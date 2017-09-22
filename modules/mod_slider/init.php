<?php
define('MOD_SLIDER_DIR', dirname(__FILE__));
define('MOD_SLIDER_URL', MODULES_URL . '/' . basename(MOD_SLIDER_DIR));
define('MOD_SLIDER_UPLOADS_DIR', UPLOADS_DIR . SB_DS . 'slides');
define('MOD_SLIDER_UPLOADS_URL', UPLOADS_URL . '/slides');
require_once MOD_SLIDER_DIR . SB_DS . 'functions.php';
class LT_ImageSlider
{
	public function __construct()
	{
		$this->AddActions();
	}
	protected function AddActions()
	{
		if( lt_is_admin() )
		{
			SB_Module::add_action('admin_menu', array($this, 'action_admin_menu'));
		}
		
	}
	public function action_admin_menu()
	{
		SB_Menu::addMenuChild('menu-management', __('Sliders', 'slider'), SB_Route::_('index.php?mod=slider'), 'menu-sliders', 'manage_slider');
	}
}
new LT_ImageSlider();