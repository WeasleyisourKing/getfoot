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
                    <h4 class="modal-title">添加商品二级分类</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="zn_name">二级分类名称（中）（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="zn_name" id="zn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="en_name">二级分类名称（英）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="en_name" id="en_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">是否显示<span style="color:red;">＊</span></label>
                        <select class="form-control" id="status">
                            <option value="1">是</option>
                            <option value="2">否</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="icon">分类图标样式<span
                                    style="color:red;">＊</span><a target="_blank" href="https://fontawesome.com/icons"> https://fontawesome.com/icons </a></label>
                        <div class="controls">
                            <input type="text" name="icon" id="icon"
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
                    <h4 class="modal-title">修改商品二级分类</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ezn_name">分类名称（中）（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ezn_name" id="ezn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="een_name">分类名称（英）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="een_name" id="een_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">是否显示<span style="color:red;">＊</span></label>
                        <select class="form-control" id="estatus">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="icon">分类图标样式<span
                                    style="color:red;">＊</span><a target="_blank" href="https://fontawesome.com/icons"> https://fontawesome.com/icons </a></label>
                        <div class="controls">
                            <input type="text" name="eicon" id="eicon"
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
            <h4 class="pull-left page-title">产品管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">产品管理</a></li>
                <li class="active">分类管理</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">分类管理</h3></div>
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

                        <div class="col-sm-3 col-md-offset-6">
                            <div class="input-group">
                                <input id="example-input2-group2" name="example-input2-group2" class="form-control"
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
                    <!-- 搜索 -->

                </form>

                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">二级分类列表</h3>
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
                                            <th class="col-md-1 col-lg-1 exce"> 顺序（正序）</th>
                                            <th class="col-md-3 col-lg-3 exce"> 二级分类名称</th>

                                            <th class="col-md-2 col-lg-2 exce">
                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-default dropdown-toggle waves-effect"
                                                            data-toggle="dropdown" aria-expanded="false">{{$status}}
                                                        <span
                                                                class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="statusAll" href="javascript:void(0);">全部状态</a></li>
                                                        <li><a id="statusShow" href="javascript:void(0);">显示</a></li>
                                                        <li><a id="statusHide" href="javascript:void(0);">不显示</a></li>

                                                    </ul>
                                                </div>
                                            </th>

                                            <th class="col-md-3 col-lg-3 exce"> 创建时间</th>
                                            <th class="col-md-3 col-lg-3 exce" class="td-actions"> 操作</th>
                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="exce">
                                                    <div class="col-md-12">
                                                        <div class="col-md-3"></div>

                                                        <div class="col-md-5 " style="padding:0px;"><input
                                                                    class="exce" data-id="{{ $item->id }}"
                                                                    data-data="{{ $item->score }}" value="{{ $item->score }}" name="dataStock"
                                                                    style="width:100%;border: 1px solid #ddd"/></div>
                                                        <div class="col-md-3"></div>
                                                    </div>

                                                </td>
                                                <td class="exce">{{ $item->zn_name }} <br/>{{ $item->en_name }}</td>
                                                </td>
                                                @if ($item->status == 1)
                                                    <td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i>
                                                    </td>
                                                @else
                                                    <td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i>
                                                    </td>
                                                @endif
                                                <td class="exce">{{ $item->created_at }}</td>
                                                <td class="exce">

                                                    <a title="修改信息" onclick="edit(this);"  class="btn btn-small btn-info"
                                                       data-id="{{$item->id}}" data-zname="{{$item->zn_name}}"  data-ename="{{$item->en_name}}"
                                                       data-status="{{$item->status}}" data-icon="{{$item->icon}}"
                                                       href="javascript:void(0);">
                                                        <i class="icon fa fa-pencil"> </i>
                                                    </a>
                                                    <a title="删除" class="btn btn-small btn-danger"
                                                       href="javascript:void(0);" data-id="{{$item->id}}"
                                                       onclick="del(this);">
                                                        <i class="icon fa fa-trash-o"> </i>
                                                    </a>
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
        strs.splice(8, 1, 20);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(8, 1, 50);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(8, 1, 100);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
//        strs.splice(8, 1, 20);
//        var val3 = strs.join('/');
//        $('#select20').attr('href', val3);

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
    </script>


    <script>
        //点击添加
        $('#sa-save').click(function () {

            var datas = {
                'id' : strs[4],
                'zn_name': $('#zn_name').val(),
                'en_name': $('#en_name').val(),
                'status': $('#status').val(),
                'icon': $('#icon').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/category/level/insert', datas, function (res) {
                if (res.status) {
                    alertify.success('创建二级分类成功');
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
            $('#ezn_name').val($(event).attr('data-zname'));
            $('#een_name').val($(event).attr('data-ename'));
            $('#eicon').val($(event).attr('data-icon'));
            $('#edit-save').attr('data-id',$(event).attr('data-id'));
            if (1 != $(event).attr('data-status')) {
                var data = '<option value="1">是</option> <option selected="selected" value="2">否</option>'
            } else {
                var data = '<option selected="selected" value="1">是</option> <option  value="2">否</option>'
            }
            $('#estatus').html(data);
            $('#edit').modal('toggle');
        }
        //修改
       var efunb = function (event) {

            var datas = {
                'id':$(event).attr('data-id'),
                'pid': strs[4],
                'zn_name': $('#ezn_name').val(),
                'status': $('#status').val(),
                'en_name': $('#een_name').val(),
                'icon': $('#eicon').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/category/level/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改二级分类成功');
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

                    $.get('/category/del', {'id': $(event).attr('data-id')}, function (res) {

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
        //点击 提交
        $(document).ready(function () {
            document.onkeyup = function (e) {
                var code = e.keyCode || e.charCode;
                if (code == 13) {
                    window.data = [];
                    $("input[name='dataStock']").each(function () {

                        if (($(this).val() != '') && ($(this).length > 0) && Number($(this).val()) >= 1 && Number($(this).val()) <=100  ) {

                            data.push({'id': $(this).attr('data-id'), 'score': $(this).val()});
                        } else {

                            alertify.alert('顺序不是1-100的数字');
                            return false;

                        }
                    });

                    if (window.data.length > 0) {

                        $.get('/score/category', {'data':window.data}, function (res) {

                            if (res.status) {
                                alertify.success('修改顺序成功');
//
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            } else {
                                alertify.alert(res.message);
                            }
                        })
                    }
                }
            }
        });

    </script>






@endsection
