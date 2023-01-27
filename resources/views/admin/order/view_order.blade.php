@extends('admin.admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin đăng nhập
      </div>

      <div class="table-responsive">
                              <?php
                              $message = Session::get('message');
                              if($message){
                                  echo '<span class="text-alert">'.$message.'</span>';
                                  Session::put('message',null);
                              }
                              ?>
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>

              <th>Tên khách hàng</th>
              <th>Email</th>
              <th>Số điện thoại</th>


            </tr>
          </thead>
          <tbody>

            <tr>
              <td>{{$customer->customer_name}}</td>
              <td>{{$customer->customer_email}}</td>
              <td>{{$customer->customer_phone}}</td>

            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin người nhận
      </div>

      <div class="table-responsive">
                              <?php
                              $message = Session::get('message');
                              if($message){
                                  echo '<span class="text-alert">'.$message.'</span>';
                                  Session::put('message',null);
                              }
                              ?>
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên người nhận</th>
              <th>Email</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ</th>
              <th>Ghi chú</th>
              <th>Hình thức thanh toán</th>

            </tr>
          </thead>
          <tbody>

            <tr>
              <td>{{$shipping->shipping_name}}</td>
              <td>{{$shipping->shipping_email}}</td>
              <td>{{$shipping->shipping_phone}}</td>
              <td>{{$shipping->shipping_address}}</td>
              <td>{{$shipping->shipping_notes}}</td>
              <td>
                @if($shipping->shipping_method==0)
                Chuyển khoản
                @else
                Tiền mặt
                @endif
                </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Chi tiết đơn hàng
    </div>

    <div class="table-responsive">
                            <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>

            <th>Tên sản phẩm</th>
            <th>Mã giảm giá</th>

            <th>Số lượng tồn kho</th>
            <th>Số lượng</th>

            <th>Giá</th>
            <th>Thành tiền</th>

          </tr>
        </thead>
        <tbody>
            @php

            $total = 0;
            @endphp
          @foreach($order_details as $key => $details)
          @php

              $subtotal = $details->product_quantity*$details->product_price;
              $total+=$subtotal;
          @endphp
          <tr class="color_qty_{{$details->product_id}}">

            <td>{{$details->product_name}}</td>
            <td>{{$details->product_coupon}}</td>

            <td>{{$details->product->product_quantity}}</td>
            <td>
                <input style="width:70px" {{$order_status!=0 ? 'disabled' : ''}} class="order_qty_{{$details->product_id}}" type="number" min="1" value="{{$details->product_quantity}}" name="product_sales_quantity">

                <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">

                <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

                <input type="hidden" name="fee_coupon" class="fee_coupon" value="{{$details->fee_coupon}}">


                <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantity}}">
                @if($order_status==0)
                <button data-product_id="{{$details->product_id}}" class="btn btn-default btn-sm update_quantity_order" name="update_quantity" style="margin-top:-2px">Cập nhật</button>
                @endif
            </td>
            <td>{{number_format($details->product_price ,0,',','.')}} vnđ</td>
            <td>{{number_format( $subtotal ,0,',','.')}} vnđ</td>
          </tr>
          @endforeach
          <tr>

            <td colspan="6">
                @php
                $total_coupon = 0;
              @endphp
              {{-- @if($coupon_condition==1)
                  @php
                $total_after_coupon = ($total*$coupon_number)/100;
                  echo 'Mã giảm '.$coupon_number.'%: -'.number_format($total_after_coupon,0,',','.').' vnđ</br>';
                  $total_coupon = $total  - $total_after_coupon + $details->product_feeship;
                  @endphp
              @elseif($coupon_condition==0)
                  @php
                  echo 'Mã giảm: -'.number_format($coupon_number,0,',','.').' vnđ'.'</br>';
                  $total_coupon = $total  - $coupon_number + $details->product_feeship ;
                  @endphp
              @else --}}
                  @php
                  $total_coupon = $total + $details->product_feeship-$details->fee_coupon ;
                  @endphp
              {{-- @endif --}}
              @if($details->fee_coupon > 0)
              Mã giảm: -{{number_format($details->fee_coupon,0,',','.')}} vnđ</br>
              @endif
              Phí vận chuyển: {{number_format($details->product_feeship,0,',','.')}} vnđ</br>
              @if($total_coupon>0)
              Tổng tiền: {{number_format($total_coupon,0,',','.')}} vnđ
              @else
              Tổng tiền: 0 vnđ
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="6">
                @foreach($order as $key => $or)
                  @if($or->order_status==0)
                  <form>
                     @csrf
                    <select class="form-control order_details" style="width:20%">
                      <option id="{{$or->order_id}}" selected value="0">Chưa xử lý</option>
                      <option id="{{$or->order_id}}" value="1">Đã xử lý - Đã giao hàng</option>
                    </select>
                  </form>
                  @elseif($or->order_status==1)
                  <form>
                    @csrf
                    <select class="form-control order_details" style="width:20%">
                        <option id="{{$or->order_id}}"  selected value="1">Đã xử lý - Đã giao hàng</option>
                    </select>
                  </form>
                  @else
                    <select class="form-control" style="width:20%">
                        <option  selected >Đơn hàng bị hủy</option>
                    </select>

                  @endif
                  @endforeach


              </td>
          </tr>
        </tbody>
      </table>
      <button class="btn btn-success" style="margin-left:15px"><a target="_blank" href="{{url('/print-order/'.$details->order_code)}}" style="color: white">In đơn hàng</a></button>
    </div>

  </div>
</div>
</div>

@endsection
