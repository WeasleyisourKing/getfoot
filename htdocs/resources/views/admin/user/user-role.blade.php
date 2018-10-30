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
                    <h4 class="modal-title">添加用户角色</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="name">角色名称（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   value="" required="required"/>
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
                    <h4 class="modal-title">修改用户角色</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ename">角色名称（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ename" id="ename"
                                   class="form-control"
                                   value="" required="required"/>
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

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">用户管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">用户管理</a></li>
                <li class="active">用户角色</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">用户角色</h3></div>
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
                            <h3 class="panel-title">角色列表</h3>
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
                                            <th class="col-md-4 col-lg-4 exce"> 角色名称</th>
                                            <th class="col-md-4 col-lg-4 exce"> 创建时间</th>
                                            <th class="col-md-4 col-lg-4 exce" class="td-actions"> 操作</th>
                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $item)
                                            <tr>

                                                <td class="exce">{{ $item->name }}</td>

                                                <td class="exce">{{ $item->created_at }}</td>
                                                <td class="exce">
                                                @if ($item->id != 1)
                                                    <a title="修改信息" onclick="edit(this);" class="btn btn-small btn-info"
                                                       data-id="{{$item->id}}"  data-name="{{$item->name}}"
                                                       href="javascript:void(0);">
                                                        <i class="icon fa fa-pencil"> </i>
                                                    </a>
                                                    <a title="删除" class="btn btn-small btn-danger"
                                                       href="javascript:void(0);" data-id="{{$item->id}}"
                                                       onclick="del(this);">
                                                        <i class="icon fa fa-trash-o"> </i>
                                                    </a>
                                                        @else
                                                        <a disabled="disabled" title="修改信息"  href ="javascript:return false;" onclick="return false;"  class="btn btn-small btn-info"
                                                           data-id="{{$item->id}}"   data-name="{{$item->name}}" style="cursor: not-allowed;"
                                                           >
                                                            <i class="icon fa fa-pencil"> </i>
                                                        </a>
                                                        <a disabled="disabled" title="删除" class="btn btn-small btn-danger"
                                                            href ="javascript:return false;" onclick="return false;" data-id="{{$item->id}}"
                                                           style="cursor: not-allowed;" >
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
        strs.splice(4, 1, 5);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(4, 1, 10);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(4, 1, 15);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
        strs.splice(4, 1, 20);
        var val3 = strs.join('/');
        $('#select20').attr('href', val3);

    </script>


    <script>
        //点击添加
        $('#sa-save').click(function () {

            var datas = {
                'id':1,
                'name': $('#name').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/user/append', datas, function (res) {
                if (res.status) {
                    alertify.success('创建用户角色成功');
                    $('#name').val('');
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
            $('#edit-save').attr('data-id',$(event).attr('data-id'));
            $('#edit').modal('toggle');
        }
        //修改
       var efunb = function (event) {

            var datas = {
                'id':$(event).attr('data-id'),
                'name': $('#ename').val(),
                '_token': '{{csrf_token()}}'
            };


           $.post('/user/role/update', datas, function (res) {

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

                    $.get('/user/role/del', {'id': $(event).attr('data-id')}, function (res) {

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
