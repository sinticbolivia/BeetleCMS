<?php
?>
<div class="wrap">
	<h2 id="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php print $title; ?></div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	<div class="text-right">
                		<a class="btn btn-primary has-popover" href="<?php print $link_btn_new; ?>"
							data-content="<?php print $this->__('SECTION_BUTTON_NEW'); ?>">
							<?php print $label_btn_new; ?>
						</a>
                	</div>
                </div>
			</div>
		</div>
	</h2>
	
	</ul>
	<div class="row">
		<div class="col-md-6">
			<form action="" method="get" class="">
				<input type="hidden" name="mod" value="content" />
				<input type="hidden" name="view" value="section.default" />
				<div class="input-group">
					<input type="text" name="keyword" value="" class="form-control" />
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
				<div>&nbsp;</div>
			</form>
		</div>
	</div>
	<table class="table">
	<thead>
	<tr>
		<th>#</th>
		<th>
			<a href="<?php print $id_order_link; ?>" class="has-popover" data-content="<?php print $this->__('SECTION_TH_ID'); ?>">
				<?php print $this->__('ID', 'content'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'content_id' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $name_order_link; ?>" class="has-popover" data-content="<?php print $this->__('SECTION_TH_NAME'); ?>">
				<?php print $this->__('Nombre', 'content'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'content_id' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $order_link; ?>" class="has-popover" data-content="<?php print $this->__('SECTION_TH_ORDER'); ?>">
				<?php print $this->__('Orden', 'content'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'show_order' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $date_order_link?>" class="has-popover" data-content="<?php print $this->__('SECTION_TH_DATE'); ?>">
				<?php print $this->__('Fecha Creacion', 'content'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'content_id' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $publishdate_order_link; ?>" class="has-popover" data-content="<?php print $this->__('SECTION_TH_PUBLISH_DATE'); ?>">
				<?php print $this->__('Fecha Publicacion', 'content'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'publish_date' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="<?php print $enddate_order_link; ?>" class="has-popover" data-content="<?php print $this->__('SECTION_TH_FINAL_DATE'); ?>">
				<?php print $this->__('Fecha Caducidad', 'content'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'end_date' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="#" class="has-popover" data-content="<?php print $this->__('SECTION_TH_ACTIONS'); ?>">
				<?php print $this->__('Accion', 'content'); ?>
			</a>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1; foreach($sections as $s): ?>
	<tr>
		<td><?php print $i; ?></td>
		<td><?php print $s->section_id; ?></td>
		<td><?php print $s->name; ?></td>
		<td width="90">
			<input type="number" min="0" name="order" value="<?php print $s->show_order; ?>" class="form-control change-order" 
				data-id="<?php print $s->section_id; ?>" />
		</td>
		<td><?php print $s->creation_date; ?></td>
		<td><?php print $s->_publish_date; ?></td>
		<td><?php print $s->_end_date; ?></td>
		<td>
			<a href="<?php print $this->Route('index.php?mod=content&view=section.edit&id='.$s->section_id); ?>" 
				class="btn btn-default btn-xs"
				title="<?php print $this->__('Editar', 'content'); ?>">
				<span class="glyphicon glyphicon-edit"></span>	
			</a>
			<a href="<?php print $this->Route('index.php?mod=content&task=section.delete&id='.$s->section_id); ?>" 
				class="confirm btn btn-default btn-xs"
				title="<?php print $this->__('Borrar', 'content'); ?>" 
				data-message="<?php print $this->__('Are you sure to delete the content section?', 'content'); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php $i++; endforeach; ?>
	</tbody>
	</table>
	<?php lt_pagination($this->Route('index.php?'.$_SERVER['QUERY_STRING']), $total_pages, $current_page); ?>
	<script>
	jQuery(function()
	{
		jQuery('.change-order').keyup(function(e)
		{
			if( e.keyCode == 13 )
			{
				window.location = 'index.php?mod=content&task=section.change_order&id='+this.dataset.id+'&order='+parseInt(this.value);
			}
		});
	});
	</script>
</div>