<?php

namespace App\Models;

use App\Entities\Category;
use Michalsn\Uuid\UuidModel;

class CategoryModel extends UuidModel
{
    protected $table = 'portal_categories';
    protected $primaryKey = 'category_id';
    protected $returnType = Category::class;
    protected $allowedFields = ['category_id', 'category_name'];

}