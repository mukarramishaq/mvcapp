<?php
/**
*Configuration File.
*
*This file contains all the configuration details.
*@author Mukarram Ishaq
*/

/***************   database configs ****************/
$config['db_host'] = 'localhost';
$config['db_port'] = '3306';
$config['db_user'] = 'root';
$config['db_password'] = '123';
$config['db_server'] = 'mysql';
$config['db_driver'] = 'mysql';
$config['db_driver_class_name'] = 'MysqlPDO';
$config['db_charset'] = 'utf8mb4';
$config['db_dsn'] = 'mysql:host=localhost;port=3306;dbname=test;charset=utf8mb4';
$config['db_dbname'] = 'test';

/***************  other configs  *****************/
$config['url_param_mask'] = 'param';
$config['url_prefix_extension'] = '/testload/';

/***************  Logs configs  *****************/
$config['log_debug_file'] = '/var/www/html/testload/logs/debug.log';

/*************** view configs  *****************/
$config['parent_directory_of_views'] = '/var/www/html/testload/app/views/';
$config['view_file_extention'] = '.html';

/*************** 404 Not Found  ****************/
$config['404_route'] = 'error/404';
