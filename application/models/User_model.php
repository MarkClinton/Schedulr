<?php

class User_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function create_user($data){
        
        $md_pword = md5($data['inputPassword']);
        $input = array(
            'first_name' => $data['inputFname'],
            'last_name'  => $data['inputLname'],
            'email'      => $data['inputEmail'],
            'password'   => $md_pword
        );
        
        $query = $this->db->insert('user', $input);
        return $query;
        
    }
    
    public function login($data){
        
        $email =  $data['inputEmail'];
        $password = $data['inputPassword'];

        $user = $this->getUser($email);
        
        $usrEmail = $user[0]['EMAIL'];
        $usrPword = $user[0]['PASSWORD'];
        
        //md5 for emails
        
        if(($email == $usrEmail) && ($password == $usrPword)){
            $this->setSession($email);
            
            return true;
            
        }   
        else {
            return false;
        }
    }
    
    public function getUser($email){
        
        $sql = "SELECT * FROM user WHERE email = '" . $email ."'";
        $query = $this->db->query($sql);
        
        if(!$query){
            return false;
        } else {
            return $query->result_array();
        }
    }
    
    public function setSession($email){
        
        $sql = "SELECT * FROM user WHERE email = '" . $email . "' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        
        $sess_data = array(
            'first_name' => $row->FIRST_NAME,
            'last_name' => $row->LAST_NAME,
            'email' => $email,
            'loggedin' => 0  
        );
        
        $this->session->set_userdata($sess_data);
        
    }
    
    public function deleteSession(){
        $this->session->sess_destroy();
    }
    
    public function getUpcomingTasks($email) {
        
        $sql = " tasks WHERE admin = '" . $email . "'";
        $limit=5;
        $start_row=0;

        $this->db->order_by("end_date", "ASC");
        $query = $this->db->get($sql, $limit, $start_row);
        return $query->result_array();  
    } 
    
    public function getUsersTasks($email) { 
        
        $sql = "SELECT tasks.* FROM tasks LEFT JOIN share "
                . "ON tasks.task_id = share.task_id WHERE "
                . "share.task_id IS NULL AND tasks.admin = '" . $email ."'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getUsersGroupTasks($email){
        $sql = "SELECT task_id FROM share WHERE email = '" . $email . "'";
        
        $queryShare = $this->db->query($sql);
        $temp = array();
        
        foreach ($queryShare->result() as $row) {
            $temp[] =  $row->task_id;
        }
        
        $ids = join("','",$temp);
        $sql2 = "tasks WHERE task_id IN ('$ids')";
        $query = $this->db->get($sql2);
        
        return $query->result_array();
    }
}
