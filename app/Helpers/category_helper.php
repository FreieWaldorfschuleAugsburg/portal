<?php


function getCategories(): array
{
    $model = new \App\Models\CategoryModel();
    return $model->findAll();

}


