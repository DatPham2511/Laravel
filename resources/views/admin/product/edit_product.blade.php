@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật sản phẩm
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                @foreach($edit_product as $key => $pro)
                                <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" value="{{old('product_name') ?? $pro->product_name}}">
                                    @error('product_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" name="product_slug" class="form-control" id="convert_slug" value="{{old('product_slug') ?? $pro->product_slug}}">
                                    @error('product_slug')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng</label>
                                    <input type="number"  name="product_quantity" class="form-control"  value="{{old('product_quantity') ?? $pro->product_quantity}}">
                                    @error('product_quantity')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                     <div class="form-group">
                                    <label for="exampleInputEmail1">Giá gốc</label>
                                    <input type="number" value="{{old('product_cost') ?? $pro->product_cost}}" name="product_cost" class="form-control" id="exampleInputEmail1" >
                                    @error('product_cost')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá bán</label>
                                    <input type="number" value="{{old('product_price') ?? $pro->product_price}}" name="product_price" class="form-control" id="exampleInputEmail1" >
                                    @error('product_price')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                    <img src="{{URL::to('uploads/product/'.$pro->product_image)}}" height="100" width="100">
                                    @error('product_image')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor1">{{old('product_desc') ?? $pro->product_desc}}</textarea>
                                    @error('product_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chi tiết sản phẩm</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="product_content"  id="ckeditor" placeholder="Nội dung sản phẩm">{{old('product_content') ?? $pro->product_content}}</textarea>
                                    @error('product_content')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục</label>
                                      <select name="product_cate" class="form-control input-sm m-bot15">
                                        @foreach($cate_product as $key => $cate)
                                            @if($cate->category_parent==0)
                                                <option value="{{$cate->category_id}}" {{$cate->category_id==$pro->category_id?'selected':false}}>{{$cate->category_name}}</option>
                                                @foreach($cate_product as $key => $cate_sub)
                                                    @if($cate_sub->category_parent!=0 && $cate_sub->category_parent==$cate->category_id)
                                                        <option value="{{$cate_sub->category_id}}" {{$cate_sub->category_id==$pro->category_id ?'selected':false}}>&nbsp&nbsp{{$cate_sub->category_name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Thương hiệu</label>
                                      <select name="product_brand" class="form-control input-sm m-bot15">
                                        @foreach($brand_product as $key => $brand)

                                            <option value="{{$brand->brand_id}}" {{$brand->brand_id==$pro->brand_id ?'selected':false}}>{{$brand->brand_name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <button type="submit" name="add_product" class="btn btn-info">Cập nhật</button>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection
