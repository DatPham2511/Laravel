<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Statistic;
use App\Models\Category;
use App\Models\Information;
use Carbon\Carbon;
use Auth;
use PDF;

session_start();

class OrderController extends Controller
{
    //trang chu
    public function CustomerLogin(){
        if(!Session::get('customer_id')){
            return redirect()->back();
        }
    }
     //trang chủ-huy đơn hàng
     public function huy_don_hang(Request $request,$order_code){
        $this->CustomerLogin();
        $order = Order::where('order_code',$order_code)->first();
        // $order->order_destroy=$data['lydo'];
        $order->order_status=2;
        $order->save();
        return redirect()->back();

     }
    //trang chủ-lịch sử đơn hàng
    public function history_order(){
        $this->CustomerLogin();
        $category = Category::where('category_status','1')->get();
        $get_order = Order::where('customer_id',Session::get('customer_id'))->orderby('created_at','DESC')->paginate(10);
        return view('pages.history.history')->with(compact('get_order','category'));
    }
    public function view_history_order($order_code){
        $this->CustomerLogin();
        $category = Category::where('category_status','1')->get();

            $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
            $order = Order::where('order_code',$order_code)->get();
            foreach($order as $key => $ord){
                $customer_id = $ord->customer_id;
                $shipping_id = $ord->shipping_id;
                $order_status = $ord->order_status;
            }
            $customer = Customer::where('customer_id',$customer_id)->first();
            $shipping = Shipping::where('shipping_id',$shipping_id)->first();

            // $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

            // foreach($order_details as $key => $order_d){
            //     $product_coupon = $order_d->product_coupon;
            // }
            // if($product_coupon != 'Không có'){
            //     $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            //     $coupon_condition = $coupon->coupon_condition;
            //     $coupon_number = $coupon->coupon_number;
            // }else{
            //     $coupon_condition = 2;
            //     $coupon_number = 0;
            // }

            // return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));
            return view('pages.history.view_history_order')->with(compact('order_details','customer','shipping','order','order_status','category'));
    }




