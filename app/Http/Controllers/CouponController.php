<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests\CouponRequest;
use Auth;
use Mail;
session_start();

class CouponController extends Controller
{
    //admin
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function insert_coupon(){
        $this->AuthLogin();
        return view('admin.coupon.insert_coupon');
    }
    public function insert_coupon_code(CouponRequest $request){
        $this->AuthLogin();
        $data = $request->all();
    	$coupon = new Coupon();

    	$coupon->coupon_name = $data['coupon_name'];
    	$coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_date_start = $data['coupon_date_start'];
        $coupon->coupon_date_end = $data['coupon_date_end'];
    	$coupon->coupon_code = $data['coupon_code'];
    	$coupon->coupon_quantity = $data['coupon_quantity'];
    	$coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_status = $data['coupon_status'];
    	$coupon->save();

    	Session::put('message','Thêm mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function list_coupon(){
        $this->AuthLogin();
        $today=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
    	$coupon = Coupon::orderBy('coupon_id','DESC')->get();
    	return view('admin.coupon.list_coupon')->with(compact('coupon','today'));
    }
    public function delete_coupon($coupon_id){
        $this->AuthLogin();
    	$coupon = Coupon::find($coupon_id);
    	$coupon->delete();
    	Session::put('message','Xóa mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function unactive_coupon($coupon_id){
        $this->AuthLogin();
        Coupon::where('coupon_id',$coupon_id)->update(['coupon_status'=>0]);
        Session::put('message','Khóa mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function active_coupon($coupon_id){
        $this->AuthLogin();
        Coupon::where('coupon_id',$coupon_id)->update(['coupon_status'=>1]);
        Session::put('message','Kích hoạt mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function edit_coupon($coupon_code){
        $this->AuthLogin();
    	$coupon = Coupon::where('coupon_code',$coupon_code)->get();
    	return view('admin.coupon.edit_coupon')->with(compact('coupon'));
    }
    public function update_coupon(Request $request,$coupon_id){
        $this->AuthLogin();
        $request->validate([
            'coupon_name' =>'required',
            'coupon_quantity' =>'required|integer|min:1',
            'coupon_number' =>'required',
            'coupon_code' =>'required|unique:tbl_coupon,coupon_code,'.$coupon_id.',coupon_id',
            'coupon_date_start' =>'required',
            'coupon_date_end' =>'required',
        ],[
            'coupon_name.required' =>'Tên mã giảm giá không được để trống',

            'coupon_quantity.required' =>'Số lượng không được để trống',
            'coupon_quantity.min' =>'Số lượng phải lớn hơn 0',
            'coupon_number.required' =>'Số giảm không được để trống',
            'coupon_date_start.required' =>'Ngày bắt đầu không được để trống',
            'coupon_date_end.required' =>'Ngày kết thúc không được để trống',

            'coupon_code.required' =>'Mã giảm giá không được để trống',
            'coupon_code.unique' =>'Mã giảm giá đã tồn tại',
        ]
        );
        $data = array();
        $data['coupon_name'] = $request->coupon_name;
        $data['coupon_date_start'] = $request->coupon_date_start;
        $data['coupon_date_end'] = $request->coupon_date_end;
        $data['coupon_code'] = $request->coupon_code;
        $data['coupon_number'] = $request->coupon_number;
        $data['coupon_quantity'] = $request->coupon_quantity;
        $data['coupon_condition'] = $request->coupon_condition;
        Coupon::where('coupon_id',$coupon_id)->update($data);
    	Session::put('message','Cập nhật mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function send_coupon($coupon_code){
       $this->AuthLogin();
       $customer=Customer::all();
       $coupon=Coupon::where('coupon_code',$coupon_code)->first();
    //    $now=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
       $title_mail="Khuyến mãi Đạt Store";

       $data=[];
       foreach($customer as $cus){
        $data['email'][]=$cus->customer_email;
       }
       $coupon=array(
        'coupon_date_start'=>$coupon->coupon_date_start,
        'coupon_date_end'=>$coupon->coupon_date_end,
        'coupon_condition'=>$coupon->coupon_condition,
        'coupon_number'=>$coupon->coupon_number,
        'coupon_code'=>$coupon_code
       );

        Mail::send('admin.coupon.send_coupon',['coupon'=>$coupon],function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],'Đạt Store');

        });
        return redirect()->back()->with('message','Gửi mã giảm giá cho khách hàng thành công');


    }

}
