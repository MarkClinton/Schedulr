<?php

class User_model extends CI_Model{

    protected $is_deleted = 0;
    protected $delete = 1;

    public function __construct() {
        parent::__construct();
    }
    
    public function create_user($data){
        $return = [];
        $options = ['cost' => 12];
        $password = $this->hashString($data['password']);
        $userCheck = $this->getUserByEmail($data['email']);
        
        if($userCheck){
            $return['code'] = 400;
            $return['response'] = "Email already exists";

        }else{
        
            $input = array(
                'first_name' => $data['firstName'],
                'last_name'  => $data['lastName'],
                'email'      => $data['email'],
                'password'   => $password,
                'is_locked'  => 0,
                'is_verified'=> 1,
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
                'last_accessed' => 'NOW()',
                'img_url' => '/assets/images/profile/user.png'
            );
            
            try{
                $this->db->insert('users', $input);
                $this->setSession($data['email']);

                $return['code'] = 200;
                $return['response'] = "User created";
                
            }catch (Exception $e){
                $return['code'] = 400;
                $return['response'] = "Something went wrong! Please try again.";
            } 
        } return $return;
    }

    public function hashString($stringToHash){
        $options = ['cost' => 12];
        $hashed = password_hash($stringToHash, PASSWORD_DEFAULT, $options);
        return $hashed;
    }

    public function updatePassword($data){

        $user = $this->getUserByEmail($data['user']);
        $user = $user[0];
        $users_pword = $user['password'];
        $user_id = $user['id'];



        $return = [];

        if(password_verify($data['password'], $users_pword) && 
            $data['new_password'] === $data['confirm_new_password']){
            try{

                $new_user_password = $this->hashString($data['new_password']);

                $this->db->set('password', $new_user_password);
                $this->db->where('id', $user_id);
                $this->db->update('users');

                $return['code'] = 200;
                $return['response'] = "Password Updated";

            }catch (Exception $e) {
                $return['code'] = 400;
                $return['response'] = "Something went wrong. Please try again.";
            } 
        } else {
            $return['code'] = 401;
            $return['response'] = "Wrong Password / Cannot Confirm New Password";
        } 
        return $return;

    }

    public function resetPassword($user_id, $password){
        
        $return = [];

        try{
            $new_user_password = $this->hashString($password);

            $this->db->set('password', $new_user_password);
            $this->db->where('id', $user_id);
            $this->db->update('users');

            $return['code'] = 200;
            $return['response'] = "Password Reset";

        }catch (Exception $e) {
            $return['code'] = 400;
            $return['response'] = "Something went wrong. Please try again.";
        } 

        return $return;

    }

    public function addToRecover($data){
        try{
            $this->db->insert('recover', $data);
            return 200;

        }catch (Exception $ex) {
            return 400;
        }

    }
    
    public function update_user($data){

        $email = $data['email'];
        try{
            $this->db->where('email', $email);
            $this->db->update('users', $data);
            return 200;
        } catch (Exception $ex) {
            return 400;
        }
    }

    public function search_people($search, $user) {

        $this->db->select('u.id, u.first_name, u.last_name, u.email, u.img_url, f.status');
        $this->db->from('users as u');
        $this->db->join('friends as f', 'u.id = f.friend_id and f.user_id = '.$user, 'left');
        $this->db->where('u.email', $search);
        //$this->db->where('f.user_id', $user);
        $this->db->where_not_in('u.id', $user);
        $query = $this->db->get();

        return $query->result_array();
        
    }
    public function login($data) {

        $return = [];

        $email = $data['email'];
        $password = $data['password'];


        $code = 0;
        try {
            $user = $this->getUserByEmail($email);
            if (!$user) {
                $return['code'] = 400;
                $return['response'] = "Wrong email or password";
            } else {

                $usrPword = $user[0]['password'];

                if(password_verify($password, $usrPword)){
                    
                    $this->setSession($email);
                    $return['code'] = 200;
                    $return['response'] = "Login successful";
                } else {
                    $return['code'] = 401;
                    $return['response'] = "Wrong email or password";
                }
            }
        } catch (Exception $e) {
            $return['code'] = 400;
            $return['response'] = "Something went wrong. Please try again.";
        }
        return $return;
    }

