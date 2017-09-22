<?php
/**
 * Template: Full Width
 */
lt_get_header();
?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="content">
					<div class="content-wrap">
						<?php SB_MessagesStack::ShowMessages(); ?>
						<?php sb_show_module(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php lt_get_footer(); ?>