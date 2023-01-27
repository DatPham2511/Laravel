<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'brand_product_name' =>'required',
            'slug_brand_product' =>'required|unique:tbl_brand_product,brand_slug',
            'brand_product_desc' =>'required',
        ];
    }
    public function messages(){
        return [
            'brand_product_name.required' =>'Tên thương hiệu không được để trống',
            'slug_brand_product.required' =>'Slug không được để trống',
            'slug_brand_product.unique' =>'Slug đã tồn tại',
            'brand_product_desc.required' =>'Mô tả không được để trống'
        ];
    }
}
