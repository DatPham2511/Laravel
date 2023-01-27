<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Roles;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Category;
use Auth;
use Session;

session_start();
class UserController extends Controller
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
    public function index(){
        $this->AuthLogin();
        $admin = Admin::with('roles')->orderBy('admin_id','DESC')->get();
        return view('admin.user.all_user')->with(compact('admin'));
    }
    public function edit_user(Request $request,$admin_id){
        $this->AuthLogin();
        $admin = Admin::with('roles')->where('admin_id',$admin_id)->get();
        $role=Roles::get();
        return view('admin.user.edit_user')->with(compact('admin','role'));
    }
    public function update_user(Request $request,$admin_id){

        $this->AuthLogin();
        $request->validate([
            'admin_name' =>'required',
            'admin_email' =>'required|email|unique:tbl_admin,admin_email,'.$admin_id.',admin_id',
            'admin_password' =>'required',
            'admin_phone' =>'required',
        ],[
            'admin_name.required' =>'Tên không được để trống',
            'admin_email.required' =>'Email không được để trống',
            'admin_email.email' =>'Email không đúng định dạng',
            'admin_email.unique' =>'Email đã tồn tại',
            'admin_password.required' =>'Mật khẩu không được để trống',
            'admin_phone.required' =>'Số điện thoại không được để trống',
        ]
        );
        $data = array();
        $data['admin_name'] = $request->admin_name;
        $data['admin_phone'] = $request->admin_phone;
        $data['admin_password'] = $request->admin_password;
        $data['admin_email'] = $request->admin_email;
        $data['admin_role'] = $request->admin_role;
        Admin::where('admin_id',$admin_id)->update($data);
        Session::put('message','Cập nhật người dùng thành công');
        return Redirect::to('user');
    }
    //admin-xóa user
    public function delete_user(Request $request,$admin_id){
        $this->AuthLogin();
        if(Auth::id()==$admin_id){
            return redirect()->back()->with('msg','Bạn không được xóa chính mình');
        }
        $admin=Admin::find($admin_id);
        $admin->delete();
        return redirect()->back()->with('message','Xóa người dùng thành công');
    }
    public function add_user(){
        $this->AuthLogin();
        $role=Roles::get();
        return view('admin.user.add_user')->with(compact('role'));
    }
    public function store_user(Request $request){
        $this->AuthLogin();
        $request->validate([
            'admin_name' =>'required',
            'admin_email' =>'required|email|unique:tbl_admin,admin_email',
            'admin_password' =>'required',
            'admin_phone' =>'required',
        ],[
            'admin_name.required' =>'Tên không được để trống',
            'admin_email.required' =>'Email không được để trống',
            'admin_email.email' =>'Email không đúng định dạng',
            'admin_email.unique' =>'Email đã tồn tại',
            'admin_password.required' =>'Mật khẩu không được để trống',
            'admin_phone.required' =>'Số điện thoại không được để trống',
        ]
        );
        $data = array();
        $data['admin_name'] = $request->admin_name;
        $data['admin_phone'] = $request->admin_phone;
        $data['admin_password'] = $request->admin_password;
        $data['admin_email'] = $request->admin_email;
        $data['admin_role'] = $request->admin_role;
        Admin::insert($data);
        Session::put('message','Thêm người dùng thành công');
        return Redirect::to('user');
    }

    //trang chủ
    public function CustomerLogin(){
        if(!Session::get('customer_id')){
            return redirect()->back();
        }
    }
    public function tai_khoan(){
        $this->CustomerLogin();
        $category = Category::where('category_status','1')->get();
        $customer_id=Session::get('customer_id');
        $customer=Customer::where('customer_id', $customer_id)->first();
        return view('pages.account.account_customer')->with(compact('customer','category'));
    }
    public function save_account(Request $request){
        $this->CustomerLogin();
        $data=$request->all();
        $customer_id=Session::get('customer_id');
        $request->validate([
            'customer_name' =>'required',
            'customer_email' =>'required|email|unique:tbl_customer,customer_email,'.$customer_id.',customer_id',
            'customer_password' =>'required',
            'customer_phone' =>'required',
        ],[
            'customer_name.required' =>'Tên không được để trống',
            'customer_email.required' =>'Email không được để trống',
            'customer_email.email' =>'Email không đúng định dạng',
            'customer_email.unique' =>'Email đã tồn tại',
            'customer_password.required' =>'Mật khẩu không được để trống',
            'customer_phone.required' =>'Số điện thoại không được để trống',
        ]
        );
        $customer=Customer::find($customer_id);
        $customer->customer_name=$data['customer_name'];
        $customer->customer_email=$data['customer_email'];
        $customer->customer_password=$data['customer_password'];
        $customer->customer_phone=$data['customer_phone'];
        $customer->save();
        return redirect()->back()->with('message','Cập nhật tài khoản thành công');

    }
}
