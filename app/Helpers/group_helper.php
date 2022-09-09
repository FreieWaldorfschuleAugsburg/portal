<?php

namespace App\Helpers;

use App\Models\GroupModel;

/**
 * @return GroupModel[]
 */
function getAllGroups(): array
{
    $db = db_connect('default');
    $result = $db->table('portal_groups')->select()->get()->getResult();

    $groups = [];
    foreach ($result as $row) {
        $groups[] = createGroupModel($row);
    }
    return $groups;
}

function getGroupById(int $id): ?GroupModel
{
    $db = db_connect('default');
    $result = $db->table('portal_groups')->where('id', $id)->select()->get()->getResult();
    if (!$result) {
        return null;
    }

    return createGroupModel($result[0]);
}

function createGroupModel($row): GroupModel
{
    return new GroupModel($row->id, $row->name, $row->internal_name, $row->admin);
}