<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>


    <!-- Add to /homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Add to /homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="apple-touch-icon-precomposed" href="{{ asset('/home/assets/i/app-icon72x72@2x.png') }}">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="{{ asset('/home/assets/i/app-icon72x72@2x.png') }}">
    <meta name="msapplication-TileColor" content="#0e90d2">

    <link rel="shortcut icon" href="/uploads/snack.ico">

    <title>Snack Talk</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('/home/css/zzsc.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/assets/css/amazeui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/category.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/details.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/shoppingcart.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/orderaffirm.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/personal.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/settlement.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/shoppingcart.css') }}">
    <link rel="stylesheet" href="{{ asset('/home/css/user.css') }}">
    <link href="{{ asset('lib/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('lib/css/sweetalert.css') }}">

    <script type="text/javascript" src="{{ asset('/home/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('lib/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/home/js/leftTime.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/home/js/index.js') }}"></script>
    <script src="{{ asset('/home/assets/js/amazeui.min.js') }}"></script>
    <script type="text/javascript" class="library" src="{{ asset('/home/js/jquery.colorbox-min.js') }}"></script>
    <script type="text/javascript" class="library" src="{{ asset('/home/js/zzsc.js') }}"></script>
    <script src="{{ asset('/home/js/personal.js') }}"></script>
    <script src="{{ asset('/lib/js/sweetalert.min.js') }}"></script>
</head>
<script type="text/javascript">

    if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
        window.location.href = "/apps";
    }
//    $.get('/api/home/login', {}, function (res) {
//        if (res.status) {
//            $('.logo').attr('src', "/" + res.data.logo);
//
//        }
//    })

    //设置语言
    var Language = function (one, tow) {
        document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? one : tow);
    }
    var LanguageHtml = function (one, tow) {
        return window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? one : tow;
    }

    var Sprice = function (role1, role2, role3, role4) {

        var haha;
        @if(!empty(Auth::guard("pc")->user()->role))
            switch ({{Auth::guard("pc")->user()->role}}) {
            case 1 :
                haha = `<div class='Price'>$${role1}</div>`;
                break;
            case 2 :
                haha = `<div class='Price'>$${role2}</div>`;
                break;
            case 3 :
                haha = `<div class='Price'>$${role3}</div>`;
                break;
            default :
                haha = `<div class='Price'>$${role4}</div>`;
        }
        document.write(haha);
        @endif

    }
    var Spricedetails = function (role1, role2, role3, role4) {

        var haha;
        @if(!empty(Auth::guard("pc")->user()->role))
            switch ({{Auth::guard("pc")->user()->role}}) {
            case 1 :
                haha = `$${role1}`;
                break;
            case 2 :
                haha = `$${role2}`;
                break;
            case 3 :
                haha = `$${role3}`;
                break;
            default :
                haha = `$${role4}`;
        }
        document.write(haha);
        @endif

    }


    var Sprice1 = function (role1, role2, role3, role4) {

        var haha;
        @if(!empty(Auth::guard("pc")->user()->role))
            switch ({{Auth::guard("pc")->user()->role}}) {
            case 1 :
                haha = role1;
                break;
            case 2 :
                haha = role2;
                break;
            case 3 :
                haha = role3;
                break;
            default :
                haha = role4;
        }
        return haha;
        @endif
    }
