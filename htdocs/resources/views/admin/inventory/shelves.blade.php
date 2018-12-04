@extends('admin/layout.app')




@section('add-item-modal-content')
    <!---- 添加模态框内容 ---->

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架名称
        </label>

        <input type="text" id="name" class="form-control" placeholder="零食货架">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架编号
        </label>

        <input type="text" id="number" class="form-control" placeholder="货架编号">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架状态
        </label>

        <select class="form-control" name="" id="status">
            <option value="1">已满</option>
            <option value="2">未满</option>
        </select>
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">选填</small>

        <textarea class="form-control" id="remark" cols="30" rows="4"></textarea>
    </div>
@endsection



@section('edit-item-modal-content')
    <!---- 编辑模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架名称
        </label>

        <input id="ename" type="text" class="form-control" placeholder="零食货架">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架编号
        </label>

        <input id="enumber" type="text" class="form-control" placeholder="货架编号">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架状态
        </label>

        <select class="form-control" name="" id="estatus">
            {{--<option value="1">已满</option>--}}
            {{--<option value="2">未满</option>--}}
        </select>
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">选填</small>

        <textarea class="form-control" id="eremark" cols="30" rows="4"></textarea>
    </div>
@endsection





@section('content')

    <!---- 头部标题及导航链接 ---->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">货架管理</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

    <!---- 搜索及按钮功能区域 ---->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-2">
                            <!-- Add 按钮 -->
                            <button class="btn btn-block btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#add-item-modal" id="add-item-btn">添加货架<i class="fa fa-plus"></i>
                            </button><!-- End Add 按钮 -->
                        </div>

                        <div class="col-lg-10">
                            <!-- 搜索 -->
                            <div class="input-group">
                                <input type="text" id="example-input1-group2" name="example-input1-group2"
                                       class="form-control input" placeholder="Search">
                                <span class="input-group-btn">
                                <button onclick="search();" type="button"
                                        class="btn waves-effect waves-light btn-primary w-md"><i
                                            class="fa fa-search"></i></button>
                            </span>
                            </div><!-- End 搜索 -->
                        </div>

                    </div><!---- End row ---->


                </div>
            </div>
        </div>
    </div><!---- End 搜索及按钮功能区域  ---->
    <div class="row">
        <!---- 货架列表 ---->
    @foreach($res as $item)

        <!---- 货架 ---->
            <div class="col-sm-4 col-lg-3 panel_box">
                <div class="panel">
                    <div class="panel-body">

                        <div class="row text-center">
                            <div class="col-lg-12">
                                <!---- 货架名称 ---->
                                <h4>{{$item->name}}</h4>

                                <!---- 货架位置/编号 ---->
                                <h5>{{$item->number}}</h5>

                                <!---- 货架状态 ---->
                                <h6>{{($item->status) != 1 ? '未满' : '已满'}}</h6>
                            </div>


                        </div><!---- End row ---->

                    </div>

                    <div class="panel-footer">
                        <!---- 编辑按钮 ---->
                        <button class="btn-sm btn-info waves-effect waves-light edit-item-btn" data-toggle="modal"
                                data-target="#edit-item-modal" onclick="edit(this);"
                                data-id="{{$item->id}}" data-name="{{$item->name}}" data-remark="{{$item->remark}}"
                                data-number="{{$item->number}}" data-status="{{$item->status}}"><i
                                    class="fa fa-edit"></i></button><!---- End 编辑按钮 ---->
                        <!---- 删除按钮 ---->
                        <button data-id="{{$item->id}}"
                                class="btn-sm btn-danger waves-effect waves-light delete-item-btn" onclick="del(this);">
                            <i class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
                    </div>
                </div>
            </div><!---- End 货架 ---->


            <!---- End 货架列表 ---->
        @endforeach
    </div>




    <!---- 弹窗 ---->
    <!---- 添加 ---->
    <div id="add-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-plus"></i> 新建一个货架</h3>
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


    <!---- 编辑 ---->
    <div id="edit-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-pencil"></i> 编辑货架</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('edit-item-modal-content')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" id="edit-save"
                            onclick="efunb(this);"><i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 编辑 ---->

    <!---- End 弹窗 ---->

    <script>
        //点击添加
        $('#save-item-btn').click(function () {

            var datas = {
                'id': 1,
                'name': $('#name').val(),
                'number': $('#number').val(),
                'status': $('#status').val(),
                'remark': $('#remark').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/shelves/insert', datas, function (res) {
                if (res.status) {
                    alertify.success('创建货架成功');
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
            $('#ename').val($(event).attr('data-name'));
            $('#enumber').val($(event).attr('data-number'));
            $('#eremark').text($(event).attr('data-remark'));
            $('#edit-save').attr('data-id', $(event).attr('data-id'));

            if (1 != $(event).attr('data-status')) {

                var data = ' <option value="1">已满</option><option value="2" selected="selected">未满</option>'
            } else {
                var data = ' <option value="1" selected="selected">已满</option><option value="2">未满</option>'
            }
            $('#estatus').html(data);
//        $('#edit-item-modal').modal('toggle');
        }
        //修改
        var efunb = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'name': $('#ename').val(),
                'number': $('#enumber').val(),
                'status': $('#estatus').val(),
                'remark': $('#eremark').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/shelves/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改货架成功');
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

            alertify.confirm("确认删除吗？", function (e) {
                if (e) {

                    $.get('/shelves/del', {'id': $(event).attr('data-id')}, function (res) {

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
    <!--搜索功能-->
    <script>
        $("#example-input1-group2").bind('input propertychange', function () {
            var str = $(this).val();
            var name = $(".panel_box h4");
            if ($(this).val() == "") {
                $(".panel_box").show();
            } else {
                $(".panel_box").hide();
                for (let i = 0; i < name.length; i++) {
                    console.log(name.eq(i).html().indexOf(str))
                    if (name.eq(i).html().indexOf(str) != -1) {
                        $(".panel_box").eq(i).show()
                    }
                }
            }
        })
    </script>


@endsection
