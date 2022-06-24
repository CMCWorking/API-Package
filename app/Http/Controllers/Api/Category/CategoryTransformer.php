<?php
namespace App\Http\Controllers\Api\Category;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' => $category['id'],
            'name' => $category['name'],
            'description' => $category['description'],
            'slug' => $category['slug'],
            'image' => $category['image'],
            'parent_id' => $category['parent_id'],
            'keywords' => $category['keywords'],
            'status' => $category['status'],
        ];
    }
}
