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
    
    public function register() {
        $data = $this->input->post();
        
            if($this->User_model->create_user($data)){
                $this->session->set_flashdata('registered', 'Thanks for registering. Please sign in');
                redirect('login');
            }
        
    }
    
    public function index(){
        $this->load->view('templates/header');
        $this->load->view('users/index');
        $this->load->view('templates/footer');  
    }
    

    public function login() {
        $data = $this->input->post();
        
        if($this->User_model->login($data)){
            redirect('users/index');
        } else {
            redirect('login');   
        }
        
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

