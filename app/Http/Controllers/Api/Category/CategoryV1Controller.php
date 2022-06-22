<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\Category\CategoryTransformer;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryV1Controller extends Controller
{
    use Helpers;

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
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'keywords' => $request->keywords,
        ]);

        return $this->response->item($category, new CategoryTransformer());
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image' => $request->image,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'keywords' => $request->keywords,
        ]);

        return $this->response->item($category, new CategoryTransformer());
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        return $this->response->noContent();
    }
}
