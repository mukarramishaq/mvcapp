<?php
/**
*uRLParser file contains URLParser class definition.
*
*uRLParser file defines URLParser class body which contains 
*different custom url parsing functions 
*
*@version 1.0
*@author Mukarram Ishaq
*/

namespace Core\Utils;
/**
*URLParser Class contains different url parsing functions.
*
*All the functions in the URLParser class are static which receive
*url string as parameter and return according to its taste.
*
*@access public
*/
class URLParser
{

    /**
     * Remove a predefined prefix from the url.
     *
     * @param $url
     * @param $prefix
     * @return mixed
     */
	public function removePrefixFromURL($url, $prefix)
    {
            return str_replace($prefix, '', $url);
    }

    /**
     * remove forward slashes from both sides of the url
     *
     * @param $url
     * @return string
     */
    public function stripSlashes($url)
    {
        return ltrim($url, "/");
    }
}