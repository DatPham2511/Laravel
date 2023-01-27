<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\City;
use App\Models\Category;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderDetails;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function CustomerLogin(){
        if(!Session::get('customer_id')){
            return redirect()->back();
        }
    }
    public function login_checkout(){
        $cate_product = Category::where('category_status','1')->get();

        return view('pages.checkout.login_checkout')->with('category',$cate_product);
    }
    public function add_customer(Request $request){
        $request->validate([
            'customer_name' =>'required',
            'customer_email' =>'required|email|unique:tbl_customer,customer_email',
            'customer_password' =>'required',
            'customer_phone' =>'required',
        ],[
            'customer_name.required' =>'Tên không được để trống',
            'customer_email.required' =>'Email không được để trống',
            'customer_email.email' =>'Email không đúng định dạng',
            'customer_email.unique' =>'Email đã tồn tại',
            'customer_password.required' =>'Mật khẩu không được để trống',
            'customer_phone.required' =>'Số điện thoại không được để trống',
        ]
        );
    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_phone'] = $request->customer_phone;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_password'] = $request->customer_password;

    	$customer_id = DB::table('tbl_customer')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
        Session::put('customer_phone',$request->customer_phone);
        Session::put('customer_email',$request->customer_email);
    	return Redirect::to('/checkout');

    }

    public function checkout(Request $request){
        $this->CustomerLogin();

        $city = City::get();
        $cate_product = Category::where('category_status','1')->get();
    	return view('pages.checkout.show_checkout')
        ->with('city',$city)
        ->with('category',$cate_product);;
    }


    public function logout_checkout(){
        Session::flush();
    	return Redirect::to('/login-checkout');
    }

    public function login_customer(Request $request){
        $request->validate([
            'password_account' =>'required',
            'email_account' =>'required|email',
        ],[
            'password_account.required' =>'Mật khẩu không được để trống',
            'email_account.required' =>'Email không được để trống',
            'email_account.email' =>'Email không đúng định dạng',
        ]
        );
    	$email = $request->email_account;
    	$password = $request->password_account;
    	$result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();
    	if($result){
    		Session::put('customer_id',$result->customer_id);
            Session::put('customer_name',$result->customer_name);
            Session::put('customer_phone',$result->customer_phone);
            Session::put('customer_email',$result->customer_email);
    		return Redirect::to('/checkout');
    	}else{
    		return Redirect::to('/login-checkout')->with('error','Email hoặc mật khẩu không đúng');
    	}
    }


    //trang chủ - chọn tp
    public function select_delivery_home(Request $request){
        $this->CustomerLogin();

        $data = $request->all();
    	if($data['action']){
    		$output = '';
    		if($data['action']=="city"){
    			$select_province = Province::where('matp',$data['ma_id'])->get();
    				$output.='<option>---Chọn quận huyện---</option>';
    			foreach($select_province as $key => $province){
    				$output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
    			}

    		}else{

    			$select_wards = Wards::where('maqh',$data['ma_id'])->get();
    			$output.='<option>---Chọn xã phường---</option>';
    			foreach($select_wards as $key => $ward){
    				$output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
    			}
    		}
    		echo $output;
    	}
    }
    //trang chủ - tính phí vận chuyển
    public function calculate_fee(Request $request){
        $this->CustomerLogin();
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                     foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{
                    Session::put('fee',20000);
                    Session::save();
                }
            }

        }
    }
    //trang chủ - xóa phí
    public function del_fee(){
        $this->CustomerLogin();
        Session::forget('fee');
        return redirect()->back();
    }
    //trang chủ - Đặt hàng
    public function confirm_order(Request $request){
        $this->CustomerLogin();

        $data = $request->all();
        //Mã
        if(Session::get('coupon')){
            $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
            $coupon->coupon_quantity=$coupon->coupon_quantity -1;
            $coupon->save();
        }
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;
        if($data['vn_code']==""){
            $checkout_code = substr(md5(microtime()),rand(0,26),5);
        }else{
            $checkout_code =  $data['vn_code'];
        }

        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 0;
        $order->order_code = $checkout_code;


        $today=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $order_date=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

        $order->created_at = $today;
        $order->order_date = $order_date;
        $order->save();

        if(Session::get('cart')==true){
           foreach(Session::get('cart') as $key => $cart){
               $order_details = new OrderDetails();
               $order_details->order_code = $checkout_code;
               $order_details->product_id = $cart['product_id'];
               $order_details->product_name = $cart['product_name'];
               $order_details->product_price = $cart['product_price'];
               $order_details->product_quantity = $cart['product_qty'];
               $order_details->product_cost = $cart['product_cost'];
               $order_details->product_coupon =  $data['order_coupon'];
               $order_details->fee_coupon =  $data['fee_coupon'];
               $order_details->product_feeship = $data['order_fee'];
               $order_details->save();
           }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');


   }



   //vnpay
   public function vnpay_payment(Request $request){
    $this->CustomerLogin();
    $data= $request->all();

    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "https://datstore.com/laravel/public/checkout";
    $vnp_TmnCode = "D6WLKR6I";//Mã website tại VNPAY
    $vnp_HashSecret = "ZWWXSEYDXXNFXGDFOXDJAXNZWSRBHQTZ"; //Chuỗi bí mật

    $vnp_TxnRef = substr(md5(microtime()),rand(0,26),5); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = 'Thanh toán VNPAY';
    $vnp_OrderType = 110000;
    $vnp_Amount =  $data['total_vnpay'] * 100;
    $vnp_Locale =   'vn';
    $vnp_BankCode =  '';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    // $vnp_ExpireDate = $_POST['txtexpire'];
    //Billing
    // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
    // $vnp_Bill_Email = $_POST['txt_billing_email'];
    // $fullName = trim($_POST['txt_billing_fullname']);
    // if (isset($fullName) && trim($fullName) != '') {
    //     $name = explode(' ', $fullName);
    //     $vnp_Bill_FirstName = array_shift($name);
    //     $vnp_Bill_LastName = array_pop($name);
    // }
    // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
    // $vnp_Bill_City=$_POST['txt_bill_city'];
    // $vnp_Bill_Country=$_POST['txt_bill_country'];
    // $vnp_Bill_State=$_POST['txt_bill_state'];
    // // Invoice
    // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
    // $vnp_Inv_Email=$_POST['txt_inv_email'];
    // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
    // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
    // $vnp_Inv_Company=$_POST['txt_inv_company'];
    // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
    // $vnp_Inv_Type=$_POST['cbo_inv_type'];
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        // "vnp_ExpireDate"=>$vnp_ExpireDate,
        // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
        // "vnp_Bill_Email"=>$vnp_Bill_Email,
        // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
        // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
        // "vnp_Bill_Address"=>$vnp_Bill_Address,
        // "vnp_Bill_City"=>$vnp_Bill_City,
        // "vnp_Bill_Country"=>$vnp_Bill_Country,
        // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
        // "vnp_Inv_Email"=>$vnp_Inv_Email,
        // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
        // "vnp_Inv_Address"=>$vnp_Inv_Address,
        // "vnp_Inv_Company"=>$vnp_Inv_Company,
        // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
        // "vnp_Inv_Type"=>$vnp_Inv_Type
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }

    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);

        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }

    }








}
