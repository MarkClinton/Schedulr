<?php

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Task_model');
    }

    public function view($page = 'task') {
        if (!file_exists(APPPATH . 'views/tasks/' . $page . '.php')) {
            show_404();
        }
        $this->load->view('templates/header');
        $this->load->view('tasks/create');
        $this->load->view('templates/footer');
    }

    public function task() {
        $task_id = filter_input(INPUT_GET, 'id');
        $data = $this->viewTask($task_id);
        //$task = array(
          //  'task_name' => $data[0]['TASK_NAME'],
          //  'task_info' => $data[0]['TASK_INFO'],
          //  'start_time' => $data[0]['START_TIME'],
          //  'end_time' => $data[0]['END_TIME'],
          //  'task_date' => $data[0]['TASK_DATE']
        //);
        $this->load->view('templates/header');
        $this->load->view('tasks/task');
        $this->load->view('templates/footer');
    }

    public function create() {
        $this->load->view('templates/header');
        $this->load->view('tasks/create');
        $this->load->view('templates/footer');
    }

    public function viewTask() {
        
        $task_id = filter_input(INPUT_GET, 'id');
        $email = $this->session->userdata('email');

        $tasks = $this->Task_model->getTask($task_id, $email);
       
        print json_encode($tasks);
    }

    public function updateTask() {
        $update = json_decode(file_get_contents('php://input'), true);
 
        $task = array(
            'TASK_NAME' => $update['inputTaskName'],
            'START_TIME' => $update['inputTaskStart'],
            'END_TIME' => $update['inputTaskEnd'],
            'TASK_DATE' => $update['inputTaskDate'],
            'TASK_INFO' => $update['inputTaskInfo'],
            'USER_ID' => $this->session->userdata('id')
        );
        $task_id = $update['id'];

        $response = $this->Task_model->updateTask($task, $task_id);
        print json_encode($response);
    }

    public function deleteTask() {
        $task_id = filter_input(INPUT_GET, 'id');

        $response = $this->Task_model->deleteTask($task_id);
        print json_encode($response);
    }

    public function createTask() {
        $new = json_decode(file_get_contents('php://input'), true);
        
        $task = array(
            'TASK_NAME' => $new['inputTaskName'],
            'START_TIME' => $new['inputTaskStart'],
            'END_TIME' => $new['inputTaskEnd'],
            'TASK_DATE' => $new['inputTaskDate'],
            'TASK_INFO' => $new['inputTaskInfo'],
            'USER_ID' => $this->session->userdata('id')
        );


        $response = $this->Task_model->createNewTask($task);
        print json_encode($response);
    }

}
