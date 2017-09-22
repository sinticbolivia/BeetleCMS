<div class="panel panel-default">
	<div class="panel-heading"><h2 class="panel-title"><?php _e('SEO Features', 'seo'); ?></h2></div>
	<div class="panel-body">
		<div class="form-group">
			<label><?php _e('Title', 'seo'); ?></label>
			<input type="text" name="meta[_seo_title]" value="<?php print isset($obj) ? $obj->_seo_title : ''; ?>"
				class="form-control" />
		</div>
		<div class="form-group">
			<label><?php _e('Description', 'seo'); ?></label>
			<textarea name="meta[_seo_desc]" class="form-control mceNoEditor"><?php print isset($obj) ? $obj->_seo_desc : '' ?></textarea>
		</div>
		<div class="form-group">
			<label><?php _e('Keywords', 'seo'); ?></label>
			<input type="text" name="meta[_seo_keys]" value="<?php print isset($obj) ? $obj->_seo_keys : ''; ?>"
				class="form-control" />
		</div>
	</div>
</div>