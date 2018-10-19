@extends('/app/layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	<script type="text/javascript">
                	Language("重设密码","Reset Password")
                </script></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="get" action="/apps/code">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-4 input-group">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="input-group-addon">
                                    <button type="button" class="btn btn-block bg-pink text-white" onclick="send();">
                	<script type="text/javascript">
                	Language("发送验证码"," Send Verification Code")
                </script></button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                	<script type="text/javascript">
                	Language("验证码","Verification Code")
                </script></label>

                            <div class="col-md-6">
                                <input id="code" name="code" type="text" class="form-control"  value="{{ old('email') }}" required>


                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 pt-4">
                                <button type="button" class="btn btn-block  bg-pink text-white" id="Submit" onclick="repasswd();">
                	<script type="text/javascript">
                	Language("重置密码","Create New Password")
                </script>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">

    var send = function (){
        var email = $('#email').val();
        $.get('/apps/repasswd', { 'email':email}, function (res) {
            if (res.status) {
                swal({
                    title: LanguageHtml('发送邮件成功，请查看验证码','Please Check Email for Verification Code'),
                    type: 'success',
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
      
        }
</script>
<script type="text/javascript">
    var repasswd = function (){
            var email = $('#email').val();
            var code = $('#code').val();
            $.ajax({
                    url:"/apps/code",
                    method:'get',
                    data:{email:email,code:code},

                success:function(res){

                    if (res.status) {
                        swal({
                            title: eval(res.data),
                            type: 'success',
                            showConfirmButton: true,
                        });
                        setTimeout(gologin,3000)
                    } else {
                        swal({
                            title: eval(res.message),
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
    function gologin(){
    	window.location.href="/apps/login"
    }
</script>