</script>
<body>
<div class="topBg">
    <div class="maxCentr topBox clearfloat">
        <div class=" topLanguage float_left" id="LanguageToggle">

            <script>
                Language("English", "Chinese")
            </script>
        </div>

        <ul class="topNav float_right">
            <li class="float_left"><a href="/categorys">
                    <p>
                        <script>
                            Language("所有分类", "All Categories")
                        </script>
                    </p>
                </a></li>
            @if (!empty(Auth::guard("pc")->user()->name))
                <li class="float_left">
                    <a href="/personal"><p class="float_left"> Hi，{{Auth::guard("pc")->user()->name}}</p></a>
                    <a class="exit float_left" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <p>
                            <script>
                                Language("&nbsp;退出", "&nbsp;Exit")
                            </script>
                        </p>
                    </a>

                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <li class="float_left"><a href="/users">
                        <p>
                            <script>
                                Language("注册/登录", "Registered/Log In")
                            </script>
                        </p>
                    </a></li>
            @endif
            <!--<li class="navIcon float_left"><a href="##">
                    <p class="navIcon1">
                        <script>
                            Language("消息通知", "Notification")
                        </script>
                    </p>
                </a></li>-->
            @if (!empty(Auth::guard("pc")->user()->id))
                <li class=" navIcon float_left"><a href="/shop/cart/{{Auth::guard('pc')->user()->id}}"
                                                   onclick="shopping();">
                        <p class="navIcon2">
                            <script>
                                Language("购物车 ", "Shopping Cart")
                            </script>
                        </p>
                    </a></li>
            @else
                <li class=" navIcon float_left"><a href="/shop/cart/-1" onclick="shopping();">
                        <p class="navIcon2">
                            <script>
                                Language("购物车 ", "Shopping cart")
                            </script>
                        </p>
                    </a></li>
            @endif
        </ul>
    </div>
</div>

<div class="logoBox clearfloat maxCentr	">
    <div class="logo float_left">
        <a href="/"><img class="logo" src="/uploads/snackicon.png" alt=""/></a>
    </div>
    <form action="/together" method="get">
        <div class="search float_right">

            <script>
                Language(` <input name="search"  type="text" class="" placeholder="搜索">`,
                    ` <input name="search"  type="text" class="" placeholder="search">`)
            </script>
            <button class=" " type="submit"><img src="/home/img/se.png" alt=""/></button>
        </div>
    </form>
</div>

@yield("content")

<div class="mailBg">
    <div class="maxCentr">
        <div class="mail_box">
            <div class="am-u-sm-5">
                <div class="am-input-group mail_but">

                    <script>
                        Language(`<input type="text" class="am-form-field" placeholder="邮箱">`,
                            `<input type="text" class="am-form-field" placeholder="Email">`)
                    </script>
                    <span class="am-input-group-btn">
					        <button class="am-btn am-btn-default" type="button">
            <script>
            	Language("订阅", "Subscribe")
            </script></button>
					      </span>
                </div>
            </div>
            <div class="am-u-sm-7 clearfloat">
                <div class="mail_pro">&nbsp;</div>
                <div class="mail_pro">
                    <ul class="am-avg-sm-4 am-thumbnails">
                        <li><img class="am-thumbnail" src="/home/img/ico (1).png"/></li>
                        <li><img class="am-thumbnail" src="/home/img/ico (2).png"/></li>
                        <li><img class="am-thumbnail" src="/home/img/ico (3).png"/></li>
                        <li><img class="am-thumbnail" src="/home/img/ico (4).png"/></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottonBg">
    <div class="maxCentr clearfloat">

        <script>
            Language(`
        <div class="am-u-sm-2">
            <ul class="bot_nav">
                <li>关于我们</li>
                <li class="btoNavPro" data-router="/company/14">关于我们</li>
                <li class="btoNavPro" data-router="/company/5">联系我们</li>
            </ul>
            <ul class="bot_nav">
                <li>使用条款</li>
                <li class="btoNavPro" data-router="/company/7">隐私政策</li>
                <li class="btoNavPro" data-router="/company/8">使用条款</li>
            </ul>
        </div>
        <div class="am-u-sm-2">
            <ul class=" bot_nav">
                <li>客户服务</li>
                <li class="btoNavPro" data-router="/company/9">常见问题</li>
                <li class="btoNavPro" data-router="/company/10">付款方式</li>
                <li class="btoNavPro" data-router="/company/12">退货换货</li>
            </ul>
        </div>
        <div class="am-u-sm-4">
            <ul>
                <li class="btoNavPro" data-router="/company/1">联系我们</li>
                <li>给我们电话<br/> <span>650-690-6666</span></li>
                <li>info@snacktalk.com</li>
            </ul>
        </div>`,
                `
        <div class="am-u-sm-2">
            <ul class="bot_nav">
                <li>About us</li>
                <li  class="btoNavPro" data-router="/company/6">About us</li>
                <li class="btoNavPro" data-router="/company/5">Contact us</li>
            </ul>
            <ul class="bot_nav">
                <li>Terms of Use</li>
                <li class="btoNavPro" data-router="/company/7">Privacy Policy</li>
                <li class="btoNavPro" data-router="/company/8">Terms of use</li>
            </ul>
        </div>
        <div class="am-u-sm-2">
            <ul class=" bot_nav">
                <li>Customer Service</li>
                <li class="btoNavPro" data-router="/company/9">FAQs</li>
                <li class="btoNavPro" data-router="/company/10">Payment Method</li>
                <li class="btoNavPro" data-router="/company/12">Returns & Exchanges</li>
            </ul>
        </div>
        <div class="am-u-sm-4">
            <ul>
                <li>Contact us</li>
                <li>Call us<br/> <span>650-690-6666</span></li>
                <li>info@snacktalk.com</li>
            </ul>
        </div>`)
        </script>
    </div>
