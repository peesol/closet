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
            'name' => 'required|between:3,30|unique:shops,name,' . $shopId,
            'slug' => 'required|between:3,30|alpha_dash|unique:shops,slug,' . $shopId,
            'description' => 'max:1000',
        ];
    }
}
