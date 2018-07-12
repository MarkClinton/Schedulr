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

        $sql = "SELECT t.user_id, gt.shared_with FROM tasks t 
                LEFT JOIN group_tasks gt ON t.id = gt.task_id
                WHERE t.id = '" . $task_id . "'";

        $query = $this->db->query($sql);

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

        $sql = "SELECT t.*, u.id as ADMIN, u.first_name, u.img_url
                FROM tasks t
                INNER JOIN users u on u.id = t.user_id
                WHERE t.id = '" . $task_id . "'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_shared_users($task_id){

        $sql = "SELECT u.*
                FROM users u 
                INNER JOIN group_tasks g on g.shared_with = u.id
                WHERE g.task_id = '" . $task_id . "'";

        $query = $this->db->query($sql);
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
    
    public function updateTask($task, $task_id){

        try{
            $this->db->where('TASK_ID', $task_id);
            $this->db->update('TASKS', $task);
            return 200;
        }catch (Exception $e) {
            return 400;
        }
    }

    public function updateTaskShare($data_one) {
        
        try{
            $this->db->insert('group_tasks', $data_one);
            return 200;
        } catch(Exception $e){
            return 400;
        } 
    }

    public function taskMedia($task_id){
        try{
            $sql = "
                SELECT t.*, l.lat, l.lng, l.name, u.first_name, u.last_name, u.img_url from task_media t
                INNER JOIN users u on t.user_id = u.id
                LEFT JOIN location l on t.location_id = l.id
                WHERE task_id = '$task_id'
                AND is_deleted = '" .$this->not_deleted . "'

            ";

            $query = $this->db->query($sql); 
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
