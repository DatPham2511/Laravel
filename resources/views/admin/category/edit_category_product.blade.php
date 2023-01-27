@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật danh mục
                        </header>

                        <div class="panel-body">
                            @foreach($edit_category_product as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{old('category_product_name') ??  $edit_value->category_name }}"  onkeyup="ChangeToSlug();" name="category_product_name" class="form-control" id="slug"  >
                                    @error('category_product_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" value="{{old('slug_category_product') ?? $edit_value->category_slug}}" name="slug_category_product" class="form-control" id="convert_slug" >
                                    @error('slug_category_product')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" class="form-control" id="ckeditor1" name="category_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục" >{{old('category_product_desc') ?? $edit_value->category_desc}}</textarea>
                                    @error('category_product_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                               @if($edit_value->category_parent!==0)
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thuộc danh mục</label>
                                      <select name="category_parent" class="form-control input-sm m-bot15">
                                        <option value="0"   >Danh mục cha</option>

                                        @foreach ($category as $key => $val)
                                            <option value="{{$val->category_id}}"  {{$val->category_id==$edit_value->category_parent ?'selected':false}} >{{$val->category_name}}</option>
                                        @endforeach


                                    </select>
                                </div>
                                @else

                                <input type="hidden" value="0" name="category_parent">
                                @endif

                                <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>

</div>

@endsection
