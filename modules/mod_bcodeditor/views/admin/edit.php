<div class="wrap">
	<h2 id="page-title"><?php print $title; ?></h2>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading"><div class="panel-title"><?php _e('Files', 'bce'); ?></div></div>
					<div class="panel-body">
						<?php foreach($files as $file): ?>
						<a href="javascript:;" class="file b-file-code" data-dir="" data-file="<?php print $file ?>">
							<?php print $file ?>
						</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
				<div id="beetle-code-editor">
				</div><!-- end id="beetle-code-editor" -->
				<script src="<?php print MOD_BCODEDITOR_URL; ?>/js/ace.js" type="text/javascript" charset="utf-8"></script>
				<script>
				var editor = ace.edit("editor");
				editor.setTheme("ace/theme/monokai");
				editor.getSession().setMode("ace/mode/javascript");
				jQuery(function()
				{
					jQuery('.b-file-code').click(function(e)
					{
						jQuery.get('index.php?mod=bcodeditor&task=load_file&file=' + this.dataset.file, function(res)
						{
							editor.setValue( atob(res.contents) );
						});
						return false;
					});
				});
				</script>
			</div>
		</div>
	</div>
</div>