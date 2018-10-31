<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">


    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>


    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="apple-touch-icon-precomposed" href="{{ asset('home/assets/i/app-icon72x72@2x.png') }}">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="assets/i/app-icon72x72@2x.png">
    <meta name="msapplication-TileColor" content="#0e90d2">

    <link rel="stylesheet" href="{{ asset('home/assets/css/amazeui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/user.css') }}">
    <script type="text/javascript" src="{{ asset('home/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('home/js/user.js') }}"></script>
    <script src="{{ asset('lib/js/check.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/lib/js/sweetalert.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('lib/css/sweetalert.css') }}">
</head>
<body>
<script type="text/javascript">
	
//设置语言
 var Language=function(one, tow){
 	 document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? one : tow); 
  }
var LanguageHtml=function(one, tow){
 	return window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? one :  tow ;
 }
</script>

<div class="topBg">
    <div class="maxCentr topBox">
        <div class="clearfloat topLanguage">
            <!--<img class="float_left" src="home/img/ENGLISH.png"/>
            <p class="float_left">English</p>-->
        </div>
    </div>
</div>

<div class="userBg">
    <div class="maxCentr clearfloat">
        <div class="indexLogo float_left">
            <img src="home/img/IndexLogo.png" alt=""/>
            <a href="/">
            	<img class="businessLogo" src="/uploads/snackicon.png" alt="" />
            </a>
        </div>
        <!--右侧登录&注册组件-->
        <div class="user float_left">
            <div class=" clearfloat userTop">
                <div class="float_left pointer"style="width: 100%;">
                    <script>
                        Language("用户登录","User Log In")
                    </script>
                </div>
                <!--<div class="float_left pointer">
                    <script>
                        Language("注册","Register")
                    </script>
                </div>-->
            </div>
            <!--用户登录输入框-->
            <div class="signIn UserTog" >
                <form action="/pcLogin" class="am-form" id="form-with-tooltip" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <fieldset>
                        <div class="am-form-group clearfloat">
                            <div class="float_left">
                                <img src="home/img/reg2.png" alt=""/>
                            </div>
                            <script>
                                Language(`<input class="float_left" type="email" name="email" id="doc-vld-email-2-1"
                                   data-validation-message="自定义提示信息：输入地球上的电子邮箱" placeholder="请输入邮箱" required/>`,
                                   `<input class="float_left" type="email" name="email" id="doc-vld-email-2-1"
                                   data-validation-message="Custom prompt message: enter E-mail address on earth" placeholder="Enter Email " required/>`)
                            </script>
                        </div>
                        <div class="am-form-group clearfloat">
                            <div class="float_left">
                                <img src="home/img/reg3.png" alt=""/>
                            </div>
                            <script>
                                Language(`<input class="float_left" type="password" name="password" id="doc-vld-pwd-1-0"
                                   placeholder="请输入密码" required/>`,`<input class="float_left" type="password" name="password" id="doc-vld-pwd-1-0"
                                   placeholder="Enter Password" required/>`)
                            </script>
                        </div>
                        <div class="form-group " style="text-align: center;">
                            @if (session('msg'))
                                <span class="help-block">
                                <strong style="color: #4982a3;">{{session('msg')}}</strong>
                                </span>
                            @endif

                        </div>
                        @if (session('email'))
                            <div class="form-group " style="text-align: center;">
                                <span class="help-block">
                                    <strong data-data="{{session('email')}}" id="onEmail" style="cursor:pointer;color: #fdb3d3;"> 
                                        <script>
                                            Language("邮件未激活，点击重新发送邮件"," Email not verified, CLICK to resend Email")
                                        </script>
                                    </strong>
                                </span>
                            </div>
                        @endif
                        <button class="am-btn am-btn-secondary" type="submit">
                            <script>
                                Language("用户登录","User Log In")
                            </script>
                        </button>
                        <div class="sigInBot clearfloat">
                            <div class="float_left pointer"id="showInitial">
                                <script>
                                    Language("忘记密码","Forgot Password")
                                </script>
                            </div>
                            <!--<div class="float_right pointer">
                                <script>
                                    Language("点我注册","Register")
                                </script>    
                            </div>-->
                        </div>
                    </fieldset>
                </form>

            </div>
			<!--用户注册输入框-->
            <!--<div class="register UserTog" style="display: none;">
                {{--<form action="" class="am-form" id="form-with-tooltip">--}}
                <fieldset>
                    <div class="am-form-group clearfloat">
                        <div class="float_left">
                            <img src="home/img/reg1.png" alt=""/>
                        </div>
                        <script>
                            Language(`<input class="float_left" type="text" id="name" minlength="1"
                               placeholder="请输入昵称" required/>`,`<input class="float_left" type="text" id="name" minlength="1"
                               placeholder="Enter Nickname" required/>`)
                        </script>  
                    </div>
                    <div class="am-form-group clearfloat">
                        <div class="float_left">
                            <img src="home/img/reg2.png" alt=""/>
                        </div>
                        <script>
                            Language(`<input class="float_left" type="email" id="email"data-validation-message="自定义提示信息：输入地球上的电子邮箱" placeholder="请输入邮箱" required/>`,
                            `<input class="float_left" type="email" id="email" data-validation-message="Custom prompt message: enter E-mail address on earth" placeholder="Enter Email" required/>`)
                        </script> 
                    </div>

                    <div class="am-form-group clearfloat">
                        <div class="float_left">
                            <img src="home/img/reg3.png" alt=""/>
                        </div>
                        <script>
                            Language(`<input class="float_left" type="password" id="password" placeholder="请输入密码"
                               required/>`,`<input class="float_left" type="password" id="password" placeholder="Enter Password "
                               required/>`)
                        </script> 
                    </div>
                    <div class="am-form-group clearfloat">
                        <div class="float_left">
                            <img src="home/img/reg3.png" alt=""/>
                        </div>
                        <script>
                            Language(`<input class="float_left" type="password" id="password1" placeholder="请再次输入您的密码"
                               data-equal-to="#doc-vld-pwd-1" required/>`,`<input class="float_left" type="password" id="password1" placeholder="Please Re-enter Password"
                               data-equal-to="#doc-vld-pwd-1" required/>`)
                        </script> 
                    </div>

                    <label class="am-checkbox-inline">
                        <input type="checkbox" value="" checked="checked" id="checkbox" name="docVlCb"/>
                        <script>
                            Language("同意接收促销和优惠","Terms of Use & Subscribe for Promotion Emails")
                        </script>
                    </label>
                    <br/>
                    <button class="am-btn am-btn-secondary" id="sa-save">
                        <script>
                            Language("用户注册","Registration")
                        </script>
                    </button>
                    <div class="toggleSingIn pointer">
                        <script>
                            Language("已有账号？立即登入","Already Have An Account? Log In")
                        </script>
                    </div>
                </fieldset>
                {{--</form>--}}
            </div>-->
        </div>
        <!--登录&注册end-->
        
        <!--忘记密码-->
        <div class="user float_left initialCipher" style="display: none;">
        		<div class="initialCipherTop">
        			<div class="box">
                        <script>
                            Language("重置密码","Reset Password")
                        </script>
                    </div>
        		</div>
        		<!--输入框&按钮-->
        		<div class="initialCipherInput register">
                <fieldset>
        			 <div class="am-form-group clearfloat">
                        <script>
                            Language(`<input class="float_left m-0 px-1 py-1" type="email" 
                               data-validation-message="请输入地球上的电子邮箱" placeholder="请输入邮箱" id="sendemail" required style="width: 100%;"/>`,
                               `<input class="float_left m-0 px-1 py-1" type="email" 
                               data-validation-message="Please enter your E-mail address on earth" placeholder="Enter Email" id="sendemail" required style="width: 100%;"/>`)
                        </script>
                    </div>

                    <div class="am-form-group clearfloat border-0">
                        <script>
                            Language(`<input class="float_left m-0 py-1 px-1 border-1" type="input" id="code"  placeholder="请输入验证码"required style="width: 55%; margin-right: 5% !important;"/>`,
                               `<input class="float_left m-0 py-1 px-1 border-1" type="input" id="code"  placeholder="Please enter the verification code"required style="width: 55%; margin-right: 5% !important;"/>`)
                        </script>
                        
                        <div class="float_left" style="width: 40%;">
                    		<button class="am-btn am-btn-secondary initialCipherBnt" onclick="send();" >
                                <script>
                                    Language("发送验证码","Send verification code")
                                </script>
                            </button>
                        </div>
                    </div>
                    <button class="am-btn am-btn-secondary" onclick="repasswd();">
                        <script>
                            Language("重置密码","Reset Password ")
                        </script>
                    </button>
                    <div class="toggleSingIn pointer"id="showLogin">
                        <script>
                            Language("马上登录","Log In ")
                        </script>
                    </div>
                </fieldset>
        		</div>
        </div>
        <!--忘记密码end-->
    </div>
