<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/14/18
 * Time: 11:12 AM
 */

use Core\Models\BaseModel;

class BaseModelTest extends \PHPUnit\Framework\TestCase
{
    private $database = null;
    private $model = null;

    public function setUp()
    {
        $this->database = $this->getMockBuilder('Core\Models\Database\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->database->expects($this->any())
            ->method('getAllColumnNames')
            ->will($this->returnValue(['id', 'name']));

        $this->model = new BaseModel($this->database);
    }

    public function test__construct()
    {
        $this->assertInstanceOf('Core\Models\BaseModel', $this->model);
    }

    public function testLoadAllClassProperties()
    {
        $this->assertTrue(
            property_exists($this->model, 'id')
            &&
            property_exists($this->model, 'name')
        );
    }

    public function testSaveUpdates()
    {
        $this->database->expects($this->once())
            ->method('select')
            ->will($this->returnValue(['id'=>1, 'name'=>'flan']));
        $this->database->expects($this->once())
            ->method('update')
            ->will($this->returnValue(true));

        $this->model = new BaseModel($this->database);
        $this->assertTrue($this->model->save());
    }

    public function testSaveInserts()
    {
        $this->database->expects($this->once())
            ->method('select')
            ->will($this->returnValue([]));
        $this->database->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(1));

        $this->model = new BaseModel($this->database);
        $this->assertEquals(1, $this->model->save());
    }

    public function testFindByIdReturnModelObject()
    {
        $this->database->expects($this->once())
            ->method('select')
            ->will($this->returnValue([['id'=>1, 'name'=>'flan']]));

        $this->model = new BaseModel($this->database);
        $this->assertInstanceOf('\Core\Models\BaseModel', $this->model->findById(1));
    }

    public function testFindReturnsArrayOfModelObjects()
    {
        $this->database->expects($this->once())
            ->method('select')
            ->will($this->returnValue(
                [
                    ['id'=>1, 'name'=>'flan'],
                    ['id'=>2, 'name'=>'flam'],
                ]
            ));

        $this->model = new BaseModel($this->database);
        $mobjects = $this->model->find([]);
        $this->assertInternalType('array', $mobjects);
        $this->assertInstanceOf('\Core\Models\BaseModel', $mobjects[0]);
    }

    public function testAll()
    {
        $this->database->expects($this->once())
            ->method('select')
            ->will($this->returnValue(
                [
                    ['id'=>1, 'name'=>'flan'],
                    ['id'=>2, 'name'=>'flam'],
                ]
            ));

        $this->model = new BaseModel($this->database);
        $mobjects = $this->model->all();
        $this->assertInternalType('array', $mobjects);
        $this->assertInstanceOf('\Core\Models\BaseModel', $mobjects[0]);
    }

    public function testDeleteSuccessfully()
    {
        $this->database->expects($this->once())
            ->method('delete')
            ->will($this->returnValue(1));
        $this->model = new BaseModel($this->database);

        $this->assertTrue($this->model->delete());
    }

    public function testDeleteReturnsFalse()
    {
        $this->database->expects($this->once())
            ->method('delete')
            ->will($this->returnValue(false));
        $this->model = new BaseModel($this->database);

        $this->assertFalse($this->model->delete());
        $this->assertInstanceOf('Core\Models\BaseModel', $this->model);
    }

    public function testCreateWithFalseCommit()
    {
        $this->assertInstanceOf('\Core\Models\BaseModel',
            $this->model->create(['id'=>1, 'name'=>'flan'], false));
    }

    public function testCreateWithTrueCommit()
    {
        $this->database->expects($this->once())
            ->method('select')
            ->will($this->returnValue([]));
        $this->database->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(1));

        $this->model = new BaseModel($this->database);

        $this->assertInstanceOf('\Core\Models\BaseModel',
            $this->model->create(['id'=>1, 'name'=>'flan'], true));
    }
}
