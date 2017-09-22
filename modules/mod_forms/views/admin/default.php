<?php
?>
<div class="wrap">
	<h2 id="page-title">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php print SBText::_('Forms', 'forms'); ?></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="page-buttons">
					<a class="btn btn-primary has-popover" href="<?php print SBText::_('index.php?mod=forms&view=new'); ?>"
							data-content="<?php print SBText::_('FORMS_BUTTON_NEW'); ?>">
							<?php _e('New', 'forms'); ?>
					</a>
				</div>
			</div>
		</div>
	</h2>
	<div class="buttons">
		
	</div>
	<table class="table">
	<thead>
	<tr>
		<th>#</th>
		<th>
			<a href="<?php print $id_order_link; ?>" class="has-popover" data-content="<?php print SBText::_('FORMS_TH_ID'); ?>">
				<?php print 'ID'; ?>
				<span class="glyphicon glyphicon-triangle-<?php print (SB_Request::getString('order_by') == 'form_id' && SB_Request::getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $title_order_link; ?>" class="has-popover" data-content="<?php print SBText::_('FORMS_TH_TITLE'); ?>">
				<?php print SBText::_('Nombre', 'forms'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print (SB_Request::getString('order_by') == 'title' && SB_Request::getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $email_order_link; ?>" class="has-popover" data-content="<?php print SBText::_('FORMS_TH_EMAIL'); ?>">
				<?php print SBText::_('Email de destino', 'forms'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print (SB_Request::getString('order_by') == 'email' && SB_Request::getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>	
			<a href="#" class="has-popover" data-content="<?php print SBText::_('FORMS_TH_SHORTCODE'); ?>">
				<?php print SBText::_('Shortcode', 'forms'); ?>
			</a>
		</th>
		<th>
			<a href="<?php print $date_order_link; ?>" class="has-popover" data-content="<?php print SBText::_('FORMS_TH_DATE'); ?>">
				<?php print SBText::_('Fecha Creacion', 'forms'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print (SB_Request::getString('order_by') == 'email' && SB_Request::getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1; foreach($forms as $form): ?>
	<tr>
		<td><?php print $i; ?></td>
		<td><?php print $form->form_id; ?></td>
		<td>
			<?php print $form->title; ?>
			<div>
				<a href="<?php print SB_Route::_('index.php?mod=forms&view=entries&id='.$form->form_id); ?>"
					class="btn btn-default btn-xs"
					title="<?php _e('Entries', 'forms'); ?>">
					<span class="glyphicon glyphicon-list">
				</a>
				<a href="<?php print SB_Route::_('index.php?mod=forms&view=edit&id='.$form->form_id); ?>"
					class="btn btn-default btn-xs"
					title="<?php print SBText::_('Editar', 'forms'); ?>">
					<span class="glyphicon glyphicon-edit">
				</a>
				<a href="<?php print SB_Route::_('index.php?mod=forms&task=delete&id='.$form->form_id); ?>" 
					class="confirm btn btn-default btn-xs" 
					data-message="<?php print SBText::_('Seguro que desea borrar el formulario?', 'forms'); ?>"
					title="<?php print SBText::_('Borrar', 'forms'); ?>">
					<span class="glyphicon glyphicon-trash">
				</a>
			</div>
		</td>
		<td><?php print $form->email; ?></td>
		<td><?php printf(FORM_SHORTCODE_TPL, $form->form_id); ?></td>
		<td><?php print sb_format_datetime($form->creation_date); ?></td>
	</tr>
	<?php $i++; endforeach; ?>
	</tbody>
	</table>
</div>