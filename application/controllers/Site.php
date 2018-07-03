<?php

class Site extends CI_Controller {
    
    public function view($page = 'index'){ 
        if(!file_exists(APPPATH.'views/site/'.$page.'.php')){
                show_404();
            }

        if ($this->session->userdata('id')){
            redirect('users/index', 'refresh');
        }else{
            $this->load->view('templates/headerIndex');
            $this->load->view('site/'.$page);
            $this->load->view('templates/footer');
        }
        
     
    }
    
    public function index(){

        if ($this->session->userdata('id')){
            redirect('users/index', 'refresh');
        }else{
            $this->load->view('templates/headerIndex');
            $this->load->view('index');
            $this->load->view('templates/footer');
        }
    }
    
}
