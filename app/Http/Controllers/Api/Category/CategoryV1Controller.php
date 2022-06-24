<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\Category\CategoryTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAPIRequest;
use App\Models\Category;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Category resource representation
 * @Resource("Categories", uri="/categories")
 */
class CategoryV1Controller extends Controller
{
    use Helpers;

    public function __construct(Category $category)
    {
        $this->middleware('auth:sanctum');
        $this->category = $category;
    }

    /**
     * It returns a paginated list of categories, using the `CategoryTransformer` to transform the data
     *
     * @return A paginated list of categories.
     */
    public function index()
    {
        $categories = $this->category->paginate(10);

        return $this->response->paginator($categories, new CategoryTransformer());
    }

    /**
     * It returns a single category
     *
     * @param id The ID of the category to show
     *
     * @return A single category
     */
    public function show($id)
    {
        $category = $this->category->find($id);
        if (!$category) {
            return $this->response->errorNotFound('Category not found');
        }

        return $this->response->item($category, new CategoryTransformer());
    }

    /**
     * It creates a new category and returns a success message
     *
     * @param CategoryAPIRequest request The request object.
     */
    public function store(CategoryAPIRequest $request)
    {
        if (!auth()->user()->can('create-categories')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to create categories.');
        }

        $category = $this->category->create([
            'name' => $request->name,
            'slug' => $request->slug ? $request->slug : Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'keywords' => $request->keywords,
        ]);

        return $this->response->item($category, new CategoryTransformer());
    }

    /**
     * It updates the category with the given id
     *
     * @param Request request The request object.
     * @param id The id of the category to be updated.
     *
     * @return An array with a message.
     */
    public function update(Request $request, $id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return $this->response->errorNotFound('Category not found');
        }

        if (!auth()->user()->can('update-categories')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to update categories.');
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

    /**
     * It deletes a category by its ID
     *
     * @param id The ID of the category to be deleted.
     *
     * @return A JSON response with a message.
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return $this->response->errorNotFound('Category not found');
        }

        if (!auth()->user()->can('delete-categories')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to delete categories.');
        }

        $category->delete();

        return $this->response->array([
            'message' => 'Category deleted successfully',
        ]);
    }
}
