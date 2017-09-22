<?php
?>
<div class="wrap">
	<h2><?php print $title; ?></h2>
	<form action="" method="post">
		<input type="hidden" name="mod" value="slider" />
		<input type="hidden" name="task" value="save" />
		<?php if( isset($slider) ): ?>
		<input type="hidden" name="id" value="<?php print $slider->id; ?>" />
		<?php endif; ?>
		<div class="form-group">
			<label><?php _e('Name', 'slider'); ?></label>
			<input type="text" name="slider[name]" value="<?php print isset($slider) ? $slider->name : ''; ?>" class="form-control" />
		</div>
		<div class="form-group">
			<a href="<?php print SB_Route::_('index.php?mod=slider')?>" class="btn btn-danger"><?php _e('Cancel', 'slider'); ?></a>
			<button type="submit" class="btn btn-success"><?php _e('Save', 'slider'); ?></button>
		</div>
	</form>
	<?php if( isset($slider) ): ?>
	<fieldset>
		<legend><?php _e('Slide Information', 'slider'); ?></legend>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="mod" value="slider" />
			<input type="hidden" name="task" value="upload" />
			<input type="hidden" name="id" value="<?php print $slider->id; ?>" />
			<div class="form-group">
				<label><?php _e('Title', 'slider'); ?></label>
				<input type="text" id="title" name="title" value="" class="form-control" />
			</div>
			<div class="form-group">
				<label><?php _e('Description', 'slider'); ?></label>
				<textarea name="description" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label><?php _e('Link', 'slider'); ?></label>
				<input type="text" id="link" name="link" value="" class="form-control" />
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label><?php _e('Image', 'slider'); ?></label>
						<input type="file" name="slide" value="" class="form-control" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>&nbsp;</label><br/>
						<button class="btn btn-primary" type="submit"><?php _e('Upload', 'slider'); ?></button>
					</div>
				</div>
			</div>
		</form>
	</fieldset>
	<table class="table">
	<thead>
	<tr>
		<th style="width:100px;text-align:center;"><?php _e('Num', 'slider'); ?></th>
		<th style="width:200px;text-align:center;"><?php _e('Image', 'slider'); ?></th>
		<th style="width:60%;"><?php _e('Title', 'slider'); ?></th>
		<th></th>
	</tr>
	</thead>
	<?php $i = 1; if( isset($slider->images) && is_array($slider->images) ): foreach($slider->images as $index => $img): ?>
	<tr>
		<td class="text-center"><?php print $i; ?></td>
		<td class="text-center"><img src="<?php print MOD_SLIDER_UPLOADS_URL . '/' . $img->image; ?>" alt="" width="150" /></td>
		<td><?php print $img->title; ?></td>
		<td>
			<a href="<?php print SB_Route::_('index.php?mod=slider&task=delete_img&sid='.$slider->id . '&id='.$index);?>" class="btn btn-default" title="<?php print _e('Delete', 'slider'); ?>"><span class="glyphicon glyphicon-trash"></span></a>
		</td>
	</tr>
	<?php $i++; endforeach; endif; ?>
	</table>
	<?php endif; ?>
</div>