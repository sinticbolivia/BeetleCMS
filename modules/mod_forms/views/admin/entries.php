<div class="wrap">
	<h2 id="page-title">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php _e('Form Entries', 'forms'); ?></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="page-buttons">
					<a class="btn btn-danger has-popover" 
						href="<?php print SBText::_('index.php?mod=forms'); ?>"
							data-content="<?php print SBText::_('FORMS_BUTTON_NEW'); ?>">
							<?php _e('Back', 'forms'); ?>
					</a>
				</div>
			</div>
		</div>
	</h2>
	<div class="buttons">
		<a href="<?php ?>" class="btn btn-primary btn-xs"><?php _e('Export to Excel', 'forms'); ?></a>
	</div><br/>
	<div class="table-responsive">
		<table class="table table-condensed table-hover table-striped table-bordered">
		<thead>
		<tr>
			<?php foreach($table->headings as $h): ?>
			<th><?php print $h; ?></th>
			<?php endforeach; ?>
			<th><?php _e('Date'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($table->rows as $row): ?>
		<tr>
			<?php foreach($table->headings as $h): ?>
			<td><?php print $row->$h; ?></td>
			<?php endforeach; ?>
			<td><?php print $row->creation_date; ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	</div>
</div>