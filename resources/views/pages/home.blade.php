@extends('layout')
@section('content')
@section('slider')
    @include('slider')
@endsection
@section('menu')
    @include('menu')
@endsection
<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản phẩm mới nhất</h2>
                        <span id="cart_session"></span>
						@foreach ($all_product as $key => $pro)

						<div class="col-sm-4">
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
                                                <input type="hidden" value="{{$pro->product_slug}}" class="cart_product_slug_{{$pro->product_id}}">
                                                <input type="hidden" value="{{$pro->product_cost}}" class="cart_product_cost_{{$pro->product_id}}">
                                                <input type="hidden" id="wishlist_productprice{{$pro->product_id}}" value="{{ number_format($pro->product_price,0,',','.') }}" class="cart_product_price_{{$pro->product_id}}">

                                                <input type="hidden" value="1" class="cart_product_qty_{{$pro->product_id}}">

                                            <a id="wishlist_producturl{{$pro->product_id}}" href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_slug)}}">
                                                <img  id="wishlist_productimage{{$pro->product_id}}"  src="{{URL::to('uploads/product/'.$pro->product_image)}}" alt="" />
                                                <h2>{{ number_format($pro->product_price,0,',','.') }} vnđ</h2>
                                                <p style="height: 55px">{{$pro->product_name}}</p>
                                            </a>
                                            <button type="button" class="btn btn-default add-to-cart add-item_{{$pro->product_id}}" id="{{$pro->product_id}}" onclick="add_to_cart(this.id)" ><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

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

                                            <span style="display:none" class="delete_{{$pro->product_id}}" >
                                                <i style="color: orange" class="fa fa-star"></i>
                                                <button  class="button_wishlisht delete_wishlist" data-id="{{$pro->product_id}}"
                                                    ><span style="color: orange">Yêu thích</span>
                                                </button>
                                            </span>
                                        </li>

									</ul>
								</div>
							</div>
						</div>

						@endforeach

					</div><!--features_items-->

                    <div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($cate_pro_tabs as $key => $cat_tab )
                                    @php
                                        $i++;
                                    @endphp
                                    <li class="tabs_pro {{ $i==1 ? 'active' : ''}}"  data-id="{{$cat_tab->category_id}}">
                                        <a href="" data-toggle="tab">
                                            {{$cat_tab->category_name}}
                                        </a>
                                    </li>

                                @endforeach


							</ul>
						</div>



                        <div id="tabs_product">

                        </div>


					</div><!--/category-tab-->


                    <div class="button-showmore">
                    </div>
                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">Sản phẩm bán chạy</h2>

                                    @foreach ($product_hot as $key => $hot)
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <form action="">
                                                            @csrf
                                                            <input type="hidden" value="{{$hot->product_id}}" class="cart_product_id_{{$hot->product_id}}">
                                                            <input type="hidden" id="wishlist_productname{{$hot->product_id}}" value="{{$hot->product_name}}" class="cart_product_name_{{$hot->product_id}}">
                                                            <input type="hidden" value="{{$hot->product_image}}" class="cart_product_image_{{$hot->product_id}}">
                                                            <input type="hidden" value="{{$hot->product_quantity}}" class="cart_product_quantity_{{$hot->product_id}}">
                                                            <input type="hidden" value="{{$hot->product_price}}" class="cart_product_price_{{$hot->product_id}}">
                                                            <input type="hidden" id="wishlist_productprice{{$hot->product_id}}" value="{{ number_format($hot->product_price,0,',','.') }}" class="cart_product_price_{{$hot->product_id}}">
                                                            <input type="hidden" value="{{$hot->product_slug}}" class="cart_product_slug_{{$hot->product_id}}">
                                                            <input type="hidden" value="{{$hot->product_cost}}" class="cart_product_cost_{{$hot->product_id}}">

                                                            <input type="hidden" value="1" class="cart_product_qty_{{$hot->product_id}}">

                                                        <a id="wishlist_producturl{{$hot->product_id}}" href="{{URL::to('/chi-tiet-san-pham/'.$hot->product_slug)}}">
                                                            <img  id="wishlist_productimage{{$hot->product_id}}"  src="{{URL::to('uploads/product/'.$hot->product_image)}}" alt="" />
                                                            <h2>{{ number_format($hot->product_price,0,',','.') }} vnđ</h2>
                                                            <p style="height: 55px">{{$hot->product_name}}</p>
                                                        </a>
                                                        <button type="button" class="btn btn-default add-to-cart add-item_{{$hot->product_id}}" id="{{$hot->product_id}}" onclick="add_to_cart(this.id)"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

                                                        <button type="button" style="display:none;background: #d9534f;color: white;"  class="btn btn-default add-to-cart remove-item_{{$hot->product_id}}" id="{{$hot->product_id}}" onclick="remove_item(this.id)" ><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>
                                                    </form>
                                                    </div>
                                                    <div class="choose">
                                                        <ul class="nav nav-pills nav-justified">

                                                            <li>
                                                                <span  class="like_{{$hot->product_id}}">
                                                                    <i class="fa fa-star"></i>
                                                                    <button class="button_wishlisht " id="{{$hot->product_id}}"
                                                                        onclick="add_wishlist(this.id);"><span>Yêu thích</span>
                                                                    </button>
                                                                </span>

                                                                <span style="display:none" class="delete_{{$hot->product_id}}" >
                                                                    <i style="color: orange" class="fa fa-star"></i>
                                                                    <button  class="button_wishlisht delete_wishlist" data-id="{{$hot->product_id}}"
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
