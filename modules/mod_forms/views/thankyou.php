<?php
?>
<div id="article-container">
	<div class="text-center">
		<h4><?php print SBText::_('Tu formulario ha sido enviado correctamente.', 'forms')?></h4>
		<h2><?php print SBText::_('Gracias', 'forms'); ?></h2>
		<p>
			<a href="<?php print $_SERVER['HTTP_REFERER']; ?>" class="btn btn-success"><?php print SBText::_('Aceptar', 'forms'); ?></a>
		</p>
	</div>
</div>