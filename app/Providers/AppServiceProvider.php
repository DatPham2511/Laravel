<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Information;
use App\Models\Post;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view){
            $app_news=Post::all()->count();
            $app_product=Product::all()->count();
            $app_order=Order::all()->count();
            $app_customer=Customer::all()->count();
            $app_product_hot=Product::orderBy('product_sold','DESC')->take(10)->get();
            $app_product_sold_out=Product::where('product_quantity','<=',5)->orderBy('product_quantity','ASC')->get();

            $contact_footer=Information::get();

            $view->with('app_product',$app_product)->with('app_order',$app_order)->with('app_customer',$app_customer)->with('app_product_hot',$app_product_hot)->with('app_product_sold_out',$app_product_sold_out)
            ->with('contact_footer',$contact_footer)->with('app_news',$app_news);

        });
    }
}
