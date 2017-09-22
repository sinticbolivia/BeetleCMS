<?php
SB_Language::loadLanguage(LANGUAGE, 'slider', dirname(__FILE__) . SB_DS . 'locale');
$permissions = array(
		array('group' => 'slider', 'permission' => 'manage_slider', 'label'	=> SB_Text::_('Manage Slider', 'slider')),
		array('group' => 'slider', 'permission' => 'create_slider', 'label'	=> SB_Text::_('Create slider', 'slider')),
		array('group' => 'slider', 'permission' => 'edit_slider', 'label'	=> SB_Text::_('Edit slider', 'slider')),
		array('group' => 'slider', 'permission' => 'delete_slider', 'label'	=> SB_Text::_('Delete slider', 'slider')),
);
sb_add_permissions($permissions);