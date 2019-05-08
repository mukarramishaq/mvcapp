<?php
/**
*Routes file contains all the routes.
*
*Routes file return a three dimensional associative array
*where first array's keys are route type like GET,POST etc
*and second array contain route as
*
*@author Mukarram Ishaq
*/
use Core\Router;

//write your routes here
Router::remember('home', ['controller'=>'HomeController', 'action'=>'index']);
Router::remember('/', ['controller'=>'HomeController', 'action'=>'index']);
Router::remember('error/404', ['controller'=>'HomeController', 'action'=>'notFound']);

Router::remember('student/', ['controller'=>'StudentController', 'action'=>'read', 'url_params'=>['id']]);
Router::remember('teacher/', ['controller'=>'TeacherController', 'action'=>'read', 'url_params'=>['id']]);
Router::remember('course/', ['controller'=>'CourseController', 'action'=>'read', 'url_params'=>['id']]);

Router::remember('student/delete/', ['controller'=>'StudentController', 'action'=>'delete', 'url_params'=>['id']]);
Router::remember('teacher/delete/', ['controller'=>'TeacherController', 'action'=>'delete', 'url_params'=>['id']]);
Router::remember('course/delete/', ['controller'=>'CourseController', 'action'=>'delete', 'url_params'=>['id']]);

Router::remember('student/create/', ['controller'=>'StudentController', 'action'=>'create']);
Router::remember('teacher/create/', ['controller'=>'TeacherController', 'action'=>'create']);
Router::remember('course/create/', ['controller'=>'CourseController', 'action'=>'create']);

Router::remember('student/update/', ['controller'=>'StudentController', 'action'=>'update', 'url_params'=>['id']]);
Router::remember('teacher/update/', ['controller'=>'TeacherController', 'action'=>'update', 'url_params'=>['id']]);
Router::remember('course/update/', ['controller'=>'CourseController', 'action'=>'update', 'url_params'=>['id']]);


