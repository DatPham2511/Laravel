@extends('admin.admin_layout')
@section('admin_content')
<div class="container-fluid">
    <style>
        p.title_thongke{
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        svg{
            width: 100%;
        }



    </style>
    <div class="row">
        <p class="title_thongke">Thống kê đơn hàng doanh số</p>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Từ ngày: <input type="text"  id="datepicker" class="form-control">
                <input type="button" style="margin: 8px 0px;"id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả"></p>
            </div>
            <div class="col-md-2">
                <p>Đến ngày: <input type="text" name="" id="datepicker2" class="form-control"></p>

            </div>
            <div class="col-md-2">
               <p>
                Lọc theo:
                <select class="dashboard-filter form-control" id="">
                    <option>--Chọn--</option>
                    <option value="7ngay">7 ngày qua</option>
                    <option value="thangtruoc">Tháng trước</option>
                    <option value="thangnay">Tháng này</option>
                    <option value="365ngayqua">365 ngày qua</option>
                </select>
               </p>
            </div>

            <div class="col-md-12 w3ls-graph">
                <!--agileinfo-grap-->
                    <div class="agileinfo-grap">
                        <div class="agileits-box">
                            <div class="agileits-box-body clearfix">
                                <div id="myfirstchart" style="height: 250px"></div>
                            </div>
                        </div>
                    </div>
                <!--//agileinfo-grap-->
            </div>
        </form>
    </div>

    <div class="row" style="margin-top:10px">
        <div class="col-md-4 col-xs-12">
            <p class="title_thongke" >Thống kê số lượng</p>
            <div id="donut" style="margin-top: -7px" ></div>
        </div>

        <div class="col-md-4 col-xs-12">
            <p class="title_thongke">Sản phẩm bán chạy</h3>
            <ol class="list_views" style=" margin: 10px 10px;color: #fff;">
                @foreach ($app_product_hot as $key => $pro_hot)
                <li><span style="color: orange">{{$pro_hot->product_name}} |</span><span style="color: black"> {{$pro_hot->product_sold}} sản phẩm</span></li>
                @endforeach
            </ol>

        </div>

        <div class="col-md-4 col-xs-12">
            <p class="title_thongke">Sản phẩm sắp hết hàng</h3>
            <ol class="list_views" style=" margin: 10px 10px;color: #fff;">
                @foreach ($app_product_sold_out as $key => $pro_out)
                <li><span style="color: orange">{{$pro_out->product_name}} |</span><span style="color: black"> {{$pro_out->product_quantity}} sản phẩm</span></li>
                @endforeach
            </ol>

        </div>
    </div>


</div>

@endsection


