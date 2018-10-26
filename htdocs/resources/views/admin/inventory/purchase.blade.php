@extends('admin/layout.app')




@section('add-item-modal-content')
    <!---- 添加模态框内容 ---->

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            采购人
        </label>
        <small class="text-muted">必填</small>

        <input type="text" id="name" class="form-control" placeholder="采购人姓名">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            供货商
        </label>
        <small class="text-muted">必填</small>

        <input type="text" id="supplier" class="form-control" placeholder="供货商名称或电话">
    </div>

    <div class="form-group col-lg-6">
        <label for="" class="control-label">
            订单金额
        </label>
        <small class="text-muted">必填</small>

        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-dollar"></i>
            </span>
            <input id="price" type="text" class="form-control" placeholder="0000.00">
        </div>

    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">必填</small>

        <textarea id="remark" class="form-control" name="" id="" cols="30" rows="4"></textarea>
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
                        <input class="form-control" type="text" placeholder="商品名称或SKU" id="searchString">
                        <span class="input-group-btn">
                            <button onclick="doPostSearch();" class="btn btn-primary waves-effect waves-light"
                                    type="button"><i class="fa fa-plus"></i></button>
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
                            <th>采购数量</th>
                        </tr>
                        </thead>

                        <tbody id="place">
                        {{--<td><img class="" height="60px; align=" middle" src="https://12buy.com/uploads/安慕希正面101118.jpg" alt=""></td>--}}
                        {{--<td><a href="" target="_blank">6907992512570</a></td>--}}
                        {{--<td><a href="" target="_blank">安慕希 希腊风味酸奶 原味 205g Ambrosial Greek Flavored Yoghurt 205g</a></td>--}}
                        {{--<td><input class="form-control" type="number" min="1" value="1"></td>--}}
                        </tbody>
                    </table>
                </div><!---- End 添加的商品 ---->

            </div><!---- end panel-body ---->
        </div>
    </div><!---- 商品列表 ---->

@endsection





@section('view-item-modal-content')
    <!---- 查看模态框内容 ---->
    <div class="row">

        <div class="col-md-12">
            <div class="pull-left">
                <h4>订单编号<br>
                    <strong id="numOrder"></strong>
                </h4>
            </div>
            <div class="pull-right">
                <p id="create"><strong>创建时间: </strong> Jun 15, 2015</p>
                <p id="puser"><strong>采购人: </strong>陈宝</p>
                <p id="orderStatus"><strong>订单状态: </strong><span class="label label-pink">Pending</span></p>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>商品图片</th>
                        <th>SKU</th>
                        <th>商品名称</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>总价</th>
                    </tr>
                    </thead>
                    <tbody id="orderDeal">


                    </tbody>
                </table>

                <div class="col-md-12">
                    <div class="col-md-3 col-md-offset-9">
                        <hr>
                        <h3 id="totalPrice" class="text-right"><i class="fa fa-dollar"></i> 100.00</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection





@section('content')

    <!---- 头部标题及导航链接 ---->
    <div class="row hidden_p">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">采购订单</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

    <!---- 搜索及按钮功能区域 ---->
    <div class="row hidden_p">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-12">
                            <!-- Add 按钮 -->
                            <button class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#add-item-modal" id="add-item-btn">Add <i class="fa fa-plus"></i>
                            </button><!-- End Add 按钮 -->
                        </div>

                        <div class="col-sm-12 m-t-10">
                            <!-- 批量操作按钮 -->
                            <div class="btn-group dropdown">
                                <button id="bulk-btn" type="button" class="btn btn-warning waves-effect waves-light">
                                    Bulk <i class="fa fa-check-square-o"></i></button>
                                <button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light"
                                        data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
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
    <div class="row hidden_p">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <!-- 数据表 -->
                    <table class="table table-bordered table-striped display" id="datatable-buttons">
                        <thead>
                        <tr>
                            <th>采购订单编号</th>
                            <th>采购人</th>
                            <th>创建时间</th>
                            <th>供货商</th>
                            <th>总金额</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($res as $item)
                            <tbody>
                            <tr>
                                <!---- 选择框及编号 ---->
                                <td>
                                    <div class="checkbox checkbox-success">
                                        <input id="item-checkbox-id" name="image_input" type="checkbox"
                                               value="{{$item->id}}" class="item-checkbox">
                                        <label for="item-checkbox-id">
                                            {{$item->order_no}}
                                        </label>
                                    </div>
                                </td><!---- 选择框及编号 ---->
                                <td> {{$item->name}}</td>
                                <td> {{$item->created_at}}</td>
                                <td> {{$item->supplier}}</td>
                                <td><i class="fa fa-dollar"></i>{{$item->total_price}}</td>
                                @if($item->status == 1)
                                    <td class="text-info">已下单</td>
                                @elseif($item->status == 2)
                                    <td class="text-info">待入库</td>
                                @else
                                    <td class="text-info">已取消</td>
                            @endif
                            <!-- 操作按钮 -->
                                <td class="actions">
                                    <!---- 查看按钮 ---->
                                    <button class="btn-sm btn-success waves-effect waves-light edit-item-btn"
                                            data-toggle="modal" data-target="#view-item-modal" data-id="{{$item->id}}"
                                            onclick="sse(this);"><i class="fa fa-eye"></i></button><!---- End 编辑按钮 ---->
                                    <!---- 删除按钮 ---->
                                    <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn"
                                            data-id="{{$item->id}}" onclick="del(this);"><i class="fa fa-trash"></i>
                                    </button><!---- End 删除按钮 ---->
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
    <div id="add-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-plus"></i> 新建采购订单</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('add-item-modal-content')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" id="save-item-btn"><i
                                class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 添加 ---->


    <!---- 查看 ---->
    <div id="view-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
            	<!--startprint-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-eye"></i> 查看采购订单</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('view-item-modal-content')
                    </div>
                </div>
                <!--endprint-->
                <div class="modal-footer">
                    <a href="##" id="Print" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                    <button type="button" onclick="dealStock(this);" data-status="1" id="sure"
                            class="btn btn-success waves-effect pull-left">确认入库
                    </button>
                    <button type="button" id="not" onclick="dealStock(this);" data-status="2"
                            class="btn btn-danger waves-effect pull-left">取消订单
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 查看 ---->
    <script type="text/javascript">
        $("#Print").click(
			function () {   
			    bdhtml=window.document.body.innerHTML;   
			    bdhtmll=window.document.body.innerHTML;   
			    sprnstr="<!--startprint-->";   
			    eprnstr="<!--endprint-->";   
			    prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);   
			    prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));   
			    window.document.body.innerHTML=prnhtml;  
			    window.print();   
			    window.location.reload()
			})
    </script>


    <!---- End 弹窗 ---->


    <script>
        //点击添加
        $('#save-item-btn').click(function () {

            $('#save-item-btn').removeAttr('disabled');
            window.obj = [];
            var i = 0;
            $("input[name='productNumber']").each(function () {

                if ($(this).val() != 0) {
                    window.obj.push({'product_id': $(this).attr('data-id'), "count": $(this).val()});
                    i += $(this).val();
                }


            });

            var datas = {
                'products': window.obj,
                'name': $('#name').val(),
                'supplier': $('#supplier').val(),
                'num': i,
                'price': $('#price').val(),
                'remark': $('#remark').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/shelves/deal/order', datas, function (res) {
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

                    $.get('/shelves/order/del', {'id': $(event).attr('data-id')}, function (res) {

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
                            </tr>`;

                        }

                    }
                    alertify.success('获取成功');

                    $('#place').append(datas);
                } else {
                    alertify.alert(res.message);
                }
            })
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

            $.get('/shelves/Batch/del', {'arr': arr}, function (res) {

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
            $.get('/shelves/order/deal', {'id': $(event).attr('data-id')}, function (res) {

                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        var datas = '', totalPrice = 0;
                        for (let i in res.data.purchase) {

                            var middle = (res.data.purchase[i].products.price * res.data.purchase[i].count).toFixed(2);
                            totalPrice += Number(middle);
                            datas += `<tr>
                                <td><img height="60px; align=" middle" src="${res.data.purchase[i].products.product_image}" alt="没有上传"></td>
                                <td >${res.data.purchase[i].products.sku}</td>
                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
                               <td>${res.data.purchase[i].count}</td>
    <td><i class="fa fa-dollar"></i>${res.data.purchase[i].products.price}</td>
     <td><i class="fa fa-dollar"></i>${middle}</td>
                            </tr>`;

                        }
                    }

                    switch (res.data.status) {
                        case '1' :
                            var word = '已下单';
                            break;
                        case '2' :
                            var word = '已入库';
                            break;
                        default :
                            var word = '已取消';
                    }
                    $('#numOrder').html(`${res.data.order_no}`);
                    $('#create').html(`<strong>创建时间: </strong> ${res.data.created_at}`);
                    $('#puser').html(`<strong>采购人: </strong> ${res.data.name}`);
                    $('#orderStatus').html(`<strong>订单状态: </strong><span class="label label-pink">${word}</span>`);
                    $('#totalPrice').html(`<i class="fa fa-dollar"></i> ${totalPrice}`);
                    $('#sure').attr('data-id', res.data.id);
                    $('#not').attr('data-id', res.data.id);
                    alertify.success('获取成功');

                    $('#orderDeal').html(datas);
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>

    <script>
        //处理订单
        var dealStock = function (event) {
            var datas = {
                'id': $(event).attr('data-id'),
                'status': $(event).attr('data-status')
            };
            $.get('/stock/put', datas, function (res) {
                if (res.status) {
                    alertify.success('处理成功');

                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>

@endsection