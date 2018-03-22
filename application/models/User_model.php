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
            $this->db->insert('USER', $input);
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
        $query = $this->db->query("SELECT * FROM USER u
                                   INNER JOIN USER_IMAGE ui on u.id = ui.user_id
                                   WHERE u.FIRST_NAME LIKE '$name'");
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

        //$sql = "SELECT * FROM USER WHERE email = '" . $email . "'";
        $sql = "SELECT * FROM USER u 
                INNER JOIN USER_IMAGE ui ON ui.USER_ID = u.ID
                WHERE EMAIL = '" . $email . "'";
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
        
        $sql = "SELECT * FROM USER WHERE email = '" . $email . "' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        
        $sess_data = array(
            'id' => $row->ID,
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
    
    public function getUpcomingTasks($user_id) {
        
        $sql = " TASKS WHERE user_id = '" . $user_id . "'";
        $limit=5;
        $start_row=0;

        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get($sql, $start_row, $limit);
        return $query->result_array();  
    } 
    
    public function getUsersTasks($user_id) { 
        
        $sql = " TASKS WHERE user_id = '" . $user_id . "'";
        $start_row=0;

        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get($sql, $start_row);
        return $query->result_array(); 
    }
    
    public function getUsersGroupTasks($user_id){
        $sql = "SELECT task_id FROM SHARE WHERE user_id = '" . $user_id . "'";
        
        $queryShare = $this->db->query($sql);
        $temp = array();
        
        foreach ($queryShare->result() as $row) {
            $temp[] =  $row->task_id;
        }
        
        $ids = join("','",$temp);
        $sql2 = "TASKS WHERE task_id IN ('$ids')";
        $query = $this->db->get($sql2);
        
        return $query->result_array();
    }

    public function getUsersById($ids){

        $sql = "SELECT * FROM USER u
                INNER JOIN USER_IMAGE ui on u.id = ui.user_id
                WHERE u.id IN ('$ids')";

        $users = $this->db->query($sql);
        return $users->result_array();
    }


    public function getFriends($user_id){

        $sql = "SELECT friend_id FROM FRIENDS WHERE user_id = '" . $user_id . "'";

        $query = $this->db->query($sql);
        $friend_ids = array();

        foreach ($query->result() as $row) {
            $friend_ids[] =  $row->friend_id;
        }

        $ids = join("','", $friend_ids);
        return $ids;

    }

    public function imageUploadPath($user_id, $image){

        $check = "SELECT * FROM USER_IMAGE WHERE user_id = '" . $user_id ."'";
        
        if($check->num_rows === 0){
            $input = array(
                'USER_ID' => $user_id,
                'URL' => $image,
                'UPLOADED_AT' => 'NOW();'
            );
            try{
                $this->db->insert('USER_IMAGE', $input);
                return 200;
            }catch (Exception $e){
                return 400;
            } 

        } else {
            try{
                $this->db->set('URL', $image);  
                $this->db->where('USER_ID', $user_id); 
                $this->db->update('USER_IMAGE');
                return 200;
            }catch (Exception $e){
                return 400;
            }   
        }
    }

    public function getImagePath($user){

         $sql = "SELECT * FROM user_image WHERE id = '" . $user . "'";

         $query_res = $this->db->query($sql);
         return $query_res->result_array();
    }
}











