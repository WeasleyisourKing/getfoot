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
        <form class="form-horizontal" id="form" role="form" action="/statistic/order" method="get">
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
        </form>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 text-center" >
                        <div id="chartmain" style="width:500px; height: 400px;"></div>
                    </div>

                    <div class="col-sm-6 text-center">
                        <div id="chartmain1" style="width:500px; height: 400px;"></div>
                    </div>
                </div>

            </div>

        </div>
        <div class="panel panel-default">
            {{--<div class="panel-heading">--}}
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="col-md-3 col-lg-3 exce"> 序号</th>
                                <th class="col-md-3 col-lg-3 exce"> 商家名称</th>
                                <th class="col-md-3 col-lg-3 exce" class="td-actions"> 订购次数</th>
                                <th class="col-md-3 col-lg-3 exce" class="td-actions"> 订购总量</th>
                            </tr>
                            </thead>

                            <tbody id="postContainer">
                            {{--@if (!is_null($arr))--}}

                                {{--@foreach ($arr as $key => $item)--}}
                                    {{--<tr>--}}
                                        {{--<td class="exce">{{ $loop->iteration }}</td>--}}
                                        {{--<td class="exce">{{ $key }}</td>--}}
                                        {{--<td class="exce">{{ count($item) }}</td>--}}
                                        {{--<td class="exce">{{ $item['count'] }}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                            </tbody>
                        </table>
                    </div>
                    {{--@if (is_null($arr))--}}
                        {{--<div class="col-md-12" style="text-align: center;">暂时没有数据</div>--}}
                    {{--@endif--}}
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

    <script>
       var order = {
            title : {
                text: '商家订单统计总览',
                subtext: '',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data:{!! $name !!}
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:{!! $data!!},

                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

       var cat = {
           title : {
               text: '商家订单一级分类总览',
               subtext: '',
               x:'center'
           },
           tooltip : {
               trigger: 'item',
               formatter: "{a} <br/>{b} : {c} ({d}%)"
           },
           legend: {
               orient: 'vertical',
               left: 'left',
               data: {!! $names !!}
           },
           series : [
               {
                   name: '访问来源',
                   type: 'pie',
                   radius : '55%',
                   center: ['50%', '60%'],
                   data:{!! $ones!!},
                   itemStyle: {
                       emphasis: {
                           shadowBlur: 10,
                           shadowOffsetX: 0,
                           shadowColor: 'rgba(0, 0, 0, 0.5)'
                       }
                   }
               }
           ]
       };
       var myChart = echarts.init(document.getElementById('chartmain'));
       myChart.setOption(order);
       var myCharts = echarts.init(document.getElementById('chartmain1'));
       myCharts.setOption(cat);
    </script>

@endsection
