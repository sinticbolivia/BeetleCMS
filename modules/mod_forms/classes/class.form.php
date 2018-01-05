<?php
require_once 'class.fields.php';
/**
 * @class	LT_Form
 * 
 * @property int 	$form_id
 * @property string $title
 * @property string $description
 * @property string	$email
 * @property string $status
 * @property string $creation_date
 * @proterty LT_FormFields	userFields;
 */
class LT_Form extends SB_ORMObject
{
	protected $filled = null;
	protected $userFields;
	protected $isAjax = false;
	/**
	 * 
	 * @param string $id
	 */
	public function __construct($id = null)
	{
		parent::__construct();
		if( $id )
			$this->GetDbData($id);
	}
	public function GetDbData($id)
	{
		$dbh = SB_Factory::getDbh();
		$query = "SELECT * FROM forms WHERE form_id = $id LIMIT 1";
		if( !$dbh->Query($query) )
		{
			return false;
		}
		$this->_dbData = $dbh->FetchRow();
		return true;
	}
	public function SetDbData($data)
	{
		$this->_dbData = $data;
	}
	public function Send($data)
	{
		/*
		$headers = array(
				'subject'		=> "Subject: {$data['subject']}",
				'from' 			=> "From: \"%s %s\" <%s>",
				'reply_to'		=> "Reply-To: {$data['sender_email']}", 
				'content_type' 	=> 'Content-type: text/html; charset=utf-8',
				'x_mailer' 		=> 'X-Mailer: little-cms'
		);
		$headers['from']	= sprintf($headers['from'], $data['sender_first_name'], $data['sender_last_name'], $data['sender_email']);
		*/
		$data['form_id']		= $this->form_id;
		$data['data']			= json_encode($data['data']);
		$data['creation_date']	= date('Y-m-d H:i:s');
		//##insert entry
		//$this->dbh->Insert('form_entries', $data);
		ob_start();
		require_once dirname(dirname(__FILE__)) . SB_DS . 'emails' . SB_DS . 'contact.php';
		$email = ob_get_clean();
		sb_include_module_helper('forms');
		$mailer = LT_HelperForms::GetMailerInstance();
		$mailer->addAddress($this->email);
		$mailer->isHTML(true);
		$mailer->From 		= FORMS_EMAIL_FROM;//$data['sender_email'];
		$mailer->FromName	= sprintf("%s %s", $data['sender_first_name'], $data['sender_last_name']);
		$mailer->addReplyTo($data['sender_email'], $mailer->FromName);
		$mailer->Subject	= $data['subject'];
		$mailer->Body 		= "Mensaje enviado por el Usuario: {$data['sender_username']}<br/>".
								"Formulario: $this->title <br/><br/><br/>" .
								"$email<br/>";
		//$mailer->AltBody	= strip_tags(str_replace("<br/>", "\n", $email));
		
		if( isset($data['attachment']) && file_exists($data['attachment']) )
			$mailer->addAttachment($data['attachment']);
		$res = $mailer->send();
		//print_r($data);
		//var_dump($res);die($mailer->ErrorInfo);
		return $res ? true : $mailer->ErrorInfo;
		//return mail($form->email, $data['subject'], $email, implode("\r\n", $headers));
	}
	public function GetFormFile()
	{
		define('MOD_FORMS_SHOW_IT', 1);
		$base_dir 	= MOD_FORMS_DIR . SB_DS . 'forms';
		$file 		= MOD_FORMS_DIR . SB_DS . 'views' . SB_DS . 'form.php';
		if( $this->form_file && file_exists($base_dir . SB_DS . $this->form_file) )
		{
			return $base_dir . SB_DS . $this->form_file;
		}
		return $file;
	}
	public function GetFormClass()
	{
		$class = require_once $this->GetFormFile();
		return $class;
	}
	/**
	 * Check if the form has a custom file
	 * 
	 * @return mixed filepath|null
	 */
	public function UseFile()
	{
		if( $this->form_file && is_file(BASEPATH . $this->form_file) )
		{
			return BASEPATH . $this->form_file;
		}
		return null;
	}
	/**
	 * Get form fields
	 * 
	 * @return  array
	 */
	public function GetFields()
	{
		return json_decode($this->fields);
	}
	/**
	 * Fill Fields from request and validate them
	 * 
	 * @return  array Filled fields
	 */
	public function FillFields()
	{
		$fields 		= $this->GetFields();
		$this->isAjax 	= SB_Request::getInt('ajax');
		foreach($fields as $i => &$field)
		{
			if( $field->type == 'button' )
			{
				unset($fields[$i]);
				continue;
			}
			if( $value = SB_Request::getVar($field->name) )
			{
				$field->value = $value;
			}
			unset($field->subtype);
			if( $field->type == 'hidden' )
			{
				$field->label = $field->name;
			}
		
		}
		$this->userFields = new LT_FormFields($fields);
		return $this->userFields;
	}
	public function SaveEntry()
	{
		$data = array(
			'form_id'		=> $this->form_id,
			'customer'		=> '',
			'email'			=> '',
			'subject'		=> '',
			'message'		=> '',
			'data'			=> json_encode($this->userFields->baseFields),
			'creation_date'	=> date('Y-m-d H:i:s')
		);
		$id = $this->dbh->Insert('form_entries', $data);
		
		return $id;
	}
	public function SendNotify()
	{
		sb_include_module_helper('forms');
		ob_start();
		require_once dirname(dirname(__FILE__)) . SB_DS . 'emails' . SB_DS . 'contact.php';
		$email = ob_get_clean();
		$subject = $this->subject ? $this->subject : 
									sprintf(__('New entry for "%s" form received', 'forms'), $this->title);//$data['subject'];
		$message = __('Hello Admin', 'forms') . '<br/><br/>'.
					sprintf(__('You have a new form entry for "%s"', 'forms'), $this->title) . '<br/><br/>'.
					__('Find the details below', 'forms') . '<br/><br/>';
		foreach($this->userFields->baseFields as $f)
		{
			$value = strip_tags( str_replace(array("\n", "\r\n"), '<br/>', $f->value), '<br/>' );
			$message .= "{$f->label}: $value<br/>";
		}
		$message .= '<br/><br/>';
		$message .= __('Regards', 'forms');;
		
		/*
		if( defined('FORMS_USE_SMTP_SERVER') && FORMS_USE_SMTP_SERVER )
		{
			$mailer = LT_HelperForms::GetMailerInstance();
			$mailer->addAddress($this->email);
			$mailer->isHTML(true);
			$mailer->From 		= $this->userFields->GetEmail();//$data['sender_email'];
			$mailer->FromName	= SITE_TITLE;
			$mailer->addReplyTo($this->userFields->GetEmail(), '');
			$mailer->Subject	= $subject;
			$mailer->Body 		= $message;
			
			//$mailer->AltBody	= strip_tags(str_replace("<br/>", "\n", $email));
			
			if( isset($data['attachment']) && file_exists($data['attachment']) )
				$mailer->addAttachment($data['attachment']);
			if( !($res = $mailer->send()) )
				$res = $mailer->ErrorInfo;
		}
		else
		{
			*/
			$headers = array(
				//'from'		=> sprintf("From: %s <%s>", SITE_TITLE, $this->userFields->GetEmail()),
				"Reply-to: " . $this->userFields->GetEmail(),
				"type"		=> "Content-type: text/html"
			);
			$res = lt_mail($this->email, $subject, $message, $headers);
		//}
		//print_r($data);
		//var_dump($res);die($mailer->ErrorInfo);
		return $res;
	}
	public function Redirect()
	{
		$redirect = $this->redirect ? $this->redirect : 
					isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : SB_Route::_('/');
		$message = $this->success_message ? $this->success_message : __('Your form has been sent', 'forms');
		if( $this->isAjax )
		{
			sb_response_json(array(
				'status'	=> 'ok',
				'message'	=> $message
			));
		}
		SB_MessagesStack::AddMessage($message, 'success');
		sb_redirect($redirect);
	}
	public function GetDbEntries()
	{
		if( !$this->form_id )
			return array();
		return SB_DbTable::GetTable('form_entries', 1)->GetRows(-1, 0, array('form_id' => $this->form_id));
	}
	public function Render()
	{
		if( $file = $this->UseFile() )
		{
			var_dump($file);
			include $file;
		}
		elseif( $this->template )
		{
			$this->RenderTemplate();
		}
		else
		{
			?>
			<form action="<?php print SB_Route::_('/'); ?>" method="post">
				<input type="hidden" id="mod" name="mod" value="forms" />
				<input type="hidden" id="task" name="task" value="send" />
				<input type="hidden" id="fid" name="fid" value="<?php print $this->form_id ?>" />
				<?php SB_Module::do_action_ref('forms_before_fields', $this); ?>
				<?php print $this->html ?>
				<?php SB_Module::do_action_ref('forms_after_fields', $this); ?>
			</form>
			<?php
		}
		
	}
	public function RenderTemplate()
	{
		$form 			= str_replace('{form_action}', SB_Route::_('/'), $this->template);
		$form_fields 	= array();
		//##set fields index
		foreach($this->GetFields() as $index => $f)
		{
			$form_fields[$f->name] = $f;
		} 
		//print_r($form_fields);
		if( !preg_match_all('/.*\{(\w+)\s+(\w+=["|\']?.*["|\']?)\s*\}.*/iU', $form, $matches) )
			print $form;
		foreach($matches[0] as $index => $placeholder)
		{
			$field_html = '';
			$type = $matches[1][$index];
			$args = !empty($matches[2][$index]) ? $this->ParseArgs($matches[2][$index]) : array();
			if( $args['name'] == 'module' || $args['name'] == 'task' || $args['name'] == 'form_id' )
			{
				if( $args['name'] == 'form_id' )
				{
					$field_html = "<input type=\"hidden\" id=\"fid\" name=\"fid\" value=\"{$this->form_id}\" />";
				}
				elseif( $args['name'] == 'module' )
				{
					$field_html = "<input type=\"hidden\" name=\"mod\" value=\"forms\" />";
				}
				elseif( $args['name'] == 'task' )
				{
					$value = $args['name'] == 'module' ? 'forms' : 'send';
					$field_html = "<input type=\"hidden\" name=\"task\" value=\"send\" />";
				}
			}
			else
			{
				$the_field = isset($form_fields[$args['name']]) ? $form_fields[$args['name']] : null;
				if( !$the_field ) continue;
				if( $the_field->type == 'text' || $the_field->type == 'checkbox' || $the_field->type == 'radio' )
				{
					ob_start();
					?>
					<div class="fb-text form-group field-<?php print $the_field->name ?>">
						<label for="<?php print $the_field->name ?>" class="fb-text-label">
							<?php print strip_tags($the_field->label)?>
							<?php if( (int)@$the_field->required == 1): ?>
							<span class="fb-required">*</span>
							<?php endif; ?>
						</label>
						<input class="<?php print $the_field->className ?>" 
							name="<?php print $the_field->name ?>" id="<?php print $the_field->name ?>" 
							<?php if( (int)@$the_field->required == 1): ?>
							required="required" 
							<?php endif; ?>
							aria-required="true" type="<?php print $the_field->subtype ?>" />
					</div>
					<?php
					$field_html = ob_get_clean();
				}
				elseif( $the_field->type == 'select' )
				{
					ob_start();
					?>
					<div class="fb-select form-group field-<?php print $the_field->name ?>">
						<label for="<?php print $the_field->name ?>" class="fb-select-label">
							<?php print strip_tags($the_field->label) ?>
						</label>
						<select class="<?php print $the_field->className ?>" name="<?php print $the_field->name ?>" 
							id="<?php print $the_field->name ?>">
							<?php foreach($the_field->values as $val): ?>
							<option value="<?php print $val->value ?>" <?php print (int)@$val->selected == 1 ? 'selected' : '';?>>
								<?php print $val->label ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php
					$field_html = ob_get_clean();
				}
				elseif( $the_field->type == 'textarea' )
				{
					ob_start();
					?>
					
						<div class="fb-textarea form-group field-<?php print $the_field->name ?>">
							<label for="<?php print $the_field->name ?>" class="fb-textarea-label">
								<?php print strip_tags($the_field->label) ?>
								<?php if( (int)@$the_field->required == 1): ?>
								<span class="fb-required">*</span>
								<?php endif; ?>
							</label>
							<textarea type="textarea" class="<?php print $the_field->className ?>" name="<?php print $the_field->name ?>" 
								id="<?php print $the_field->name ?>" 
								<?php if( (int)@$the_field->required == 1): ?>
								required="required" aria-required="true"
								<?php endif; ?>
								></textarea>
						</div>
					
					<?php
					$field_html = ob_get_clean();
				}
				elseif( $the_field->type == 'button' )
				{
					ob_start();
					?>
					<div class="fb-button form-group field-<?php print $the_field->name ?>">
						<button type="<?php print $the_field->subtype ?>" class="<?php print $the_field->className ?>" 
							name="<?php print $the_field->name ?>" style="<?php print $the_field->style ?>" 
							id="<?php print $the_field->name ?>">
							<?php print strip_tags($the_field->label) ?>
						</button>
					</div>
					<?php
					$field_html = ob_get_clean();
				}
			}
			$form = str_replace($placeholder, $field_html, $form);
		}
		print $form;
	}
	protected function ParseArgs($str)
	{
		$parts = array_map('trim', explode(' ', $str));
		$args = array();
		foreach($parts as $p)
		{
			$key = $p;
			$value = '';
			if( strstr($p, '=') )
				list($key, $value) = explode('=', $p);
			$args[$key] = str_replace(array('"', "'"), '', $value);
		}
		return $args;
	}
}
