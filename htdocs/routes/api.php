<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//第三方接口
Route::group(['middleware' => 'token'], function () {

    Route::get('/products', 'Api\ThirdController@product');
});
//商品下订单
Route::post('/order', 'Api\NewOrderController@placeOrder');

//snack下商业订单
Route::post('/business/order', 'Api\BusinessOrderController@placeOrder');

//TODO 商品类

//获取某商品评论接口
Route::post('/shop/message', 'Api\ShopController@shopMessage');

//效验商品库存接口
Route::get('/check/product', 'Api\NewOrderController@checkProductStock');

//获取订单状态接口
Route::get('/order/state', 'Api\NewOrderController@orderState');

//获取商业订单状态接口
Route::get('/order/bunsiess/state', 'Api\NewOrderController@orderBunsiessState');
//app商品下订单
Route::get('/shop/order', 'Api\AppOrderController@placeOrder');

//获取分类接口
Route::get('/category/list', 'Api\ShopController@categoryList');

//获取某分类商品列表接口
Route::get('/category/product/list', 'Api\ShopController@categoryProductList');

//获取某商品接口
Route::get('/shop/list', 'Api\ShopController@shopList');

//获取首页列表接口
Route::get('/home/page', 'Api\ShopController@homePage');

//获取login图标接口
Route::get('/home/login', 'Api\ShopController@login');

//搜索商品接口
Route::get('/product/search', 'Api\ShopController@productSearch');

//TODO 支付类
//paypal回调接口
Route::post('/pal/notify', 'Api\NewOrderController@palNotify');


//Authorize支付接口
Route::get('/pal/authorize', 'Api\AuthorizeController@pay');

//Authorize跳转白表单接口
//Route::post('/pal/authorize', 'Api\AuthorizeController@authorizeToken');

//citon citcon支付宝微信请求支付接口
Route::get('/citon/pay', 'Api\CitconController@pay');

//citon 回调接口
Route::post('/citon/callback', 'Api\CitconController@payCallback');

//authorize 账单上传接口
Route::post('/authorize/invoice', 'Api\AuthorizeController@authorizeInvoice');

//税金接口
Route::get('/tax/zip/{zip}/city/{city}', 'Api\ShopController@tax');

//TODO 用户类

//获取用户某订单详情
Route::get('/users/order/details', 'Api\NewOrderController@getOrderDetails');

Route::get('/business/order/details', 'Api\NewOrderController@getBusinessDetails');

//TODO App订单详情地址

//查看折扣码接口
Route::get('/discount/use', 'Api\ShopController@discountUse');


//获取用户发票地址接口
Route::get('/user/bill/address','Api\UserController@billAddress');

//修改用户发票地址接口
Route::post('/edit/user/bill/address','Api\UserController@editBillAddress');

//上传用户发票地址接口
Route::post('/insert/user/bill/address', 'Api\UserController@insertAddress');


Route::get('/apps/order/address','Api\NewOrderController@orderAddress');

//获取用户地址信息接口
Route::get('/user/address', 'Api\UserController@addressList');

//获取地址信息
Route::get('/user/edit/address', 'Api\UserController@updateAddress');

//获取某用户地址信息接口
Route::get('/users/details', 'Api\UserController@addressDetails');

//修改用户地址接口
Route::get('/edit/user/address', 'Api\UserController@editAddress');

//修改支付地址接口
Route::get('/edit/user/editAddress', 'Api\NewOrderController@editAddress');

//删除用户地址接口
Route::get('/del/user/address', 'Api\UserController@delAddress');

//获取用户评论管理接口
Route::get('/user/comment', 'Api\UserController@message');

//获取待评论产品
Route::get('/pc/tocomment', 'Api\UserController@toComments');

//获取用户订单计数接口
Route::get('/pc/order/count', 'Api\NewOrderController@countOrderIndex');

//上传用户地址信息接口
Route::get('/upload/user/address', 'Api\UserController@aadAddress');

//获取用户全部评论接口
Route::post('/user/comments', 'Api\UserController@personalComment');

//TODO 注册登录类
//用户注册接口
Route::get('/user/register', 'Api\UserController@userRegister');

//用户登录接口
Route::get('/user/sign', 'Api\UserController@userSign');

//重新发送邮件接口
Route::get('/send/email', 'Api\UserController@againSendEmail');

//点击邮箱回调
Route::get('/email/deal/{token?}', 'Api\UserController@emailDeal');






