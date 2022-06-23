<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\Category\CategoryTransformer;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryV1Controller extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $categories = Category::paginate(10);

        return $this->response->paginator($categories, new CategoryTransformer());
    }

    public function show($id)
    {
        $category = Category::find($id);

        return $this->response->item($category, new CategoryTransformer());
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            'image' => ['required', 'string'],
            'status' => ['required', 'integer'],
            'slug' => ['unique:categories'],
            'parent_id' => ['nullable', 'integer'],
            'keywords' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];

        $payload = app('request')->only(['name', 'slug', 'status', 'description', 'image', 'parent_id', 'keywords']);

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new Category.', $validator->errors());
        }

        $category = Category::create([
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
        $rules = [
            'name' => ['required', 'string'],
            'image' => ['string'],
            'status' => ['required', 'integer'],
            'slug' => ['unique:categories'],
            'parent_id' => ['nullable', 'integer'],
            'keywords' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];

        $payload = app('request')->only(['name', 'slug', 'status', 'description', 'image', 'parent_id', 'keywords']);

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not update Category.', $validator->errors());
        }

        $category = Category::find($id);

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
        $category = Category::find($id);

        if (!$category) {
            return $this->response->errorNotFound('Category not found');
        }

        $category->delete();

        return $this->response->array([
            'message' => 'Category deleted successfully',
        ]);
    }
}
