<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Đạt Store</title>
    {{-- //<link  rel="canonical" href="{{$url_canonical}}" /> --}}
    @foreach ($contact_footer as $key => $logo)
     <link rel="icon" href="{{url('uploads/contact/'.$logo->info_logo)}}" type="image/gif" sizes="64x64">
    @endforeach
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/lightgallery.min.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/lightslider.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/prettify.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{('frontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo" >
                            @foreach ($contact_footer as $key => $contact)

                                   {!!$contact->info_slogan!!}
                            @endforeach
						</div>
					</div>
					{{-- <div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div> --}}
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
                            @foreach ($contact_footer as $key => $logo)
							    <a href="{{url('/')}}"><img style="height:65px" src="{{url('uploads/contact/'.$logo->info_logo)}}" alt="" /></a>
                            @endforeach
                        </div>

						{{-- <div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>

							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div>
						</div> --}}
					</div>
                    <style>
                        .shop-menu .hover-cart{
                            display: inline-grid;
                            display: none;
                            position: absolute;
                            z-index: 9999;
                            background: whitesmoke;
                            padding: 0;
                            width:130%;


                        }
                        li.cart-hover{
                            position: relative;
                        }
                        ul.hover-cart li{
                            padding:10px;
                            border-bottom:1px solid #000;
                        }
                        ul.hover-cart li img{
                            display: block;
                            margin: 0 22%;
                            width: 50px;
                            height: 50px;
                        }
                        li.cart-hover:hover .hover-cart{
                            display: inline-grid;
                        }
                        .gio-hang-hover p{
                            margin:5px 0px;
                        }
                    </style>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">

							<ul class="nav navbar-nav">

                                <?php
                                 $customer_id=Session::get('customer_id');
                                 if( $customer_id!=NULL){
                                ?>
								<li><a href="{{URL::to('/tai-khoan')}}"><i class="fa fa-user"></i>{{Session::get('customer_name')}}</a></li>
                                <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                                 <?php
                                 } else {
                                 ?>
                                 <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>

                                 <?php
                                }
                                ?>


                                <li class="cart-hover"><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i>
                                    Giỏ hàng

                                        <span class="show-cart"></span>
                                        <div class="clear-fix"></div>
                                        <span class="gio-hang-hover">

                                        </span>

                                </a></li>
                                <?php
                                    $customer_id=Session::get('customer_id');
                                    if( $customer_id!=NULL){
                                ?>
                                <li><a href="{{URL::to('/history-order')}}"><i class="fa fa-refresh"></i>Lịch sử mua hàng</a></li>
								<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
                                <?php
                                }else{
                                ?>
                                <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                <?php
                                }
                                ?>
                            </ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">

						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/')}}" >Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category as $key => $cate)
                                        @if($cate->category_parent==0)
										    <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_slug)}}">{{$cate->category_name}}</a></li>
                                            @foreach ($category as $key => $cate_sub)
                                                @if($cate_sub->category_parent!=0 && $cate_sub->category_parent==$cate->category_id)
										            <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_slug)}}">&nbsp&nbsp&nbsp{{$cate_sub->category_name}}</a></li>

                                                @endif
                                            @endforeach
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
								<li ><a href="{{URL::to('/tin-tuc')}}">Tin tức</a>

                                </li>
								{{-- <li><a href="{{URL::to('/show-cart')}}">Giỏ hàng

                                        <span class="show-cart"></span>

                                </a></li> --}}
								<li><a href="{{URL::to('/lien-he')}}">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
                        <form action="{{URL::to('/tim-kiem')}}" method="get">
                        @csrf
						<div class="search_box pull-right">
							<input style="width:300px;margin-left:-100px" type="text" placeholder="Tên sản phẩm" name="keywords_submit" value="{{request()->keywords_submit}}"/>
                            <input type="submit" style="margin-top: -1.7px;color:white"class="btn btn-primary" value="Tìm kiếm">
                        </div>
                    </form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

	@yield('slider')
	<section>
		<div class="container">
			<div class="row">
                @yield('menu')

                @yield('content')


			</div>
		</div>
	</section>

	<footer id="footer"><!--Footer-->
		<div class="footer-widget">
			<div class="container">
				<div class="row">

					<div class="col-sm-3">
						<div class="single-widget">
                            @foreach ($contact_footer as $key => $con)
                                <p><a href="{{url('/')}}"><img style="height:65px" src="{{url('uploads/contact/'. $con->info_logo)}}" alt="" /></a></p>
                                {!!$con->info_slogan!!}
                            @endforeach

						</div>
					</div>
                    @foreach ($contact_footer as $key=>$contact_foot)


					<div class="col-sm-4">
						<div class="single-widget">
							<h2>Thông tin liên hệ</h2>
                            <ul class="nav nav-pills nav-stacked">
								<li><a>{!!$contact_foot->info_contact!!}</a></li>

							</ul>



						</div>
					</div>
					<div class="col-sm-4" style="padding-bottom:15px">
						<div class="single-widget">
							<h2>Fanpage</h2>
                            {!!$contact_foot->info_fanpage!!}
						</div>
					</div>
                    @endforeach


				</div>
			</div>
		</div>



	</footer><!--/Footer-->



    <script src="{{asset('frontend/js/jquery.js')}}"></script>
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <script src="{{asset('frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('frontend/js/prettify.js')}}"></script>
    <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('frontend/js/simple.money.format.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.form-validator.min.js')}}"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">

            $('.category-filter').click(function(){
                var category=[] , tempArray=[];
                $.each($("[data-filters='category']:checked"),function(){
                    tempArray.push($(this).val());
                });
                tempArray.reverse();
                if(tempArray.length!==0){
                    category+='?cate='+tempArray.toString();
                }else{
                    category='?cate=';

                }
                window.location.href=category;
            })

            $('.brand-filter').click(function(){
                var brand=[] , tempArray=[];
                $.each($("[data-filters='brand']:checked"),function(){
                    tempArray.push($(this).val());
                });
                tempArray.reverse();
                if(tempArray.length!==0){
                    brand+='?brand='+tempArray.toString();
                }else{
                    brand='?brand=';
                }
                window.location.href=brand;
            })




   </script>
    <script type="text/javascript">

        $('.brand-filters').click(function(){
            var cate = $(this).data('cate');
            var keyword = $(this).data('keyword');
            var brand=[] , tempArray=[];
            $.each($("[data-filters='brands']:checked"),function(){
                tempArray.push($(this).val());
            });
            tempArray.reverse();
            if(tempArray.length!==0){
                brand+='?cate='+cate+'&brand='+tempArray.toString()+'&keywords_submit='+keyword;
            }else{
                brand='?cate='+cate+'&brand='+'&keywords_submit='+keyword;
            }
            window.location.href=brand;
        })

        $('.category-filters').click(function(){
            var brand = $(this).data('brand');
            var keyword = $(this).data('keyword');
            var category=[] , tempArray=[];
            $.each($("[data-filters='categories']:checked"),function(){
                tempArray.push($(this).val());
            });
            tempArray.reverse();
            if(tempArray.length!==0){
                category+='?cate='+tempArray.toString()+'&brand='+brand+'&keywords_submit='+keyword;
            }else{
                category='?cate='+'&brand='+brand+'&keywords_submit='+keyword;

            }
            window.location.href=category;
        })


