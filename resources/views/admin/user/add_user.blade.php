@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm người dùng
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">

                                <form role="form" action="{{URL::to('/store-user')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên người dùng</label>
                                    <input type="text" value="{{old('admin_name')}}" name="admin_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                    @error('admin_name')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" value="{{old('admin_email')}}" name="admin_email" class="form-control" id="exampleInputEmail1" placeholder="Slug">
                                    @error('admin_email')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input type="text" value="{{old('admin_phone')}}" name="admin_phone" class="form-control" id="exampleInputEmail1" placeholder="Slug">
                                    @error('admin_phone')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="password" value="{{old('admin_password')}}" name="admin_password" class="form-control" id="exampleInputEmail1" placeholder="Slug">
                                    @error('admin_password')
                                    <span style="color: red">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Quyền</label>
                                      <select name="admin_role" class="form-control input-sm m-bot15">
                                        @foreach($role as $key => $rol)
                                                 <option value="{{$rol->id_roles}}" {{old('admin_role')==$rol->id_roles ? 'selected' : false}}>{{$rol->name}}</option>

                                        @endforeach

                                    </select>
                                </div>


                                <button type="submit" name="add_category_product" class="btn btn-info">Thêm mới</button>
                                </form>

                            </div>

                        </div>
                    </section>

            </div>
@endsection
