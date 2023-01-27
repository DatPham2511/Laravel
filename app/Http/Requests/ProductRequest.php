<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' =>'required',
            'product_quantity' =>'required|integer|min:1',
            'product_slug' =>'required|unique:tbl_product,product_slug',
            'product_price' =>'required',
            'product_cost' =>'required',
            'product_desc' =>'required',
            'product_content' =>'required',
            'product_image' =>'required',

        ];
    }
    public function messages(){
        return [
            'product_name.required' =>'Tên sản phẩm không được để trống',

            'product_quantity.required' =>'Số lượng không được để trống',
            'product_quantity.min' =>'Số lượng phải lớn hơn 0',
            'product_slug.required' =>'Slug không được để trống',
            'product_slug.unique' =>'Slug đã tồn tại',

            'product_price.required' =>'Giá bán không được để trống',

            'product_cost.required' =>'Giá gốc không được để trống',
            'product_content.required' =>'Chi tiết sản phẩm không được để trống',
            'product_desc.required' =>'Mô tả không được để trống',
            'product_image.required' =>'Hình ảnh không được để trống'

        ];
    }
}
