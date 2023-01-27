@extends('admin.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách danh mục
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
            <th>Tên danh mục</th>
            <th>Slug</th>
            <th>Mô tả</th>
            <th>Thuộc danh mục</th>
            <th>Tình trạng</th>
            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>

        @foreach($category_product as $key => $cate_all)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $cate_all->category_name }}</td>
            <td>{{ $cate_all->category_slug }}</td>
            <td>{!!$cate_all->category_desc!!}</td>
            <td>
                    @if($cate_all->category_parent==0)
                        Danh mục cha
                    @else
                        @foreach ($category_parent as $key => $cate_parent)
                            @if($cate_all->category_parent==$cate_parent->category_id)
                            {{$cate_parent->category_name}}
                            @endif
                        @endforeach
                    @endif

            </td>

            <td><span class="text-ellipsis">
              <?php
               if($cate_all->category_status==1){
                ?>
                <a href="{{URL::to('/unactive-category-product/'.$cate_all->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>

                 <a href="{{URL::to('/active-category-product/'.$cate_all->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>
            <td>
              <a href="{{URL::to('/edit-category-product/'.$cate_all->category_slug)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa danh mục này không?')" href="{{URL::to('/delete-category-product/'.$cate_all->category_id)}}" class="active styling-edit" ui-toggle-class="">
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
