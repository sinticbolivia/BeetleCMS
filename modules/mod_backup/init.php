<?php
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
								'<span class="glyphicon glyphicon-hdd"></span>'.SB_Text::_('Backups'), 
								SB_Route::_('index.php?mod=backup'), 
								'lt-backups-menu', 'manage_db_backup', 10);
	}
}
new LT_Module_Backup();