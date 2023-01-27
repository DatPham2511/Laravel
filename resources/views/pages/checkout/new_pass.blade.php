@extends('layout')
@section('content')
<div class="col-sm-9 padding-right">
<section id="form"><!--form-->
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-sm-offset-1">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {!!session()->get('message')!!}
                </div>
                @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {!!session()->get('error')!!}
                </div>
                @endif
                <div class="login-form"><!--login form-->
                    @php
                        $token=$_GET['token'];
                        $email=$_GET['email'];

                    @endphp
                    <h2>Điền mật khẩu mới</h2>
                    <form action="{{URL::to('/reset-new-pass')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$token}}" name="token">
                        <input type="hidden" value="{{$email}}" name="email">

                        <input type="password" name="password_account" placeholder="Mật khẩu mới" value="{{old('password_account')}}" />
                        @error('password_account')
                        <span style="color: red">{{$message}}</span>
                        @enderror

                        <button type="submit" class="btn btn-default">Cập nhật</button>
                    </form>
                </div><!--/login form-->
            </div>

        </div>
    </div>
</section><!--/form-->
</div>
@endsection
