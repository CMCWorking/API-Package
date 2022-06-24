<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'image' => 'required|string',
            'status' => 'required|integer',
            'slug' => 'unique:categories',
            'parent_id' => 'integer',
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'The name field is required.',
            'image.required' => 'The image field is required.',
            'status.required' => 'The status field is required.',
            'slug.unique' => 'The slug has already been taken.',
            'parent_id.integer' => 'The parent id must be an integer.',
        ];
    }
}
