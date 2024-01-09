<?php

namespace App\Controllers;

use App\Models\AuthException;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class CategoryController extends BaseController
{
    /**
     * @throws AuthException
     */
    public function index(): string
    {
        $categories = getCategories();
        return $this->render('categories/CategoryView', ['categories' => $categories]);
    }

    /**
     * @throws ReflectionException
     */
    public function update(): RedirectResponse
    {
        $updatedCategories = $this->request->getPost('category');
        $addedCategories = $this->request->getPost('new_category');
        updateOrDeleteCategories($updatedCategories);
        if ($addedCategories) {
            foreach ($addedCategories as $addedCategory) {
                createAndStoreCategory($addedCategory);
            }
        }

        return redirect('categories');
    }
}