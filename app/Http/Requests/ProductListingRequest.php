<?php

namespace Closet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductListingRequest extends FormRequest
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
        'price' => 'required',
        'description' => 'required',  
        'category_id' => 'required',
        'subcategory_id' => 'required',                             
        'image' => 'required',                             
        ];
    }

    public function messages()
    {
    return [
        'category_id.required' => 'Please select category',
        'subcategory_id.required' => 'Please select subcategory',
        'image.required'  => 'Please choose some image',
    ];
    }
}
