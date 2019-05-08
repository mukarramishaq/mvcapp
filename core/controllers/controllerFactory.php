<?php
/**
 * controllerFactory file contains class definition
 * of controllerFactory.
 *
 * @author Mukarram Ishaq
 */

namespace Core\Controllers;

use Core\Exceptions\ClassNotFoundException;
use Core\Exceptions\InvalidControllerException;

class ControllerFactory
{

    /**
     * ControllerFactory constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $controllerName
     * @return mixed
     * @throws ClassNotFoundException
     * @throws InvalidControllerException
     */
    public function createController($controllerName, $model)
    {
        //if controller class not found throw exception
        if (!$this->doesClassExist($controllerName)) {
            throw new ClassNotFoundException("$controllerName class is not found");
        }
        //make sure controller class is derived from \Core\Controllers\BaseController
        //and its parent has implemented \Core\Controller\ControllerInterface
        if (!$this->validateControllerClass($controllerName)) {
            throw new InvalidControllerException("$controllerName is not a controller class!");
        }
        //return instance of controller class
        return new $controllerName($model);
    }

    /**
     * @access private
     * @param $class
     * @return bool
     */
    private function doesClassExist($class)
    {
        return class_exists($class);
    }

    /**
     * @access private
     * @param string $class
     * @return bool
     */
    private function validateControllerClass($class)
    {
        return
            (
                array_key_exists('Core\Controllers\BaseController',class_parents($class))
                &&
                array_key_exists('Core\Controllers\ControllerInterface', class_implements($class))
            )   ? true : false;
    }

}
