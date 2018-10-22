@extends('admin/layout.app')

@section('content')
    <!-- Main Content -->

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
                                <p class="m-t-10"><strong>User: </strong>{{$address['user']}}
                                    <strong>Email:</strong> {{$address['email']}}</p>
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
                                                alt="没有上传"/>
                                            </td>
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

                            <hr>
                            <h3 class="text-right">USD {{$data['total_price']}}</h3>
                        </div>
                    </div>
                    <hr>
                    <!---endprint-->
                    <div class="hidden-print">
                        <div class="pull-right">
                            <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i
                                        class="fa fa-print"></i></a>
                            {{-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    		</div>
	</div>
	<div class="row">
		<table border="1" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th><img width="80px" src="/uploads/logo5.png" alt="12buy"></th>
					<th>
                        <h4>Order # <br>
                            <strong>{{$data['order_no']}}</strong>
                        </h4>
					</th>
				</tr>
				<tr>
					<th></th>
				</tr>
			</thead>
			<tr><th>Header</th></tr>
			<tr><td>Data</td></tr>
		</table>
	</div>


@endsection
