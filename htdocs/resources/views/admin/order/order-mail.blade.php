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
            <h4 class="pull-left page-title">订单管理</h4>
            <ol class="breadcrumb pull-right">
                <li class="active"><a href="#">Admin Panel</a></li>
                <li class="active"><a href="#">订单管理</a></li>
                <li class="active">邮寄列表</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">邮寄列表</h3></div>
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


                            </div>
                        </div>
                    </div>
                    <!-- 搜索 -->

                </form>

                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">邮寄列表

                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="form-group">
                                        <label>
                                            <text style="font-weight: 400;" id="pname">敬请期待</text>
                                        </label>
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





@endsection
