@extends('admin.admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách thương hiệu
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
            <th>Tên thương hiệu</th>
            <th>Slug</th>
            <th>Mô tả</th>
            <th>Tình trạng</th>
            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>
        @foreach($all_brand_product as $key => $brand_pro)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $brand_pro->brand_name }}</td>
            <td>{{ $brand_pro->brand_slug }}</td>
            <td>{!!$brand_pro->brand_desc !!}</td>
            <td><span class="text-ellipsis">
              <?php
               if($brand_pro->brand_status==1){
                ?>
                <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>

                 <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>
            <td>
              <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_slug)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa thương hiệu này không?')" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
      @endforeach
        </tbody>
      </table>
    </div>
    {{-- <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-5 text-center">
        </div>
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_brand_product->links()!!}
          </ul>
        </div>
      </div>

    </footer> --}}
  </div>
</div>
@endsection
