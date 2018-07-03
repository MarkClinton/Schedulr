<?php

class User_model extends CI_Model{

    protected $is_deleted = 0;
    protected $delete = 1;

    public function __construct() {
        parent::__construct();
    }
    
    public function create_user($data){
        //$md_pword = md5($data['password']);
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

        $user = $this->getUsersById($data['user']);
        $user = $user[0];
        $users_pword = $user['password'];
        $user_id = $data['user'];

        $return = [];

        if(password_verify($data['password'], $users_pword) && 
            $data['new_password'] === $data['confirm_new_password']){
            try{

                $new_user_password = $this->hashString($data['password']);

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
            //$sql = 'UPDATE user SET FIRST_NAME = ' + $user['FIRST_NAME'] + ' WHERE EMAIL = ' + $email;
            $this->db->where('email', $email);
            $this->db->update('users', $data);
            return 200;
        } catch (Exception $ex) {
            return 400;
        }
    }
    // NEEDS ATTENTION
    public function search_people($search, $user) {

        $name = "%$search%";
        $sql = "SELECT u.*, f.status FROM users u
                LEFT JOIN friends f on u.id = f.friend_id AND f.user_id = '$user'
                WHERE u.email LIKE '$name'
                AND u.id NOT IN ('$user')
        ";

        //"SELECT * FROM users WHERE email LIKE '$name'"

        $query = $this->db->query($sql);
        return $query->result_array();
        
        //$response = $this->db->select('*')->from('USER')->where("FIRST_NAME LIKE '%$search'")->get();
        //return $response->result_array();
        //$this->db->or_like('LAST_NAME', $search);
        
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

                //if ($password == $usrPword) {
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

        
        $sql = "SELECT * FROM users 
                WHERE email = '" . $email . "'";
        try {
            $query = $this->db->query($sql);
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

        //$sql = "SELECT * FROM USER WHERE email = '" . $email . "'";
        $sql = "SELECT * FROM users 
                WHERE id = '" . $id . "'";
        try {
            $query = $this->db->query($sql);
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
        
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' LIMIT 1";
        $result = $this->db->query($sql);
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

        $sql = "tasks 
                WHERE user_id = '" . $user_id . "'
                AND is_deleted = '" . $this->is_deleted ."'
                OR id IN (
                    select task_id from group_tasks 
                    where shared_with = '" . $user_id ."')";
        //$limit=5;
        $start_row=0;

        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get($sql, $start_row);
        return $query->result_array();  
    } 
    
    public function getUsersTasks($user_id) { 
        
        $sql = " tasks WHERE user_id = '" . $user_id . "'
                AND is_deleted = '" . $this->is_deleted . "'";
        $start_row=0;

        $this->db->order_by("task_date", "ASC");
        $this->db->order_by("start_time", "ASC");
        $query = $this->db->get($sql, $start_row);
        return $query->result_array(); 
    }
    
    public function getUsersGroupTasks($user_id){

        $sql = "SELECT task_id FROM group_tasks WHERE shared_with = '" . $user_id . "'";
        
        $queryShare = $this->db->query($sql);
        $temp = array();
        
        foreach ($queryShare->result() as $row) {
            $temp[] =  $row->task_id;
        }
        
        $ids = join("','",$temp);
        $sql2 = "tasks WHERE id IN ('$ids')";
        $query = $this->db->get($sql2);
        
        return $query->result_array();
    }

    public function getUsersById($ids){

        $sql = "SELECT * FROM users
                WHERE id IN ('$ids')";

        $users = $this->db->query($sql);
        return $users->result_array();
    }


    public function getFriends($user_id){

        $sql = "SELECT friend_id FROM friends WHERE user_id = '" . $user_id . "' 
                AND is_deleted = $this->is_deleted";

        $query = $this->db->query($sql);
        $friend_ids = array();

        foreach ($query->result() as $row) {
            $friend_ids[] =  $row->friend_id;
        }

        $ids = join("','", $friend_ids);
        return $ids;

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

         $sql = "SELECT img_url FROM users WHERE id = '" . $user . "'";

         $query_res = $this->db->query($sql);
         return $query_res->result_array();
    }

    public function checkResetToken($token){

        $sql = "SELECT * FROM recover
                WHERE token = '" .$token . "'
                AND used = 0
                AND expr_date >= NOW()";

        $query_res = $this->db->query($sql);
        return $query_res->result_array();

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











