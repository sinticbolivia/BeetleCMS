<?php
class LT_AdminControllerForms extends SB_Controller
{
	public function task_default()
	{
		$order_by		= SB_Request::getString('order_by', 'creation_date');
		$order			= SB_Request::getString('order', 'desc');	
		$page			= SB_Request::getInt('page', 1);
		$limit			= SB_Request::getInt('limit', defined('ITEMS_PER_PAGE') ? ITEMS_PER_PAGE : 25);
		
		
		$dbh = SB_Factory::getDbh();
		$dbh->Query("SELECT COUNT(*) AS total_rows FROM forms");
		$total_rows 	= $dbh->FetchRow()->total_rows;
		$total_pages 	= ceil($total_rows / $limit);
		$offset 		= ($page <= 1) ? 0 : ($page - 1) * $limit;
		$query = "SELECT * FROM forms WHERE status = 'enabled' ORDER BY $order_by $order LIMIT $offset, $limit";
		$dbh->Query($query);
		$new_order = $order == 'asc' ? 'desc' : 'asc';
		sb_set_view_var('forms', $dbh->FetchResults());
		sb_set_view_var('form_files', LT_HelperForms::GetFormFiles());
		sb_set_view_var('id_order_link', SB_Route::_('index.php?mod=forms&order_by=form_id&order='.$new_order));
		sb_set_view_var('title_order_link', SB_Route::_('index.php?mod=forms&order_by=title&order='.$new_order));
		sb_set_view_var('email_order_link', SB_Route::_('index.php?mod=forms&order_by=email&order='.$new_order));
		sb_set_view_var('date_order_link', SB_Route::_('index.php?mod=forms&order_by=creation_date&order='.$new_order));
	}
	public function task_new()
	{
		sb_set_view_var('form_files', LT_HelperForms::GetFormFiles());
		sb_set_view_var('title', __('New Form', 'forms'));
	}
	public function task_edit()
	{
		$id = SB_Request::getInt('id');
		$query = "SELECT * FROM forms WHERE form_id = $id LIMIT 1";
		$dbh = SB_Factory::getDbh();
		if ( !$dbh->Query($query) )
		{
			SB_MessagesStack::AddMessage(SBText::_('El formulario no existe'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=forms'));
		}
		$form = $dbh->FetchRow();
		sb_set_view('new');
		sb_set_view_var('title', __('Edit form', 'forms'));
		sb_set_view_var('form', $form);
		sb_set_view_var('form_files', LT_HelperForms::GetFormFiles());
	}
	public function task_save()
	{
		$id 			= SB_Request::getInt('id');
		$title 			= SB_Request::getString('title');
		$description	= SB_Request::getString('description');
		$email			= SB_Request::getString('email');
		$form_file		= SB_Request::getString('form_file');
		$form_data		= SB_Request::getString('form_data');
		$html			= SB_Request::getString('html');
		$template		= SB_Request::getString('template');
		$subject		= SB_Request::getString('subject');
		$message		= SB_Request::getString('message');
		$status			= 'enabled';
		$data = compact('title', 'description', 'email', 'status', 'form_file', 'subject', 'message');
		if( !empty($form_data) )
		{
			$data['fields'] = base64_decode($form_data);
		}
		if( !empty($html) )
		{
			$data['html']	= base64_decode($html);
		}
		$data['template'] = base64_decode($template);
		//print_r($data);die();
		//print_r($data);die();
		$dbh = SB_Factory::getDbh();
		if( !$id )
		{
			$data['creation_date'] = date('Y-m-d H:i:s');
			$id = $dbh->Insert('forms', $data);
			SB_MessagesStack::AddMessage(__('The new form has been created'), 'success');
			sb_redirect(SB_Route::_('index.php?mod=forms'));
		}
		else
		{
			$dbh->Update('forms', $data, array('form_id' => $id));
			SB_MessagesStack::AddMessage(SBText::_('The form has been updated'), 'success');
			sb_redirect(SB_Route::_('index.php?mod=forms&view=edit&id='.$id));
		}
	}
	public function task_delete()
	{
		$id = SB_Request::getInt('id');
		$query = "DELETE FROM forms WHERE form_id = $id LIMIT 1";
		$dbh = SB_Factory::getDbh();
		$dbh->Query($query);
		SB_MessagesStack::AddMessage(SBText::_('El formulario fue borrado correctamente.'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=forms'));
	}
	public function task_entries()
	{
		require_once MOD_FORMS_DIR . SB_DS . 'classes' . SB_DS . 'class.form.php';
		$id = SB_Request::getInt('id');
		$form = new LT_Form($id);
		$entries = $form->GetDbEntries();
		$table = (object)array(
			'headings'	=> array(),
			'rows'		=> array()
		);
		if( count($entries) )
		{
			$data = json_decode($entries[0]->data);
			foreach($data as $j => $d)
			{
				if( !isset($d->label) || empty($d->label) ) continue;
				$table->headings[] = $d->label;
			}
		}
		foreach($entries as $i => $e)
		{
			$data = json_decode($e->data);
			if( !$data ) continue;
			//print_r($data);
			$row = array('creation_date' => sb_format_datetime($e->creation_date));
			foreach($table->headings as $h)
			{
				foreach($data as $d)
				{
					if( !isset($d->label) ) continue;
					if( $d->label == $h )
					{
						$row[$h] = $d->value;
					}
					
				}
				
			}
			$table->rows[] = (object)$row;
		}
		//print_r($table);
		sb_set_view_var('table', $table);
	}
}