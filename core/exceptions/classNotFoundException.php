<?php
namespace Core\Exceptions;

use Throwable;

/**
 * Class ClassNotFoundException
 * @package Core\Exceptions
 */
class ClassNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}