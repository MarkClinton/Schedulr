<?php

class Task_model extends CI_Model {
    
    protected $delete = 1;
    protected $not_deleted = 0;

    public function __construct() {
        parent::__construct();
    }
    
    public function getTask($task_id, $user) {
        
        $task_details = $this->get_task_details($task_id);
        $shared_users = $this->get_shared_users($task_id);

        $result = array();
        $result[] = $task_details;
        $result[] = $shared_users;

        return $result;
    }

    public function checkTaskPrivilege($task_id){
        
        $response = array();

        $this->db->select('t.user_id, g.shared_with');
        $this->db->from('tasks as t');
        $this->db->join('group_tasks as g', 't.id = g.task_id', 'left');
        $this->db->where('t.id', $task_id);
        $query = $this->db->get();

        $data = $query->result_array();
        array_push($response, $data[0]['user_id']);

        foreach($data as $d){
            foreach($d as $k => $v){
                if($k == 'shared_with'){
                    array_push($response, $v);
                }
            }
        }
        return $response;

    }

    public function get_task_details($task_id){
        
        $this->db->select('t.*, u.id as ADMIN, u.first_name, u.img_url');
        $this->db->from('tasks as t');
        $this->db->join('users as u', 'u.id = t.user_id', 'inner');
        $this->db->where('t.id', $task_id);
        $query = $this->db->get();
    
        return $query->result_array();
    }

    public function get_shared_users($task_id){

        $this->db->select('u.id, u.first_name, u.last_name, u.email, u.img_url');
        $this->db->from('users as u');
        $this->db->join('group_tasks as g', 'g.shared_with = u.id', 'inner');
        $this->db->where('g.task_id', $task_id);
        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function deletetask($task_id) {
        
        try{
            $this->db->set('is_deleted', $this->delete);
            $this->db->where('id', $task_id);
            $this->db->update('tasks');
            return 200;
        } catch(Exception $e) {
            return 400;
        }
    }
    
    public function createNewTask($task){

        $data = array();
        
        try{
            $this->db->insert('tasks', $task);
            $data['task_id'] = $this->db->insert_id();
            $data['code'] = 200;
            return $data;
        } catch(Exception $e){
            return 400;
        }  
    }

    public function updateDateTime($id, $tasks){
        try{
            $this->db->where('id', $id);
            $this->db->update('tasks', $tasks);
            return 200;
        }catch (Exception $e){
            return 400;
        }
    }
    
    public function updateTask($task, $task_id){

        try{
            $this->db->where('id', $task_id);
            $this->db->update('tasks', $task);
            return 200;
        }catch (Exception $e) {
            return 400;
        }
    }

    public function addTaskShare($data_one) {
        
        try{
            $this->db->insert('group_tasks', $data_one);
            return 200;
        } catch(Exception $e){
            return 400;
        } 
    }

    public function removeTaskShare($task_id, $remove_user) {
        try{
            $this->db->where('task_id', $task_id);
            $this->db->where('shared_with', $remove_user);
            $this->db->delete('group_tasks');
            return 200;
        } catch(Exception $e) {
            return 400;
        }
    }

    public function taskMedia($task_id){
        try{

            $this->db->select('t.*, l.lat, l.lng, l.name, u.first_name, u.last_name, u.img_url');
            $this->db->from('task_media as t');
            $this->db->join('users as u', 't.user_id = u.id', 'inner');
            $this->db->join('location as l', 't.location_id = l.id', 'left');
            $this->db->where('t.task_id', $task_id);
            $this->db->where('t.is_deleted', $this->not_deleted);
            $query = $this->db->get();

            return $query->result_array();
        }catch(Exception $e){
            return 400;
        } 

    }

    public function deleteTaskMedia($media_id){

        try{
            $this->db->set('is_deleted', $this->delete);
            $this->db->where('id', $media_id);
            $this->db->update('task_media');
            return 200;
        }catch(Exception $e){
            return 400;
        } 
    }


    public function addFile($fileToUpload){

        try{
            $this->db->insert('task_media', $fileToUpload);
            return 200;
        } catch(Exception $e){
            return 400;
        } 
    }


    public function addLocation($location){

        $data = array();
        
        try{
            $this->db->insert('location', $location);
            $data['location_id'] = $this->db->insert_id();
            $data['code'] = 200;
            return $data;
        } catch(Exception $e){
            return 400;
        }  
    }


    public function fileUploadPath(){

    }

}
