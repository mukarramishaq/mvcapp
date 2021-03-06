<?php
/**
 * baseController file contains body
 * of baseControlller Class.
 * @author Mukarram Ishaq
 */
namespace Core\Controllers;

use Core\Controllers\ControllerInterface;
use Core\Request;
use Core\Exceptions\MethodNotFoundException;
use Core\Views\View;

/**
 * Class BaseController
 * @package Core\Controllers
 */
class BaseController implements ControllerInterface
{
    /**
     * @var \Core\Models\BaseModel|null
     */
    protected $model = null;
    protected $view = null;
    
    public function __construct($model)
    {
        $this->model = $model;
        $this->view = new View();
    }

    /**
     * @return mixed|void
     */
    public function beforeAction()
    {

    }

    /**
     * @return mixed|void
     */
    public function afterAction()
    {

    }

    /**
     * @param Request $request
     * @param array $filters
     */
    public function validate(Request $request, array $filters)
    {

    }

    /**
     * @param Request $request
     * @param array $otherParams
     * @return mixed|void
     * @throws MethodNotFoundException
     */
    public function handle(\Core\Request $request, array $otherParams)
    {
        $actionName = $otherParams['action'];
        //check if action does not exist
        if (!method_exists($this, $actionName)) {
           throw new MethodNotFoundException("$actionName is not found in ", __CLASS__);
        }
        //prepare parameters
        $parameters = array_merge([$request],$otherParams['url_params']);

        //call beforeAction method here
        $this->beforeAction();
        //call controller function asynchronously
        call_user_func_array([$this, $actionName], $parameters);
        //call afterAction method here
        $this->afterAction();
    }
}
