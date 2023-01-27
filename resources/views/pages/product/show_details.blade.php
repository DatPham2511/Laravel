@extends('layout')
@section('content')
@section('menu')
    @include('menu')
@endsection
<div class="col-sm-9 padding-right">
@foreach ($details_product as $key => $details)
<div class="product-details"><!--product-details-->
    <style>
        .lSSlideOuter .lSPager.lSGallery img {
                display: block;
                height: 140px;
                max-width: 100%;
            }
            /* li.active{
                border:1px solid #FE980F;
            } */

    </style>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: none">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{url('/danh-muc-san-pham/'.$cate_slug)}}">{{$product_cate}}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{$pro_name}}</li>
        </ol>
      </nav>

    <div class="col-sm-5">
        <ul id="imageGallery">
            @foreach ($gallery as $key =>$gal)
            <li data-thumb="{{asset('uploads/gallery/'.$gal->gallery_image)}}" data-src="{{asset('uploads/gallery/'.$gal->gallery_image)}}">
              <img width="100%" height="424px" src="{{asset('uploads/gallery/'.$gal->gallery_image)}}" />
            </li>
            @endforeach

          </ul>
    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->


            <h2>{{$details->product_name}}</h2>
            <p>Mã ID: {{$details->product_id}}</p>

            <form action="" method="POST">
                @csrf
                <input type="hidden" value="{{$details->product_id}}" class="cart_product_id_{{$details->product_id}}">
                <input type="hidden" value="{{$details->product_name}}" class="cart_product_name_{{$details->product_id}}">
                <input type="hidden" value="{{$details->product_image}}" class="cart_product_image_{{$details->product_id}}">
                <input type="hidden" value="{{$details->product_quantity}}" class="cart_product_quantity_{{$details->product_id}}">
                <input type="hidden" value="{{$details->product_price}}" class="cart_product_price_{{$details->product_id}}">
                <input type="hidden" value="{{$details->product_slug}}" class="cart_product_slug_{{$details->product_id}}">
                <input type="hidden" value="{{$details->product_cost}}" class="cart_product_cost_{{$details->product_id}}">


            <span>
                <span>{{ number_format($details->product_price,0,',','.') }} vnđ</span>
                <label>Số lượng:</label>
                <input type="number" value="1" min="1" class="cart_product_qty_{{$details->product_id}}" name="qty">
                <br>
                <span id="cart_session"></span>
                {{-- <input name="product_id" type="hidden"  value="{{$details->product_id}}" /> --}}

                <button type="button" style="margin-left:0px" class="btn btn-fefault cart add-item_{{$details->product_id}}" id="{{$details->product_id}}" onclick="add_to_cart(this.id)"><i class="fa fa-shopping-cart" style="padding-right:6px"></i>Thêm giỏ hàng</button>

                <button type="button" style="display:none;background: #d9534f;color:white"  class="btn btn-fefault add-to-cart remove-item_{{$details->product_id}}" id="{{$details->product_id}}" onclick="remove_item(this.id)" ><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>

            </span>

        </form>
            <p><b>Tình trạng:</b>
                @if($details->product_quantity > 0)
               Còn hàng</p>
                @else
               Hết hàng</p>
                @endif
            <p><b>Điều kiện:</b> Mới</p>
            <p><b>Danh mục:</b> {{$details->category_name}}</p>
            <p><b>Thương hiệu:</b> {{$details->brand_name}}</p>

        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li ><a href="#mota" data-toggle="tab">Mô tả</a></li>
			<li><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
            <li class="active"><a href="#comment" data-toggle="tab">Bình luận</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade " id="mota" >
           <p>{!!$details->product_desc!!}</p>
        </div>
        <div class="tab-pane fade" id="details" >
            <p>{!!$details->product_content!!}</p>
         </div>
         <div class="tab-pane fade active in" id="comment" >
            <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0" nonce="lSb0xOUC"></script>
                <div class="fb-comments" data-href="{{$url_canonical}}" data-width="830" data-numposts="5"></div>
            </div>


    </div>
</div><!--/category-tab-->
@endforeach
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>

                @foreach ($related_product as $key => $related)
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                                <div class="productinfo text-center">
                                    <form action="">
                                        @csrf
                                        <input type="hidden" value="{{$related->product_id}}" class="cart_product_id_{{$related->product_id}}">
                                        <input type="hidden" id="wishlist_productname{{$related->product_id}}" value="{{$related->product_name}}" class="cart_product_name_{{$related->product_id}}">
                                        <input type="hidden" value="{{$related->product_image}}" class="cart_product_image_{{$related->product_id}}">
                                        <input type="hidden" value="{{$related->product_quantity}}" class="cart_product_quantity_{{$related->product_id}}">
                                        <input type="hidden" value="{{$related->product_price}}" class="cart_product_price_{{$related->product_id}}">
                                        <input type="hidden" id="wishlist_productprice{{$related->product_id}}" value="{{ number_format($related->product_price,0,',','.') }}" class="cart_product_price_{{$related->product_id}}">
                                        <input type="hidden" value="{{$related->product_slug}}" class="cart_product_slug_{{$related->product_id}}">
                                        <input type="hidden" value="{{$related->product_cost}}" class="cart_product_cost_{{$related->product_id}}">

                                        <input type="hidden" value="1" class="cart_product_qty_{{$related->product_id}}">

                                    <a id="wishlist_producturl{{$related->product_id}}" href="{{URL::to('/chi-tiet-san-pham/'.$related->product_slug)}}">
                                        <img  id="wishlist_productimage{{$related->product_id}}"  src="{{URL::to('uploads/product/'.$related->product_image)}}" alt="" />
                                        <h2>{{ number_format($related->product_price,0,',','.') }} vnđ</h2>
                                        <p style="height: 55px">{{$related->product_name}}</p>
                                    </a>
                                    <button type="button" class="btn btn-default add-to-cart add-item_{{$related->product_id}}" id="{{$related->product_id}}" onclick="add_to_cart(this.id)"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

                                    <button type="button" style="display:none;background: #d9534f;color: white;"  class="btn btn-default add-to-cart remove-item_{{$related->product_id}}" id="{{$related->product_id}}" onclick="remove_item(this.id)" ><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>
                                </form>
                                </div>

                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">

                                        <li>
                                            <span  class="like_{{$related->product_id}}">
                                                <i class="fa fa-star"></i>
                                                <button class="button_wishlisht " id="{{$related->product_id}}"
                                                    onclick="add_wishlist(this.id);"><span>Yêu thích</span>
                                                </button>
                                            </span>

                                            <span style="display:none" class="delete_{{$related->product_id}}" >
                                                <i style="color: orange" class="fa fa-star"></i>
                                                <button  class="button_wishlisht delete_wishlist" data-id="{{$related->product_id}}"
                                                    ><span style="color: orange">Yêu thích</span>
                                                </button>
                                            </span>
                                        </li>

                                    </ul>
                                </div>

                        </div>

                    </div>
                </div>
              @endforeach

</div><!--/recommended_items-->
</div>
@endsection
