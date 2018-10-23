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

/*-----------------APP端----------------------------*/
//Route::get('/apps', function () {
//
//    return view('app.welcome');
//});
//Route::get('/home', 'HomeController@index')->name('home');

//TODO App首页页面
Route::get('/apps{order?}', 'App\ProductController@homePage')->name('home');

//TODO App分类页面
//Route::view('/apps/category', 'app.category')->name('category');
Route::get('/apps/category', 'App\ProductController@showCategory')->name('category');

//TODO App分类聚合页面
Route::get('/apps/category/categorylist/{id?}', 'App\ProductController@CategoryShop')->name('categorylist');

//TODO App品牌聚合页面
Route::get('/apps/brand/brandlist/{id?}', 'App\ProductController@brandShop')->name('brandlist');

//TODO App活动聚合页面
Route::get('/apps/activielist/{id?}', 'App\ProductController@ActivieShop')->name('categorylist');

//TODO App搜索商品显示页面
Route::get('/apps/productList', 'App\ProductController@productList')->name('productList');

//TODO App购物车页面
//Route::view('/apps/cart', 'app.cart')->name('cart');
Route::get('/apps/cart/{id?}', 'App\ProductController@shoppingCart')->name('cart');

//TODO App用户页面
//Route::view('/apps/user{id?}', 'App.user')->name('user');
Route::get('/apps/user/{id?}', 'App\ProductController@user')->name('user');

//TODO App商品页面
Route::get('/apps/product/{id?}', 'App\ProductController@details')->name('product');

//TODO App登出页面
Route::any('/apps/quit', 'App\ProductController@quit')->name('quit');

//TODO App重设密码页面
Route::get('/apps/rebuild', function () {

    return view('app.email');

})->name('rebuild');

Route::get('/apps/repasswd','App\LoginController@rebuild');

Route::get('/apps/code','App\LoginController@check');

//TODO App产品评论页面
Route::get('/apps/products/comments/{id}','App\UserController@productMessage');

////TODO App待评论页面
Route::get('/apps/tocomments/{id}','App\UserController@toComments');

Route::get('/apps/addComments','App\UserController@addComment');

//TODO App个人账户设置页面
Route::get('/apps/account','App\LoginController@userUpdate')->name('account');

//TODO App个人修改地址页面
Route::get('/apps/Record', function () {

    return view('app.record');

});

//TODO App联系我们页面
Route::get('/apps/contactUs', function () {

    return view('app.contactUs');

});

//TODO App用户条款
Route::get('/apps/userTerms', function () {

    $res = App\Http\Model\ArticleModel::getInfoById(13);

    return view('app.userTerms',['data' => $res->en_content]);

});

//修改个人信息
Route::post('/apps/update/personal/info','App\LoginController@UpdatePersonal');

//TODO App个人新增地址页面
Route::get('/apps/add/address', function () {

    return view('app.addAddress');

})->name('addAddress');

//TODO App个人新增发票地址页面
Route::get('/apps/bill/address', function () {

    return view('app.billAddress');

})->name('billAddress');

//TODO App个人修改地址页面
Route::get('/apps/edit/address', function () {

    return view('app.editAddress');

})->name('editAddress');

//TODO App个人地址管理页面
Route::get('/apps/address',function(){
    return view('app.address');
})->name('address');

//app订单删除
Route::get('/apps/delorder','App\UserController@delOrder');

//TODO App个人订单详情页面
Route::get('/apps/order/details', function () {

    return view('app.orderdetail');

});

//TODO app个人评论页面
Route::get('/apps/users/message','App\UserController@message');

//TODO App个人密码页面
Route::get('/apps/password','App\LoginController@userPasswd')->name('password');

Route::get('/apps/epassword','App\LoginController@euserPasswd');

//Route::any('/apps/rebuild', 'App\ProductController@quit')->name('quit');

//TODO App登录页面
Route::get('/apps/login', function () {

    return view('app.login',['logo' =>App\Http\Model\GeneralModel::first(['logo'])->logo]);

})->name('appsLogin');


//TODO App注册页面
Route::get('/apps/register', function () {

    return view('app.register',['logo' =>App\Http\Model\GeneralModel::first(['logo'])->logo]);

})->name('appsRegister');

//TODO pc登录表单
//后台登录处理
Route::post('/appLogin', 'App\LoginController@postLogin');

/*-----------------Web端----------------------------*/
//TODO 首页页面
Route::get('/', 'Web\ProductController@homePage');
//Route::get('/', function () {

//    return redirect('/login');
//    return view('web.index');

//});

//TODO 首页页面
Route::get('/pay/paypal', 'Web\ProductController@payPaypal');

//TODO PC分类页面
Route::get('/categorys','Web\ProductController@showCategory');

//TODO PC公司信息
Route::get('/company/{id}','Web\ProductController@companyinformation');

//Route::get('/company/{id}', function () {
//
//      return view('web.companyinformation');
//
//});

//TODO PC商品详情页面
Route::get('/details/{id?}','Web\ProductController@details');
//Route::get('/details', function () {
//
//    return view('web.details');
//
//});
//pc个人中心
Route::get('/personal','Web\LoginController@personal');

Route::post('/UpdatePersonal','Web\LoginController@UpdatePersonal');

Route::get('/pc/epassword','Web\LoginController@euserPasswd');

//TODO PC分类聚合页面
Route::get('/shop/{id?}','Web\ProductController@CategoryShop');
//TODO PC二级各类聚合页面
Route::get('/categorys/detail/{id?}','Web\ProductController@twoLevel');
//TODO PC搜索结果页面
Route::get('/together','Web\ProductController@productList');
//Route::get('/shop', function () {
//
//    return view('web.product');
//
//});

//TODO PC购物车页面
Route::get('/shop/cart/{id?}','Web\ProductController@shoppingCart');


//TODO PC订单确定页面
Route::get('/order/confirm/{id?}','Web\ProductController@orderConfirm');


//TODO PC注册登录页面
Route::get('/users', function () {

    return view('web.user');

});

//TODO pc登录表单
//后台登录处理
Route::post('/pcLogin', 'Web\LoginController@postLogin');

//TODO pc注册表单
//后台登录处理
Route::post('/pc/register', 'Web\LoginController@Register');

//TODO pc重发邮箱
//后台登录处理
Route::get('/pc/again/email', 'Web\LoginController@againSendEmail');

/*-----------------admin端----------------------------*/

//TODO 后台登录首页
Route::get('/admin', function () {

    return redirect('/login');
});

Auth::routes();

Route::get('/homes', 'HomeController@index')->name('homes');


//图片处理
Route::post('/imgHandle', 'Common@imgHandle');

//TODO 后台登录
//后台登录处理
Route::post('/postLogin', 'Admin\LoginController@postLogin');
//修改admin密码
Route::post('/admin/password', 'Admin\LoginController@adminUpdate');

//TODO 仪表盘
//后台登录处理
Route::get('/dashboard', 'Admin\DashboardController@index');


