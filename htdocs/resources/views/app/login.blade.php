@extends('/app/layouts.app')

@section('content')

<div class="top-fix">

</div>

<div class="container">
	<div class="container amount-input py-2 fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="/apps" class="top-nav-item"><i class="fa fa-angle-left"></i></a>

			<!--<a href="" class="top-nav-item"><i class="fa fa-share-alt"></i></a>-->
		</div>
	</div>
	<div class="d-flex flex-column p-5 mt-5">

		<!-- logo -->
		<div class="d-flex justify-content-center pb-4">
			<img class="w-100 h-100" src="/{{$logo}}" alt="logo">
		</div><!-- logo -->

		<form action="/appLogin" class="am-form" id="form-with-tooltip" method="post">
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<!-- 邮箱 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-envelope text-mute"></i></span>
				</div>
				@if (session('email'))
					<script>
                		Language(`<input type="text" value="{{session('email')}}" name="email" class="form-control border-0" placeholder="请输入邮箱" aria-label="" aria-describedby="">`,
                			`<input type="text" value="{{session('email')}}" name="email" class="form-control border-0" placeholder="Enter Email Address" aria-label="" aria-describedby="">`)
                		</script>
					
					@else

					<script>
                		Language(`<input type="text" name="email" class="form-control border-0" placeholder="请输入邮箱" aria-label="" aria-describedby="">`,
                			`<input type="text" name="email" class="form-control border-0" placeholder="Enter Email Address" aria-label="" aria-describedby="">`)
                		</script>
					

				@endif

			</div>
		</div><!-- 邮箱 -->

		<!-- 密码 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-unlock text-mute"></i></span>
				</div>
					<script>
                		Language(`<input type="password" name="password" class="form-control border-0" placeholder="请输入密码" aria-label="" aria-describedby="">`,
                			`<input type="password" name="password" class="form-control border-0" placeholder="Enter Password" aria-label="" aria-describedby="">`)
                		</script>
				
			</div>
		</div><!-- 密码 -->

			@if (session('msg'))
				<div class="d-flex justify-content-center py-3" style="text-align: center;">
					<div class="input-group">
                                <p class="help-block"style="margin: 0 auto;">
                                <strong style="color: #495057;">{{session('msg')}}</strong>
                                </p>
					</div>
				</div>
			@endif
			@if (session('email'))
				<div class="d-flex justify-content-center py-3" style="text-align: center;">
					<div class="input-group">
                                <p class="help-block">
                                    <strong data-data="{{session('email')}}" id="onEmail"
											style="cursor:pointer;color: #495057;"> 
                	<script type="text/javascript">
                	Language("邮件未激活，点击重新发送邮件","Email not verified, CLICK to resend Email")
                </script></a></strong>
                                </p>
					</div>
				</div>
		@endif
		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<button type="submit" class="btn bg-pink text-white btn-block rounded-50" id="clause_btn">
                	<script type="text/javascript">
                	Language("登录","Log In ")
                </script></button>
		</div><!-- 按钮 -->
		
   
		</form>
		<!-- 链接 -->
		<div class="d-flex justify-content-between py-3">
			<div class="d-flex">
				<a href="{{ route('rebuild') }}" class="text-muted">
                	<script type="text/javascript">
                	Language("忘记密码","Forgot Password ")
                </script></a>
			</div>
			<div class="d-flex">
				<a href="{{ route('appsRegister') }}" class="text-muted">
                	<script type="text/javascript">
                	Language("点我注册","Register")
                </script></a>
			</div>
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
    $('#onEmail').click(function () {

        $.get('/pc/again/email', {'email': $(this).attr('data-data')}, function (res) {
            if (res.status) {
                swal({
                    title: LanguageHtml('已重新发送激活邮件 !','Email Sent'),
                    type: 'info',
                    showConfirmButton: true,

                })

            } else {
                swal({
                    title: eval(res.message),
                    type: 'info',
                    showConfirmButton: true,

                })
            }
        })
    })

</script>


@endsection