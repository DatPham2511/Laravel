@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật Slider
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                @foreach($all_slide as $key => $slide)
                                <form role="form" action="{{URL::to('/update-slide/'.$slide->slider_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên slider</label>
                                    <input value="{{old('slider_name') ?? $slide->slider_name }}" type="text" name="slider_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                    @error('slider_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Slide">
                                    <img src="{{URL::to('uploads/slider/'.$slide->slider_image)}}" height="100" width="250">
                                    @error('slider_image')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor" class="form-control" name="slider_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ old('slider_desc') ?? $slide->slider_desc }}</textarea>
                                    @error('slider_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <button type="submit" name="add_slider" class="btn btn-info">Cập nhật</button>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection
