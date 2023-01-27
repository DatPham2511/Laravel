<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Danh mục</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            @foreach ($category as $key => $cate)
            @if($cate->category_parent==0)
            <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">
                            {{-- href="{{URL::to('/danh-muc-san-pham/'.$cate->category_slug)}}" --}}
                            <a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_slug)}}">
                                {{$cate->category_name}}
                            </a>
                            <a class="badge pull-right" data-toggle="collapse" data-parent="#accordian" href="#{{$cate->category_slug}}"><i class="fa fa-plus" ></i></a>

                        </h4>
                    </div>


                    <div id="{{$cate->category_slug}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach ($category as $key => $cate_sub)
                                    @if($cate_sub->category_parent==$cate->category_id)
                                        <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_slug)}}">{{$cate_sub->category_name}} </a></li>

                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

            </div>
            @endif
        @endforeach
        </div><!--/category-products-->

        <div class="brands_products"><!--brands_products-->
            <h2>Thương hiệu</h2>


            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                  @foreach ($brand as $key => $bra)
                    <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$bra->brand_slug)}}"> <span class="pull-right"></span>{{$bra->brand_name}}</a></li>
                 @endforeach
                </ul>
            </div>


        </div><!--/brands_products-->

        <div class="price-range"><!--brands_products-->
            <h2>Yêu thích</h2>
            <div class="brands-name">
                <div id="row_wishlist" class="row">

                </div>
            </div>


        </div>



    </div>
</div>
