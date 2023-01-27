<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Slider;
use Auth;
session_start();

class CategoryController extends Controller
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
    public function add_category_product(){
        $this->AuthLogin();
    	$category = Category::where('category_parent','0')->get();
    	return view('admin.category.add_category_product')->with(compact('category'));
    }
    public function all_category_product(){
        $this->AuthLogin();

    	$category_parent = Category::where('category_parent',0)->get();
        $category_product = Category::orderBy('category_id','DESC')->get();

    	$manager_category_product  = view('admin.category.all_category_product')->with('category_parent',$category_parent)
        ->with('category_product',$category_product);
    	return view('admin.admin_layout')->with('admin.category.all_category_product', $manager_category_product);
    }
    public function save_category_product(CategoryRequest $request){
        $this->AuthLogin();
    	$data = array();

    	$data['category_name'] = $request->category_product_name;
        $data['category_slug'] = $request->slug_category_product;
        $data['category_desc'] = $request->category_product_desc;
    	$data['category_parent'] = $request->category_parent;
    	$data['category_status'] = $request->category_product_status;

    	Category::insert($data);
    	Session::put('message','Thêm danh mục thành công');
    	return Redirect::to('all-category-product');
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        Category::where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Khóa danh mục thành công');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id){
        $this->AuthLogin();
        Category::where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Kích hoạt danh mục thành công');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_slug){
        $this->AuthLogin();

        $edit_category_product = Category::where('category_slug',$category_product_slug)->get();
    	$category = Category::where('category_parent','0')->get();


        $manager_category_product  = view('admin.category.edit_category_product')->with('edit_category_product',$edit_category_product)
        ->with('category',$category);

        return view('admin.admin_layout')->with('admin.category.edit_category_product', $manager_category_product);
    }


    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
        $request->validate([
            'category_product_name' =>'required',
            'slug_category_product' =>'required|unique:tbl_category_product,category_slug,'.$category_product_id.',category_id',
            'category_product_desc' =>'required',
        ],[
            'category_product_name.required' =>'Tên danh mục không được để trống',
            'slug_category_product.required' =>'Slug không được để trống',
            'slug_category_product.unique' =>'Slug đã tồn tại',
            'category_product_desc.required' =>'Mô tả không được để trống'
        ]
        );
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_slug'] = $request->slug_category_product;
        $data['category_desc'] = $request->category_product_desc;
    	$data['category_parent'] = $request->category_parent;


        Category::where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục thành công');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        Category::where('category_id',$category_product_id)->delete();

        Session::put('message','Xóa danh mục thành công');
        return Redirect::to('all-category-product');
    }

    //trang chu
    //san pham theo danh muc
    public function show_category_home($category_slug,Request $request){
        $cate_product = Category::where('category_status','1')->get();

        $brand_product = Brand::where('brand_status','1')->get();
        $cate_name = Category::where('category_slug',$category_slug)->where('category_status','1')->limit(1)->get();
        $category_slug = Category::where('category_slug',$category_slug)->where('category_status','1')->get();


        foreach ($category_slug as $key => $cate) {
            $category_id=$cate->category_id;
        }


         //danh muc cha
         $category_sub=Category::where('category_parent', $category_id)->where('category_status','1')->get();
         $array_sub=array();
         foreach($category_sub as $key => $sub){
             $array_sub[]=$sub->category_id;
         }
         array_push($array_sub, $category_id);

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

         if(isset($_GET['sort_by'])){
            $sort_by=$_GET['sort_by'];
            $sort_price=$_GET['sort_price'];
            //lọc 1
            if($sort_by=="giam_dan" &&  $sort_price==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_by=="tang_dan" &&  $sort_price==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);

                }


            }
            elseif($sort_by=="kytu_az" &&  $sort_price==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_name','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_name','ASC')
                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_by=="kytu_za" &&  $sort_price==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_name','DESC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->orderBy('product_name','DESC')
                    ->paginate(9)->appends($_GET);

                }

            }
            //lọc 2
            if($sort_price=="duoi_1t" &&  $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="1t_5t" &&  $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="5t_10t" &&  $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="10t_20t" &&  $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="20t_30t" &&  $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="tren_30t" &&  $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)

                    ->paginate(9)->appends($_GET);

                }

            }

            //lọc kết hợp
            elseif($sort_price=="duoi_1t"  && $sort_by=="tang_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="duoi_1t"  && $sort_by=="giam_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="duoi_1t"  && $sort_by=="kytu_za"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="duoi_1t"  && $sort_by=="kytu_az"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','<',1000000)

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);

                }

            }




            elseif($sort_price=="1t_5t"  && $sort_by=="tang_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)

                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)

                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="1t_5t"  && $sort_by=="giam_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);

                }


            }
            elseif($sort_price=="1t_5t"  && $sort_by=="kytu_za"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);

                }

            }
            elseif($sort_price=="1t_5t"  && $sort_by=="kytu_az"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[1000000,5000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }



            elseif($sort_price=="5t_10t"  && $sort_by=="tang_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t"  && $sort_by=="giam_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t"  && $sort_by=="kytu_za"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="5t_10t"  && $sort_by=="kytu_az"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[5000000,10000000])

                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }


            elseif($sort_price=="10t_20t"  && $sort_by=="giam_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t"  && $sort_by=="tang_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_price','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t"  && $sort_by=="kytu_za"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="10t_20t"  && $sort_by=="kytu_az"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[10000000,20000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }




            elseif($sort_price=="20t_30t" && $sort_by=="giam_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }


            }
            elseif($sort_price=="20t_30t" && $sort_by=="tang_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="20t_30t" && $sort_by=="kytu_za"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="20t_30t" && $sort_by=="kytu_az"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->whereBetween('product_price',[20000000,30000000])
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }

            }



            elseif($sort_price=="tren_30t" && $sort_by=="giam_dan"){
                if($brand==""){

                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }else{

                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)


                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','DESC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" && $sort_by=="tang_dan"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)
                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_price','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" && $sort_by=="kytu_za"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)
                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','DESC')

                    ->paginate(9)->appends($_GET);
                }

            }
            elseif($sort_price=="tren_30t" && $sort_by=="kytu_az"){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','ASC')

                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->where('product_price','>',30000000)
                    ->orderBy('product_name','ASC')
                    ->paginate(9)->appends($_GET);
                }

            }

            elseif($sort_price=="" && $sort_by==""){
                if($brand==""){
                    $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                    ->where('product_status','1')
                    ->where('brand_status','1')

                    ->whereIn('category_id',$array_sub)
                    ->paginate(9)->appends($_GET);
                }else{
                    $category_by_id = Product::where('product_status','1')
                    ->whereIn('brand_id',$array_bra)

                    ->whereIn('category_id',$array_sub)
                    ->paginate(9)->appends($_GET);
                }
            }


        }
        elseif(isset($_GET['brand'])){
            if($brand==""){
                $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
                ->where('product_status','1')
                ->where('brand_status','1')

                ->whereIn('category_id',$array_sub)
                ->paginate(9)->appends($_GET);
            }else{
                $category_by_id = Product::whereIn('brand_id',$array_bra)
                ->whereIn('category_id',$array_sub)
                ->where('product_status','1')
                ->paginate(9)->appends($_GET);
            }

        }
        else{

            $category_by_id = Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
            ->where('product_status','1')
            ->where('brand_status','1')

            ->whereIn('category_id',$array_sub)
            ->paginate(9)->appends($_GET);


        }


        return view('pages.category.show_category')->with('category',$cate_product)->with('brand',$brand_product)->with('category_by_id',$category_by_id)->with('cate_name',$cate_name);



    }
    public function product_tabs(Request $request){
       $data=$request->all();
       $output='';
       $category_sub=Category::where('category_parent',$data['cate_id'])->where('category_status','1')->get();


       $array_sub=array();

       foreach($category_sub as $key => $sub){
        $array_sub[]=$sub->category_id;
       }

       array_push($array_sub,$data['cate_id']);

       $product=Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
       ->where('product_status','1')
       ->where('brand_status','1')->whereIn('category_id',$array_sub)->take(8)->get();

       $product_count=$product->count();
       if($product_count>0){
        $output.='	<div class="tab-content">

                        <div class="tab-pane fade active in" id="tshirt" >';

                        foreach ($product as $key => $val) {

                            $output.='<div class="col-sm-3">

                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                            <form action="">
                                            '.csrf_field().'
                                            <input type="hidden" value="'.$val->product_id.'" class="cart_product_id_'.$val->product_id.'">
                                            <input type="hidden" id="wishlist_productname'.$val->product_id.'" value="'.$val->product_name.'" class="cart_product_name_'.$val->product_id.'">
                                            <input type="hidden" value="'.$val->product_image.'" class="cart_product_image_'.$val->product_id.'">
                                            <input type="hidden" value="'.$val->product_quantity.'" class="cart_product_quantity_'.$val->product_id.'">
                                            <input type="hidden" value="'.$val->product_price.'" class="cart_product_price_'.$val->product_id.'">
                                            <input type="hidden" value="'.$val->product_slug.'" class="cart_product_slug_'.$val->product_id.'">
                                            <input type="hidden" value="'.$val->product_cost.'" class="cart_product_cost_'.$val->product_id.'">
                                            <input type="hidden" id="wishlist_productprice'.$val->product_id.'" value="'.number_format($val->product_price,0,',','.') .'" class="cart_product_price_'.$val->product_id.'">

                                            <input type="hidden" value="1" class="cart_product_qty_'.$val->product_id.'">

                                            <a id="wishlist_producturl'.$val->product_id.'" href="'.url('/chi-tiet-san-pham/'.$val->product_slug).'">
                                                <img  id="wishlist_productimage'.$val->product_id.'"  src="'.url('uploads/product/'.$val->product_image).'" alt="" />
                                                <h2>'.number_format($val->product_price,0,',','.').' vnđ</h2>
                                                <p style="height: 55px">'.$val->product_name.'</p>
                                            </a>
                                            <button type="button" class="btn btn-default add-to-cart add-item_'.$val->product_id.'" id="'.$val->product_id.'" onclick="add_to_cart(this.id)"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>

                                            <button type="button"  style="display:none;background: #d9534f;color: white;"  class="btn btn-default add-to-cart remove-item_'.$val->product_id.'" id="'.$val->product_id.'" onclick="remove_item(this.id)" ><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>
                                            </form>

                                    </div>

                                </div>

                                <div class="choose">
                                <ul class="nav nav-pills nav-justified">

                                    <li>
                                        <span  class="like_'.$val->product_id.'">
                                            <i class="fa fa-star"></i>
                                            <button class="button_wishlisht " id="'.$val->product_id.'"
                                                onclick="add_wishlist(this.id);"><span>Yêu thích</span>
                                            </button>
                                        </span>

                                        <span style="display:none" class="delete_'.$val->product_id.'" >
                                            <i style="color: orange" class="fa fa-star"></i>
                                            <button  class="button_wishlisht delete_wishlist" data-id="'.$val->product_id.'"
                                                ><span style="color: orange">Yêu thích</span>
                                            </button>
                                        </span>
                                    </li>

                                </ul>
                            </div>


                            </div>
                        </div>';
                        }

              $output.='</div>
                    </div>




                  ';


       }

       echo  $output;
    }
    public function show_more(Request $request){
        $data=$request->all();
        $output='';

        $show_more=Category::where('category_id',$data['cate_id'])->where('category_status','1')->first();
        $category_sub=Category::where('category_parent',$data['cate_id'])->where('category_status','1')->get();

        $array_sub=array();

        foreach($category_sub as $key => $sub){
         $array_sub[]=$sub->category_id;
        }

        array_push($array_sub,$data['cate_id']);

        $product=Product::join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('product_status','1')
        ->where('brand_status','1')->whereIn('category_id',$array_sub)->take(8)->get();

        $product_count=$product->count();
        if($product_count>0){
            $output.='
                <a href="'.url('/danh-muc-san-pham/'.$show_more->category_slug).'">Xem thêm sản phẩm</a>
            ';

        }
        echo  $output;

    }
}
