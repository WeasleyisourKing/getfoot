@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->

    <!-- 添加 Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">添加商品优惠券</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="type">优惠券类型<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <select class="form-control" id="type">
                                <option selected="selected" value="1">固定价格</option>
                                <option value="2">百分比</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">优惠券状态<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <select class="form-control" id="status">
                                <option selected="selected" value="1">启用</option>
                                <option value="2">禁用</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="number">优惠券张数（最多500张）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="number" id="number"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="code">优惠券代码（最多50字符）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="code" id="code"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="zn_name">优惠券名称（中）（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="zn_name" id="zn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="en_name">优惠券名称（英）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="en_name" id="en_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>


                    <div id="price">
                    <div class="form-group">
                        <label class="control-label" for="pnum">优惠券价格<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="pnum" id="pnum"
                                   class="form-control"
                                   value="0.00" required="required"/>
                        </div>
                    </div>

                        <div class="form-group">
                            <label class="control-label" for="threshold">优惠券最低购买价格<span
                                        style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="threshold" id="threshold"
                                       class="form-control"
                                       value="0.00" required="required"/>
                            </div>
                        </div>
                </div>

                    <div class="form-group" id="discount">
                        <label class="control-label" for="discount">优惠券折扣<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <select class="form-control" id="rcent">
                                <option selected="selected" value="5%">5% OFF</option>
                                <option selected="selected" value="10%">10% OFF</option>
                                <option selected="selected" value="15%">15% OFF</option>
                                <option selected="selected" value="20%">20% OFF</option>
                                <option selected="selected" value="25%">25% OFF</option>
                                <option selected="selected" value="30%">30% OFF</option>
                                <option selected="selected" value="35%">35% OFF</option>
                                <option selected="selected" value="40%">40% OFF</option>
                                <option selected="selected" value="45%">45% OFF</option>
                                <option selected="selected" value="50%">50% OFF</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="sa-save" data-id=""
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 编辑 Modal -->
    <div id="edit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑商品优惠券</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">优惠券类型<span
                                    style="color:red;">＊</span></label>
                        <div class="controls" id="etype1">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">优惠券状态<span
                                    style="color:red;">＊</span></label>
                        <div class="controls" id="estatus1">

                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label" for="enumber">优惠券次数（最多500）<span--}}
                                    {{--style="color:red;">＊</span></label>--}}
                        {{--<div class="controls">--}}
                            {{--<input type="text" name="enumber" id="enumber"--}}
                                   {{--class="form-control"--}}
                                   {{--value="" required="required"/>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="control-label" for="ecode">优惠券代码（最多50字符）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ecode" id="ecode"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ezn_name">优惠券名称（中）（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ezn_name" id="ezn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="een_name">优惠券名称（英）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="een_name" id="een_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div id="eprice">
                        <div class="form-group" >
                            <label class="control-label" for="epnum">优惠券价格<span
                                        style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="epnum" id="epnum"
                                       class="form-control"
                                       value="0.00" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ethreshold">优惠券最低购买价格<span
                                        style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="ethreshold" id="ethreshold"
                                       class="form-control"
                                       value="0.00" required="required"/>
                            </div>
                        </div>
                    </div>


                    <div class="form-group" id="ediscount">
                        <label class="control-label" for="ediscount">优惠券折扣<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <select class="form-control" id="ercent">
                                <option selected="selected" value="5%">5% OFF</option>
                                <option selected="selected" value="10%">10% OFF</option>
                                <option selected="selected" value="15%">15% OFF</option>
                                <option selected="selected" value="20%">20% OFF</option>
                                <option selected="selected" value="25%">25% OFF</option>
                                <option selected="selected" value="30%">30% OFF</option>
                                <option selected="selected" value="35%">35% OFF</option>
                                <option selected="selected" value="40%">40% OFF</option>
                                <option selected="selected" value="45%">45% OFF</option>
                                <option selected="selected" value="50%">50% OFF</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="edit-save" data-id="" onclick="efunb(this);"
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 查看 Modal -->
    <div id="see" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">折扣码列表</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class=" col-md-2 col-lg-2 exce"> 序号</th>
                                <th class=" col-md-3 col-lg-3 exce"> 是否使用</th>
                                <th class=" col-md-4 col-lg-4 exce"> 折扣码</th>
                                <th class=" col-md-3 col-lg-3 exce"> 订单号</th>
                            </tr>
                            </thead>
                            <tbody id="info">

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">产品管理</h4>
            <ol class="breadcrumb pull-right">
                <li class="active"><a href="#">Admin Panel</a></li>
                <li class="active"><a href="#">产品管理</a></li>
                <li class="active">优惠活动</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">优惠券管理</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <!-- 搜索 -->
                <form class="form-horizontal" role="form">

                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal"
                                    data-target="#add">
                                <i class="fa fa-plus"></i> Add
                            </button>


                        </div>

                        {{--<div class="col-sm-3 col-md-offset-6">--}}
                            {{--<div class="input-group">--}}
                                {{--<input id="example-input2-group2" name="example-input2-group2" class="form-control"--}}
                                       {{--placeholder="Search" type="email">--}}
                                {{--<span class="input-group-btn">--}}
                                                    {{--<button type="button"--}}
                                                            {{--class="btn waves-effect waves-light btn-primary">--}}
                                                        {{--<i class="fa fa-search"></i>--}}
                                                    {{--</button>--}}
                                                    {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <!-- 搜索 -->

                </form>

                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">优惠券类列表

                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="btn-group col-md-2">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="true">{{$limit}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="select" href="">20条</a></li>
                                        <li><a id="select10" href="">50条</a></li>
                                        <li><a id="select15" href="">100条</a></li>
                                        {{--<li><a id="select20" href="">20条</a></li>--}}
                                    </ul>
                                </div>
                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="col-md-2 col-lg-2 exce">名称</th>
                                            <th class="col-md-1 col-lg-1 exce">优惠券类型</th>
                                            <th class="col-md-1 col-lg-1 exce">总数量</th>
                                            <th class="col-md-1 col-lg-1 exce">剩余数量</th>
                                            <th class="col-md-2 col-lg-2 exce">优惠券代码</th>
                                            <th class="col-md-1 col-lg-1 exce">
                                                {{--<th class="col-md-2 col-lg-2 exce">状态</th>--}}
                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-default dropdown-toggle waves-effect"
                                                            data-toggle="dropdown" aria-expanded="false">{{$status}}
                                                        <span
                                                                class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="statusAll" href="javascript:void(0);">全部状态</a></li>
                                                        <li><a id="statusShow" href="javascript:void(0);">启用</a></li>
                                                        <li><a id="statusHide" href="javascript:void(0);">禁用</a></li>

                                                    </ul>
                                                </div>
                                            </th>
                                            <th class="col-md-2 col-lg-2 exce"> 创建时间</th>
                                            <th class="col-md-2 col-lg-2 exce" class="td-actions"> 操作</th>
                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $key => $item)
                                            <tr>

                                                <td class="exce">{{ $item->zn_name }} <br/>{{ $item->en_name }}</td>

                                                @if ($item->type != 1)
                                                    <td class="exce">百分比<br/>{{ $item->rcent }} </td>
                                                @else
                                                    <td class="exce">固定价格<br/>${{ $item->rcent }}</td>
                                                @endif

                                                <td class="exce">{{ $item->stock }}</td>
                                                <td class="exce">{{ count($item->info) }}</td>
                                                <td class="exce">{{ $item->code }}</td>
                                                @if ($item->status == 1)
                                                    <td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i>
                                                    </td>
                                                @else
                                                    <td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i>
                                                    </td>
                                                @endif
                                                <td class="exce">{{ $item->created_at }}</td>

                                                <td class="exce">

                                                    <a title="查看信息" class="btn btn-small btn-success" onclick="see(this);"
                                                       href="javascript:void(0);" data-id="{{$item->id}}">
                                                    <i class="icon fa fa-external-link"> </i>
                                                    </a>
                                                    <a title="修改信息" onclick="edit(this);" class="btn btn-small btn-info"
                                                       data-id="{{$item->id}}" data-zname="{{$item->zn_name}}"
                                                       data-ename="{{$item->en_name}}" data-type="{{$item->type}}"
                                                       data-stock="{{$item->stock}}" data-rcent="{{$item->rcent}}"
                                                       data-status="{{$item->status}}"  data-code="{{$item->code}}"
                                                       data-threshold="{{$item->threshold}}"
                                                       href="javascript:void(0);">
                                                        <i class="icon fa fa-pencil"> </i>
                                                    </a>

                                                    @foreach ($data as $k => $v)
                                                        @if ($v['id'] == $item['id'])
                                                            @if ($v['sign'] == 0)
                                                                <a title="删除" class="btn btn-small btn-danger"
                                                                   href="javascript:void(0);" data-id="{{$item->id}}"
                                                                   onclick="del(this);">
                                                                    <i class="icon fa fa-trash-o"> </i>
                                                                </a>
                                                            @else
                                                                <a disabled="disabled" title="删除"
                                                                   class="btn btn-small btn-danger"
                                                                   href="javascript:return false;"
                                                                   onclick="return false;"
                                                                   style="cursor: not-allowed;">
                                                                    <i class="icon fa fa-trash-o"> </i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div style="clear: both;text-align: center;">
                                        {{ $data->links() }}
                                    </div>

                                </div>
                                @if(!$data->count())
                                    <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 表单 -->


                <!-- End Form -->
            </div>
        </div>
    </div>

    <script>

        var url = window.location.pathname;
        strs = url.split("/");

        //替换limit为5
        strs.splice(6, 1, 20);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(6, 1, 50);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(6, 1, 100);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
        //        strs.splice(6, 1, 20);
        //        var val3 = strs.join('/');
        //        $('#select20').attr('href', val3);

        var url = window.location.pathname;
        strs = url.split("/");

        //替换status为5
        strs.splice(4, 1, -1);
        var val4 = strs.join('/');
        $('#statusAll').attr('href', val4);


        //替换status为5
        strs.splice(4, 1, 1);
        var val5 = strs.join('/');
        $('#statusShow').attr('href', val5);


        //替换status为5
        strs.splice(4, 1, 2);
        var val6 = strs.join('/');
        $('#statusHide').attr('href', val6);
    </script>

    <script>
        if ($('#type').val() != 1) {

            $('#discount').show();
            $('#price').hide();
        } else {
            $('#discount').hide();
            $('#price').show();
        }
        //百分比
        $('#type').change(function () {
            if ($('#type').val() != 1) {

                $('#discount').show();
                $('#price').hide();
            } else {
                $('#discount').hide();
                $('#price').show();
            }
        })


    </script>

    <script>
        //点击添加
        $('#sa-save').click(function () {

            var datas = {
                'zn_name': $('#zn_name').val(),
                'en_name': $('#en_name').val(),
                'number': $('#number').val(),
                'type': $('#type').val(),
                'code':$('#code').val(),
                'status': $('#status').val(),
                '_token': '{{csrf_token()}}'
            };
            //百分比
            if ($('#type').val() != 1) {
                datas.rcent = $('#rcent').val();

            } else {
                datas.threshold = $('#threshold').val();
                datas.price = $('#pnum').val();
            }

            $.post('/discount/insert', datas, function (res) {
                if (res.status) {
                    alertify.success('创建优惠码类成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })

        })

        //显示
        var edit = function (event) {

            $('#ezn_name').val($(event).attr('data-zname'));
            $('#een_name').val($(event).attr('data-ename'));
            $('#ecode').val($(event).attr('data-code'));

            if ($(event).attr('data-type') != 1) {
                //off
                var data = `<select class="form-control" id="etypes">
                        <option value="1">固定价格</option>
                        <option selected="selected"  value="2">百分比</option>
                        </select>`;
            } else {
                $('#ethreshold').val($(event).attr('data-threshold'));
                //固定
                var data = `<select class="form-control" id="etypes">
                        <option selected="selected" value="1">固定价格</option>
                        <option value="2">百分比</option>
                        </select>`;
            }
            if ($(event).attr('data-status') != 1) {
                //off
                var datas = `<select class="form-control" id="estatus">
                                        <option  value="1">启用</option>
                                        <option selected="selected" value="2">禁用</option>
                                    </select>`;
            } else {
                //国定
                var datas = `<select class="form-control" id="estatus">
                                        <option selected="selected" value="1">启用</option>
                                        <option  value="2">禁用</option>
                                    </select>`;
            }

            $('#etype1').html(data);
            $('#estatus1').html(datas);
            //百分比
            $('#etypes').change(function () {
                if ($('#etypes').val() != 1) {

                    $('#ediscount').show();
                    $('#eprice').hide();
                } else {
                    $('#ediscount').hide();
                    $('#eprice').show();
                }
            })
            $('#edit-save').attr('data-stock', $(event).attr('data-stock'));
            $('#edit-save').attr('data-id', $(event).attr('data-id'));

            if ($('#etypes').val() != 1) {

                $('#ediscount').show();
                $('#eprice').hide();
                $('#ercent').val($(event).attr('data-rcent'));
                $('#epnum').val('0.00');
            } else {
                $('#ediscount').hide();
                $('#eprice').show();
                $('#epnum').val($(event).attr('data-rcent'));
            }
            $('#edit').modal('toggle');
        }
        //修改
        var efunb = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'zn_name': $('#ezn_name').val(),
                'en_name': $('#een_name').val(),
                'number': $(event).attr('data-stock'),
                'type': $('#etypes').val(),
                'code': $('#ecode').val(),
                'status': $('#estatus').val(),
                '_token': '{{csrf_token()}}'
            };
            //百分比
            if ($('#etypes').val() != 1) {
                datas.rcent = $('#ercent').val();

            } else {
                datas.threshold = $('#ethreshold').val();
                datas.price = $('#epnum').val();
            }

            $.post('/discount/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改优惠码类成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }


        //删除
        var del = function (event) {

            alertify.confirm("确认框", function (e) {
                if (e) {

                    $.get('/discount/del', {'id': $(event).attr('data-id')}, function (res) {

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
        var see = function (event) {


            $.get('/discount/see', {'id': $(event).attr('data-id')}, function (res) {

                if (res.status) {

                        var j = 1,datas = '';
                        for (let i in res.data) {

                            var middle = res.data[i].status != 2 ? `<td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i></td>` : `<td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i></td>`;

                            var order = res.data[i].order != null ? `<td class="exce">${res.data[i].order.order_no}</td>` :  `<td class="exce"> </td>`;
                            datas += `<tr><td class="exce">${j}</td>`+ middle + `
                                    <td class="exce">${res.data[i].code}</td>
                                    ` + order + `</tr>`;

                            ++j;
                        }

                    $('#info').html(datas);
                    $('#see').modal('toggle');
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>
@endsection
