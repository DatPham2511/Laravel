@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách người dùng
    </div>

    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            $msg = Session::get('msg');
                            if($message){
                                echo '<span class="text-success">'.$message.'</span>';
                                Session::put('message',null);
                            };
                            if($msg){
                                echo '<span class="text-alert">'.$msg.'</span>';
                                Session::put('message',null);
                            };

                            ?>
      <table class="table table-striped b-t b-light"  id="myTable">
        <thead>
          <tr>

            <th>STT</th>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th style="width:165px;">Mật khẩu</th>
            <th>Quyền</th>


            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach($admin as $key => $user)
            {{-- <form action="{{url('/assign-roles')}}" method="POST">
              @csrf --}}
              <tr>

                <td>{{$key+1}}</td>
                <td>{{ $user->admin_name }}</td>
                <td>{{ $user->admin_email }}

                    <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
                </td>
                <td>{{ $user->admin_phone }} </td>
                <td ><input type="password" value="{{ $user->admin_password }}" disabled style="border: none;background:none"></td>
                {{-- <td><input type="radio" name="role"  {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                <td><input type="radio" name="user_role"  {{$user->hasRole('user') ? 'checked' : ''}}></td> --}}
                <td >{{ $user->roles->name }}</td>

              <td>

                {{-- <p><input type="submit" value="Phân quyền" class="btn btn-sm btn-default"></p>
                <p> <a style="margin-top:5px" class="btn btn-sm btn-danger" href="{{url('/delete-user-roles/'.$user->admin_id)}}">Xóa user</a></p> --}}
                <a href="{{URL::to('/edit-user/'.$user->admin_id)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                  <a onclick="return confirm('Bạn có chắc là muốn xóa người dùng này không?')" href="{{URL::to('/delete-user/'.$user->admin_id)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-times text-danger text"></i>
              </td>

              </tr>
            {{-- </form> --}}
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection
