<?php

class MY_Exceptions extends CI_Exceptions {

    public function __construct()
    {
        parent::__construct();
    }

    function show_404($page = '', $log_error = TRUE)
    {
        $CI =& get_instance();
        if ($CI->session->userdata('id')) {
            $CI->load->view('templates/header');
            $CI->load->view('errors/html/customError404');
            $CI->load->view('templates/footer');
            echo $CI->output->get_output();
            exit;
        } else {
            $CI->load->view('templates/headerIndex');
            $CI->load->view('errors/html/customErrorIndex404');
            $CI->load->view('templates/footer');
            echo $CI->output->get_output();
            exit;
        }
    }
}