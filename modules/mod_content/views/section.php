<?php
?>
<div class="lt-section">
	<h1><?php print $section->name; ?></h1>
	<div><?php print $section->description; ?></div>
	<div class="b-section-articles">
		<?php foreach($articles as $a): ?>
		<div class="b-article container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="image">
						<a href="<?php print $c->link; ?>">
							<?php print $a->TheThumbnail('500x500'); ?>
						</a>
					</div>
				</div>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<h2 class="title"><?php print $a->title; ?></h2>
					<div class="content"><?php print $a->TheExcerpt(); ?></div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>