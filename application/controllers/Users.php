<?php

class Users extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        
    }
    
    public function view($page = 'index'){ 
        if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
                show_404();
            }
            
        $this->load->view('templates/header');
        $this->load->view('users/'.$page);
        $this->load->view('templates/footer');
     
    }
    
    public function getProfile(){
        $email = $this->session->userdata('email');
        $response = $this->User_model->getUser($email);
        print json_encode($response);
    }
    
    public function updateProfile(){
        $profile = json_decode(file_get_contents('php://input'), true);
        //print_r($profile);
        $user = array(
            'FIRST_NAME' => $profile['first_name'],
            'LAST_NAME'  => $profile['last_name'],
            'EMAIL' => $profile['email'],
            'PASSWORD'   => $profile['password']
        );
        $response = $this->User_model->update_user($user);
        print json_encode($response);
    }
    
    public function searchPeople(){
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $this->User_model->search_people($input);
        print json_encode($response);
    }
    
    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $response = $this->User_model->create_user($data);
        print json_encode($response);
    }
    
    public function index(){
        $this->load->view('templates/header');
        $this->load->view('users/index');
        $this->load->view('templates/footer');  
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
        $email = $this->session->userdata('email');
        $data = $this->User_model->getUpcomingTasks($email);
        print json_encode($data);
    }
    
    public function displayGroupTasks() {
        $email = $this->session->userdata('email');
        $data = $this->User_model->getUsersGroupTasks($email);
        print json_encode($data);
        
    }
    
    public function displayTasks() {
        $email = $this->session->userdata('email');
        $tasks = $this->User_model->getUsersTasks($email);
        print json_encode($tasks);
    }
}