</div>
</body>
<script>
    var check = function () {

        var id = {{ !empty(Auth::guard("pc")->user()) ? Auth::guard("pc")->user()->id : '-1'}};

        if (id == -1) {
            swal({
                title: LanguageHtml("请先登录", "Please Log In"),
                type: 'warning',
                showConfirmButton: true,
            })
            return -1;
        }
        return 1;
    }
    var shopping = function () {

//        if (check() == -1) {
//            return;
//        }
        if (check() != 1) {
            return;
        }
        window.location.href = "/shop/cart/" + id;

    }

    var shop = localStorage.getItem('myCart') ? JSON.parse(localStorage.getItem("myCart")) : [],
        data = {};
    $(document).ready(function () {
        $(".shopAdd").click(function () {
            if ($(this).attr('datas-tock') <= 0) {
                swal({
                    title: LanguageHtml("商品库存不足", "Sold out"),
                    type: 'info',
                    showConfirmButton: true,
                })
                return false;
            }

            if (check() == -1) {
                return false;
            }

            //判断空对象  [{"count":2, "product_id":1},{"count":2, "product_id":2}]
            if ($.isEmptyObject(shop)) {
                //空对象
                data = {
                    'count': $(this).attr('data-number'),
                    'product_id': $(this).attr('data-id'),
                    'zn_name': $(this).attr('data-zn-name'),
                    'en_name': $(this).attr('data-en-name'),
                    'price': $(this).attr('data-price'),
                    'img': $(this).attr('data-img')
                };
                shop.push(data);
            } else {
                for (var item in shop) {
                    var status = -1;
                    //判断是否有相同的
                    if (shop[item].product_id == $(this).attr('data-id')) {
                        status = item;
                        break;
                    }
                }

                if (status != -1) {
                    //有重复
                    shop[item].count=shop[item].count*1+$(this).attr('data-number')*1;
                } else {
                    data = {
                        'count': $(this).attr('data-number'),
                        'product_id': $(this).attr('data-id'),
                        'zn_name': $(this).attr('data-zn-name'),
                        'en_name': $(this).attr('data-en-name'),
                        'price': $(this).attr('data-price'),
                        'img': $(this).attr('data-img')
                    };
                    shop.push(data);
                }

            }
            localStorage.setItem("myCart", JSON.stringify(shop));
//          alert("商品已添加");
            swal({
                title: LanguageHtml("商品已添加", "Item(s) Added"),
                type: 'success',
                showConfirmButton: true,
            })
            return false;
        });
    });

    //  	设置中英文切换
    $("#LanguageToggle").click(function () {
        if (window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1) {
            window.localStorage.setItem("lang", 2);
            location.reload()
        } else {
            window.localStorage.setItem("lang", 1);
            location.reload()
        }
    })
    //跳转地址
    $(".DrinksPro,.secondBannerPro,.btoNavPro,.snacksPro,.categoryHotPro ,.categoryTitle,.DrinksTitle p,.DrinksMore p,.classify li,#buttonpay").css("cursor", "pointer")
    $(".DrinksPro,.secondBannerPro,.btoNavPro,.snacksPro,.categoryHotPro,.categoryTitle,.DrinksTitle p,.DrinksMore p,.classify li,#buttonpay").click(function () {
        var Router = $(this).attr("data-router");
        window.location.href = Router;
    })
    $(".Drinks .am-u-sm-3:last-child").addClass("am-u-end")
</script>

</html>