    //admin
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    //admin-đơn hàng
    public function manage_order(){
        $this->AuthLogin();
    	$order = Order::orderBy('created_at','DESC')->get();
    	return view('admin.order.manage_order')->with(compact('order'));
    }
    //admin-chi tiết đơn hàng
    public function view_order($order_code){
        $this->AuthLogin();
		$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
		$order = Order::where('order_code',$order_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		// $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		// foreach($order_details as $key => $order_d){
		// 	$product_coupon = $order_d->product_coupon;
		// }
		// if($product_coupon != 'Không có'){
		// 	$coupon = Coupon::where('coupon_code',$product_coupon)->first();
		// 	$coupon_condition = $coupon->coupon_condition;
		// 	$coupon_number = $coupon->coupon_number;
		// }else{
		// 	$coupon_condition = 2;
		// 	$coupon_number = 0;
		// }

		// return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));
		return view('admin.order.view_order')->with(compact('order_details','customer','shipping','order','order_status'));

	}
    //in đơn hàng
    public function print_order($checkout_code){
        $this->AuthLogin();
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		return $pdf->stream();
	}
    public function print_order_convert($checkout_code){
        $this->AuthLogin();
        $contact=Information::first();

		$order_details = OrderDetails::with('product')->where('order_code',$checkout_code)->get();
		$order = Order::where('order_code',$checkout_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;

		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		// $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

		// foreach($order_details as $key => $order_d){

		// 	$product_coupon = $order_d->product_coupon;
		// }
		// if($product_coupon != 'Không có'){
		// 	$coupon = Coupon::where('coupon_code',$product_coupon)->first();

		// 	$coupon_condition = $coupon->coupon_condition;
		// 	$coupon_number = $coupon->coupon_number;

		// 	// if($coupon_condition==1){
		// 	// 	$coupon_echo = $coupon_number.' %';
		// 	// }elseif($coupon_condition==0){
		// 	// 	$coupon_echo = number_format($coupon_number,0,',','.').' vnđ';
		// 	// }
		// }else{
		// 	$coupon_condition = 2;
		// 	$coupon_number = 0;
		// 	// $coupon_echo = '0 vnđ';
		// }

		$output = '';

		$output.='<style>
        body{
			font-family: DejaVu Sans;
		}

		.table-styling, .t1{
			border:1px solid #000;
            border-collapse:collapse;
            
		}


        .t2 {
            width:100%;
		}

		</style>

        <table class="t2">
                    <tr>
                        <td class="t2"></td>
                        <td class="t2" style="padding-left:50px">'.$contact->info_contact.'</td>
                    </tr>
		</table>

		<h1><center>Hóa đơn bán hàng</center></h1>

		<p>Tên khách hàng: '.$shipping->shipping_name.'</p>
        <p>Email: '.$shipping->shipping_email.'</p>
        <p>Số điện thoại: '.$shipping->shipping_phone.'</p>
        <p>Địa chỉ: '.$shipping->shipping_address.'</p>
        <p>Ghi chú: '.$shipping->shipping_notes.'</p>
        <p>Ngày đặt hàng: '.$ord->created_at.'</p>

		<br/>
			<table class="table-styling">
				<thead>
					<tr>
						<th class="t1" style="width:312px">Tên sản phẩm</th>

						<th class="t1" style="width:80px" >Số lượng</th>
						<th class="t1" style="width:150px">Giá sản phẩm</th>
						<th class="t1" style="width:150px">Thành tiền</th>
					</tr>
				</thead>
				<tbody>';

				$total = 0;

				foreach($order_details as $key => $product){

					$subtotal = $product->product_price*$product->product_quantity;
					$total+=$subtotal;

		$output.='
					<tr>
						<td class="t1">'.$product->product_name.'</td>


						<td class="t1">'.$product->product_quantity.'</td>
						<td class="t1">'.number_format($product->product_price,0,',','.').' vnđ'.'</td>
						<td class="t1">'.number_format($subtotal,0,',','.').' vnđ'.'</td>

					</tr>';
				}

				// if($coupon_condition==1){
				// 	$total_after_coupon = ($total*$coupon_number)/100;
	            //     $total_coupon = $total - $total_after_coupon;
				// }else{
                //   	$total_coupon = $total - $coupon_number;
				// }


		$output.= '<tr>


				<td colspan="4">';

		// 		if($coupon_condition==1){
        // $output.= '<p>Mã giảm '.$coupon_number.'%: -'.number_format($total_after_coupon,0,',','.').' vnđ </p>';
        //         } else if($coupon_condition==0){
        // $output.= '<p>Mã giảm: -'.$coupon_number.' vnđ </p>';
        //         }
                if($product->fee_coupon > 0){
        $output.=  '<p>Mã giảm: -'.number_format($product->fee_coupon,0,',','.').' vnđ'.'</p>';
                }

        $output.=
                '<p>Phí vận chuyển: '.number_format($product->product_feeship,0,',','.').' vnđ'.'</p>
				<p>Tổng tiền: '.number_format($total + $product->product_feeship - $product->fee_coupon ,0,',','.').' vnđ'.'</p>
				</td>
		</tr>';
		$output.='
				</tbody>

		</table>

		<p style="margin-left:465px">Ngày.....tháng.....năm.....</p>
			<table>
				<thead>

                    <tr>
                        <th width="200px">Khách hàng</th>
                        <th  width="730px">Người lập phiếu</th>

                    </tr>
				</thead>
				<tbody>
                ';

		$output.='
				</tbody>

		</table>

		';


		return $output;

	}
    //xử lý đơn hàng
    public function update_order_qty(Request $request){
        $this->AuthLogin();
		//update tình trạng
		$data = $request->all();

		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();

        //thống kê
            // if($data['product_coupon'] != 'Không có'){
            // 	$coupon = Coupon::where('coupon_code',$data['product_coupon'])->first();
            // 	$coupon_condition = $coupon->coupon_condition;
            // 	$coupon_number = $coupon->coupon_number;
            // }else{
            //     $coupon_condition = 2;
            // }

        $order_date=$order->order_date;
        $statistic=Statistic::where('order_date',$order_date)->get();
        if($statistic){
            $statistic_count=$statistic->count();
        }else{
            $statistic_count=0;
        }

		if($order->order_status==1){
            //thống kê
            $total_order=0;
            $sales=0;
            $profit=0;
            $quantity=0;
            //
			foreach($data['order_product_id'] as $key => $product_id){

				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;


                //thống kê
		        $order_details = OrderDetails::where('product_id',$product_id)->where('order_code',$data['order_code'])->first();

                $product_price=$order_details->product_price;
                $product_cost = $order_details->product_cost;
                //
				foreach($data['quantity'] as $key2 => $qty){
						if($key==$key2){
								$pro_remain = $product_quantity - $qty;
								$product->product_quantity = $pro_remain;
								$product->product_sold = $product_sold + $qty;
								$product->save();

                                //doanh thu thống kê
                                $quantity+=$qty;

                                $sales+= $product_price*$qty;
                                $profit+=$product_cost*$qty;
						}
				}
			}
            $total_order+=1;
            // if($coupon_condition==1){
            //     $sales_after_coupon = $sales-(($sales*$coupon_number)/100);
            //     $profit = $sales_after_coupon-$profit;
            // }elseif($coupon_condition==0){
            //     $sales_after_coupon=$sales-$coupon_number;
            //     $profit = $sales_after_coupon-$profit;
            // }elseif($coupon_condition==2){
            //     $sales_after_coupon=$sales;
            //     $profit = $sales_after_coupon-$profit;
            // }
            $sales_after_coupon=$sales-$data['fee_coupon'];
            $profit = $sales_after_coupon-$profit;


            //update doanh số thống kê
            if($statistic_count>0){
                $statistic_update=Statistic::where('order_date',$order_date)->first();
                $statistic_update->sales=$statistic_update->sales + $sales_after_coupon;
                $statistic_update->profit=$statistic_update->profit + $profit;
                $statistic_update->quantity=$statistic_update->quantity + $quantity;
                $statistic_update->total_order=$statistic_update->total_order + $total_order;
                $statistic_update->save();
            }else{
                $statistic_new=new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales_after_coupon;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();

            }

        }

	}
    //admin-update số lượng đơn
    public function update_qty(Request $request){
        $this->AuthLogin();
		$data = $request->all();
		$order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$order_details->product_quantity = $data['order_qty'];
		$order_details->save();
	}
    public function delete_order($order_code){
        $this->AuthLogin();
        $shipping=Order::where('order_code',$order_code)->first();
        $shipping_id= $shipping->shipping_id;
        OrderDetails::where('order_code',$order_code)->delete();
        Shipping::where('shipping_id', $shipping_id)->delete();
        Order::where('order_code',$order_code)->delete();
        Session::put('message','Xóa đơn hàng thành công');
        return Redirect::to('manage-order');


	}



}
