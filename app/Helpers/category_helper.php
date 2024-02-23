<?php

namespace App\Helpers;

use App\Models\CategoryModel;
use App\Entities\Category;
use \Ramsey\Uuid\Uuid;

function getCategories(): array
{
    $model = new \App\Models\CategoryModel();
    return $model->findAll();

}


/**
 * @throws ReflectionException
 */
function createAndStoreCategory(string $categoryName): Category
{
    $categoryModel = new CategoryModel();
    $category = new Category();
    $category->category_id = Uuid::uuid4();
    $category->category_name = $categoryName;
    $categoryModel->insert($category);
    return $category;
}

function getCategoryByName(string $categoryName)
{
    $categoryModel = new CategoryModel();
    return $categoryModel->where('category_name', $categoryName)->first();
}



/**
 * @throws ReflectionException
 */
function updateOrDeleteCategories(array $updatedCategories): void
{
    $categoryModel = new CategoryModel;
    $allCategories = $categoryModel->findAll();
    foreach ($allCategories as $allCategory) {

        if (!array_key_exists($allCategory->category_id, $updatedCategories)) {
            deleteCategory($allCategory->category_id);
        }
    }
    foreach ($updatedCategories as $categoryId => $categoryName) {
        updateCategory($categoryId, $categoryName);
    }

}

/**
 * @throws ReflectionException
 */
function updateCategory($categoryId, $categoryName)
{
    $categoryModel = new CategoryModel();
    $categoryModel->update($categoryId, ['category_name' => $categoryName]);
}


function deleteCategory(string $categoryId): void
{
    $categoryModel = new CategoryModel();
    $categoryModel->delete($categoryId);
}
