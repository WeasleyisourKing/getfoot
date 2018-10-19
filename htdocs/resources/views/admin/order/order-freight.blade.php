@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->


    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">订单管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">订单管理</a></li>
                <li class="active">邮费设置</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">邮费设置</h3></div>
            <div class="panel-body">
                <!-- Start Form -->


                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                当前商品总价小于或等于<b style="color: green;">${{$data->threshold}}</b>需要支付<b style="color: green;">${{$data->freight}}</b>运费</h3></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="threshold">阀值（$）<span
                                                        style="color:red;">✲</span></label>
                                            <div class="col-md-5">
                                                <input type="text" name="threshold" id="threshold" class="form-control"
                                                       value="{{$data->threshold}}" required="required"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="freight">运费（$）<span
                                                        style="color:red;">✲</span></label>
                                            <div class="col-md-5">
                                                <input type="text" name="freight" id="freight" class="form-control"
                                                       value="{{$data->freight}}" required="required"/>
                                            </div>
                                        </div>

                                        <div class="modal-footer col-md-8 col-md-offset-2">
                                            <button type="button" id="sa-save" data-id=""
                                                    class="btn btn-primary waves-effect waves-light"><i
                                                        class="fa fa-save"></i> Save
                                            </button>
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
        //点击保存
        $('#sa-save').click(function () {

            var datas = {
                'threshold': $('#threshold').val(),
                'freight': $('#freight').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/order/freight', datas, function (res) {
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
