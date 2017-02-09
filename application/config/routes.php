<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['users/displayTasks'] = 'users/displayTasks';
$route['users/displayUpcomingTasks'] = 'users/displayUpcomingTasks';
$route['users/displayGroupTasks'] = 'users/displayGroupTasks';
$route['users/login'] = 'users/login';
$route['users/register'] = 'users/register';

$route['users/tasks/task?(:any)'] = 'tasks/task';
$route['users/tasks/delete?(:any)'] = 'tasks/deleteTask';
$route['users/tasks/viewTask'] = 'tasks/viewTask';
$route['users/tasks/updateTask'] = 'tasks/updateTask';
$route['users/tasks/createTask'] = 'tasks/createTask';
$route['users/tasks/create'] = 'tasks/create';

$route['users/(:any)'] = 'users/view/$1';
$route['users'] = 'users/index';
$route['default_controller'] = 'site/view';
//$route[''] = 'site/index';
$route['(:any)'] = 'site/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
