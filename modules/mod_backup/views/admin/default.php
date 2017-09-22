<?php
?>
<div class="container">
	<h1><?php print SB_Text::_('Backups'); ?></h1>
	<div class="row">
		<div class="col-md-6">
			<h3 class="has-popover" data-content="<?php print SBText::_('BACKUP_TABLES'); ?>"><?php print SB_Text::_('Tablas'); ?></h3>
			<form action="" method="post">
				<input type="hidden" name="mod" value="backup" />
				<input type="hidden" name="task" value="do_backup" />
				<ul class="" style="height:300px;overflow:auto;">
					<?php foreach($tables as $t): ?>
				    <li class="list-group-item">
				    	<label>
				    		<input type="checkbox" name="tables[]" value="<?php print $t->{'Tables_in_'.DB_NAME}?>" checked />
				    		<?php print $t->{'Tables_in_'.DB_NAME}?>
				    	</label>
				    </li>
				    <?php endforeach; ?>
				</ul><br/>
				<p>
					<label class="has-popover" data-content="<?php print SBText::_('BACKUP_FILES'); ?>">
						<?php print SBText::_('Realizar copia de archivos', 'backup'); ?>
						<input type="checkbox" name="backup_files" value="1" />
					</label>
				</p>
				<p>
					<button class="btn btn-secondary has-popover" data-content="<?php print SBText::_('BACKUP_BUTTON_START'); ?>">
						<?php print SB_Text::_('Realizar Backup', 'backup'); ?></button>
				</p>
			</form>
		</div>
		<div class="col-md-6">
			<h3 class="has-popover" data-content="<?php print SBText::_('BACKUP_RESTORE'); ?>">
				<?php print SB_Text::_('Restaurar Backup'); ?>
			</h3>
			<form action="" method="post" enctype="multipart/form-data" class="horizontal-form">
				<input type="hidden" name="mod" value="backup" />
				<input type="hidden" name="task" value="restore_backup" />
				<div class="form-group">
					 <label for="exampleInputFile" class="has-popover" data-content="<?php print SBText::_('BACKUP_UPLOAD_FILE'); ?>">
					 	<?php print SB_Text::_('Archivo SQL'); ?>
					 </label>
					<input type="file" name="backup_file" />
				</div>
				<em class="has-popover" data-content="<?php print SBText::_('BACKUP_MAX_FILE_SIZE'); ?>">
					<?php printf(SBText::_('Tamaño maximo de archivo: %s'), ini_get('upload_max_filesize'));?></em>
				<p>
					<button type="submit" class="btn btn-secondary has-popover" data-content="<?php print SBText::_('BACKUP_BUTTON_RESTORE'); ?>">
						<?php print SB_Text::_('Restaurar'); ?></button>
				</p>
			</form>
		</div>
	</div>
</div>