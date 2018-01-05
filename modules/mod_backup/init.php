<?php
namespace SinticBolivia\SBFramework\Modules\Backup;
use SinticBolivia\SBFramework\Classes\SB_Language;
use SinticBolivia\SBFramework\Classes\SB_Module;
use SinticBolivia\SBFramework\Classes\SB_Menu;
use SinticBolivia\SBFramework\Classes\SB_Route;

define('MOD_BACKUP_DIR', dirname(__FILE__));
class LT_Module_Backup
{
	public function __construct()
	{
		SB_Language::loadLanguage(LANGUAGE, 'backup', MOD_BACKUP_DIR . SB_DS . 'locale');
		$this->AddActions();
		ini_set('upload_max_filesize', '20M');
		
	}
	protected function AddActions()
	{
		SB_Module::add_action('admin_menu', array($this, 'action_admin_menu'));
	}
	public function action_admin_menu()
	{
		SB_Menu::addMenuChild('menu-management', 
								'<span class="glyphicon glyphicon-hdd"></span>'.__('Backups', 'backup'), 
								SB_Route::_('index.php?mod=backup'), 
								'lt-backups-menu', 'manage_db_backup', 10);
	}
}
new LT_Module_Backup();