    public function getUserByEmail($email) {

        //Need to return password for login. Does not show to end user
        $this->db->select('id, first_name, last_name, email, img_url, password');
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();


        try {
            $result = $query->num_rows();
            
            if ($result === 1) {
                return $query->result_array();
            } else {
                return false;
            }
        } catch (Exception $e) {
            print("Exception");
            return false;
        }
    }

    public function getUser($id) {

        $this->db->select('id, first_name, last_name, email, img_url');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();


        try {
            $result = $query->num_rows();
            
            if ($result === 1) {
                return $query->result_array();
            } else {
                return false;
            }
        } catch (Exception $e) {
            print("Exception");
            return false;
        }
    }

    public function getUserDetails($id){
        $sql = "SELECT  (
        SELECT COUNT(*)
        FROM   friends
        WHERE user_id = '" . $id . "'
        AND status = 1
        ) AS friends,
        (
        SELECT COUNT(*)
        FROM   tasks
        WHERE user_id = '" . $id . "'
        AND is_deleted = '" . $this->is_deleted . "'
        ) AS tasks,
        (
        SELECT COUNT(*)
        FROM group_tasks
        WHERE shared_with = '" . $id . "'
        ) AS groups";

        $query = $this->db->query($sql);
        return $query->result_array();  
    }

    public function addToUserTimeline($data){
        try{
            $this->db->insert('timeline', $data);
            return 200;
        } catch(Exception $e){
            return 400;
        }  
    }

    public function getUserTimeline($user){

        $sql = "
        select 
        DATE(t.created_at) as 'created_at',
        TIME(t.created_at) as 'time',
        tt.name,
        CASE
            WHEN t.type = 1 THEN ta.name
            WHEN t.type = 2 THEN ta.name
            WHEN t.type = 3 THEN u.first_name
        END AS 'timeline'
            from   timeline t
            inner JOIN timeline_type tt on t.type = tt.id
            left outer join   tasks ta
            on     t.type_data_id = ta.id
            and    t.type in (1,2)
            left outer join   users u
            on     t.type_data_id = u.id
            and    t.type = 3
            where  t.user_id = '" . $user . "'
            order by created_at DESC";
        
        $data = $this->db->query($sql);
        return $data->result_array();
    }

    public function setSession($email){
        
        $limit = 1;
        $this->db->select();
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->limit($limit);
        $result = $this->db->get();

        $row = $result->row();
        
        $sess_data = array(
            'id' => $row->id,
            'first_name' => $row->first_name,
            'last_name' => $row->last_name,
            'email' => $email,
            'loggedin' => 0,
            'picture' => $row->img_url  
        );
        
        $this->session->set_userdata($sess_data);
    }
    
    public function deleteSession(){

        $this->session->sess_destroy();
    }
    
    public function getUpcomingTasks($user_id) {

        $this->db->select('task_id');
        $this->db->from('group_tasks');
        $this->db->where('shared_with', $user_id);
        $group_tasks_raw = $this->db->get();

        $group_tasks = array();
        foreach ($group_tasks_raw->result() as $row) {
            $group_tasks[] =  $row->task_id;
        }

        $this->db->select();
        $this->db->from('tasks');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_deleted', $this->is_deleted);
        if($group_tasks){
            $this->db->or_where_in('id', $group_tasks);
        }
        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get();

        return $query->result_array();  
    } 
    
    public function getUsersTasks($user_id) { 
        
        $this->db->select();
        $this->db->from('tasks');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_deleted', $this->is_deleted);
        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get();
        return $query->result_array(); 
    }
    
    public function getUsersGroupTasks($user_id){

        $this->db->select('task_id');
        $this->db->from('group_tasks');
        $this->db->where('shared_with', $user_id);
        $queryShare = $this->db->get();

        $temp = array();
        foreach ($queryShare->result() as $row) {
            $temp[] =  $row->task_id;
        }
        if($temp){
            $this->db->select();
            $this->db->from('tasks');
            $this->db->where_in('id', $temp);
            $query = $this->db->get();
            $query = $query->result_array();
        }else{
            $query = [];
        }
        
        return $query;
    }

    public function getUsersById($ids){
        if($ids){
            $this->db->select('id, first_name, last_name, email, img_url');
            $this->db->from('users');
            $this->db->where_in('id', $ids);
            $query = $this->db->get();
            $query = $query->result_array();
        }else{
            $query =[];
        }
        return $query;
    }


    public function getFriends($user_id){

        $this->db->select('friend_id');
        $this->db->from('friends');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_deleted', $this->is_deleted);
        $query = $this->db->get();

        $friend_ids = array();

        foreach ($query->result() as $row) {
            $friend_ids[] =  $row->friend_id;
        }

        return $friend_ids;
    }

    public function removeFriend($friend_id, $user_id) {
        $status = 4;
        try{
            $cond  = ['user_id' => $user_id, 'friend_id' => $friend_id];

            $this->db->where($cond);
            $this->db->set('is_deleted', $this->delete);
            $this->db->set('status', $status);
            $this->db->update('friends');

            $cond2  = ['user_id' => $friend_id, 'friend_id' => $user_id];
            $this->db->where($cond2);
            $this->db->set('is_deleted', $this->delete);
            $this->db->set('status', $status);
            $this->db->update('friends');

            return 200;

        }catch (Exception $e) {
            return 400;
        }
    }

    public function addFriends($user_id, $friend_id){

        $status = 1;
        /*
        * Check whether theres a record of friends first that may have been deleted
        * If so just update the is_deleted field to 0
        * If not, Add new record of friends
        */

        try{
            $cond  = ['user_id' => $user_id, 'friend_id' => $friend_id];
            $this->db->where($cond);
            $r = $this->db->get('friends');

            $cond2  = ['user_id' => $friend_id, 'friend_id' => $user_id];
            $this->db->where($cond2);
            $q = $this->db->get('friends');

            if($r->num_rows() > 0 && $q->num_rows() > 0){
                $this->db->where($cond);
                $this->db->set('is_deleted', $this->is_deleted);
                $this->db->set('status', $status);
                $this->db->update('friends');

                $this->db->where($cond2);
                $this->db->set('is_deleted', $this->is_deleted);
                $this->db->set('status', $status);
                $this->db->update('friends');
            }else{

                $this->db->set($cond);
                $this->db->set('status', $status);
                $this->db->set('created_at', 'now()');
                $this->db->set('is_deleted', $this->is_deleted);
                $this->db->insert('friends');

                $this->db->set($cond2);
                $this->db->set('status', $status);
                $this->db->set('created_at', 'now()');
                $this->db->set('is_deleted', $this->is_deleted);
                $this->db->insert('friends');
            }
            return 200;

        }catch (Exception $e) {
            return 400;
        }
    }

    public function imageUploadPath($user_id, $image){

        $this->session->set_userdata('picture', $image);

        try{
            $this->db->where('id', $user_id);
            $this->db->set('img_url', $image);
            $this->db->update('users');

        }catch (Exception $e){
            return 400;
        }
    }

    public function getImagePath($user){

        $this->db->select('img_url');
        $this->db->from('users');
        $this->db->where('id', $user);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function checkResetToken($token){

        $this->db->select('token, expr_date, id, used');
        $this->db->from('recover');
        $this->db->where('token', $token);
        $this->db->where('used', 0);
        $this->db->where('expr_date > NOW()');
        $query = $this->db->get();

        return $query->result_array();

    }

    public function validateToken($tokenDetails){

        $user_id = $tokenDetails[0]['id'];
        $token = $tokenDetails[0]['token'];

        try{
            $cond  = ['id' => $user_id, 'token' => $token];
            $this->db->where($cond);
            $this->db->set('used', $this->delete);
            $this->db->update('recover');
            return 200;
        }catch (Exception $e){
            return 400;
        }

    }
}