//TODO 后台系统
Route::group(['middleware' => 'role'], function () {


    //TODO 用户管理页面
    Route::group(['prefix' => '/user'], function () {
        //用户列表页面*
        Route::get('/list/status/{status?}/limit/{limit?}', 'Admin\UserController@userList');
        //管理员列表页面*
        Route::get('/manager/type/{type?}/status/{status?}/limit/{limit?}', 'Admin\UserController@managerList');
        //管理员角色列表页面*
        Route::get('/manager/limit/{limit?}', 'Admin\UserController@managerRole');
//        //添加用户页面
//        Route::get('/insert', 'Admin\UserController@userInsert');
        //用户角色列表页面*
        Route::get('/role/limit/{limit?}', 'Admin\UserController@userRole');
//        //添加用户角色页面
//        Route::get('/append', 'Admin\UserController@userAppend');
    });


    //TODO 内容管理页面
    Route::group(['prefix' => '/content'], function () {
        //页面管理页面*
        Route::get('/list', 'Admin\ContentController@contentList');
        //首页内容页面*
        Route::get('/home/status/{status?}/category/{category?}/brand/{brand?}/limit/{limit?}', 'Admin\ContentController@contentHome');
        //首页横幅页面
        Route::get('/', 'Admin\ContentController@index');
        //首页活动页面
        Route::get('/activite/{status?}', 'Admin\ContentController@contentActivite');
    });


    //TODO 库存管理页面
    Route::group(['prefix' => '/stock'], function () {

        //入库页面
        Route::get('/list/limit/{limit?}', 'Admin\StockController@addLibrary');
        //出库页面
        Route::get('/out/limit/{limit?}', 'Admin\StockController@stockOut');
        //出库页面
        Route::get('/shelves/limit/{limit?}', 'Admin\StockController@stockShelves');
    });

    //TODO 订单管理页面
    Route::group(['prefix' => '/order'], function () {
        //订单列表页面*
        Route::get('/list/status/{status?}/limit/{limit?}', 'Admin\OrderController@orderList');
        //某订单详情页面*
        Route::get('/detail/{id?}', 'Admin\OrderController@orderDetail');
        //运费设置页面*
        Route::get('/freight', 'Admin\OrderController@freight');
        //优惠活动页面
        Route::get('/mail', 'Admin\OrderController@mail');
    });

    //TODO 商品管理页面
    Route::group(['prefix' => '/product'], function () {
//        //分类页面
//        Route::get('/category/{type?}', 'Admin\ProductController@productCategory');
        //分类一级页面
        Route::get('/category/status/{status?}/limit/{limit?}', 'Admin\ProductController@productCategory');
        //分类二级页面
        Route::get('/category/level/{id?}/status/{status?}/limit/{limit?}', 'Admin\ProductController@categoryLevel');
//        //编辑分类页面
//        Route::get('/edit/{id?}', 'Admin\ProductController@productEdit');
        //创建分类页面
//        Route::get('/found', 'Admin\ProductController@productFound');
        //品牌列表页面
        Route::get('/brand/status/{status?}/limit/{limit?}', 'Admin\ProductController@productBrand');
        //编辑品牌页面
        Route::get('/brand/edit/{id?}', 'Admin\ProductController@productBrandEdit');
        //创建品牌页面
        Route::get('/brand/found', 'Admin\ProductController@productBrandFound');
        //商品列表页面
        Route::get('/list/status/{status?}/category/{category?}/brand/{brand?}/limit/{limit?}', 'Admin\ProductController@productList');
        //商品评论页面
        Route::get('/message/status/{status?}/limit/{limit?}', 'Admin\ProductController@productMessage');
        //优惠活动页面
        Route::get('/discount/status/{status?}/limit/{limit?}', 'Admin\ProductController@discount');

    });

    //TODO 网站设置页面
    Route::group(['prefix' => '/set'], function () {
    //通用设置页面
    Route::get('/general', 'Admin\GeneralController@general');
       //邮件设置页面
    Route::get('/mail/{status}', 'Admin\GeneralController@mail');
    //邮递设置页面
    Route::get('/deliver', 'Admin\GeneralController@deliver');
    });


    //TODO 抓货订单页面
    Route::group(['prefix' => '/catch'], function () {
        Route::get('/list', 'Admin\CatchController@catchList');

//        Route::get('/show', 'Admin\CatchController@payShow');
        Route::get('/show', 'api\AuthorizeController@authorizeToken');
    });

    //TODO 商家订单管理页面
    Route::group(['prefix' => '/business'], function () {
        //订单列表页面*
        Route::get('/list/status/{status?}/limit/{limit?}', 'Admin\BusinessController@businessList');
        //某订单详情页面*
        Route::get('/detail/{id?}', 'Admin\BusinessController@orderDetail');
        //删除接口
        Route::get('/order/del', 'Admin\BusinessController@orderDel');
//        Route::get('/show', 'Admin\CatchController@payShow');
        Route::get('/show', 'api\AuthorizeController@authorizeToken');
    });
});


//TODO 管理员管理接口
////修改管理员基本信息
//Route::post('/manager/modify', 'Admin\ManagerController@managerModify');
////添加管理员
//Route::post('/manager/insert', 'Admin\ManagerController@managerInsert');
//搜索管理员
Route::get('/manager/search', 'Admin\ManagerController@managerSearch');


//TODO 用户管理接口
//获取用户地址信息接口*
Route::get('/user/address', 'Admin\UserController@addressList');
//获取用户订单接口*
Route::get('/user/order', 'Admin\UserController@orderList');

//创建用户接口*
Route::post('/user/add', 'Admin\UserController@userAdd');
//修改用户接口*
Route::post('/user/update', 'Admin\UserController@userUpdate');
//删除用户接口*
Route::get('/user/del', 'Admin\UserController@userDel');

