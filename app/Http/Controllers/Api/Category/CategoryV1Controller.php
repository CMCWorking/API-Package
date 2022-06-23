<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\Category\CategoryTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAPIRequest;
use App\Models\Category;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryV1Controller extends Controller
{
    use Helpers;

    public function __construct(Category $category)
    {
        $this->middleware('auth:sanctum');
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->paginate(10);

        return $this->response->paginator($categories, new CategoryTransformer());
    }

    public function show($id)
    {
        $category = $this->category->find($id);

        return $this->response->item($category, new CategoryTransformer());
    }

    public function store(CategoryAPIRequest $request)
    {
        $category = $this->category->create([
            'name' => $request->name,
            'slug' => $request->slug ? $request->slug : Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'keywords' => $request->keywords,
        ]);

        return $this->response->array([
            'message' => 'Category created successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return $this->response->errorNotFound('Category not found');
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ? $request->slug : Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'keywords' => $request->keywords,
        ]);

        return $this->response->array([
            'message' => 'Category updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return $this->response->errorNotFound('Category not found');
        }

        $category->delete();

        return $this->response->array([
            'message' => 'Category deleted successfully',
        ]);
    }
}
