<?php
?>
<div class="wrap">
	<h2 id="page-title"><?php print $title; ?></h2>
	
	<div>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#general" data-toggle="tab"><?php _e('General Info', 'forms'); ?></a></li>
			<li><a href="#designer" data-toggle="tab"><?php _e('Designer', 'forms'); ?></a></li>
			<li><a href="#preview" data-toggle="tab"><?php _e('Preview', 'forms'); ?></a></li>
			<li><a href="#html" data-toggle="tab"><?php _e('HTML Code'); ?></a></li>
			<li><a href="#template-tab" data-toggle="tab"><?php _e('Template'); ?></a></li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane active">
				<form id="form-new" action="" method="post" class="">
					<input type="hidden" name="mod" value="forms" />
					<input type="hidden" name="task" value="save" />
					<?php if( isset($form) ): ?>
					<input type="hidden" name="id" value="<?php print $form->form_id; ?>" />
					<?php endif; ?>
					<input type="hidden" id="form_data" name="form_data" 
						value="<?php print isset($form) ? base64_encode($form->fields) : ''; ?>" />
					<div class="container-fluid">
						<div class="row">
							<div id="form-container" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label class="has-popover" data-content="<?php print SBText::_('FORMS_NAME'); ?>">
										<?php _e('Name:', 'forms'); ?></label>
									<input type="text" name="title" value="<?php print SB_Request::getString('title', isset($form) ? $form->title : ''); ?>" 
											class="form-control" maxlength="40" size="40" />									
								</div>
								<div class="form-group">
									<label class="has-popover" data-content="<?php print SBText::_('FORMS_DESCRIPTION'); ?>">
										<?php _e('Description:', 'forms'); ?></label>
									<textarea name="description" class="form-control"><?php print SB_Request::getString('description', isset($form) ? $form->description : ''); ?></textarea>
								</div>
								<div class="form-group">
									<label class="has-popover" data-content="<?php print SBText::_('FORMS_DEST_EMAIL'); ?>">
										<?php _e('Target Email:', 'forms'); ?>
									</label>
									<input type="email" name="email" value="<?php print SB_Request::getString('email', isset($form) ? $form->email : ''); ?>" 
												class="form-control" maxlength="40" />
								</div>
								<div class="form-group">
									<label class="control-label"><?php _e('Forms', 'forms'); ?></label>
									<select name="form_file" class="form-control">
										<option value="">-- form file --</option>
										<?php foreach($form_files as $file): ?>
										<option value="<?php print $file['file']; ?>" <?php print isset($form) && $form->form_file == $file['file'] ? 'selected' : ''; ?>>
											<?php print $file['name']; ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label class="has-popover" data-content="<?php print SBText::_('FORMS_SUBJECT'); ?>">
										<?php _e('Subject', 'forms'); ?></label>
									<input type="text" name="subject" value="<?php print SB_Request::getString('subject', isset($form) ? $form->subject : ''); ?>" 
											class="form-control" />									
								</div>
								<div class="form-group">
									<label class="has-popover" data-content="<?php print SBText::_('FORMS_MESSAGE'); ?>">
										<?php _e('Message:', 'forms'); ?></label>
									<textarea name="message" class="form-control" style="height:300px;"><?php print SB_Request::getString('message', isset($form) ? $form->message : ''); ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div><!-- end id="general" -->
			<div id="designer" class="tab-pane">
				<div id="fb-editor"></div>
			</div>
			<div id="preview" class="tab-pane">
				<div id="fb-rendered-form">
					
				</div>
			</div>
			<div id="html" class="tab-pane">
				<textarea name="html" class="form-control" style="height:500px;"></textarea>
			</div>
			<div id="template-tab" class="tab-pane">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
							<div class="panel panel-default">
								<div class="panel-header">
									<h4 class="panel-title"><?php _e('Form Fields', 'forms'); ?></h4>
								</div>
								<div class="panel-body">
									<p class="alert alert-info">
									<?php _e('Your form action needs to be equal to => {form_action}', 'forms'); ?>
									</p>
									<p class="alert alert-info"><b>
										<?php _e('Dont forget to add these placholders at the begining of your form or before &lt;/form> tag', 'forms'); ?><br/>
										{field name="module"}<br/>
										{field name="task"}<br/>
										{field name="form_id"}</b>
									</p>
									<div id="template-fields"></div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
							<textarea id="template" name="template" class="form-control" 
								style="height:500px;"><?php print isset($form) ? htmlentities($form->template) : ''; ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="">
			<a href="<?php print SB_Route::_('index.php?mod=forms'); ?>" class="btn btn-danger has-popover"
				data-content="<?php print SBText::_('FORMS_BUTTON_CANCEL'); ?>">
				<?php _e('Cancel', 'forms'); ?></a>
			<button type="button" class="btn btn-success has-popover" onclick="jQuery('#form-new').submit();"
				data-content="<?php print SBText::_('FORMS_BUTTON_SAVE'); ?>">
				<?php _e('Save', 'forms'); ?>
			</button>
		</div>
	</div>
	
