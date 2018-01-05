<?php
/**
 * @package SBFramework
 */

/**
 * The base application case to initializa any web application
 * 
 * @author SinticBolivia <info@sinticbolivia.net>
 * @version 1.0.0
 */
namespace SinticBolivia\SBFramework\Classes;

class SB_Application extends SB_Object
{
	protected	$defaultModules = array(
			'mod_modules',
			'mod_users',
			'mod_settings'
	);
	protected	$controller;
	protected 	$view;
	protected	$module;
    public      $moduleNamespace;
	protected	$htmlDocument;
	protected 	$templateHtml;
	
	private function __construct()
	{
		$this->htmlDocument = new SB_HtmlDoc();
	}
	public function Load()
	{
		if( !is_dir(UPLOADS_DIR) )
			mkdir(UPLOADS_DIR);
		if( !is_dir(TEMP_DIR) )
			mkdir(TEMP_DIR);
		if( !is_dir(APPLICATIONS_DIR) )
			mkdir(APPLICATIONS_DIR);		
	}
	public function StartRewrite()
	{
		if( !defined('LT_REWRITE') || !constant('LT_REWRITE') )
			return;
		$the_path = SB_Request::$path;
		//var_dump($the_path);
		if( strstr($the_path, '?') && strstr($the_path, '=') )
		{
			return;
		}
		
		$def = array();
		$routes = SB_Module::do_action('rewrite_routes', $def);
		//print_r($routes);
		$the_route = null;
		foreach($routes as $match => $route)
		{
			//var_dump($match, $the_path);
			if( preg_match($match, $the_path, $matches) )
			{
				//print_r($matches);
				//$the_route = preg_replace($match, '', $route);
				//var_dump($route);
				$the_route = $route;
				for($i = 1; $i < count($matches); $i++)
				{
					$the_route = str_replace("$$i", $matches[$i], $the_route);
				}
				break;
			}
		}
		//var_dump($the_route);
		if( !$the_route )
			return false;
		SB_Route::SetRoute($the_route, SB_Request::$requestMethod);
	}
	public function LoadModules()
	{
		//##include default hooks
		sb_include('default-hooks.php', 'file');
		//##load modules
		$modules = SB_Module::getEnabledModules();
		$modules = array_merge($modules, $this->defaultModules);
		//print_r($modules);
		//##load the users module before
		require_once MODULES_DIR . SB_DS . 'mod_users' . SB_DS . 'init.php';
		foreach($modules as $module)
		{
			//var_dump($module);
			if( file_exists(MODULES_DIR . SB_DS . $module . SB_DS . 'init.php') )
			{
				require_once MODULES_DIR . SB_DS . $module . SB_DS . 'init.php';
			}
		}
		SB_Module::do_action('modules_loaded');
	}
	public function Start()
	{
		SB_Module::do_action('before_init');
		//##check for backend template functions.php file
		$backend_template_dir = sb_get_template_dir('backend');
		if( file_exists($backend_template_dir . SB_DS . 'functions.php') )
			require_once $backend_template_dir . SB_DS . 'functions.php';
		//##check for frontend template functions.php file
		$template_dir = sb_get_template_dir('frontend');
		if( file_exists($template_dir . SB_DS . 'functions.php') )
			require_once $template_dir . SB_DS . 'functions.php';
		SB_Module::do_action('template_loaded');
		//##get current environment template and set constants
		$template_dir = sb_get_template_dir();
		//##check and execute cron jobs
		$this->CronJobs();
		if( SB_Request::getString('mod') == null && SB_Request::getString('tpl_file') == null && !defined('LT_ADMIN') )
		{
			define('LT_FRONTPAGE', 1);
		}
		SB_Module::do_action('init');
	}
	/**
	 * Load default language for application
	 * 
	 * @return  
	 */
	public function LoadLanguage()
	{
		$r_lang		= SB_Request::getString('lang');
		if( $r_lang )
		{
			define('LANGUAGE', $r_lang);
			SB_Session::setVar('lang', $r_lang);
		}
		elseif( $r_lang = SB_Session::getVar('lang') )
		{
			define('LANGUAGE', $r_lang);
		}
		else
		{
			define('LANGUAGE', defined('SYS_LANGUAGE') ? SYS_LANGUAGE : 'en_US');
		}
		$lang_code 	= defined('LANGUAGE') ? LANGUAGE : 'en_US';
		$domain 	= 'default';
		$path 		= BASEPATH . SB_DS . 'locale';
		defined('LANGUAGE') or define('LANGUAGE', $lang_code);
        
        if( !function_exists('textdomain') )
            SB_Language::UsePOMO();
		SB_Language::loadLanguage($lang_code, $domain, $path);
		//setlocale(LC_NUMERIC, 'en_GB.utf-8');
		//setlocale(LC_NUMERIC, 'en_GB');
		//putenv('LC_NUMERIC=en_GB.utf-8');
	}
	/**
	 * Get the module controller instance
	 * 
	 * @return SB_Controller
	 */
	protected function InstanceController()
	{
		
	}
	public function ProcessModule($mod)
	{	
		if( !$mod )
		{
			//##create a dummy controller
			$this->controller = new SB_Controller();
			return false;
		}
		$this->module	= $mod;
		SB_Request::setVar('mod', $mod);
		
		$dbh 			= SB_Factory::getDbh();
		$_task 			= SB_Request::getTask();
		$ctrl			= SB_Request::getString('ctrl');
		$view 			= SB_Request::getString('view', 'default');
		
        if( !defined('LT_ADMIN') )
		{
			sb_include('template-functions.php', 'file');
		}
        if( !$_task && $view )
		{
			$_task = $view;
		}
		if( strstr('.', $view) )
		{
			list(,$view) = explode('.', $view);
		}
        
		
		if( $_task )
		{
			SB_Module::do_action('before_process_module');
			$task               = $_task;
            if( !$this->IncludeModule($mod, $task) )
                $this->IncludeOldModule ($mod, $task);
            if( strstr($_task, '.') )
            {
                list($ctrl, $task) 	= explode('.', $_task);
            }
            $method = 'task_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $task);
            
			//##set the module
            $this->controller->mod = $mod;
            if( !is_callable(array($this->controller, $method)) )
            {
                return false;
            }
			call_user_func(array($this->controller, $method));
			SB_Module::do_action('after_process_module');
		}
	}
    public function IncludeModule($mod, $task)
    {
        //var_dump($task);
        $module_dir		= MODULES_DIR . SB_DS . 'mod_'.$mod;
        //##build module namespace
        $this->moduleNamespace = $namespace          = 'SinticBolivia\\SBFramework\\Modules\\' . ucfirst($mod);
        $controller_class   = '';
        if( strstr($task, '.') )
        {
            list($_class_prefix, $_task) = explode('.', $task);
            $namespace .= '\\Controllers\\';
            $controller_class = $namespace . ucfirst($_class_prefix) . 'Controller';
        }
        else
        {
            $controller_class   = $namespace . (defined('LT_ADMIN') ? '\\Admin' : '\\') . 'Controller';
        }
        
        
        $controller_file    = sb_namespace2path($controller_class); //str_replace('\\', SB_DS, $namespace) . (defined('LT_ADMIN') ? '/Admin' : '') . 'Controller';
        //$controller_path    = dirname($controller_file);
        //var_dump($controller_file);
        if( !is_file($controller_file) /*&& !is_file($controller_path . SB_DS . $controller_file)*/ )
            return false;
        try
        {
            $this->controller   = new $controller_class($this->htmlDocument);
            define('MODULE_DIR', $module_dir);
            define('MODULE_URL', MODULES_URL . '/mod_'.$mod);
        }
        catch(Exception $e)
        {
            return false;
        }
        return true;
    }
    public function IncludeOldModule($mod, $task)
    {
        $module_dir		= MODULES_DIR . SB_DS . 'mod_'.$mod;
        $class_prefix 	= defined('LT_ADMIN') ? 'LT_AdminController' : 'LT_Controller';
        $file_prefix	= defined('LT_ADMIN') ? 'admin.' : '';
        if( !is_dir($module_dir) )
        {
            die('The module "'.$mod.'" does not exists.');
        }
        define('MODULE_DIR', $module_dir);
        define('MODULE_URL', MODULES_URL . '/mod_'.$mod);
        $controllers_dir 	= $module_dir . SB_DS . 'controllers';
        $controller_file 	= $module_dir . SB_DS . $file_prefix . 'controller.php';
        $controller_class	= $class_prefix . ucfirst(strtolower($mod));
        if( strstr($task, '.') )
        {
            list($ctrl, $task) 	= explode('.', $task);
            $controller_file 	= $controllers_dir . SB_DS . $file_prefix . 'controller.' . $ctrl . '.php';
            $controller_class	.= ucfirst($ctrl);   
        }
        if( !is_file($controller_file) )
        {
            return false;
        }
        
        require_once $controller_file;
        $this->controller = new $controller_class($this->htmlDocument);
        
        return true;
    }
	/**
	 * Return the current controller
	 * @return SB_Controller
	 */
	public function GetController()
	{
		return $this->controller;
	}
	public function ProcessTemplate($tpl_file = 'index.php')
	{
		global $view_vars;
	
		$view 			= SB_Request::getString('view', 'default');
		
		SB_Module::do_action('before_process_template');
		$template_dir 	= sb_get_template_dir();
		$template_url	= sb_get_template_url();
		$mod			= SB_Request::getString('mod', null);
		
		//##check if template directory exists
		if( !$template_dir || !is_dir($template_dir) )
		{
			require_ONCE INCLUDE_DIR . SB_DS . 'template-functions.php';
			lt_template_fallback();
			return true;
		}
		if( defined('LT_ADMIN') )
		{
			if( function_exists('sb_build_admin_menu') )
				sb_build_admin_menu();
		}
		else 
		{
				
		}
		if( !$mod )
		{
			$mod = defined('LT_ADMIN') ? 'dashboard' : 'content';
		}
		
		if( !strstr($tpl_file, '.php') )
			$tpl_file .= '.php';
		if( lt_is_frontpage() && file_exists($template_dir . SB_DS . 'frontpage.php') )
		{
			$tpl_file = 'frontpage.php';
		}
		else
		{
		}
		$tpl_file = SB_Module::do_action('template_file', $tpl_file);
		$this->htmlDocument->AddBodyClass('tpl-' . str_replace('.php', '', $tpl_file));
		//extract(isset($view_vars[$view]) ? $view_vars[$view] : array());
		$vars = $this->GetController() ? $this->GetController()->viewVars : array();
		count($vars) && extract($vars);
		ob_start();
		require_once $template_dir. SB_DS . $tpl_file;
		$this->templateHtml = ob_get_clean();
	}
	public function ShowTemplate()
	{
		print $this->templateHtml;
		sb_end();
	}
	/**
	 * Execute all cron jobs
	 */
	protected function CronJobs()
	{
		return true;
		if( defined('LT_CRON') )
			return false;
		
		if( !function_exists('fsockopen') )
		{
			$this->Log('Enable to created sockets');
			return false;
		}
		$errno = '';
		$errstr = '';
		set_time_limit(0);
		$url = SB_Route::_('cron.php', 'frontend');
		$url = str_replace(array('http://','https://'), '', $url);
		$url = str_replace($_SERVER['HTTP_HOST'], '', $url);
		$fp = fsockopen($_SERVER['HTTP_HOST'], $port = 80, $errno, $errstr, $conn_timeout = 30);
		if (!$fp)
		{
			echo "$errstr ($errno)<br />\n";
			return false;
		}
		$out = "GET $url HTTP/1.1\r\n";
		$out .= "Host: {$_SERVER['HTTP_HOST']}\r\n";
		$out .= "Connection: Close\r\n\r\n";
		stream_set_blocking($fp, false);
		stream_set_timeout($fp, $rw_timeout = 86400);
		fwrite($fp, $out);
		//$this->Log($out);
		return $fp;
	} 
	public static function GetApplication($app = null)
	{
		static $the_app;
		if( $the_app )
			return $the_app;
		if( !$app )
		{
			$the_app = new SB_Application();
			return $the_app;
		}
	
		$the_app_file = APPLICATIONS_DIR . SB_DS . 'app.' . $app . '.php';
		if( !file_exists($the_app_file) )
			throw new Exception('The application ' . ucfirst($app) . ' does not exists.');
		require_once $the_app_file;
		$the_app_class = 'SB_Application' . ucfirst(preg_replace('/[^a-zA-Z]/', '', $app));
		if( !class_exists($the_app_class) )
			throw new Exception('The application class "'.$the_app_class.'" does not exists');
		$the_app = new $the_app_class();
		return $the_app;
	}
	public function GetLanguages()
	{
		return SB_Module::do_action('lt_languages', array(
				'es_ES'	=> __('Spanish', 'lt'),
				'en_US'	=> __('English', 'lt'),
		));
	}
	/**
	 * Log a thing into application log file
	 * @param mixed $str 
	 * @return  
	 */
	public function Log($str)
	{
		$fh = is_file(LOG_FILE) ? fopen(LOG_FILE, 'a+') : fopen(LOG_FILE, 'w+');
		fwrite($fh, sprintf("[%s]:\n%s\n", date('Y-m-d H:i:s'), print_r($str, 1)));
		fclose($fh);
	}
}
