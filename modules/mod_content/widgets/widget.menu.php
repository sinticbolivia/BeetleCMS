<?php
class SB_MBWidgetMenu extends SB_Widget
{
	public function __construct()
	{
		parent::__construct(__('Menu', 'content'));
		
	}
	public function Render($args = array())
	{
		$def_args = array(
			'title'		=> __('Menu', 'content'),
			'menu_key'		=> null,
			'menu_class'	=> 'menu',
			'submenu_class'	=> 'submenu'
		);
		$args = array_merge($def_args, $args);
		/*
		$pages = LT_HelperContent::GetArticles(array(
			'rows_per_page' => -1
		));
		*/
		?>
		<div class="widget">
			<?php if($args['title']): ?>
			<h2 class="title"><?php print $args['title']; ?></h2>
			<?php endif; ?>
			<div class="body">
				<?php
				if( $args['menu_key'] )
					!lt_show_content_menu($args['menu_key'], array(
																	'class' => $args['menu_class'], 
																	'sub_menu_class' => $args['submenu_class']));
				?>
			</div>
		</div>
		<?php
	}
}
sb_register_widget('SB_MBWidgetMenu');