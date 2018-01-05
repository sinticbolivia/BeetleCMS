<?php
class LT_HelperForms
{
	/**
	 * 
	 * @param bool $debug 
	 * @return  PHPMailer
	 */
	public static function GetMailerInstance($debug = false)
	{
		sb_include_lib('PHPMailer/PHPMailerAutoload.php');
		$mailer 		= new PHPMailer($debug);
		$use_smtp 		= defined('FORMS_USE_SMTP_SERVER') ? (int)FORMS_USE_SMTP_SERVER : 0;
		$smtp_server 	= defined('FORMS_SMTP_SERVER') ? trim(FORMS_SMTP_SERVER) : null;
		$smtp_port		= defined('FORMS_SMTP_SERVER_PORT') ? trim(FORMS_SMTP_SERVER_PORT) : null;
		$smtp_username 	= defined('FORMS_SMTP_USERNAME') ? trim(FORMS_SMTP_USERNAME) : null;
		$smtp_password	= defined('FORMS_SMTP_PASSWORD') ? trim(FORMS_SMTP_PASSWORD) : null;
		$secure			= defined('FORMS_SMTP_SECURE') ? trim(FORMS_SMTP_SECURE) : null;
		$mailer->CharSet = 'utf-8';
		if( $use_smtp )
		{
			$mailer->isSMTP();
			$mailer->SMTPDebug = $debug;
		}
		if( !empty($smtp_server) )
		{
			$mailer->Host		= $smtp_server;// . ':' . $smtp_port;
			$mailer->Port		= $smtp_port;
		}
		if( !empty($smtp_username) )
		{
			$mailer->SMTPAuth 	= true;
			$mailer->Username	= $smtp_username;
			$mailer->Password	= $smtp_password;
			$mailer->AuthType	= defined('FORMS_SMTP_AUTH_TYPE') ? FORMS_SMTP_AUTH_TYPE : 'LOGIN';
		}
		if( !empty($secure) )
		{
			$mailer->SMTPSecure = $secure;//'ssl';//tls';
		}
		//else
		{
			//var_dump(function_exists('mail'));
			//$mailer->isSendmail();
			//$mailer->isMail();
			//$mailer->isSMTP();
		}
		return $mailer;
	}
	public static function GetFormFiles()
	{
		$base_dir = MOD_FORMS_DIR . SB_DS . 'forms';
		$files = array();
		/*
		if( function_exists('glob') )
		{
			$files = array_map('basename', glob($base_dir . SB_DS . '*.php'));
		}
		else
		{*/
			//var_dump($base_dir);
			$dh = opendir($base_dir);
			while( ($file = readdir($dh)) !== false )
			{
				//var_dump($file);
				if( $file{0} == '.' ) continue;
				if( strstr($file, '.php') )
					$files[] = array('file' => str_replace(BASEPATH, '', $base_dir. SB_DS . $file), 'name' => $file);
			}
			closedir($dh);
		//}
		
		$files = SB_Module::do_action('forms_files', $files);
		return $files;
	}
}