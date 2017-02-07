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
        
        if($query){
            return "Task Deleted Successfully";
        } else {
            return "Task Could Not Be Deleted";
        }  
    }
    
    public function createNewTask($task){
        
        $query = $this->db->insert('tasks', $task); 
        
        if(!$query){
            return "Task Could Not Be Created";
        } else {
            return "Task Created Successfully";
        }  
        
    }
}
