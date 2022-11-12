<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use function App\Helpers\protectRoute;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = getCategories();
        return $this->render('categories/CategoryView', ['categories' => $categories]);
    }

    /**
     * @throws \ReflectionException
     */
    public function update()
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