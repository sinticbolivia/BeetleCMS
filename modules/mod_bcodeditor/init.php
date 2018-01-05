<?php
define('MOD_BCODEDITOR_DIR', dirname(__FILE__));
define('MOD_BCODEDITOR_URL', MODULES_URL . '/' . basename(MOD_BCODEDITOR_DIR));
class Beetle_Mod_Codeditor
{
	public function __construct()
	{
		$this->AddActions();
	}
	protected function AddActions()
	{
		if( lt_is_admin() )
		{
			SB_Module::add_action('template_buttons', array($this, 'action_template_buttons'));
		}
	}
	public function action_template_buttons($template_data, $type)
	{
		$link = SB_Route::_('index.php?mod=bcodeditor&edit=' . basename($template_data['template_dir']) . '&type=' . $type);
		?>
		<a href="<?php print $link ?>" class="btn btn-primary btn-xs">
			<?php _e('Edit Code', 'bce'); ?>
		</a>
		<?php
	}
}
new Beetle_Mod_Codeditor();