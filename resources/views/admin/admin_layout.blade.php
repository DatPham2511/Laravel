<!DOCTYPE html>
<head>
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
@foreach ($contact_footer as $key => $logo)
<link rel="icon" href="{{url('uploads/contact/'.$logo->info_logo)}}" type="image/gif" sizes="64x64">
@endforeach
<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" >
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet"/>
<link href="{{asset('backend/css/jquery.dataTables.min.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet">

<link rel="stylesheet" href="{{asset('backend/css/jquery.dataTables.min.css')}}" type="text/css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->



</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="{{URL::to('/')}}" class="logo">
        SHOP
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        {{-- <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li> --}}
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="username">Xin ch??o
                <?php
                $name=Auth::user()->admin_name;
                if($name){
                    echo $name;
                }
                ?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                {{-- <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li> --}}
                <li><a href="{{URL::to('/logout-auth')}}"><i class="fa fa-key"></i>????ng xu???t</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->

    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Trang ch???</span>
                    </a>
                </li>


                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-list-alt"></i>
                        <span>Danh m???c</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Th??m danh m???c</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Danh s??ch danh m???c</a></li>
                    </ul>

                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-globe"></i>
                        <span>Th????ng hi???u</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-brand-product')}}">Th??m th????ng hi???u</a></li>
						<li><a href="{{URL::to('/all-brand-product')}}">Danh s??ch th????ng hi???u</a></li>

                    </ul>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>S???n ph???m</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Th??m s???n ph???m</a></li>
						<li><a href="{{URL::to('/all-product')}}">Danh s??ch s???n ph???m</a></li>

                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-picture-o"></i>
                        <span>Slider</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-slider')}}">Th??m slider</a></li>
						<li><a href="{{URL::to('/manage-slider')}}">Danh s??ch slider</a></li>

                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-ticket"></i>
                        <span>M?? gi???m gi??</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/insert-coupon')}}">Th??m m?? gi???m gi??</a></li>
						<li><a href="{{URL::to('/list-coupon')}}">Danh s??ch m?? gi???m gi??</a></li>

                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{URL::to('/delivery')}}">
                        <i class="fa fa-truck"></i>
                        <span>Ph?? v???n chuy???n</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-newspaper-o"></i>
                        <span>B??i vi???t</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-post')}}">Th??m b??i vi???t</a></li>
						<li><a href="{{URL::to('/list-post')}}">Danh s??ch b??i vi???t</a></li>

                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{URL::to('/information')}}">
                        <i class="fa fa-info-circle"></i>
                        <span>Th??ng tin website</span>
                    </a>

                </li>

                <li class="sub-menu">
                    <a href="{{URL::to('/manage-order')}}">
                        <i class="fa fa-shopping-cart"></i>
                        <span>????n h??ng</span>
                    </a>

                </li>

                @hasrole('admin')
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i>
                        <span>Ng?????i d??ng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-user')}}">Th??m ng?????i d??ng</a></li>
						<li><a href="{{URL::to('/user')}}">Danh s??ch ng?????i d??ng</a></li>
                    </ul>
                </li>

                <li>
                    <a class="javascript:;" href="{{URL::to('/statistic')}}">
                        <i class=" fa fa-bar-chart-o"></i>
                        <span>Th???ng k??</span>
                    </a>
                </li>
                @endhasrole
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		@yield('admin_content')

</section>
 <!-- footer -->
		  {{-- <div class="footer">
			<div class="wthree-copyright">
			  <p>?? 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
			</div>
		  </div> --}}
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>

<script src="{{asset('backend/js/bootstrap.js')}}"></script>
<script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('backend/js/scripts.js')}}"></script>
<script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>


<script src="{{asset('backend/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="{{asset('backend/js/simple.money.format.js')}}"></script>

<script type="text/javascript">
   $('.money').simpleMoneyFormat();
</script>

<script type="text/javascript">
    CKEDITOR.replace('ckeditor');
    CKEDITOR.replace('ckeditor1');
