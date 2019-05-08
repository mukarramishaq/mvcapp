<?php
namespace Core\Exceptions;

use Throwable;

/**
 * Class InvalidControllerException
 * @package Core\Exceptions
 */
class InvalidControllerException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}