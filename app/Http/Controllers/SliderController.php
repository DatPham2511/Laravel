<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
session_start();

class SliderController extends Controller
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
    //admin - danh sách slide
    public function manage_slider(){
        $this->AuthLogin();
    	$all_slide = Slider::orderBy('slider_id','DESC')->get();
    	return view('admin.slider.list_slider')->with(compact('all_slide'));
    }
    //admin - thêm
    public function add_slider(){
        $this->AuthLogin();
    	return view('admin.slider.add_slider');
    }

    public function insert_slider(Request $request){

    	$this->AuthLogin();
        $request->validate([
            'slider_name' =>'required',
            'slider_desc' =>'required',
            'slider_image' =>'required',
        ],[
            'slider_name.required' =>'Tên slider không được để trống',
            'slider_desc.required' =>'Mô tả không được để trống',
            'slider_image.required' =>'Hình ảnh không được để trống',
        ]
        );
   		$data = $request->all();
       	$get_image = request('slider_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
           	$slider->save();
            Session::put('message','Thêm slider thành công');
            return Redirect::to('manage-slider');
        }

    }
    public function unactive_slide($slide_id){
        $this->AuthLogin();
        Slider::where('slider_id',$slide_id)->update(['slider_status'=>0]);
        Session::put('message','Khóa slider thành công');
        return Redirect::to('manage-slider');

    }
    public function active_slide($slide_id){
        $this->AuthLogin();
        Slider::where('slider_id',$slide_id)->update(['slider_status'=>1]);
        Session::put('message','Kích hoạt slider thành công');
        return Redirect::to('manage-slider');

    }
    public function delete_slide(Request $request, $slide_id){
        $this->AuthLogin();
        $slider = Slider::find($slide_id);
        unlink('uploads/slider/'.$slider->slider_image);
        $slider->delete();
        Session::put('message','Xóa slider thành công');
        return redirect()->back();
    }
    public function edit_slide($slide_id){
        $this->AuthLogin();
    	$all_slide = Slider::where('slider_id',$slide_id)->get();
    	return view('admin.slider.edit_slider')->with(compact('all_slide'));
    }

    public function update_slide(Request $request,$slide_id){
    	$this->AuthLogin();
        $request->validate([
            'slider_name' =>'required',
            'slider_desc' =>'required',

        ],[
            'slider_name.required' =>'Tên slider không được để trống',
            'slider_desc.required' =>'Mô tả không được để trống',

        ]
        );
        $data['slider_name'] = $request->slider_name;
        $data['slider_desc'] = $request->slider_desc;
       	$get_image = request('slider_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/slider', $new_image);
            $data['slider_image'] = $new_image;
        }
            Slider::where('slider_id',$slide_id)->update($data);
            Session::put('message','Cập nhật slider thành công');
            return Redirect::to('manage-slider');


    }


}
