@extends('layout')
@section('content')

<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-sm-offset-1">
                <?php
                $message = Session::get('message');
                $error = Session::get('error');
                if($message){
                    echo '<div class="alert alert-success">'.$message.'</div>';
                    Session::put('message',null);
                }
                elseif($error){
                    echo '<div class="alert alert-danger">'.$error.'</div>';
                    Session::put('error',null);
                }
                ?>

                <div class="login-form"><!--login form-->
                    <h2>Thông tin tài khoản</h2>
                    <form action="{{URL::to('/save-account')}}" method="POST">
                        {{ csrf_field() }}

                        <input type="text" name="customer_name" placeholder="Họ và tên" value="{{old('customer_name') ?? $customer->customer_name}}" />
                        @error('customer_name')
                        <span style="color: red">{{$message}}</span>
                        @enderror

                        <input type="text" name="customer_email" placeholder="Email" value="{{old('customer_email') ?? $customer->customer_email}}" />
                        @error('customer_email')
                        <span style="color: red">{{$message}}</span>
                        @enderror
                        <input type="text" name="customer_phone" placeholder="Số điện thoại" value="{{old('customer_phone') ?? $customer->customer_phone}}" />
                        @error('customer_phone')
                        <span style="color: red">{{$message}}</span>
                        @enderror
                        <input type="password" name="customer_password" placeholder="Mật khẩu" value="{{old('customer_password') ?? $customer->customer_password}}" />
                        @error('customer_password')
                        <span style="color: red">{{$message}}</span>
                        @enderror
                        <button type="submit" class="btn btn-default">Cập nhật</button>

                    </form>
                </div><!--/login form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection
