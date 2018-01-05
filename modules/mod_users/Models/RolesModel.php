<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SinticBolivia\SBFramework\Modules\Users\Models;
use SinticBolivia\SBFramework\Classes\SB_Model;
use SinticBolivia\SBFramework\Modules\Users\Classes\SB_Role;

/**
 * Description of RolesModel
 *
 * @author marcelo
 */
class RolesModel extends SB_Model
{
    //put your code here
    public function Create(SB_Role $role)
    {
        //##create a new user role
        $data = $role->_dbData;
        $data['creation_date'] = $cdate;
        $role_id = $this->dbh->Insert('user_roles', $data);
        
        return $role_id;
    }
    public function Update(SB_Role $role)
    {
        $data = $role->_dbData;
       
        //##update the user role
		$this->dbh->Update('user_roles', $data, array('role_id' => $role->role_id));
        
        return $role->role_id;
    }
    public function Save(SB_Role $role)
    {
        if( !$role->role_id )
		{
            return $this->Create($role);
		}
		else
		{
			return $this->Update($role);
		}
        
    }
    public function Delete($roleId)
    {
        $query = "SELECT * FROM user_roles WHERE role_id = $roleId LIMIT 1";
		if( !$this->dbh->Query($query) )
		{
            throw new Exception($this->__('El role does not exists', 'users'));
		}
		$role = $this->dbh->FetchRow();
		$slug = sb_build_slug($role->role_name);
		$this->dbh->Query("DELETE FROM role2permission WHERE role_id = {$role->role_id}");
		$this->dbh->Query("DELETE FROM permissions WHERE (permission = 'create_role_$slug' OR permission = '$slug')");
		$this->dbh->Query("DELETE FROM user_roles WHERE role_id = {$role->role_id} LIMIT 1");
    }
    /**
     * Check if a role name already exists
     * 
     * @param string $roleName
     * @return bool
     */
    public function RoleNameExists($roleName)
    {
        //##check for duplicated role name
        $query = "SELECT role_id, role_name FROM user_roles WHERE role_name = '$roleName' LIMIT 1";
        return $this->dbh->Query($query) > 0 ? true : false;
    }
    public function SetPermissions($roleId, $perms)
    {
        $roleId = (int)$roleId;
        $this->dbh->Query("DELETE FROM role2permission WHERE role_id = $roleId");
        if( count($perms) )
        {
            $query = "INSERT INTO role2permission(role_id,permission_id) VALUES";
            foreach($perms as $perm_id)
            {
                $query .= "($roleId, $perm_id),";
            }
            $this->dbh->Query(rtrim($query, ','));
        }

        $data = array(
                'permission' 				=> 'create_role_' . sb_build_slug($role_name),
                'label'						=> sprintf($this->__('Asignar Rol %s'), $role_name),
                'last_modification_date'	=> $cdate,
                'creation_date'				=> $cdate
        );
        $this->dbh->Insert('permissions', $data);
        
        return true;
    }
}
