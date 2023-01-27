<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
session_start();

class HomeController extends Controller
{
    public function index(Request $request){
        $slider = Slider::where('slider_status','1')->orderBy('slider_id','desc')->take(4)->get();
        $cate_product = Category::where('category_status','1')->get();

        $brand_product = Brand::where('brand_status','1')->get();

        $all_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('product_status','1')
        ->where('category_status','1')
        ->where('brand_status','1')
        ->orderBy('product_id','desc')->take(6)->get();

        $product_hot = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('product_status','1')
        ->where('category_status','1')
        ->where('brand_status','1')
        ->orderBy('product_sold','desc')->take(6)->get();

        $cate_pro_tabs=Category::where('category_parent','0')->where('category_status','1')->get();

        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('all_product',$all_product)->with('slider',$slider)
        ->with('cate_pro_tabs',$cate_pro_tabs)
        ->with('product_hot',$product_hot);
    }
    public function search(Request $request){
	   $keywords = $request->keywords_submit;
       $cate_product = Category::where('category_status','1')->get();
       $brand_product = Brand::where('brand_status','1')->get();

           //loc thương hiệu
           $brand_arr=[];
           $array_bra=[];
           $brand=$request->brand;
           $brand_arr=explode(",",$brand);
           $brand_filter =Brand::whereIn('brand_id', $brand_arr)->where('brand_status',1)->get();

           foreach($brand_filter as $key => $val_brand){
               $brand_id = $val_brand->brand_id;
               array_push($array_bra, $brand_id);
           }

        //loc danh mục
        $category_arr=[];
        $array_cate=[];
        $cate=$request->cate;
        $category_arr=explode(",",$cate);
        $category =Category::whereIn('category_id', $category_arr)->where('category_status',1)->get();

        foreach($category as $key => $val){
            $category_id = $val->category_id;
            array_push($array_cate, $category_id);
        }


       if(isset($_GET['sort_by'])){
        $sort_by=$_GET['sort_by'];
        $sort_price=$_GET['sort_price'];

        //lọc 1
        if($sort_by=="giam_dan" &&  $sort_price==""){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_by=="tang_dan" &&  $sort_price=="" ){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_by=="kytu_az" &&  $sort_price==""){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_by=="kytu_za" &&  $sort_price=="" ){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }

        }
        //lọc 2
        if($sort_price=="duoi_1t" &&  $sort_by=="" ){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->where('product_price','<',1000000)
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','<',1000000)
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="1t_5t" &&  $sort_by=="" ){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->whereBetween('product_price',[1000000,5000000])
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[1000000,5000000])
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->paginate(9)->appends($_GET);
            }



        }
        elseif($sort_price=="5t_10t" &&  $sort_by=="" ){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->whereBetween('product_price',[5000000,10000000])
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[5000000,10000000])
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="10t_20t" &&  $sort_by==""){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->whereBetween('product_price',[10000000,20000000])
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[10000000,20000000])
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="20t_30t" &&  $sort_by==""){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->whereBetween('product_price',[20000000,30000000])
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[20000000,30000000])
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="tren_30t" &&  $sort_by==""){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')

                ->where('product_price','>',30000000)
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','>',30000000)
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->paginate(9)->appends($_GET);
            }

        }

        //lọc kết hợp
        elseif($sort_price=="duoi_1t"  && $sort_by=="tang_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)
                ->orderBy('product_price','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','<',1000000)
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="duoi_1t"  && $sort_by=="giam_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_price','DESC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','<',1000000)

                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="duoi_1t"  && $sort_by=="kytu_za"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','<',1000000)

            ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

            ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }



        }
        elseif($sort_price=="duoi_1t"  && $sort_by=="kytu_az"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','<',1000000)

                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

            ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','<',1000000)

                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }

        }




        elseif($sort_price=="1t_5t"  && $sort_by=="tang_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="1t_5t"  && $sort_by=="giam_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="1t_5t"  && $sort_by=="kytu_za"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="1t_5t"  && $sort_by=="kytu_az"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[1000000,5000000])
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }

        }



        elseif($sort_price=="5t_10t"  && $sort_by=="tang_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
            ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="5t_10t"  && $sort_by=="giam_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="5t_10t"  && $sort_by=="kytu_za"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="5t_10t"  && $sort_by=="kytu_az"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[5000000,10000000])
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }

        }


        elseif($sort_price=="10t_20t"  && $sort_by=="giam_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','DESC')

                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','DESC')

                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="10t_20t"  && $sort_by=="tang_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','ASC')

                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_price','ASC')

                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="10t_20t"  && $sort_by=="kytu_za"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="10t_20t"  && $sort_by=="kytu_az"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','ASC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[10000000,20000000])
                ->orderBy('product_name','ASC')


                ->paginate(9)->appends($_GET);
            }

        }




        elseif($sort_price=="20t_30t" && $sort_by=="giam_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','DESC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','DESC')

                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="20t_30t" && $sort_by=="tang_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','ASC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','ASC')

                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_price','ASC')
                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="20t_30t" && $sort_by=="kytu_za"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','DESC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','DESC')
                ->paginate(9)->appends($_GET);
            }
        }
        elseif($sort_price=="20t_30t" && $sort_by=="kytu_az"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','ASC')



                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','ASC')


                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->whereBetween('product_price',[20000000,30000000])
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }

        }



        elseif($sort_price=="tren_30t" && $sort_by=="giam_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','DESC')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','DESC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','DESC')


                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','DESC')

                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="tren_30t" && $sort_by=="tang_dan"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','ASC')



                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','ASC')


                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_price','ASC')


                ->paginate(9)->appends($_GET);
            }

        }
        elseif($sort_price=="tren_30t" && $sort_by=="kytu_za"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','DESC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','DESC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','DESC')


                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','DESC')


                ->paginate(9)->appends($_GET);
            }


        }
        elseif($sort_price=="tren_30t" && $sort_by=="kytu_az"){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','ASC')

                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','ASC')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','ASC')


                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_price','>',30000000)
                ->orderBy('product_name','ASC')


                ->paginate(9)->appends($_GET);
            }

        }

        elseif($sort_price=="" && $sort_by==""){
            if($brand=="" && $cate==""){
                $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('category_status','1')
                ->where('brand_status','1')
                ->where('product_name','like','%'.$keywords.'%')
                ->paginate(9)->appends($_GET);
            }elseif($brand!=="" &&  $cate==""){
                $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')
                ->where('product_status','1')
                ->where('category_status','1')


                ->paginate(9)->appends($_GET);
            }
            elseif($cate!=="" &&  $brand==""){
                $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')
                ->whereIn('category_id',$array_cate)
                ->where('product_name','like','%'.$keywords.'%')


                ->paginate(9)->appends($_GET);
            }else{
                $search_product = Product::where('product_status','1')
                ->whereIn('category_id',$array_cate)
                ->whereIn('brand_id',$array_bra)
                ->where('product_name','like','%'.$keywords.'%')



                ->paginate(9)->appends($_GET);
            }


        }


    }
    elseif(isset($_GET['brand']) && isset($_GET['cate'])){
        if($brand=="" && $cate==""){
            $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
            ->where('product_status','1')
            ->where('category_status','1')
            ->where('brand_status','1')
            ->where('product_name','like','%'.$keywords.'%')
            ->paginate(9)->appends($_GET);
        }elseif($brand!=="" &&  $cate==""){
            $search_product = Product:: join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->whereIn('brand_id',$array_bra)
            ->where('product_name','like','%'.$keywords.'%')
            ->where('product_status','1')
            ->where('category_status','1')


            ->paginate(9)->appends($_GET);
        }
        elseif($cate!=="" &&  $brand==""){
            $search_product = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
            ->where('product_status','1')
            ->where('brand_status','1')
            ->whereIn('category_id',$array_cate)
            ->where('product_name','like','%'.$keywords.'%')
            ->paginate(9)->appends($_GET);
        }else{
            $search_product = Product::where('product_status','1')
            ->whereIn('category_id',$array_cate)
            ->whereIn('brand_id',$array_bra)
            ->where('product_name','like','%'.$keywords.'%')
            ->paginate(9)->appends($_GET);
        }

    }

    else{

        $search_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('product_status','1')
        ->where('category_status','1')
        ->where('brand_status','1')
        ->where('product_name','like','%'.$keywords.'%')
        ->paginate(9)->appends($_GET);


    }

       return view('pages.product.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product)->with('keywords',$keywords);
   }


}
