<?php
namespace Core\Exceptions;

use Throwable;

/**
 * class FileNotFoundException
 * @package Core\Exceptions
 */
class FileNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}