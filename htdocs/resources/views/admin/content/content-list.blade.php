@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->

    <!-- 添加 Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 800px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">添加文章</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label" for="ezn_name">名称（中）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls" id="zn">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">详细描述（中）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls" id="zn-name">
                            <div id="contact-zn-editor">
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="ezn_name">名称（英）（最多100字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls" id="en">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">详细描述（英）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls" id="en-name">
                            <div id="contact-en-editor">
                                <p></p>
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
    </div>



    <!-- 编辑 Modal -->

    <div id="edit" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 800px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑文章</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ezn_name">名称（中）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ezn_name" id="ezn_name"
                                   class="form-control"
                                   value="" required="required"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">详细描述（中）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <div id="zn-editor">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="een_name">名称（英）（最多100字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="een_name" id="een_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">详细描述（英）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <div id="en-editor">

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
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">内容管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">页面管理</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">页面管理</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <div class="form-group">
                    <ul id="myTab" class="nav nav-tabs navtab-bg ">
                        <li class="active">
                            <a href="#contact" data-toggle="tab">联系我们</a>
                        </li>

                        <li>
                            <a href="#about" data-toggle="tab">关于我们</a>
                        </li>
                        <li>
                            <a href="#terms" data-toggle="tab">使用条款</a>
                        </li>
                        <li>
                            <a href="#customer" data-toggle="tab">客户服务</a>
                        </li>
                        <li>
                            <a href="#userterms" data-toggle="tab">app用户条款</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="contact">
                            <div class="form-group">
                                <label class="control-label">详细描述（中）<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <div id="editor">
                                        <p>{!! $contact->zn_content !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">详细描述（英）<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <div id="editors">
                                        <p>{!! $contact->en_content !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="edit-save" data-id="1" onclick="func(this);"
                                        class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="about">
                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="button" class="btn waves-effect waves-light btn-primary"
                                            data-id="2" data-zn="about-zn-editor" data-en="about-en-editor"
                                            onclick="add(this);">
                                        <i class="fa fa-plus"></i> Add
                                    </button>

                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-3 col-lg-3 exce"> 名称</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 创建时间</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 修改时间</th>
                                                        <th class="col-md-3 col-lg-3 exce" class="td-actions"> 操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="postContainer">
                                                    @foreach ($about as $item)
                                                        <tr>

                                                            <td class="exce">{{ $item->zn_name }}
                                                                <br/>{{ $item->en_name }}</td>
                                                            <td class="exce">{{ $item->created_at }}</td>
                                                            <td class="exce">{{ $item->updated_at }}</td>

                                                            <td class="exce">
                                                                <a title="修改信息" onclick="edit(this);"
                                                                   class="btn btn-small btn-info"
                                                                   data-id="{{$item->id}}"
                                                                   data-zname="{{$item->zn_name}}"
                                                                   data-ename="{{$item->en_name}}"
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
                                            </div>
                                            @if(!$about->count())
                                                <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="terms">

                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="button" class="btn waves-effect waves-light btn-primary"
                                            data-id="3" data-zn="terms-zn-editor" data-en="terms-en-editor"
                                            onclick="add(this);">
                                        <i class="fa fa-plus"></i> Add
                                    </button>

                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-3 col-lg-3 exce"> 名称</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 创建时间</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 修改时间</th>
                                                        <th class="col-md-3 col-lg-3 exce" class="td-actions"> 操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="postContainer">
                                                    @foreach ($terms as $item)
                                                        <tr>

                                                            <td class="exce">{{ $item->zn_name }}
                                                                <br/>{{ $item->en_name }}</td>
                                                            <td class="exce">{{ $item->created_at }}</td>
                                                            <td class="exce">{{ $item->updated_at }}</td>

                                                            <td class="exce">
                                                                <a title="修改信息" onclick="edit(this);"
                                                                   class="btn btn-small btn-info"
                                                                   data-id="{{$item->id}}"
                                                                   data-zname="{{$item->zn_name}}"
                                                                   data-ename="{{$item->en_name}}"
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
                                            </div>
                                            @if(!$terms->count())
                                                <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="customer">

                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="button" class="btn waves-effect waves-light btn-primary"
                                            data-id="4" data-zn="customer-zn-editor" data-en="customer-en-editor"
                                            onclick="add(this);">
                                        <i class="fa fa-plus"></i> Add
                                    </button>

                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-3 col-lg-3 exce"> 名称</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 创建时间</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 修改时间</th>
                                                        <th class="col-md-3 col-lg-3 exce" class="td-actions"> 操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="postContainer">
                                                    @foreach ($customer as $item)
                                                        <tr>

                                                            <td class="exce">{{ $item->zn_name }}
                                                                <br/>{{ $item->en_name }}</td>
                                                            <td class="exce">{{ $item->created_at }}</td>
                                                            <td class="exce">{{ $item->updated_at }}</td>

                                                            <td class="exce">
                                                                <a title="修改信息" onclick="edit(this);"
                                                                   class="btn btn-small btn-info"
                                                                   data-id="{{$item->id}}"
                                                                   data-zname="{{$item->zn_name}}"
                                                                   data-ename="{{$item->en_name}}"
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
                                            </div>
                                            @if(!$customer->count())
                                                <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade " id="userterms">
                            <div class="form-group">
                                <label class="control-label">详细描述（中）<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <div id="usertermseditor">
                                        <p>{!! $userTerms->zn_content !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">详细描述（英）<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <div id="usertermseditors">
                                        <p>{!! $userTerms->en_content !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-id="13" onclick="userfunc(this);"
                                        class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        //添加编辑器
        var E = window.wangEditor;

        var editor2 = new E('#editor');
        //图片名
        editor2.customConfig.uploadFileName = 'img';
        //接口
        editor2.customConfig.uploadImgServer = "/imgHandle";  // 上传图片
        //传递参数 POST
        editor2.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
        editor2.customConfig.uploadImgHooks = {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            fail: function (xhr, editor, result) {
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                editor.customConfig.customAlert(result.data[0]);

            },
            // 图片上传出错时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            error: function (xhr, editor) {
                editor.customConfig.customAlert(result.data[0]);
            },
        };
        //自定义提示方法
        editor2.customConfig.customAlert = function (info) {
            alertify.alert(info);
        };
        editor2.create();

    </script>

    <script>
        //添加编辑器
        var E = window.wangEditor;

        var editor1 = new E('#editors');
        //图片名
        editor1.customConfig.uploadFileName = 'img';
        //接口
        editor1.customConfig.uploadImgServer = "/imgHandle";  // 上传图片
        //传递参数 POST
        editor1.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
        editor1.customConfig.uploadImgHooks = {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            fail: function (xhr, editor, result) {
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                editor.customConfig.customAlert(result.data[0]);

            },
            // 图片上传出错时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            error: function (xhr, editor) {
                editor.customConfig.customAlert(result.data[0]);
            },
        };
        //自定义提示方法
        editor1.customConfig.customAlert = function (info) {
            alertify.alert(info);
        };
        editor1.create();

    </script>
    <script>
            var editor = function (data) {

                //添加编辑器
                var E = window.wangEditor;

                var editor = new E('#' + data);
                //图片名
                editor.customConfig.uploadFileName = 'img';
                //接口
                editor.customConfig.uploadImgServer = "/imgHandle";  // 上传图片
                //传递参数 POST
                editor.customConfig.uploadImgParams = {
                    _token: '{{csrf_token()}}'
                }
                //监听
                editor.customConfig.uploadImgHooks = {
                    // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                    fail: function (xhr, editor, result) {
                        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                        editor.customConfig.customAlert(result.data[0]);

                    },
                    // 图片上传出错时触发
                    // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
                    error: function (xhr, editor) {
                        editor.customConfig.customAlert(result.data[0]);
                    },
                };
                //自定义提示方法
                editor.customConfig.customAlert = function (info) {
                    alertify.alert(info);
                };
                editor.create();
                return editor;
            }

    </script>

    {{--<script>--}}

            {{--var list = ['contact-zn-editor', 'contact-en-editor'];--}}
            {{--window.dataList = [];--}}
            {{--for (let i in list) {--}}
                {{--window.dataList.push(editor(list[i]));--}}
            {{--}--}}
    {{--</script>--}}

    <script>
        var add = function (event) {


            var dataZn = dataEn = zn = en = '';
            switch ($(event).attr('data-id')) {
                //关于我们
                case '2' :
                    dataZn = '<div id="about-zn-editor"> <p></p> </div>';
                    dataEn = '<div id="about-en-editor"> <p></p> </div>';
                    zn = '<input type="text"  id="about-zn"  class="form-control"  value="" required="required"/>';
                    en = '<input type="text"  id="about-en"  class="form-control"  value="" required="required"/>';
                    break;
                case '3' :
                    dataZn = '<div id="terms-zn-editor"> <p></p> </div>';
                    dataEn = '<div id="terms-en-editor"> <p></p> </div>';
                    zn = '<input type="text"  id="terms-zn"  class="form-control"  value="" required="required"/>';
                    en = '<input type="text"  id="terms-en"  class="form-control"  value="" required="required"/>';
                    break;
                case '4' :
                    dataZn = '<div id="customer-zn-editor"> <p></p> </div>';
                    dataEn = '<div id="customer-en-editor"> <p></p> </div>';
                    zn = '<input type="text"  id="customer-zn"  class="form-control"  value="" required="required"/>';
                    en = '<input type="text"  id="customer-en"  class="form-control"  value="" required="required"/>';
                    break;
            }
            $('#sa-save').attr('data-id', $(event).attr('data-id'));

            $('#zn-name').html(dataZn);
            $('#en-name').html(dataEn);
            $('#zn').html(zn);
            $('#en').html(en);

            window.editorZn = editor($(event).attr('data-zn'));
            window.editorEn = editor($(event).attr('data-en'));
            $('#add').modal('toggle');

        }

        //添加
        $('#sa-save').click(function () {

            var datas = {
                'id': $(this).attr('data-id'),
                'zn_name': $('#zn input').val(),
                'en_name': $('#en input').val(),
                'zn_content': window.editorZn.txt.html(),
                'en_content': window.editorEn.txt.html(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/content/add', datas, function (res) {
                if (res.status) {
                    alertify.success('创建文章成功');
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
            $('#edit-save').attr('data-id', $(event).attr('data-id'));

            $('#zn-editor').html('');
            $('#en-editor').html('');
            window.editorZnn = editor('zn-editor');
            window.editorEnn = editor('en-editor');
            $.get('/article/modify', {'id': $(event).attr('data-id')}, function (res) {


                if (res.status) {
                    $('#ezn_name').val(res.data.zn_name);
                    $('#een_name').val(res.data.en_name);
                    $('#zn-editor p').html(res.data.zn_content);
                    $('#en-editor p').html(res.data.en_content);

                } else {
                    alertify.alert(res.message);
                }
            })
            $('#edit').modal('toggle');
        }


        var func = function (event) {


            var datas = {
                'id': $(event).attr('data-id'),
                'zn_name': '联系我们',
                'en_name': 'Contact us',
                'zn_content': editor2.txt.html(),
                'en_content': editor1.txt.html(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/article/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改文章成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }
        //修改
        var efunb = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'zn_name': $('#ezn_name').val(),
                'en_name': $('#een_name').val(),
                'zn_content': window.editorZnn.txt.html(),
                'en_content': window.editorEnn.txt.html(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/article/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改文章成功');
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

                    $.get('/article/del', {'id': $(event).attr('data-id')}, function (res) {

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
        //添加编辑器
        var E = window.wangEditor;

        var usertermseditor = new E('#usertermseditor');
        //图片名
        usertermseditor.customConfig.uploadFileName = 'img';
        //接口
        usertermseditor.customConfig.uploadImgServer = "/imgHandle";  // 上传图片
        //传递参数 POST
        usertermseditor.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
        usertermseditor.customConfig.uploadImgHooks = {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            fail: function (xhr, editor, result) {
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                editor.customConfig.customAlert(result.data[0]);

            },
            // 图片上传出错时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            error: function (xhr, editor) {
                editor.customConfig.customAlert(result.data[0]);
            },
        };
        //自定义提示方法
        usertermseditor.customConfig.customAlert = function (info) {
            alertify.alert(info);
        };
        usertermseditor.create();

    </script>

    <script>
        //添加编辑器
        var E = window.wangEditor;

        var usertermseditors = new E('#usertermseditors');
        //图片名
        usertermseditors.customConfig.uploadFileName = 'img';
        //接口
        usertermseditors.customConfig.uploadImgServer = "/imgHandle";  // 上传图片
        //传递参数 POST
        usertermseditors.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
        usertermseditors.customConfig.uploadImgHooks = {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            fail: function (xhr, editor, result) {
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
                editor.customConfig.customAlert(result.data[0]);

            },
            // 图片上传出错时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            error: function (xhr, editor) {
                editor.customConfig.customAlert(result.data[0]);
            },
        };
        //自定义提示方法
        usertermseditors.customConfig.customAlert = function (info) {
            alertify.alert(info);
        };
        usertermseditors.create();

    </script>

    <script>

        var userfunc = function (event) {


            var datas = {
                'id': $(event).attr('data-id'),
                'zn_name': 'app用户条款',
                'en_name': 'App User terms',
                'zn_content': usertermseditor.txt.html(),
                'en_content': usertermseditors.txt.html(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/article/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改文章成功');
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
