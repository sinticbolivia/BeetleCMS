<?php
?>
<div class="wrap">
	<h2 id="page-title"><?php print SB_Text::_('Backups'); ?></h2>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-6">
				<h3 class="has-popover" data-content="<?php print SBText::_('BACKUP_TABLES'); ?>">
					<?php _e('Tables', 'backup'); ?>
				</h3>
				<form action="" method="post">
					<input type="hidden" name="mod" value="backup" />
					<input type="hidden" name="task" value="do_backup" />
					<ul class="" style="height:300px;overflow:auto;">
						<?php foreach($tables as $t): ?>
						<li class="list-group-item">
							<label>
								<input type="checkbox" name="tables[]" value="<?php print $t->name ?>" checked />
								<?php print $t->name ?>
							</label>
						</li>
						<?php endforeach; ?>
					</ul><br/>
					<p>
						<label class="has-popover" data-content="<?php print SBText::_('BACKUP_FILES'); ?>">
							<?php _e('Copy files', 'backup'); ?>
							<input type="checkbox" name="backup_files" value="1" />
						</label>
					</p>
					<p>
						<button class="btn btn-success has-popover" data-content="<?php print SBText::_('BACKUP_BUTTON_START'); ?>">
							<?php print SB_Text::_('Build Backup', 'backup'); ?></button>
					</p>
				</form>
			</div>
			<div class="col-md-6">
				<h3 class="has-popover" data-content="<?php print SBText::_('BACKUP_RESTORE'); ?>">
					<?php _e('Restore Backup'); ?>
				</h3>
				<form action="" method="post" enctype="multipart/form-data" class="horizontal-form">
					<input type="hidden" name="mod" value="backup" />
					<input type="hidden" name="task" value="restore_backup" />
					<div class="form-group">
						 <label for="exampleInputFile" class="has-popover" data-content="<?php print SBText::_('BACKUP_UPLOAD_FILE'); ?>">
							<?php _e('SQL File', 'backup'); ?>
						 </label>
						<input type="file" name="backup_file" class="form-control" />
					</div>
					<em class="has-popover" data-content="<?php print SBText::_('BACKUP_MAX_FILE_SIZE'); ?>">
						<?php printf(__('Max file size: %s', 'backup'), ini_get('upload_max_filesize'));?></em>
					<p>
						<button type="submit" class="btn btn-success has-popover" data-content="<?php print SBText::_('BACKUP_BUTTON_RESTORE'); ?>">
							<?php _e('Restore', 'backup'); ?></button>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>