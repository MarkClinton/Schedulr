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
        $_POST = json_decode(file_get_contents('php://input'), true);
 
        $task = array(
            'TASK_NAME' => $_POST['inputTaskName'],
            'START_TIME' => $_POST['inputTaskStart'],
            'END_TIME' => $_POST['inputTaskEnd'],
            'TASK_DATE' => $_POST['inputTaskDate'],
            'TASK_INFO' => $_POST['inputTaskInfo'],
            'ADMIN' => $this->session->userdata('email')
        );
        $task_id = $_POST['id'];

        $response['status'] = $this->Task_model->updateTask($task, $task_id);
        print json_encode($response);
    }

    public function deleteTask() {
        $task_id = filter_input(INPUT_GET, 'id');

        $response['status'] = $this->Task_model->deleteTask($task_id);
        print json_encode($response);
    }

    public function createTask() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $task = array(
            'TASK_NAME' => $_POST['inputTaskName'],
            'START_TIME' => $_POST['inputTaskStart'],
            'END_TIME' => $_POST['inputTaskEnd'],
            'TASK_DATE' => $_POST['inputTaskDate'],
            'TASK_INFO' => $_POST['inputTaskInfo'],
            'ADMIN' => $this->session->userdata('email')
        );


        $response['status'] = $this->Task_model->createNewTask($task);
        print json_encode($response);
    }

}
