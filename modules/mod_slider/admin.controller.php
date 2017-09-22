<?php
class LT_AdminControllerSlider extends SB_Controller
{
	public function task_default()
	{
		//##get all sliders
		$sliders = (array)sb_get_parameter('sliders', array());
		//print_r($sliders);
		sb_set_view_var('sliders', (array)$sliders);
	}
	public function task_new()
	{
		$title = __('Create New Slider', 'slider');
		sb_set_view_var('title', $title);
		$this->document->SetTitle($title);
	}
	public function task_edit()
	{
		$id 	= SB_Request::getString('id');
		//##get all sliders
		$sliders = (array)sb_get_parameter('sliders', array());
		if( !isset($sliders[$id]) )
		{
			sb_redirect(SB_Route::_('index.php?mod=slider'));
		}
		$slider = $sliders[$id];
		sb_set_view('new');
		sb_set_view_var('slider', $slider);
		$title = sprintf(__('Edit Slider "%s"', 'slider'), $slider->name);
		sb_set_view_var('title', $title);
		$this->document->SetTitle($title);
	}
	public function task_save()
	{
		$id 	= SB_Request::getString('id', null);
		$slider = array_map('trim', SB_Request::getVar('slider'));
		//##get all sliders
		$sliders = (array)sb_get_parameter('sliders', array());
		if( $id === null || empty($id) )
		{
			$id 					= 'slider_' . (($sliders && is_array($sliders)) ? count($sliders) : '0');
			$sliders[$id] 			= $slider;
			$sliders[$id]['id'] 	= $id;
			$sliders[$id]['images'] = array();
		}
		else 
		{
			$sliders[$id] = array_merge((array)$sliders[$id], $slider);
		}
		sb_update_parameter('sliders', $sliders);
		SB_MessagesStack::AddMessage(__('The slider has been created', 'slider'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=slider&view=edit&id='.$id));
	}
	public function task_delete()
	{
		$id 	= SB_Request::getString('id', null);
		if( !$id )
		{
			SB_MessagesStack::AddMessage(__('Invalid slider identifier', 'slider'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=slider'));
		}
		//##get all sliders
		$sliders = (array)sb_get_parameter('sliders', array());
		//print_r($sliders);var_dump(isset($sliders[$id]));var_dump($id);die();
		if( !isset($sliders[$id]) )
		{
			SB_MessagesStack::AddMessage(__('The slider does not exists', 'slider'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=slider'));
		}
		//##delete images
		foreach($sliders[$id]->images as $img)
		{
			@unlink(MOD_SLIDER_UPLOADS_DIR . SB_DS . $img->image);
		}
		unset($sliders[$id]);
		sb_update_parameter('sliders', $sliders);
		SB_MessagesStack::AddMessage(__('The slider has been deleted', 'slider'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=slider'));
	}
	public function task_upload()
	{
		$id 	= SB_Request::getString('id', null);
		$sliders = (array)sb_get_parameter('sliders', array());
		if( !isset($sliders[$id]) )
		{
			return false;
		}
		if( !isset($_FILES['slide']) || $_FILES['slide']['size'] <= 0 )
		{
			SB_MessagesStack::AddMessage(__('You need to upload an image', 'slider'), 'error');
			sb_redirect(SB_Route::_('index.php?mod=slider&view=edit&id='.$id));
			return false;
		}
		if( !is_dir(MOD_SLIDER_UPLOADS_DIR) )
			mkdir(MOD_SLIDER_UPLOADS_DIR);
		
		$filename = sb_build_slug($_FILES['slide']['name']);
		$filename = sb_get_unique_filename($filename, MOD_SLIDER_UPLOADS_DIR);
		move_uploaded_file($_FILES['slide']['tmp_name'], $filename);
		if( !isset($sliders[$id]->images) || !is_array($sliders[$id]->images) )
			$sliders[$id]->images = array();
		$sliders[$id]->images[] = array('image' => basename($filename), 
										'title' => SB_Request::getString('title'), 
										'description' => SB_Request::getString('description'),
										'link'			=> SB_Request::getString('link')
		);
		sb_update_parameter('sliders', $sliders);
		SB_MessagesStack::AddMessage(__('The slide has been added', 'slider'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=slider&view=edit&id='.$id));
	}
	public function task_delete_img()
	{
		$slider_id 	= SB_Request::getString('sid');
		$img_index 	= SB_Request::getInt('id');
		$sliders = (array)sb_get_parameter('sliders', array());
		if( !isset($sliders[$slider_id]) )
		{
			return false;
		}
		$slider =& $sliders[$slider_id];
		//##delete slide image
		@unlink(MOD_SLIDER_UPLOADS_DIR . SB_DS . $slider->images[$img_index]->image);
		unset($slider->images[$img_index]);
		sb_update_parameter('sliders', $sliders);
		SB_MessagesStack::AddMessage(__('The slide has been deleted'), 'success');
		sb_redirect(SB_Route::_('index.php?mod=slider&view=edit&id='.$slider_id));
	}
	public function task_reset()
	{
		sb_update_parameter('sliders', array());
	}
}
