@extends('layout')
@section('content')
<div class="col-sm-9 padding-right">
<section id="cart_items">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: none">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
              <li class="breadcrumb-item"><a href="{{url('/show-cart')}}">Giỏ hàng</a></li>
              <li class="breadcrumb-item">Thanh toán</li>
            </ol>
          </nav>


        @if(!Session::get('cart'))

            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Hình ảnh</td>
                            <td class="description">Tên sản phẩm</td>
                            <td class="price">Giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><center>
                            @php
                            echo 'Làm ơn thêm sản phẩm vào giỏ hàng';
                            @endphp
                            </center></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        @else
        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin đơn hàng</p>
                        <div class="form-one">
                            <form method="POST">
                                @csrf
                                <label for="">Email</label>
                                <input type="text" class="shipping_email" name="shipping_email" placeholder="Email" value="{{Session::get('customer_email')}}">
                                <label for="">Họ và tên</label>
                                <input type="text" class="shipping_name" name="shipping_name" placeholder="Họ và tên" value="{{Session::get('customer_name')}}">
                                <label for="">Địa chỉ</label>
                                <input type="text" class="shipping_address" name="shipping_address" placeholder="Địa chỉ" >
                                <label for="">Số điện thoại</label>
                                <input type="text" class="shipping_phone" name="shipping_phone" placeholder="Số điện thoại" value="{{Session::get('customer_phone')}}">
                                <label for="">Ghi chú</label>
                                <textarea name="shipping_notes"  class="shipping_notes" placeholder="Ghi chú đơn hàng" rows="5"></textarea>
                                <input type="hidden" class="vn_code"  value="{{request()->vnp_TxnRef}}">

                                @if(Session::get('fee'))
                                    <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                                 @else
                                    <input type="hidden" name="order_fee" class="order_fee" value="20000">
                                 @endif

                                 {{-- @if(Session::get('coupon'))
										@foreach(Session::get('coupon') as $key => $cou)
											<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
										@endforeach
								@else
										<input type="hidden" name="order_coupon" class="order_coupon" value="Không có">
								@endif --}}
                                @php
                                $total_after1 = 0;
                                 @endphp
                                @foreach(Session::get('cart') as $key => $cart1)
                                    @php
                                        $subtotal1 = $cart1['product_price']*$cart1['product_qty'];
                                        $total_after1+=$subtotal1;
                                    @endphp
                                @endforeach
                                @if(Session::get('coupon'))
                                        @foreach(Session::get('coupon') as $key => $cou1)
                                            @if($cou1['coupon_condition']==1)
                                                    @php
                                                    $total_coupon1 = ($total_after1*$cou1['coupon_number'])/100;

                                                    @endphp

                                            @elseif($cou1['coupon_condition']==0)
                                                    @php
                                                    $total_coupon1 = $cou1['coupon_number'];
                                                    @endphp
                                            @endif
                                        @endforeach
                                        <input type="hidden" name="fee_coupon" class="fee_coupon" value="{{$total_coupon1}}">
                                        @foreach(Session::get('coupon') as $key => $cou)
                                            <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                        @endforeach


                                    @else
                                        <input type="hidden" name="fee_coupon" class="fee_coupon" value="0">
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="Không có">
                                    @endif




                                       @if(request()->vnp_TransactionStatus=='00')
                                       <div class="form-group">
                                        <label for="exampleInputPassword1">Hình thức thanh toán</label>
                                         <select name="payment_select"  class="form-control input-sm m-bot15 payment_select">
                                               {{-- <option value="0">Chuyển khoản</option>
                                               <option value="1">Tiền mặt</option> --}}
                                               <option value="0">Đã thanh toán bằng VNPAY</option>

                                       </select>
                                    </div>
                                       @else
                                       <div class="form-group">
                                        <input type="hidden" value="1" class="payment_select">
                                    </div>
                                       @endif

                               <input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary send_order" style="width:40%">

                            </form>
                            </div>
                            <div class="form-two">
                            <form>
                                @csrf

                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn thành phố</label>
                                  <select name="city" id="city" class="form-control input-sm m-bot15 choose city">

                                        <option value="">--Chọn tỉnh thành phố--</option>
                                    @foreach($city as $key => $ci)
                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn quận huyện</label>
                                  <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                        <option value="">--Chọn quận huyện--</option>

                                </select>
                            </div>
                              <div class="form-group">
                                <label for="exampleInputPassword1">Chọn xã phường</label>
                                  <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                        <option value="">--Chọn xã phường--</option>
                                </select>
                            </div>
                            @if(request()->vnp_TransactionStatus!='00')

                            <input type="button" value="Tính phí vận chuyển" name="calculate_order" class="btn btn-primary calculate_delivery" style="width:30%">
                            @endif
                            </form>

                        </div>

                    </div>
                </div>

                <div class="col-sm-12 clearfix">
                    <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<div class="alert alert-danger">'.$message.'</div>';
                        Session::put('message',null);
                    }
                    ?>
                    <div class="table-responsive cart_info">

                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <td class="image">Hình ảnh</td>
                                    <td class="description" style="width:34%">Tên sản phẩm</td>

                                    <td class="price" style="width:15%">Giá</td>

                                    <td class="quantity" style="width:12%">Số lượng</td>
                                    <td class="total" style="width:23%">Thành tiền</td>


                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $total_after = 0;
                                @endphp
                                @foreach(Session::get('cart') as $key => $cart)
                                    @php
                                        $subtotal = $cart['product_price']*$cart['product_qty'];
                                        $total_after+=$subtotal;
                                    @endphp
                                <tr>
                                    <td class="cart_product">
                                        <a href=""><img width="100" height="auto" src="{{asset('uploads/product/'.$cart['product_image'])}}" alt=""></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4>{{$cart['product_name']}}</h4>
                                       <p>Mã ID: {{$cart['product_id']}}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{number_format($cart['product_price'],0,',','.')}} vnđ</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">

                                            <input style="width:70%"  class="cart_quantity_input" disabled type="number" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" min="1">
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">
                                            {{number_format($subtotal,0,',','.')}} vnđ
                                        </p>
                                    </td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td >
                                        @if(Session::get('cart'))
                                        @if(request()->vnp_TransactionStatus!='00')

                                                {{-- <a class="btn btn-default check_out" href="">Thanh toán</a> --}}

                                                <form action="{{URL::to('/check-coupon')}}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="text" name="coupon" class="form-control" placeholder="Mã giảm giá">
                                                    @error('coupon')
                                                    <p style="color: red;margin-bottom:0px;margin-top:5px">{{$message}}</p>
                                                    @enderror
                                                    <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá" style="margin-top:10px">

                                                </form>
                                        @endif
                                        @endif
                                    </td>
                                    <td colspan="3"></td>
                                    {{-- <td>
                                        @if(Session::get('coupon'))
                                        <a class="btn btn-default check_out" href="{{URL::to('/unset-coupon')}}" >Xóa mã giảm giá</a>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <li>Tổng tiền: <span>{{number_format($total_after,0,',','.')}} vnđ</span></li>

                                        @if(Session::get('coupon'))
                                                @foreach(Session::get('coupon') as $key => $cou)
                                                    @if($cou['coupon_condition']==1)
                                                    <li>
                                                        @if(request()->vnp_TransactionStatus!='00')
                                                            <a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a>
                                                        @endif

                                                            @php
                                                            $total_coupon = ($total_after*$cou['coupon_number'])/100;

															$total_after_coupon = $total_after-$total_coupon;

                                                            @endphp

                                                        Mã giảm {{$cou['coupon_number']}}%: -{{number_format($total_coupon,0,',','.')}} vnđ</li>
                                                    @elseif($cou['coupon_condition']==0)
                                                    <li>
                                                        @if(request()->vnp_TransactionStatus!='00')
                                                        <a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a>
                                                        @endif
                                                        Mã giảm: -{{number_format($cou['coupon_number'],0,',','.')}} vnđ</li>

                                                            @php
                                                            $total_coupon = $total_after - $cou['coupon_number'];
                                                            $total_after_coupon = $total_coupon;
                                                            @endphp


                                                    @endif
                                                @endforeach
                                        @endif
                                        @if(Session::get('fee'))
										<li>
                                            @if(request()->vnp_TransactionStatus!='00')
											<a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>
                                            @endif
											Phí vận chuyển: <span>{{number_format(Session::get('fee'),0,',','.')}} vnđ</span></li>

										@endif

                                            @php
                                                if(Session::get('fee') && !Session::get('coupon')){
                                                    $total_after = $total_after + Session::get('fee');
                                                    if($total_after>0){
                                                    echo '<li>Thanh toán: '.number_format($total_after,0,',','.').' vnđ</li>';
                                                    }else{
                                                    echo '<li>Thanh toán: 0 vnđ</li>';
                                                    }
                                                }elseif(!Session::get('fee') && Session::get('coupon')){
                                                    $total_after = $total_after_coupon;
                                                    if($total_after>0){
                                                        echo '<li>Thanh toán: '.number_format($total_after,0,',','.').' vnđ</li>';
                                                    }else{
                                                        echo '<li>Thanh toán: 0 vnđ</li>';
                                                    }

                                                }elseif(Session::get('fee') && Session::get('coupon')){
                                                    $total_after = $total_after_coupon + Session::get('fee');
                                                    if($total_after>0){
                                                        echo '<li>Thanh toán: '.number_format($total_after,0,',','.').' vnđ</li>';
                                                    }else{
                                                        echo '<li>Thanh toán: 0 vnđ</li>';
                                                    }

                                                }

                                            @endphp

                                    </td>

                                   </td>
                                </tr>


                            </tbody>
                            @if(request()->vnp_TransactionStatus!='00')
                            <tr>
                                <td>
                                <form action="{{URL::to('/vnpay-payment')}}" method="POST">
                                    @csrf

                                    <input type="hidden" value={{$total_after}} name="total_vnpay">
                                <button type="submit" class="btn btn-default check_out" name="redirect">
                                        Thanh toán VNPAY
                                </button>
                                </form>
                            </td>
                        </tr>
                            @endif


                        </table>

                    </div>
                </div>

            </div>
        </div>
        @endif



</section> <!--/#cart_items-->
</div>
@endsection
