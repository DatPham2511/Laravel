<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//trang chu
Route::get('/', 'HomeController@index');
Route::get('/tim-kiem', 'HomeController@search');


//trang chủ-liên hệ
Route::get('/lien-he', 'ContactController@lien_he');

//trang chu
Route::get('/danh-muc-san-pham/{category_slug}', 'CategoryController@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_slug}', 'BrandController@show_brand_home');
Route::get('/chi-tiet-san-pham/{product_slug}', 'ProductController@details_product');
Route::post('/product-tabs', 'CategoryController@product_tabs');//tab san pham
Route::post('/show-more', 'CategoryController@show_more');//tab more

//trang chu - cart
Route::post('/add-cart-ajax', 'CartController@add_cart_ajax');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/delete-cart/{session_id}', 'CartController@delete_cart');
Route::post('/update-cart', 'CartController@update_cart');
Route::get('/show-cart-menu', 'CartController@show_cart_menu');//đếm
Route::get('/hover-cart', 'CartController@hover_cart');
Route::get('/remove-item', 'CartController@remove_item');//xóa
Route::get('/cart-session', 'CartController@cart_session');//xóa


//trang chu - coupon
Route::post('/check-coupon', 'CartController@check_coupon');
Route::get('/unset-coupon', 'CartController@unset_coupon');



// trang chu -check out
Route::get('/login-checkout', 'CheckoutController@login_checkout');

Route::post('/add-customer', 'CheckoutController@add_customer');// dang ky
Route::post('/login-customer', 'CheckoutController@login_customer');// dang nhap
Route::get('/checkout', 'CheckoutController@checkout');
Route::get('/logout-checkout', 'CheckoutController@logout_checkout');// dang xuat

Route::post('/select-delivery-home','CheckoutController@select_delivery_home');//chọn thành phố
Route::post('/calculate-fee','CheckoutController@calculate_fee');//tính phí vận chuyển
Route::get('/del-fee','CheckoutController@del_fee');//xóa phí
Route::post('/confirm-order','CheckoutController@confirm_order');//xác nhận đặt hàng



//trang chủ-quên mật khẩu
Route::get('/quen-mat-khau', 'MailController@quen_mat_khau');
Route::post('/recover-pass', 'MailController@recover_pass');
Route::get('/update-new-pass', 'MailController@update_new_pass');
Route::post('/reset-new-pass', 'MailController@reset_new_pass');

//trang chu-lich su don hang
Route::get('/history-order','OrderController@history_order');
Route::get('/view-history-order/{order_code}','OrderController@view_history_order');
Route::get('/huy-don-hang/{order_code}','OrderController@huy_don_hang');

//trang chu - gg fb
Route::get('/login-customer-google', 'MailController@login_customer_google');
Route::get('/customer/google/callback','MailController@callback_customer_google');

Route::get('/login-customer-facebook', 'MailController@login_customer_facebook');
Route::get('/customer/facebook/callback','MailController@callback_customer_facebook');

//trang chu - tai khoan
Route::get('/tai-khoan', 'UserController@tai_khoan');
Route::post('/save-account', 'UserController@save_account');

//vnpay
Route::post('/vnpay-payment', 'CheckoutController@vnpay_payment');

//trang chu - tin tuc

Route::get('/tin-tuc', 'PostController@tin_tuc');
Route::get('/bai-viet/{post_slug}', 'PostController@bai_viet');









//admin-category
Route::get('/add-category-product', 'CategoryController@add_category_product');
Route::get('/all-category-product', 'CategoryController@all_category_product');
Route::post('/save-category-product', 'CategoryController@save_category_product');

Route::get('/edit-category-product/{category_product_slug}','CategoryController@edit_category_product');


Route::post('/update-category-product/{category_product_id}','CategoryController@update_category_product');
Route::get('/delete-category-product/{category_product_id}','CategoryController@delete_category_product');

Route::get('/unactive-category-product/{category_product_id}','CategoryController@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','CategoryController@active_category_product');

//admin-brand
Route::get('/add-brand-product', 'BrandController@add_brand_product');
Route::get('/all-brand-product', 'BrandController@all_brand_product');
Route::post('/save-brand-product', 'BrandController@save_brand_product');

Route::get('/edit-brand-product/{brand_product_slug}','BrandController@edit_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandController@update_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','BrandController@delete_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}','BrandController@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','BrandController@active_brand_product');

//admin-product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/all-product', 'ProductController@all_product');
Route::post('/save-product', 'ProductController@save_product');

Route::get('/edit-product/{product_slug}','ProductController@edit_product');
Route::post('/update-product/{product_id}','ProductController@update_product');
Route::get('/delete-product/{product_id}','ProductController@delete_product');

Route::get('/unactive-product/{product_id}','ProductController@unactive_product');
Route::get('/active-product/{product_id}','ProductController@active_product');

//admin - đơn hàng
Route::get('/manage-order','OrderController@manage_order');
Route::get('/view-order/{order_code}','OrderController@view_order');
Route::get('/delete-order/{order_code}','OrderController@delete_order');

Route::post('/update-order-qty','OrderController@update_order_qty');//xử lý số lượng đơn hàng
Route::post('/update-qty','OrderController@update_qty');//cap nhat so luong don hang
//admin - coupon
Route::get('/insert-coupon', 'CouponController@insert_coupon');
Route::post('/insert-coupon-code', 'CouponController@insert_coupon_code');
Route::get('/list-coupon', 'CouponController@list_coupon');
Route::get('/delete-coupon/{coupon_id}', 'CouponController@delete_coupon');
Route::get('/unactive-coupon/{coupon_id}','CouponController@unactive_coupon');
Route::get('/active-coupon/{coupon_id}','CouponController@active_coupon');
Route::get('/edit-coupon/{coupon_code}','CouponController@edit_coupon');
Route::post('/update-coupon/{coupon_id}','CouponController@update_coupon');

Route::get('/send-coupon/{coupon_code}','CouponController@send_coupon');

//admin- tính vận chuyển
Route::get('/delivery', 'DeliveryController@delivery');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');

//admin - in đơn hàng
Route::get('/print-order/{checkout_code}','OrderController@print_order');

//admin - slider
Route::get('/manage-slider','SliderController@manage_slider');
Route::get('/add-slider','SliderController@add_slider');
Route::get('/delete-slide/{slide_id}','SliderController@delete_slide');
Route::post('/insert-slider','SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}','SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}','SliderController@active_slide');
Route::get('/edit-slide/{slide_id}','SliderController@edit_slide');
Route::post('/update-slide/{slide_id}','SliderController@update_slide');

//admin - authen

Route::get('/admin','AuthController@login_auth');
Route::post('/login','AuthController@login');
Route::get('/dashboard', 'AuthController@show_dashboard');//trang dashboard
Route::get('/logout-auth','AuthController@logout_auth');


//admin - user
Route::group(['middleware'=> 'auth.roles'], function () {
    Route::get('/user','UserController@index');
    Route::get('/add-user','UserController@add_user');
    Route::post('/store-user','UserController@store_user');
    Route::get('/edit-user/{admin_id}','UserController@edit_user');
    Route::get('/delete-user/{admin_id}','UserController@delete_user');
    Route::post('/update-user/{admin_id}','UserController@update_user');
    //admin-thống kê
    Route::post('/filter-by-date','AuthController@filter_by_date');
    Route::post('/dashboard-filter','AuthController@dashboard_filter');
    Route::post('/days-order','AuthController@days_order');
    Route::get('/statistic', 'AuthController@show_statistic');
});

//admin - gallery
Route::get('/add-gallery/{product_slug}','GalleryController@add_gallery');
Route::get('/select-gallery','GalleryController@select_gallery');
Route::post('/insert-gallery/{pro_id}','GalleryController@insert_gallery');
Route::post('/update-gallery-name','GalleryController@update_gallery_name');
Route::post('/delete-gallery','GalleryController@delete_gallery');
Route::post('/update-gallery','GalleryController@update_gallery');

//admin - tin tức
Route::get('/add-post','PostController@add_post');
Route::post('/save-post','PostController@save_post');
Route::get('/list-post','PostController@list_post');
Route::get('/unactive-post/{post_id}','PostController@unactive_post');
Route::get('/active-post/{post_id}','PostController@active_post');
Route::get('/edit-post/{post_slug}','PostController@edit_post');
Route::post('/update-post/{post_id}','PostController@update_post');
Route::get('/delete-post/{post_id}','PostController@delete_post');


//admin - liên hệ
Route::get('/information','ContactController@information');
// Route::post('/save-info','ContactController@save_info');
Route::post('/update-info/{info_id}','ContactController@update_info');