</script>

<script type="text/javascript">
    $(document).ready(function(){
        //load b???ng
        fetch_delivery();

        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();
             $.ajax({
                url : '{{url('/select-feeship')}}',
                method: 'POST',
                data:{_token:_token},
                success:function(data){
                   $('#load_delivery').html(data);
                }
            });
        }
        $(document).on('focus','.fee_feeship_edit',function(e){
             var feeValue = $(this).text();
            feeValue = feeValue.replace('.','');
             feeValue = feeValue.slice(0, feeValue.length - 3);
            e.target.innerText = feeValue;
        });
        //update ti???n
        $(document).on('blur','.fee_feeship_edit',function(e){

            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
             var _token = $('input[name="_token"]').val();
             j=0;
             if(!fee_value||!parseInt(fee_value)){
                j=j+1;
                alert('Ph?? v???n chuy???n kh??ng ???????c ????? tr???ng v?? ph???i l?? s???');
            }
            // alert(feeship_id);
            // alert(fee_value);
            if(j==0){
            $.ajax({
                url : '{{url('/update-delivery')}}',
                method: 'POST',
                data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
                success:function(data){

                   fetch_delivery();
                    $('#error').html('<span class="text-success">C???p nh???t ph?? v???n chuy???n th??nh c??ng</span>');
                }
            });
        }

        });
        //th??m v??o b???ng fee
        $('.add_delivery').click(function(){

           var city = $('.city').val();
           var province = $('.province').val();
           var wards = $('.wards').val();
           var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
            j=0;
            if(!city||!province||!wards||!fee_ship){
                j=j+1;
                alert('B???n ch??a ch???n ?????y ????? th??ng tin');
            }
           // alert(city);
           // alert(province);
           // alert(wards);
           // alert(fee_ship);
           if(j==0){
            $.ajax({
                url : '{{url('/insert-delivery')}}',
                method: 'POST',
                data:{city:city, province:province, _token:_token, wards:wards, fee_ship:fee_ship},
                success:function(data){
                    alert('Th??m ph?? v???n chuy???n th??nh c??ng')
                   location.reload();
                   fetch_delivery();
                }
            });
        }


        });
        //ch???n ????? hi???n th??? qu???n huy???n xp
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
                url : '{{url('/select-delivery')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                   $('#'+result).html(data);
                }
            });
        });
    })


</script>

{{-- th?? vi??n ???nh --}}
<script type="text/javascript">
    $(document).ready(function(){
        load_gallery()
        function load_gallery(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url : '{{url('/select-gallery')}}',
                method: 'GET',
                data:{pro_id:pro_id,_token:_token},
                success:function(data){
                   $('#gallery_load').html(data);
                }
            });
        }
        //validate ???nh
        // $('#file').change(function(){
        //     var error='';
        //     var files=$('#file')[0].files;
        //     if(files.length>5){
        //         error+='B???n ch??? ???????c ch???n t???i ??a 5 h??nh ???nh';
        //     }
        //     // }else if(files.size > 2000000){
        //     //     error+='File ???nh qu?? l???n';
        //     // }

        //     if(error==''){

        //     }else{
        //         $('#file').val('');
        //         $('#error').html('<span class="text-alert">'+error+'</span>');
        //         return false;
        //     }
        // });
        //update t??n h??nh ???nh
         $(document).on('blur','.edit_gallery_name',function(e){

            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();

            j=0;
             if(!gal_text){
                j=j+1;
                alert('T??n h??nh ???nh kh??ng ???????c ????? tr???ng');
            }
            if(j==0){
            $.ajax({
                url : '{{url('/update-gallery-name')}}',
                method: 'POST',
                data:{gal_id:gal_id, gal_text:gal_text, _token:_token},
                success:function(data){
                    load_gallery();
                    $('#error').html('<span class="text-success">C???p nh???t t??n h??nh ???nh th??nh c??ng</span>');

                }
            });
        }

        });
        //delete
         $(document).on('click','.delete-gallery',function(e){

            var gal_id = $(this).data('gal_id');

            var _token = $('input[name="_token"]').val();
            if(confirm('B???n c?? mu???n x??a h??nh ???nh n??y kh??ng?')){
                $.ajax({
                    url : '{{url('/delete-gallery')}}',
                    method: 'POST',
                    data:{gal_id:gal_id, _token:_token},
                    success:function(data){

                        load_gallery();
                        $('#error').html('<span class="text-success">X??a h??nh ???nh th??nh c??ng</span>');

                    }
            });
        }

        });
        //update h??nh ???nh
         $(document).on('change','.file_image',function(e){

            var gal_id = $(this).data('gal_id');
            var image=document.getElementById('file-'+gal_id).files[0];

            var form_data=new FormData();
            form_data.append("file",document.getElementById('file-'+gal_id).files[0]);
            form_data.append("gal_id",gal_id);

                $.ajax({
                    url : '{{url('/update-gallery')}}',
                    method: 'POST',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(data){
                        load_gallery();
                        $('#error').html('<span class="text-success">C???p nh???t h??nh ???nh th??nh c??ng</span>');

                    }
            });


        });



    });
