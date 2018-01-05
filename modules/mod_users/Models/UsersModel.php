<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SinticBolivia\SBFramework\Modules\Users\Models;
use SinticBolivia\SBFramework\Classes\SB_Model;
/**
 * Description of UsersModel
 *
 * @author marcelo
 */
class UsersModel extends SB_Model
{
    //put your code here
    public function Create()
    {
        
    }
    public function Update()
    {
        
    }
    public function Delete($userId)
    {
        $user = new SB_User($userId);
		if( !$user->user_id )
			throw new Exception($this->__('The user does not exists', 'users'));
			
		$query = "DELETE FROM user_meta WHERE user_id = {$user->user_id}";
		$this->dbh->Query($query);
		$this->dbh->Query("DELETE FROM users WHERE user_id = {$user->user_id}");
        sb_delete_dir($user->GetDirectory());
        return true;
    }
}
