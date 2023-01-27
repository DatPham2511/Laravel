@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm bài viết
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-post')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên bài viết</label>
                                    <input type="text"  class="form-control"  value="{{old('post_title')}}" name="post_title"   onkeyup="ChangeToSlug();" id="slug" placeholder="Tên thương hiệu" >
                                    @error('post_title')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" name="post_slug" value="{{old('post_slug')}}" class="form-control" id="convert_slug" placeholder="Slug" >
                                    @error('post_slug')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file"  name="post_image" class="form-control" id="exampleInputEmail1" >
                                    @error('post_image')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor1" class="form-control" name="post_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('post_desc')}}</textarea>
                                    @error('post_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor" class="form-control" name="post_content" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('post_content')}}</textarea>
                                    @error('post_content')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tình trạng</label>
                                      <select name="post_status" class="form-control input-sm m-bot15">
                                           <option value="1" {{old('post_status')==1?'selected':false}}>Kích hoạt</option>
                                            <option value="0" {{old('post_status')==0?'selected':false}}>Khóa</option>

                                    </select>
                                </div>

                                <button type="submit" name="add_post" class="btn btn-info">Thêm mới</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
