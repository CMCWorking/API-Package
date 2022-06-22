<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\Category\CategoryTransformer;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Dingo\Api\Routing\Helpers;

class CategoryV1Controller extends Controller
{
    use Helpers;

    public function index()
    {
        $categories = Category::paginate(10);

        return $this->response->paginator($categories, new CategoryTransformer());
    }
}
