<?php
/**
*Student Controller class resides in this class.
*
*@author Mukarram Ishaq
*/
namespace App\Controllers;

use Core\Controllers\BaseController;
use Core\Request;
use Core\Models\ModelFactory;
use Core\Controllers\Traits\CRUD;
use Core\Log;
use Core\Views\View;
/**
*StudentController Class.
*
*StudentController handles all the routes of CRUD operations 
*relating to crud
*/
class StudentController extends BaseController
{
    use CRUD;

    public function __construct($model)
    {
        parent::__construct($model);
    }


}
