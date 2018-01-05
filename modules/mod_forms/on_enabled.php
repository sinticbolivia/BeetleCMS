<?php 
defined('BASEPATH') or die('Dont fuck with me buddy.');
SB_Module::RunSQL('forms');
$dbh = SB_Factory::getDbh();
$permissions = array(
		array('permission' => 'manage_forms', 'label'	=> SB_Text::_('Gestionar Formularios', 'forms')),
		array('permission' => 'create_form', 'label'	=> SB_Text::_('Crear formulario', 'forms')),
		array('permission' => 'edit_form', 'label'	=> SB_Text::_('Editar formulario','forms')),
		array('permission' => 'delete_form', 'label'	=> SB_Text::_('Borrar formulario', 'forms')),
);
$local_permissions = sb_get_permissions(false);
foreach($permissions as $perm)
{
	if( in_array($perm['permission'], $local_permissions) ) continue;
	$dbh->Insert('permissions', $perm);
}