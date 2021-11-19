<?php

namespace App\Services\Admin;

use App\Parameters\Admin\CategoryParameters;
use App\Repository\Eloquent\Admin\CategoryRepository;

/**
 *
 */
class CategoryService
{
    public CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function saveCategory(CategoryParameters $categoryParameters, $category)
    {
        foreach ($categoryParameters as $key => $parameter) {
            try {
                $category->{$key} = $parameter;
            }catch (\Exception $e) {
                report($e);
            }
        }
        $category->save();

        return $category;
    }

}
