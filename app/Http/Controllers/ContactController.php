<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Information;
use Auth;
use Session;

class ContactController extends Controller
{
    //trang chủ
    public function lien_he(){
        $contact= information::get();
        $cate_product = Category::where('category_status','1')->get();
        $brand_product = Brand::where('brand_status','1')->get();
        return view('pages.contact.contact')->with('brand',$brand_product)->with('category',$cate_product)
        ->with('contact',$contact);
    }



    //admin
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function information(){
        $this->AuthLogin();
        $contact= information::get();
        return view('admin.information.add_information')->with(compact('contact'));

    }
    // public function save_info(Request $request){
    //     $this->AuthLogin();
    //     $request->validate([
    //         'info_contact' =>'required',
    //         'info_map' =>'required',
    //         'info_fanpage' =>'required',


    //     ],[
    //         'info_contact.required' =>'Thông tin liên hệ không được để trống',
    //         'info_map.required' =>'Bản đồ không được để trống',

    //         'info_fanpage.required' =>'Fanpage không được để trống'
    //     ]
    //     );
    //     $data=$request->all();
    //     $information =new Information();
    //     $information->info_contact=$data['info_contact'];
    //     $information->info_map=$data['info_map'];
    //     $information->info_fanpage=$data['info_fanpage'];
    //     $get_image = $request->file('info_logo');
    //     $path='uploads/contact/';
    //     if($get_image){
    //         $get_name_image = $get_image->getClientOriginalName();
    //         $name_image = current(explode('.',$get_name_image));
    //         $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
    //         $get_image->move($path,$new_image);
    //         $information->info_logo=$new_image;

    //     }
    //     $information->save();
    //     Session::put('message','Thêm thông tin website thành công');
    //     return Redirect::to('information');

    // }
    public function update_info(Request $request,$info_id){
        $this->AuthLogin();
        $request->validate([
            'info_contact' =>'required',
            'info_map' =>'required',
            'info_fanpage' =>'required',
            'info_slogan' =>'required',


        ],[
            'info_contact.required' =>'Thông tin liên hệ không được để trống',
            'info_map.required' =>'Bản đồ không được để trống',
            'info_fanpage.required' =>'Fanpage không được để trống',
            'info_slogan.required' =>'Slogan không được để trống'
        ]
        );
        $data=$request->all();
        $information =Information::find($info_id);
        $information->info_contact=$data['info_contact'];
        $information->info_map=$data['info_map'];
        $information->info_fanpage=$data['info_fanpage'];
        $information->info_slogan=$data['info_slogan'];
        $get_image = $request->file('info_logo');
        $path='uploads/contact/';
        if($get_image){
            unlink($path.$information->info_logo);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $information->info_logo=$new_image;
        }
        $information->save();
        Session::put('message','Cập nhật thông tin website thành công');
        return Redirect::to('information');

    }
}
