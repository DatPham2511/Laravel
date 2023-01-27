@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách bài viết
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
            <th>Tên bài viết</th>
            <th>Hình ảnh</th>
            <th>Slug</th>
            <th>Mô tả</th>
            <th>Tình trạng</th>

            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_post as $key => $post)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $post->post_title }}</td>
            <td><img src="uploads/post/{{ $post->post_image }}" height="100" width="100"></td>
            <td>{{ $post->post_slug }}</td>
            <td>{!!$post->post_desc !!}</td>
            <td><span class="text-ellipsis">
              <?php
               if($post->post_status==1){
                ?>
                <a href="{{URL::to('/unactive-post/'.$post->post_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>
                 <a href="{{URL::to('/active-post/'.$post->post_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>
            <td>
                <a href="{{URL::to('/edit-post/'.$post->post_slug)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa bài viết này không?')" href="{{URL::to('/delete-post/'.$post->post_id)}}" class="active styling-edit" ui-toggle-class="">
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
