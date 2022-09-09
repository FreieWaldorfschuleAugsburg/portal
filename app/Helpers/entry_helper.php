<?php

namespace App\Helpers;

use App\Models\EntryButtonColor;
use App\Models\EntryButtonModel;
use App\Models\EntryModel;
use App\Models\UserModel;

/**
 * @return EntryModel[]
 */
function entries(?UserModel $user): array
{
    $db = db_connect('default');
    $result = $db->table('portal_entries')->select()->get()->getResult();

    $entries = [];
    foreach ($result as $row) {
        $entries[] = createEntryModel($row);
    }

    foreach ($entries as $key => $value) {
        if ($value->entitledGroups) {
            if (is_null($user)) {
                unset($entries[$key]);
            } else {
                $found = false;
                foreach ($value->entitledGroups as $entitledGroup) {
                    if (in_array($entitledGroup, $user->groups)) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    unset($entries[$key]);
                }
            }
        }
    }

    return $entries;
}

function createEntryModel($entryRow): EntryModel
{
    $db = db_connect('default');
    $entitlementResult = $db->table('portal_entitlements')->where('entry_id', $entryRow->id)->select()->get()->getResult();

    helper('group');
    $entitledGroups = [];
    foreach ($entitlementResult as $entitlementRow) {
        $group = getGroupById($entitlementRow->group_id);
        if (!is_null($group))
            $entitledGroups[] = $group;
    }

    $buttonResult = $db->table('portal_buttons')->where('entry_id', $entryRow->id)->select()->get()->getResult();

    $buttons = [];
    foreach ($buttonResult as $buttonRow) {
        $buttons[] = createEntryButtonModel($buttonRow);
    }

    return new EntryModel($entryRow->id, $entryRow->name, $entryRow->description, $entitledGroups, $buttons);
}

function createEntryButtonModel($buttonRow): EntryButtonModel
{
    return new EntryButtonModel($buttonRow->id, $buttonRow->name, EntryButtonColor::from($buttonRow->color), $buttonRow->url);
}