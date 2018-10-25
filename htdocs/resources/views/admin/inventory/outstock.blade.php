@extends('admin/layout.app')




@section('add-item-modal-content')
<!---- 添加模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            操作人
        </label> <small class="text-muted">必填</small>

        <input type="text" id="operator" class="form-control" placeholder="操作人姓名">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            创建时间
        </label>

        <input id="NowDate" type="text" class="form-control" readonly="readonly" value="当前时间">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            出库类型
        </label>
    
        <input type="text" class="form-control" readonly="readonly" value="手动出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">出库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            关联订单
        </label> 
        <small class="text-muted">选填</small>

        <input type="text" id="orderId" class="form-control" placeholder="关联的订单号码">
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label> 
        <small class="text-muted">必填</small>

        <textarea class="form-control" id="remark" cols="30" rows="4"></textarea>
    </div>
    <!---- 商品列表 ---->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">添加商品</h4> 
            </div>
            <div class="panel-body">
                <!---- 搜索并添加商品 ---->
                <div class="form-group col-lg-4">
                    <div class="input-group">
                        <input class="form-control" id="searchString" type="text" placeholder="商品名称或SKU">
                        <span class="input-group-btn">
                            <button onclick="doPostSearch();" class="btn btn-primary waves-effect waves-light" type="button"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div><!---- End 搜索并添加商品 ---->

                <!---- 添加的商品 ---->
                <div>
                    <table class="table table-bordered table-striped display">
                        <thead>
                            <tr>
                                <th>商品图片</th>
                                <th>SKU</th>
                                <th>商品名称</th>
                                <th>出库数量</th>
                                <th>批次过期时间 <small class="text-muted">选填</small></th>
                            </tr>
                        </thead>

                        <tbody id="place">
                            {{--<td><img class="" height="60px; align=" middle" src="https://12buy.com/uploads/安慕希正面101118.jpg" alt=""></td>--}}
                            {{--<td><a href="" target="_blank">6907992512570</a></td>--}}
                            {{--<td><a href="" target="_blank">安慕希 希腊风味酸奶 原味 205g Ambrosial Greek Flavored Yoghurt 205g</a></td>--}}
                            {{--<td><input class="form-control" type="number" max="-1" value="-1"></td>--}}
                            {{--<td><input id="datepicker" class="form-control" type="text"></td>--}}
                        </tbody>
                    </table>
                </div><!---- End 添加的商品 ---->

            </div><!---- end panel-body ---->
        </div>
    </div><!---- 商品列表 ---->

@endsection





@section('view-item-modal-content')
<!---- 查看模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            操作人
        </label>

        <input type="text" id="eoperator" class="form-control" readonly="readonly" value="陈宝">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            创建时间
        </label>

        <input type="text" id="date" class="form-control" readonly="readonly" value="2018-10-23 9:30:21">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            出库类型
        </label>
    
        <input type="text" class="form-control" readonly="readonly" value="手动出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">出库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            关联订单
        </label>
        <input type="text" id="eorderId" class="form-control"  value="">

        {{--<a class="form-control">无</a>--}}
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>

        <textarea class="form-control" id="eremark" cols="30" rows="4" readonly="readonly">商品已过保质期</textarea>
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
                        {{--<td><p class="text-center text-danger">-10</p></td>--}}
                        {{--<td><p class="text-center">130</p></td>--}}
                        {{--<td>已过期</td>--}}
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
            <li class="active">出库</li>
        </ol>
    </div>
</div><!---- End 头部标题及导航链接 ---->

<!---- 搜索及按钮功能区域 ---->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">

                <div class="row">

                    <div class="col-lg-12">
                        <!-- Add 按钮 -->
                        <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#add-item-modal" id="add-item-btn">Add <i class="fa fa-plus"></i></button><!-- End Add 按钮 -->
                    </div>

                    <div class="col-sm-12 m-t-10">
                        <!-- 批量操作按钮 -->
                        <div class="btn-group dropdown">
                            <button id="bulk-btn" type="button" class="btn btn-warning waves-effect waves-light">Bulk <i class="fa fa-check-square-o"></i></button>
                            <button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="">打印</a></li>
                                <li class="divider"></li>
                                <li class="text-danger"><a href="javascript:viod(0);" id="delete_btn">删除</a></li>
                            </ul>
                        </div>
                        <!-- 批量操作按钮 -->
                    </div>

                </div><!---- End row ---->

            </div>
        </div>
    </div>
</div><!---- End 搜索及按钮功能区域  ---->

<!---- 库存列表 ---->
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-body">
                <!-- 数据表 -->
                <table class="table table-bordered table-striped display" id="datatable-buttons">
                    <thead>
                        <tr>
                            <th>库存编号</th>
                            <th>出库类型</th>
                            <th>操作人</th>
                            <th>创建时间</th>
                            <th>关联订单</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($res as $item)
                        <tr>
                            <!---- 选择框及编号 ---->
                            <td>
                                <div class="checkbox checkbox-success">
                                    <input id="item-checkbox-id" type="checkbox" name="image_input" value="{{$item->id}}" class="item-checkbox">
                                    <label for="item-checkbox-id">
                                        {{$item->order_no}}
                                    </label>
                                </div>
                            </td><!---- 选择框及编号 ---->
                            @if($item->type != 1)
                                <td>手动</td>
                            @else
                                <td>自动</td>
                            @endif
                            <td> {{$item->operator}}</td>
                            <td>{{$item->create}}</td>
                            <td>{{$item->pruchase_order_no}}
                            </td>
                            <!-- 操作按钮 -->
                            <td class="actions">
                                <!---- 查看按钮 ---->
                                <button data-id="{{$item->id}}" onclick="sse(this);" class="btn-sm btn-success waves-effect waves-light edit-item-btn" data-toggle="modal" data-target="#view-item-modal" id=""><i class="fa fa-eye"></i></button><!---- End 编辑按钮 ---->
                                <!---- 删除按钮 ---->
                                <button data-id="{{$item->id}}" onclick="del(this);" class="btn-sm btn-danger waves-effect waves-light delete-item-btn" id=""><i class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
                            </td><!-- 操作按钮 -->
                        </tr>
                    @endforeach
                        
                    </tbody>
                </table><!-- End 数据表 -->
            </div>
        </div>
    </div>
</div><!---- End 库存列表 ---->





<!---- 弹窗 ---->
    <!---- 添加 ---->
    <div id="add-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 80%"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                    <h3 class="modal-title"><i class="fa fa-plus"></i> 新建一条出库记录</h3> 
                </div> 
                <div class="modal-body"> 
                    <div class="row"> 
                        @yield('add-item-modal-content')
                    </div> 
                </div> 
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                    <button type="button" class="btn btn-info waves-effect waves-light" id="save-item-btn"><i class="fa fa-save"></i> Save</button> 
                </div> 
            </div> 
        </div>
    </div><!---- End 添加 ---->


    <!---- 查看 ---->
    <div id="view-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 80%"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                    <h3 class="modal-title"><i class="fa fa-eye"></i> 查看记录</h3> 
                </div> 
                <div class="modal-body"> 
                    <div class="row"> 
                        @yield('view-item-modal-content')
                    </div> 
                </div> 
                <div class="modal-footer"> 
                    <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a> 
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
                </div> 
            </div> 
        </div>
    </div><!---- End 查看 ---->



<!---- End 弹窗 ---->

<script>

    //点击添加
    $('#save-item-btn').click(function () {

        $('#save-item-btn').removeAttr('disabled');
        window.obj = [];
        window.objs = [];
        var i = 0;
        $("input[name='productNumber']").each(function () {

            if ($(this).val() != 0) {
                window.obj.push({
                    'product_id': $(this).attr('data-id'),
                    "count": $(this).val()
                });
                window.objs.push({
                    'product_id': $(this).attr('data-id'),
                    'overdue' : $(this).parent().next().find('input').val(),
                    "count": $(this).val()
                });
                i += Number($(this).val());
            }


        });

        var datas = {
            'products': window.obj,
            'uproducts':window.objs,
            'operator': $('#operator').val(),
            'num': i,
            'orderId': $('#orderId').val(),
            'remark': $('#remark').val(),
            '_token': '{{csrf_token()}}'
        };

        $.post('/out/stock/deal/order', datas, function (res) {
            if (res.status) {
                alertify.success('创建采购订单成功');
                $('#save-item-btn').attr('disabled', "false");
                window.obj = [];
                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                alertify.alert(res.message);
                $('#save-item-btn').removeAttr('disabled');
            }
        })

    })
    //删除
    var del = function (event) {

        alertify.confirm("确认框", function (e) {
            if (e) {

                $.get('/enter/stock/order/del', {'id': $(event).attr('data-id')}, function (res) {

                    if (res.status) {
                        alertify.success("删除成功");

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        alertify.alert(res.message);
                    }
                })
            }

        });
    }

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
        $.get('/out/stock/order/deal', {'id': $(event).attr('data-id')}, function (res) {

            if (res.status) {
                if (res.data.length == 0) {
                    alertify.alert('搜索不到数据');
                    return;
                } else {
                    var datas = '';
                    for (let i in res.data.purchase) {

                        var midlle = res.data.purchase[i].overdue == null ? '未填写': '至'+res.data.purchase[i].overdue;
                        datas += `<tr>
                                <td><img height="60px; align=" middle" src="${res.data.purchase[i].products.product_image}" alt="没有上传"></td>
                                <td >${res.data.purchase[i].products.sku}</td>
                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
                                <td><p class="text-center text-success">-${res.data.purchase[i].count}</p></td>
                                 <td><p class="text-center">${res.data.purchase[i].products.stock}</p></td>
                                 <td>${midlle}</td>
                            </tr>`;

                    }
                    {{--<td><img class="" height="60px; align=" middle" src="https://12buy.com/uploads/安慕希正面101118.jpg" alt=""></td>--}}
                    {{--<td><a href="" target="_blank">6907992512570</a></td>--}}
                    {{--<td><a href="" target="_blank">安慕希 希腊风味酸奶 原味 205g Ambrosial Greek Flavored Yoghurt 205g</a></td>--}}
                    {{--<td><p class="text-center text-danger">-10</p></td>--}}
                    {{--<td><p class="text-center">130</p></td>--}}
                    {{--<td>已过期</td>--}}
                }

                $('#eoperator').val(`${res.data.operator}`);
                $('#eorderId').val(`${res.data.pruchase_order_no}`);
                $('#date').val(`${res.data.create}`);
                $('#eremark').val(`${res.data.remark}`);

                alertify.success('获取成功');

                $('#orderDeal').html(datas);
            } else {
                alertify.alert(res.message);
            }
        })
    }
</script>

<script>
    //搜索库存
    function doPostSearch() {

        $.get('/stock/search', {'value': $('#searchString').val()}, function (res) {

            if (res.status) {
                if (res.data.length == 0) {
                    alertify.alert('搜索不到数据');
                    return;
                } else {
                    var datas = '';
                    for (let i in res.data) {

                        datas += `<tr>
                                <td><img height="60px; align=" middle" src="${res.data[i].product_image}" alt="没有上传"></td>
                                <td >${res.data[i].sku}</td>
                                <td>${res.data[i].zn_name}${res.data[i].en_name}</td>
                                <td><input class="form-control" data-id="${res.data[i].id}"  name='productNumber'  type="text" min="0" value="0"></td>
                                <td><input class="datepicker" class="form-control" type="text" data-date-format="yyyy-mm-dd"></td>
                            </tr>`;

                    }
                }

                alertify.success('获取成功');

                $('#place').append(datas);
                $('.datepicker').datepicker()
            } else {
                alertify.alert(res.message);
            }
        })
    }


    var mydate = new Date();
    $("#NowDate").val(`${mydate.getFullYear()}-${mydate.getMonth() + 1}-${mydate.getDate()}`)

</script>
@endsection