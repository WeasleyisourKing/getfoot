@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->


    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">设置</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">设置</a></li>
                <li class="active">通用设置</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">通用设置</h3></div>
            <div class="panel-body">
                <!-- Start Form -->


                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <form class="form-horizontal" role="form">

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="title">网站标题（最多20字）<span style="color:red;">＊</span></label>
                                            <div class="col-md-5">
                                                <input type="text" name="title" id="title" class="form-control"
                                                       value="{{$data->title}}" required="required"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="keywords">网站关键字（最多50字）<span style="color:red;">＊</span></label>
                                            <div class="col-md-8">
                                                <input type="text" name="keywords" id="keywords" class="form-control"
                                                       value="{{$data->keywords}}" required="required"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="description">网站描述（最多240字）<span style="color:red;">＊</span></label>
                                                <div class="col-md-8">
                                        <textarea maxlength="240" name="description" id="description"
                                                   class="form-control" rows="5"
                                                  value="">{{$data->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">网站LOGO</label>
                                            <div class="col-md-8 controls">
                                                    <input type="file" name="img" id="uploadfile" multiple class="file-loading"/>
                                            </div>
                                        </div>


                                        <div class="modal-footer col-md-9 col-md-offset-2">
                                            <button type="button" id="sa-save" data-id=""
                                                    class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                                            </button>
                                        </div>

                                    </form>
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
        window.imgAddress = '';
        window.imgId = '';
        $("#uploadfile").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
                @if (!empty($data->logo))


                    "<img class='file-preview-frame' data-fileindex='0' data-template='image' src='{{$data->logo}}'/>",

                @endif
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
        //点击保存
        $('#sa-save').click(function () {

//            if (!imgAddress) {
//                alertify.alert('图片没有上传');
//                return;
//            }

            var datas = {
                'id':1,
                'imgAddress':window.imgAddress,
                'title': $('#title').val(),
                'keywords': $('#keywords').val(),
                'description': $('#description').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/general/editor', datas, function (res) {
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