</div>
<link rel="stylesheet" href="<?php print MOD_FORMS_URL ?>/js/jquery-ui/jquery-ui.min.css" />
<style>
.stage-wrap ul{height:500px !important;overflow:auto;}
</style>
<script src="<?php print MOD_FORMS_URL ?>/js/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php print MOD_FORMS_URL ?>/js/kevinchappell-formBuilder/dist/form-builder.min.js"></script>
<script src="<?php print MOD_FORMS_URL ?>/js/kevinchappell-formBuilder/dist/form-render.min.js"></script>
<script>
function __addLineBreaks(html) 
{
  return html.replace(new RegExp('&gt; &lt;', 'g'), "&gt;\n&lt;")
			.replace(new RegExp('&gt;&lt;', 'g'), "&gt;\n&lt;")
			.replace(new RegExp('> <', 'g'), ">\n<")
			.replace(new RegExp('><', 'g'), ">\n<");
}
function __buildHTML(formData)
{
	//var code = jQuery('<div/>');
	var code = jQuery('#fb-rendered-form');
	code.formRender({formData});
	var html = __addLineBreaks(code.html());
	jQuery('[name=html]').val( `<form action="" method="post">\n${html}\n</form>` );
	jQuery('#form_data').val( btoa(formData) );
	
	return html;
}
function __setTemplateFields()
{
	var textarea = jQuery('#template').get(0);
	var fields_container = jQuery('#template-fields');
	fields_container.html('');
	var fields = eval(formBuilder.formData);
	fields.forEach(function(field)
	{
		var btn = document.createElement('a');
		btn.className = 'btn btn-default';
		btn.style.display = 'block';
		btn.style.marginBottom = '8px';
		btn.href= 'javascript:;';
		btn.dataset.type = field.type;
		btn.dataset.name = field.name;
		btn.dataset.label = field.label;
		btn.onclick = function(e)
		{
			var placeholder = '';
			
			if( this.dataset.type == 'button' )
			{
				placeholder = `{button name="${this.dataset.name}"}`;
			}
			else //if( this.dataset.type = 'text' )
			{
				placeholder = `{field name="${this.dataset.name}" label="${this.dataset.label}"}`;
			}
			//console.log(placeholder);
			var cursorPos = textarea.selectionStart;
			var textBefore = textarea.value.substring(0,  cursorPos);
			var textAfter  = textarea.value.substring(cursorPos, textarea.value.length);
			textarea.value	= textBefore + placeholder + textAfter;
			
		};
		btn.innerHTML = `${field.label} (${field.type})`;
		fields_container.append(btn);
	});
}
jQuery(function($) 
{
	var $fbEditor		= jQuery('#fb-editor');
    var $formContainer 	= jQuery('#fb-rendered-form');
    var fbOptions 		= 
	{
		//defaultFields: [{type:'hidden',name:"mod",value:'forms'},{type:'hidden',name:"task",value:'send'}],
		showActionButtons: false,
		onSave: function() 
		{
			$fbEditor.toggle();
			$formContainer.toggle();
			$('form', $formContainer).formRender({
				formData: formBuilder.formData
			});
		},
		typeUserEvents: {
			button:
			{
				onadd: function(fld)
				{
					//##add field to template fields
					jQuery('#template-fields').append(`<input type="" />`);
					var classField = jQuery('.fld-className', fld);
					//console.log(classField);
					classField[0].onchange = function(e) 
					{
						console.log('onchange:'+e.target.value);
						e.preventDefault();
						e.stopPropagation();
						return false;
					};
					classField[0].onblur = function(e)
					{
						//console.log('onblur:' + e.target.value);
						
						e.preventDefault();
						e.stopPropagation();
						classField[0].value = e.target.value;
						return false;
					};					
				}
			}
		}
    };
	document.addEventListener('fieldAdded', function(e)
	{
		__setTemplateFields();
		
	}, true);
	var fields = <?php print (isset($form) && $form->fields) ? $form->fields : "''"; ?>;
	fbOptions.formData = JSON.stringify(fields);
	window.formBuilder = $fbEditor.formBuilder(fbOptions);
	window.addEventListener('load', function()
	{
		__setTemplateFields();
	}, false);
	
	jQuery('.nav-tabs li a').click(function()
	{
		__buildHTML(formBuilder.formData);
	});
	jQuery('#form-new').submit(function()
	{
		var html = __buildHTML(formBuilder.formData);
		var template = btoa(jQuery('#template').val());
		jQuery(this).append('<input type="hidden" name="html" value="'+btoa(html)+'" />');
		jQuery(this).append('<input type="hidden" name="template" value="'+template+'" />');
		return true;
	});
});
</script>