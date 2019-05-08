<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/14/18
 * Time: 11:04 AM
 */

use Core\Controllers\Traits\CRUD;

class CRUDTest extends \PHPUnit\Framework\TestCase
{
    protected $controller = null;
    //setup
    public function setUp()
    {
        //create mock for trait
        $this->controller = $this->getMockForTrait(CRUD::class);

        //create model mock
        $this->controller->model = $this->getMockBuilder('Core\Models\BaseModel')
            ->disableOriginalConstructor()
            ->getMock();

        //create requestMock
        $this->requestMock = $this->getMockBuilder('Core\Request')
            ->disableOriginalConstructor()
            ->getMock();

        //create view mock
        $this->controller->view = $this->getMockBuilder('Core\Views\View')->getMock();
    }

    //tear down
    public function tearDown()
    {
        unset($this->controller);
    }

    public function testCreateWhenUserAlreadyExists()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue((object)["id"=>1, "name"=>"haha"]));
        $this->controller->model->expects($this->never())
            ->method('create')
            ->will($this->returnValue((object)["id"=>1, "name"=>"haha"]));


        //stubs request mock
        $this->requestMock->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('POST'));
        $this->requestMock->expects($this->once())
            ->method('getInput')
            ->will($this->returnValue(["id"=>1, "name"=>"flan"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));

        $this->assertTrue($this->controller->create($this->requestMock));
    }

    public function testCreateWhenUserNotAlreadyExists()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue(null));
        $this->controller->model->expects($this->once())
            ->method('create')
            ->will($this->returnValue((object)["id"=>1, "name"=>"haha"]));

        //stubs request mock
        $this->requestMock->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('POST'));
        $this->requestMock->expects($this->once())
            ->method('getInput')
            ->will($this->returnValue(["id"=>1, "name"=>"flan"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));


        $this->assertTrue($this->controller->create($this->requestMock));
    }

    public function testCreateRequestMethodIsGET()
    {
        //stubs model mock
        $this->controller->model->expects($this->never())
            ->method('findById')
            ->will($this->returnValue((object)["id"=>1, "name"=>"haha"]));
        $this->controller->model->expects($this->never())
            ->method('create')
            ->will($this->returnValue((object)["id"=>1, "name"=>"haha"]));

        //stubs request mock
        $this->requestMock->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('GET'));
        $this->requestMock->expects($this->never())
            ->method('getInput')
            ->will($this->returnValue(["id"=>1, "name"=>"flan"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));


        $this->assertTrue($this->controller->create($this->requestMock));
    }

    public function testDeleteWhenNotFound()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue(null));
        $this->controller->model->expects($this->never())
            ->method('delete')
            ->will($this->returnValue(false));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(false));


        $this->assertFalse($this->controller->delete($this->requestMock, 2));
    }

    public function testDeleteWhenFound()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue($this->controller->model));
        $this->controller->model->expects($this->once())
            ->method('delete')
            ->will($this->returnValue(true));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));


        $this->assertTrue($this->controller->delete($this->requestMock, 2));
    }

    public function testUpdateWhenNotFound()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue(null));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(false));

        //stubs request mock
        $this->requestMock->expects($this->never())
            ->method('getMethod')
            ->will($this->returnValue('GET'));
        $this->requestMock->expects($this->never())
            ->method('getActualURL')
            ->will($this->returnValue('/a/g/b'));
        $this->requestMock->expects($this->never())
            ->method('getInput')
            ->will($this->returnValue(["id"=>2, "name"=>"Mukarram Ishaq"]));

        $this->assertFalse($this->controller->update($this->requestMock, 2));
    }

    public function testUpdateWhenFoundAndMethodIsGET()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue((object)["id"=>2, "name"=>"mukarram"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));

        //stubs request mock
        $this->requestMock->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('GET'));
        $this->requestMock->expects($this->once())
            ->method('getActualURL')
            ->will($this->returnValue('/a/g/b'));
        $this->requestMock->expects($this->never())
            ->method('getInput')
            ->will($this->returnValue(["id"=>2, "name"=>"Mukarram Ishaq"]));

        $this->assertTrue($this->controller->update($this->requestMock, 2));
    }

    public function testUpdateSuccessfully()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue($this->controller->model));
        $this->controller->model->allProperties = ["id", "name"];

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(100));

        //stubs request mock
        $this->requestMock->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue('POST'));
        $this->requestMock->expects($this->never())
            ->method('getActualURL')
            ->will($this->returnValue('/a/g/b'));
        $this->requestMock->expects($this->once())
            ->method('getInput')
            ->will($this->returnValue(["id"=>2, "name"=>"Mukarram Ishaq"]));

        $this->assertEquals(100, $this->controller->update($this->requestMock, 2));
    }

    /**
     * read when param is "all" provided
     */
    public function testReadAllWhenParamIsAll()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('all')
            ->will($this->returnValue([[1],[2],[3]]));
        $this->controller->model->expects($this->never())
            ->method('findById')
            ->will($this->returnValue((object)["id"=>1, "name"=>"flan"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));

        $this->assertTrue($this->controller->read($this->requestMock, 'all'));
    }

    /**
     * read when not a single param is provided
     */
    public function testReadAllWhenNoParam()
    {
        //stubs model mock
        $this->controller->model->expects($this->once())
            ->method('all')
            ->will($this->returnValue([[1],[2],[3]]));
        $this->controller->model->expects($this->never())
            ->method('findById')
            ->will($this->returnValue((object)["id"=>1, "name"=>"flan"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(true));

        $this->assertTrue($this->controller->read($this->requestMock, ''));
    }

    /**
     * read when param is number
     */
    public function testReadAllWhenParamIsNumber()
    {
        //stubs model mock
        $this->controller->model->expects($this->never())
            ->method('all')
            ->will($this->returnValue([[1],[2],[3]]));
        $this->controller->model->expects($this->once())
            ->method('findById')
            ->will($this->returnValue((object)["id"=>1, "name"=>"flan"]));

        //stubs view mock
        $this->controller->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue(1));

        $this->assertEquals(1, $this->controller->read($this->requestMock, 2));
    }

}
