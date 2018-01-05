<?php
class LT_AdminControllerBcodeeditor extends SB_Controller
{
	public function task_edit()
	{
		$name	= SB_Request::getString('edit');
		$type	= SB_Request::getString('type');
		$template_dir = $type == 'backend' ? ADM_TEMPLATES_DIR : TEMPLATES_DIR;
		$template_dir .= '/' . $name;
		
		$title = __('Template Code Editor', 'bce');
		
		$files = sb_get_dir_contents($template_dir);
		$this->SetVars(get_defined_vars());
		$this->document->SetTitle($title);
	}
}