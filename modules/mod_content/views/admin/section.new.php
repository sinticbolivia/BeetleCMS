<?php
?>
<div class="wrap">
	<h2 id="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php print $title; ?></div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	<div class="text-right">
	                    <a href="<?php print $this->Route('index.php?mod=content&view=section.default'); ?>" class="btn btn-danger">
	                        <?php _e('Back', 'content'); ?>
	                    </a>
	                    <a href="javascript:;" class="btn btn-success" onclick="jQuery('#form-section').submit();"><?php _e('Save', 'content'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </h2>
	<form id="form-section" action="" method="post">
		<input type="hidden" name="mod" value="content" />
		<input type="hidden" name="task" value="section.save" />
		<input type="hidden" name="fo" value="<?php print $fo; ?>" />
		<?php if( isset($section) ): ?>
		<input type="hidden" name="section_id" value="<?php print $section->section_id; ?>" />
		<?php endif; ?>
			<div class="form-group">
				<label class="has-popover" data-content="<?php print $this->__('SECTION_TITLE'); ?>">
					<?php print $this->__('Name', 'content'); ?></label>
				<div class="row">
					<div class="col-md-6">
						<div class="input-group section-color">
							<input type="text" name="section_name" value="<?php print $this->request->getString('section_name', isset($section) ? $section->name : ''); ?>" 
									class="form-control" maxlength="40" />
							<input type="hidden" id="section-color-input" name="btn_bg_color" value="<?php print isset($section) && $section->_btn_bg_color ? $section->_btn_bg_color : '#0d4a04'; ?>" />
							<input type="hidden" id="section-fg-color" name="btn_fg_color" value="<?php print isset($section) && $section->_btn_fg_color ? $section->_btn_fg_color : '#fff'; ?>" />					    
							<span class="input-group-addon fg_color_picker" title="<?php print $this->__('Color de Texto', 'content'); ?>">
					    		<i style="display:inline-block;width:16px;height:16px;cursor:pointer;background-color:<?php print isset($section) && $section->_btn_fg_color ? $section->_btn_fg_color : '#fff'; ?>;">&nbsp;</i>
						    </span>
						    <span class="input-group-addon bg_color_picker" title="<?php print $this->__('Color de Boton', 'content'); ?>">
						    	<i style="display:inline-block;width:16px;height:16px;cursor:pointer;background-color:<?php print isset($section) && $section->_btn_bg_color ? $section->_btn_bg_color : '#0d4a04'; ?>;">&nbsp;</i>
						    </span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="has-popover" data-content="<?php print $this->__('SECTION_LABEL_UPLOAD_IMG_CHECK', 'content'); ?>">
					<?php print $this->__('Usar Imagen en lugar de Boton de texto', 'content'); ?>
					<input type="checkbox" name="use_button_instead" value="1" <?php print (isset($section) && $section->_use_button_instead == 1) ?  'checked' : ''; ?> />
				</label>
				<div>
					<span class="help-block">
						<?php print $this->__('Subir Imagen para Boton: (Tamaño recomendado: 200x100 / 150x80)', 'content');?>
					</span>
					<span id="select-button-image" class="btn btn-primary">
						<?php print $this->__('Subir imagen', 'content'); ?>
						<span id="uploading-btn-img" style="display:none;">
							<img src="<?php print BASEURL; ?>/js/fineuploader/loading.gif" alt=""  />
							<?php print $this->__('Subiendo imagen...', 'content'); ?>
						</span>
					</span>
					<div id="button-image" style="<?php print (isset($section) && $section->_button_image) ? '' : 'display:none'; ?>">
						<img src="<?php print UPLOADS_URL; ?>/buttons/<?php print isset($section) ? $section->_button_image : ''; ?>" alt="" />
						<a href="javascript:;" id="remove-button-image" class="remove" <?php print (isset($section) && $section->_button_image) ? '' : 'style="display:none;"'; ?>>
							<img src="<?php print BASEURL ?>/images/close_window-48x48.png" alt="" title="<?php print $this->__('Eliminar Banner', 'content')?>" />
						</a>
					</div>
				</div>
			</div>
			<?php /* ?>
			<div id="section-banner">
				<label><?php print SB_Text::_('Banner', 'content'); ?></label><br/>
				<div>
					<span id="select-banner" class="btn btn-primary" title="<?php print SB_Text::_('Select image', 'content'); ?>">
						<?php print SB_Text::_('Select image', 'content'); ?>
					</span>
					<span id="uploading" style="display:none;">
						<img src="<?php print BASEURL; ?>/js/fineuploader/loading.gif" alt="" />
						<?php print SB_Text::_('Subiendo imagen', 'content'); ?>
					</span>
				</div>
				<div id="the-banner">
					<img src="<?php print $image_url; ?>" alt="" class="img-thumbnail" <?php print !$image_url ? 'style="display:none;"' : ''; ?> />
					<a href="javascript:;" id="remove-banner" class="remove" <?php print !$image_url ? 'style="display:none;"' : ''; ?>>
						<img src="<?php print BASEURL ?>/images/close_window-48x48.png" alt="" title="<?php print SB_Text::_('Eliminar Banner', 'conent')?>" />
					</a>
				</div>
			</div>
			*/ ?>
			<div class="form-group row">
				<div class="col-md-6">
					<label class="has-popover" data-content="<?php print $this->__('SECTION_DESCRIPTION'); ?>">
						<?php print $this->__('Description', 'content'); ?>
					</label>
					<textarea id="description" name="description" class="form-control"><?php print $this->request->getString('description', isset($section) ? $section->description : ''); ?></textarea>
				</div>
				<div clas="clearfix" style="clear:both;"></div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
						<label class="has-popover" data-content="<?php print $this->__('SECTION_PUBLISH_DATE'); ?>">
							<?php print $this->__('Fecha Publicacion:', 'content'); ?></label>
						<div class="row">
							<div class="col-md-10">
								<input type="text" name="publish_date" value="<?php print $this->request->getString('publish_date', isset($section) ? 
																																sb_format_date($section->_publish_date) : 
																																date(DATE_FORMAT)
																						); ?>" 
									class="form-control datepicker" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="has-popover" data-content="<?php print $this->__('SECTION_EXPIRES_DATE'); ?>">
							<?php print $this->__('Fecha Caducidad:', 'content'); ?></label>
						<div class="row">
							<div class="col-md-8">
								<input type="text" name="end_date" value="<?php print $this->request->getString('end_date', 
																							(isset($section) && $section->_end_date) ? 
																							sb_format_date($section->_end_date) 
																							: 
																							date(DATE_FORMAT, strtotime((date('Y')+35).'-01-01'))
																					); ?>" 
										class="form-control datepicker" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="has-popover" data-content="<?php print $this->__('SECTION_PUBLISH_C_DATE'); ?>">
							<?php print $this->__('Fecha Publicaci&oacute;n Calculada:', 'content'); ?></label>
						<div class="row">
							<div class="col-md-4">
								<input type="number" name="calculated_date" min="0" value="<?php print $this->request->getString('calculated_date', isset($section) ? (int)$section->_calculated_date : 0); ?>" class="form-control" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="has-popover" data-content="<?php print $this->__('SECTION_EXPIRES_C_DATE'); ?>">
							<?php print $this->__('Fecha Caducidad Calculada:', 'content'); ?></label>
						<div class="row">
							<div class="col-md-4">
								<input type="number" name="calculated_end_date" min="0" value="<?php print $this->request->getString('calculated_end_date', isset($section) ? (int)$section->_calculated_end_date : 0); ?>" class="form-control" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
			</div>
			<div class="row">
				<div class="col-md-4">
					<label class="has-popover" data-content="<?php print $this->__('SECTION_USE_CDATES'); ?>">
						<input type="checkbox" name="use_calculated_dates" value="1" <?php print (isset($section) && (int)$section->_use_calculated_dates == 1) ? 'checked' : ''; ?> />
						<?php print $this->__('Usar fechas calculadas:')?>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="has-popover" data-content="<?php print $this->__('SECTION_PARENT'); ?>"><?php print $this->__('Seccion Padre:', 'content'); ?></label>
						<?php print sb_sections_dropdown(array('id' => 'parent_id', 'selected' => isset($section) ? $section->parent_id : -1)); ?>
						<?php //print SB_Request::getInt('parent_id', isset($section) ? $section->parent_id : -1); ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label><?php _e('Language', 'content'); ?></label>
				<select name="lang" class="form-control">
	  				<?php foreach($this->app->GetLanguages() as $code => $lang):?>
	  				<option value="<?php print $code; ?>" <?php print @LANGUAGE == $code ? 'selected' : ''; ?>>
	  					<?php print $lang; ?>
	  				</option>
	  				<?php endforeach; ?>
	  			</select>
			</div>
			<?php b_do_action('section_fields', isset($section) ? $section : null); ?>
			<p>
				<a class="btn btn-danger has-popover" href="<?php print $this->Route('index.php?mod=content&view=section.default'); ?>"
					data-content="<?php print $this->__('SECTION_BUTTON_CANCEL'); ?>">
					<?php print $this->__('Cancelar', 'content'); ?></a>
				<button type="submit" class="btn btn-success has-popover" data-content="<?php print $this->__('SECTION_BUTTON_SAVE'); ?>">
					<?php print $this->__('Guardar', 'content'); ?></button>
			</p>
	</form>
	<script>
	jQuery(function()
	{
		jQuery('.fg_color_picker').ColorPicker({
			onChange: function (hsb, hex, rgb) 
			{
				jQuery('#section-fg-color').val('#' + hex);
				jQuery('.fg_color_picker i').css('backgroundColor', '#' + hex);
			}
		});
		jQuery('.bg_color_picker').ColorPicker({
			onChange: function (hsb, hex, rgb) 
			{
				jQuery('#section-color-input').val('#' + hex);
				jQuery('.bg_color_picker i').css('backgroundColor', '#' + hex);
			}
		});
		jQuery('#remove-button-image').click(function()
		{
			var params = 'mod=content&task=section.remove_button_image';
			<?php if( isset($section) ):  ?>
			params += '&id=<?php print $section->section_id; ?>';
			<?php else: ?>
			params += '&id=temp';
			<?php endif; ?>
			jQuery.post('index.php', params, function(res){});
			jQuery('#button-image').css('display', 'none');
			return false;
		});
		var button_uploader = new qq.FineUploaderBasic({
			//element: document.getElementById("uploader"),
			//template: 'qq-template-gallery',
			button: document.getElementById('select-button-image'),
			request: {
				endpoint: '<?php print $this->Route('index.php?mod=content&task=section.upload_button_image' . (isset($section) ? '&id='.$section->section_id : '')); ?>'
			},
			validation: {
				allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
			},
			callbacks: 
			{
				onUpload: function(id, fileName) 
				{
					jQuery('#uploading-btn-img').css('display', 'block');
				},
				onProgress: function(id, fileName, loaded, total) 
				{
					
				},
				onComplete: function(id, fileName, responseJSON) 
				{
					jQuery('#uploading-btn-img').css('display', 'none');
					if (responseJSON.success) 
					{
						jQuery('#button-image').css('display', 'block');
						jQuery('#button-image img:first').attr('src', responseJSON.image_url).css('display', 'inline');
						jQuery('#remove-button-image').css('display', 'inline');
		            } 
		            else 
					{
						alert(responseJSON.error);
		            }
				}
			}
		});
		jQuery('input[name=qqfile]').attr('title', 'Sube una imagen de tu equipo');
		<?php /* ?>
		jQuery('#remove-banner').click(function()
		{
			jQuery.post('<?php print $remove_banner_link; ?>', 'mod=content&task=section.remove_banner', function(res){});
			jQuery('#the-banner img:first').css('display', 'none');
			jQuery('#remove-banner').css('display', 'none');
			return false;
		});
		var uploader = new qq.FineUploaderBasic({
			//element: document.getElementById("uploader"),
			//template: 'qq-template-gallery',
			button: document.getElementById('select-banner'),
			request: {
				endpoint: '<?php print $upload_endpoint; ?>'
			},
			validation: {
				allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
			},
			callbacks: 
			{
				onSubmit: function(id, fileName) 
				{
					//$messages.append('<div id="file-' + id + '" class="alert" style="margin: 20px 0 0"></div>');
				},
				onUpload: function(id, fileName) 
				{
					jQuery('#uploading').css('display', 'block');
				},
				onProgress: function(id, fileName, loaded, total) 
				{
					
				},
				onComplete: function(id, fileName, responseJSON) 
				{
					jQuery('#uploading').css('display', 'none');
					if (responseJSON.success) 
					{
						jQuery('#the-banner img:first').attr('src', responseJSON.image_url).css('display', 'inline');
						jQuery('#remove-banner').css('display', 'inline');
		            } 
		            else 
					{
						alert(responseJSON.error);
		            }
				}
			}
		});
		*/ ?>
	});
	</script>
</div>
<link rel="stylesheet" href="<?php print BASEURL; ?>/js/colorpicker/css/colorpicker.css" />
<script src="<?php print BASEURL; ?>/js/colorpicker/js/colorpicker.js"></script>
