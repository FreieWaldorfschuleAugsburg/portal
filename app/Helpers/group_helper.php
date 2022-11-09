<?php

namespace App\Helpers;

use App\Models\AuthException;
use App\Entities\Group;
use App\Models\GroupModel;
use Ramsey\Uuid\Uuid;

/**
 * @throws AuthException
 */


function getAllActiveDirectoryGroups(): array
{
    $connection = getAdminConnection();
    $groups = \LdapRecord\Models\ActiveDirectory\Group:: paginate();
    $groupNames = [];

    foreach ($groups as $group) {
        $groupNames[] = $group->getName();
    }

    sort($groupNames);
    return $groupNames;

}

function createGroupEntity(string $name, string $roleId): Group
{
    $group = new Group();
    $group->group_id = Uuid::uuid4();
    $group->internal_name = $name;
    $group->role_id = $roleId;

    return $group;
}

function getRoleGroups(string $roleId): array
{
    $groupModel = new GroupModel();
    return $groupModel->where('role_id', $roleId)->findAll();
}


function deleteGroups(string $roleId): void
{
    $groupModel = new GroupModel();
    $groupModel->where('role_id', $roleId)->delete();

}

/**
 * @throws \ReflectionException
 */
function storeGroup(Group $group): void
{
    $groupModel = new GroupModel();
    $groupModel->insert($group);

}






