@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thông tin website
                        </header>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <div class="panel-body">

                            <div class="position-center">
                                @foreach ($contact as $key=>$value)


                                <form role="form" action="{{URL::to('/update-info/'.$value->info_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thông tin liên hệ</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor1" class="form-control" name="info_contact" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('info_contact') ?? $value->info_contact}}</textarea>
                                    @error('info_contact')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Bản đồ</label>
                                    <textarea style="resize: none" rows="8"  class="form-control" name="info_map" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('info_map')?? $value->info_map}}</textarea>
                                    @error('info_map')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Fanpage</label>
                                    <textarea style="resize: none" rows="8"  class="form-control" name="info_fanpage" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('info_fanpage')?? $value->info_fanpage}}</textarea>
                                    @error('info_fanpage')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Slogan</label>
                                    <textarea style="resize: none" rows="8" id="ckeditor" class="form-control" name="info_slogan" id="exampleInputPassword1" placeholder="Mô tả danh mục" > {{old('info_slogan')?? $value->info_slogan}}</textarea>
                                    @error('info_slogan')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh logo</label>
                                    <input type="file"  name="info_logo" class="form-control" id="exampleInputEmail1" >
                                    <img src="{{URL::to('uploads/contact/'.$value->info_logo)}}" height="100" width="100">
                                </div>

                                <button type="submit" name="add_brand_product" class="btn btn-info">Cập nhật</button>
                                </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
@endsection
