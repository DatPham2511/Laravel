@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách Slider
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
            <th>Tên slider</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Tình trạng</th>

            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_slide as $key => $slide)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $slide->slider_name }}</td>
            <td><img src="uploads/slider/{{ $slide->slider_image }}" height="120" width="400"></td>
            <td>{!!$slide->slider_desc !!}</td>
            <td><span class="text-ellipsis">
              <?php
               if($slide->slider_status==1){
                ?>
                <a href="{{URL::to('/unactive-slide/'.$slide->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>
                 <a href="{{URL::to('/active-slide/'.$slide->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>
            <td>
                <a href="{{URL::to('/edit-slide/'.$slide->slider_id)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa slider này không?')" href="{{URL::to('/delete-slide/'.$slide->slider_id)}}" class="active styling-edit" ui-toggle-class="">
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
