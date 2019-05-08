<?php
/**
*This file contains Request Class.
*
*request.php file contains the definition of
*\Core\Request class
*
*@author Mukarram Ishaq
*/

namespace Core;

use Core\Utils\URLParser;

/**
 * Class Request
 * @package Core
 */
class Request
{
	/**
	*$url contains requested URI.
	*
	*$url is a string containing requested url.
	*
	*@access public
	*@var string $url
	*/
	private $url = null;

    /**
     *$url contains requested URI.
     *
     *$url is a string containing requested url.
     *
     *@access public
     *@var string $url
     */
    private $actualURL = null;

	/**
	*$method contains method of the request
	* in a string.
	*
	*@var string $method
	*@access public
	*/
	private $method = null;

	/**
    *$input contains data sent through
    * GET or POST request.
    *
    *@var array $input
    *@access public
    */
    private $input = null;

	/**
	*Constructor of Request Class.
	*
	*@access public
	*@param void
	*/
	public function __construct($completeURL, $url, $method, $input)
	{
	    $this->actualURL = $completeURL;
        $this->url = $url;
        $this->method = $method;
        $this->input = $input;
	}

	/**
     * @param string $url
     * @access public
     * @return void
     */
	public function setURL($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $url
     * @access public
     * @return void
     */
    public function setActualURL($url)
    {
        $this->actualURL = $url;
    }

    /**
     * @param $method
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    /**
     * @param array $input
     */
    public function setInput(array $input)
    {
        $this->input = $input;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getActualURL()
    {
        return $this->actualURL;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

}
