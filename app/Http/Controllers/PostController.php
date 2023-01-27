<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use App\Models\Post;
use App\Models\Category;
use App\Models\Brand;
class PostController extends Controller
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
    public function add_post(){
        $this->AuthLogin();
        return view('admin.post.add_post');

    }
    public function save_post(Request $request){
        $this->AuthLogin();
        $request->validate([
            'post_title' =>'required',
            'post_image' =>'required',
            'post_slug' =>'required|unique:tbl_post,post_slug',
            'post_desc' =>'required',
            'post_content' =>'required',

        ],[
            'post_title.required' =>'Tên bài viết không được để trống',
            'post_image.required' =>'Hình ảnh không được để trống',
            'post_slug.required' =>'Slug không được để trống',
            'post_slug.unique' =>'Slug đã tồn tại',
            'post_desc.required' =>'Mô tả không được để trống',
            'post_content.required' =>'Nội dung không được để trống',


        ]
        );
        $data = $request->all();
    	$post = new Post();

    	$post->post_title = $data['post_title'];
    	$post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_status = $data['post_status'];

        $get_image=$request->file('post_image');
        if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('uploads/post',$new_image);
                $post->post_image = $new_image;
                $post->save();
                Session::put('message','Thêm bài viết thành công');
                return Redirect::to('list-post');
        }
    }
    public function list_post(){
        $this->AuthLogin();
        $all_post=Post::orderBy('post_id','DESC')->get();
        return view('admin.post.list_post')->with(compact('all_post'));

    }
    public function unactive_post($post_id){
        $this->AuthLogin();
        Post::where('post_id',$post_id)->update(['post_status'=>0]);
        Session::put('message','Khóa bài viết thành công');
        return Redirect::to('list-post');

    }
    public function active_post($post_id){
        $this->AuthLogin();
        Post::where('post_id',$post_id)->update(['post_status'=>1]);
        Session::put('message','Kích hoạt bài viết thành công');
        return Redirect::to('list-post');

    }
    public function edit_post($post_slug){
        $this->AuthLogin();
    	$edit_post = Post::where('post_slug',$post_slug)->get();
    	return view('admin.post.edit_post')->with(compact('edit_post'));
    }
    public function update_post(Request $request,$post_id){
    	$this->AuthLogin();
        $request->validate([
            'post_title' =>'required',

            'post_slug' =>'required|unique:tbl_post,post_slug,'.$post_id.',post_id',
            'post_desc' =>'required',
            'post_content' =>'required',

        ],[
            'post_title.required' =>'Tên bài viết không được để trống',

            'post_slug.required' =>'Slug không được để trống',
            'post_slug.unique' =>'Slug đã tồn tại',
            'post_desc.required' =>'Mô tả không được để trống',
            'post_content.required' =>'Nội dung không được để trống',


        ]
        );
        $data = $request->all();
        $post =Post::find($post_id);

    	$post->post_title = $data['post_title'];
    	$post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $get_image=$request->file('post_image');
        if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('uploads/post',$new_image);
                $post->post_image = $new_image;
        }
            $post->save();
            Session::put('message','Cập nhật bài viết thành công');
            return Redirect::to('list-post');

    }
    public function delete_post(Request $request, $post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        unlink('uploads/post/'.$post->post_image);
        $post->delete();
        Session::put('message','Xóa bài viết thành công');
        return redirect()->back();
    }




    //trang chủ
    public function tin_tuc(){
        $category = Category::where('category_status','1')->get();
        $brand = Brand::where('brand_status','1')->get();
        $post=Post::where('post_status','1')->orderBy('post_id','DESC')->paginate(10);

        return view('pages.post.new')->with(compact('category','brand','post'));

    }

    public function bai_viet($post_slug){
        $category = Category::where('category_status','1')->get();
        $brand = Brand::where('brand_status','1')->get();
        $post_by_slug=Post::where('post_slug',$post_slug)->where('post_status','1')->first();
        return view('pages.post.new_detail')->with(compact('category','brand','post_by_slug'));

    }
}
