<?php
/**
*Router file contain definition of Router Class.
*
*Router file defines the body of Router Class and its 
*necessary functions and attributes
*
*@author Mukarram Ishaq
*/
namespace Core;


use Core\Request;
use Core\Controllers\ControllerFactory;
use Core\Models\ModelFactory;
use Core\Exceptions\ClassNotFoundException;
use Core\Exceptions\InvalidControllerException;
/**
*Router Class.
*
*Router class contains attribute and methods.
*
*@access public
*@version 1.0
*@author Mukarram Ishaq
*/
class Router
{
    /**
    *$routes keeps all the routes and their information.
    *
    *$routes is an associative array which keeps information
    * of routes in a key values pairs.
    *
    *@var array $routes
    *@access protected
    *@static
    */
    protected static $routes = null;
    
    /**
    *init function initializes the resources.
    *
    *init function is a static function and it
    *initializes all the static resources in this
    *Router Class.
    *
    *@param void
    *@access public
    *@static
    *@return void
    */
    public static function init()
    {
        self::$routes = array();
    }

    /**
     * destroy function nullify the resources.
     *
     * destroy function is a static function and it
     * makes all the static resources in this Router
     * Class equal to null.
     *
     * @param void
     * @access public
     * @static
     * @return void
     */
    public static function destroy()
    {
        self::$routes = null;
    }

    /**
    *remember function will keep the route and its informations.
    *
    *remember function stores the route and its other information
    *like controller, action etc in the $routes array.
    *
    *@param string $route
    *@param array $handler
    *@access public
    *@static
    *@return void
    */
    public static function remember($route, array $handler)
    {
        //remove trailing or leading forward slashes
        $route = trim($route,"/");

        //if url params are given then count them too.
        if (isset($handler['url_params'])) {
            $handler['no_of_url_params'] = count($handler['url_params']);
        }
        //self::$gets[$route] = $handler;
        self::$routes[$route] = $handler;
    }


    /**
     * handle function will route will the request.
     *
     * handle function accepts object of Core\Request class
     * and will forward to its legit controller.
     *
     * @param \Core\Request $request
     * @param \Core\FactoryRegistry $factoryRegistry
     */
    public static function handle(Request $request, \Core\FactoryRegistry $factoryRegistry)
    {
        $requiredRouteName = self::determineRoute($request->getURL());
        if ($requiredRouteName != null) {
            //get handlersInfo of this route
            $handlersInfo = self::$routes[$requiredRouteName];
            //retrieve params which are part of the url
            $urlParams = self::determineParamsInTheRoute($requiredRouteName, $request->getURL());
            //if there is no url params
            if ($urlParams == null){
                $urlParams = array();
            }
            //create controllerFactory
            $controllerFactory = $factoryRegistry->get('controller');
            $controller = null;
            //create Model Factory
            $modelFactory = $factoryRegistry->get('model');
            $model = null;
            /*---------create model first--------*/
            try {
                $model = $modelFactory->createModel("\\App\\Models\\".ucfirst(str_replace("Controller", "", $handlersInfo['controller'])));
            } catch (ClassNotFoundException $e) {
            
            } catch (InvalidModelException $e) {
            
            }
            /*-----------now controller----------*/
            try {
                $controller = $controllerFactory->createController(
                '\\App\\Controllers\\'.$handlersInfo['controller'],
                   $model
                    );
                //handle request to the controller
                $controller->handle(
                    $request,
                    ['action'=>$handlersInfo['action'], 'url_params'=>$urlParams]
                );
            } catch (ClassNotFoundException $e) {
//                \Core\Log::debug($e, __FILE__, __LINE__);
            } catch (InvalidControllerException $e) {
//                \Core\Log::debug($e, __FILE__, __LINE__);
            }


        } else {
            //route to notFoundController or notFoundAction
            $notFoundURL = $GLOBALS['config']['url_prefix_extension'].$GLOBALS['config']['404_route'];
            header('Location: '.$notFoundURL."?url=".$request->getActualURL());
        }
    }

    /**
     * @access private
     * @static
     * @param string $url
     * @return string|null $requireRouteName
     */
    private static function determineRoute($url)
    {
        $routeNames = array_keys(self::$routes);
        $totalRoutes = count($routeNames);
        $requiredRouteName = null;
        $maxLengthMatched = 0;
        for ($i = 0, $j = $totalRoutes-1; $i < $totalRoutes && $j >= 0; $i++, $j--) {
            //when to end iteration
            if ($i > $j) {
                break;
            }

            //check from start
            $len = strlen($routeNames[$i]);
            if (strncmp($routeNames[$i], $url, $len) === 0) {
                //route found
                //if length matches of this route is greater
                //only then make it our required route
                if ($len > $maxLengthMatched) {
                    $maxLengthMatched = $len;
                    $requiredRouteName = $routeNames[$i];
                }
                //otherwise do nothing
            }

            //when to end iteration
            if ($i == $j) {
                break;
            }

            //check from end
            $len = strlen($routeNames[$j]);
            if (strncmp($routeNames[$j], $url, $len) === 0) {
                //route found
                //if length matches of this route is greater
                //only then make it our required route
                if ($len > $maxLengthMatched) {
                    $maxLengthMatched = $len;
                    $requiredRouteName = $routeNames[$j];
                }
                //otherwise do nothing
            }
        }
        return $requiredRouteName;
    }

    /**
     * @access private
     * @static
     * @param string $route
     * @param string $url
     * @return array|null
     */
    private function determineParamsInTheRoute($route, $url)
    {
        $handler = self::$routes[$route];
        //check this route contains no param
        if ($handler['no_of_url_params'] <= 0) {
            return null;
        }

        $params = explode('/', trim(str_replace($route, '', $url), '/'));
        return $params;
    }

}
