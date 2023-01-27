@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm danh mục
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input value="{{old('category_product_name')}}" type="text"  onkeyup="ChangeToSlug();" id="slug" class="form-control"  name="category_product_name" placeholder="Tên Danh mục" >
                                    @error('category_product_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input value="{{old('slug_category_product')}}" type="text" name="slug_category_product" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('slug_category_product')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea  style="resize: none" rows="8"  id="ckeditor1" class="form-control" name="category_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục" >{{old('category_product_desc')}}</textarea>
                                    @error('category_product_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thuộc danh mục</label>
                                      <select name="category_parent" class="form-control input-sm m-bot15">
                                        <option value="0"  {{old('category_parent')==0?'selected':false}} >Danh mục cha</option>

                                        @foreach ($category as $key => $val)
                                            <option value="{{$val->category_id}}"  {{old('category_parent')==$val->category_id?'selected':false}} >{{$val->category_name}}</option>
                                        @endforeach


                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tình trạng</label>
                                      <select name="category_product_status" class="form-control input-sm m-bot15">
                                           <option value="1"  {{old('category_product_status')==1?'selected':false}} >Kích hoạt</option>
                                           <option value="0"  {{old('category_product_status')==0?'selected':false}} >Khóa</option>

                                    </select>
                                </div>

                                <button type="submit" name="add_category_product" class="btn btn-info">Thêm mới</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
