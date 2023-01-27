@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật bài viết
                        </header>

                        <div class="panel-body">

                            <div class="position-center">
                                @foreach($edit_post as $key => $post)
                                <form role="form" action="{{URL::to('/update-post/'.$post->post_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên bài viết</label>
                                    <input value="{{old('post_title') ?? $post->post_title }}" type="text" name="post_title" class="form-control"  onkeyup="ChangeToSlug();" id="slug" placeholder="Tên danh mục">
                                    @error('post_title')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input value="{{old('post_slug') ?? $post->post_slug }}" type="text" name="post_slug" class="form-control" id="convert_slug"  placeholder="Tên danh mục">
                                    @error('post_slug')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="post_image" class="form-control" id="exampleInputEmail1" placeholder="Slide">
                                    <img src="{{URL::to('uploads/post/'.$post->post_image)}}" height="100" width="100">
                                    @error('post_image')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor1" class="form-control" name="post_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ old('post_desc') ?? $post->post_desc }}</textarea>
                                    @error('post_desc')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor" class="form-control" name="post_content" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ old('post_content') ?? $post->post_content }}</textarea>
                                    @error('post_content')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <button type="submit" name="add" class="btn btn-info">Cập nhật</button>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection
