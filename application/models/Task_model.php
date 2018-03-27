<?php

class Task_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getTask($task_id, $user) {
        
        $task_details = $this->get_task_details($task_id);
        $shared_users = $this->get_shared_users($task_id);

        $result = array();
        $result[] = $task_details;
        $result[] = $shared_users;

        //return $query->result_array();   
        return $result;
    }

    public function get_task_details($task_id){

        $sql = "SELECT t.*, u.id as ADMIN, u.first_name, ui.url
                FROM TASKS t
                INNER JOIN USER u on u.id = t.user_id
                INNER JOIN USER_IMAGE ui on ui.user_id = u.id
                WHERE t.task_id = '" . $task_id . "'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_shared_users($task_id){

        $sql = "SELECT u.*, ui.url  
                FROM USER u 
                INNER JOIN SHARE s on s.user_id = u.id
                INNER JOIN USER_IMAGE ui on ui.user_id = u.id
                WHERE s.task_id = '" . $task_id . "'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function deletetask($task_id) {
        
        try{
            $this->db->where('TASK_ID', $task_id);
            $query = $this->db->delete('TASKS');
            return 200;
        } catch(Exception $e) {
            return 400;
        }
    }
    
    public function createNewTask($task){
        
        try{
            $this->db->insert('TASKS', $task); 
            return 200;
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
            $this->db->insert('SHARE', $data_one);
            return 200;
        } catch(Exception $e){
            return 400;
        } 
    }
}
