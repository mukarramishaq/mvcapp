<?php
/**
 * file contains CourseController Class.
 * @author Mukarram Ishaq
 */

namespace App\Controllers;

use Core\Controllers\BaseController;
use Core\Request;
use Core\Models\ModelFactory;
use Core\Controllers\Traits\CRUD;
use Core\Log;
use Core\Views\View;
/**
 * Class CourseController
 * @package App\Controllers
 */
class CourseController extends BaseController
{
    use CRUD;

    public function __construct($model)
    {
        parent::__construct($model);
    }
}
