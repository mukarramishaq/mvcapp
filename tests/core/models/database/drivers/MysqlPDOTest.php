<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/19/18
 * Time: 12:56 PM
 */

use Core\Models\Database\Drivers\MysqlPDO;

class MysqlPDOTest extends \PHPUnit\Framework\TestCase
{
    private $connection = null;

    public function setUp()
    {
        $this->connection = MysqlPDO::getConnection("sqlite::memory:", "", "");
    }

    public function tearDown()
    {
        unset($this->connection);
    }

    public function test__wakeup()
    {
        $this->assertNULL(unserialize(serialize($this->connection)));
    }

    public function testGetConnection()
    {
        $this->assertInstanceOf('Core\Models\Database\Drivers\MysqlPDO', $this->connection);
    }
}
