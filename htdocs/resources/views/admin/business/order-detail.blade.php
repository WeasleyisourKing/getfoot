@extends('admin/layout.app')

@section('content')
    <!-- Main Content -->

    {{--<div class="row">--}}
        {{--<div class="col-sm-12">--}}
            {{--<h4 class="pull-left page-title">商家订单管理</h4>--}}
            {{--<ol class="breadcrumb pull-right">--}}
                {{--<li><a href="#">Admin Panel</a></li>--}}
                {{--<li><a href="#">商家订单管理</a></li>--}}
                {{--<li class="active">订单列表</li>--}}
                {{--<li class="active">订单详情</li>--}}
            {{--</ol>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-body">--}}
                    {{--<!--startprint-->--}}
                    {{--<div class="clearfix">--}}
                        {{--<div class="pull-left">--}}
                            {{--<h4 class="text-right"><img width="80px" src="/uploads/logo5.png" alt="12buy"></h4>--}}

                        {{--</div>--}}
                        {{--<div class="pull-right">--}}
                            {{--<h4>Order # <br>--}}
                                {{--<strong>{{$data['order_no']}}</strong>--}}
                            {{--</h4>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}

                            {{--<div class="pull-left">--}}
                                {{--<address>--}}
                                    {{--<strong>{{$address['name']}}</strong><br>--}}
                                    {{--{{$address['country']}}<br>--}}
                                    {{--{{$address['detail']}}<br>--}}
                                    {{--{{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>--}}
                                    {{--{{$address['mobile']}}--}}
                                {{--</address>--}}
                            {{--</div>--}}
                            {{--<div class="pull-right m-t-30">--}}
                                {{--<p><strong>Order Date: </strong> {{$data['created_at']}}</p>--}}
                                {{-- <p class="m-t-10"><strong>订单状态: </strong> <span class="label label-pink">Pending</span></p> --}}
                                {{--<p class="m-t-10"><strong>User: </strong>{{$address['user']}}--}}
                                    {{--<strong>Email:</strong> {{$address['email']}}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="table-responsive">--}}
                                {{--<table class="table">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>#</th>--}}
                                        {{--<th>Item</th>--}}
                                        {{--<th>Description</th>--}}
                                        {{--<th>Unit Cost</th>--}}
                                        {{--<th>Quantity</th>--}}
                                        {{--<th>Total</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                    {{--@foreach ($product as $key => $item)--}}
                                        {{--<tr>--}}
                                            {{--<td>{{ $key + 1 }}</td>--}}
                                            {{--<td><img height="30px; align=" middle" src="{{ $item['image'] }}"--}}
                                                {{--alt="没有上传"/>--}}
                                            {{--</td>--}}
                                            {{--<td>{{ !empty($item['znName']) ? $item['znName'] : $item['name'] }}</td>--}}
                                            {{--<td>{{ $item['singlePrice'] }}</td>--}}
                                            {{--<td>{{ $item['count'] }}</td>--}}
                                            {{--<td>{{ $item['totalPrice'] }}</td>--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                                    {{--</tbody>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row" style="border-radius: 0px">--}}
                        {{--<div class="col-md-3 col-md-offset-9">--}}

                            {{--<hr>--}}
                            {{--<h3 class="text-right">USD {{$data['total_price']}}</h3>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                    {{--<!---endprint-->--}}
                    {{--<div class="hidden-print">--}}
                        {{--<div class="pull-right">--}}
                            {{--<a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i--}}
                                        {{--class="fa fa-print"></i></a>--}}
                            {{-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> --}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}

    {{--</div>--}}

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">商家订单管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">商家订单管理</a></li>
                <li class="active">订单列表</li>
                <li class="active">订单详情</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!--startprint-->
                    <div class="table-responsive">
                        <table id="biaoge" class="table">
                            <thead>
                    <div class="clearfix">
                        <div class="pull-left">
                            {{--<h4 class="text-right"><img width="80px" src="/uploads/logo5.png" alt="12buy"></h4>--}}

                        {{--</div>--}}
                        {{--<div class="pull-right">--}}
                            {{--<h4>Order # <br>--}}
                                {{--<strong>{{$data['order_no']}}</strong>--}}
                            {{--</h4>--}}

                            <tr style="font-size: 18px;" >
                                <th colspan="3"><img class="text-right" width="80px" src="/uploads/logo5.png" alt="12buy"></th>

                                <th colspan="3" class="pull-right" align="right">
                                    Order # <br>
                                    <strong>{{$data['order_no']}}</strong>

                                </th>
                            </tr>
                        </div>
                    </div>

                    <hr>
                    {{--<div class="row">--}}
                        <div class="col-md-12">
                            {{--<div class="table-responsive">--}}
                                {{--<table id="biaoge" class="table">--}}
                                    {{--<thead>--}}
                            <div class="pull-left">
                                <th colspan="3" align="left">
                                <address>
                                    <strong>{{$address['name']}}</strong><br>
                                    {{$address['country']}}<br>
                                    {{$address['detail']}}<br>
                                    {{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>
                                    {{$address['mobile']}}
                                </address>
                                </th>
                            </div>
                            <div class="pull-right m-t-20">
                                <th colspan="3" align="right">
                                <p><strong>Order Date: </strong> {{$data['created_at']}}</p>
                                {{-- <p class="m-t-10"><strong>订单状态: </strong> <span class="label label-pink">Pending</span></p> --}}
                                <p class="m-t-10"><strong>User: </strong>{{$address['user']}}
                                    <strong>Email:</strong> {{$address['email']}}</p>
                                </th>
                            </div>
                        </div>

                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="table-responsive">--}}
                                {{--<table class="table">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>#</th>--}}
                                        {{--<th>Item</th>--}}
                                        {{--<th>Description</th>--}}
                                        {{--<th>Unit Cost</th>--}}
                                        {{--<th>Quantity</th>--}}
                                        {{--<th>Total</th>--}}
                                    {{--</tr>--}}
                                    </thead>

                                    <tbody>
                                    <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>Unit Cost</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    </tr>
                                    @foreach ($product as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img height="30px; align=" middle" src="{{ $item['image'] }}"
                                                alt="没有上传"/>
                                            </td>
                                            <td>{{ !empty($item['znName']) ? $item['znName'] : $item['name'] }}</td>
                                            <td>{{ $item['singlePrice'] }}</td>
                                            <td>{{ $item['count'] }}</td>
                                            <td>{{ $item['totalPrice'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <tfoot>
                    		<tr>
                    			<td colspan="6" align="right " style="font-weight: bold; font-size: 24px; line-height: 100px;">USD {{$data['total_price']}}</td>
                    		</tr>
                    <!--<div class="row" style="border-radius: 0px">-->
                        <!--<div class="col-md-3 col-md-offset-9">

                            <hr>
                            <tr class="text-right"></h3>
                        </div>-->
                    <!--</div>-->
                    </tfoot>
                    <hr>
                                </table>
                    <!---endprint-->
                    <div class="hidden-print">
                        <div class="pull-right">
                            <a id="daochu" class="btn btn-inverse waves-effect waves-light"><i
                                        class="fa fa-print"></i></a>
                            {{-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> --}}
                        </div>
                    </div>
                </div>
            {{--</div>--}}

        </div>

    </div>

    {{--<div class="row" style="background: white;margin: 0 50px;padding: 20px;">--}}
        {{--<table id="biaoge" width="90%" border="0" cellspacing="0" cellpadding="0" style="background: white;margin: 0 5%;">--}}
            {{--<thead style="margin-bottom: 50px;">--}}
            {{--<tr style="font-size: 18px;border-bottom: 1px solid #eee;margin-bottom: 30px;" >--}}
                {{--<th colspan="3"><img width="80px" src="/uploads/logo5.png" alt="12buy"></th>--}}
                {{--<th colspan="3" align="right">--}}
                    {{--Order # <br>--}}
                    {{--<strong>{{$data['order_no']}}</strong>--}}

                {{--</th>--}}
            {{--</tr>--}}

            {{--<tr >--}}
                {{--<th colspan="3" align="left">--}}
                    {{--<strong>{{$address['name']}}</strong><br>--}}
                    {{--{{$address['country']}}<br>--}}
                    {{--{{$address['detail']}}<br>--}}
                    {{--{{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>--}}
                    {{--{{$address['mobile']}}--}}
                {{--</th >--}}
                {{--<th align="right" colspan="3">--}}
                    {{--<strong>Order Date: </strong> {{$data['created_at']}} <br />--}}
                    {{--<strong>User: </strong>{{$address['user']}}--}}
                    {{--<strong>Email:</strong> {{$address['email']}}--}}

                {{--</th>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<th colspan="6"></th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--<tr style="border-bottom: 2px solid #666;">--}}
                {{--<th style="align:center;" align="center">#</th>--}}
                {{--<th align="center">Item</th>--}}
                {{--<th align="center">Description</th>--}}
                {{--<th align="center">Unit Cost</th>--}}
                {{--<th style="align:center;" align="center">Quantity</th>--}}
                {{--<th align="center">Total</th>--}}
            {{--</tr>--}}
            {{--@foreach ($product as $key => $item)--}}
                {{--<tr>--}}
                    {{--<td align="center">{{ $key + 1 }}</td>--}}
                    {{--<td align="center"><img height="30px; align=" middle" src="{{ $item['image'] }}"--}}
                        {{--alt="没有上传"/></td>--}}
                    {{--<td align="center">{{ !empty($item['znName']) ? $item['znName'] : $item['name'] }}</td>--}}
                    {{--<td align="center">{{ $item['singlePrice'] }}</td>--}}
                    {{--<td align="center">{{ $item['count'] }}</td>--}}
                    {{--<td align="center">{{ $item['totalPrice'] }}</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
            {{--<tfoot>--}}
            {{--<tr><td  colspan="6" align="right"></td></tr>--}}
            {{--<tr>--}}
                {{--<td  colspan="6" align="right"><b>Shipping fee:</b> {{ $data['freight'] }}</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td  colspan="6" align="right"><b>Tax:</b> {{ round(round(($data['total_price'] - $data['freight']) / (1 + $data['tax']), 2) * $data['tax'],2) }}</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td  colspan="6" align="right">Sub-total: {{$data['total_price']}}</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td  colspan="6" align="right">USD {{$data['total_price']}}</td>--}}
            {{--</tr>--}}
            {{--</tfoot>--}}
        {{--</table>--}}
        {{--<a id="daochu">导出</ a>--}}
    {{--</div>--}}

    <script>

        var html = "<html><head><meta charset='utf-8' /></head><body>" + document.getElementById("biaoge").outerHTML + "</body></html>";
        // 实例化一个Blob对象，其构造函数的第一个参数是包含文件内容的数组，第二个参数是包含文件类型属性的对象
        var blob = new Blob([html], { type: "application/vnd.ms-excel" });
        var a = document.getElementById("daochu");
        // 利用URL.createObjectURL()方法为a元素生成blob URL
        a.href = URL.createObjectURL(blob);
        // 设置文件名
        a.download = "学生成绩表.xls";
    </script>
@endsection
