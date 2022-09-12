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
        $entries[] = createEntryModel($db, $row);
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

    foreach ($entries as $entry) {
        foreach ($entry->buttons as $key => $value) {
            if ($value->entitledGroups) {
                if (is_null($user)) {
                    unset($entry->buttons[$key]);
                } else {
                    $found = false;
                    foreach ($value->entitledGroups as $entitledGroup) {
                        if (in_array($entitledGroup, $user->groups)) {
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        unset($entry->buttons[$key]);
                    }
                }
            }
        }
    }

    return $entries;
}

function createEntryModel($db, $entryRow): EntryModel
{
    $entitlementResult = $db->table('portal_entry_entitlements')->where('entry_id', $entryRow->id)->select()->get()->getResult();

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
        $buttons[] = createEntryButtonModel($db, $buttonRow);
    }

    return new EntryModel($entryRow->id, $entryRow->name, $entryRow->description, $entitledGroups, $buttons);
}

function createEntryButtonModel($db, $buttonRow): EntryButtonModel
{
    $entitlementResult = $db->table('portal_button_entitlements')->where('button_id', $buttonRow->id)->select()->get()->getResult();

    helper('group');
    $entitledGroups = [];
    foreach ($entitlementResult as $entitlementRow) {
        $group = getGroupById($entitlementRow->group_id);
        if (!is_null($group))
            $entitledGroups[] = $group;
    }

    return new EntryButtonModel($buttonRow->id, $buttonRow->name, EntryButtonColor::from($buttonRow->color), $entitledGroups, $buttonRow->url);
}