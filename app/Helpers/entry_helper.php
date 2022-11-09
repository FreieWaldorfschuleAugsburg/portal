<?php

namespace App\Helpers;

use App\Entities\Entry;
use App\Models\CategoryWrapper;
use App\Models\EntryModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\IncomingRequest;


function getEntriesByCategory($roles = null)
{
    $builder = db_connect()->table(getenv('database.views.entriesWithCategoryAndRole'));
    $entries = [];

    $allCategories = db_connect()->table('portal_categories')->get()->getResult();

    foreach ($allCategories as $category) {
        $categoryEntries = $builder->getWhere(['role_id' => null, 'category_id' => $category->category_id])->getResult();
        if ($roles != null) {
            foreach ($roles as $role) {
                $entriesWithRole = $builder->getWhere(['role_id' => $role, 'category_id' => $category->category_id])->getResult();
                foreach ($entriesWithRole as $entryWithRole) {
                    if (!in_array($entryWithRole, $categoryEntries)) {
                        $categoryEntries[] = $entryWithRole;
                    }
                }

            }
        }
        if (sizeof($categoryEntries) > 0) {
            $categoryWrapper = new CategoryWrapper($category->category_id, $category->category_name, $categoryEntries);
            $entries[] = $categoryWrapper;
        }


    }

    return $entries;

}

function compareEntryCategory($entry1, $entry2)
{
    return strcmp($entry1->category_name, $entry2->category_name);
}


function getEntry(string $entryId)
{
    $entryModel = new EntryModel();
    return $entryModel->find($entryId);
}

function deleteEntry(string $entryId)
{
    $entryModel = new EntryModel();
    return $entryModel->delete($entryId);


}


function getEntryWithRoleAndCategory(string $entryId)
{
    return db_connect()->table(getenv('database.views.entriesWithCategoryAndRole'))->getWhere(['entry_id' => $entryId])->getFirstRow();
}


function createEntryFromForm($request, $entryId)
{

    $entry = new Entry();
    if (getEntry($entryId) != null) {
        $entry = getEntry($entryId);
    }
    $entry->entry_id = $entryId;
    $entry->entry_name = $request->getPost('name');
    $entry->entry_url = $request->getPost('url');
    $entry->entitled_role = strlen($request->getPost('role')) > 1 ? $request->getPost('role') : null;
    $entry->category_id = $request->getPost('category');
    $entry->entry_color_1 = $request->getPost('color1');
    $entry->entry_color_2 = $request->getPost('color2');


    return $entry;

}

/**
 * @throws \ReflectionException
 */
function saveEntry($entry)
{
    $entryModel = new EntryModel();
    try {
        $entryModel->update($entry->entry_id, $entry);
    } catch (DataException $exception){

    }

}


/**
 * @throws \ReflectionException
 */
function insertEntry($entry): bool
{
    $entryModel = new EntryModel();
    return $entryModel->insert($entry);
}

