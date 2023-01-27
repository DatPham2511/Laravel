@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm thương hiệu
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text"  class="form-control"  value="{{old('brand_product_name')}}" name="brand_product_name"   onkeyup="ChangeToSlug();" id="slug" placeholder="Tên thương hiệu" >
                                    @error('brand_product_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" name="slug_brand_product" value="{{old('slug_brand_product')}}" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('slug_brand_product')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor1" class="form-control" name="brand_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('brand_product_desc')}}</textarea>
                                    @error('brand_product_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <!-- <div class="form-group">
                                    <label for="exampleInputPassword1">Từ khóa danh mục</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="category_product_keywords" id="exampleInputPassword1" placeholder="Từ khóa danh mục" ></textarea>
                                </div> -->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tình trạng</label>
                                      <select name="brand_product_status" class="form-control input-sm m-bot15">
                                           <option value="1" {{old('brand_product_status')==1?'selected':false}}>Kích hoạt</option>
                                            <option value="0" {{old('brand_product_status')==0?'selected':false}}>Khóa</option>

                                    </select>
                                </div>

                                <button type="submit" name="add_brand_product" class="btn btn-info">Thêm mới</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
