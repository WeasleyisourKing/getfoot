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
        <form class="form-horizontal" id="form" role="form" action="/single/order" method="get">
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
                            <div style="float: right;">
                                <div class="btn-group" style="padding: 10px;">
                                    <input id="indate1" name="front" type="text" class="form-control"
                                           placeholder="请选择查询开始日期" readonly>
                                </div>
                                <div class="btn-group" style="padding: 10px;">
                                    <input id="indate2" name="after" type="text" class="form-control"
                                           placeholder="请选择查询结束日期" readonly>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <input type="hidden" value="{{$id}}" name="id">
        </form>

        <div class="panel panel-default">
            {{--<div class="panel-heading">--}}
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <table class="table table-bordered table-striped display" id="datatable-buttons">
                            <thead>
                            <tr>
                                <th class="col-md-3 col-lg-3 exce"> 订单号</th>
                                <th class="col-md-3 col-lg-3 exce"> 订单数量</th>
                                <th class="col-md-3 col-lg-3 exce" class="td-actions"> 订单总额（$）</th>
                                <th class="col-md-3 col-lg-3 exce"> 订单日期</th>


                            </tr>
                            </thead>

                            <tbody id="postContainer">
                            @if (!is_null($data))

                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td class="exce"><a href="/single/order/details?front=&after=&id={{$item['id']}}">{{ $item->order_no }}</a></td>
                                        <td class="exce">{{ $item->total_count }}</td>
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

        $(document).ready(function () {
            document.onkeyup = function (e) {
                var code = e.keyCode || e.charCode;
                if (code == 13) {
                    $("#form").submit();
                }
            }
        });

        //            var url = document.location.toString();
        //            var arrUrl = url.split("?");
        //            var para = arrUrl[1];
        //            para = para.substr(7);
        //
        //            $('#qqo').find('li').each(function(){
        //
        //               var t = $(this).find('a').attr('href',$(this).find('a').attr('href')+'&'+para);
        //            })


    </script>



@endsection
