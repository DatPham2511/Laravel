@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách mã giảm giá
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
            <th>Tên mã giảm giá</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Mã giảm giá</th>
            <th>Số lượng</th>
            <th>Điều kiện giảm giá</th>
            <th>Số giảm</th>
            <th>Hạn sử dụng</th>
            <th>Tình trạng</th>
            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $cou->coupon_name }}</td>
            <td>{{ $cou->coupon_date_start }}</td>
            <td>{{ $cou->coupon_date_end }}</td>
            <td>{{ $cou->coupon_code }}</td>
            <td>{{ $cou->coupon_quantity }}</td>
            <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                Giảm theo %
                <?php
                 }else{
                ?>
                Giảm theo tiền
                <?php
               }
              ?>
            </span>
          </td>
             <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                Giảm {{$cou->coupon_number}} %
                <?php
                 }else{
                ?>
                Giảm {{ number_format($cou->coupon_number,0,',','.') }} vnđ
                <?php
               }
              ?>
            </span></td>

            <td>
                @if($cou->coupon_date_end>=$today)
                <span style="color: green">Còn hạn</span>
                @else
                <span style="color: red">Hết hạn</span>
                @endif

          </td>
            <td>
                <span class="text-ellipsis">
                <?php
                 if($cou->coupon_status==1){
                  ?>
                  <a href="{{URL::to('/unactive-coupon/'.$cou->coupon_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                  <?php
                   }else{
                  ?>

                   <a href="{{URL::to('/active-coupon/'.$cou->coupon_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                  <?php
                 }
                ?>
              </span>
            </td>

            <td>

                <a href="{{URL::to('/edit-coupon/'.$cou->coupon_code)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa mã này không?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
              <p><a href="{{URL::to('/send-coupon/'.$cou->coupon_code)}}" class="btn btn-default">Gửi mã</a></p>

            </td>
            
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
  </div>
</div>
@endsection
