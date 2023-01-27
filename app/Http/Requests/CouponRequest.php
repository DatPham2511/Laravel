<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'coupon_name' =>'required',
            'coupon_quantity' =>'required|integer|min:1',
            'coupon_number' =>'required',
            'coupon_code' =>'required|unique:tbl_coupon,coupon_code',
            'coupon_date_start' =>'required',
            'coupon_date_end' =>'required',
        ];
    }
    public function messages(){
        return [
            'coupon_name.required' =>'Tên mã giảm giá không được để trống',

            'coupon_quantity.required' =>'Số lượng không được để trống',
            'coupon_quantity.min' =>'Số lượng phải lớn hơn 0',
            'coupon_number.required' =>'Số giảm không được để trống',
            'coupon_date_start.required' =>'Ngày bắt đầu không được để trống',
            'coupon_date_end.required' =>'Ngày kết thúc không được để trống',

            'coupon_code.required' =>'Mã giảm giá không được để trống',
            'coupon_code.unique' =>'Mã giảm giá đã tồn tại',

        ];
    }
}
