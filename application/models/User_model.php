<?php

class User_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function create_user($data){
        //$md_pword = md5($data['password']);
        
        $input = array(
            'first_name' => $data['firstName'],
            'last_name'  => $data['lastName'],
            'email'      => $data['email'],
            'password'   => $data['password']
        );
        
        try{
            $this->db->insert('user', $input);
            return 200;
        }catch (Exception $e){
            return 400;
        } 
    }
    
    public function update_user($data){
        try{
            //$sql = 'UPDATE user SET FIRST_NAME = ' + $user['FIRST_NAME'] + ' WHERE EMAIL = ' + $email;
            $this->db->where('EMAIL', 'mark@gmail.com');
            $this->db->update('USER', $data);
            return 200;
        } catch (Exception $ex) {
            return 400;
        }
    }
    
    public function search_people($search) {
        $name = "%$search%";
        $query = $this->db->query("SELECT FIRST_NAME, LAST_NAME, EMAIL FROM USER WHERE FIRST_NAME LIKE '$name'");
        return $query->result_array();
        
        //$response = $this->db->select('*')->from('USER')->where("FIRST_NAME LIKE '%$search'")->get();
        //return $response->result_array();
        //$this->db->or_like('LAST_NAME', $search);
        
    }
    public function login($data) {

        $email = $data['email'];
        $password = $data['password'];
        $code = 0;
        try {
            $user = $this->getUser($email);

            if (!$user) {
                $code = 400;
            } else {

                $usrPword = $user[0]['PASSWORD'];

                if ($password == $usrPword) {
                    $this->setSession($email);
                    $code = 200;
                } else {
                    $code = 401;
                }
            }
        } catch (Exception $e) {
            $code = 400;
        }
        return $code;
    }

    public function getUser($email) {

        $sql = "SELECT * FROM user WHERE email = '" . $email . "'";
        try {
            $query = $this->db->query($sql);
            $result = $query->num_rows();
            
            if ($result === 1) {
                return $query->result_array();
            } else {
                print($email);
                return false;
            }
        } catch (Exception $e) {
            print("Exception");
            return false;
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
        //$limit=5;
        $start_row=0;

        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get($sql, $start_row);
        return $query->result_array();  
    } 
    
    public function getUsersTasks($email) { 
        
        /*$sql = "SELECT tasks.* FROM tasks LEFT JOIN share "
                . "ON tasks.task_id = share.task_id WHERE "
                . "share.task_id IS NULL AND tasks.admin = '" . $email ."'";*/
        $sql = "SELECT * FROM tasks where admin = '" . $email . "'";

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
