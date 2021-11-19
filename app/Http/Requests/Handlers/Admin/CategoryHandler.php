<?php

namespace App\Http\Requests\Handlers\Admin;

use App\Http\Requests\Handlers\RequestHandler;
use App\Parameters\Admin\CategoryParameters;
use phpDocumentor\Reflection\Types\Integer;

/**
 *
 */
class CategoryHandler extends RequestHandler
{

    /**
     * @return CategoryParameters
     */
    public function getParameters(): CategoryParameters
    {
        $parameters = new CategoryParameters();
        $category = $this->request->get('category');
        $parameters->name = $category['name'];
        $parameters->order = $category['order'] ?? '';
        $parameters->subtitle = $category['subtitle'] ?? '';
        $parameters->slug = $category['slug'] ?? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category['name'])));
        $parameters->color = $category['color'] ?? '';
        $parameters->parent_id = (int)$category['parent_id'];

        return $parameters;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
