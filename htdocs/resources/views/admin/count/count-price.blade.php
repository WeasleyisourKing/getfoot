@extends('admin/layout.app')


@section('content')

    <!-- vue作用域 -->
    <div id="xxcctty">
        <!---- 头部标题及导航链接 ---->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">财务统计</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Admin Panel</a></li>
                    <li><a href="#">统计</a></li>
                    <li class="active">财务统计</li>
                </ol>
            </div>
        </div><!---- End 头部标题及导航链接 ---->

        <!---- 搜索及按钮功能区域 ---->
        <!-- 搜索 -->
        <form class="form-horizontal" id="form" role="form" action="/statistic/finance" method="get">
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
            {{--<div class="panel-heading">--}}
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <table class="table table-bordered table-striped display" id="datatable-buttons">
                            <thead>
                            <tr>
                                <th class="col-md-3 col-lg-3 exce"> 总销售额（$）</th>
                                <th class="col-md-3 col-lg-3 exce"> 总成本（$）</th>
                                <th class="col-md-3 col-lg-3 exce"> 总折扣金额（$）</th>
                                <th class="col-md-3 col-lg-3 exce"> 总利润($)</th>

                            </tr>
                            </thead>

                            <tbody id="postContainers">
                            <tr>
                                <td class="exce">{{ $info['total_price'] }}</td>
                                <td class="exce">{{ $info['total_cost'] }}</td>
                                <td class="exce">{{ $info['total_discount'] }}</td>
                                <td class="exce">{{ $info['profit'] }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
                {{--</div>--}}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 text-center" id="chartmain" style="height: 400px;">
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 text-center" id="chartmain1" style="height: 400px;">
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="btn-group col-sm-3">
                            <select id="one" name="cat" class="form-control">
                                <option selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-3">
                            <select id="two" name="cat" class="form-control">
                                <option value='0'>二级分类</option>
                            </select>
                        </div>
                        <div class="btn-group col-sm-3">
                            <select id="pro" class="form-control">
                                <option value='0'>请选择产品</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="btn-group col-sm-3">
                            <select id="one1" name="cat" class="form-control">
                                <option selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-3">
                            <select id="two1" name="cat" class="form-control">
                                <option value='0'>二级分类</option>
                            </select>
                        </div>
                        <div class="btn-group col-sm-3">
                            <select id="pro1" name="pro" class="form-control">
                                <option value='0'>请选择产品</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 text-center" id="chartmain2" style="height: 400px;">
                    </div>
                </div>
            </div>
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


    </script>

    <script>
        var order = {
            title: {
                text: '总销售额趋势图',
                subtext: '',
                x: 'center'
            },
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data:{!! $count !!},
                type: 'line'
            }]
        };

        var cat = {
            title: {
                text: '总利润',
                subtext: '',
                x: 'center'
            },
            color: ['#3398DB'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '总利润',
                    type: 'bar',
                    barWidth: '60%',
                    data:{!! $cost !!}
                }
            ]
        };
        var myChart = echarts.init(document.getElementById('chartmain'));
        myChart.setOption(order);
        var myCharts = echarts.init(document.getElementById('chartmain1'));
        myCharts.setOption(cat);

    </script>

    <script>
        $('#one').on("click", function () {
            var data = @json($category);
            $info = "<option value='0'>二级分类</option>";
            if ($(this).val() != 0) {
                for (let i in data) {
                    if ($(this).val() == data[i].id) {
                        if (data[i].pid.length == 0) {
                            $info = "<option value='0'>二级分类不存在</option>";
                        } else {
                            $info = "<option value='0'>请选择二级分类</option>";
                            for (let j in data[i].pid) {
                                $info += `<option value=${data[i].pid[j].id}>${data[i].pid[j].zn_name}</option>`;
                            }
                        }

                    }
                }
            }
            $('#two').html($info);
        });
        $('#one1').on("click", function () {
            var data = @json($category);
            $info = "<option value='0'>二级分类</option>";
            if ($(this).val() != 0) {
                for (let i in data) {
                    if ($(this).val() == data[i].id) {
                        if (data[i].pid.length == 0) {
                            $info = "<option value='0'>二级分类不存在</option>";
                        } else {
                            $info = "<option value='0'>请选择二级分类</option>";
                            for (let j in data[i].pid) {
                                $info += `<option value=${data[i].pid[j].id}>${data[i].pid[j].zn_name}</option>`;
                            }
                        }

                    }
                }
            }
            $('#two1').html($info);
        });
        $('#two').on("change", function () {

            $.get('/two/product/list/' + $(this).val(), function (res) {

                if (res.status) {

                    if (res.data.length == 0) {
                        $info = "<option value='0'>请选择产品</option>";
                    } else {
                        $info = "<option value='0'>请选择产品</option>";
                        for (let j in res.data) {
                            $info += `<option value=${res.data[j].id}>${res.data[j].zn_name}</option>`;
                        }
                    }
                    $('#pro').html($info);
                }
            });
        });
        $('#two1').on("change", function () {

            $.get('/two/product/list/' + $(this).val(), function (res) {

                if (res.status) {

                    if (res.data.length == 0) {
                        $info = "<option value='0'>请选择产品</option>";
                    } else {
                        $info = "<option value='0'>请选择产品</option>";
                        for (let j in res.data) {
                            $info += `<option value=${res.data[j].id}>${res.data[j].zn_name}</option>`;
                        }
                    }
                    $('#pro1').html($info);
                }
            });
        });

        $('#pro').on("change", function () {

            $.get('/pro/info/' + $(this).val(), function (res) {

                if (res.status) {
                    pro.series[0].name = res.data.name;
                    pro.series[0].data = JSON.parse(res.data.value);

                    myChart2.setOption(pro,true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });
        $('#pro1').on("change", function () {

            $.get('/pro/info/' + $(this).val(), function (res) {

                if (res.status) {
                    pro.series[1].name = res.data.name;
                    pro.series[1].data = JSON.parse(res.data.value);

                    myChart2.setOption(pro,true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });

        var pro = {
            title: {
                text: '产品销售利润对比',
                subtext: '',
                x: 'center'
            },
            color: ['#4cabce', '#e5323e'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '',
                    type: 'bar',
                    barWidth: '20%',
                    data: []
                },
                {
                    name: '',
                    type: 'bar',
                    barWidth: '20%',
                    data: []
                }
            ]
        };
        var myChart2 = echarts.init(document.getElementById('chartmain2'));
        myChart2.setOption(pro);
    </script>
@endsection
