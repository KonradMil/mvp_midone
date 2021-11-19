<?php

namespace App\Repository\Eloquent\Admin;

use App\Models\Forum\Category;
use App\Models\Forum\Discussion;
use App\Models\Forum\Post;
use App\Repository\Eloquent\BaseRepository;

/**
 *
 */
class CategoryRepository extends BaseRepository
{

    /**
     * @param Category $category
     */
    public function __construct(Category $category = null)
    {
            parent::__construct($category);
    }

    public function getCategories()
    {
        $categories = Category::get();

        foreach ($categories as $category) {
            $count = 0;
            $category->subcategory = ($category->parent_id == NULL)? 'NIE' : 'TAK';
            $discussions = Discussion::where('category_id', '=', $category->id)->get();
            foreach ($discussions as $d) {
                $count += $d->posts()->count();
            }
            $category->posts_count =  $count;
        }
        return $categories;
    }

    public function getTopCategories()
    {
        return Category::where('parent_id', '=', NULL)->select(['name', 'id'])->get();
    }

    public function getCategoryChildren($id)
    {
        $category = Category::find($id);

        return Category::where('parent_id', '=', $category->id)->select(['name', 'id'])->get();
    }
}