</script>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

   
</script>

{{-- Ch???n th??ng --}}
<script type="text/javascript">
    $(document).ready(function(){
        $( "#datepicker" ).datepicker({
            dateFormat:"yy-mm-dd",

        });
        $( "#datepicker2" ).datepicker({
            dateFormat:"yy-mm-dd",
        });

    });
</script>
{{-- bi???u ????? --}}
<script type="text/javascript">
    $(document).ready(function(){
        chartdayorder();
       var chart=new Morris.Bar({
           element: 'myfirstchart',
           barColors: ["#B21516", "#1531B2", "#1AB244", "#B29215"],
           //lineColors:['#819C79','#819C79','#819C79','#819C79','#819C79'],
            parseTime:false,
            hideHover:'auto',

           xkey: 'period',
           ykeys: ['order','sales','profit','quantity'],

           labels: ['????n h??ng','doanh s???','l???i nhu???n','s??? l?????ng'],
       });

       $('#btn-dashboard-filter').click(function(){
           var _token = $('input[name="_token"]').val();
           var from_date = $('#datepicker').val();
           var to_date = $('#datepicker2').val();
            if(!from_date||!to_date){
                alert('B???n ch??a nh???p ?????y ????? th??ng tin');
            }else{
           $.ajax({
                   url : '{{url('/filter-by-date')}}',
                   method: 'POST',
                   dataType:'JSON',
                   data:{_token:_token,from_date:from_date,to_date:to_date},
                   success:function(data){
                      chart.setData(data);
                   }
               });
            }

       });

       function chartdayorder(){
           var _token = $('input[name="_token"]').val();
           $.ajax({
                   url : '{{url('/days-order')}}',
                   method: 'POST',
                   dataType:'JSON',
                   data:{_token:_token},
                   success:function(data){
                      chart.setData(data);
                   }
               });
       }

       $('.dashboard-filter').change(function(){
           var dashboard_value = $(this).val();
           var _token = $('input[name="_token"]').val();

           $.ajax({
                   url : '{{url('/dashboard-filter')}}',
                   method: 'POST',
                   dataType:'JSON',
                   data:{_token:_token,dashboard_value:dashboard_value},
                   success:function(data){
                      chart.setData(data);
                   }
               });

       });

   });
   </script>
{{-- t???ng sp dh --}}
<script type="text/javascript">
     $(document).ready(function(){

        var colorDanger = "#FF1744";
        var donut=Morris.Donut({
        element: 'donut',
        resize: true,
        colors: [
            '#33CC66',
            '#ce616a',
            '#ce8f61',
            '#4842f5',

        ],
        //labelColor:"#cccccc", // text color
        //backgroundColor: '#333333', // border color
        data: [
            {label:"SAN PHAM", value:{{$app_product}},},
            {label:"BAI VIET", value:{{$app_news}},},
            {label:"DON HANG", value:{{$app_order}}},
            {label:"KHACH HANG", value:{{$app_customer}}},
        ]
        });


    });
