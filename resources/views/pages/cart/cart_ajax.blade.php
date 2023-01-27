@extends('layout')
@section('content')
<div class="col-sm-9 padding-right">
<section id="cart_items">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: none">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
              <li class="breadcrumb-item">Giỏ hàng</li>
            </ol>
          </nav>
          <?php
          $message = Session::get('message');
          if($message){
              echo '<div class="alert alert-danger">'.$message.'</div>';
              Session::put('message',null);
          }
          ?>
        <div class="table-responsive cart_info">
            <form action="{{URL::to('/update-cart')}}" method="post">
                {{ csrf_field() }}
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>

                        <td class="price" style="width:15%">Giá</td>

                        <td class="quantity" style="width:12%">Số lượng</td>
                        <td class="total" style="width:20%">Thành tiền</td>
                        <td  style="width:3%"></td>
                    </tr>
                </thead>
                <tbody>
                    @if(Session::get('cart')==true)
                    @php
						$total = 0;
					@endphp
                    @foreach(Session::get('cart') as $key => $cart)
                        @php
							$subtotal = $cart['product_price']*$cart['product_qty'];
							$total+=$subtotal;
						@endphp
                    <tr>
                        <td class="cart_product">
                            <img width="100" height="auto" src="{{asset('uploads/product/'.$cart['product_image'])}}" alt="">
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
                                <input style="width:70%" class="cart_quantity_input" type="number" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" min="1">
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{number_format($subtotal,0,',','.')}} vnđ
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-cart/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                            @if(Session::get('customer_id'))
                            <a class="btn btn-default check_out" href="{{url('/checkout')}}" style="width:160px">Đặt hàng</a>
                            @else
                            <a class="btn btn-default check_out" href="{{url('/login-checkout')}}" style="width:160px">Đặt hàng</a>
                            @endif
                        </td>
                        <td colspan="3">
                            <input type="submit"  name="update_qty" value="Cập nhật giỏ hàng" class="btn btn-default check_out">

                        </td>
                        {{-- <td>
                            @if(Session::get('coupon'))
                            <a class="btn btn-default check_out" href="{{URL::to('/unset-coupon')}}" >Xóa mã giảm giá</a>
                            @endif
                        </td> --}}

                        <td colspan="2">
                            <li>Tổng tiền: <span>{{number_format($total,0,',','.')}} vnđ</span></li>
                            @if(Session::get('coupon'))
									@foreach(Session::get('coupon') as $key => $cou)
										@if($cou['coupon_condition']==1)
                                        <li><a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a>


												@php
												$total_coupon = ($total*$cou['coupon_number'])/100;

												@endphp
                                                 Mã giảm {{$cou['coupon_number']}}%: -{{number_format($total_coupon,0,',','.')}} vnđ</li>
											<li>Tổng còn: {{number_format($total-$total_coupon,0,',','.')}} vnđ</li>
										@elseif($cou['coupon_condition']==0)
                                        <li><a class="cart_quantity_delete" href="{{url('/unset-coupon')}}"><i class="fa fa-times"></i></a>
                                            Mã giảm: -{{number_format($cou['coupon_number'],0,',','.')}} vnđ</li>

												@php
												$total_coupon = $total - $cou['coupon_number'];
                                                if($total_coupon <= 0){
                                                    echo '<li>Tổng còn: 0 vnđ</li>';
                                                }
                                                else{
                                                    echo '<li>Tổng còn: '.number_format($total_coupon,0,',','.').' vnđ</li>';
                                                }
												@endphp

										@endif
									@endforeach
							@endif
                            {{-- <li>Phí vận chuyển: <span>Free</span></li>
                            <li>Tiền sau giảm: <span></span></li> --}}
                        </td>

                       </td>
                    </tr>
                </form>
                    <tr>
                        <td >
                            @if(Session::get('cart'))

                            <form action="{{URL::to('/check-coupon')}}" method="POST">
                                {{ csrf_field() }}
                                <input type="text" name="coupon" class="form-control" placeholder="Nhập mã giảm giá">
                                @error('coupon')
                                <p style="color: red;margin-bottom:0px;margin-top:5px">{{$message}}</p>
                                @enderror
                                <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá" style="margin-top:10px">

                            </form>

                            @endif
                        </td>
                        <td colspan="5"></td>

                    </tr>

                    @else
                    <tr>
                        <td colspan="6"><center>
                        @php
                        echo 'Làm ơn thêm sản phẩm vào giỏ hàng';
                        @endphp
                        </center></td>
                    </tr>
                    @endif
                </tbody>




            </table>

        </div>
    </div>
    </div>
</section> <!--/#cart_items-->




@endsection
