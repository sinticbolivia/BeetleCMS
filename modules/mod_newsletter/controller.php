<?php
class LT_ControllerNewsletter extends SB_Controller
{
	public function task_default()
	{
	}
	public function task_subscribe()
	{
		$ajax = SB_Request::getInt('ajax');
		$data = SB_Request::getVars(array(
			'int:list_id',
			'name',
			'firstname',
			'lastname',
			'email',
			'source'
		));
		if( isset($data['name']) && !empty(trim($data['name'])) )
		{
			$parts = explode(' ', trim($data['name']));
			if( count($parts) == 4 )
			{
				$data['firstname'] = "{$parts[0]} {$parts[1]}";
				$data['lastname'] = "{$parts[2]} {$parts[3]}";
			}
			elseif( count($parts) == 3 )
			{
				$data['firstname'] = "{$parts[0]}";
				$data['lastname'] = "{$parts[1]} {$parts[2]}";
			}
			elseif( count($parts) == 2 )
			{
				$data['firstname'] = "{$parts[0]}";
				$data['lastname'] = "{$parts[1]}";
			}
			else
			{
				$data['firstname'] = $data['name'];
				$data['lastname'] = "";
			}
		}
		unset($data['name']);
		if( !$data['list_id'] )
		{
			$msg = __('You need to set the list identifier', 'newsletter');
			if( $ajax )
			{
				sb_response_json(array('status' => 'error', 'error' => $msg));
			}
			SB_MessagesStack::AddMessage($msg, 'error');
			return false;
		}
		if( !$data['email'] )
		{
			$msg = __('The customer email is empty or invalid', 'newsletter');
			if( $ajax )
			{
				sb_response_json(array('status' => 'error', 'error' => $msg));
			}
			SB_MessagesStack::AddMessage($msg, 'error');
			return false;
		}
		
		$table = SB_DbTable::GetTable('newsletter_customers', 1);
		$customer = $table->Search(null, array(), array('email' => $data['email']));
		if( $customer )
		{
			$msg = __('The customer email already exists.', 'newsletter');
			if( $ajax )
			{
				sb_response_json(array('status' => 'error', 'error' => $msg));
			}
			SB_MessagesStack::AddMessage($msg, 'error');
			return false;
		}
		$data['creation_date'] = date('Y-m-d H:i:s');
		$id = $this->dbh->Insert('newsletter_customers', $data);
		$msg = __('The customer has been registered into list.', 'newsletter');
		if( $ajax )
		{
			sb_response_json(array('status' => 'ok', 'message' => $msg, 'customer_id' => $id));
		}
		SB_MessagesStack::AddMessage($msg, 'success');
	}
	/**
	 * Process the newsletter queues
	 * @return  
	 */
	public function task_npq()
	{
		die();
		ini_set('display_errors', 1);error_reporting(E_ALL);
		//lt_mail('marce_nickya@yahoo.es', 'rest', 'hole');
		//var_dump(function_exists('mail'));die();
		//##set the email sending limit
		$sending_limit 	= 10;
		//$table 			= SB_DbTable::GetTable('newsletter_queues', 1);
		//$subscribers 	= $table->GetRows($sending_limit, 0, array());
		$query = "SELECT q.*,c.firstname,c.lastname,c.email ".
					"FROM newsletter_queues q, newsletter_customers c ".
					"WHERE 1 = 1 ".
					"AND q.customer_id = c.id " .
					"AND c.status = 'enabled' " .
					"AND q.status = 'pending' " .
					"ORDER BY q.creation_date ASC";
		$subscribers = $this->dbh->FetchResults($query);
		foreach($subscribers as $sub)
		{
			//##check the notification type
			if( $sub->type == 'new_article' )
			{
				$article = new LT_Article((int)$sub->data);
				if( !$article->content_id )
					continue;
				print "Sending email to {$sub->email}<br/>\n";
				//##include the email template	
				ob_start();
				include MOD_NEWSLETTER_DIR . SB_DS . 'templates' . SB_DS . 'email' . SB_DS . 'new-content.php';
				$html = ob_get_clean();
				$subject = __("A new contect has been published", 'newsletter');
				$headers = array('type' => 'Content-type: text/html', 
								'from'	=> sprintf("From: %s <no-reply@newsletter.com>", SITE_TITLE)
				);
				lt_mail($sub->email, $subject, $html, $headers);
				//##update queue status
				/*
				$this->dbh->Update('newsletter_queues', 
									array('status' => 'sent', 'sent_date' => date('Y-m-d H:i:s')),
									array('id' => $sub->id)
				);
				*/
			}
		}
		die('Newsletter processed');
	}
}