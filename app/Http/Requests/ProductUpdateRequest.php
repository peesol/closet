<?php

namespace Closet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'product_name' => 'required|max:150',
            'category_id' => 'required',
            'price' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'This field is required.',
            'category_id.required' => 'This field is required.',
            'price.required' => 'This field is required.',
            'description.required' => 'This field is required.',
        ];
    }
}
