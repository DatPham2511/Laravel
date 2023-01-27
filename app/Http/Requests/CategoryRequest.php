<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_product_name' =>'required',
            'slug_category_product' =>'required|unique:tbl_category_product,category_slug',
            'category_product_desc' =>'required',
        ];
    }
    public function messages(){
        return [
            'category_product_name.required' =>'Tên danh mục không được để trống',
            'slug_category_product.required' =>'Slug không được để trống',
            'slug_category_product.unique' =>'Slug đã tồn tại',
            'category_product_desc.required' =>'Mô tả không được để trống'
        ];
    }
}
