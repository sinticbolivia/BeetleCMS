<?php lt_get_header(); ?>
<!-- Main section-->
<section>
	<!-- Page content-->
	<div class="content-wrapper">
		<!--
		<h3>Page title <small>Subtitle</small> </h3> -->
		<div class="row">
			<div class="col-lg-12">
				<div class="messages hidden-print"><?php SB_MessagesStack::ShowMessages(); ?></div>
				<?php sb_show_module(isset($_html_content) ? $_html_content : null); ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</section>
<?php lt_get_footer(); ?>