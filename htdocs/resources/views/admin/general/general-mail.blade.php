@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">设置</h4>
            <ol class="breadcrumb pull-right">
                <li class="active"><a href="#">Admin Panel</a></li>
                <li class="active"><a href="#">设置</a></li>
                <li class="active">邮件设置</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">邮件设置</h3></div>
            <div class="panel-body">
            {{--<div class="col-sm-3">--}}
            {{--<select class="form-control" id="brand">--}}
            {{--<option selected="selected" id="brand1" value="">请选择商品品牌</option>--}}

            {{--<option value="w">234</option>--}}

            {{--</select>--}}


            {{--</div>--}}
            <!-- Start Form -->

                <!-- 搜索 -->
                <form class="form-horizontal" role="form">

                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-3" >

                        </div>

                        <div class="col-sm-3 col-md-offset-6">
                            <select class="form-control" id="shop">

                                {{--<option id="shop1" value="1">注册</option>--}}

                                <option id="shop2" value="2">商品下单（用户接收）</option>

                                {{--<option id="shop3" value="3">商品发货</option>--}}

                                {{--<option id="shop4" value="4">商品到货</option>--}}

                                <option id="shop5" value="5">商品下单（商家接收）</option>

                            </select>
                        </div>
                    </div>
                    <!-- 搜索 -->

                </form>

                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        {{--<div class="panel-heading">--}}
                            {{--<h3 class="panel-title">邮件设置</h3>--}}
                        {{--</div>--}}
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label class="control-label">参数</label>
                                        <div class="controls">
                                            <div style="border:1px solid #ccc; height: 150px;padding:10px 10px 10px 10px;overflow-y: auto;" >

                                                @foreach($params as $items)
                                                    <script>
                                                        console.log(<?php echo json_encode($items)?>)
                                                    </script>
                                                    <div style=" float: left;width:450px;line-height:30px;">{{$items['zn']}} : {{$items['val']}}</div>
                                                    @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">内容</label>
                                        <div class="controls">
                                            <div id="editor">
                                                <p>{!! $data !!}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="modal-footer col-md-10 col-md-offset-2">
                            <button type="button" id="save" data-id="{{$status}}"
                                    class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                            </button>
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



    <script>
        //跳转 显示
        $('#shop' + {{$status}}).attr('selected', 'selected');

        $('#shop').change(function () {
            //1 注册 2 下单 3 发货 4 到货

            window.location.href = '/set/mail/status/' + $(this).val();

        })

    </script>

    <script>
        //提交修改内容
//        en_editor.txt.html(),
        $('#save').click(function() {

            $.post('/general/mail/modify', {'id': $(this).attr('data-id'),'text':editor.txt.html(),  '_token': '{{csrf_token()}}'}, function (res) {

                if (res.status) {
                    alertify.success('修改成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        })
    </script>
@endsection
