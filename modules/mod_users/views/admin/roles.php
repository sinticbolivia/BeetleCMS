<?php

?>
<div class="wrap">
	<h1><?php $this->__('User Roles', 'users'); ?></h1>
	<ul class="view-buttons">
		<li>
			<a class="btn btn-secondary has-popover" data-content="<?php $this->__('USERS_ROLE_BUTTON_NEW'); ?>" 
				href="<?php print $this->__('index.php?mod=users&view=roles.new&ctrl=roles'); ?>">
				<?php print $this->__('New Role', 'users'); ?>
			</a>
		</li>
	</ul>
	<table class="table">
	<thead>
	<tr>
		<th>#</th>
		<th>
			<a href="<?php print $role_order_link; ?>" class="has-popover" data-content="<?php print $this->__('USERS_ROLE_TH_ROLE'); ?>">
				<?php print $this->__('Role', 'users'); ?>
				<span class="glyphicon glyphicon-triangle-<?php print ($this->request->getString('order_by') == 'role_name' && $this->request->getString('order', 'asc') == 'asc') ? 'bottom' : 'top'; ?>"></span>
			</a>
		</th>
		<th>
			<a href="#" class="has-popover" data-content="<?php print $this->__('USERS_ROLE_TH_ACTIONS'); ?>">
				<?php print $this->__('Actions'); ?>
			</a>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php $i = 1;foreach($roles as $role): ?>
	<tr>
		<td><?php print $i; ?></td>
		<td><?php print $role->role_name; ?></td>
		<td>
			<a href="index.php?mod=users&view=roles.edit&id=<?php print $role->role_id; ?>" class="btn btn-default btn-xs"
				title="<?php print $this->__('Edit', 'users'); ?>">
				<span class="glyphicon glyphicon-edit"></span>
			</a> 
			<a href="index.php?mod=users&task=roles.delete&id=<?php print $role->role_id; ?>" class="confirm btn btn-default btn-xs" 
				data-message="<?php print $this->__('Are you sure to delete the user role?'); ?>" title="<?php print $this->__('Delete role'); ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php $i++; endforeach; ?>
	</tbody>
	</table>
</div><!-- end class="container" -->
