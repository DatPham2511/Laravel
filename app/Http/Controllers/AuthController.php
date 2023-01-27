<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Roles;
use App\Models\Statistic;
use App\Models\Post;
use Carbon\Carbon;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Redirect;
use Auth;
class AuthController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function login_auth(){
        return view('admin.login_auth');
    }
    public function login(LoginRequest $request){
      $data=$request->all();
       if(Auth::attempt(['admin_email'=>$data['admin_email'],'admin_password'=>$data['admin_password']])){
            return redirect('/dashboard');
       }else{
         return redirect('/admin')->with('message','Email hoặc mật khẩu không đúng');
       }
    }
    public function logout_auth(Request $request){
        $this->AuthLogin();
        Auth::logout();
       return redirect('/admin');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard.dashboard');
    }
    public function show_statistic(){
        $this->AuthLogin();
        $app_product=Product::all()->count();
        $app_news=Post::all()->count();
        $app_order=Order::all()->count();
        $app_customer=Customer::all()->count();
        $app_product_hot=Product::orderBy('product_sold','DESC')->take(10)->get();
        $app_product_sold_out=Product::where('product_quantity','<=',5)->orderBy('product_quantity','ASC')->get();
        return view('admin.statistic.statistic')->with(compact('app_product','app_order','app_customer','app_product_hot','app_product_sold_out','app_news'));
    }
    public function filter_by_date(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $from_date=$data['from_date'];
        $to_date=$data['to_date'];
        $get=Statistic::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();
        foreach($get as $key => $val){
            $chart_data[]=array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity,

            );
        }
        echo $data=json_encode( $chart_data);

    }
    public function  dashboard_filter(Request $request){
        $this->AuthLogin();
        $data=$request->all();

        $dauthangnay=Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days=Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days=Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $now=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value']=='7ngay'){
            $get=Statistic::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value']=='thangtruoc'){
            $get=Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value']=='thangnay'){
            $get=Statistic::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();
        }else{
            $get=Statistic::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }
        foreach($get as $key => $val){
            $chart_data[]=array(
                'period'=>$val->order_date,
                'order'=>$val->total_order,
                'sales'=>$val->sales,
                'profit'=>$val->profit,
                'quantity'=>$val->quantity,

            );
        }
        echo $data=json_encode( $chart_data);

    }
    public function days_order(){
        $this->AuthLogin();
        $now=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get=Statistic::where('order_date',$now)->first();

            $chart_data[]=array(
                'period'=>$get->order_date,
                'order'=>$get->total_order,
                'sales'=>$get->sales,
                'profit'=>$get->profit,
                'quantity'=>$get->quantity,

            );

        echo $data=json_encode( $chart_data);

    }


}
