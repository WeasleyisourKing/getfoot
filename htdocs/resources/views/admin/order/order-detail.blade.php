{{--@extends('admin/layout.app')--}}

{{--@section('content')--}}
    {{--<!-- Main Content -->--}}


    {{--<div class="row">--}}
        {{--<div class="col-sm-12">--}}
            {{--<h4 class="pull-left page-title">订单管理</h4>--}}
            {{--<ol class="breadcrumb pull-right">--}}
                {{--<li><a href="#">Admin Panel</a></li>--}}
                {{--<li><a href="#">订单管理</a></li>--}}
                {{--<li class="active">订单列表</li>--}}
                {{--<li class="active">订单详情</li>--}}
            {{--</ol>--}}
        {{--</div>--}}
    {{--</div>--}}

                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="panel panel-default">--}}
                            {{--<div class="panel-heading">--}}
                                {{--<h3 class="panel-title">--}}
                                    {{--<span style="font-weight: bold;">订单号：</span>{{$data['order_no']}}--}}
                                {{--</h3>--}}
                            {{--</div>--}}

                            {{--<table id="table" class="table table-striped ">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th class="col-md-2 col-lg-2 exce"> 序号</th>--}}
                                    {{--<th class="col-md-2 col-lg-2 exce"> 商品图片</th>--}}
                                    {{--<th class="col-md-2 col-lg-2 exce"> 商品名称</th>--}}
                                    {{--<th class="col-md-2 col-lg-2 exce"> 单价（$ ）</th>--}}
                                    {{--<th class="col-md-2 col-lg-2 exce"> 数量</th>--}}
                                    {{--<th class="col-md-2 col-lg-2 exce"> 小计($)</th>--}}

                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody id="postContainer">--}}

                                {{--@foreach ($product as $key => $item)--}}
                                    {{--<tr>--}}
                                        {{--<td class="exce">{{ $key + 1 }}</td>--}}
                                        {{--<td class="exce"><img height="100px; align=" middle" src="{{ $item['image'] }}"--}}
                                            {{--alt="没有上传"/>--}}
                                        {{--</td>--}}
                                        {{--<td class="exce">{{ $item['name'] }}</td>--}}
                                        {{--<td class="exce">{{ $item['singlePrice'] }}</td>--}}
                                        {{--<td class="exce">{{ $item['count'] }}</td>--}}
                                        {{--<td class="exce">{{ $item['totalPrice'] }}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}

                                {{--@if(!empty($data['discounts']))--}}
                                    {{--<tr>--}}
                                    {{--<td class="exce"><b>折扣码：</b></td>--}}
                                    {{--@if($data['discounts']['discount']['type'] != 1)--}}
                                        {{--off--}}
                                            {{--<td class="exce" colspan="5"><b>百分比({{$data['discounts']['discount']['rcent']}})</b></td>--}}
                                        {{--@else--}}
                                            {{--<td class="exce" colspan="5"><b>固定价格({{$data['discounts']['discount']['rcent']}})</b></td>--}}
                                        {{--@endif--}}
                                    {{--</tr>--}}
                                    {{--@endif--}}
                                {{--<tr>--}}
                                    {{--<td class="exce"><b>运费（$）：</b></td>--}}
                                    {{--<td class="exce" colspan="5"><b>{{ $data['freight'] }}</b></td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                     {{--<td class="exce"><b>合计（$）：</b></td>--}}
                                    {{--<td class="exce" colspan="5"><b>{{$data['total_price']}}</b></td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                    {{--<div class="col-md-12">--}}
                        {{--<div class="panel panel-default">--}}
                            {{--<div class="panel-heading">--}}
                                {{--<h3 class="panel-title">--}}
                                    {{--<i class="icon-edit"></i>--}}
                                    {{--下单用户</h3>--}}
                            {{--</div>--}}
                            {{--<div class="modal-body" style="font-size: 16px;">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label>用户名 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['user']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>邮箱 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['email']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>下单时间 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$data['created_at']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-md-12">--}}
                        {{--<div class="panel panel-default">--}}
                            {{--<div class="panel-heading">--}}
                                {{--<h3 class="panel-title">--}}
                                    {{--<i class="icon-edit"></i>--}}
                                    {{--邮寄信息</h3>--}}
                            {{--</div>--}}
                            {{--<div class="modal-body" style="font-size: 16px;">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label>收件人 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['name']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>手机号码 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['mobile']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label>地址1 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['country']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label>地址2 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['detail']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}


                                {{--<div class="form-group">--}}
                                    {{--<label>城市 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['city']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>州 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['province']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label>邮编 :--}}
                                        {{--<text style="font-weight: 400;" id="name">{{$address['zip']}}</text>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                            {{--</div>--}}

                        {{--</div>--}}

                    {{--</div>--}}




{{--@endsection--}}
@extends('admin/layout.app')

@section('content')
    <!-- Main Content -->

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">订单管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">订单管理</a></li>
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
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-right"><img width="80px" src="/uploads/logo5.png" alt="12buy"></h4>

                        </div>
                        <div class="pull-right">
                            <h4>Order # <br>
                                <strong>{{$data['order_no']}}</strong>
                            </h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="pull-left">
                                <address>
                                    <strong>{{$address['name']}}</strong><br>
                                    {{$address['country']}}<br>
                                    {{$address['detail']}}<br>
                                    {{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>
                                    {{$address['mobile']}}
                                </address>
                            </div>
                            <div class="pull-right m-t-30">
                                <p><strong>Order Date: </strong> {{$data['created_at']}}</p>
                                {{-- <p class="m-t-10"><strong>订单状态: </strong> <span class="label label-pink">Pending</span></p> --}}
                                <p class="m-t-10"><strong>User: </strong>{{$address['user']}} <strong>Email:</strong> {{$address['email']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>Unit Cost</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($product as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img height="30px; align=" middle" src="{{ $item['image'] }}"
                                                alt="没有上传"/></td>
                                            <td>{{ !empty($item['znName']) ? $item['znName'] : $item['name'] }}</td>
                                            <td>{{ $item['singlePrice'] }}</td>
                                            <td>{{ $item['count'] }}</td>
                                            <td>{{ $item['totalPrice'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="border-radius: 0px">
                        <div class="col-md-3 col-md-offset-9">
                            <p class="text-right"><b>Shipping fee:</b> {{ $data['freight'] }}</p>
                            <p class="text-right">
                                <b>Tax:</b> {{ round(round(($data['total_price'] - $data['freight']) / (1 + $data['tax']), 2) * $data['tax'],2) }}
                            </p>
                            <p class="text-right">Sub-total: {{$data['total_price']}}</p>
                            <hr>
                            <h3 class="text-right">USD {{$data['total_price']}}</h3>
                        </div>
                    </div>
                    <hr>
       				 <!---endprint-->
                    <div class="hidden-print">
                        <div class="pull-right">
                            <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                            {{-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    
    
	<div class="row" style="background: white;margin: 0 50px;padding: 20px;">
		<table id="biaoge" width="90%" border="0" cellspacing="0" cellpadding="0" style="background: white;margin: 0 5%;">
			<thead style="margin-bottom: 50px;">
				<tr style="font-size: 18px;border-bottom: 1px solid #eee;margin-bottom: 30px;" >
					<th colspan="3"><img width="80px" src="/uploads/logo5.png" alt="12buy"></th>
					<th colspan="3" align="right">
                        Order # <br>
                            <strong>{{$data['order_no']}}</strong>
                        
					</th>
				</tr>
				<tr >
					<th colspan="3">
                        <strong>{{$address['name']}}</strong><br>
                        {{$address['country']}}<br>
                        {{$address['detail']}}<br>
                        {{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>
                        {{$address['mobile']}}
					</th >
					<th align="right" colspan="3">
                        <strong>Order Date: </strong> {{$data['created_at']}} <br />
                        <strong>User: </strong>{{$address['user']}}
                            <strong>Email:</strong> {{$address['email']}}
                        
					</th>
				</tr>
			</thead>
			<tbody>
                <tr style="border-bottom: 2px solid #666;">
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
                        alt="没有上传"/></td>
                    <td>{{ !empty($item['znName']) ? $item['znName'] : $item['name'] }}</td>
                    <td>{{ $item['singlePrice'] }}</td>
                    <td>{{ $item['count'] }}</td>
                    <td>{{ $item['totalPrice'] }}</td>
                </tr>
            @endforeach
			</tbody>
			<tfoot>
				<tr>
					<td><b>Shipping fee:</b> {{ $data['freight'] }}</td>
				</tr>
				<tr>
					<td><b>Tax:</b> {{ round(round(($data['total_price'] - $data['freight']) / (1 + $data['tax']), 2) * $data['tax'],2) }}</td>
				</tr>
				<tr>
					<td>Sub-total: {{$data['total_price']}}</td>
				</tr>
				<tr>
					<td>USD {{$data['total_price']}}</td>
				</tr>
			</tfoot>
		</table>
		<a id="daochu">导出</a>
	</div>

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
