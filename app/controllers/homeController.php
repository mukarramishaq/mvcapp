<?php
/**
 *Home Controller class resides in this class.
 *
 *@author Mukarram Ishaq
 */
namespace App\Controllers;

use Core\Controllers\BaseController;
use Core\Request;
/**
 *HomeController Class.
 *
 *HomeController handles all the routes of CRUD operations
 *relating to crud
 */
class HomeController extends BaseController
{

    public function __construct($model)
    {
        parent::__construct($model);
    }

    /**
     *Index is the default action of this controller
     *@param void
     *@return void
     */
    public function index()
    {
//        \Core\Log::debug("I am in home hahah.");
        $this->view->render("home");
    }

    /**
     * @param Request $request
     */
    public function notFound(Request $request)
    {
        $this->view->render("errors/404", ['url'=>$request->getInput()['url']]);
    }
}
