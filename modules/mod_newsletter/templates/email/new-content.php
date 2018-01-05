<?php
$name = trim(sprintf("%s %s", $sub->firstname, $sub->lastname));
if( empty($name) )
	$name = $sub->email;
?>
<?php printf(__('Hello %s', 'newsletter'), $name); ?><br/>
<p>
<?php printf(__('A new content has been published into %s', 'newsletter'), SITE_TITLE); ?>
</p>
<table style="width:100%;border-collapse:collapse;">
<tr>
	<td style="width:50%;">
		<a href="<?php print $article->link; ?>" style="display:block;">
			<img src="<?php print $article->GetThumbnailUrl(); ?>" alt="<?php print $article->TheTitle(); ?>"
					style="max-width:100%;"/>
		</a>
	</td>
	<td style="width:50%;">
		<h2><a href="<?php print $article->link; ?>"><?php print $article->TheTitle(); ?></a></h2>
		<p><?php print $article->TheExcerpt(); ?></p>
	</td>
</tr>
</table>
<br/>
<?php _e('Kind Regards,', 'newsletter'); ?><br/>
<?php printf(__('The %s Team', 'newsletter'), SITE_TITLE); ?><br/>
<a href="<?php print BASEURL; ?>"><?php print BASEURL; ?></a>