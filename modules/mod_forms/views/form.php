<?php
if( isset($form) && $form ):
?>
<style>
.the_form{background:#fff;border:1px solid #ececec;padding:5px;}
</style>
	<div class="col-md-6">
		<div class="row">
			<form id="form" class="the_form" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="mod" value="forms" />
				<input type="hidden" name="task" value="send" />
				<input type="hidden" name="form_id" value="<?php print $form->form_id; ?>" />
				<div class="control-group">
					<label><?php print SBText::_('Asunto: (resume en una frase corta)', 'forms')?></label>
					<input type="text" name="subject" value="<?php print SB_Request::getString('subject'); ?>" 
						placeholder="<?php print SBText::_('Teclea una frase resumen corta de tu consulta o sugerencia', 'forms'); ?>" 
						required="required" class="form-control" />
				</div>
				<div class="control-group">
					<label><?php print SBText::_('Mensaje', 'forms'); ?></label>
					<textarea name="message" class="form-control" required><?php print SB_Request::getString('message'); ?></textarea>
				</div>
				<div class="control-group">
					<label><?php print SBText::_('Opcional: Adjuntar archivo (Archivos permitidos: .jpg .gif .bmp .pdf .doc .mp3 .zip)', 'forms'); ?></label>
					<input type="file" name="the_file" /><span class="help-block"><?php print SBText::_('Tama&ntilde;o m&aacute;ximo del archivo: 5Mb'); ?></span>
				</div>
				<div class="control-group form-inline">
					<img src="<?php print SB_Route::_('captcha.php?var=forms_captcha'); ?>" />
					<input type="text" name="captcha" value="" class="form-control" required autocomplete="off" />
				</div>
				<br/>
				<div class="control-group">
					<button type="submit" class="btn btn-danger"><?php print SBText::_('Enviar ahora', 'forms')?></button>
				</div>
			</form>
		</div>
	</div>
	<div class="clearfix"></div>
<?php endif; ?>