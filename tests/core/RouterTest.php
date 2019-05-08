<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/7/18
 * Time: 11:40 AM
 */

namespace Test\Core;

use PHPUnit\Framework\TestCase;
use Core\Router;
/**
 * Class RouterTest
 * @package Core
 */
class RouterTest extends TestCase
{
    public function setUp()
    {
        Router::init();
    }

    public function tearDown()
    {
        Router::destroy();
    }

    public function rememberDataProvider(){
        return array(
            ['rotue/route', ['controller'=>'haha', 'action'=>'hehe']],
            ['rotue/route', ['controller'=>'haha']],
            ['rotue/route', []],
        );
    }


    /**
     * @param $route
     * @param $handlersInfo
     * @dataProvider rememberDataProvider
     */
    public function testRemember($route, $handlersInfo)
    {
        Router::remember($route, $handlersInfo);
        $this->assertTrue(true);
    }

    public function testInit()
    {
        Router::init();
        $this->assertTrue(true);
    }

    public function testHandle()
    {

    }
}
