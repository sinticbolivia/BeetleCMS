<?php
class LT_ControllerForms extends SB_Controller
{
	public function task_default()
	{
		
	}
	public function task_form()
	{
		$id = SB_Request::getInt('id');
		$dbh = SB_Factory::getDbh();
		$query = "SELECT * FROM forms WHERE form_id = $id LIMIT 1";
		if( !$dbh->Query($query) )
		{
			SB_MessagesStack::AddMessage(SBText::_('El formulario no existe', 'forms'));
		} 
		else 
		{
			global $form, $form_file;
			$form = new LT_Form($id);
			$form->SetDbData($this->dbh->FetchRow());
			$form_file = SB_Module::do_action('forms_form_file', $form->GetFormFile(), $form);
			if( strstr('views/form.php') )
			{
				sb_set_view_var('form', $form);
			}
			else
			{
				function __function_form_view($view_file, $mod)
				{
					global $form, $form_file;
					return $form_file;
				}
				SB_Module::add_action('view_template', '__function_form_view');
			}
		}
		
	}
	public function task_send()
	{
		$id 			= SB_Request::getInt('fid');
		$ajax			= SB_Request::getInt('ajax');
		if( !$id )
		{
			$error = __('The form identifier is invalid', 'forms');
			if( $ajax )
				sb_response_json(array('status' => 'error', 'error' => $error));
			SB_MessagesStack::AddMessage($error, 'error');
			SB_Session::setVar('form_data', $_POST);
			sb_redirect($_SERVER['HTTP_REFERER']);
			return false;
		}
		/*
		if( empty($subject) )
		{
			SB_MessagesStack::AddMessage(SBText::_('Debe ingresar un asunto', 'forms'), 'error');
			SB_Session::setVar('form_data', $data);
			sb_redirect($_SERVER['HTTP_REFERER']);
			return false;
		}
		$forms_captcha = SB_Session::getVar('forms_captcha');
		if( $forms_captcha != $user_captcha )
		{
			SB_MessagesStack::AddMessage(SBText::_('Texto de seguridad invalido', 'forms'), 'error');
			SB_Session::setVar('form_data', $data);
			sb_redirect($_SERVER['HTTP_REFERER']);
			return false;
		}
		*/
		
		require_once dirname(__FILE__) . SB_DS . 'classes' . SB_DS . 'class.form.php';
		$form = new LT_Form($id);
		//print_r($form->GetFields());
		if( !$form->FillFields() )
		{
			$error = __('There is errors on your form submit, please double check.', 'forms');
			if( $ajax )
				sb_response_json(array('status' => 'error', 'error' => $error));
			SB_MessagesStack::AddMessage($error, 'error');
			SB_Session::setVar('form_data', $_POST);
			sb_redirect($_SERVER['HTTP_REFERER']);
			return false;
		}
		
		$form->SaveEntry();
		$form->SendNotify();
		$form->Redirect();
		sb_response_json(array('status' => 'ok', 'message' => __('Your message has been sent', 'forms')));
		/*
		try
		{
			if( !$form->form_id )
			{
				throw new Exception(__('The form does not exists', 'forms'), 'error');
				SB_Session::setVar('form_data', $_POST);
				//sb_redirect($_SERVER['HTTP_REFERER']);
				return false;
			}
			$form_class = $form->GetFormClass();
			if( !class_exists($form_class) )
			{
				throw new Exception(sprintf(__('The form class "%s" does not exists', 'forms'), $form_class), 'error');
				SB_Session::setVar('form_data', $_POST);
				//sb_redirect($_SERVER['HTTP_REFERER']);
				return false;
			}
			$the_form = new $form_class($form);
			$the_form->Validate();
			$the_form->Send();
		}
		catch(Exception $e)
		{
			if( $ajax )
			{
				sb_response_json(array('status' => 'error', 'error' => $e->getMessage()));
			}
			
			SB_MessagesStack::AddMessage($e->getMessage(), 'error');
			SB_Session::setVar('form_data', $_POST);
			sb_redirect($_SERVER['HTTP_REFERER']);
			return false;
		}
		*/
		/*
		if( sb_is_user_logged_in() )
		{
			$user = sb_get_current_user();
			$data['data']['sender_first_name'] 	= $user->first_name;
			$data['data']['sender_last_name']	= $user->last_name;
			$data['data']['sender_email']		= $user->email;
			$data['data']['sender_username']	= $user->username;
		}
		if( isset($_FILES['the_file']) && $_FILES['the_file']['size'] > 0 )
		{
			$tmp_attachment	= TEMP_DIR . SB_DS . $_FILES['the_file']['name'];
			move_uploaded_file($_FILES['the_file']['tmp_name'], $tmp_attachment);
			$data['attachment']	= $tmp_attachment;
		}
		$res = $form->Send($data);
		if( $res !== true )
		{
			SB_MessagesStack::AddMessage(__('Ocurrio un error al enviar el mensaje.', 'forms') . '<br/>' . $res, 'error');
			return false;
		}
		sb_set_view('thankyou');
		SB_Session::unsetVar('forms_captcha');
		*/
	}
}