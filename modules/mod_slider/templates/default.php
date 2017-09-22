<?php
?>
<!-- Slider -->
<div id="home_carousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php for($i = 0; $i < count($slider->images); $i++): ?>
		<li data-target="#home_carousel" data-slide-to="<?php print $i; ?>" class="<?php print $i === 0 ? 'active' : ''; ?>"></li>
		<?php endfor; ?>
	</ol>
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<?php foreach($slider->images as $index => $img): ?>
		<div class="item <?php print $index === 0 ? 'active' : ''; ?>">
			<img src="<?php printf("%s/%s", MOD_SLIDER_UPLOADS_URL, $img->image); ?>" alt="<?php print $img->title; ?>" />
			<div class="carousel-caption">
				<?php if( !empty($img->title) ): ?>
				<h2 class="slide-title"><?php print $img->title; ?></h2>
				<?php endif; ?>
				<?php if( !empty($img->description) ): ?>
			    <p class="slide-description"><?php print $img->description; ?></p>
			    <?php endif; ?>
			    <?php if( isset($img->link) && !empty($img->link) ): ?>
			    <form method="get" action="<?php print $img->link; ?>">
			    	<button type="submit" class="btn btn-lg btn-default"><?php _e('View more', 'slider'); ?></button>
			    </form>
			    <?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<!-- Controls -->
	<a class="left carousel-control" href="#home_carousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
	</a>
	<a class="right carousel-control" href="#home_carousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
	</a>
</div>
<!-- Slider end -->