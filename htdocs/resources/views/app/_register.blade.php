@extends('/app/layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-color-pink text-white"><script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " 注册成为12Buy会员 " : "Register as a 12Buy member "); </script></div>

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " 名称 " : "name"); </script></label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" required autofocus>

                                {{--@if ($errors->has('name'))--}}
                                {{--<span class="invalid-feedback">--}}
                                {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required>

                                {{--@if ($errors->has('email'))--}}
                                {{--<span class="invalid-feedback">--}}
                                {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " 密码 " : " password"); </script></label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                {{--@if ($errors->has('password'))--}}
                                {{--<span class="invalid-feedback">--}}
                                {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password1"
                                   class="col-md-4 col-form-label text-md-right"><script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " 密码 " : "confirm password"); </script></label>

                            <div class="col-md-6">
                                <input id="password1" type="password" class="form-control" name="password_confirmation"
                                       required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="sa-save" class="btn btn-block btn-primary">
                                		<script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " 注册 " : "registered"); </script>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //点击添加
        $('#sa-save').click(function () {


            var password = $('#password').val(),
                password1 = $('#password1').val();

            if (String(password1) != String(password)) {

                swal({
                    title: '2次密码输入不一致!',
                    type: 'info',
                    showConfirmButton: false,
                    timer: 1000
                })

                return;
            }
            //验证密码参数
            res = check({'password': password});
            if (!res.status) {

                swal({
                    title: '密码中必须包含字母、数字、特称字符，至少8个字符!',
                    type: 'info',
                    showConfirmButton: false,
                    timer: 1000
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
            var jaAjaxFun=function (res) {
                if (res.status) {
                    swal({
                        title: '创建用户成功，请点击邮箱激活!',
                        type: 'success',
                        showConfirmButton: false,
//                      timer: 1000
                    })
                    $('#name').val('');
                    $('#email').val('');

//                  setTimeout(function () {
//                      window.location.href="{{ route('appsLogin') }}";
//                  }, 1500);
                } else {
                    swal({
                        title: res.message,
                        type: 'info',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            }
			jqAjax("post","/pc/register",datas,jaAjaxFun)
//          $.post('/pc/register', datas, function (res) {
//              if (res.status) {
//                  swal({
//                      title: '创建用户成功，请点击邮箱激活!',
//                      type: 'success',
//                      showConfirmButton: false,
//                      timer: 1000
//                  })
//                  $('#name').val('');
//                  $('#email').val('');
//
//                  setTimeout(function () {
//                      window.location.href="{{ route('appsLogin') }}";
//                  }, 1500);
//              } else {
//                  swal({
//                      title: res.message,
//                      type: 'info',
//                      showConfirmButton: false,
//                      timer: 1000
//                  })
//              }
//          })

        })
    </script>


@endsection
