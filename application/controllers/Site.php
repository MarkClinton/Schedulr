<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    public function view($page = 'index'){ 
        if(!file_exists(APPPATH.'views/site/'.$page.'.php')){
                show_404();
            }
        $this->load->view('templates/headerIndex');
        $this->load->view('site/'.$page);
        $this->load->view('templates/footer');
     
    }
    
    public function index(){
        $this->load->view('templates/headerIndex');
        $this->load->view('index');
        $this->load->view('templates/footer');
    }
    
}
