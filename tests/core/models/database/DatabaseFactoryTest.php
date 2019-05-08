<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/18/18
 * Time: 12:18 PM
 */

use Core\Models\Database\DatabaseFactory;

class DatabaseFactoryTest extends \PHPUnit\Framework\TestCase
{
    private $factory = null;
    private $config = array();

    public function setUp()
    {
        $this->config['db_dsn'] = "mysql::memory";
        $this->config['db_user'] = "root";
        $this->config['db_password'] = "123";
        $this->config['db_driver'] = "mysql";
        $this->config['db_driver_class_name'] = "MysqlPDO";

        $this->factory = new DatabaseFactory($this->config);
    }

    /**
     * assert the successfull retrieval of Gate Class Name
     */
    public function testGetCurrentGateClassNameSuccessfully()
    {
        $this->assertEquals('\Core\Models\Database\MysqlGate', $this->factory->getCurrentGateClassName());
    }

    public function testGetCurrentGateClassNameReturnsNull()
    {
        $this->factory = new DatabaseFactory([]);
        $this->assertNull($this->factory->getCurrentGateClassName());
    }

    /**
     *when it return an instance of gate of successfully.
     */
    public function testGetDatabaseInstanceReturnsSuccessfully()
    {
        $this->assertInstanceOf('\Core\Models\Database\DatabaseInterface', $this->factory->getDatabaseInstance());
    }

    /**
     * data provider for testGetDatabaseInstanceThrowsClassNotFoundException
     * @return array
     */
    public function getDatabaseInstanceThrowsClassNotFoundException()
    {
        return [
            ['db_driver'],
            ['db_driver_class_name'],
        ];
    }

    /**
     * when getDatabaseInstance throws ClassNotFoundException
     * @dataProvider getDatabaseInstanceThrowsClassNotFoundException
     * @param $key
     * @expectedException \Core\Exceptions\ClassNotFoundException
     */
    public function testGetDatabaseInstanceThrowsClassNotFoundException($key)
    {
        unset($this->config[$key]);
        $this->factory = new DatabaseFactory($this->config);
        $this->factory->getDatabaseInstance();
    }


    /**
     * assert the correct creation of instance of this class
     */
    public function test__construct()
    {
        $this->assertInstanceOf('Core\Models\Database\DatabaseFactory', $this->factory);
    }

    /**
     * assert the successfull retrieval of driver class name
     */
    public function testGetCurrentDatabaseDriverClassNameSuccessfully()
    {
        $this->assertEquals('\\Core\\Models\\Database\\Drivers\\MysqlPDO', $this->factory->getCurrentDatabaseDriverClassName());
    }

    /**
     * when getCurrentDatabaseDriverClassName return null
     */
    public function testGetCurrentDatabaseDriverClassNameReturnsNull()
    {
        $this->factory = new DatabaseFactory([]);
        $this->assertNull($this->factory->getCurrentDatabaseDriverClassName());
    }
}
