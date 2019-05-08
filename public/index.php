<?php
/**
*Single Entry Point of the app.
*
*This file handles all the requests as every request first
*reach at its door then they are forwarded after doing 
*processing.
*
*@author Mukarram Ishaq
*/

/**
*root directory constant.
*@global string ROOT.
*@name ROOT.
*/
define('ROOT', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

/*-----------  load configs  -------------*/
require_once(ROOT.'core/config.php');

/*----------
 - since this is single entry point then autoload should be here
 - here autoload only load class files having specific
 - namespaces
 -----------*/
require_once(ROOT.'autoload.php');

/*------------- all use statements will come here  ----------- */
use Core\Router;
use Core\RequestMaker;
use Core\Utils\URLParser;
use Core\Views\View;
use Core\FactoryRegistry;
use Core\Models\Database\DatabaseFactory;
use Core\Models\ModelFactory;
use Core\Controllers\ControllerFactory;
/*----------  initialized the router resources  ----------- */
Router::init();

/*----------  load all routes  ----------------- */
require_once(ROOT.'app/routes.php');

/*---------- set up views configs --------------*/
View::$parent_directory_of_views = $config['parent_directory_of_views'];
View::$fileExtension = $config['view_file_extention'];

/*---------- setup factory registry service ---------*/
$registry = new FactoryRegistry();
$registry->add('database', new DatabaseFactory($config));
$registry->add('model', new ModelFactory(FactoryRegistry::get('database')));
$registry->add('controller', new ControllerFactory());

/*----------  prepare the coming request  ------------- */
RequestMaker::setURLParser(new URLParser());
RequestMaker::setURLPrefix($config['url_prefix_extension']);
$req = RequestMaker::make();

/*---------  handover the request object to the router  ------------- */
Router::handle($req, $registry);


