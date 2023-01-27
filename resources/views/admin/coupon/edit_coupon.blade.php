@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật mã giảm giá
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                @foreach($coupon as $key => $cou)
                                <form role="form" action="{{URL::to('/update-coupon/'.$cou->coupon_id)}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                    <input value="{{old('coupon_name') ?? $cou->coupon_name}}" type="text"  class="form-control"   name="coupon_name"  placeholder="Tên Danh mục" >
                                    @error('coupon_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                    <input value="{{old('coupon_date_start') ??  $cou->coupon_date_start}}" type="text"  id="datepicker" class="form-control"   name="coupon_date_start"   placeholder="Tên Danh mục" >
                                    @error('coupon_date_start')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày kết thúc</label>
                                    <input value="{{old('coupon_date_end') ?? $cou->coupon_date_end}}" type="text"  id="datepicker2" class="form-control"   name="coupon_date_end"   placeholder="Tên Danh mục" >
                                    @error('coupon_date_end')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã giảm giá</label>
                                    <input value="{{old('coupon_code') ?? $cou->coupon_code}}" type="text" name="coupon_code" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('coupon_code')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng</label>
                                    <input value="{{old('coupon_quantity') ?? $cou->coupon_quantity}}" type="number"  name="coupon_quantity" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('coupon_quantity')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Điều kiện giảm giá</label>
                                      <select name="coupon_condition" class="form-control input-sm m-bot15">
                                            @if($cou->coupon_condition==1)
                                            <option value="1"  selected >Giảm theo phần trăm</option>

                                            <option value="0" >Giảm theo tiền</option>
                                            @else
                                            <option value="1" >Giảm theo phần trăm</option>

                                            <option value="0" selected>Giảm theo tiền</option>
                                            @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số giảm</label>
                                    <input value="{{old('coupon_number') ?? $cou->coupon_number}}" type="number" name="coupon_number" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('coupon_number')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>


                                <button type="submit" name="add_category_product" class="btn btn-info">Cập nhật</button>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection
