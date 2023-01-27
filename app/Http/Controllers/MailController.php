<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Category;
use Socialite;
use App\Models\Social;
use Session;

class MailController extends Controller
{
    //mail
    public function quen_mat_khau(){
        $cate_product = Category::where('category_status','1')->get();
        return view('pages.checkout.forget_pass')->with('category',$cate_product);
    }
    public function recover_pass(Request $request){
        $request->validate([
            'email_account' =>'required|email',
        ],[
            'email_account.required' =>'Email không được để trống',
            'email_account.email' =>'Email không đúng định dạng',
        ]
        );
        $data=$request->all();
        // $now=Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $title_mail="Tạo mật khẩu mới Đạt Store";
        $customer=Customer::where('customer_email',$data['email_account'])->get();

            $count_customer=$customer->count();
            if($count_customer==0){
                return redirect()->back()->with('error','Email không đúng');
            }else{
                foreach ($customer as $key => $value) {
                    $customer_id=$value->customer_id;
                }
                //mã token
                $token_random=Str::random();
                $customer=Customer::find($customer_id);
                $customer->customer_token=$token_random;
                $customer->save();

                //gửi mail
                $to_email=$data['email_account'];
                $link_reset_pass=url('/update-new-pass?email='.$to_email.'&token='.$token_random);

                $data=array('name'=>$title_mail,'body'=>$link_reset_pass,'email'=>$data['email_account']);

                Mail::send('pages.checkout.forget_pass_notify',['data'=>$data],function($message) use ($title_mail,$data){
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'],'Đạt Store');

                });
                return redirect()->back()->with('message','Gửi thành công. Vui lòng kiểm tra email của bạn để tạo mật khẩu mới');

            }


    }
    public function update_new_pass(){
        $cate_product = Category::where('category_status','1')->get();
        return view('pages.checkout.new_pass')->with('category', $cate_product);
    }
    public function reset_new_pass(Request $request){
        $request->validate([
            'password_account' =>'required',
        ],[
            'password_account.required' =>'Mật khẩu không được để trống',

        ]
        );
        $data=$request->all();
        $token_random=Str::random();
        $customer=Customer::where('customer_email','=',$data['email'])->where('customer_token','=',$data['token'])->get();
        $count_customer=$customer->count();
        if($count_customer>0){
            foreach ($customer as $key => $value) {
                $customer_id=$value->customer_id;
           }
           $reset=Customer::find($customer_id);
           $reset->customer_password=$data['password_account'];
           $reset->customer_token=$token_random;
           $reset->save();
           return redirect('login-checkout')->with('message','Thay đổi mật khẩu thành công');
        }else{
           return redirect('quen-mat-khau')->with('error','Vui lòng nhập lại email vì link đã quá hạn');
        }

    }

    //google
    public function login_customer_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_customer_google(){
        $cust_google = Socialite::driver('google')->stateless()->user();

        $authCustomer = $this->findOrCreateCustomer($cust_google,'google');

        if($authCustomer){
            $account = Customer::where('customer_id',$authCustomer->user)->first();

            Session::put('customer_id',$account->customer_id);
            Session::put('customer_name',$account->customer_name);
            Session::put('customer_email',$account->customer_email);
        }elseif($customer_new){
            $account = Customer::where('customer_id',$authCustomer->user)->first();

            Session::put('customer_id',$account->customer_id);
            Session::put('customer_name',$account->customer_name);
            Session::put('customer_email',$account->customer_email);
        }
        return redirect('checkout');
    }

    public function findOrCreateCustomer($cust_google , $provider){
        $authCustomer = Social::where('provider_user_id', $cust_google->id)->first();

        if($authCustomer){
            return $authCustomer;
        }else{
            $customer_new = new Social([
                'provider_user_id' => $cust_google->id,
                'provider_user_email' => $cust_google->email,
                'provider' => strtoupper($provider)
            ]);

            $cust = Customer::where('customer_email',$cust_google->email)->first();
            if(!$cust){
                $cust = Customer::create([
                    'customer_name' => $cust_google->name,
                    'customer_email' => $cust_google->email,
                    'customer_password' => '',
                    'customer_phone' => ''

                ]);
            }
            $customer_new->customer()->associate($cust);
            $customer_new->save();

            return $customer_new;

        }



    }
    //facebook
    public function login_customer_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_customer_facebook(){
        $cust_fb = Socialite::driver('facebook')->user();
        $authCustomer = $this->findOrCreateCust($cust_fb,'facebook');

        if($authCustomer){
            $account = Customer::where('customer_id',$authCustomer->user)->first();

            Session::put('customer_id',$account->customer_id);
            Session::put('customer_name',$account->customer_name);
            Session::put('customer_email',$account->customer_email);
        }elseif($customer_new){
            $account = Customer::where('customer_id',$authCustomer->user)->first();

            Session::put('customer_id',$account->customer_id);
            Session::put('customer_name',$account->customer_name);
            Session::put('customer_email',$account->customer_email);
        }
        return redirect('checkout');
    }

    public function findOrCreateCust($cust_fb , $provider){
        $authCustomer = Social::where('provider_user_id', $cust_fb->id)->first();

        if($authCustomer){
            return $authCustomer;
        }else{
            $customer_new = new Social([
                'provider_user_id' => $cust_fb->id,
                'provider_user_email' => $cust_fb->email,
                'provider' => strtoupper($provider)
            ]);

            $cust = Customer::where('customer_email',$cust_fb->email)->first();
            if(!$cust){
                $cust = Customer::create([
                    'customer_name' => $cust_fb->name,
                    'customer_email' => $cust_fb->email,
                    'customer_password' => '',
                    'customer_phone' => ''

                ]);
            }
            $customer_new->customer()->associate($cust);
            $customer_new->save();

            return $customer_new;

        }



    }


}
