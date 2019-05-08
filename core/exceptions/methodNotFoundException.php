<?php
namespace Core\Exceptions;

use Throwable;

/**
 * Class MethodNotFoundException
 * @package Core\Exceptions
 */
class MethodNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}