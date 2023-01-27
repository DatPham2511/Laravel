@extends('layout')
@section('content')
<div class="col-sm-12 padding-right">

    <div class="table-agile-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: none">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
              <li class="breadcrumb-item">Lịch sử mua hàng</li>
            </ol>
          </nav>
  <div class="panel panel-default">

    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-success">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light" >
        <thead>
          <tr>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt hàng</th>
            <th>Tình trạng đơn hàng</th>

            <th style="width:107px;"></th>
          </tr>
        </thead>
        <tbody>

          @foreach($get_order as $key => $ord)

          <tr>

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
              <a href="{{URL::to('/view-history-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
                Xem đơn hàng</a>

                {{-- <form>
                    @csrf --}}
                @if($ord->order_status==0)

                <!-- Trigger the modal with a button -->
                <a class="btn btn-danger" onclick="return confirm('Bạn có chắc là muốn hủy đơn hàng này không?')" href="{{URL::to('/huy-don-hang/'.$ord->order_code)}}">
                {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Hủy đơn hàng</button> --}}Hủy đơn hàng
                </a>

                @endif
            {{-- <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Lý do hủy đơn hàng</h4>

                </div>
                <div class="modal-body">
                    <p><textarea rows="5" class="lydohuydon" placeholder="Lý do hủy đơn hàng..."></textarea></p>
                </div>
                <div class="modal-footer">

                    <button id="{{$ord->order_code}}" onclick="huydonhang(this.id);" class="btn btn-success" >Gửi lý do hủy</button>
                    <button type="button"  class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
                </div>

            </div>
            </div> --}}
                {{-- </form> --}}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
 <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-12 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {{$get_order->links()}}
          </ul>
        </div>
      </div>

    </footer>

  </div>
</div>
</div>
@endsection