</script>

    <script type="text/javascript">
         $(document).ready(function() {
            $('#imageGallery').lightSlider({
             gallery:true,
            item:1,
            loop:true,
            thumbItem:3,
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
            onSliderLoad: function(el) {
                el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        }
    });
  });
    </script>

    <script type="text/javascript">

        $(document).ready(function(){
          $('.send_order').click(function(){
            // swal({
            //       title: "Xác nhận đơn hàng",
            //       type: "warning",
            //       showCancelButton: true,
            //       confirmButtonClass: "btn-danger",
            //       confirmButtonText: "Đồng ý",
            //         cancelButtonText: "Đóng",
            //         closeOnConfirm: false,

            //     },
            //   function(isConfirm){
            //        if (isConfirm) {
                      var shipping_email = $('.shipping_email').val();
                      var shipping_name = $('.shipping_name').val();
                      var shipping_address = $('.shipping_address').val();
                      var shipping_phone = $('.shipping_phone').val();
                      var shipping_notes = $('.shipping_notes').val();
                      var shipping_method = $('.payment_select').val();
                      var order_fee = $('.order_fee').val();
                      var order_coupon = $('.order_coupon').val();
                      var fee_coupon = $('.fee_coupon').val();
                      var vn_code = $('.vn_code').val();

                      var _token = $('input[name="_token"]').val();

                      if(shipping_email==''||shipping_name==''||shipping_address==''||shipping_phone==''||shipping_notes==''||shipping_method==''){
                        alert('Bạn chưa điền đầy đủ thông tin đơn hàng');
                      }else{
                      $.ajax({
                          url: '{{url('/confirm-order')}}',
                          method: 'POST',
                          data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_notes:shipping_notes,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method,vn_code:vn_code,fee_coupon:fee_coupon},
                          success:function(data){
                            swal("Đơn hàng", "Đặt hàng thành công. Cảm ơn bạn đã mua hàng", "success");
                            window.setTimeout(function(){
                                window.location.href = "{{url('/history-order')}}";
                            } ,3000);
                          }
                      });
                    }


                //     }
                // });
             });
          });

  </script>
    <script type="text/javascript">
        hover_cart();
        show_cart();
        cart_session();
        htmlLoaded();
        //số lượng cart
        function show_cart(){
            $.ajax({
                url : '{{url('/show-cart-menu')}}',
                method: 'GET',
                success:function(data){
                   $('.show-cart').html(data);
                }
            });
        }

        function hover_cart(){
            $.ajax({
                url : '{{url('/hover-cart')}}',
                method: 'GET',
                success:function(data){
                   $('.gio-hang-hover').html(data);
                }
            });
        }

        function remove_item(id){
            var id=id;
            $.ajax({
                url : '{{url('/remove-item')}}',
                method: 'GET',
                data:{id:id},
                success:function(data){
                    document.getElementsByClassName("add-item_"+id)[0].style.display="inline";
                    document.getElementsByClassName("remove-item_"+id)[0].style.display="none";
                    show_cart();
                    hover_cart();
                    cart_session();
                }
            });
        }
        function cart_session(){
            $.ajax({
                url : '{{url('/cart-session')}}',
                method: 'GET',

                success:function(data){
                   $('#cart_session').html(data);

                }
            });
        }
        function htmlLoaded(){
            $(window).load(function(){
                var id=[];
                $('.cart_id').each(function(){
                    id.push($(this).val());
                    //alert(id);
                });
                for(var i=0;i<id.length;i++){
                    $('.add-item_'+id[i]).hide();
                    $('.remove-item_'+id[i]).show();

                }
            });



        }
        function add_to_cart(id){
            var id=id;
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_slug = $('.cart_product_slug_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_quantity = $('.cart_product_quantity_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_cost = $('.cart_product_cost_' + id).val();

            var cart_product_qty = $('.cart_product_qty_' + id).val();
            var _token = $('input[name="_token"]').val();
            j=0;
            if(parseInt(cart_product_qty) < 1){
                j++;
                alert('Số lượng sản phẩm phải lớn hơn 0');

            }
            if(parseInt(cart_product_qty)  > parseInt(cart_product_quantity)){
                j++;
                alert('Sản phẩm trong kho không đủ');
            }

            if(j==0){

            $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,
                        cart_product_quantity:cart_product_quantity,cart_product_slug:cart_product_slug,cart_product_cost:cart_product_cost},
                    success:function(data){
                                swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{url('/show-cart')}}";

                                });
                                document.getElementsByClassName("add-item_"+id)[0].style.display="none";
                                document.getElementsByClassName("remove-item_"+id)[0].style.display="inline";
                                show_cart();
                                hover_cart();
                                cart_session();


                    }
                });
            }
        }

    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            // alert(action);
            //  alert(matp);
            //   alert(_token);

            if(action=='city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{url('/select-delivery-home')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                   $('#'+result).html(data);
                }
            });
        });
    })
    </script>
     <script type="text/javascript">
        $(document).ready(function(){
            $('.calculate_delivery').click(function(){
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if(matp == '' || maqh =='' || xaid ==''){
                    alert('Bạn chưa chọn đầy đủ thông tin phí vận chuyển');
                }else{
                    $.ajax({
                    url : '{{url('/calculate-fee')}}',
                    method: 'POST',
                    data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
                    success:function(data){
                       location.reload();
                    }
                    });
                }
        });
    });
    </script>
 {{-- //yêu thích --}}
    <script type="text/javascript">

    function view(){
        if(localStorage.getItem('data')!=null){
            var data=JSON.parse(localStorage.getItem('data'));
            for(i=0;i<data.length;i++){
                var id=data[i].id;
                var name=data[i].name;
                var price=data[i].price;
                var image=data[i].image;
                var url=data[i].url;

                document.getElementById('row_wishlist').style.overflow='scroll';
                document.getElementById('row_wishlist').style.height='500px';

                $('.like_'+id).hide();
                $('.delete_'+id).show();

                $("#row_wishlist").append('<div class="row" style="margin:10px 15px"><div class="col-md-4"><img width="100%" height="75px" src="'+image+'"></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+price+' vnđ</p><p><a href="'+url+'">Xem ngay</a></p><a class="btn btn-danger btn-xs delete_wishlist"  data-id="'+id+'"   style="margin-top:0">Xóa</a></div></div>')
            }
        }
    }
    view();
    function add_wishlist(clicked_id){
        var id=clicked_id;
        var name=document.getElementById('wishlist_productname'+id).value;
        var price=document.getElementById('wishlist_productprice'+id).value;
        var image=document.getElementById('wishlist_productimage'+id).src;
        var url=document.getElementById('wishlist_producturl'+id).href;

        var newItem={
            'url':url,
            'id':id,
            'name':name,
            'price':price,
            'image':image
        }
        if(localStorage.getItem('data')==null){
            localStorage.setItem('data','[]');
        }
        //chuyển chuỗi -> obj
        var old_data=JSON.parse(localStorage.getItem('data'));
        var matches=$.grep(old_data,function(obj){
            return obj.id==id;
        })
        if(matches.length){
            alert('Sản phẩm đã có trong yêu thích');
        }
        else{
            document.getElementById('row_wishlist').style.overflow='scroll';
            document.getElementById('row_wishlist').style.height='500px';


            document.getElementsByClassName("like_"+id)[0].style.display="none";
            document.getElementsByClassName("delete_"+id)[0].style.display="inline";

            old_data.push(newItem);

            $("#row_wishlist").append('<div class="row" style="margin:10px 10px"><div class="col-md-4"><img width="100%"  height="75px" src="'+newItem.image+'"></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+' vnđ</p><p><a href="'+newItem.url+'">Chi tiết</a></p><a class="btn btn-danger btn-xs delete_wishlist" data-id="'+newItem.id+'" style="margin-top:0">Xóa</a></div></div>')

        }
        //chuyển obj->string
        localStorage.setItem('data',JSON.stringify(old_data));
    }
    //xóa
    $(document).on('click','.delete_wishlist',function(event){

                var id = $(this).data('id');


                if (localStorage.getItem('data') != null) {
                    var data = JSON.parse(localStorage.getItem('data'));
                    if (data.length) {
                            for (i = 0; i < data.length; i++) {
                                if (data[i].id == id) {
                                data.splice(i,1); //xóa phần tử khỏi mảng
                            }
                        }
                    }

                    localStorage.setItem('data',JSON.stringify(data));  //chuyển obj->string
                    // alert('Xóa thành công');
                    window.location.reload();
                }
            });
    </script>
    {{-- sắp xếp --}}
    <script type="text/javascript">
         $(document).ready(function(){
            $('.sort').on('change',function(){
                var url=$(this).val();
                if(url){
                    window.location=url;
                }
                return false;
            });
        });
    </script>
    {{-- <script type="text/javascript">
        function huydonhang(id){
            var order_code=id;
            // var lydo=$('.lydohuydon').val();
            var order_status=2;
            var _token = $('input[name="_token"]').val();

            // if(lydo==''){
            //     alert('Lý do không được để trống');
            // }else{
            $.ajax({
                url : '{{url('/huy-don-hang')}}',
                method: 'POST',
                data:{order_code:order_code,_token:_token,order_status:order_status},
                success:function(data){
                     alert('Hủy đơn hàng thành công');
                     location.reload();
                }
            });
        // }

        }
    </script> --}}
    <script type="text/javascript">
        $.validate({

        });
    </script>

   {{-- tabs --}}
   <script type="text/javascript">
    $(document).ready(function(){
                var cate_id = $('.tabs_pro').data('id');

                var _token = $('input[name="_token"]').val();

                $.ajax({
                url : '{{url('/product-tabs')}}',
                method: 'POST',
                data:{cate_id:cate_id,_token:_token},
                success:function(data){
                    $('#tabs_product').html(data);
                    var id2=[];
                    $('.cart_id').each(function(){
                        id2.push($(this).val());
                        //alert(id);
                    });
                    for(var i=0;i<id2.length;i++){
                        $('.add-item_'+id2[i]).hide();
                        $('.remove-item_'+id2[i]).show();

                    }

                    if(localStorage.getItem('data')!=null){
                        var data=JSON.parse(localStorage.getItem('data'));
                        for(i=0;i<data.length;i++){
                            var id=data[i].id;
                            $('.like_'+id).hide();
                            $('.delete_'+id).show();

                        }
                    }
                }
                });

                $.ajax({

                    url : '{{url('/show-more')}}',
                    method: 'POST',
                    data:{cate_id:cate_id,_token:_token},
                    success:function(data){
                        $('.button-showmore').html(data);
                    }
                });

        $('.tabs_pro').click(function(){
            var cate_id = $(this).data('id');
            var _token = $('input[name="_token"]').val();


                $.ajax({

                url : '{{url('/product-tabs')}}',
                method: 'POST',
                data:{cate_id:cate_id,_token:_token},
                success:function(data){
                    $('#tabs_product').html(data);

                    var id2=[];
                    $('.cart_id').each(function(){
                        id2.push($(this).val());
                        //alert(id);
                    });
                    for(var i=0;i<id2.length;i++){
                        $('.add-item_'+id2[i]).hide();
                        $('.remove-item_'+id2[i]).show();

                    }

                    if(localStorage.getItem('data')!=null){
                        var data=JSON.parse(localStorage.getItem('data'));
                        for(i=0;i<data.length;i++){
                            var id=data[i].id;
                            $('.like_'+id).hide();
                            $('.delete_'+id).show();

                        }
                    }

                }
                });
                $.ajax({

                    url : '{{url('/show-more')}}',
                    method: 'POST',
                    data:{cate_id:cate_id,_token:_token},
                    success:function(data){
                        $('.button-showmore').html(data);
                    }
                });

    });
});


</script>

    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "101362252808821");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

</body>
</html>
