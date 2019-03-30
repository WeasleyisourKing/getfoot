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
        <form class="form-horizontal" id="form" role="form" action="/statistic/product/count" method="get">
            <div class="panel">
                <div class="panel-body">
                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-3 ">
                            <h3>B2B</h3>
                        </div>
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-6 ">
                            <div style="float: right;">
                                <div class="btn-group" style="padding: 10px;">
                                    <input id="indate1" name="date[front]" type="text" class="form-control"
                                           placeholder="请选择查询开始日期" readonly>
                                </div>
                                <div class="btn-group" style="padding: 10px;">
                                    <input id="indate2" name="date[after]"  type="text" class="form-control"
                                           placeholder="请选择查询结束日期" readonly>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="btn-group">
                                <select id="one" name="cat[one]" class="form-control">
                                    <option selected="selected"  value="0">一级分类</option>
                                    @foreach ($category as $items)
                                    <option value ="{{$items['id']}}">{{$items['zn_name']}}</option>
                                    @endforeach
                                    </select>
                            </div>
                            <div class="btn-group"  style="padding-left:10px; ">
                                <select id="two" name="cat[two]" class="form-control">
                                    <option value='0'>二级分类</option>
                                </select>

                            </div>
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
        <div class="row">
            <!---- 货架列表 ---->
        @foreach($data as $key => $item)
        <!---- 货架 ---->
            <div class="col-sm-6 panel_box" style="height: 280px;">
                <div class="panel">
                    <div class="panel-body">

                        <div class="row" style="height:220px;">
                            <div class="col-sm-4 text-center">

                                <a href="/single/product?front={{$dateFront}}&after={{$dateaFter}}&search={{$item->products['zn_name']}}">
                                    <div class="exce text-center" style="height:200px;" ><img height="100px; align=" middle "
                                    src="{{ $item->products['product_image'] }}" alt="没有上传"/>
                                </div>
                                </a>
                            </div>
                            <div class="col-sm-8" style="padding-top: 40px;" >

                                <div >
                                    <h4>{{$item->products['zn_name']}}</h4>

                                </div>
                                <div >
                                    <h4>{{$item->products['en_name']}}</h4>
                                </div>
                                <div >
                                    <h4>商品销量：{{$item->count}}</h4>
                                </div>
                                <div >
                                    <h4>销量排名：{{($page-1) * 8 + $key + 1}}</h4>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!---- End 货架 ---->
            </div>
                @endforeach

            <div id="qqo" style="clear: both;text-align: center;">
                {{ $data->links() }}
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

            $('#one').on("click", function() {
                var data = @json($category);
                $info = "<option value='0'>二级分类</option>";
                if ($(this).val() != 0) {
                    for (let i in data) {
                        if ($(this).val() == data[i].id) {
                            if (data[i].pid.length == 0) {
                                $info = "<option value='0'>二级分类不存在</option>";
                            } else {
                                $info = "<option value='0'>二级全部分类</option>";
                                for (let j in data[i].pid) {
                                    $info += `<option value=${data[i].pid[j].id}>${data[i].pid[j].zn_name}</option>`;
                                }
                            }

                        }
                    }
                }
                $('#two').html($info);
            })

            $(document).ready(function () {
                document.onkeyup = function (e) {
                    var code = e.keyCode || e.charCode;
                    if (code == 13) {
                        $("#form").submit();
                    }
                }
            });

            var url = document.location.toString();
            var arrUrl = url.split("?");
            var para = arrUrl[1];
            para = para.substr(7);

            $('#qqo').find('li').each(function(){

               var t = $(this).find('a').attr('href',$(this).find('a').attr('href')+'&'+para);
            })


        </script>


@endsection