//获取用户角色接口*
Route::get('/role', 'Admin\UserController@role');
//修改用户角色接口*
Route::post('/user/role/update', 'Admin\UserController@userRoleUpdate');
//添加用户角色接口*
Route::post('/user/append', 'Admin\UserController@userRoleAppend');
//删除用户角色接口*
Route::get('/user/role/del', 'Admin\UserController@userRoleDel');

//修改管理员基本信息接口*
Route::post('/manager/modify', 'Admin\UserController@managerModify');
//添加管理员接口*
Route::post('/manager/insert', 'Admin\UserController@managerInsert');
//删除管理员接口*
Route::get('/manager/del', 'Admin\UserController@managerDel');
//添加管理员角色接口*
Route::post('/manager/add', 'Admin\UserController@managerAdd');
//删除管理员角色接口*
Route::get('/manager/role/del', 'Admin\UserController@managerRoleDel');
//修改管理员角色接口*
Route::post('/manager/role/update', 'Admin\UserController@managerRoleUpdate');
//获取管理员角色接口*
Route::get('/Administrators', 'Admin\UserController@Administrators');

//搜索用户信息
Route::get('/search', 'Admin\MyController@search');

//TODO 内容管理接口
//删除banner接口*
Route::get('/content/del', 'Admin\ContentController@sowDel');
//添加banner URL接口*
Route::get('/content/url', 'Admin\ContentController@contentUrl');
//添加文章接口*
Route::post('/content/add', 'Admin\ContentController@contentAdd');
//删除文章接口*
Route::get('/article/del', 'Admin\ContentController@articleDel');
//获取文章接口*
Route::get('/article/modify', 'Admin\ContentController@articleModify');
//修改文章接口*
Route::post('/article/editor', 'Admin\ContentController@articleEditor');
//添加活动接口*
Route::post('/article/add', 'Admin\ContentController@articleAdd');
//修改活动接口*
Route::post('/activity/modify', 'Admin\ContentController@activityEditor');
//删除活动接口*
Route::get('/activity/del', 'Admin\ContentController@activityDel');
//添加商品活动接口*
Route::post('/product/article/add', 'Admin\ContentController@productArticleAdd');
//获取各活动下商品接口
Route::get('/see/activie', 'Admin\ContentController@seeActivie');
//上传热销商品接口
Route::post('/hot/imgHandle', 'Admin\ContentController@hotImgHandle');
//上传热销商品地址接口
Route::get('/hot/url', 'Admin\ContentController@hotUrl');
//TODO 网站设置接口
//保存通用设置接口
Route::post('/general/editor', 'Admin\GeneralController@generalEditor');
//邮件内容修改接口
Route::post('/general/mail/modify', 'Admin\GeneralController@generalMailModify');

//TODO 订单管理接口
//保存邮费设置接口
Route::post('/order/freight', 'Admin\OrderController@orderFreight');
//删除接口
Route::get('/order/del', 'Admin\OrderController@orderDel');
//创建订单接口
Route::post('/order/add', 'Admin\OrderController@placeOrder');
//创建商家订单接口
Route::post('/business/order/add', 'Admin\BusinessController@placeOrder');

//TODO 商品管理接口
//修改分类接口*
Route::post('/category/editor', 'Admin\ProductController@categoryEditor');
//创建一级分类接口*
Route::post('/category/insert', 'Admin\ProductController@categoryInsert');
//删除分类接口*
Route::get('/category/del', 'Admin\ProductController@categoryDel');
//创建二级分类接口*
Route::post('/category/level/insert', 'Admin\ProductController@categoryLevelInsert');
//修改二级分类接口*
Route::post('/category/level/editor', 'Admin\ProductController@categoryLevelEditor');
//修改二级分类顺序接口*
Route::get('/score/category', 'Admin\ProductController@scoreCategory');


//修改品牌接口*
Route::post('/brand/editor', 'Admin\ProductController@brandEditor');
//创建品牌接口*
Route::post('/brand/insert', 'Admin\ProductController@brandInsert');
//删除品牌接口*
Route::get('/brand/del', 'Admin\ProductController@brandDel');

