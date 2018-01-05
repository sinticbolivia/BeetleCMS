<?php
define('MOD_NEWSLETTER_DIR', dirname(__FILE__));
define('MOD_NEWSLETTER_URL', MODULES_URL . '/' . basename(MOD_NEWSLETTER_DIR));
class LT_ModNewsletter
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
			SB_Module::add_action('save_article', array($this, 'action_save_article'));
		}
	}
	public function action_admin_menu()
	{
		SB_Menu::addMenuPage(__('Newsletter', 'newlsetter'), SB_Route::_('index.php?mod=newsletter'), 
								'menu-newsletter',
								'see-menu-newsletter');
	}
	public function action_save_article($id, $updated)
	{
		global $dbh;
		
		//##check if article id is valid and it was updated
		if( $id && $updated )
			return true;
		
		//##get whole newsletter subscribers
		$table 			= SB_DbTable::GetTable('newsletter_customers', 1);
		$subscribers 	= $table->GetRows(-1);
		$queue = array();
		//##build a queue
		foreach($subscribers as $sub)
		{
			$queue[] = array(
				'type'			=> 'new_article',
				'list_id'		=> 0,
				'customer_id'	=> $sub->id,
				'data'			=> $id,
				'status'		=> 'pending',
				'creation_date'	=> date('Y-m-d H:i:s')
			);
		}
		$dbh->InsertBulk('newsletter_queues', $queue);
	}
}
$mod_newsletter = new LT_ModNewsletter();