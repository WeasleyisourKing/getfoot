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
                    <h4 class="modal-title">添加管理员</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">管理员名称（最多15字）<span style="color:red;">＊</span> </label>
                        <input type="text" id="name" class="form-control" required="required" value=""/>

                    </div>

                    <div class="form-group">
                        <label class="control-label">是否可用<span style="color:red;">＊</span></label>
                        <select class="form-control" id="status">
                            <option value="1">是</option>
                            <option value="2">否</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">管理角色<span style="color:red;">＊</span></label>
                        <select class="form-control" id="role">
                            @foreach($role as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">管理员密码 <span style="color:red;">＊</span></label>
                        <input type="password" id="passwd" class="form-control" required="required" value=""/>

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


    <!-- 编辑 Modal -->

    <div id="edit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">管理员基本信息修改</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ename">角色名称（最多15字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ename" id="ename"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">是否启用<span style="color:red;">＊</span></label>
                        <select class="form-control" id="estatus">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">管理角色<span style="color:red;">＊</span></label>
                        <select class="form-control" id="erole">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">密码 </label>
                        <input type="password" id="epasswd" class="form-control" required="required" value=""/>

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

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">用户管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">用户管理</a></li>
                <li class="active">管理员管理</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">管理员管理</h3></div>
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
                            <h3 class="panel-title">管理员列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="btn-group col-md-2">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="true">{{$limit}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="select" href="">5条</a></li>
                                        <li><a id="select10" href="">10条</a></li>
                                        <li><a id="select15" href="">15条</a></li>
                                        <li><a id="select20" href="">20条</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="col-md-2 col-lg-2 exce"> 管理员名称</th>
                                            <th class="col-md-2 col-lg-2 exce">
                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-default dropdown-toggle waves-effect"
                                                            data-toggle="dropdown" aria-expanded="false">{{$type}}
                                                        <span
                                                                class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="roleAll" href="javascript:void(0);">全部角色</a></li>
                                                        @foreach($role as $item)
                                                            <li><a onclick="ofun(this)" id="role{{$item->id}}"
                                                                   data-id="{{$item->id}}"
                                                                   href="javascript:void(0);">{{$item->name}}</a></li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </th>

                                            <th class="col-md-2 col-lg-2 exce"> 最后登录时间</th>
                                            <th class="col-md-2 col-lg-2 exce"> 最后登录ip</th>
                                            <th class="col-md-2 col-lg-2 exce">
                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-default dropdown-toggle waves-effect"
                                                            data-toggle="dropdown" aria-expanded="false">{{$status}}
                                                        <span
                                                                class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="statusAll" href="javascript:void(0);">全部状态</a></li>
                                                        <li><a id="statusShow" href="javascript:void(0);">可用</a></li>
                                                        <li><a id="statusHide" href="javascript:void(0);">禁用</a></li>

                                                    </ul>
                                                </div>
                                            </th>
                                            <th class="col-md-2 col-lg-2 exce" class="td-actions"> 操作</th>
                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $item)
                                            <tr>

                                                <td class="exce">{{ $item->username }}</td>
                                                <td class="exce">{{ $item->manys->name }}</td>
                                                <td class="exce">{{ $item->login_time }}</td>
                                                <td class="exce">{{ $item->last_ip }}</td>
                                                @if ($item->status == 1)
                                                    <td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i></td>
                                                @else
                                                    <td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i></td>
                                                @endif
                                                <td class="exce">

                                                    @if ($item->id != 1)
                                                        <a title="修改信息" onclick="edit(this);"
                                                           class="btn btn-small btn-info"
                                                           data-id="{{$item->id}}"
                                                           data-name="{{$item->username}}" data-role="{{$item->role}}"
                                                           data-status="{{$item->status}}"
                                                           href="javascript:void(0);">
                                                            <i class="icon fa fa-pencil"> </i>
                                                        </a>
                                                        <a title="删除" class="btn btn-small btn-danger"
                                                           href="javascript:void(0);" data-id="{{$item->id}}"
                                                           onclick="del(this);">
                                                            <i class="icon fa fa-trash-o"> </i>
                                                        </a>
                                                    @else
                                                        <a disabled="disabled" title="修改信息"
                                                           href="javascript:return false;" onclick="return false;"
                                                           class="btn btn-small btn-info"
                                                           data-id="{{$item->id}}" data-name="{{$item->name}}"
                                                           style="cursor: not-allowed;"
                                                        >
                                                            <i class="icon fa fa-pencil"> </i>
                                                        </a>
                                                        <a disabled="disabled" title="删除"
                                                           class="btn btn-small btn-danger"
                                                           href="javascript:return false;" onclick="return false;"
                                                           data-id="{{$item->id}}"
                                                           style="cursor: not-allowed;">
                                                            <i class="icon fa fa-trash-o"> </i>
                                                        </a>
                                                    @endif


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
        strs.splice(8, 1, 5);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(8, 1, 10);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(8, 1, 15);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
        strs.splice(8, 1, 20);
        var val3 = strs.join('/');
        $('#select20').attr('href', val3);

        var url = window.location.pathname;
        strs = url.split("/");

        //替换status为5
        strs.splice(6, 1, -1);
        var val4 = strs.join('/');
        $('#statusAll').attr('href', val4);


        //替换status为5
        strs.splice(6, 1, 1);
        var val5 = strs.join('/');
        $('#statusShow').attr('href', val5);


        //替换status为5
        strs.splice(6, 1, 2);
        var val6 = strs.join('/');
        $('#statusHide').attr('href', val6);

        var url = window.location.pathname;
        strs = url.split("/");

        //替换status为5
        strs.splice(4, 1, -1);
        var val7 = strs.join('/');
        $('#roleAll').attr('href', val7);


        //点击角色
        var ofun = function (event) {
            strs.splice(4, 1, $(event).attr('data-id'));
            window.location.href = strs.join('/');
        }

    </script>


    <script>
        //点击添加
        $('#sa-save').click(function () {


            //验证密码参数
            res = check({'password': $('#passwd').val()});
            if (!res.status) {
                alertify.alert('密码中必须包含字母、数字、特称字符，至少8个字符');
                return;
            }
            var datas = {
                'name': $('#name').val(),
                'password': $('#passwd').val(),
                'role': $('#role').val(),
                'status': $('#status').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/manager/insert', datas, function (res) {
                if (res.status) {
                    alertify.success('添加管理员成功');
                    $('#name').val('');
                    $('#password').val('');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        })
    </script>

    <script>
        //显示
        var edit = function (event) {
            $('#ename').val($(event).attr('data-name'));
            $('#edit-save').attr('data-id', $(event).attr('data-id'));
            if (1 != $(event).attr('data-status')) {
                var data = '<option value="1">是</option> <option selected="selected" value="2">否</option>'
            } else {
                var data = '<option selected="selected" value="1">是</option> <option  value="2">否</option>'
            }
            $('#estatus').html(data);


            var record = '';
            $.get('/Administrators', '', function (res) {

                if (res.status) {
                    for (let i in res.data) {
                        if ($(event).attr('data-role') != res.data[i].id) {
                            record += `<option value="${res.data[i].id}">${res.data[i].name}</option>`;
                        } else {
                            record += `<option selected="selected" value="${res.data[i].id}">${res.data[i].name}</option>`;
                        }
                    }
                    $('#erole').html(record);
                } else {
                    alertify.alert('获取列表失败');
                }
            })


            $('#edit').modal('toggle');
        }
        //修改
        var efunb = function (event) {


            var datas = {
                'id': $(event).attr('data-id'),
                'name': $('#ename').val(),
                'passwd': $('#epasswd').val(),
                'role': $('#erole').val(),
                'status': $('#estatus').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/manager/modify', datas, function (res) {

                if (res.status) {
                    alertify.success('修改成功');
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

                    $.get('/manager/del', {'id': $(event).attr('data-id')}, function (res) {

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









@endsection
