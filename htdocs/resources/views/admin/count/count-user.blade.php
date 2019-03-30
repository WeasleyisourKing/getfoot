@extends('admin/layout.app')


@section('content')

    <!-- vue作用域 -->
    <div id="xxcctty">
        <!---- 头部标题及导航链接 ---->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">用户统计</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Admin Panel</a></li>
                    <li><a href="#">统计</a></li>
                    <li class="active">用户统计</li>
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
        </form>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6 text-center" id="chartmain" style="height: 400px;">
                    </div>
                    <div class="col-sm-6 text-center" id="chartmain1" style="height: 400px;">
                    </div>
                </div>

            </div>

        </div>
        <div class="panel panel-default">
            {{--<div class="panel-heading">--}}
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 text-center" id="chartmain2" style="height: 400px;">
                        </div>
                    </div>
                </div>
                {{--</div>--}}
            </div>
        </div>
    </div>


    <script>

//        $(function () {
//            var start = {
//                format: "YYYY-MM-DD",
////                    skinCell: "jedategreen",
//                choosefun: function (elem, datas) {
//                    end.minDate = datas;
//                }
//            };
//            var end = {
//                format: "YYYY-MM-DD",
////                    skinCell: "jedategreen",
//                choosefun: function (elem, datas) {
//                    start.maxDate = datas;
//                }
//            }
//            $('#indate1').jeDate(start);
//            $('#indate2').jeDate(end);
//
//        })

//        $(document).ready(function () {
//            document.onkeyup = function (e) {
//                var code = e.keyCode || e.charCode;
//                if (code == 13) {
//                    $("#form").submit();
//                }
//            }
//        });


    </script>

    <script>
        var option = {
            title: {
                text: '商业用户统计总揽',
                subtext: '',
                x: 'center'
            },
            tooltip: {
                formatter: "{a} <br/>{b} : {c}%"
            },
            toolbox: {
                feature: {
                    restore: {},
                    saveAsImage: {}
                }
            },
            series: [
                {
                    name: '业务指标',
                    type: 'gauge',
                    center: ['50%', '60%'],
                    detail: {formatter: '{value}%'},
                    data: [{value: {{$percent}}, name: '商业用户'}]
                }
            ]
        };

        var cat = {
            title: {
                text: '商业用户位置及数量',
                subtext: '',
                x: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: {!! $names !!}
            },
            series: [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius: '55%',
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

       var line = {
           title: {
               text: '商业用户增长趋势',
               subtext: '',
               x: 'center'
           },
            xAxis: {
                type: 'category',
                data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
            },
            yAxis: {
                type: 'value'
            },
            series: [{

                data:{!! $count!!},
                type: 'line'
            }]
        };

        var myChart = echarts.init(document.getElementById('chartmain'));
        myChart.setOption(option);

        var myCharts = echarts.init(document.getElementById('chartmain1'));
        myCharts.setOption(cat);

        var myChart1 = echarts.init(document.getElementById('chartmain2'));
        myChart1.setOption(line);

    </script>

@endsection
