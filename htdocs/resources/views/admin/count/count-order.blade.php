@extends('admin/layout.app')


@section('content')

    <!-- vue作用域 -->
    <div id="xxcctty">
        <!---- 头部标题及导航链接 ---->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">订单统计</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Admin Panel</a></li>
                    <li><a href="#">统计</a></li>
                    <li class="active">订单统计</li>
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

                        <table class="table table-bordered table-striped display" id="datatable-buttons">
                            <thead>
                            <tr>
                                <th class="col-md-2 col-lg-2 exce"> 商家名称</th>
                                <th class="col-md-2 col-lg-2 exce"> 商家订单总数</th>
                                <th class="col-md-2 col-lg-2 exce" class="td-actions"> 商家订单总额（$）</th>
                                <th class="col-md-2 col-lg-2 exce" class="td-actions"> 商家订单平均总额($)</th>
                                <th class="col-md-2 col-lg-2 exce"> 商家下单频率</th>
                                <th class="col-md-2 col-lg-2 exce"> 商家订单最多分类</th>


                            </tr>
                            </thead>

                            <tbody id="postContainers">
                            @if (!is_null($user))

                                @foreach ($user as $key => $item)
                                    <tr>
                                        <td class="exce"><a
                                                    href="/single/order?front=&after=&id={{$item['id']}}">{{ $item['name'] }}</a>
                                        </td>
                                        <td class="exce">{{ $item['count'] }}</td>
                                        <td class="exce">{{ $item['price'] }}</td>
                                        <td class="exce">{{ $item['avg_price'] }}</td>
                                        <td class="exce">{{ $item['avg_count'] }}</td>
                                        <td class="exce">{{ !empty($item['avg_count']) ? $item['cat'] : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if (is_null($user))
                        <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                    @endif
                </div>
                {{--</div>--}}
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="btn-group col-sm-4">
                            <select id="pro" class="form-control">
                                <option id="first1" value='0'>请选择商家1</option>
                                @foreach ($bin as $items)
                                    <option value="{{$items['id']}}">{{$items['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="one" name="cat" class="form-control">
                                <option id="first2" selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="two" name="cat" class="form-control">
                                <option id="first3" value='0'>二级分类</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group col-sm-4">
                            <select id="pro1" class="form-control">
                                <option id="first4" value='0'>请选择商家2</option>
                                @foreach ($bin as $items)
                                    <option value="{{$items['id']}}">{{$items['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="one1" name="cat" class="form-control">
                                <option id="first5" selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="two1" name="cat" class="form-control">
                                <option id="first6" value='0'>二级分类</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="btn-group col-sm-4">
                            <select id="pro2" class="form-control">
                                <option id="first7" value='0'>请选择商家3</option>
                                @foreach ($bin as $items)
                                    <option value="{{$items['id']}}">{{$items['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="one2" name="cat" class="form-control">
                                <option id="first8" selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="two2" name="cat" class="form-control">
                                <option id="first9" value='0'>二级分类</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group col-sm-4">
                            <select id="pro3" class="form-control">
                                <option id="first10" value='0'>请选择商家4</option>
                                @foreach ($bin as $items)
                                    <option value="{{$items['id']}}">{{$items['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="one3" name="cat" class="form-control">
                                <option id="first11" selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="two3" name="cat" class="form-control">
                                <option id="first12" value='0'>二级分类</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="btn-group col-sm-4">
                            <select id="pro4" class="form-control">
                                <option id="first13" selected="selected" value='0'>请选择商家5</option>
                                @foreach ($bin as $items)
                                    <option value="{{$items['id']}}">{{$items['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="one4" name="cat" class="form-control">
                                <option id="first14" selected="selected" value="0">一级分类</option>
                                @foreach ($category as $items)
                                    <option value="{{$items['id']}}">{{$items['zn_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn-group col-sm-4">
                            <select id="two4" name="cat" class="form-control">
                                <option id="first15" value='0'>二级分类</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 text-center" id="chartmain3" style="height: 400px;">
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
                text: '商家订单统计总览',
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
                data:{!! $name !!}
            },
            series: [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius: '55%',
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
            title: {
                text: '商家订单一级分类总览',
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
        $('#one2').on("click", function () {
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
            $('#two2').html($info);
        });
        $('#one3').on("click", function () {
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
            $('#two3').html($info);
        });
        $('#one4').on("click", function () {
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
            $('#two4').html($info);
        });
    </script>

    <script>


        var option = {
            title: {
                text: '全年商家订单分类及商品统计对比',
                x: 'center'
            },
            color: ['#003366', '#006699', '#4cabce', '#e5323e'],
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
            series: [
                {
                    name: '',
                    data: [],
                    type: 'line'
                },
                {
                    name: '',
                    data: [],
                    type: 'line'
                },
                {
                    name: '',
                    data: [],
                    type: 'line'
                },
                {
                    name: '',
                    data: [],
                    type: 'line'
                },
                {
                    name: '',
                    data: [],
                    type: 'line'
                },
            ]
        };
        var myChartss = echarts.init(document.getElementById('chartmain3'));
        myChartss.setOption(option);

        $('#two').on("change", function () {

            $.get('/pro/total/' + $('#pro').val() + '/two/' + $(this).val(), function (res) {

                if (res.status) {

                    option.series[0].name = $('#pro').find("option:selected").text();
                    option.series[0].data = JSON.parse(res.data.value);
                    option.legend.data = JSON.parse(dd);

                    myChartss.setOption(option, true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });
        $('#two1').on("change", function () {

            $.get('/pro/total/' + $('#pro').val() + '/two/' + $(this).val(), function (res) {

                if (res.status) {


                    option.series[1].name = $('#pro1').find("option:selected").text();
                    option.series[1].data = JSON.parse(res.data.value);

                    myChartss.setOption(option, true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });
        $('#two2').on("change", function () {

            $.get('/pro/total/' + $('#pro2').val() + '/two/' + $(this).val(), function (res) {

                if (res.status) {

                    option.series[2].name = $('#pro2').find("option:selected").text();
                    option.series[2].data = JSON.parse(res.data.value);

                    myChartss.setOption(option, true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });
        $('#two3').on("change", function () {

            $.get('/pro/total/' + $('#pro3').val() + '/two/' + $(this).val(), function (res) {

                if (res.status) {

                    option.series[3].name = $('#pro3').find("option:selected").text();
                    option.series[3].data = JSON.parse(res.data.value);

                    myChartss.setOption(option, true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });
        $('#two4').on("change", function () {

            $.get('/pro/total/' + $('#pro').val() + '/two/' + $(this).val(), function (res) {

                if (res.status) {

                    option.series[4].name = $('#pro4').find("option:selected").text();
                    option.series[4].data = JSON.parse(res.data.value);

                    myChartss.setOption(option, true);
                } else {
                    alertify.alert(res.message);

                }
            });
        });
    </script>
@endsection
