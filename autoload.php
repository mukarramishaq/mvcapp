<?php

/**
*This file handles loading of classes
*
*@author Mukarram Ishaq
*/

/**
*customeLoader function gives us customized loader.
*
*customeLoader function returns us a function which can
*be registered using spl_autoload_register function to register
*a customized loader.
*
*@param string $src directory which contain classes
*@param string $namespace_prefix
*@param string $fileExtention extention of file like ".php"
*
*@return closure
*/
function customeLoader($src, $namespace_prefix, $fileExtention)
{
    return function ($class) use ($src, $namespace_prefix, $fileExtention){
        //check does $class contain our namespace prefix at the beginning
        $len = strlen($namespace_prefix);
        if (strncmp($namespace_prefix, $class, $len) !== 0) {
            return;
        }
        //now replace namespace prefix with the path of the dir
        $class = $src.str_replace($namespace_prefix, '', $class);
        //replace "\\" slashes with "/"
        $class = str_replace('\\', '/', $class);
        //make first letter of every subspacename and class name small
        $classArray = explode('/', $class);
        //making first letter of each one small
        foreach($classArray as $subnamespace){
            $class = str_replace($subnamespace,lcfirst($subnamespace),$class);  
        }
        //append file extention with the path
        $classFile = $class.$fileExtention;
        //check file exists
        if(file_exists($classFile)){
            require_once($classFile);
        }
    };
}


/**
*Register an autload to load classes from "core" folder
*
*/
$coreLoader = customeLoader(__DIR__.'/core/', 'Core\\', '.php');
spl_autoload_register($coreLoader);

/**
*Register an autload to load classes from "app" folder
*
*/
$appLoader = customeLoader(__DIR__.'/app/', 'App\\', '.php');
spl_autoload_register($appLoader);