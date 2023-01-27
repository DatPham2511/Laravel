@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm Slider
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên slider</label>
                                    <input value="{{old('slider_name')}}" type="text" name="slider_name" class="form-control" >
                                    @error('slider_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input  type="file" name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Slide">
                                    @error('slider_image')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor" class="form-control" name="slider_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{old('slider_desc')}}</textarea>
                                    @error('slider_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tình trạng</label>
                                      <select name="slider_status" class="form-control input-sm m-bot15">
                                           <option value="1"  {{old('slider_status')==1?'selected':false}}>Kích hoạt</option>
                                            <option value="0"  {{old('slider_status')==0?'selected':false}}>Khóa</option>

                                    </select>
                                </div>

                                <button type="submit" name="add_slider" class="btn btn-info">Thêm mới</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
