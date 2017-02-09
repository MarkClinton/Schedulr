<?php

class Task_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getTask($task_id, $user) {
        
        $sql = "tasks WHERE task_id = '" . $task_id . "' AND admin = '" . $user . "'";
        
        $query = $this->db->get($sql);
        return $query->result_array();   
    }
    
    public function deletetask($task_id) {
        
        //$sql = "DELETE FROM tasks WHERE task_id = " + $task_id;
        
        $this->db->where('TASK_ID', $task_id);
        $query = $this->db->delete('tasks'); 
        
        if(!$query){
            return 400;
        } else {
            return 200;
        }  
    }
    
    public function createNewTask($task){
        
        $query = $this->db->insert('tasks', $task); 
        
        if(!$query){
            return 400;
        } else {
            return 200;
        }  
        
    }
    
    public function updateTask($task, $task_id){
        
        $this->db->where('TASK_ID', $task_id);
        $query = $this->db->update('TASKS', $task);
        
        if(!$query){
            return 400;
        } else {
            return 200;
        }  
    }
}
