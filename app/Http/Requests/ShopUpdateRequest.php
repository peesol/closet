<?php

namespace Closet\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ShopUpdateRequest extends FormRequest
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

        $shopId = Auth::user()->shop->id;

        return [
            'name' => 'required|max:50|min:3|unique:shops,name,' . $shopId,
            'slug' => 'required|max:30|min:3|alpha_dash|unique:shops,slug,' . $shopId,
            'description' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'This URL has already been taken.',
            'slug.required' => 'URL field is required.',
            'slug.alpha_num' => 'URL must only contain letters or numbers.',
            'slug.max' => 'URL must be between 3 - 30 characters',
            'slug.min' => 'URL must be between 3 - 30 characters',
            'name.unique' => 'This name has already been taken.',
            'name.required' => 'Name field is required.',
            'description.max' => 'Description must not exeed 1000 characters',

        ];
    }
}
