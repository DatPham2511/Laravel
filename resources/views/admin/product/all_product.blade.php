@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách sản phẩm
    </div>

    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-success">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Thư viện ảnh</th>
            <th>Số lượng</th>
            <th>Slug</th>
            <th>Giá gốc</th>
            <th>Giá bán</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Chi tiết sản phẩm</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>

            <th>Tình trạng</th>

            <th >Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_product as $key => $pro)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $pro->product_name }}</td>
            <td><a href="{{url('/add-gallery/'. $pro->product_slug )}}">Thêm thư viện ảnh</a></td>
            <td>{{ $pro->product_quantity }}</td>
            <td>{{ $pro->product_slug }}</td>
            <td>{{ number_format($pro->product_cost,0,',','.') }} vnđ</td>
            <td>{{ number_format($pro->product_price,0,',','.') }} vnđ</td>
            <td><img src="{{URL::to('uploads/product/'.$pro->product_image)}}" height="100" width="100"></td>
            <td>{!! $pro->product_desc !!}</td>
            <td>{!! $pro->product_content !!}</td>
            <td>{{ $pro->category_name }}</td>
            <td>{{ $pro->brand_name }}</td>

            <td><span class="text-ellipsis">
              <?php
               if($pro->product_status==1){
                ?>
                <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>
                 <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
               }
              ?>
            </span></td>

            <td>
              <a href="{{URL::to('/edit-product/'.$pro->product_slug)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này không?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active styling-edit" ui-toggle-class="">
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
