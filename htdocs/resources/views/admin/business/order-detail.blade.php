@extends('admin/layout.app') @section('content')
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

                @if ($status != 1)
                    <div class="panel-body">
                        <!--ttartprint-->
                        <div class="table-responsive" style="overflow-x:hidden ">
                            <table id="biaoge" class="table">
                                <thead>
                                <div class="clearfix">
                                    <div class="pull-left">
                                        {{--
                                        <h4 class="text-right"><img width="80px" src="/uploads/logo5.png" alt="12buy"></h4>--}} {{--

                                </div>--}} {{--
                                <div class="pull-right">--}} {{--
                                    <h4>Order # <br>--}} {{--
                                        <strong>{{$data['order_no']}}</strong>--}} {{--
                                    </h4>--}}

                                        <tr style="font-size: 18px;">
                                            <th colspan="4">PO</th>

                                            <th colspan="9" align="right">
                                                <p style="text-align: right;">
                                                    <!-- Order # <br> -->
                                                    Snack Talk
                                                </p>

                                            </th>
                                        </tr>
                                    </div>
                                </div>

                                <hr> {{--
                            <div class="row">--}}
                                <div class="col-md-12">
                                    {{--
                                    <div class="table-responsive">--}} {{--
                                        <table id="biaoge" class="table">--}} {{--
                                            <thead>--}}
                                    <div class="pull-left">
                                        <th colspan="2" align="left">
                                            <address>
                                                <strong>SnackTalk</strong><br>
                                                4961 Santa Anita<br>
                                                Ave unit i<br>
                                                Temple city, CA 91780<br>
                                                650-690-6666<br>
                                                info@snacktalk.com
                                            </address>
                                        </th>
                                    </div>
                                    <div class="pull-left">
                                        <th colspan="4" align="left">
                                            <address>

                                                Ship To Address</br>

                                                <strong>{{$address['name']}}</strong><br>
                                                {{$address['country']}}<br>
                                                {{$address['detail']}}<br>
                                                {{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>
                                                {{$address['mobile']}}
                                            </address>
                                        </th>
                                    </div>
                                    <div class="pull-right ">
                                        <th colspan="4" align="right">
                                            <p style="text-align: right;">
                                                <strong>创建时间: </strong> {{$data['created_at']}}</p>
                                            {{--
                                            <p class="m-t-10"><strong>订单状态: </strong> <span class="label label-pink">Pending</span></p> --}}
                                            <p style="text-align: right;" class="m-t-10">
                                                <strong>采购人: </strong>{{$address['user']}}<br>
                                                <strong>订单编号:</strong> {{$data['order_no']}}</p>
                                        </th>
                                    </div>
                                </div>

                                </thead>

                                <tbody>
                                <tr>
                                    <th style=" min-width: 60px;">SKU</th>
                                    <th style=" min-width: 60px;">内部SKU</th>
                                    <th style=" min-width: 30px;">商品图片</th>
                                    <th style=" min-width: 30px;">商品名称</th>
                                    <th style=" min-width: 40px;">单价</th>
                                    <th style=" min-width: 50px;">数量</th>
                                    <th style=" min-width: 50px;">箱规</th>
                                    <th style=" min-width: 90px;" >过期日期</th>
                                    <th style=" min-width: 80px;">货架地址</th>
                                    <th style=" min-width: 40px;">分数量</th>
                                </tr>
                                @foreach ($data['purchase'] as $key => $item)
                                    <tr>
                                        <td>
                                            {{ $item['products']['sku'] }}
                                        </td>
                                        <td>
                                            {{ !empty($item['products']['innersku']) ? $item['products']['innersku'] : '' }}
                                        </td>
                                        <td>
                                            <img middle="" src="{{$item['products']['product_image']}}" alt="没有上传"
                                                 height="100px; align=">
                                        </td>
                                        <td>{{ $item['products']['zn_name'] }}</br>{{ $item['products']['en_name'] }}</td>
                                        <td>{{ $item['single_price'] }}</td>
                                        <td>{{ $item['count'] }}</td>
                                        <td> {{ !empty($item['products']['number']) ? $item['products']['number'] : '' }} </td>
                                        <td colspan="3">
                                                @foreach($item['shelves'] as $v)
                                            <div class="row " style="display:flex; justify-content: center;">
                                                    <div class="col-sm-4 text-center">{{ $v['overdue'] }}</div>
                                                    <div class="col-sm-4 text-center">{{ !empty( $v['name']) ?  $v['name'] : '货架不存在' }}</div>
                                                    <div class="col-sm-4 text-center">{{ $v['count'] }}</div>
                                            </div>
                                            @endforeach
                                        </td>
                                        {{--{{dd($item['products']['shelves'])}}--}}
                                        {{--<td>{{ !empty( $item['products']['shelves']) ? $item['products']['shelves']['name'] : ''  }}</td>--}}
                                    </tr>
                                @endforeach
                                </tbody>

                        </div>
                        <tfoot>
                        <tr>
                            <td colspan="10" align="right "
                                style="font-weight: bold; font-size: 24px; line-height: 100px;">
                                <p style="text-align: right;">USD {{$data['total_price']}}</p>
                            </td>
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
                        <!---eedprint-->
                        <div class="hidden-print">
                            <div class="pull-right">
                                {{--@if ($status != 1)--}}
                                <a id="daochu1" class="btn btn-inverse waves-effect waves-light"><i
                                            class="fa fa-print"></i></a>
                                {{--@else--}}
                                {{--<a id="invoice" class="btn btn-success waves-effect waves-light"><i--}}
                                {{--class="fa fa-print">invoice</i></a>--}}
                                {{--<a id="packing" class="btn btn-success waves-effect waves-light"><i--}}
                                {{--class="fa fa-print">packing</i></a> --}}{{-- <a href="#" class="btn btn-primary waves-effect waves-light">Submit</a> --}}
                                {{--@endif--}}
                            </div>
                        </div>


                    </div>

            </div>
        @else
            <!-- 第2次 -->
                <div id="packing1" class="panel-body">
                    <!--rrartprint-->
                    <div class="table-responsive" style="overflow-x:hidden ">
                        <table class="table">
                            <thead>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <tr style="font-size: 18px;">
                                        <th colspan="4">PackingList</th>

                                        <th colspan="5" align="right" style=" vertical-align: middle;">
                                            <p style="text-align: right;">
                                                <!-- Order # <br> -->
                                                <strong>Snack Talk</strong>
                                            </p>

                                        </th>
                                    </tr>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="table-responsive" style="overflow-x:hidden ">
                                        <table id="biaoge" class="table">
                                            <thead>
                                            <div class="pull-left">
                                                <th colspan="1" align="left">
                                                    <address>

                                                        <strong>SnackTalk</strong><br>
                                                        4961 Santa Anita<br>
                                                        Ave unit i<br>
                                                        Temple city, CA 91780<br>
                                                        650-690-6666<br>
                                                        info@snacktalk.com
                                                    </address>
                                                </th>
                                            </div>
                                            <div class="pull-left">
                                                <th colspan="2" align="left">
                                                    <address>
                                                        Ship To Address</br>
                                                        <strong>{{$address['name']}}</strong><br>
                                                        {{$address['country']}}<br>
                                                        {{$address['detail']}}<br>
                                                        {{$address['city']}}
                                                        , {{$address['province']}} {{$address['zip']}}<br>
                                                        {{$address['mobile']}}
                                                    </address>
                                                </th>
                                            </div>
                                            <div class="pull-right ">
                                                <th colspan="2" align="right" style=" vertical-align: middle;">
                                                    <p style="text-align: right;"><strong>create
                                                            date: </strong> {{$data['created_at']}}</p>
                                                    <p style="text-align: right;" class="m-t-10">
                                                        <strong>Packing list#:</strong> {{$data['order_no']}}</p>
                                                </th>
                                            </div>
                                    </div>

                            </thead>

                            <tbody>
                            <tr>
                                <th>Terms</th>
                                <th>Due Date</th>
                                <th>Rep</th>
                                <th>Account#</th>
                                <th>Ship Date</th>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                            </tr>
                            <tr>

                                <th>SKU</th>
                                <th>Product Name</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                            @foreach ($data['purchase'] as $key => $item)
                                <tr>


                                    <td>
                                        {{ $item['products']['sku'] }}
                                    </td>
                                    <td>{{ $item['products']['zn_name'] }} </br>{{$item['products']['en_name']}}</td>
                                    <td>{{ $item['single_price'] }}</td>
                                    <td>{{ $item['count'] }}</td>
                                    <td>{{ $item['total_price'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                    </div>
                    <tfoot>
                    <tr>
                        <td colspan="3">Pallets Out:</td>
                        <td colspan="3">SIGN:</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="right "
                            style="font-weight: bold; font-size: 24px; line-height: 100px;">
                            <p style="text-align: right;">Total: {{$data['total_price']}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center ">
                            <p style="text-align: center;">Make all checks payable to Snack Talk Inc. Thank you for
                                your business!</p>
                        </td>
                    </tr>
                    </tfoot>
                    <hr>
                    </table>
                    <!---rrdprint-->
                    <div class="hidden-print">
                        <div class="pull-right">
                            <a id="packing" class="btn btn-success waves-effect waves-light"><i
                                        class="fa fa-print">packing</i></a>
                            <a id="excel-packing" class="btn btn-default btn-info"><i
                                        class="fa fa-print">excel-packing</i></a>
                        </div>
                    </div>
                </div>

        </div>
        {{--<!-- 第3次 -->--}}
        <div id="invoice1" class="panel-body" style="margin-top:20px">
            <!--ssartprint-->
            <div class="table-responsive" style="overflow-x:hidden ">
                <table class="table">
                    <thead>
                    <div class="clearfix">
                        <div class="pull-left">
                            <tr style="font-size: 18px;">
                                <th colspan="4">Invoice</th>

                                <th colspan="5" align="right" style=" vertical-align: middle;">
                                    <p style="text-align: right;">
                                        <!-- Order # <br> -->
                                        <strong>Snack Talk</strong>
                                    </p>

                                </th>
                            </tr>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive" style="overflow-x:hidden ">
                                <table id="biaoge" class="table">
                                    <thead>
                                    <div class="pull-left">
                                        <th colspan="1" align="left">
                                            <address>

                                                <strong>SnackTalk</strong><br>
                                                4961 Santa Anita<br>
                                                Ave unit i<br>
                                                Temple city, CA 91780<br>
                                                650-690-6666<br>
                                                info@snacktalk.com
                                            </address>
                                        </th>
                                    </div>
                                    <div class="pull-left">
                                        <th colspan="2" align="left">
                                            <address>
                                                Ship To Address</br>
                                                <strong>{{$address['name']}}</strong><br>
                                                {{$address['country']}}<br>
                                                {{$address['detail']}}<br>
                                                {{$address['city']}}, {{$address['province']}} {{$address['zip']}}<br>
                                                {{$address['mobile']}}
                                            </address>
                                        </th>
                                    </div>
                                    <div class="pull-right ">
                                        <th colspan="2" align="right" style=" vertical-align: middle;">
                                            <p style="text-align: right;"><strong>create
                                                    date: </strong> {{$data['created_at']}}
                                            </p>
                                            <p style="text-align: right;" class="m-t-10">
                                                <strong>Packing list#:</strong> {{$data['order_no']}}</p>
                                        </th>
                                    </div>
                            </div>

                    </thead>

                    <tbody>
                    <tr>
                        <th>Terms</th>
                        <th>Due Date</th>
                        <th>Rep</th>
                        <th>Account#</th>
                        <th>Ship Date</th>
                    </tr>

                    <tr>
                        <td colspan="6">&nbsp;</td>
                    </tr>

                    <tr>

                        <th>SKU</th>
                        <th>Product Name</th>
                        <th>Rate</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                    @foreach ($data['purchase'] as $key => $item)
                        <tr>

                            <td>{{ $item['products']['sku'] }}</td>
                            <td>{{ $item['products']['zn_name'] }} </br> {{$item['products']['en_name']}}</td>
                            <td>{{ $item['single_price'] }}</td>
                            <td>{{ $item['count'] }}</td>
                            <td>{{ $item['total_price'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
            </div>
        </div>
    </div>
    <tfoot>
    <tr>
        <td colspan="3">Pallets Out:</td>
        <td colspan="3">SIGN:</td>
    </tr>
    <tr>
        <td colspan="6" align="right "
            style="font-weight: bold; font-size: 24px; line-height: 100px;">
            <p style="text-align: right;">Total: {{$data['total_price']}}</p>
        </td>
    </tr>
    <tr>

        <td colspan="6" align="center ">
            <p style="text-align: center;">Make all checks payable to Snack Talk Inc. Thank you for
                your
                business!</p>
        </td>
    </tr>
    </tfoot>
    <hr>
    </table>
    <!---nndprint-->
    <div class="hidden-print">
        <div class="pull-right">
            <a id="invoice" class="btn btn-success waves-effect waves-light"><i
                        class="fa fa-print">invoice</i></a>
            <a id="excel-invoice" class="btn btn-default btn-info"><i
                        class="fa fa-print">excel-invoice</i></a>
        </div>
    </div>
    </div>
    </div>
    @endif
    </div>
    </div>

    </div>

    </div>

    <script>
        $("#excel-packing").click(
            function () {
        var html = "<html><head><meta charset='utf-8' /></head><body>" + document.getElementById("biaoge").outerHTML + "</body></html>";
        // 实例化一个Blob对象，其构造函数的第一个参数是包含文件内容的数组，第二个参数是包含文件类型属性的对象
        var blob = new Blob([html], { type: "application/vnd.ms-excel" });
        var a = document.getElementById("excel-packing");
        // 利用URL.createObjectURL()方法为a元素生成blob URL
        a.href = URL.createObjectURL(blob);
        // 设置文件名
        a.download = "packing.xls";
        })

        $("#excel-invoice").click(
            function () {
        var html = "<html><head><meta charset='utf-8' /></head><body>" + document.getElementById("biaoge").outerHTML + "</body></html>";
        // 实例化一个Blob对象，其构造函数的第一个参数是包含文件内容的数组，第二个参数是包含文件类型属性的对象
        var blob = new Blob([html], { type: "application/vnd.ms-excel" });
        var a = document.getElementById("excel-invoice");
        // 利用URL.createObjectURL()方法为a元素生成blob URL
        a.href = URL.createObjectURL(blob);
        // 设置文件名
        a.download = "invoice.xls";
        })
        $("#invoice").click(
            function () {
                // $(".panel-body").eq(0).hide();
                // $(".panel-body").eq(1).show();
                document.title = "Snack Talk"
                bdhtml = window.document.body.innerHTML;
                bdhtmll = window.document.body.innerHTML;
                sprnstr = "<!--ssartprint-->";
                eprnstr = "<!--nndprint-->";
                prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
                prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
                window.document.body.innerHTML = prnhtml;
                window.print();
                window.location.reload()
            })
        $("#packing").click(
            function () {
//             $(".panel-body").eq(0).remove();
                // $(".panel-body").eq(2).show();
                $("#invoice1").remove()
                document.title = "Snack Talk";
                bdhtml = window.document.body.innerHTML;
                bdhtmll = window.document.body.innerHTML;
                sprnstr = "<!--rrartprint-->";
                eprnstr = "<!--rrdprint-->";
                prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
                prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
                window.document.body.innerHTML = prnhtml;
                window.print();
                window.location.reload()
            })
        $("#daochu1").click(
            function () {
                $(".panel-body").eq(1).hide();
                document.title = "Snack Talk";
                bdhtml = window.document.body.innerHTML;
                bdhtmll = window.document.body.innerHTML;
                sprnstr = "<!--ttartprint-->";
                eprnstr = "<!--eedprint-->";
                prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
                prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
                window.document.body.innerHTML = prnhtml;
                window.print();
                window.location.reload()
            })

    </script>
@endsection