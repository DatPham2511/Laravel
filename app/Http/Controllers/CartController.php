<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Models\Coupon;
use Carbon\Carbon;
session_start();

class CartController extends Controller
{
    public function add_cart_ajax(Request $request){
        // Session::forget('cart');
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_available=0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_available++;
                }
            }
            if($is_available==0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                    'product_cost' => $data['cart_product_cost'],
                    'product_slug' => $data['cart_product_slug'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'product_cost' => $data['cart_product_cost'],
                'product_slug' => $data['cart_product_slug'],
            );
            Session::put('cart',$cart);
        }

        Session::save();
    }
    public function show_cart(Request $request){
        //menu
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->get();
        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function delete_cart($session_id){
        $cart = Session::get('cart');
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back();

        }else{
            return redirect()->back();
        }

    }
    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            $message = '';
            foreach($data['cart_qty'] as $key => $qty){

                foreach($cart as $session => $val){

                    if($val['session_id']==$key  && $qty<=$cart[$session]['product_quantity']){
                        $cart[$session]['product_qty'] = $qty;
                    } elseif($val['session_id']==$key && $qty>$cart[$session]['product_quantity']){
                        $message.='Sản phẩm '.$cart[$session]['product_name'].' trong kho không đủ<br>';
                        Session::put('message', $message);
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back();
        }else{
            return redirect()->back()->with('message','Cập nhật số lượng thất bại');
        }
    }
    //mã giảm giá
    public function check_coupon(Request $request){
        $today=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $request->validate([
            'coupon' =>'required',

        ],[
            'coupon.required' =>'Mã giảm giá không được để trống',
        ]
        );
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status','=',1)->where('coupon_date_start','<=',$today)->first();
        $coupon_quantity = Coupon::where('coupon_code',$data['coupon'])->where('coupon_quantity','>',0)->first();
        $coupon_date = Coupon::where('coupon_code',$data['coupon'])->where('coupon_date_end','>=',$today)->first();
        if( $coupon){
           if($coupon_quantity){
            if($coupon_date){
                        $cou[] = array(
                                'coupon_code' => $coupon->coupon_code,
                                'coupon_condition' => $coupon->coupon_condition,
                                'coupon_number' => $coupon->coupon_number,
                            );
                        Session::put('coupon',$cou);

                    Session::save();
                    return redirect()->back();
            }else{
                return redirect()->back()->with('message','Mã giảm giá đã hết hạn');
            }
           }else{
            return redirect()->back()->with('message','Mã giảm giá đã hết');
           }
        }else{
            return redirect()->back()->with('message','Mã giảm giá không đúng');
        }

    }
    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon==true){
            // Session::destroy();
            Session::forget('coupon');
            return redirect()->back();
        }
    }
    public function show_cart_menu(){
        $cart=count(Session::get('cart'));
        $output='';
        if( $cart>0){
        $output.='<span class="badges">'.$cart.'</span>';
        }
        else{
            $output.='';
        }
        echo $output;

    }
    public function hover_cart(){

        $cart=count(Session::get('cart'));
        $output='';
        if( $cart>0){
        $output.='<ul class="hover-cart">';
                foreach(Session::get('cart') as $key => $value){
                $output.='<li>
                    <a href="'.url('/chi-tiet-san-pham/'.$value['product_slug']).'">
                        <img src="'.asset('uploads/product/'.$value['product_image']).'" >
                        <p>'.$value['product_name'].'</p>
                        <p>'.number_format($value['product_price'],0,',','.').' vnđ</p>
                        <p>Số lượng: '.$value['product_qty'].'</p>
                    </a>

                </li>';
                }
        $output.='</ul>';
        }
        echo $output;

    }
    public function remove_item(Request $request){
        $data=$request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['product_id']==$data['id']){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
        }


    }
    public function cart_session(Request $request){
       $output='';
        $cart = Session::get('cart');
        if($cart==true){
            foreach($cart as $key => $val){
                $output.='<input type="hidden" class="cart_id" value="'.$val['product_id'].'">';
            }
        }
        echo $output;


    }



}
