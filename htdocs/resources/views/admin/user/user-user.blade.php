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
                    <h4 class="modal-title">添加用户</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="name">名称（最多20字）<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">性别<span
                                    class="red">＊</span></label>
                        <select class="form-control" id="sex">
                            <option selected="selected" value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">角色<span
                                    class="red">＊</span></label>
                        <select class="form-control" id="role">
                            @foreach($arr as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="email">邮箱<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="email" id="email" class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    {{--<div class="form-group">--}}
                        {{--<label class="control-label" for="integral">积分<span--}}
                                    {{--class="red">＊</span></label>--}}
                        {{--<div class="controls">--}}
                            {{--<input type="text" name="integral" id="integral" class="form-control"--}}
                                   {{--value="" required="required"/>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group" >
                        <label class="col-sm-2 control-label" style="padding-left: 0;padding-top:8px; ">头像</label>
                        <div class="controls">
                            <input type="file" name="img" id="uploadfile" multiple class="file-loading"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="passwd">密码<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="password" name="passwd" id="passwd" class="form-control"
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

                    <div class="form-group">
                        <label class="control-label">性别<span
                                    class="red">＊</span></label>
                        <select class="form-control" id="esex">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">角色<span
                                    class="red">＊</span></label>
                        <select class="form-control" id="erole">

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="eemail">邮箱<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="eemail" id="eemail" class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="eintegral">积分<span
                                    class="red">＊</span></label>
                        <div class="controls">
                            <input type="text" name="eintegral" id="eintegral" class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-2 control-label" style="padding-left: 0;padding-top:8px; ">头像</label>
                        <div class="controls" id="control">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="epasswd">密码</label>
                        <div class="controls">
                            <input type="password" name="epasswd" id="epasswd" class="form-control"
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

    <div id="addressModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">用户收货地址列表</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>用户名 :
                            <text style="font-weight: 400;" id="aname"></text>
                        </label>
                        <label style="float: right;">共计（条） :
                            <text style="font-weight: 400;" id="count"></text>
                        </label>
                    </div>
                    <div class="form-group">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class=" col-md-1 col-lg-1 exce"> 序号</th>
                                <th class=" col-md-2 col-lg-2 exce"> 姓名</th>
                                <th class="col-md-2 col-lg-2 exce"> 手机号码</th>
                                <th class="col-md-1 col-lg-1 exce">州</th>
                                <th class="col-md-2 col-lg-2 exce"> 市</th>
                                <th class="col-md-2 col-lg-2 exce"> 区</th>
                                <th class="col-md-2 col-lg-2 exce"> 详细地址</th>
                            </tr>
                            </thead>
                            <tbody id="address">

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="orderModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">用户订单列表</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>用户名 :
                            <text style="font-weight: 400;" id="orderName"></text>
                        </label>
                        <label style="float: right;">共计（条） :
                            <text style="font-weight: 400;" id="orderCount"></text>
                        </label>
                    </div>
                    <div class="form-group">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class=" col-md-2 col-lg-2 exce"> 序号</th>
                                <th class=" col-md-2 col-lg-2 exce"> 订单号</th>
                                <th class="col-md-2 col-lg-2 exce"> 总价格</th>
                                <th class="col-md-2 col-lg-2 exce"> 总数量</th>
                                <th class="col-md-2 col-lg-2 exce">状态</th>
                                <th class="col-md-2 col-lg-2 exce">下单时间</th>
                            </tr>
                            </thead>
                            <tbody id="order">

                        </table>

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
                <li class="active">用户管理</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">用户管理</h3></div>
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
                            <h3 class="panel-title">用户列表</h3>
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
                                            <th class="col-md-2 col-lg-2 exce"> 名称</th>
                                            <th class="col-md-1 col-lg-1 exce"> 性别</th>
                                            <th class="col-md-2 col-lg-2 exce"> 头像</th>
                                            <th class="col-md-2 col-lg-2 exce"> 邮箱</th>
                                            <th class="col-md-1 col-lg-1 exce"> 积分</th>
                                            <th class="col-md-1 col-lg-1 exce"> 注册时间</th>
                                            <th class="col-md-1 col-lg-1 exce">
                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-default dropdown-toggle waves-effect"
                                                            data-toggle="dropdown" aria-expanded="false">{{$status}}
                                                        <span
                                                                class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="statusAll" href="javascript:void(0);">全部状态</a></li>
                                                        <li><a id="statusShow" href="javascript:void(0);">激活</a></li>
                                                        <li><a id="statusHide" href="javascript:void(0);">不激活</a></li>

                                                    </ul>
                                                </div>
                                            </th>
                                            <th class="col-md-2 col-lg-2 exce"> 操作</th>
                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $item)
                                            <tr>

                                                <td class="exce">{{ $item->name }}</td>
                                                <td class="exce">{{$item->sex}}</td>
                                                <td class="exce"><img height="100px; align=" middle" src="{{ $item->avatar }}"
                                                    alt="没有上传"/>
                                                </td>
                                                <td class="exce">{{ $item->email }}</td>
                                                <td class="exce">{{ $item->integral }}</td>
                                                <td class="exce">{{ $item->created_at }}</td>
                                                @if ($item->status != 1)

                                                    <td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i></td>
                                                @else
                                                    <td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i></td>
                                                @endif

                                                <td class="exce">

                                                    <a title="查看用户订单" data-id="{{$item->id}}" data-name="{{$item->name}}"
                                                       class="btn btn-small btn-success"
                                                       href="javascript:void (0);"
                                                       onclick="funOrder(this)">
                                                        <i class="icon fa fa-shopping-basket"> </i>
                                                    </a>
                                                    <a title="查看用户地址" data-id="{{$item->id}}" data-name="{{$item->name}}"
                                                       class="btn btn-small btn-success"
                                                       href="javascript:void (0);"
                                                       onclick="funAddress(this)">
                                                        <i class="icon fa fa-bars"> </i>
                                                    </a>
                                                    <a title="修改" href="javascript:void(0); "class="btn btn-small btn-info"
                                                       data-id="{{$item->id}}"  data-name="{{$item->name}}"
                                                       data-sex="{{$item->sex}}"
                                                       data-avatar="{{$item->avatar}}"
                                                       data-email="{{$item->email}}"
                                                       data-integral="{{$item->integral}}"
                                                       data-role="{{$item->role}}"
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

//        var a = 'b';
//       var b = 'c';
//        console.log(eval(a));
        //添加编辑器
        window.imgAddress = '';
        window.imgId = '';
        $("#uploadfile").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
            ],
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 19999,//图片的最大宽度
            maxImageHeight: 19999,//图片的最大高度
            //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 1, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function (previewId, index) {   //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}'
                };
                return data;
            }
        });
        //异步上传返回结果处理
        $("#uploadfile").on("fileuploaded", function (event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {
                imgAddress = obj.data;
                imgId = obj.img_id;
                alertify.alert('上传成功');
            }
        });
    </script>
    <script>

        var url = window.location.pathname;
        strs = url.split("/");

        //替换limit为5
        strs.splice(6, 1, 5);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(6, 1, 10);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(6, 1, 15);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
        strs.splice(6, 1, 20);
        var val3 = strs.join('/');
        $('#select20').attr('href', val3);

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
        //点击添加
        $('#sa-save').click(function () {


            //验证密码参数
            res = check({'password': $('#passwd').val()});
            if (!res.status) {
                alertify.alert('密码中必须包含字母、数字、特称字符，至少8个字符');
                return;
            }
            var datas = {
                'img_id':window.imgId,
                'name': $('#name').val(),
                'sex': $('#sex').val(),
                'email': $('#email').val(),
                'password': $('#passwd').val(),
                'role': $('#role').val(),
//                'integral': $('#integral').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/user/add', datas, function (res) {
                if (res.status) {
                    alertify.success('创建用户成功');
                    $('#name').val('');
                    $('#email').val('');
//                    $('#integral').val('');
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


            //获取角色
            $.get('/role', '', function (res) {
                if (res.status) {
                    var data1 = '';
                    for (let i in res.data) {
                        if (res.data[i].id != $(event).attr('data-role')) {
                            data1 += `<option  value="${res.data[i].id}">${res.data[i].name}</option>`;
                        } else {
                            data1 += `<option selected="selected" value="${res.data[i].id}">${res.data[i].name}</option>`;
                        }
                    }

                    $('#erole').html(data1);
                } else {

                    alertify.alert('获取信息失败');
                }

            })


            if ($(event).attr('data-sex') == '男') {
                var data = '<option selected="selected" value="1">男</option>' +
                    '<option  value="2">女</option>';
            } else {
                var data = '<option value="1">男</option>' +
                    '<option selected="selected" value="2">女</option>';
            }
            $('#esex').html(data);

            var datas = `<input type="file"  name="img"  id="euploadfile${$(event).attr('data-id')}" multiple class="file-loading"/>`;

            $('#control').html(datas);

            var res = [];

            if ($(event).attr('data-avatar').length != 1) {
                res.push (`<img class='file-preview-frame' data-fileindex='0' data-template='image' src='${$(event).attr('data-avatar')}'/>`);
            }


            showImage($(event).attr('data-id'),res);

            $('#ename').val($(event).attr('data-name'));
            $('#eemail').val($(event).attr('data-email'));
            $('#eintegral').val($(event).attr('data-integral'));

            $('#edit-save').attr('data-id',$(event).attr('data-id'));
            $('#edit').modal('toggle');
        }
        //修改
       var efunb = function (event) {

           var datas = {
               'id':$(event).attr('data-id'),
               'name': $('#ename').val(),
               'sex': $('#esex').val(),
               'email': $('#eemail').val(),
               'role': $('#erole').val(),
               'integral': $('#eintegral').val(),
               '_token': '{{csrf_token()}}'
           };

           if ($('#epasswd').val().length > 1) {
               res = check({'password': $('#epasswd').val()});
               if (!res.status) {
                   alertify.alert('密码中必须包含字母、数字、特称字符，至少8个字符');
                   return;
               }
               datas.password = $('#epasswd').val();
           }

           if (eimgAddress.length != 0) {
               datas.img_id = eimgAddress;

           }

           $.post('/user/update', datas, function (res) {

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

                    $.get('/user/del', {'id': $(event).attr('data-id')}, function (res) {

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
        var showImage = function (ctrlName,eimage) {

            window.control = $('#euploadfile' + ctrlName);
            //添加编辑器
            window.eimgAddress = [];
            window.eimgId = '';
            control.fileinput({
                language: 'zh', //设置语言
                uploadUrl: "/imgHandle", //上传的地址
                allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
                initialPreview: eimage, //预览图片的设置

                uploadAsync: true, //默认异步上传
                showUpload: true, //是否显示上传按钮
                showRemove: true, //显示移除按钮
                showPreview: true, //是否显示预览+
                showCaption: true,//是否显示标题
                browseClass: "btn btn-primary", //按钮样式
                dropZoneEnabled: false,//是否显示拖拽区域
                //minImageWidth: 50, //图片的最小宽度
                //minImageHeight: 50,//图片的最小高度
                maxImageWidth: 19999,//图片的最大宽度
                maxImageHeight: 19999,//图片的最大高度
                //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
                //minFileCount: 0,
                maxFileCount: 1, //表示允许同时上传的最大文件个数
                enctype: 'multipart/form-data',
                validateInitialCount: true,
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
                msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
                //传递参数
                uploadExtraData: function (previewId, index) {   //额外参数的关键点
                    var data = {
                        '_token': '{{csrf_token()}}'
                    };
                    return data;
                }
            });

            //异步上传返回结果处理
            window.control.on("fileuploaded", function (event, data) {
                var obj = data.response;

                if (obj.errno == 1) {
                    alertify.alert(obj.data[0]);
                    return;
                } else {

                    eimgAddress.push(obj.data);
                    alertify.alert('上传成功');
                }
            });
        }


    </script>


    <script>
        //查看订单
        function funOrder(event) {

            $('#orderName').text($(event).attr('data-name'));
            $.get('/user/order', {'id': $(event).attr('data-id')}, function (res) {

                if (res.status) {
                    if (res.data == null) {
                      var j = 1;
                        var datas = '<div><h5 style="color: red;">该客户没有订单信息</h5></div>';
                    } else {
                        var j = 1;
                        for (let i in res.data) {

                            switch (res.data[i].status) {
                                case 1 : res.data[i].status = '已支付';
                                    break;
                                case 2 : res.data[i].status = '未支付';
                                    break;
                                case 3 : res.data[i].status = '已发货';
                                    break;
                                default : res.data[i].status = '已完成';
                            }
                            datas += `<tr>
                                    <td class="exce">${j}</td>
                                    <td class="exce">${res.data[i].order_no}</td>
                                    <td class="exce">${res.data[i].total_price}</td>
                                    <td class="exce">${res.data[i].total_count}</td>
                                    <td class="exce">${res.data[i].status}</td>
                                    <td class="exce">${res.data[i].created_at}</td>
                                   </tr>`;
                            ++j;
                        }
                    }
                    $('#orderCount').text(j - 1);
                    $('#order').html(datas);
                    $('#orderModal').modal('toggle');
                } else {
                    alertify.alert('获取订单列表失败');
                }
            })
        }

    </script>

    <script>
        //查看地址
        function funAddress(event) {

            $('#aname').text($(event).attr('data-name'));
            $.get('/user/address', {'id': $(event).attr('data-id')}, function (res) {
                if (res.status) {
                    if (res.data.length == 0) {

                        var datas = '<div style="width:100px;text-align: center"><h5 style="color: red;">该客户没有填写地址信息</h5></div>';
                        $('#count').text(0);
                    } else {
                        var j = 1;
                        for (let i in res.data) {

                            if (res.data[i].default == '1') {
                                var middle = `<td class="exce" style="color: red;" >默 ${j}</td>`;
                            } else {
                                var middle = `<td class="exce">${j}</td>`;
                            }
                            datas += `<tr>` + middle + `
                                    <td class="exce">${res.data[i].name}</td>
                                    <td class="exce">${res.data[i].mobile}</td>
                                    <td class="exce">${res.data[i].province}</td>
                                    <td class="exce">${res.data[i].city}</td>
                                    <td class="exce">${res.data[i].country}</td>
                                    <td class="exce">${res.data[i].detail}</td>
                                   </tr>`;
                            ++j;
                        }
                        $('#count').text(j - 1);
                    }

                    $('#address').html(datas);
                    $('#addressModal').modal('toggle');
                } else {
                    alertify.alert('获取地址列表失败');
                }
            })
        }

    </script>


@endsection
