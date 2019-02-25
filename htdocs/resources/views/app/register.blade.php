@extends('/app/layouts.app')

@section('content')

<div class="top-fix"></div>

<div class="container">
	<div class="container amount-input py-2 fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="javascript:history.back(-1);" class="top-nav-item"><i class="fa fa-angle-left"></i></a>

			<!--<a href="" class="top-nav-item"><i class="fa fa-share-alt"></i></a>-->
		</div>
	</div>
	<div class="d-flex flex-column px-5 pt-2 mt-5">

		<!-- logo -->
		<div class="d-flex justify-content-center pb-4">
			<img class="w-50 h-50" src="/uploads/snackicon.png" alt="logo">
		</div><!-- logo -->

		<!-- 昵称 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-user text-mute"></i></span>
				</div>
					<script>
                		Language(`<input id="name" type="text" class="form-control border-0" placeholder="请输入昵称" aria-label="" aria-describedby="">`,
                			`<input id="name" type="text" class="form-control border-0" placeholder="Enter Nickname" aria-label="" aria-describedby="">`)
                		</script>
				
			</div>
		</div><!-- 昵称 -->

		<!-- 邮箱 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-envelope text-mute"></i></span>
				</div>
					<script>
                		Language(`<input id="email" type="text" class="form-control border-0" placeholder="请输入邮箱" aria-label="" aria-describedby="">`,
                			`<input id="email" type="text" class="form-control border-0" placeholder="Enter Email " aria-label="" aria-describedby="">`)
                		</script>
				
			</div>
		</div><!-- 邮箱 -->

		<!-- 密码 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-unlock text-mute"></i></span>
				</div>
					<script>
                		Language(`<input type="password" id="password" class="form-control border-0" placeholder="请输入密码" aria-label="" aria-describedby="">`,
                			`<input type="password" id="password" class="form-control border-0" placeholder=" Enter Password" aria-label="" aria-describedby="">`)
                		</script>
				
			</div>
		</div><!-- 密码 -->

		<!-- 确认密码 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-unlock text-mute"></i></span>
				</div>
					<script>
                		Language(`<input type="password" id="password1" class="form-control border-0" placeholder="请确认您的密码" aria-label="" aria-describedby="">`,
                			`<input type="password" id="password1" class="form-control border-0" placeholder="Re-enter Password" aria-label="" aria-describedby="">`)
                		</script>
				
			</div>
		</div><!-- 确认密码 -->

		<!--用户条款-->
	 	<div class="input-group py-3">
		      <div class="input-group-prepend">
			        <div class="input-group-text  border-0 bg-white" >
			         	 <input type="checkbox" checked="" id="clause" clause="2"> 
			        </div>
		      </div>
			 <a href="/apps/userTerms" class="text-muted">
			 	
                	<script type="text/javascript">
                	Language("用户条款和接收促销邮件","Terms of Use & Subscribe for Promotion Emails")
                </script>
			 </a>
	    </div><!--用户条款-->
    
		<!-- 按钮 -->
		<div class="d-flex justify-content-center pb-3">
			<button type="button" id="sa-save" class="btn bg-pink text-white btn-block rounded-50">
                	<script type="text/javascript">
                	Language("注册","Register")
                </script></button>
		</div><!-- 按钮 -->
		
    <script type="text/javascript">
    	//是否接受条款
    		$("#clause").click(function(){
    			var clauseNum=$("#clause").attr("clause");
    			if (clauseNum==2) {
    				$("#clause").attr("clause","1");
    			} else{
    				$("#clause").attr("clause","2");
    			}
    		});
    	//登录时，先判断是否接受条款
//  		$("#sa-save").click(function(){
//  			var clauseNum=$("#clause").attr("clause");
//  			if (clauseNum==2) {
//  			} else{
//              swal({
//                  title: '注册前，您必须同意用户条款和就收促销邮件!',
//                  type: 'info',
//                  showConfirmButton: true,
//
//              })
//  				return
//  			}
//  		})
    </script>
		<!-- 链接 -->
		<div class="d-flex justify-content-center py-1">
			<span>
                	<script type="text/javascript">
                	Language("已有账号，","Already have an account,")
                </script><a href="{{ route('appsLogin') }}" class="text-red">
                	<script type="text/javascript">
                	Language("立即登录","log in ")
                </script></a></span>
		</div><!-- 链接 -->

	</div>
</div>


@endsection





@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('.top-fix').hide();
		$('#mobile-nav').hide();
		$('.mobile-fix-unauth').hide();
		$('.mobile-fix').hide();
	});

</script>

<script>
    //点击添加
    var saSsave=function () {
   		 	//登录时，先判断是否接受条款
    			var clauseNum=$("#clause").attr("clause");
    			if (clauseNum==1) {
    				
                swal({
                    title: LanguageHtml('注册前，您必须同意用户条款和就收促销邮件，才能注册账号!',' Please Review and Agree Terms of Use In Order to Register'),
                    type: 'info',
                    showConfirmButton: true,

                })
    				return
    			}


        var password = $('#password').val(),
            password1 = $('#password1').val();

        if (String(password1) != String(password)) {

            swal({
                title: LanguageHtml('2次密码输入不一致!','Please Confirm Password '),
                type: 'info',
                showConfirmButton: true,
            })

            return;
        }
        //验证密码参数
        res = check({'password': password});
        if (!res.status) {

            swal({
                title: LanguageHtml('密码中必须包含字母、数字，8-15个字符!','Password must contain alphabet, number, within 8-15 characters!'),
                type: 'warning',
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
    			$('#sa-save').one("click",saSsave)
            if (res.status) {
                swal({
                    title: LanguageHtml('创建用户成功，请点击邮箱激活!',' Successfully registered, please activate through Email'),
                    type: 'success',
                    showConfirmButton: true,
                })
                $('#name').val('');
                $('#email').val('');

              {{--  setTimeout(function () {
                    window.location.href="{{ route('appsLogin') }}";
                }, 1500);--}}
                
            }else {
                swal({
                    title: res.message,
                    type: 'info',
                    showConfirmButton: true,
                })
            }
        })

    }
    $('#sa-save').one("click",saSsave)
</script>


@endsection