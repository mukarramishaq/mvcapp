<?php
/**
 * Created by PhpStorm.
 * User: mukarram.ishaq
 * Date: 9/6/18
 * Time: 12:19 PM
 */

namespace Test\Core\Utils;

use Core\Utils\URLParser;
use PHPUnit\Framework\TestCase;

class URLParserTest extends TestCase
{
    private $urlParser = null;

    public function setUp()
    {
        $this->urlParser = new URLParser();
    }

    public function tearDown()
    {
        $this->urlParser = null;
    }

    /**
     * this function provides data for testing
     * removePrefixFromURL function
     * @return array
     */
    public function removePrefixFromURLProvider()
    {
        return array(
            ['crud/show', '', 'crud/show'],
            ['/crud/show', 'testload', '/crud/show'],
            ['testload/crud/show/', '/testload/', 'testload/crud/show/'],
            ['/testload/crud/show/', '/testload/', 'crud/show/'],
        );
    }

    /**
     * this function provides data for testing
     * stripSlashes function
     * @return array
     */
    public function stripSlashesProvider()
    {
        return array(
            ['crud/show', 'crud/show'],
            ['/crud/show', 'crud/show'],
            ['testload/crud/show/', 'testload/crud/show/'],
            ['/testload/crud/show/', 'testload/crud/show/'],
        );
    }

    /**
     * @param $url
     * @param $prefix
     * @param $output
     * @dataProvider removePrefixFromURLProvider
     */
    public function testPrefixeRemovedSuccessfully($url, $prefix, $output)
    {
        $this->assertEquals($output, $this->urlParser->removePrefixFromURL($url, $prefix));
    }

    /**
     * @param $url
     * @param $output
     * @dataProvider stripSlashesProvider
     */
    public function testStrippedSlashesSuccessfully($url, $output)
    {
        $this->assertEquals($output, $this->urlParser->stripSlashes($url));
    }
}
