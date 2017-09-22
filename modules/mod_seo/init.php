<?php
define('MOD_SEO_DIR', dirname(__FILE__));

class LT_ModSEO
{
	public function __construct()
	{
		$this->AddActions();
	}
	protected function AddActions()
	{
		if( lt_is_admin() )
		{
			SB_Module::add_action('content_data', array($this, 'action_content_data'));
			SB_Module::add_action('product_tabs', array($this, 'action_product_tabs'));
			SB_Module::add_action('product_tabs_content', array($this, 'action_product_tabs_content'));
		}
	}
	public function action_content_data($content)
	{
		require_once 'html' . SB_DS . 'box-seo.php';
	}
	public function action_product_tabs()
	{
		?>
		<li><a href="#seo" data-toggle="tab"><?php _e('SEO Features', 'seo'); ?></a></li>
		<?php
	}
	public function action_product_tabs_content($obj)
	{
		
		?>
		<div id="seo" class="tab-pane">
			<?php require_once 'html' . SB_DS . 'box-seo.php'; ?>
		</div>
		<?php
	}
}
new LT_ModSEO();