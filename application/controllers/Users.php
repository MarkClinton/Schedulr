<?php

class Users extends CI_Controller {

    protected $is_used = 0;

    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('email_client');

    }
    
    public function view($page = 'index'){ 
        if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
                show_404();
            }

        if ($this->session->userdata('id')){
            $this->load->view('templates/header');
            $this->load->view('users/'.$page);
            $this->load->view('templates/footer');
        }else{
            redirect('index', 'refresh');
        }
     
    }

    public function index(){

        if ($this->session->userdata('id')){
            $this->load->view('templates/header');
            $this->load->view('users/index');
            $this->load->view('templates/footer'); 

            $data['pp'] = $this->session->userdata('picture');
        }else{
            redirect('index', 'refresh');
        }
    }
    
    public function getProfile(){

        $id = $this->session->userdata('id');
        $response['profile'] = $this->User_model->getUser($id);
        $response['profile_details'] = $this->User_model->getUserDetails($id);
        print json_encode($response);
    }

    public function getFriends(){

        $user_id = $this->session->userdata('id');
        $response = $this->User_model->getFriends($user_id);

        $users_friends = $this->User_model->getUsersById($response);
        print json_encode($users_friends);
    }

    public function addFriends() {

        $user_id = $this->session->userdata('id');
        $friend_id = filter_input(INPUT_GET, 'userId');

        $response = $this->User_model->addFriends($user_id, $friend_id);
        $this->addFriendToTimeline($user_id, $friend_id);
        print json_encode($response);

    }
    
    public function updateProfile(){

        $profile = json_decode(file_get_contents('php://input'), true);

        $user = array(
            'first_name' => $profile['first_name'],
            'last_name'  => $profile['last_name'],
            'email'      => $profile['email'],
            'password'   => $profile['password']
        );

        $response = $this->User_model->update_user($user);
        print json_encode($response);
    }

    public function updatePassword(){

        $update = json_decode(file_get_contents('php://input'), true);
        $user = $user_id = $this->session->userdata('id');

        $toUpdate = array(
            'user' => $user,
            'password' => $update['password_old'],
            'new_password' => $update['password_new'],
            'confirm_new_password' => $update['password_new_confirm']
        );

        $response = $this->User_model->updatePassword($toUpdate);
        print json_encode($response);
    }

    public function getTimeline(){
        $user_id = $this->session->userdata('id');

        $response = $this->User_model->getUserTimeline($user_id);
        print json_encode($response);
    }

    public function addFriendToTimeline($user_id, $friend_id){
        
        $timeline_type = 3;
        $timestamp = date('Y-m-d G:i:s');

        $data = array(
            'user_id' => $user_id,
            'created_at' => $timestamp,
            'type' => $timeline_type,
            'type_data_id' => $friend_id
        );

        $response = $this->User_model->addToUserTimeline($data);
        print json_encode($response);
    }

    public function searchPeople(){

        $user_id = $this->session->userdata('id');
        $input = json_decode(file_get_contents('php://input'), true);
        $search = $input['searchText'];
        $response = $this->User_model->search_people($search, $user_id);
        print json_encode($response);
        
    }

    public function deleteFriend(){

        $friend_id = filter_input(INPUT_GET, 'userId');
        $user_id = $this->session->userdata('id');

        $response = $this->User_model->removeFriend($friend_id, $user_id);
        return json_encode($response);
    }
    
    public function register() {
        
        $data = json_decode(file_get_contents('php://input'), true);

        $response = $this->User_model->create_user($data);
        if($response['code'] == 200){
            $mail = $this->email_client->welcome_mail($data);
        }
        print json_encode($response);
    }
    

    public function login() { 

        $user = json_decode(file_get_contents('php://input'), true);
        $response = $this->User_model->login($user);
        print json_encode($response);
    }
    
    public function logout(){
        $this->User_model->deleteSession();
        redirect('index');  
    }
    
    public function displayUpcomingTasks(){
        $email = $this->session->userdata('id');
        $data['tasks'] = $this->User_model->getUpcomingTasks($email);
        $data['user_id'] = $this->session->userdata('id');
        
        print json_encode($data);
    }
    
    public function displayGroupTasks() {
        $email = $this->session->userdata('id');
        $data['tasks'] = $this->User_model->getUsersGroupTasks($email);
        $data['user_id'] = $this->session->userdata('id');

        print json_encode($data);
        
    }
    
    public function displayTasks() {
        $email = $this->session->userdata('id');
        $data['tasks'] = $this->User_model->getUsersTasks($email);
        $data['user_id'] = $this->session->userdata('id');

        print json_encode($data);
    }

    public function imageUpload(){

        $target_dir = "/opt/lampp/htdocs/Schedulr/assets/images/profile/";
        $name = $_POST['name'];
       
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        $image_path = '/assets/images/profile/' . $name;
        $user_id = $this->session->userdata('id');
        $data = $this->User_model->imageUploadPath($user_id, $image_path);
        print json_encode($data); 
    }

    public function profileImage(){
        $user_id = $this->session->userdata('id');
        $file_path = $this->User_model->getImagePath($user_id);
        print json_encode($file_path);
    }

    public function recoverPassword(){

        $return = [];

        $data = file_get_contents('php://input');
        $user = $this->User_model->getUserByEmail($data);
        $user = $user[0];
        $expr = date("Y-m-d H:i:s", strtotime('+8 hours'));


        if (!is_null($user)){

            // Random hash of email
            // Could be better???
            $token = md5(uniqid($user['email'], true));
            $id = $user['id'];
            $user_first_name = $user['first_name'];

            $data = array(
                'token' => $token,
                'expr_date' => $expr,
                'id' => $id,
                'used' => $this->is_used
            );

            $recover = $this->User_model->addToRecover($data);

            while($recover !== 200){
                $tokenRetry = md5(uniqid($user['email'], true));
                $data = array(
                    'token' => $tokenRetry,
                    'expr_date' => $expr,
                    'id' => $id,
                    'used' => $this->is_used
                );
                $recover = $this->User_model->addToRecover($data);
            }

            if($recover == 200){
                $mail = $this->email_client->password_reset($token, $user);
                $return = $mail;
            }

        }else{
            $return['code'] = 200;
            $return['response'] = "Email sent";
        }
        // Always display that an email has been sent even if user doesnt exist. Added security.
        print json_encode($return); 
    }

    public function validateRecoverPassword(){

        $return = [];

        $tokenToVal = filter_input(INPUT_GET, 'tok');
        $newData = json_decode(file_get_contents('php://input'), true);

        
        $checkToken = $this->User_model->checkResetToken($tokenToVal);

        if(!empty($checkToken)){
            $user_id = $checkToken[0]['id'];
            $validation = $this->User_model->validateToken($checkToken);
            if($validation == 200){
                $reset_password = $this->User_model->resetPassword($user_id, $newData);
                $return = $reset_password;
            }

        }else{
            $return['code'] = 400;
            $return['response'] = "This reset request has expired or has already been used";
        }
        

        print json_encode($return);
    }

}

