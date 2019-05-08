<?php
/**
 * contains View Class.
 * @author Mukarram Ishaq
 */
namespace Core\Views;

use Core\Exceptions\FileNotFound;

/**
 * Class View
 * @package Core\Views
 */
class View
{
    public static $parent_directory_of_views = null;
    public static $fileExtension = null;


    public function render($viewFileName, array $data = [])
    {
        $file = self::$parent_directory_of_views.$viewFileName.self::$fileExtension;
        //first of all check file named $viewFileName exists or not
        if (!file_exists($file)) {
//            \Core\Log::debug("$viewFileName file not found", __FILE__, __LINE__);
            throw new FileNotFoundException("$viewFileName not found!");
        }
        //include file
        require($file);
    }
}