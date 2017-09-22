<?php
class LT_ThemeAngle extends LT_BaseTheme
{
	public function AddActions()
	{
		$task = SB_Request::getTask();
		parent::AddActions();
		if( lt_is_admin() )
		{
			if( $task == 'angle_set_colors' )
			{
				$theme = basename(SB_Request::getString('theme'));
				sb_update_user_meta(sb_get_current_user()->user_id, '_angle_colors', $theme);
				die();
			}
		}
	}
}
LT_ThemeAngle::GetInstance();