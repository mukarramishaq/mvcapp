<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/14/18
 * Time: 11:11 AM
 */

use Core\Models\ModelFactory;

class ModelFactoryTest extends \PHPUnit\Framework\TestCase
{
     
    protected $databaseFactory = null;
    

    public function setUp()
    {
        
        $this->databaseFactory = $this->getMockBuilder('\Core\Models\Database\DatabaseFactory')
                                    ->setConstructorArgs([[]])
                                    ->getMock();
        $databaseInstance = $this->getMockBuilder('\Core\Models\Database\DatabaseInterface')
                                ->getMock();

        $databaseInstance->expects($this->any())
                        ->method('getAllColumnNames')
                        ->will($this->returnValue([]));
                                
        $this->databaseFactory->expects($this->any())
            ->method('getDatabaseInstance')
            ->will($this->returnValue($databaseInstance));
    }

    public function tearDown()
    {
        unset($this->databseFactory);
    }

    public function test__construct()
    {
        $this->assertInstanceOf("\Core\Models\ModelFactory", new ModelFactory($this->databaseFactory));
    }

    /**
     * @return array
     */
    public function createModelSuccessfullyDataProvider()
    {
        return [
            ["\App\Models\Student"],
            ["\App\Models\Course"],
            ["\App\Models\Teacher"]
        ];
    }

    /**
     * @param $modelName
     * @dataProvider createModelSuccessfullyDataProvider
     */
    public function testCreateModelSuccessfully($modelName)
    {
        
        //create model factory
        $modelFactory = new ModelFactory($this->databaseFactory);
        $this->assertInstanceOf("\Core\Models\BaseModel", $modelFactory->createModel($modelName));
    }

    /**
     * @return array
     */
    public function createModelThrowsClassNotFoundExceptionDataProvider()
    {
        return [
            ["\\App\\Models\\Studt"],
            ["\\App\\Models\\Couse"],
            ["\\App\\Models\\Techer"]
        ];
    }

    /**
     * @param $modelName
     * @dataProvider createModelThrowsClassNotFoundExceptionDataProvider
     * @expectedException \Core\Exceptions\ClassNotFoundException
     */
    public function testCreateModelThrowsClassNotFoundException($modelName)
    {
        $modelFactory = new ModelFactory($this->databaseFactory);
        $modelFactory->createModel($modelName);
    }


    /**
     * @return array
     */
    public function createModelThrowsInvalidModelExceptionDataProvider()
    {
        return [
            ["\\App\\Controllers\\StudentController"],
            ["\\App\\Controllers\\CourseController"],
            ["\\App\\Controllers\\TeacherController"]
        ];
    }

    /**
     * @param $modelName
     * @dataProvider createModelThrowsInvalidModelExceptionDataProvider
     * @expectedException \Core\Exceptions\InvalidModelException
     */
    public function testCreateModelThrowsInvalidModelException($modelName)
    {
        $modelFactory = new ModelFactory($this->databaseFactory);
        $modelFactory->createModel($modelName);
    }
}
