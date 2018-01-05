<?php
$filename = basename($_SERVER['REQUEST_URI']);
//if( preg_match('/\.(map|jpg|jpeg|css|js|gif|png|txt)$/', $filename, $matches) )
if( preg_match('/\.(map)$/', $filename, $matches) )
	return false;
/*
error_log(__FILE__);
error_log('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
error_log('QUERY_STRING' .  $_SERVER['QUERY_STRING']);
*/
$base_dir = dirname(__FILE__);
//$cfg_file = file_exists($base_dir . DIRECTORY_SEPARATOR . 'config.php') ? 'config.php' : 'config-min.php';
$cfg_file = defined('LT_INSTALL') ? 'config-min.php' : 'config.php';
if( defined('CFG_FILE') )
{
	$cfg_file = CFG_FILE;
}
if( !file_exists($base_dir . DIRECTORY_SEPARATOR . $cfg_file) )
{
	header('Location: install/index.php');die();
}
	
require_once $base_dir . DIRECTORY_SEPARATOR . $cfg_file;

if( DEVELOPMENT == 1 )
{
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
function sb_namespace2path($namespace)
{
    $folder = str_replace(array('SinticBolivia\\SBFramework\\Modules', 'SinticBolivia\\BeetleCMS\\Modules', '\\'), 
                    array(MODULES_DIR . SB_DS . 'mod_', MODULES_DIR . SB_DS . 'mod_', SB_DS), $namespace);
    //var_dump($class_name);
    //var_dump($folder);
    list($prefix, $owner) = explode('_/', $folder);
    $file = $prefix . '_' . lcfirst($owner) . '.php';
    
    return $file;
}
//##define autoload function
spl_autoload_register(function($class_name)
{   
    $file = '';
    //##check for sbframework classes
    //$default_class = BASEPATH . SB_DS . 'include' . SB_DS . 'Classes' . SB_DS . $class_name . '.php';
    /*
    if( is_file($default_class) )
    {
        require_once $default_class;
        var_dump('DEFAULT CLASS: ', $default_class);
        return true;
    }
    */
    if( stristr($class_name, '\\Modules') )
    {
        $file = sb_namespace2path($class_name);
        //var_dump('FILE:', $file);
    }
    else
    {
        $file .= BASEPATH . SB_DS . 'include' . str_replace(array('SinticBolivia\\SBFramework', 'SinticBolivia\\BeetleCMS', '\\'), 
                                                        array('', '', SB_DS), $class_name) . '.php';
    }
    //var_dump($file);
    if( !is_file($file) )
    {
        return false;
    }
    //var_dump($file);
    require_once $file;
    return true;
});
/*
$classes = array(
		'class.object.php',
		'class.globals.php',
		'class.orm-object.php',
		'class.session.php',
		'class.request.php',
		'class.messages-stack.php',
		'class.module.php',
		'class.factory.php',
		'class.meta.php',
		'class.language.php',
		'class.route.php',
		'class.menu.php',
		'class.shortcode.php',
		'class.application.php',
		'class.controller.php',
		'class.model.php',
		'class.html-doc.php',
		'class.html-builder.php',
		'class.compress.php',
		'class.cron.php',
		'class.attachment.php',
		'class.table-list.php',
		'class.widget.php',
		'class.theme.php'
);
$db_drivers = array(
		'database.class.php',
		'database.interface.php',
		//##database tables
		'classes/class.table.php'
);
*/
use SinticBolivia\SBFramework\Classes\SB_Module;
use SinticBolivia\SBFramework\Classes\SB_Request;// as SB_Request;
use SinticBolivia\SBFramework\Classes\SB_Session;// as SB_Session;
use SinticBolivia\SBFramework\Classes\SB_Factory;// as SB_Factory;
use SinticBolivia\SBFramework\Classes\SB_Menu;
use SinticBolivia\SBFramework\Classes\SB_Route;

//##include database drivers
if( DB_TYPE == 'mysql' )
{
    //$db_drivers[] = 'database.mysql.php';
    //use SinticBolivia\SBFramework\Database\SB_MySQL as SB_MySQL;
}
	
if( DB_TYPE == 'sqlite' || DB_TYPE == 'sqlite3' )
{
    //$db_drivers[] = 'database.sqlite3.php';
    //use SinticBolivia\SBFramework\Database\SB_Sqlite3 as SB_Sqlite3;
}
if( DB_TYPE == 'postgres' )
{
    //$db_drivers[] = 'database.postgres.php';
    //use SinticBolivia\SBFramework\Database\SB_Sqlite3 as SB_Sqlite3;
}
/*
foreach($classes as $class_file)
{
	require_once INCLUDE_DIR . SB_DS . 'classes' . SB_DS . $class_file;
}
foreach($db_drivers as $drv)
{
	require_once INCLUDE_DIR . SB_DS . 'database' . SB_DS . $drv;
}
*/
require_once INCLUDE_DIR . SB_DS . 'functions.php';
require_once INCLUDE_DIR . SB_DS . 'formatting.php';

SB_Session::start();
SB_Request::Start();
$app = null;
if( $rapp = SB_Request::getString('ltapp') )
{
	if( (int)$rapp === -1 )
	{
		SB_Session::unsetVar('ltapp');
	}
	else
	{
		$app = $rapp;
		SB_Session::setVar('ltapp', $app);
	}
	 
}
elseif( SB_Session::getVar('ltapp') )
{
	$app = SB_Session::getVar('ltapp');
}
elseif( defined('APP_NAME') )
{
	$app = APP_NAME;
}

//$app = SB_Application::GetApplication(defined('APP_NAME') ? APP_NAME : null);
$app = SB_Factory::getApplication($app);
set_error_handler(function($errno, $error, $error_file, $error_line, $context)
{
	$app = SB_Factory::getApplication();
		
	$app->Log(array('code' => $errno, 'error' => $error, 'file' => $error_file, 'line' => $error_line, 'context' => $context));
	//var_dump($errno);
	if( $errno != E_NOTICE && $errno != E_USER_WARNING && $errno != E_USER_NOTICE )
	{
		lt_die($error . '<br/><div style="height:200px;overflow:auto;"><code><pre>' . print_r(debug_backtrace(), 1) . '</pre></code></div>');
	}
}, E_ALL);
$app->Load();

if( defined('LT_INSTALL') )
{
	return true;
}
$dbh = SB_Factory::getDbh();
//##start and propagate settings
sb_initialize_settings();
$app->LoadLanguage();
//##load modules
$app->LoadModules();
$app->StartRewrite();
$app->Start();
//ini_set('post_max_size', '128M');
//ini_set('upload_max_filesize', '128M');
//setlocale(LC_NUMERIC, 'en_GB.utf-8');
//error_log(__FILE__);
//var_dump($_GET['rule']);