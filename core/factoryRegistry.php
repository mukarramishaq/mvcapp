<?php
/**
*Class definition of FactoryRegistry.
*
*@author Mukarram Ishaq
*/
namespace Core;

/**
*FactoryRegistry.
*
*@package \Core;
*/
class FactoryRegistry
{
    private static $factories = array();
   
    /**
    *add function add give factory into $factories array.
    *@param string $key
    *@param object $factory
    *an instance of a factory.
    *@return bool
    *@access public
    *@static
    */
    public function add($key, $factory)
    {
        //if key already occupied then ignore
        if (!isset(self::$factories[$key])) {
            self::$factories[$key] = $factory;
            return true;
        }
        return false;
    }
    
    /**
    *function return factory stored at key $key.
    *@access public
    *@static
    *@param string $key
    *@return mixed
    */
    public function get($key)
    {
        return self::$factories[$key];
    }
}
