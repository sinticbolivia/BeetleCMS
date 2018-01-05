<?php
define('MOD_FORMS_DIR', dirname(__FILE__));
define('MOD_FORMS_URL', MODULES_URL . '/' . basename(MOD_FORMS_DIR));
define('FORM_SHORTCODE_TPL', "[forms id=\"%d\"]");
require_once MOD_FORMS_DIR . SB_DS . 'helper.forms.php';
class LT_Forms
{
	public function __construct()
	{
		SB_Language::loadLanguage(LANGUAGE, 'forms', MOD_FORMS_DIR . SB_DS . 'locale');
		$this->AddActions();
		$this->AddShortcodes();
	}
	protected function AddActions()
	{
		if( defined('LT_ADMIN') )
		{
			SB_Module::add_action('admin_menu', array($this, 'action_admin_menu'));
			SB_Module::add_action("settings_tabs", array($this, 'action_settings_tabs'), 11);
			SB_Module::add_action("settings_tabs_content", array($this, 'action_settings_tabs_content'), 11);
		}
		
	}
	protected function AddShortcodes()
	{
		SB_Shortcode::AddShortcode('forms', array($this, 'shortcode_forms'));
	}
	public function action_admin_menu()
	{
		SB_Menu::addMenuChild('menu-content', '<span class="glyphicon glyphicon-tasks"></span> '.__('Forms', 'forms'), 
								SB_Route::_('index.php?mod=forms'), 'menu-forms', 'manage_forms');
	}
	public function shortcode_forms($args)
	{
		
		if( $data = SB_Session::getVar('form_data') )
		{
			foreach($data as $var => $value)
			{
				SB_Request::setVar($var, $value);
			}
			SB_Session::unsetVar('form_data');
		}
		require_once dirname(__FILE__) . SB_DS . 'classes' . SB_DS . 'class.form.php';
		$form = new LT_Form((int)$args['id']);
		if( !$form->form_id )
			return '';
		/*	
		$form_class = SB_Module::do_action('forms_form_class', $form->GetFormClass(), $form);
		
		if( !class_exists($form_class) )
			return '';
		$the_form = new $form_class($form);
		return $the_form->GetHtml();
		//ob_start();
		//require_once SB_Module::do_action('forms_form_file', $form->GetFormFile(), $form);
		//return ob_get_clean();
		*/
		
		ob_start();
		SB_Module::do_action_ref('forms_before_render', $form);
		$form->Render();
		SB_Module::do_action_ref('forms_after_render', $form);
		return ob_get_clean();
	}
	public function action_settings_tabs()
	{
		?>
		<li>
			<a href="#forms-tab" role="tab" data-toggle="tab" class="has-popover" data-content="<?php print SBText::_('FORMS_TAB_LABEL_SMTP'); ?>">
			<?php print SB_Text::_('SMTP - Formularios', 'forms'); ?></a></li>
		<?php 
	}
	public function action_settings_tabs_content($settings)
	{
		?>
		<div id="forms-tab" role="tabpanel" class="tab-pane">
			<div class="row">
				<div class="col-md-6">
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_EMAIL_FROM'); ?>">
							<?php print SBText::_('Email de remitente:', 'smn'); ?></label>
						<input type="email" name="settings[FORMS_EMAIL_FROM]" value="<?php print @$settings->FORMS_EMAIL_FROM; ?>" class="form-control" />
					</div>
					<h4><?php print SBText::_('Configuracion SMTP', 'smn'); ?></h4>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_USE_SMTP'); ?>">
							<?php print SBText::_('Utilizar Servidor SMTP:', 'smn'); ?>
							<input type="checkbox" name="settings[FORMS_USE_SMTP_SERVER]" value="1" <?php print (int)@$settings->FORMS_USE_SMTP_SERVER ? 'checked' : ''; ?> />
						</label>
						
					</div>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_SMTP_SERVER'); ?>">
							<?php print SBText::_('Servidor SMTP:', 'smn'); ?></label>
						<input type="text" name="settings[FORMS_SMTP_SERVER]" value="<?php print @$settings->FORMS_SMTP_SERVER; ?>" class="form-control" />
					</div>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_SMTP_SERVER_PORT'); ?>">
							<?php print SBText::_('Puerto Servidor SMTP:', 'smn'); ?></label>
						<input type="number" name="settings[FORMS_SMTP_SERVER_PORT]" value="<?php print @$settings->FORMS_SMTP_SERVER_PORT; ?>" class="form-control" />
					</div>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_SMTP_USERNAME'); ?>">
							<?php print SBText::_('Usuario SMTP:', 'smn'); ?></label>
						<input type="text" name="settings[FORMS_SMTP_USERNAME]" value="<?php print @$settings->FORMS_SMTP_USERNAME; ?>" class="form-control" />
					</div>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_SMTP_PASSWORD'); ?>">
							<?php print SBText::_('Contrase&ntilde;a SMTP:', 'smn'); ?></label>
						<input type="password" name="settings[FORMS_SMTP_PASSWORD]" value="<?php print @$settings->FORMS_SMTP_PASSWORD; ?>" class="form-control" />
					</div>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_SMTP_AUTH_TYPE'); ?>">
							<?php print SBText::_('Autenticacion SMTP:', 'smn'); ?></label>
						<select name="settings[FORMS_SMTP_AUTH_TYPE]" class="form-control">
							<option value="">-- <?php print SBText::_('ninguna'); ?> --</option>
							<option value="LOGIN" <?php print @$settings->FORMS_SMTP_AUTH_TYPE == 'LOGIN' ? 'selected' : ''; ?>>LOGIN</option>
							<option value="PLAIN" <?php print @$settings->FORMS_SMTP_AUTH_TYPE == 'PLAIN' ? 'selected' : ''; ?>>PLAIN</option>
							<option value="NTLM" <?php print @$settings->FORMS_SMTP_AUTH_TYPE == 'NTLM' ? 'selected' : ''; ?>>NTLM</option>
							<option value="CRAM-MD5" <?php print @$settings->FORMS_SMTP_AUTH_TYPE == 'CRAM-MD5' ? 'selected' : ''; ?>>CRAM-MD5</option>
						</select>
					</div>
					<div class="control-group">
						<label class="has-popover" data-content="<?php print SBText::_('FORMS_LABEL_SMTP_SECURE'); ?>">
							<?php print SBText::_('Seguridad SMTP:', 'smn'); ?></label>
						<select name="settings[FORMS_SMTP_SECURE]" class="form-control">
							<option value="">-- <?php print SBText::_('ninguna'); ?> --</option>
							<option value="ssl" <?php print @$settings->FORMS_SMTP_SECURE == 'ssl' ? 'selected' : ''; ?>>SSL</option>
							<option value="tls" <?php print @$settings->FORMS_SMTP_SECURE == 'tls' ? 'selected' : ''; ?>>TLS</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
}
new LT_Forms();