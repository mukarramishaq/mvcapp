<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/7/18
 * Time: 5:22 PM
 */

namespace Test\Core\Controllers;

use PHPUnit\Framework\TestCase;
use Core\Controllers\BaseController;

/**
 * Class BaseControllerTest
 * @package Core\Controllers
 */
class BaseControllerTest extends TestCase
{   protected $baseController = null;
    protected $model = null;

    public function setUp()
    {
        $this->model = $this->getMockBuilder('Core\Models\BaseModel')
            ->disableOriginalConstructor()
            ->getMock();
        $this->baseController = new BaseController($this->model);
    }

    public function testHandle()
    {
        $this->assertTrue(true);
    }

    public function testBeforeAction()
    {
        $this->baseController->beforeAction();
        $this->assertTrue(true);
    }

    public function testValidate()
    {
        $requestMock = $this->getMockBuilder('Core\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $this->baseController->validate($requestMock, []);
        $this->assertTrue(true);
    }

    public function testAfterAction()
    {
        $this->baseController->afterAction();
        $this->assertTrue(true);
    }
}
