<?php
namespace Core\Exceptions;

use Throwable;

/**
 * Class InvalidArgumentException
 * @package Core\Exceptions
 */
class InvalidArgumentException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}