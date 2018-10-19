@extends('admin/layout.app')

@section('content')

    <div class="row">

        <div id="handle" style="display: block;" class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypal">

                        <input type="hidden" name="cmd" value="_xclick">

                        <input type="hidden" name="business" value="info-facilitator@12buy.com">

                        <input type="hidden" name="item_name" value="巧克力">

                        <input type="hidden" name="item_number" value="A514682889341893">


                        <input type="hidden" name="cancel_return" value="http://buy.yn-pulse.com/dashboard">
                        <input type="hidden" name="cancel_return" value="http://shop.buy.com/dashboard">

                        <input type="hidden" name="notify_url" value="http://buy.yn-pulse.com/api/pal/notify">

                        <input type="hidden" name="notify_url" value="http://shop.buy.com/api/pal/notify">

                        成功后返回
                        <input type="hidden" name="return" value="http://shop.buy.com/dashboard">
                        <!-- 货币种类，USD为美元 -->
                        <input type="hidden" name="currency_code" value="USD">
                        <!-- 支付金额 -->
                        <input type="hidden" name="amount" value="0.8">
                        <input type="submit" value="立即支付" class="sbtn4" />
                    </form>


                    {{--<form  id = 'send_hptoken'  action = 'https://test.authorize.net/payment/payment'  method = 'post' target = 'load_payment'>--}}
                    {{--<input  type = 'hidden'  name = 'token'  value = {{$token}}/>--}}
                        {{--<input type="submit" value="立即支付" class="sbtn4" />--}}
                {{--</form>--}}
                </div>
            </div>
        </div>

    </div>
    {{--<script>--}}
    {{--var ws = new WebSocket("ws://IP:端口");--}}
    {{--//握手监听函数--}}
    {{--ws.onopen=function(){--}}
    {{--//状态为1证明握手成功，然后把client自定义的名字发送过去--}}
    {{--if(so.readyState==1){--}}
    {{--//握手成功后对服务器发送信息--}}
    {{--so.send('type=add&ming='+n);--}}
    {{--}--}}
    {{--}--}}
    {{--//错误返回信息函数--}}
    {{--ws.onerror = function(){--}}
    {{--console.log("error");--}}
    {{--};--}}
    {{--//监听服务器端推送的消息--}}
    {{--ws.onmessage = function (msg){--}}
    {{--console.log(msg);--}}
    {{--}--}}

    {{--//断开WebSocket连接--}}
    {{--ws.onclose = function(){--}}
    {{--ws = false;--}}
    {{--}--}}

    {{--</script>--}}




@endsection