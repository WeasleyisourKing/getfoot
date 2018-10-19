<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2018/1/25
 * Time: 15:12
 */

return [


    //图片地址前缀
    'user_url' => 'user.user.jpg',

    //用户默认图片地址

    'img_url' => 'https://12buy.com',
//    'img_url' => 'http://shop.buy.com/',
    //上传文件目录
    'file_path' => public_path() . '/uploads',

    //token前缀
    'token_prefix' => 'Hjl456dwGFfgKD?Gs3',

    //邮箱注册过期时间
    'email_time' => 86400,

    //palpay支付商户号
    'palpay_business' => 'account@12buy.com',

    //citcon YES : 线上 | NO : 沙盒
    'citcon_status' => 'NO',

    //支付宝支付URL 沙盒
    'citcon_alipay_sandbox_url' => 'https://dev.citconpay.com/payment/pay?amount=%s&currency=USD&vendor=%s&reference=%s&ipn_url=%s&callback_url=%s&allow_duplicates=yes',

    //支付宝支付URL 线上
    'citcon_alipay_accept_url' => 'https://citconpay.com/payment/pay?amount=%s&currency=USD&vendor=%s&reference=%s&ipn_url=%s&callback_url=%s&allow_duplicates=yes',

    //微信支付URL 沙盒
    'citcon_wxpay_sandbox_url' => 'https://dev.citconpay.com/payment/pay_qr?amount=%s&currency=USD&vendor=%s&reference=%s&ipn_url=%s&callback_url=%s&allow_duplicates=yes',

    //微信支付URL 线上
    'citcon_wxpay_accept_url' => 'https://citconpay.com/payment/pay_qr?amount=%s&currency=USD&vendor=%s&reference=%s&ipn_url=%s&callback_url=%s&allow_duplicates=yes',

    //citon 令牌
    'citon_token' => '540C7CADF0624930B04E23E2D279B858',

    //Authorize api login id
    'Authorize_login_id' => '8D5f4CYqjg',

    //Authorize key
    'Authorize_key' => '7K45Z69F2M8wjvQB',

//    //Authorize api login id test
//    'Authorize_login_id' => '2Xr2n53qqEY',
//
//    //Authorize key test
//    'Authorize_key' => '76k5ux6dn88KHNsw',

    //支付宝或者微信回调
    'callback_url' => '/api/citon/callback',

    //authorize YES : 线上 | NO : 沙盒
    'authorize_status' => 'YES',

    //authorize 沙盒
    'authorize_sandbox_url' => 'https://test.authorize.net/payment/payment',

    //authorize 线上
    'authorize_accept_url' => 'https://accept.authorize.net/payment/payment',

    'send_eamil' => 'orders@12buy.com',

    //税金地址
    'tax_url' => 'https://api.zip-tax.com/request/v40?key=%s&postalcode=%s&city=%s',

    //税金key
    'tax_key' => '9xQ6b4ORtV5IXdGi',
    //目录分隔符
    'DIRECTORY_SEPARATOR' => '/'
];