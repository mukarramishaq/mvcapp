<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/7/18
 * Time: 5:21 PM
 */

namespace Test\Core\Controllers;

use Core\Controllers\ControllerFactory;
use PHPUnit\Framework\TestCase;
use Core\Exceptions\ClassNotFoundException;
use Core\Exceptions\InvalidControllerException;

/**
 * Class ControllerFactoryTest
 * @package Core\Controllers
 */
class ControllerFactoryTest extends TestCase
{
    private $controllerFactory = null;
    private $model = null;

    public function setUp()
    {
        $this->model = $this->getMockBuilder('Core\Models\BaseModel')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controllerFactory = new ControllerFactory();
    }

    public function tearDown()
    {
        unset($this->controllerFactory);
        unset($this->model);
    }

    /**
     * @return array
     */
    public function createsControllerFunctionCreatesControllerSuccessfullyDataProvider()
    {
        return array(
            ['\\App\\Controllers\\StudentController'],
            ['\\App\\Controllers\\TeacherController'],
            ['\\App\\Controllers\\CourseController']
        );
    }

    /**
     * @return array
     */
    public function createsControllerFunctionThrowsClassNotFoundExceptionDataProvider()
    {
        return [
            ["\\App\\StudentController"],
            ["\\App\\Controllers\\TeacherController2"],
            ["\\App\\Controller\\CourseController"]
        ];
    }
    
    /**
     * @return array
     */
    public function createsControllerFunctionThrowsInvalidControllerExceptionDataProvider()
    {
        return [
            ["\\App\\Controllers\\ControllerTemp"]
        ];
    }


    /**
     * @param $controllerName
     * @dataProvider createsControllerFunctionCreatesControllerSuccessfullyDataProvider
     */
    public function testCreateControllerFunctionCreatesControllerSuccessfully($controllerName)
    {
            $this->assertInstanceOf("Core\Controllers\BaseController", $this->controllerFactory->createController($controllerName, $this->model));
    }

    /**
     * @param $controllerName
     * @dataProvider createsControllerFunctionThrowsClassNotFoundExceptionDataProvider
     * @expectedException Core\Exceptions\ClassNotFoundException
     */
    public function testCreateControllerFunctionThrowsClassNotFoundException($controllerName)
    {
            $this->controllerFactory->createController($controllerName, $this->model);
    }
    
    /**
     * @param $controllerName
     * @dataProvider createsControllerFunctionThrowsInvalidControllerExceptionDataProvider
     * @expectedException Core\Exceptions\InvalidControllerException
     */
    public function testCreateControllerFunctionThrowsInvalidControllerException($controllerName)
    {
        $this->controllerFactory->createController($controllerName, $this->model);
    }

    public function test__construct()
    {
        $this->assertInstanceOf('Core\\Controllers\\ControllerFactory', $this->controllerFactory);
    }
}
