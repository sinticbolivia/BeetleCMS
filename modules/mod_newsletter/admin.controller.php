<?php
class LT_AdminControllerNewsletter extends SB_Controller
{
	public function task_default()
	{
		$table = new LT_TableList('newsletter_customers', 'id', 'newsletter');
		$table->SetColumns(array(
			'id' 			=> array('db_col' => 'id', 'label' => 'ID'),
			'list_id' 		=> array('db_col' => 'list_id', 'label' => __('List', 'newsletter'), 'show' => false),
			'firstname' 	=> array('db_col' => 'firstname', 'label' => __('Firstname', 'newsletter')),
			'lastname' 		=> array('db_col' => 'lastname', 'label' => __('Lastname', 'newsletter')),
			'email' 		=> array('db_col' => 'email', 'label' => __('Email', 'newsletter')),
			'status' 		=> array('db_col' => 'status', 'label' => __('Status', 'newsletter')),
			'creation_date' => array('db_col' => 'creation_date', 'label' => __('Creation Date', 'newsletter')),
		));
		$table->Fill();
		sb_set_view_var('table', $table);
	}
}