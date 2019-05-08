<?php
namespace Core\Exceptions;

use Throwable;

/**
 * Class InvalidModelException
 * @package Core\Exceptions
 */
class InvalidModelException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}