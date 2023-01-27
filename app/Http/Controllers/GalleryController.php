<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\Gallery;
use App\Models\Product;
class GalleryController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function add_gallery($product_slug){
        $this->AuthLogin();
        $pro=Product::where('product_slug',$product_slug)->first();
        $pro_id= $pro->product_id;
    	return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }
    public function select_gallery(Request $request){
        $this->AuthLogin();
        $product_id = $request->pro_id;
        $gallery=Gallery::where('product_id',$product_id)->orderby('gallery_id','desc')->get();
        $gallery_count=$gallery->count();
        $output=
        '<form>
        '.csrf_field().'
        <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên hình ảnh</th>
            <th>Hình ảnh</th>
            <th>Quản lý</th>
          </tr>
        </thead>
        <tbody>

        ';
        if($gallery_count>0){
            $i=0;
            foreach($gallery as $key =>$gal){
                $i++;
                $output.='

                    <tr>
                            <td>'. $i.'</td>
                            <td contenteditable data-gal_id="'.$gal->gallery_id.'" class="edit_gallery_name">'.$gal->gallery_name.'</td>
                             <td><img src="'.url('uploads/gallery/'.$gal->gallery_image).'" height="100" width="100" >

                             <input name="file" accept="image/*" id="file-'.$gal->gallery_id.'" type="file" class="file_image" style="width:40%" data-gal_id="'.$gal->gallery_id.'"/></td>
                            <td><button type="button" data-gal_id="'.$gal->gallery_id.'" class="btn btn-sm btn-danger delete-gallery">Xóa</button></td>
                         </tr>

                ';

            }
        }
        // else{
        //     $output.='  <tr>
        //                      <td colspan="4">Sản phẩm chưa có thư viện ảnh</td>
        //             </tr>';
        // }
        $output.='

                 </tbody>
            </table>
            </form>'
            ;
        echo $output;
    }
    public function insert_gallery(Request $request,$pro_id){
        $this->AuthLogin();
        $get_image=$request->file('file');
        if($get_image){
            foreach($get_image as $image){
                $get_name_image = $image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,999).'.'.$image->getClientOriginalExtension();
                $image->move('uploads/gallery',$new_image);
                $gallery =new Gallery();
                $gallery->gallery_name=$new_image;
                $gallery->gallery_image=$new_image;
                $gallery->product_id=$pro_id;
                $gallery->save();
            }
            Session::put('message','Thêm hình ảnh thành công');
            return redirect()->back();
        }
        else{
            Session::put('msg','Bạn chưa thêm hình ảnh');
            return redirect()->back();
        }
    }
    public function update_gallery_name(Request $request){
        $this->AuthLogin();
        $gal_id=$request->gal_id;
        $gal_text=$request->gal_text;
        $gallery =Gallery::find($gal_id);
        $gallery->gallery_name=$gal_text;
        $gallery->save();
    }
    public function delete_gallery(Request $request){
        $this->AuthLogin();
        $gal_id=$request->gal_id;
        $gallery =Gallery::find($gal_id);
        unlink('uploads/gallery/'.$gallery->gallery_image);
        $gallery->delete();

    }
    public function update_gallery(Request $request){
        $this->AuthLogin();
        $get_image=$request->file('file');
        $gal_id=$request->gal_id;
        if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('uploads/gallery',$new_image);
                $gallery =Gallery::find($gal_id);
                unlink('uploads/gallery/'.$gallery->gallery_image);

                $gallery->gallery_image=$new_image;

                $gallery->save();
                return redirect()->back();
        }

    }
}
