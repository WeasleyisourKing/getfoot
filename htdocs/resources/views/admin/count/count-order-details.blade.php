@extends('admin/layout.app')


@section('content')

    <!-- vue作用域 -->
    <div id="xxcctty">
        <!---- 头部标题及导航链接 ---->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">商品销售统计</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Admin Panel</a></li>
                    <li><a href="#">统计</a></li>
                    <li class="active">商品销售统计</li>
                </ol>
            </div>
        </div><!---- End 头部标题及导航链接 ---->

        <!---- 搜索及按钮功能区域 ---->
        <!-- 搜索 -->
        {{--<form class="form-horizontal" id="form" role="form" action="/single/order/details" method="get">--}}
            <div class="panel">
                <div class="panel-body">
                    <!-- 搜索 -->
                    <div class="row ">
                        <div class="col-sm-3 ">
                            <h3>B2B</h3>
                        </div>
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-6 ">
                            {{--<div style="float: right;">--}}
                                {{--<div class="btn-group" style="padding: 10px;">--}}
                                    {{--<input id="indate1" name="front" type="text" class="form-control"--}}
                                           {{--placeholder="请选择查询开始日期" readonly>--}}
                                {{--</div>--}}
                                {{--<div class="btn-group" style="padding: 10px;">--}}
                                    {{--<input id="indate2" name="after" type="text" class="form-control"--}}
                                           {{--placeholder="请选择查询结束日期" readonly>--}}
                                {{--</div>--}}

                            {{--</div>--}}

                        </div>
                    </div>

                </div>

            </div>
        {{--</form>--}}

        <div class="panel panel-default">
            {{--<div class="panel-heading">--}}
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <table class="table table-bordered table-striped display" id="datatable-buttons">
                            <thead>
                            <tr>
                                <th class="col-md-2 col-lg-2 exce"> 商品名称</th>
                                <th class="col-md-2 col-lg-2 exce"> 商品图片</th>
                                <th class="col-md-2 col-lg-2 exce"> 商品SKU</th>
                                <th class="col-md-1 col-lg-1 exce"> 商品单价（$）</th>
                                <th class="col-md-1 col-lg-1 exce"> 商品数量</th>
                                <th class="col-md-2 col-lg-2 exce"> 总价（$）</th>
                                <th class="col-md-2 col-lg-2 exce"> 订单日期</th>


                            </tr>
                            </thead>

                            <tbody id="postContainer">
                            @if (!is_null($data))

                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td class="exce">{{ !empty($item->products->zn_name) ? $item->products->zn_name : "已删除商品" }}</td>
                                        <td class="exce"><img height="100px; align=" middle "
                                            src="{{ !empty($item->products->product_image) ? $item->products->product_image : '' }}" alt=""/>
                                        </td>
                                        <td class="exce">{{ !empty($item->products->sku ) ? $item->products->sku : "已删除商品" }}</td>
                                        <td class="exce">{{ $item->single_price }}</td>
                                        <td class="exce">{{ $item->count }}</td>
                                        <td class="exce">{{ $item->total_price }}</td>
                                        <td class="exce">{{ $item->created_at }}</td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--</div>--}}
            </div>
        </div>
    </div>


    <script>

        $(function () {
            var start = {
                format: "YYYY-MM-DD",
//                    skinCell: "jedategreen",
                choosefun: function (elem, datas) {
                    end.minDate = datas;
                }
            };
            var end = {
                format: "YYYY-MM-DD",
//                    skinCell: "jedategreen",
                choosefun: function (elem, datas) {
                    start.maxDate = datas;
                }
            }
            $('#indate1').jeDate(start);
            $('#indate2').jeDate(end);

        })

//        $(document).ready(function () {
//            document.onkeyup = function (e) {
//                var code = e.keyCode || e.charCode;
//                if (code == 13) {
//                    $("#form").submit();
//                }
//            }
//        });


    </script>



@endsection
