<?php
class LT_ModFAQ
{
	public function __construct()
	{
		$this->AddActions();
		$this->AddShortcodes();
	}
	protected function AddActions()
	{
		SB_Module::add_action('content_types', array($this, 'action_content_types'));
	}
	protected function AddShortcodes()
	{
		SB_Shortcode::AddShortcode('faqs', array($this, 'shortcode_faqs'));
	}
	public function action_content_types($types)
	{
		$types['faq'] = array(
					'labels'	=> array(
							'menu_label'	=> __('FAQ', 'faq'),
							'new_label'		=> __('New FAQ', 'faq'),
							'edit_label'	=> __('Edit FAQ', 'faq'),
							'listing_label'	=> __('FAQ\'s', 'faq')
					),
					'features'	=> array(
							'featured_image'	=> false,
							'use_dates'			=> false,
							'calculated_dates'	=> false
					)
			);
		return $types;
	}
	public function shortcode_faqs()
	{
		$items = LT_HelperContent::GetArticles(array('type' => 'faq', 'rows_per_page' => -1, 'publish_date' => false, 'end_date' => false));
		?>
		<div id="accordion" class="panel-group faqs">
			<?php $i = 1; foreach($items['articles'] as $faq): ?>
			<div class="panel panel-default">
				<div id="heading-<?php print $i; ?>" class="panel-heading">
					<h4>
						<a href="#collapse-<?php print $i; ?>" data-toggle="collapse" data-parent="#accordion">
							<?php print $faq->title; ?>
						</a>
					</h4>
				</div>
				<div id="collapse-<?php print $i; ?>" class="panel-collapse collapse">
					<?php print $faq->content; ?>
				</div>
			</div>
			<?php $i++; endforeach; ?>
		</div>
		<?php 
	}
}
new LT_ModFAQ();