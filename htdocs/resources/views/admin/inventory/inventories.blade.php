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

        <input type="text" id="eorderId" class="form-control"  value="">

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
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">

                <div class="row">

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
                            <th>库存类型</th>
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
                            @if($item->status != 1)
                                <td>出库</td>
                            @else
                                <td>入库</td>
                            @endif
                            <td> {{$item->operator}}</td>
                            <td>{{$item->create}}</td>
                            <td>{{$item->pruchase_order_no}}
                            </td>
                            <!-- 操作按钮 -->
                            <td class="actions">
                                <!---- 查看按钮 ---->
                                <button class="btn-sm btn-success waves-effect waves-light edit-item-btn" data-toggle="modal" data-target="#view-item-modal"  data-id="{{$item->id}}" onclick="sse(this);"><i class="fa fa-eye"></i></button><!---- End 编辑按钮 ---->
                                <!---- 删除按钮 ---->
                                <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn" data-id="{{$item->id}}" onclick="del(this);"><i class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
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
    <!---- 查看 ---->
    <div id="view-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
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
                    <a href="##"id="Print" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a> 
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
        $.get('/enter/stock/order/deal', {'id': $(event).attr('data-id')}, function (res) {

            if (res.status) {
                if (res.data.length == 0) {
                    alertify.alert('搜索不到数据');
                    return;
                } else {
                    var datas = '';
                    for (let i in res.data.purchase) {

                        var midlle = res.data.purchase[i].overdue == null ? '未填写': '至'+res.data.purchase[i].overdue;
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

                $('#eoperator').attr("value",`${res.data.operator}`);
                $('#eorderId').attr("value",`${res.data.pruchase_order_no}`);
                $('#date').attr("value",`${res.data.create}`);
                $('#eremark').attr("value",`${res.data.remark}`);

                alertify.success('获取成功');

                $('#orderDeal').html(datas);
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
            } else {
                alertify.alert(res.message);
            }
        })
    }
</script>


@endsection