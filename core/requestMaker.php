<?php
/**
 * This file contains class body of RequestMaker.
 * @author Mukarram Ishaq
 */

namespace Core;

use Core\Utils\URLParser;
use Core\Request;

/**
 * Class RequestMaker
 * @package Core
 */
class RequestMaker
{
    /**
     * @var \Core\Utils\URLParser $urlParser
     */
    public static $urlParser = null;

    public static $urlPrefix = null;


    /**
     * make function will make an object of Core\Request
     * type and populate it and then return that object
     * @return \Core\Request
     */
    public static function make()
    {
        //retrieve url
        $completeURL = $_SERVER['REQUEST_URI'];
        //refine url
        $url = self::$urlParser->removePrefixFromURL($completeURL, self::$urlPrefix);
        $url = self::$urlParser->stripSlashes($url);
        //remove get parameters from the url if there is any
        $url = parse_url($url, PHP_URL_PATH);
        //retrieve method type
        $method = $_SERVER['REQUEST_METHOD'];
        //retrieve form inputs
        $input = $_REQUEST;
        //create a request object and return
        return new Request($completeURL, $url, $method, $input);
    }

    /**
     * @param URLParser $urlParser
     */
    public static function setURLParser(URLParser $urlParser)
    {
        self::$urlParser = $urlParser;
    }

    /**
     * @param string $urlPrefix
     */
    public static function setURLPrefix($urlPrefix)
    {
        self::$urlPrefix = $urlPrefix;
    }

}
