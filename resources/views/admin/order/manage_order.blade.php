@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách đơn hàng
    </div>

    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-success">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light"  id="myTable">
        <thead>
          <tr>

            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt hàng</th>
            <th>Tình trạng đơn hàng</th>

            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>

          @foreach($order as $key => $ord)

          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $ord->order_code }}</td>
            <td>{{ $ord->created_at }}</td>
            <td>@if($ord->order_status==0)
                    <span style="color:blue">Đơn hàng mới</span>
                @elseif($ord->order_status==1)
                    <span style="color:rgb(44, 216, 44)">Đã xử lý - Đã giao hàng</span>
                @else
                    <span style="color:red">Đơn hàng bị hủy</span>
                @endif
            </td>

            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-eye text-success text-active"></i></a>

              <a onclick="return confirm('Bạn có chắc là muốn xóa đơn hàng này không?')" href="{{URL::to('/delete-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>


  </div>
</div>
@endsection
