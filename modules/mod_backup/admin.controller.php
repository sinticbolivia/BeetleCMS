<?php
class LT_AdminControllerBackup extends SB_Controller
{
	public function task_default()
	{
		$dbh = SB_Factory::getDbh();
		$dbh->Query("SHOW TABLES");
		sb_set_view_var('tables', $dbh->FetchResults());
	}
	public function task_do_backup()
	{
		$tables = SB_Request::getVar('tables', array());
		$dbh = SB_Factory::getDbh();
		$dbh->Query("SHOW TABLES");
		$db_tables = array();
		foreach($dbh->FetchResults() as $t)
		{
			$db_tables[] = $t->{'Tables_in_'.DB_NAME};
		}
		$skip_tables = array_diff($db_tables, $tables);
		$ignore = '';
		foreach($skip_tables as $table)
		{
			$ignore .= sprintf("--ignore-table=%s.%s ", DB_NAME, $table);
		}
		$dump_file = TEMP_DIR . SB_DS . "database-dump.sql";
		$cmd = sprintf("/usr/bin/mysqldump -u %s -p%s \"%s\" %s > \"%s\"", DB_USER, DB_PASS, DB_NAME, $ignore, $dump_file);
		system($cmd);
		if( !file_exists($dump_file) )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('Ocurrio un error al realizar la copia de seguridad.'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=backup'));
		}
		$uploads_zip 	= TEMP_DIR . SB_DS . 'uploads.zip';
		$template_zip 	= TEMP_DIR . SB_DS . 'template.zip';
		if( SB_Request::getInt('backup_files') )
		{
			//##compress uploads folder
			$zip = new SB_Compress();
			$zip->DestinationFile = $uploads_zip;
			$zip->CompressDir(array(BASEPATH . SB_DS . 'uploads'));
			$zip->Save();
			/*
			//##compress template folder
			$zip = new SB_Compress();
			$zip->DestinationFile = $template_zip;
			$zip->CompressDir(array(TEMPLATES_DIR . SB_DS . 'default'));
			$zip->Save();
			*/
		}
		$backup_file = TEMP_DIR . SB_DS . sprintf("backup-cms-%s.zip", date('Y-m-d-H:i:s'));
		$zip = new SB_Compress();
		$zip->DestinationFile = $backup_file;
		$zip->CompressFiles(array($uploads_zip, /*$template_zip,*/ $dump_file));
		$zip->Save();
		
		//Download the database file
		header('Content-Description: File Transfer');
		//header('Content-Type: application/octet-stream');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename='.basename($backup_file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($backup_file));
		readfile($backup_file);
		//After download remove the file from server
		unlink($uploads_zip);
		unlink($template_zip);
		unlink($dump_file);
		unlink($backup_file);
		die();
	}
	public function task_restore_backup()
	{
		ob_start();
		//ini_set('display_errors', 0);error_reporting(0);
		if( !isset($_FILES['backup_file']) )
			sb_redirect(SB_Route::_('index.php?mod=backup'));
		if( $_FILES['backup_file']['error'] == UPLOAD_ERR_INI_SIZE )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('El archivo es demasiado grande, compruebe la configuracion de PHP.', 'backup'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=backup'));
		}
		if( $_FILES['backup_file']['size'] <= 0 )
		{
			SB_MessagesStack::AddMessage(SB_Text::_('Backup no valido', 'backup'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=backup'));
		}
		
		$backup_file = TEMP_DIR . SB_DS . $_FILES['backup_file']['name'];
		if( move_uploaded_file($_FILES['backup_file']['tmp_name'], $backup_file) )
		{
			$destination = TEMP_DIR . SB_DS . 'backup_restore';
			//##uncompress the backup file
			$zip = new SB_Compress();
			$zip->Decompress($backup_file, $destination);
			$sql_file 		= $destination . SB_DS . 'database-dump.sql';
			$template_file 	= $destination . SB_DS . 'template.zip';
			$uploads		= $destination . SB_DS . 'uploads.zip';
			if( file_exists($sql_file) )
			{
				$cmd = sprintf("mysql -u %s -p%s \"%s\" < \"%s\"", DB_USER, DB_PASS, DB_NAME, $sql_file);
				$res = system($cmd, $return_var);
				unlink($sql_file);
			}
			if( file_exists($template_file) )
			{
				$tpl_zip = new SB_Compress();
				$tpl_zip->Decompress($template_file, TEMPLATES_DIR);
				unlink($template_file);
			}
			if( file_exists($uploads) )
			{
				$up_zip = new SB_Compress();
				$up_zip->Decompress($uploads, BASEPATH);
				unlink($uploads);
			}
			rmdir($destination);
			SB_MessagesStack::AddMessage(SB_Text::_('Base de datos restaurada correctamente.'), 'success');
			sb_redirect(SB_Route::_('index.php?mod=backup'));
		}
		SB_MessagesStack::AddMessage(SB_Text::_('Ocurrio un error al restaurar la base de datos.'), 'error');
		sb_redirect(SB_Route::_('index.php?mod=backup'));
	}
}
