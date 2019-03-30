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
        <form class="form-horizontal" id="form" role="form" action="/single/product" method="get">
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
                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input id="example-input2-group2" name="search" class="form-control"
                                       placeholder="Search" type="email">
                                <span class="input-group-btn">
                            <button type="button"
                                    class="btn waves-effect waves-light btn-primary">
                            <i class="fa fa-search"></i>
                            </button>
                            </span>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </form>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">单品销售详情</h3>
                    {{--<div class="panel">--}}
                </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5 text-center">
                                {{--<p>sdfsd</p>--}}
                                <div class="exce" style="height:200px;" ><img height="100px; align=" middle "
                                src="{{ $data['products']['product_image'] }}" alt="没有上传"/>
                                </div>
                            </div>
                            <div class="col-sm-7" style="padding-top: 10px;">

                                <div>

                                    <h4>
                                        中文名称：{{ is_null($data['products']['zn_name']) ? '无数据' : $data['products']['zn_name']}}</h4>

                                </div>
                                <div>
                                    <h4>
                                        英文名称：{{ is_null($data['products']['en_name']) ? '无数据':$data['products']['en_name']}}</h4>
                                </div>
                                <div>
                                    <h4>商品销量：{{  is_null($data['count']) ? '无数据':$data['count']}}</h4>
                                </div>
                                <div>
                                    <h4>销量排名：{{ is_null($data['rank']) ? '无数据':$data['rank']}}</h4>
                                </div>
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
                            @if (!is_null($arr))

                                @foreach ($arr as $key => $item)
                                    <tr>
                                        <td class="exce">{{ $loop->iteration }}</td>
                                        <td class="exce">{{ $key }}</td>
                                        <td class="exce">{{ count($item) }}</td>
                                        <td class="exce">{{ $item['count'] }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if (is_null($arr))
                        <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                    @endif
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
