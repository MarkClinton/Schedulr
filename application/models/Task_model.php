<?php

class Task_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getTask($task_id, $user) {
        
        $sql = "TASKS WHERE task_id = '" . $task_id . "' AND admin = '" . $user . "'";
        
        $query = $this->db->get($sql);
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
}
