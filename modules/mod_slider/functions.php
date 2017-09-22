<?php
function lt_slider($id, $tpl = 'default.php')
{
	$sliders = (array)sb_get_parameter('sliders', array());
	//print_r($sliders);
	if( !isset($sliders[$id]) )
		return false;
	$slider = $sliders[$id];
	/*
	$slider = (object)array(
			'images' => array(
					(object)array(
							'title' => '',
							'image' => 'banner01-jpg-593',
					),
					(object)array(
							'title' => '',
							'image' => 'banner03.jpg',
					)
			)
	);
	*/
	$tpl 			= SB_Module::do_action('mod_slider_tpl', 'templates' . SB_DS . $tpl);
	$tpl_partial 	= TEMPLATE_DIR . SB_DS . 'partial-' . $id . '.php';
	if( file_exists($tpl_partial) && is_file($tpl_partial) )
	{
		$tpl = $tpl_partial;
	}
	include $tpl;
}