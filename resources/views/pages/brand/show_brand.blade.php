@extends('layout')
@section('content')

@section('menu')
    @include('menu')
@endsection
<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						@foreach ($bra_name as $key => $name)
						<h2 class="title text-center">{{$name->brand_name}}</h2>
                        <span id="cart_session"></span>
						@endforeach

                        <div class="row">

                                <div class="col-md-12">
                                    <label for="amount">Lọc danh mục</label><br>
                                    @php
                                        $category_id=[];
                                        $category_arr=[];
                                        if(isset($_GET['cate'])){
                                            $category_id=$_GET['cate'];
                                            //chuyển sang mảng
                                            $category_arr=explode(",",$category_id);
                                        }

                                    @endphp

                                    @foreach ($category as $key =>$cate)
                                        <label class="checkbox-inline" style="margin-left:0px;padding-left:35px;padding-bottom:5px">
                                            <input type="checkbox" {{in_array($cate->category_id,$category_arr) ? 'checked':''}}
                                                data-filters="category" class="form-control-checkbox category-filter" name="category-filter" value="{{$cate->category_id}}">
                                            {{$cate->category_name}}
                                        </label>
                                    @endforeach


                                </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4" >
                                <label for="amount">Sắp xếp theo</label>
                                <form action="">
                                    @csrf
                                    <select class="form-control sort" style="width:70%">

                                        <option value="{{Request::url()}}?sort_by=&sort_price={{request()->sort_price}}&cate={{request()->cate}}">--Lọc--</option>
                                        <option value="{{Request::url()}}?sort_by=tang_dan&sort_price={{request()->sort_price}}&cate={{request()->cate}}" {{request()->sort_by=='tang_dan' ? 'selected':''}}>Giá tăng dần</option>
                                        <option value="{{Request::url()}}?sort_by=giam_dan&sort_price={{request()->sort_price}}&cate={{request()->cate}}" {{request()->sort_by=='giam_dan' ? 'selected':''}}>Giá giảm dần</option>
                                        <option value="{{Request::url()}}?sort_by=kytu_az&sort_price={{request()->sort_price}}&cate={{request()->cate}}" {{request()->sort_by=='kytu_az' ? 'selected':''}}>Tên từ A đến Z</option>
                                        <option value="{{Request::url()}}?sort_by=kytu_za&sort_price={{request()->sort_price}}&cate={{request()->cate}}"  {{request()->sort_by=='kytu_za' ? 'selected':''}}>Tên từ Z đến A</option>

                                    </select>
                                </form>
                            </div>

                            <div class="col-md-4" >
                                <label for="amount">Khoảng giá</label>
                                <form action="">
                                    @csrf
                                    <select class="form-control sort" style="width:70%">

                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=&cate={{request()->cate}}">--Lọc--</option>
                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=duoi_1t&cate={{request()->cate}}" {{request()->sort_price=='duoi_1t' ? 'selected':''}}>Dưới 1 triệu</option>
                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=1t_5t&cate={{request()->cate}}" {{request()->sort_price=='1t_5t' ? 'selected':''}}>1 triệu đến 5 triệu</option>
                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=5t_10t&cate={{request()->cate}}" {{request()->sort_price=='5t_10t' ? 'selected':''}}>5 triệu đến 10 triệu</option>
                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=10t_20t&cate={{request()->cate}}" {{request()->sort_price=='10t_20t' ? 'selected':''}}>10 triệu đến 20 triệu</option>
                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=20t_30t&cate={{request()->cate}}"  {{request()->sort_price=='20t_30t' ? 'selected':''}}>20 triệu đến 30 triệu</option>
                                        <option value="{{Request::url()}}?sort_by={{request()->sort_by}}&sort_price=tren_30t&cate={{request()->cate}}"  {{request()->sort_price=='tren_30t' ? 'selected':''}}>Trên 30 triệu</option>

                                    </select>
                                </form>
                            </div>

                        </div>


						@foreach ($brand_by_id as $key => $pro)
						<div class="col-sm-4" style="margin-top:20px">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
                                            <form action="">
                                                @csrf
                                                <input type="hidden" value="{{$pro->product_id}}" class="cart_product_id_{{$pro->product_id}}">
                                                <input type="hidden" id="wishlist_productname{{$pro->product_id}}" value="{{$pro->product_name}}" class="cart_product_name_{{$pro->product_id}}">
                                                <input type="hidden" value="{{$pro->product_image}}" class="cart_product_image_{{$pro->product_id}}">
                                                <input type="hidden" value="{{$pro->product_quantity}}" class="cart_product_quantity_{{$pro->product_id}}">
                                                <input type="hidden" value="{{$pro->product_price}}" class="cart_product_price_{{$pro->product_id}}">
                                                <input type="hidden" id="wishlist_productprice{{$pro->product_id}}" value="{{ number_format($pro->product_price,0,',','.') }}" class="cart_product_price_{{$pro->product_id}}">
                                                <input type="hidden" value="{{$pro->product_slug}}" class="cart_product_slug_{{$pro->product_id}}">
                                                <input type="hidden" value="{{$pro->product_cost}}" class="cart_product_cost_{{$pro->product_id}}">

                                                <input type="hidden" value="1" class="cart_product_qty_{{$pro->product_id}}">

                                            <a id="wishlist_producturl{{$pro->product_id}}" href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_slug)}}">
                                                <img  id="wishlist_productimage{{$pro->product_id}}"  src="{{URL::to('uploads/product/'.$pro->product_image)}}" alt="" />
                                                <h2>{{ number_format($pro->product_price,0,',','.') }} vnđ</h2>
                                                <p style="height: 55px">{{$pro->product_name}}</p>
                                            </a>
                                            <button type="button" class="btn btn-default add-to-cart add-item_{{$pro->product_id}}" id="{{$pro->product_id}}" onclick="add_to_cart(this.id)"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

                                            <button type="button" style="display:none;background: #d9534f;color: white;"  class="btn btn-default add-to-cart remove-item_{{$pro->product_id}}" id="{{$pro->product_id}}" onclick="remove_item(this.id)" ><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>
                                        </form>
										</div>

								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">

										<li>
                                            <span  class="like_{{$pro->product_id}}">
                                                <i class="fa fa-star"></i>
                                                <button class="button_wishlisht " id="{{$pro->product_id}}"
                                                    onclick="add_wishlist(this.id);"><span>Yêu thích</span>
                                                </button>
                                            </span>

                                            <span  style="display:none" class="delete_{{$pro->product_id}}" >
                                                <i style="color: orange" class="fa fa-star"></i>
                                                <button  class="button_wishlisht delete_wishlist" data-id="{{$pro->product_id}}"
                                                ><span style="color: orange">Yêu thích</span>
                                                </button>
                                            </span>
                                        </li>
										{{-- <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li> --}}
									</ul>
								</div>
							</div>
						</div>

						@endforeach

					</div><!--features_items-->


                                <div class="col-sm-12 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {{$brand_by_id->links()}}
                                     </ul>
                                </div>





                    </div>
@endsection
