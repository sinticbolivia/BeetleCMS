<?php
class LT_FormPrinceSeatingEnquiry extends SB_ORMObject
{
	protected $formData;
	
	public function __construct($form)
	{
		parent::__construct();
		$this->formData = $form;
		
	}
	public function GetDbData($id){}
	public function SetDbData($data){}
	public function Validate()
	{
		$ajax = SB_Request::getInt('ajax');
		$data	 = SB_Request::getVars(array(
			'customer',
			'email',
			'message'
		));
		if( empty($data['customer']) )
		{
			throw new Exception(__('You need to type a customer name', 'ps'));
		}
		if( empty($data['email']) )
		{
			throw new Exception(__('You need to type an email address', 'ps'));
		}
		if( empty($data['message']) )
		{
			throw new Exception(__('You need to type a message', 'ps'));
		}
		
		
	}
	public function Send()
	{
		$ajax = SB_Request::getInt('ajax');
		$data	 = SB_Request::getVars(array(
			'customer',
			'email',
			'message'
		));
		$data['form_id']	= $this->formData->form_id;
		$data['data']		= SB_Request::getVar('data', array());
		
		$subject 	= $this->formData->title;
		$to			= $this->formData->email;
		$body		= sprintf("%s<br/><br/>", __("Hello Administrator", 'ps')).
					sprintf(__('You have a new %s request, find details below.<br/><br/>', 'ps'), $this->formData->title).
					sprintf(__('Customer: %s<br/>', 'ps'), $data['customer']).
					sprintf(__('Email: %s<br/>', 'ps'), $data['email']).
					sprintf(__('Phone: %s<br/>', 'ps'), $data['data']['phone']).
					sprintf(__('Project Name: %s<br/>', 'ps'), $data['data']['project_name']).
					sprintf(__('Quantity: %s<br/>', 'ps'), $data['data']['qty']).
					sprintf(__('Time Frame: %s<br/>', 'ps'), $data['data']['time_frame']).
					sprintf(__('Budget: %s<br/>', 'ps'), $data['data']['budget']).
					sprintf(__('Venue Type: %s<br/>', 'ps'), $data['data']['venue_type']).
					sprintf(__('Message:<br/>%s<br/>', 'ps'), $data['message']).
					'<br/>'.
					__('Regards,', 'ps');
		$headers = array(
			'Content-type: text/html',
			sprintf("From: %s <%s>", $data['customer'], $data['email'])
		);
		$res 			= lt_mail($to, $subject, $body, $headers);
		$dbh 			= SB_Factory::GetDbh();
		$data['data'] 	= json_encode($data['data']);
		$entry_id 		= $dbh->Insert('form_entries', $data);
		if( $ajax )
		{
			sb_response_json(array(
				'status' 	=> 'ok', 
				'message' 	=> __('Your message has been sent, we will contact you as soon as possible', 'ps'),
				'mail_res'	=> $res,
				'sent_to'	=> $to
			));
		}
	}
	public function GetHtml()
	{
		$instance_id = 'enquery_form_' . 1;
		ob_start();?>
		<div class="form-container">
			<form id="<?php print $instance_id; ?>" action="<?php print SB_Route::_('index.php'); ?>" method="post">
				<input type="hidden" name="mod" value="forms" />
				<input type="hidden" name="task" value="send" />
				<input type="hidden" name="ajax" value="1" />
				<input type="hidden" name="id" value="<?php print $this->formData->form_id; ?>" />
				<div class="row">
					<div class="col-sx-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="text" name="customer" value="" placeholder="<?php _e('Name', 'ps'); ?>" class="form-control" />
						</div>
					</div>
					<div class="col-sx-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="email" name="email" value="" placeholder="<?php _e('Email', 'ps'); ?>" class="form-control" />
						</div>
					</div>
					<div class="col-sx-12 col-sm-12 col-md-4">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="text" name="data[phone]" value="" placeholder="<?php _e('Phone', 'ps'); ?>" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="text" name="data[project_name]" value="" placeholder="<?php _e('Project Name', 'ps'); ?>" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 col-md-3">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="text" name="data[qty]" value="" placeholder="<?php _e('Qty', 'ps'); ?>" class="form-control" />
						</div>
					</div>
					<div class="col-sx-12 col-sm-12 col-md-3">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="text" name="data[time_frame]" value="" placeholder="<?php _e('Time Frame', 'ps'); ?>" class="form-control" />
						</div>
					</div>
					<div class="col-sx-12 col-sm-12 col-md-3">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<input type="text" name="data[budget]" value="" placeholder="<?php _e('Budget', 'ps'); ?>" class="form-control" />
						</div>
					</div>
					<div class="col-sx-12 col-sm-12 col-md-3">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<select name="data[venue_type]" class="form-control">
								<option value="-">-- venue type --</option>
								<option value="Hospitality">Hospitality</option>
								<option value="Government">Government</option>
								<option value="Restaurant">Restaurant</option>
								<option value="Educational Facility">Educational Facility</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label"><?php print ''; ?></label>
							<textarea name="message" placeholder="<?php _e('Message', 'ps'); ?>" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary"><?php _e('Submit', 'ps'); ?></button>
					</div>
				</div>
				<div class="form-group messages">
					
				</div>
			</form>
		</div>
		<script>
		jQuery('#<?php print $instance_id; ?>').submit(function()
		{
			var form	= this;
			var params = jQuery(this).serialize();
			jQuery(this).find('button[type=submit]').prop('disabled', true);
			jQuery(this).find('.messages:first').html('');
			jQuery.post(this.action, params, function(res)
			{
				jQuery(form).find('button[type=submit]').prop('disabled', false);
				if( res.status == 'ok' )
				{
					jQuery(form).find('.messages:first').html('<span class="alert alert-success">'+res.message+'</span>');
				}
				else
				{
					jQuery(form).find('.messages:first').html('<span class="alert alert-danger">'+res.error+'</span>');
				}
			});
			return false;
		});
		</script>
		<?php
		return ob_get_clean();
	}
}
return 'LT_FormPrinceSeatingEnquiry';