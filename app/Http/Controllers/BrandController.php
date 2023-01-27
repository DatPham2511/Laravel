<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Auth;

session_start();

class BrandController extends Controller
{
    //admin
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function add_brand_product(){
        $this->AuthLogin();
    	return view('admin.brand.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();
    	$all_brand_product = Brand::orderBy('brand_id','DESC')->get();
    	$manager_brand_product  = view('admin..brand.all_brand_product')->with('all_brand_product',$all_brand_product);
    	return view('admin.admin_layout')->with('admin.brand.all_brand_product', $manager_brand_product);
    }
    public function save_brand_product(BrandRequest $request){
        $this->AuthLogin();
    	$data = array();

    	$data['brand_name'] = $request->brand_product_name;
        $data['brand_slug'] = $request->slug_brand_product;
        $data['brand_desc'] = $request->brand_product_desc;
    	$data['brand_status'] = $request->brand_product_status;

    	Brand::insert($data);
    	Session::put('message','Thêm thương hiệu thành công');
    	return Redirect::to('all-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->AuthLogin();
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Khóa thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->AuthLogin();
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Kích hoạt thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_slug){
        $this->AuthLogin();
        $edit_brand_product = Brand::where('brand_slug',$brand_product_slug)->get();

        $manager_brand_product  = view('admin.brand.edit_brand_product')->with('edit_brand_product',$edit_brand_product);

        return view('admin.admin_layout')->with('admin.brand.edit_brand_product', $manager_brand_product);
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->AuthLogin();
        $request->validate([
            'brand_product_name' =>'required',
            'slug_brand_product' =>'required|unique:tbl_brand_product,brand_slug,'.$brand_product_id.',brand_id',
            'brand_product_desc' =>'required',
        ],[
            'brand_product_name.required' =>'Tên thương hiệu không được để trống',
            'slug_brand_product.required' =>'Slug không được để trống',
            'slug_brand_product.unique' =>'Slug đã tồn tại',
            'brand_product_desc.required' =>'Mô tả không được để trống'
        ]
        );
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;
        $data['brand_slug'] = $request->slug_brand_product;
        Brand::where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhật thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();
        Brand::where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }

    //trang chu
    //san pham theo thuong hieu
    public function show_brand_home($brand_slug,Request $request){
        $cate_product =Category::where('category_status','1')->get();
       
        $brand_product = Brand::where('brand_status','1')->get();
        $bra_name = Brand::where('brand_slug',$brand_slug)->where('brand_status','1')->limit(1)->get();
        $brand_slug = Brand::where('brand_slug',$brand_slug)->where('brand_status','1')->get();

        foreach ($brand_slug as $key => $brand) {
            $brand_id=$brand->brand_id;
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

        if(isset($_GET['sort_by']) || isset($_GET['sort_price'])){
            $sort_by=$_GET['sort_by'];
            $sort_price=$_GET['sort_price'];

            //lọc 1
            if($sort_by=="giam_dan" &&  $sort_price==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)

                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)
                    ->where('brand_id',$brand_id)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }
            }
            elseif($sort_by=="tang_dan" &&  $sort_price==""){

                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')
                    ->where('brand_id',$brand_id)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);

                }
                else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)
                    ->where('brand_id',$brand_id)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_by=="kytu_az" &&  $sort_price==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->orderBy('product_name','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->orderBy('product_name','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_by=="kytu_za" &&  $sort_price==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->orderBy('product_name','DESC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->orderBy('product_name','DESC')
                    ->paginate(9)->appends($_GET);
                }
            }

            //lọc 2
            elseif($sort_price=="duoi_1t" &&  $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="1t_5t" &&  $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t" &&  $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t" &&  $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])

                    ->paginate(9)->appends($_GET);
                }
                else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="20t_30t" &&  $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)
                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" &&  $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                        ->whereIn('category_id',$array_cate)

                        ->where('brand_id',$brand_id)
                        ->where('product_price','>',30000000)

                        ->paginate(9)->appends($_GET);
                }

            }

            //lọc kết hợp
            elseif($sort_price=="duoi_1t"  && $sort_by=="tang_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="duoi_1t"  && $sort_by=="giam_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="duoi_1t"  && $sort_by=="kytu_za"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="duoi_1t"  && $sort_by=="kytu_az"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }

            elseif($sort_price=="1t_5t"  && $sort_by=="tang_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)

                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)

                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="1t_5t"  && $sort_by=="giam_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="1t_5t"  && $sort_by=="kytu_za"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)
                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="1t_5t"  && $sort_by=="kytu_az"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }



            elseif($sort_price=="5t_10t"  && $sort_by=="tang_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t"  && $sort_by=="giam_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t"  && $sort_by=="kytu_za"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t"  && $sort_by=="kytu_az"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }


            elseif($sort_price=="10t_20t"  && $sort_by=="giam_dan"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t"  && $sort_by=="tang_dan"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t"  && $sort_by=="kytu_za"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t"  && $sort_by=="kytu_az"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }




            elseif($sort_price=="20t_30t" && $sort_by=="giam_dan"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="20t_30t" && $sort_by=="tang_dan"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="20t_30t" && $sort_by=="kytu_za"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="20t_30t" && $sort_by=="kytu_az"){
                if($cate==""){

                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)

                    ->where('brand_id',$brand_id)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }



            elseif($sort_price=="tren_30t" && $sort_by=="giam_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" && $sort_by=="tang_dan"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" && $sort_by=="kytu_za"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)
                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" && $sort_by=="kytu_az"){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)


                    ->where('brand_id',$brand_id)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }
            }

            elseif($sort_price=="" && $sort_by==""){
                if($cate==""){
                    $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                    ->where('product_status','1')
                    ->where('category_status','1')

                    ->where('brand_id',$brand_id)
                    ->paginate(9)->appends($_GET);
                }else{

                    $brand_by_id = Product::where('product_status','1')
                    ->whereIn('category_id',$array_cate)
                    ->where('brand_id',$brand_id)
                    ->paginate(9)->appends($_GET);
                }




            }


        }
        elseif(isset($_GET['cate'])){
            if($cate==""){
                $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
                ->where('product_status','1')
                ->where('category_status','1')

                ->where('brand_id',$brand_id)
                ->paginate(9)->appends($_GET);
            }else{
                $brand_by_id = Product::whereIn('category_id', $array_cate)
                ->where('product_status','1')
                ->where('brand_id',$brand_id)
                ->paginate(9)->appends($_GET);
            }
        }
        else{

            $brand_by_id = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->where('product_status','1')
            ->where('category_status','1')

            ->where('brand_id',$brand_id)
            ->paginate(9)->appends($_GET);


        }

        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)->with('brand_by_id',$brand_by_id)
        ->with('bra_name',$bra_name);
    }
}
