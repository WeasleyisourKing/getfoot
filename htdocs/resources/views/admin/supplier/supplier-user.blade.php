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
                    <h4 class="modal-title">添加供应商</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="company">供应商名称（最多70字）<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="company" id="company"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">联系人（最多30字）<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="mobile">联系电话<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="mobile" id="mobile"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="email">邮箱地址<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="email" id="email" class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                        <div class="form-group">
                            <label class="control-label" for="address">地址（最多150字）<span
                                        style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="address" id="address"
                                       class="form-control"
                                       value="" required="required"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="country">国家（最多30字）<span
                                        style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="country" id="country"
                                       class="form-control"
                                       value="" required="required"/>
                            </div>
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
                    <h4 class="modal-title">修改供应商</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ecompany">供应商名称（最多70字）<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ecompany" id="ecompany"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ename">联系人（最多30字）<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ename" id="ename"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="emobile">联系电话<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="emobile" id="emobile"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="eemail">邮箱地址<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="eemail" id="eemail" class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="eaddress">地址（最多150字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="eaddress" id="eaddress"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="ecountry">国家（最多150字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ecountry" id="ecountry"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
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


    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">供货商管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">供货商管理</a></li>
                <li class="active">供货商列表</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">供货商管理</h3></div>
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
                    </div>
                    <!-- 搜索 -->

                </form>

                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">供货商列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade in active" id="ordinary">

                                        <div class="row">
                                            <div class="col-md-8"></div>

                                        </div>

                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                {{--<table class="table table-bordered">--}}
                                                <table class="table table-bordered table-striped display"
                                                       id="datatable-buttons">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-2 col-lg-2 exce"> 供应商名称</th>
                                                        <th class="col-md-1 col-lg-1 exce"> 联系人</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 电话号码</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 邮箱地址</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 地址</th>
                                                        <th class="col-md-1 col-lg-1 exce"> 国家</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 操作</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody id="postContainer">
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td class="exce">{{ $item->company }}</td>
                                                            <td class="exce">{{ $item->name }}</td>
                                                            <td class="exce">{{$item->mobile}}</td>
                                                            <td class="exce">{{$item->email}}</td>
                                                            <td class="exce">{{$item->address}}</td>
                                                            <td class="exce">{{$item->country}}</td>

                                                            <td class="exce">

                                                                <a title="修改" href="javascript:void(0); "
                                                                   class="btn btn-small btn-info"
                                                                   data-id="{{$item->id}}"
                                                                   data-company="{{$item->company}}"
                                                                   data-name="{{$item->name}}"
                                                                   data-mobile="{{$item->mobile}}"
                                                                   data-email="{{$item->email}}"
                                                                   data-address="{{$item->address}}"
                                                                   data-country="{{$item->country}}"
                                                                   onclick="edit(this);">
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
                                                {{--<div style="clear: both;text-align: center;">--}}
                                                {{--{{ $data->links() }}--}}
                                                {{--</div>--}}

                                            </div>
                                            @if(!$data->count())
                                                <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
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
        //点击添加
        $('#sa-save').click(function () {

            var datas = {
                'name': $('#name').val(),
                'company': $('#company').val(),
                'email': $('#email').val(),
                'mobile': $('#mobile').val(),
                'address': $('#address').val(),
                'country': $('#country').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/supplier/add', datas, function (res) {
                if (res.status) {
                    alertify.success('创建成功');
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
            $('#eemail').val($(event).attr('data-email'));
            $('#ecompany').val($(event).attr('data-company'));
            $('#emobile').val($(event).attr('data-mobile'));
            $('#eaddress').val($(event).attr('data-address'));
            $('#ecountry').val($(event).attr('data-country'));

            $('#edit-save').attr('data-id',$(event).attr('data-id'));
            $('#edit').modal();
        }

        //修改
        var efunb = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'name': $('#ename').val(),
                'company': $('#ecompany').val(),
                'email': $('#eemail').val(),
                'mobile': $('#emobile').val(),
                'address': $('#eaddress').val(),
                'country': $('#ecountry').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/supplier/update', datas, function (res) {

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

                    $.get('/supplier/del', {'id': $(event).attr('data-id')}, function (res) {

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
