@extends('/app/layouts.app')

@section('content')

	<div class="container py-2 bg-light fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="javascript:history.back(-1);"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("修改密码","Change Password")
                </script></h6>
			<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="top-nav-item"><i class="fa fa-user"></i></a>
		</div>
	</div>

<div class="top-fix"></div>

<div class="container">
	<div class="d-flex flex-column p-5 mt-5">

		<form action="/apps/epassword" method="get">
		<!-- 原始密码 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-lock"></i></span>
				</div>
                	<script type="text/javascript">
                	Language(`<input name="oldPasswd" type="password" class="form-control border-0" placeholder="请输入原密码" aria-label="" aria-describedby="" required="required">`,
                		`<input name="oldPasswd" type="password" class="form-control border-0" placeholder="Enter Old Password" aria-label="" aria-describedby="" required="required">`)
                </script>
				
			</div>
		</div><!-- 原始密码 -->

		<!-- 新密码 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-unlock"></i></span>
				</div>
                	<script type="text/javascript">
                	Language(`<input name="newPasswd" id="newPasswd" type="password" class="form-control border-0" placeholder="请输入新密码" aria-label="" aria-describedby="" required="required">`,
                		`<input name="newPasswd" id="newPasswd" type="password" class="form-control border-0" placeholder="Enter New Password" aria-label="" aria-describedby="" required="required">`)
                </script>
				
			</div>
		</div><!-- 新密码 -->

		<!-- 新密码再次输入 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-unlock"></i></span>
				</div>
                	<script type="text/javascript">
                	Language(`<input name="newPasswd2" type="password" class="form-control border-0" placeholder="请再次输入新密码" aria-label="" aria-describedby="" required="required">`,
                		`<input name="newPasswd2" type="password" class="form-control border-0" placeholder="Re-enter New Password" aria-label="" aria-describedby="" required="required">`)
                </script>
				
			</div>
		</div><!-- 新密码再次输入 -->

			@if (session('msg'))
				<div class="d-flex justify-content-center py-3" style="text-align: center;">
					<div class="input-group">
						<p class="help-block" style="margin: 0 auto;">
							<strong style="font-size: 14px; color: red; display: block; text-align: center;" > {{session('msg')}}</strong>

						</p>
					</div>
				</div>
		@endif
		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<button id="sa-save" type="submit" class="btn btn-red btn-block rounded-50">
                	<script type="text/javascript">
                	Language("修改","Save ")
                </script></button>
		</div><!-- 按钮 -->
		</form>
	</div>
</div>


@endsection





@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#mobile-nav').hide();
	});

	@if(session('msg'))
	var xx="{{session('msg')}}";
		if(xx=='修改成功'){
			swal({
						title: LanguageHtml('修改成功','Saved'),
						type: 'success',
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: LanguageHtml('是的','Yes')
						}).then(function(isConfirm) {
						if (isConfirm.value==true) {
							window.location.href="/apps/user/{{ Auth::guard('pc')->user()->id }}"
						}
						})
		}
	@endif
</script>
<script type="text/javascript">
	$('#sa-save').click(function (){
		res = check({'password': $('#newPasswd').val()});

            if (!res.status) {
//              alertify.alert('密码中必须包含字母、数字、特称字符，至少8个字符');
                 swal({
                            title: LanguageHtml('密码中必须包含字母、数字，8-15个字符!',' Password must contain alphabet, number, within 8-15 characters! '),
                            type: 'warning',
                            showConfirmButton: true
                        })
                return false;
            }
	})
</script>


@endsection