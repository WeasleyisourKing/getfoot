@extends('/app/layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">

            <img src="http://buy.yn-pulse.com/home/img/logo.png" class="h-50 my-auto mx-auto" alt="Logo">

            <div class="col-md-8">


                <div class="card border-0 mt-5">

                    <div class="card-body">
                        <form action="/appLogin" class="am-form" id="form-with-tooltip" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group row">
                                <label for="email"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}" required autofocus>

                                    {{--@if ($errors->has('email'))--}}
                                    {{--<span class="invalid-feedback">--}}
                                    {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('密码') }}</label>

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
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" style="display: none;"
                                                   checked>{{--  {{ __('自动登录') }} --}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if (session('msg'))
                                <div class="form-group row " style="text-align: center;">
                                    <div class="col-md-8 offset-md-4">
                                <span class="help-block">
                                <strong style="color: #fdb3d3;">{{session('msg')}}</strong>
                                </span>
                                    </div>
                                </div>
                            @endif
                            @if (session('email'))
                                <div class="form-group row" style="text-align: center;">
                                    <div class="col-md-8 offset-md-4">
                                <span class="help-block">
                                    <strong data-data="{{session('email')}}" id="onEmail"
                                            style="cursor:pointer;color: #fdb3d3;"> 邮件未激活，点击重新发送邮件</strong>
                                </span>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-block btn-red">
                                        {{ __('登录') }}
                                    </button>

                                    {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                    {{--{{ __('忘记密码？') }}--}}
                                    {{--</a>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#onEmail').click(function () {
        		var jqAjaxFun= function (res) {
                if (res.status) {
                    swal({
                        title: '请点击邮箱激活!',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    })

                } else {
                    swal({
                        title: res.message,
                        type: 'info',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            };
			jqAjax("get","/pc/again/email", {'email': $(this).attr('data-data')},jqAjaxFun)
//          $.get('/pc/again/email', {'email': $(this).attr('data-data')}, function (res) {
//              if (res.status) {
//                  swal({
//                      title: '请点击邮箱激活!',
//                      type: 'success',
//                      showConfirmButton: false,
//                      timer: 1000
//                  })
//
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