</div>

<div class="bottonBg">
    <div class="maxCentr clearfloat">

        <script>
            Language(`
        <div class="am-u-sm-2">
            <ul class="bot_nav">
                <li>关于我们</li>
                <li class="btoNavPro" data-router="/company/6">关于我们</li>
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

 	//跳转地址
	$(".DrinksPro,.secondBannerPro,.btoNavPro,.snacksPro,.categoryHotPro").css("cursor","pointer")
	$(".DrinksPro,.secondBannerPro,.btoNavPro,.snacksPro,.categoryHotPro").click(function(){
		var Router=$(this).attr("data-router");
		window.location.href = Router;
	})
    //点击添加
    $('#sa-save').click(function () {


        if (!$("#checkbox").get(0).checked) {
            swal({
                title:"请同意条款",
                type: 'info',
                showConfirmButton: true,

            })
//          alert('请同意条款');
            return;
        }
        var password = $('#password').val(),
            password1 = $('#password1').val();

        if (String(password1) != String(password)) {
//          alert('2次密码输入不一致');
            swal({
                title:"2次密码输入不一致",
                type: 'info',
                showConfirmButton: true,

            })
            return;
        }
        //验证密码参数
        res = check({'password': password});
        if (!res.status) {
//          alert('密码中必须包含字母、数字、特称字符，至少8个字符');
            swal({
                title:'密码中必须包含字母、数字、特称字符，至少8个字符',
                type: 'info',
                showConfirmButton: true,

            })
            return;
        }
        var datas = {
//            'img_id': window.imgId,
            'name': $('#name').val(),
            'sex': 1,
            'email': $('#email').val(),
            'password': password,
//            'role': $('#role').val(),
//            'integral': $('#integral').val(),
            '_token': '{{csrf_token()}}'
        };

        $.post('/pc/register', datas, function (res) {
            if (res.status) {
//              alert('创建用户成功，请点击邮箱激活');
	            swal({
	                title:'创建用户成功，请点击邮箱激活',
	                type: 'success',
	                showConfirmButton: true,
	
	            })
                $('#name').val('');
                $('#email').val('');

                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
//              alert(res.message);
	            swal({
	                title:res.message,
	                type: 'warning',
	                showConfirmButton: true,
	
	            })
            }
        })

    })
</script>


<script>
    $('#onEmail').click(function () {

        $.get('/pc/again/email', {'email':$(this).attr('data-data')}, function (res) {
            if (res.status) {
//              alert('请点击邮箱激活');
	            swal({
	                title:'请点击邮箱激活',
	                type: 'info',
	                showConfirmButton: true,
	
	            })
            } else {
                alert(res.message);
            }
        })
    })
//
//			        //获取商家logo
//			          $.ajax({
//								url:'/api/home/login',
//								method: 'get',
//								success: function(logo){      
//									$('.businessLogo').attr('src',"/"+logo.data.logo);
//
//								}
//							});
</script>

<script>

    var send = function (){

        var email = $('#sendemail').val();
        $.get('/apps/repasswd', { 'email':email}, function (res) {
            if (res.status) {
                swal({
                    title: '发送邮件成功，请查看验证码',
                    type: 'success',
                    showConfirmButton: true,
                })

            } else {
                swal({
                    title: res.message,
                    type: 'info',
                    showConfirmButton: true,
                })
            }
        })

    }

    var repasswd = function (){
        var email = $('#sendemail').val();
        var code = $('#code').val();
        $.ajax({
            url:"/apps/code",
            method:'get',
            data:{email:email,code:code},
            success:function(res){

                if (res.status) {
                    swal({
                        title: res.data,
                        type: 'success',
                        showConfirmButton: true,
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    swal({
                        title: res.message,
                        type: 'info',
                        showConfirmButton: true,
                    })
                }
            },
            error: function () {
                swal({
                    title: '请求失败',
                    type: 'info',
                    showConfirmButton: true,

                })

            }

        })
    }
</script>
</html>
