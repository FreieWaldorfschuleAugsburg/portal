<?php

namespace App\Models;


class CategoryWrapper
{
    public string $categoryId;
    public string $categoryName;
    public array $categoryItems;

    /**
     * @param string $categoryId
     * @param string $categoryName
     * @param array $categoryItems
     */
    public function __construct(string $categoryId, string $categoryName, array $categoryItems)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->categoryItems = $categoryItems;
    }


}
