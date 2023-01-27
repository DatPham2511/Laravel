@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm mã giảm giá
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                    <input type="text"  value="{{old('coupon_name')}}" class="form-control"   name="coupon_name"   placeholder="Tên Danh mục" >
                                    @error('coupon_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                    <input type="text" value="{{old('coupon_date_start')}}" class="form-control"  id="datepicker"  name="coupon_date_start"   placeholder="Tên Danh mục" >
                                    @error('coupon_date_start')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày kết thúc</label>
                                    <input type="text"  value="{{old('coupon_date_end')}}"  class="form-control"  id="datepicker2"  name="coupon_date_end"   placeholder="Tên Danh mục" >
                                    @error('coupon_date_end')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã giảm giá</label>
                                    <input type="text" value="{{old('coupon_code')}}" name="coupon_code" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('coupon_code')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng</label>
                                    <input type="number"   value="{{old('coupon_quantity')}}" name="coupon_quantity" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('coupon_quantity')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Điều kiện giảm giá</label>
                                      <select name="coupon_condition" class="form-control input-sm m-bot15">
                                            <option value="1" {{old('coupon_condition')==1?'selected':false}}>Giảm theo phần trăm</option>
                                            <option value="0" {{old('coupon_condition')==0?'selected':false}} >Giảm theo tiền</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số giảm</label>
                                    <input type="number" value="{{old('coupon_number')}}"  name="coupon_number" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('coupon_number')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tình trạng</label>
                                      <select name="coupon_status" class="form-control input-sm m-bot15">
                                           <option value="1" {{old('coupon_status')==1?'selected':false}}>Kích hoạt</option>
                                            <option value="0" {{old('coupon_status')==0?'selected':false}}>khóa</option>

                                    </select>
                                </div>

                                <button type="submit" name="add_category_product" class="btn btn-info">Thêm mới</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
