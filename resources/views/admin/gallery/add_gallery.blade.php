@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thư viện ảnh
                        </header>
                        <div class="table-responsive">
                        <form action="{{url('/insert-gallery/'.$pro_id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <br>
                            <div class="row">
                                <div class="col-md-3" align="right">

                                </div>
                                <div class="col-md-6" >
                                    <input type="file" id="file" class="form-control" name="file[]" accept="image/*" multiple>

                                </div>
                                <div class="col-md-3" >
                                    <input type="submit" name="upload" name="taianh" value="Tải ảnh" class="btn btn-success">
                                </div>
                            </div>
                    </form>

                       <span id="error"> <?php
                        $message = Session::get('message');
                        $msg = Session::get('msg');
                        if($message){
                            echo '<span class="text-success">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        if($msg){
                            echo '<span class="text-alert">'.$msg.'</span>';
                            Session::put('msg',null);
                        }
                        ?></span>
                        <div class="panel-body">
                            <input type="hidden" name="pro_id" value="{{$pro_id}}" class="pro_id">
                            <form action="">
                                @csrf
                            <div id="gallery_load">

                            </div>
                            </form>

                        </div>
                        </div>
                    </section>
</div>
            </div>
@endsection