//获取用户全部留言
Route::post('/search/history', 'Admin\ProductController@replyList');
//回复接口
Route::post('/reply/message', 'Admin\ProductController@replyMessage');
//获取评论未留言接口
Route::get('/unread', 'Admin\ProductController@unread');
//删除留言接口
Route::get('/message/del', 'Admin\ProductController@messageDel');

//创建商品接口*
Route::post('/product/establish', 'Admin\ProductController@productEstablish');
//上架商品接口*
Route::get('/product/up', 'Admin\ProductController@productUp');
//下架商品接口*
Route::get('/product/down', 'Admin\ProductController@productDown');
//删除商品接口*
Route::get('/product/del', 'Admin\ProductController@productDel');
//获取某商品接口*
Route::get('/modify', 'Admin\ProductController@productModify');
//修改商品信息接口*
Route::post('/product/revise', 'Admin\ProductController@productRevise');



//查看折扣码接口
Route::get('/discount/see', 'Admin\ProductController@discountSee');
//创建折扣码接口
Route::post('/discount/insert', 'Admin\ProductController@discountInsert');
//修改折扣码接口
Route::post('/discount/editor', 'Admin\ProductController@discountEditor');
//删除折扣码接口
Route::get('/discount/del', 'Admin\ProductController@discountDel');

//TODO 库存管理接口
//修改商品添加库存信息接口*
Route::post('/stock/product', 'Admin\StockController@productStock');
//修改商品减少库存信息接口*
Route::post('/stock/product/sub', 'Admin\StockController@productStockSub');
//搜索商品库存接口*
Route::get('/stock/search', 'Admin\StockController@searchStock');
//修改商品货架接口*
Route::post('/edit/shelves', 'Admin\StockController@editShelves');

//TODO 抓货打包接口
//随机获取订单接口*
Route::get('/catch/order', 'Admin\CatchController@catchOrder');
//订单完成或异常接口*
Route::post('/catch/status', 'Admin\CatchController@catchStatus');
//关闭或者刷新订单接口*
Route::get('/catch/reduction', 'Admin\CatchController@catchReduction');

////搜索案例信息
//Route::get('/search/case', 'Admin\MyController@searchCase');
//
////获取某速配案例信息
//Route::get('/editor/{id}', 'Admin\MyController@editorCase');
//
////获取智库专家某案例信息
//Route::get('/editor/expert/{id}', 'Admin\MyController@expert');
//
//
//
////保存速配案例案例
//Route::post('/modify', 'Admin\MyController@caseModify');
//
////保存专家信息
//Route::post('/expert/modify', 'Admin\MyController@expertModify');
//
////获取某专家案例列表
//Route::get('/expert', 'Admin\MyController@expertList');
//
////新建案例
//Route::post('/case/insert', 'Admin\MyController@insertCase');
//
////新建专家
//Route::post('/expert/insert', 'Admin\MyController@insertexpert');
//
////获取全部专家
//Route::get('/expert/name', 'Admin\MyController@getExpertAll');
//
////TODO 活动管理
////搜索日历活动
//Route::get('/search/calendar', 'Admin\MyController@searchCalendar');
//
////获取某日历活动信息
//Route::get('/calendar/{id}', 'Admin\MyController@getCalendar');
//
////修改日历活动
//Route::post('/calendar/modify', 'Admin\MyController@modifyCalendar');
//
////新建日历活动
//Route::post('/calendar/insert', 'Admin\MyController@insertCalendar');
//
////活动报名情况
//Route::get('/details', 'Admin\MyController@calendarDetails');
//
////TODO 互动管理
//
////搜索福利或增值服务
//Route::get('/welfare/search', 'Admin\MyController@searchWelfare');
//
////获取福利或增值服务页面
//Route::get('/welfare/editor/{id}', 'Admin\MyController@editorWelfare');
//
//
////TODO 留言管理
//
////获取用户全部留言
//Route::post('/search/history', 'Admin\MyController@replyList');
//
////获取用户留言
//Route::post('/user/message', 'Admin\MyController@getUserMessage');
//
////获取用户留言列表
//Route::get('/search/message', 'Admin\MyController@searchMessage');
//

//
////获取留言未读条数
//Route::get('/unread', 'Admin\MyController@unread');


//没有权限页面
Route::get('error', 'Admin\MyController@error');

//404页面
Route::get('/404', 'Admin\MyController@notFound');
