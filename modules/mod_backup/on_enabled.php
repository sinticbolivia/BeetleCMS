<?php
$dbh 		= SB_Factory::getDbh();
SB_Language::loadLanguage(LANGUAGE, 'backup', dirname(__FILE__) . SB_DS . 'locale');
$permissions = array(
		array('group' => 'backup', 'permission' => 'manage_db_backup', 'label'	=> __('Manage Database Backup', 'backup')),
		array('group' => 'backup', 'permission' => 'create_db_backup', 'label'	=> __('Create Database Backup', 'backup')),
		array('group' => 'backup', 'permission' => 'restore_db_backup', 'label'	=> __('Restore Database Backup', 'backup')),
		array('group' => 'backup', 'permission' => 'backup_files', 'label'	=> __('Backup files', 'backup')),
);
sb_add_permissions($permissions);