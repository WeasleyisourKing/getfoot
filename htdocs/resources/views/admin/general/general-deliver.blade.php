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
                    <h4 class="modal-title">添加商品品牌</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="zn_name">品牌名称（中）（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="zn_name" id="zn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="en_name">品牌名称（英）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="en_name" id="en_name"
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
                    <h4 class="modal-title">添加商品品牌</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ezn_name">品牌名称（中）（最多20字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ezn_name" id="ezn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="een_name">品牌名称（英）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="een_name" id="een_name"
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
            <h4 class="pull-left page-title">设置</h4>
            <ol class="breadcrumb pull-right">
                <li class="active"><a href="#">Admin Panel</a></li>
                <li class="active"><a href="#">设置</a></li>
                <li class="active">邮递设置</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">邮递设置</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <!-- 搜索 -->
                <form class="form-horizontal" role="form">

                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-3">
                            {{--<button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal"--}}
                                    {{--data-target="#add">--}}
                                {{--<i class="fa fa-plus"></i> Add--}}
                            {{--</button>--}}


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
                            <h3 class="panel-title">邮递设置</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="control-label">内容</label>
                                        <div class="controls">
                                            <div id="editor">
                                                <p></p>
                                            </div>
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
        //添加编辑器
        var E = window.wangEditor;

        var editor = new E('#editor');
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

    </script>




@endsection
