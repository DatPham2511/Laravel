@extends('layout')
@section('content')

<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
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
                    <h2>Đăng nhập</h2>
                    <form action="{{URL::to('/login-customer')}}" method="POST">
                        {{ csrf_field() }}

                        <input type="text" name="email_account" placeholder="Email" value="{{old('email_account')}}" />
                        @error('email_account')
                        <span style="color: red">{{$message}}</span>
                        @enderror

                        <input type="password" name="password_account" placeholder="Mật khẩu" value="{{old('password_account')}}" />
                        @error('password_account')
                        <span style="color: red">{{$message}}</span>
                        @enderror
                        <p>
                            <a href="{{url('/quen-mat-khau')}}">Quên mật khẩu</a>
                        </p>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>

                    </form>
                    <style>
                            ul.list-login{
                                margin:10px;
                                padding:0;

                            }
                            ul.list-login li{
                              display: inline;
                              margin:5px;
                            }
                    </style>
                    <ul class="list-login">
                        <li>
                            <a href="{{url('login-customer-google')}}">
                                <img src="{{asset('frontend/images/google.png')}}" width="10%" >
                            </a>
                        </li>
                        <li>
                            <a href="{{url('login-customer-facebook')}}">
                                <img src="{{asset('frontend/images/facebook.png')}}" width="10%" >
                            </a>
                        </li>


                    </ul>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng ký</h2>
                    <form action="{{URL::to('/add-customer')}}" method="POST">
                        {{ csrf_field() }}


                        <input type="text" name="customer_name" placeholder="Họ và tên" value="{{old('customer_name')}}"/>
                        @error('customer_name')
                        <span style="color: red">{{$message}}</span>
                        @enderror

                        <input type="text" name="customer_email" placeholder="Email" value="{{old('customer_email')}}"/>
                        @error('customer_email')
                        <span style="color: red">{{$message}}</span>
                        @enderror


                        <input type="text" name="customer_phone" placeholder="Số điện thoại" value="{{old('customer_phone')}}"/>
                        @error('customer_phone')
                        <span style="color: red">{{$message}}</span>
                        @enderror


                        <input type="password" name="customer_password" placeholder="Mật khẩu" value="{{old('customer_password')}}"/>
                        @error('customer_password')
                        <span style="color: red">{{$message}}</span>
                        @enderror
                        <button type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection
