<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['uri_protocol'] = 'AUTO';

$route['users/displayTasks'] = 'users/displayTasks';
$route['users/displayUpcomingTasks'] = 'users/displayUpcomingTasks';
$route['users/displayGroupTasks'] = 'users/displayGroupTasks';
$route['users/login'] = 'users/login';
$route['users/register'] = 'users/register';
$route['users/getProfile'] = 'users/getProfile';
$route['users/Users/getFriends'] = 'users/getFriends';
$route['users/getFriends'] = 'users/getFriends';
$route['users/addFriends'] = 'users/addFriends';
$route['users/deleteFriend'] = 'users/deleteFriend';
$route['users/updateProfile'] = 'users/updateProfile';
$route['users/searchPeople'] = 'users/searchPeople';
$route['users/imageUpload'] = 'users/imageUpload';
$route['users/tasks/showFriends'] = 'users/getFriends';
$route['users/tasks/Users/getFriends'] = 'users/getFriends';
$route['users/tasks/task?(:any)'] = 'tasks/task';
$route['users/tasks/deleteTask?(:any)'] = 'tasks/deleteTask';
$route['users/tasks/viewTask'] = 'tasks/viewTask';
$route['users/tasks/updateTask'] = 'tasks/updateTask';
$route['users/tasks/createTask'] = 'tasks/createTask';
$route['users/tasks/create'] = 'tasks/create';
$route['users/tasks/addUser'] = 'tasks/addUserToProject';
$route['users/getTimeline'] = 'users/getTimeline';
$route['users/profileImage'] = 'users/profileImage';
$route['users/tasks/addFileToProject'] = 'tasks/addFileToProject';
$route['users/tasks/getTaskMedia'] = 'tasks/getTaskMedia';
$route['users/tasks/deleteMedia'] = 'tasks/deleteMedia';
$route['users/tasks/addLocationToProject'] = 'tasks/addLocationToProject';
$route['users/tasks/fileUpload'] = 'tasks/fileUpload';
$route['users/updatePassword'] = 'users/updatePassword';
$route['users/recoverPassword'] = 'users/recoverPassword';
$route['users/validateRecoverPassword?(:any)'] = 'users/validateRecoverPassword';
$route['users/tasks/unauthorized'] = 'tasks/unauthorized';



$route['users/(:any)'] = 'users/view/$1';
$route['users'] = 'users/index';
$route['default_controller'] = 'site/view';
//$route[''] = 'site/index';
$route['(:any)'] = 'site/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
