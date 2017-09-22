<?php
?>
<div class="wrap">
	<h2 id="">
		<?php _e('Sliders', 'slider'); ?>
		<a href="<?php print SB_Route::_('index.php?mod=slider&view=new'); ?>" class="btn btn-primary"><?php _e('New', 'slider'); ?></a>
	</h1>
	<table class="table">
	<thead>
	<tr>
		<th><?php _e('No.', 'slider'); ?></th>
		<th><?php _e('Name', 'slider'); ?></th>
		<th><?php _e('Images', 'slider'); ?></th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<?php $i = 1; if( isset($sliders) && is_array($sliders) ) : foreach($sliders as $index => $slider): ?>
	<tr>
		<td class="text-center"><?php print $i; ?></td>
		<td><?php print $slider->name; ?></td>
		<td class="text-center"><?php print count($slider->images); ?></td>
		<td>
			<a href="<?php print SB_Route::_('index.php?mod=slider&view=edit&id='.$index); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="<?php print SB_Route::_('index.php?mod=slider&task=delete&id='.$index); ?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a>
		</td>
	</tr>
	<?php $i++; endforeach; endif; ?>
	</table>
</div>