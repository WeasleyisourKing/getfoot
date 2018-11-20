@extends('admin/layout.app')




@section('view-item-modal-content')
    <!---- 查看模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            操作人
        </label>

        <input type="text" id="eoperator" class="form-control" readonly="readonly" value="系统">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            创建时间
        </label>

        <input type="text" id="date" class="form-control" readonly="readonly" value="2018-10-23 9:30:21">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            库存类型
        </label>

        <input type="text" class="form-control" readonly="readonly" value="出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">入库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            关联订单
        </label>

        <input type="text" id="eorderId" class="form-control" value="">

    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>

        <textarea class="form-control" id="eremark" cols="30" rows="4" readonly="readonly">此出库记录由系统根据用户订单正常生成</textarea>
    </div>

    <!---- 商品列表 ---->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">商品列表</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>商品图片</th>
                        <th>SKU</th>
                        <th>商品名称</th>
                        <th>变更数量</th>
                        <th>实时库存</th>
                        <th>过期时间</th>
                    </tr>
                    </thead>

                    <tbody id="orderDeal">
                    {{--<td><img class="" height="60px; align=" middle" src="https://12buy.com/uploads/安慕希正面101118.jpg" alt=""></td>--}}
                    {{--<td><a href="" target="_blank">6907992512570</a></td>--}}
                    {{--<td><a href="" target="_blank">安慕希 希腊风味酸奶 原味 205g Ambrosial Greek Flavored Yoghurt 205g</a></td>--}}
                    {{--<td><p class="text-center text-danger">-30</p></td>--}}
                    {{--<td><p class="text-center">120</p></td>--}}
                    {{--<td>至2018-11-23</td>--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div><!---- 商品列表 ---->
@endsection





@section('content')

    <!---- 头部标题及导航链接 ---->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">库存列表</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

    <!---- 搜索及按钮功能区域 ---->
    {{--<div class="row">--}}
    {{--<div class="col-lg-12">--}}
    {{--<div class="panel">--}}
    {{--<div class="panel-body">--}}

    {{--<div class="row">--}}

    {{--<div class="col-sm-12 m-t-10">--}}
    {{--<!-- 批量操作按钮 -->--}}
    {{--<div class="btn-group dropdown">--}}
    {{--<button id="bulk-btn" type="button" class="btn btn-warning waves-effect waves-light">Bulk <i class="fa fa-check-square-o"></i></button>--}}
    {{--<button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>--}}
    {{--<ul class="dropdown-menu" role="menu">--}}
    {{--<li><a href="">打印</a></li>--}}
    {{--<li class="divider"></li>--}}
    {{--<li class="text-danger"><a href="javascript:viod(0);" id="delete_btn">删除</a></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<!-- 批量操作按钮 -->--}}
    {{--</div>--}}

    {{--</div><!---- End row ---->--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div><!---- End 搜索及按钮功能区域  ---->--}}

    <!---- 库存列表 ---->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <!-- 数据表 -->
                    <table class="table table-bordered table-striped display" id="example">
                        <thead>
                        <tr>
                            <th class="exce">商品名称</th>
                            <th class="exce">最近库存变更日期</th>
                            <th class="exce">最近库存变更数量</th>
                            <th class="exce">SKU</th>
                            <th class="exce">商品图片</th>
                            <th class="exce">库存数量</th>
                            {{--<th class="exce">操作</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($res as $item)
                            <tr>
                                <!---- 选择框及编号 ---->
                                {{--<td>--}}
                                {{--<div class="checkbox checkbox-success">--}}
                                {{--<input id="item-checkbox-id" type="checkbox" name="image_input" value="{{$item->id}}" class="item-checkbox">--}}
                                {{--<label for="item-checkbox-id">--}}
                                {{--{{$item->order_no}}--}}
                                {{--</label>--}}
                                {{--</div>--}}
                                {{--</td><!---- 选择框及编号 ---->--}}
                                <td class="exce">{{ $item->zn_name }} <br/>{{ $item->en_name }}</td>
                                @if(!empty($item->info))
                                    <td class="exce">{{ $item->info->created_at }}</td>
                                    @if ($item->info->status != 1)
                                        <td class="exce">-{{ $item->info->count }}</td>
                                    @else
                                        <td class="exce">+{{ $item->info->count }}</td>
                                    @endif
                                @else
                                    <td class="exce">暂时没有变更</td>
                                    <td class="exce">暂时没有变更</td>
                                @endif
                                <td class="exce">{{ $item->sku }}</td>
                                <td class="exce"><img height="100px; align=" middle"
                                    src="{{ $item->product_image }}"
                                    alt="没有上传"/>
                                </td>


                                <td class="exce">
                                    <div class="col-md-12">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4"
                                             style="border: 1px solid #ddd;height:24px ">{{ $item->stock }}</div>
                                        <div class="col-md-5" style="padding:0px;"><input
                                                    data-id="{{ $item->id }}"
                                                    data-data="{{ $item->stock }}" name="dataStock"
                                                    style="width:100%;border: 1px solid #ddd"/></div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </td>
                                {{--<!-- 操作按钮 -->--}}
                                {{--<td class="actions exce">--}}
                                {{--<!---- 查看按钮 ---->--}}
                                {{--<button class="btn-sm btn-success waves-effect waves-light edit-item-btn"--}}
                                {{--data-toggle="modal" data-target="#view-item-modal" data-id="{{$item->id}}"--}}
                                {{--onclick="sse(this);"><i class="fa fa-eye"></i></button><!---- End 编辑按钮 ---->--}}
                                {{--<!---- 删除按钮 ---->--}}
                                {{--<button class="btn-sm btn-danger waves-effect waves-light delete-item-btn" data-id="{{$item->id}}" onclick="del(this);"><i class="fa fa-trash"></i></button><!---- End 删除按钮 ---->--}}
                                {{--</td><!-- 操作按钮 -->--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table><!-- End 数据表 -->
                </div>
            </div>
        </div>
    </div><!---- End 库存列表 ---->





    <!---- 弹窗 ---->
    <!---- 查看 ---->
    <div id="view-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content"> <!--startprint-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-eye"></i> 查看库存信息</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('view-item-modal-content')
                    </div>
                </div>
                <!--endprint-->
                <div class="modal-footer">
                    <a href="##" id="Print" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div><!---- End 查看 ---->


    <script type="text/javascript">
    </script>
    <!---- End 弹窗 ---->
    <script>
        //删除
        //    var del = function (event) {
        //
        //        alertify.confirm("确认框", function (e) {
        //            if (e) {
        //
        //                $.get('/enter/stock/order/del', {'id': $(event).attr('data-id')}, function (res) {
        //
        //                    if (res.status) {
        //                        alertify.success("删除成功");
        //
        //                        setTimeout(function () {
        //                            location.reload();
        //                        }, 1500);
        //                    } else {
        //                        alertify.alert(res.message);
        //                    }
        //                })
        //            }
        //
        //        });
        //    }

        $('#delete_btn').click(function () {

            var arr = [];
            $('input[name=image_input]:checked').each(function () {

                arr.push($(this).val());
            });

            if (arr.length == 0) {
                alertify.alert('没有选择任何记录');
                return;
            }

            $.get('/enter/stock/Batch/del', {'arr': arr}, function (res) {

                if (res.status) {
                    alertify.success('删除成功');
                    $("input[name='image_input']").removeAttr("checked", false);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }

            });
        });
        var sse = function (event) {
            $.get('/enter/stock/order/deal', {'id': $(event).attr('data-id')}, function (res) {

                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        var datas = '';
                        for (let i in res.data.purchase) {

                            var midlle = res.data.purchase[i].overdue == null ? '未填写' : '至' + res.data.purchase[i].overdue;
                            var char = res.data.status != 1 ? '-' : '+';
                            datas += `<tr>
                                <td><img height="60px; align=" middle" src="${res.data.purchase[i].products.product_image}" alt="没有上传"></td>
                                <td >${res.data.purchase[i].products.sku}</td>
                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
                                <td><p class="text-center text-success">${char}${res.data.purchase[i].count}</p></td>
                                 <td><p class="text-center">${res.data.purchase[i].products.stock}</p></td>
                               <td>${midlle}</td>
                            </tr>`;
                        }

                    }

                    $('#eoperator').attr("value", `${res.data.operator}`);
                    $('#eorderId').attr("value", `${res.data.pruchase_order_no}`);
                    $('#date').attr("value", `${res.data.create}`);
                    $('#eremark').attr("value", `${res.data.remark}`);

                    alertify.success('获取成功');

                    $('#orderDeal').html(datas);
                    $("#Print").click(
                        function () {
                            bdhtml = window.document.body.innerHTML;
                            bdhtmll = window.document.body.innerHTML;
                            sprnstr = "<!--startprint-->";
                            eprnstr = "<!--endprint-->";
                            prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
                            prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
                            window.document.body.innerHTML = prnhtml;
                            window.print();
                            window.location.reload()
                        })
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>

    <script>
        //点击 提交
        $(document).ready(function () {
            document.onkeyup = function (e) {
                var code = e.keyCode || e.charCode;
                if (code == 13) {
                    window.data = [];
                    window.sum = 0;

//                    window.shelve = [];
                    $("input[name='dataStock']").each(function () {
                        if (($(this).val() != '')) {

                            data.push({'product_id': $(this).attr('data-id'), 'count': $(this).val()});
                        }
                    });
                    console.log(window.data);


                    if (data[0].count[0] == '-') {

                        for (let i in data) {
                            if (!(Number(data[i].count) < 0)) {
                                alertify.success('本次提交为出库处理，包含正数或者格式不正确');
                                return;
                            }
                            window.sum += Math.abs(data[i].count);

                        }
                    } else {
                        for (let i in data) {

                            if (!(Number(data[i].count) > 0)) {
                                alertify.success('本次提交为入库处理，包含负数或者格式不正确');
                                return;
                            }
                            window.sum += Math.abs(data[i].count);

                        }

                    }


                    if (window.data.length > 0) {

                        $.post('/stock/product/deal', {
                            'data': window.data,
                            'count': window.sum,
//                            'shelve': window.shelve,
                            '_token': '{{csrf_token()}}'
                        }, function (res) {

                            if (res.status) {
                                alertify.success('修改库存成功');
                                $('input[name="dataStock"]').val('');
//                                $('input[name="dataShelve"]').val('');
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            } else {
                                alertify.alert(res.message);
                            }
                        })
                    } else {
                        alertify.alert('没有商品的库存改变');
                    }

                }
            }
        });

        //PDF打印按钮
        //	    $("datatable-buttons_wrapper").ready(()=>{
        //	    		$("#datatable-buttons_wrapper .dt-buttons a").eq(3).hide();
        //	    		console.log("chengg")
        //	    })
    </script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });

    </script>
@endsection