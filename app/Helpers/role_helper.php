<?php

namespace App\Helpers;


use App\Entities\Role;
use App\Models\GroupModel;
use App\Models\RoleModel;

function getRole(string $roleId): object|array|null
{
    $roleModel = new RoleModel();
    $role = $roleModel->find($roleId);
    $role->groups = getRoleGroups($roleId);
    return $role;
}


/**
 * @throws \ReflectionException
 */
function saveRole($role)
{
    $roleModel = new RoleModel();
    $roleModel->save($role);

    deleteGroups($role->role_id);


    foreach ($role->groups as $group) {
        storeGroup(createGroupEntity($group, $role->role_id));
    }

}


function deleteRole($roleId)
{
    $roleModel = new RoleModel();
    $roleModel->delete($roleId);
}


function getAllRoles(): array
{
    $model = new \App\Models\RoleModel();
    $roles = $model->findAll();

    foreach ($roles as $role) {
        $role->groups = \App\Helpers\getRoleGroups($role->role_id);
    }

    return $roles;
}
