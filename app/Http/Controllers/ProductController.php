<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Gallery;
use File;
use Auth;
session_start();

class ProductController extends Controller
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
    public function add_product(){
        $this->AuthLogin();
        $cate_product = Category::where('category_status',1)->get();
        $brand_product = Brand::where('brand_status',1)->get();
        return view('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product',$brand_product);
    }
    public function all_product(){
        $this->AuthLogin();
    	$all_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->orderBy('product_id','DESC')
        ->get();
    	$manager_product  = view('admin.product.all_product')->with('all_product',$all_product);
    	return view('admin.admin_layout')->with('admin.product.all_product', $manager_product);
    }
    public function save_product(ProductRequest $request){
        $this->AuthLogin();
    	$data = array();
    	$data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
    	$data['product_price'] = $request->product_price;
        $data['product_cost'] = $request->product_cost;
    	$data['product_desc'] = $request->product_desc;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_content'] = $request->product_content;
        $data['product_sold']=0;

        // $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image');
        $path='uploads/product/';
        $path_gallery='uploads/gallery/';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            File::copy($path.$new_image,$path_gallery.$new_image);
            $data['product_image'] = $new_image;
            $pro_id=Product::insertGetId($data);
            $gallery=new Gallery();
            $gallery->gallery_image=$new_image;
            $gallery->gallery_name=$new_image;
            $gallery->product_id=$pro_id;
            $gallery->save();
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('all-product');
        }
    }
    public function unactive_product($product_id){
        $this->AuthLogin();
       Product::where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Khóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function active_product($product_id){
        $this->AuthLogin();
       Product::where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_slug){
        $this->AuthLogin();

        $cate_product = Category::where('category_status',1)->get();
        $brand_product = Brand::where('brand_status',1)->get();
        $edit_product =Product::where('product_slug',$product_slug)->get();

        $manager_product  = view('admin.product.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);

        return view('admin.admin_layout')->with('admin.product.edit_product', $manager_product);
    }
    public function update_product(Request $request,$product_id){
        $this->AuthLogin();
        $request->validate([
            'product_name' =>'required',
            'product_quantity' =>'required|integer|min:1',
            'product_slug' =>'required|unique:tbl_product,product_slug,'.$product_id.',product_id',
            'product_price' =>'required',
            'product_cost' =>'required',
            'product_desc' =>'required',
            'product_content' =>'required',
        ],[
            'product_name.required' =>'Tên sản phẩm không được để trống',

            'product_quantity.required' =>'Số lượng không được để trống',
            'product_quantity.min' =>'Số lượng phải lớn hơn 0',
            'product_slug.required' =>'Slug không được để trống',
            'product_slug.unique' =>'Slug đã tồn tại',
            'product_price.required' =>'Giá bán không được để trống',
            'product_cost.required' =>'Giá gốc không được để trống',
            'product_content.required' =>'Chi tiết sản phẩm không được để trống',
            'product_desc.required' =>'Mô tả không được để trống',
        ]
        );
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
    	$data['product_price'] = $request->product_price;
        $data['product_cost'] = $request->product_cost;
    	$data['product_desc'] = $request->product_desc;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_content'] = $request->product_content;
        // $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image');
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('uploads/product',$new_image);
                    $data['product_image'] = $new_image;
                    Product::where('product_id',$product_id)->update($data);
                    Session::put('message','Cập nhật sản phẩm thành công');
                    return Redirect::to('all-product');
        }
        Product::where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id){
        $this->AuthLogin();
        $product =Product::find($product_id);
        $product->delete();
        unlink('uploads/product/'.$product->product_image);
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }

    //trang chủ - chi tiết sản phẩm
    public function details_product($product_slug,Request $request){

        $cate_product = Category::where('category_status','1')->get();
        $brand_product = Brand::where('brand_status','1')->get();

        $details_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('product_slug',$product_slug)
        ->where('product_status','1')
        ->where('category_status','1')
        ->where('brand_status','1')
        ->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $product_cate=$value->category_name;
            $cate_slug=$value->category_slug;
            $pro_name=$value->product_name;
            $url_canonical = $request->url();
            }

        //gallery
        $gallery = Gallery::where('product_id',$product_id)->get();


        $related_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)
        ->where('product_status','1')
        ->where('category_status','1')
        ->where('brand_status','1')
        ->whereNotIn('tbl_product.product_id',[$product_id])->take(4)->get();

        return view('pages.product.show_details')->with('category',$cate_product)->with('brand',$brand_product)->with('details_product',$details_product)
       ->with('related_product',$related_product)
       ->with('gallery',$gallery)
       ->with('product_cate',$product_cate)
       ->with('cate_slug',$cate_slug)
       ->with('pro_name',$pro_name)
       ->with('url_canonical',$url_canonical);
    }

}