</script>




{{-- C???p nh???t s??? l?????ng ????n h??ng --}}
<script type="text/javascript">
    $('.update_quantity_order').click(function(){
        var order_product_id = $(this).data('product_id');
        var order_qty = $('.order_qty_'+order_product_id).val();
        var order_code = $('.order_code').val();
        var _token = $('input[name="_token"]').val();
        // alert(order_product_id);
        if(parseInt(order_qty) < 1){
            alert('S??? l?????ng s???n ph???m ph???i l???n h??n 0');
        }else{
        // alert(order_qty);
        // alert(order_code);
        $.ajax({
                url : '{{url('/update-qty')}}',

                method: 'POST',

                data:{_token:_token, order_product_id:order_product_id ,order_qty:order_qty ,order_code:order_code},
                // dataType:"JSON",
                success:function(data){
                    alert('C???p nh???t s??? l?????ng s???n ph???m th??nh c??ng');
                   location.reload();
                }
        });
    }
    });
</script>
{{-- x??? l?? ????n h??ng --}}
<script type="text/javascript">
    $('.order_details').change(function(){
        var order_status = $(this).val();
        var fee_coupon = $('.fee_coupon').val();

        var order_code = $('.order_code').val();

        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();

        //lay ra so luong
        quantity = [];
        $("input[name='product_sales_quantity']").each(function(){
            quantity.push($(this).val());
        });
        //lay ra product id
        order_product_id = [];
        $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });
        j = 0;
        for(i=0;i<order_product_id.length;i++){
            //so luong khach dat
            var order_qty = $('.order_qty_' + order_product_id[i]).val();
            //so luong ton kho
            var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

            if(parseInt(order_qty)>parseInt(order_qty_storage)){
                j = j + 1;
                if(j==1){
                    alert('S???n ph???m trong kho kh??ng ?????');
                }
                $('.color_qty_'+order_product_id[i]).css('background','#FF0066');
            }
        }
        if(j==0){
                $.ajax({
                        url : '{{url('/update-order-qty')}}',
                            method: 'POST',
                            data:{_token:_token, order_status:order_status ,order_id:order_id ,quantity:quantity, order_product_id:order_product_id,fee_coupon:fee_coupon,order_code:order_code},
                            success:function(data){
                                alert('Thay ?????i t??nh tr???ng ????n h??ng th??nh c??ng');
                                location.reload();
                            }
                });

         }

    });
</script>
<script type="text/javascript">

    function ChangeToSlug()
        {
            var slug;

            //L???y text t??? th??? input title
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //?????i k?? t??? c?? d???u th??nh kh??ng d???u
                slug = slug.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'a');
                slug = slug.replace(/??|??|???|???|???|??|???|???|???|???|???/gi, 'e');
                slug = slug.replace(/i|??|??|???|??|???/gi, 'i');
                slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'o');
                slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???/gi, 'u');
                slug = slug.replace(/??|???|???|???|???/gi, 'y');
                slug = slug.replace(/??/gi, 'd');
                //X??a c??c k?? t??? ?????t bi???t
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                //?????i kho???ng tr???ng th??nh k?? t??? g???ch ngang
                slug = slug.replace(/ /gi, "-");
                //?????i nhi???u k?? t??? g???ch ngang li??n ti???p th??nh 1 k?? t??? g???ch ngang
                //Ph??ng tr?????ng h???p ng?????i nh???p v??o qu?? nhi???u k?? t??? tr???ng
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                //X??a c??c k?? t??? g???ch ngang ??? ?????u v?? cu???i
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                //In slug ra textbox c?? id ???slug???
            document.getElementById('convert_slug').value = slug;
        }




</script>

</body>
</html>
