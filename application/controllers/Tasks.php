<?php

class Tasks extends CI_Controller {

    protected $default_active_status = 1;
    protected $default_active_is_deleted = 0;

    protected $type_note = 1;
    protected $type_location = 2;
    protected $type_file = 3;
    //protected $timestamp = now();

    public function __construct() {

        parent::__construct();

        if($this->session->userdata('id')){
        $this->load->model('Task_model');
        $this->load->model('User_model');
        }else{
            redirect('index', 'refresh');
        }
    }

    public function task() {
        $task_id = filter_input(INPUT_GET, 'id');
        $id = $this->session->userdata('id');
        $check = $this->Task_model->checkTaskPrivilege($task_id);

        if(!in_array($id, $check)){
            redirect('/users/tasks/unauthorized', 'refresh');
        }else if(!$id){
            redirect('index', 'refresh');
        }else{
            $this->load->view('templates/header');
            $this->load->view('tasks/task');
            $this->load->view('templates/footer');
        }
    }

    public function create() {

        if($this->session->userdata('id')){
        $this->load->view('templates/header');
        $this->load->view('tasks/create');
        $this->load->view('templates/footer');
        }else{
            redirect('index', 'refresh');
        }
    }

    public function unauthorized(){
        $this->load->view('templates/header');
        $this->load->view('errors/html/unauthorized');
        $this->load->view('templates/footer');
    }

    public function viewTask() {

        $task_id = filter_input(INPUT_GET, 'id');
        $id = $this->session->userdata('id');

        $tasks['task'] = $this->Task_model->getTask($task_id, $id);
        $tasks['admin'] = $id;
        print json_encode($tasks);
    }

    public function updateTask() {

        $update = json_decode(file_get_contents('php://input'), true);
        
        $timestamp = date('Y-m-d G:i:s');

        $task = array(
            'name' => $update['inputTaskName'],
            'start_time' => $update['inputTaskStart'],
            'end_time' => $update['inputTaskEnd'],
            'task_date' => $update['inputTaskDate'],
            'info' => $update['inputTaskInfo'],
            'user_id' => $this->session->userdata('id'),
            'updated_at' => $timestamp
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
        $timeline_type = 1;

        $new = json_decode(file_get_contents('php://input'), true);
        $shared_with = $new['sharedWith'];

        $timestamp = date('Y-m-d G:i:s');

        $task = array(
            'user_id' => $this->session->userdata('id'),
            'name' => $new['inputTaskName'],
            'start_time' => $new['inputTaskStart'],
            'end_time' => $new['inputTaskEnd'],
            'task_date' => $new['inputTaskDate'],
            'info' => $new['inputTaskInfo'],
            'status' => $this->default_active_status,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'is_deleted' => $this->default_active_is_deleted,
            'type' => $new['types']
        );

        $response = $this->Task_model->createNewTask($task);
        $task_id = $response['task_id'];

        $data_timeline = array(
            'user_id' => $this->session->userdata('id'),
            'created_at' => $timestamp,
            'type' => $timeline_type,
            'type_data_id' => $task_id = $response['task_id']
        );

        if($response['code'] == 200){
            $this->User_model->addToUserTimeline($data_timeline);
            print json_encode($response);
        }
        
        if($shared_with > 0) {
            
            foreach($shared_with as $n) {
                $this->createTaskSharedWith($task_id, $n['id']);
            }
        } 
    }

    public function createTaskSharedWith($task_id, $user_id){

        $timestamp = date('Y-m-d G:i:s');
        $timeline_type = 2;

        $data_one = array (
            'shared_with' => $user_id,
            'task_id' => $task_id,
            'is_deleted' => $this->default_active_is_deleted,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        );

        $data_timeline = array (
            'user_id' => $user_id,
            'created_at' => $timestamp,
            'type' => $timeline_type,
            'type_data_id' => $task_id
        );  

        $response =  $this->Task_model->updateTaskShare($data_one);
        $this->User_model->addToUserTimeline($data_timeline);
        print json_encode($response);

    }

    public function addUserToProject() {

        $task_id = filter_input(INPUT_GET, 'taskId');
        $share_user_id = filter_input(INPUT_GET, 'userId');
        $timestamp = date('Y-m-d G:i:s');
        $timeline_type = 2;
        
        $data_one = array (
            'shared_with' => $share_user_id,
            'task_id' => $task_id,
            'is_deleted' => $this->default_active_is_deleted,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        );

        $data_timeline = array (
            'user_id' => $share_user_id,
            'created_at' => $timestamp,
            'type' => $timeline_type,
            'type_data_id' => $task_id
        ); 

        $response =  $this->Task_model->updateTaskShare($data_one);
        $this->User_model->addToUserTimeline($data_timeline);
        print json_encode($response);
        
    }

    public function getTaskMedia(){
        $task_id = filter_input(INPUT_GET, 'task_id');

        $response = $this->Task_model->taskMedia($task_id);
        print json_encode($response);

    }

    public function deleteMedia(){
        $media_id = filter_input(INPUT_GET, 'media_id');

        $response = $this->Task_model->deleteTaskMedia($media_id);
        print json_encode($response);
    }


    public function addFileToProject(){
        $data = json_decode(file_get_contents('php://input'), true);
        
        $data = $data[0];
        $timestamp = date('Y-m-d G:i:s');

        if(isset($data['file_url'])){
            $file_url = $data['file_url'];
        }else{
            $file_url = null;
        }

        if(isset($data['info'])){
            $info = $data['info'];
        }else{
            $info = null;
        }

        $file = array(
            'task_id' => $data['task_id'],
            'user_id' => $data['admin'],
            'file_url' => $file_url,
            'is_deleted' => $this->default_active_is_deleted,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'information' => $info,
            'type' => $this->type_note,
            'location_id' => NULL

        );

        $response = $this->Task_model->addFile($file);

        return json_encode($response);

    }

    public function addLocationToProject(){
        $data = json_decode(file_get_contents('php://input'), true);
        $data = $data[0];
        $timestamp = date('Y-m-d G:i:s');
        print_r($data);
         
        $location = array(
            'name' => $data['name'],
            'address' => $data['name'],
            'lat' => $data['lat'],
            'lng' => $data['lng']
        );

        $response = $this->Task_model->addLocation($location);
        $location_id = $response['location_id'];

        $media = array(
            'task_id' => $data['task_id'],
            'user_id' => $data['admin'],
            'file_url' => NULL,
            'is_deleted' => $this->default_active_is_deleted,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'information' => NULL,
            'type' => $this->type_location,
            'location_id' => $location_id
        );

        $response = $this->Task_model->addFile($media);
        return json_encode($response);

    }

    public function fileUpload(){

        $timestamp = date('Y-m-d G:i:s');

        $data = json_decode($_POST['data']);
        print_r($data);
        $task_id = $data->task_id;
        $uploaded_by = $data->uploaded_by;

        $target_dir = '/opt/lampp/htdocs/Schedulr/assets/files/' . $task_id . '/';

        if (!is_dir($target_dir)) {
            mkdir($target_dir);         
        }

        $name = $_FILES["file"]["name"];

        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        $file_path = '/assets/files/' . $task_id . '/' . $name;
        $user_id = $this->session->userdata('id');

        $file = array(
            'task_id' => $task_id,
            'user_id' => $uploaded_by,
            'file_url' => $file_path,
            'is_deleted' => $this->default_active_is_deleted,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'information' => $name,
            'type' => $this->type_file,
            'location_id' => NULL

        );

        $data = $this->Task_model->addFile($file);
        //$data = $this->User_model->imageUploadPath($user_id, $image_path);
        print json_encode($data); 
    }

}
