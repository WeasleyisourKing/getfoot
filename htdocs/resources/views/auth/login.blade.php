
    @extends('layouts.app')
        @section('content')
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading bg-img"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"> Sign In to <strong>12BUY</strong> </h3>
                </div> 


                <div class="panel-body">
                <form class="form-horizontal m-t-20" action="/postLogin" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" name="username" value="" type="text" required="" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" name="password" type="password" required="" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center;">
                        @if (session('msg'))
                            <span class="help-block">
                                <strong>{{session('msg')}}</strong>
                                </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>

                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    {{--<div class="form-group m-t-30">--}}
                        {{--<div class="col-sm-7">--}}
                            {{--<a href="recoverpw.html"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-5 text-right">--}}
                            {{--<a href="register.html">Create an account</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </form> 
                </div>                                 
                
            </div>
        </div>


 @endsection