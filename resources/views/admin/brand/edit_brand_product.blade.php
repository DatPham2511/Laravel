@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật thương hiệu
                        </header>

                        <div class="panel-body">
                            @foreach($edit_brand_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" value="{{old('brand_product_name') ?? $edit_value->brand_name}}" onkeyup="ChangeToSlug();" name="brand_product_name" class="form-control" id="slug"  >
                                    @error('brand_product_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" value="{{old('slug_brand_product') ?? $edit_value->brand_slug}}" name="slug_brand_product" class="form-control" id="convert_slug" >
                                    @error('slug_brand_product')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" class="form-control"  id="ckeditor1" name="brand_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục" >{{old('brand_product_desc') ?? $edit_value->brand_desc}}</textarea>
                                    @error('brand_product_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
@endsection
