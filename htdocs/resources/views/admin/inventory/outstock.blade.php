@extends('admin/layout.app')




@section('add-item-modal-content')
    <!---- 添加模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            操作人1
        </label>
        <small class="text-muted">必填</small>

        <input type="text" id="operator" readonly="readonly" class="form-control" placeholder="操作人姓名">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            创建时间
        </label>

        <input id="NowDate" type="text" class="form-control" readonly="readonly" value="当前时间">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            出库类型
        </label>

        <input type="text" id="inStock" class="form-control" readonly="readonly" value="手动出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">出库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            关联订单
        </label>
        <small class="text-muted">选填</small>

        <input type="text" id="orderId" class="form-control" placeholder="关联的订单号码">
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">必填</small>

        <textarea class="form-control" id="remark" cols="30" rows="4"></textarea>
    </div>
    <!---- 商品列表 ---->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">添加商品</h4>
            </div>
            <div id="content" class="form-group" style="
   			 padding: 10px;">
            </div>
            <div class="panel-body">
                <!---- 搜索并添加商品 ---->
                <div class="form-group col-lg-4">
                    <div class="input-group">
                        <input class="form-control" id="searchString" type="text" placeholder="商品名称或SKU">
                        <span class="input-group-btn">
                            <button onclick="doPostSearch();" class="btn btn-primary waves-effect waves-light"
                                    type="button"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div><!---- End 搜索并添加商品 ---->

                <!---- 添加的商品 ---->
                <div>
                    <table id="table" class="table table-bordered table-striped display">
                    </table>

                    {{--<tbody id="place">--}}
                    {{--<td><img class="" height="60px; align=" middle" src="https://12buy.com/uploads/安慕希正面101118.jpg" alt=""></td>--}}
                    {{--<td><a href="" target="_blank">6907992512570</a></td>--}}
                    {{--<td><a href="" target="_blank">安慕希 希腊风味酸奶 原味 205g Ambrosial Greek Flavored Yoghurt 205g</a></td>--}}
                    {{--<td><input class="form-control" type="number" max="-1" value="-1"></td>--}}
                    {{--<td><input id="datepicker" class="form-control" type="text"></td>--}}
                    {{--</tbody>--}}
                    {{--</table>--}}
                </div><!---- End 添加的商品 ---->

            </div><!---- end panel-body ---->
        </div>
    </div><!---- 商品列表 ---->

@endsection





@section('view-item-modal-content')
    <!---- 查看模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            操作人
        </label>

        <input type="text" id="eoperator" class="form-control" readonly="readonly" value="">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            创建时间
        </label>

        <input type="text" id="date" class="form-control" readonly="readonly" value="">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            出库类型
        </label>

        <input type="text" id="etype" class="form-control" readonly="readonly" value="手动出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">出库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            关联订单
        </label>
        <input type="text" id="eorderId" readonly="readonly" class="form-control" value="">

        {{--<a class="form-control">无</a>--}}
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>

        <textarea class="form-control" id="eremark" cols="30" rows="4" readonly="readonly"></textarea>
    </div>
    <!---- 商品列表 ---->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">商品列表</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-sm-2 text-center">商品图片</th>
                        <th class="col-sm-2 text-center">SKU</th>
                        <th class="col-sm-4 text-center">商品名称</th>
                        <th class="col-sm-2 text-center">变更数量（-）</th>
                        <th class="col-sm-1 text-center">实时库存</th>
                        <th class="col-sm-1 text-center">过期时间</th>
                    </tr>
                    </thead>

                    <tbody id="orderDeal">

                    </tbody>
                </table>
            </div>
        </div>
    </div><!---- 商品列表 ---->
@endsection

@section('view-bunsiess-modal-content')
    <!---- 查看模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            操作人
        </label>

        <input type="text" id="beoperator" class="form-control" readonly="readonly" value="">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            创建时间
        </label>

        <input type="text" id="bdate" class="form-control" readonly="readonly" value="">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            出库类型
        </label>

        <input type="text" id="betype" class="form-control" readonly="readonly" value="手动出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">出库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            关联订单
        </label>
        <input type="text" id="beorderId" class="form-control" readonly="readonly" value="">

        {{--<a class="form-control">无</a>--}}
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>

        <textarea class="form-control" id="beremark" cols="30" rows="4" readonly="readonly"></textarea>
    </div>
    <!---- 商品列表 ---->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">商品列表</h4>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-sm-2 text-center">商品图片</th>
                        <th class="col-sm-2 text-center">SKU</th>
                        <th class="col-sm-4 text-center">商品名称</th>
                        <th class="col-sm-2 text-center">变更数量（-）</th>
                        <th class="col-sm-1 text-center">实时库存</th>
                        <th class="col-sm-1 text-center">过期时间</th>
                    </tr>
                    </thead>

                    <tbody id="borderDeal">

                    </tbody>
                </table>
            </div>
        </div>
    </div><!---- 商品列表 ---->
@endsection



@section('content')
<div class="row " id="xxcctty">

    <!---- 头部标题及导航链接 ---->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">出库</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

    <!---- 搜索及按钮功能区域 ---->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-12">
                            <!-- Add 按钮 -->
                            <button class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#add-item-modal" id="add-item-btn">Add <i class="fa fa-plus"></i>
                            </button><!-- End Add 按钮 -->
                        </div>

                        {{--<div class="col-sm-12 m-t-10">--}}
                            {{--<!-- 批量操作按钮 -->--}}
                            {{--<div class="btn-group dropdown">--}}
                                {{--<button id="bulk-btn" type="button" class="btn btn-warning waves-effect waves-light">--}}
                                    {{--Bulk <i class="fa fa-check-square-o"></i></button>--}}
                                {{--<button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light"--}}
                                        {{--data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>--}}
                                {{--<ul class="dropdown-menu" role="menu">--}}
                                    {{--<li><a href="">打印</a></li>--}}
                                    {{--<li class="divider"></li>--}}
                                    {{--<li class="text-danger"><a href="javascript:viod(0);" id="delete_btn">删除</a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                            {{--<!-- 批量操作按钮 -->--}}
                        {{--</div>--}}

                    </div><!---- End row ---->

                </div>
            </div>
        </div>
    </div><!---- End 搜索及按钮功能区域  ---->

    <!---- 库存列表 ---->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <!-- 数据表 -->
                    <table class="table table-bordered table-striped display" id="datatable-buttons">
                        <thead>
                        <tr>
                            <th>库存编号</th>
                            <th>出库类型</th>
                            <th>操作人</th>
                            <th>创建时间</th>
                            <th>关联订单</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($res as $item)
                            <tr>
                                <!---- 选择框及编号 ---->
                                <td>
                                    {{$item->order_no}}
                                    {{--<div class="checkbox checkbox-success">--}}
                                        {{--<input id="item-checkbox-id" type="checkbox" name="image_input"--}}
                                               {{--value="{{$item->id}}" class="item-checkbox">--}}
                                        {{--<label for="item-checkbox-id">--}}
                                            {{--{{$item->order_no}}--}}
                                        {{--</label>--}}
                                    </div>
                                </td><!---- 选择框及编号 ---->
                                @if($item->type != 1)
                                    <td>手动</td>
                                @else
                                    <td>自动</td>
                                @endif
                                <td> {{$item->operator}}</td>
                                <td>{{$item->created_at}}</td>
                                @if ($item->pruchase_order_no  == -1 || $item->pruchase_order_no  == -2)
                                <td></td>
                                 @else
                                  <td>{{$item->pruchase_order_no}}</td>
                                @endif
                                @if($item->state != 1 || $item->type != 2)
                                    <td>已审核出库</td>
                                @else
                                    <td class="text-info">等待审核</td>
                            @endif
                            <!-- 操作按钮 -->
                                <td class="actions">
                                {{--@if ($item->state == 1 && $item->type == 2)--}}
                                {{--<button class="btn-sm btn-success waves-effect waves-light btn-sm btn-info"--}}
                                {{--data-id="{{$item->id}}" onclick="check(this);"><i--}}
                                {{--class="fa fa-check"></i></button><!---- End 编辑按钮 ---->--}}
                                {{--@endif--}}
                                <!---- 查看按钮 ---->
                                    <button data-id="{{$item->id}}" onclick="sse(this);"
                                            class="btn-sm btn-success waves-effect waves-light edit-item-btn"><i
                                                class="fa fa-eye"></i></button><!---- End 编辑按钮 ---->
                                    <!---- 删除按钮 ---->


                                    @if($item->state == 1 && $item->type == 2  && (Auth::user()->role == 1))
                                        <button data-id="{{$item->id}}" onclick="del(this);"
                                                class="btn-sm btn-danger waves-effect waves-light delete-item-btn"><i
                                                    class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
                                    @endif

                                </td><!-- 操作按钮 -->
                            </tr>
                        @endforeach

                        </tbody>
                    </table><!-- End 数据表 -->
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">

                    <div class="row">
                        <h1>商业订单</h1>
                    </div><!---- End row ---->

                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <!-- 数据表 -->
                    <table class="table table-bordered table-striped display" id="datatable1">
                        <thead>
                        <tr>
                            <th>库存编号</th>
                            <th>出库类型</th>
                            <th>操作人</th>
                            <th>创建时间</th>
                            <th>关联订单</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pruchase as $item)
                            <tr>
                                <!---- 选择框及编号 ---->
                                <td>
                                    {{$item->order_no}}
                                    {{--<div class="checkbox checkbox-success">--}}
                                        {{--<input id="item-checkbox-id" type="checkbox" name="image_input"--}}
                                               {{--value="{{$item->id}}" class="item-checkbox">--}}
                                        {{--<label for="item-checkbox-id">--}}
                                            {{--{{$item->order_no}}--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                </td><!---- 选择框及编号 ---->
                                @if($item->type != 1)
                                    <td>手动</td>
                                @else
                                    <td>自动</td>
                                @endif
                                <td> {{$item->operator}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->pruchase_order_no}}
                                </td>
                                @if($item->state != 1 || $item->type != 2)
                                    <td>已审核出库</td>
                                @else
                                    <td class="text-info">等待审核</td>
                            @endif
                            <!-- 操作按钮 -->
                                <td class="actions">
                                <!---- 查看按钮 ---->
                                    <button data-id="{{$item->id}}" onclick="bunsiessSse(this);"
                                            class="btn-sm btn-success waves-effect waves-light edit-item-btn"><i
                                                class="fa fa-eye"></i></button><!---- End 编辑按钮 ---->
                                    <!---- 删除按钮 ---->


                                    @if($item->state == 1 && $item->type == 2  && (Auth::user()->role == 1))
                                        <button data-id="{{$item->id}}" onclick="del(this);"
                                                class="btn-sm btn-danger waves-effect waves-light delete-item-btn"><i
                                                    class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
                                    @endif

                                </td><!-- 操作按钮 -->
                            </tr>
                        @endforeach

                        </tbody>
                    </table><!-- End 数据表 -->
                </div>
            </div>
        </div>
    </div><!---- End 库存列表 ---->





    <!---- 弹窗 ---->
    <!---- 添加 ---->
    <div id="add-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-plus"></i> 新建一条出库记录</h3>
                </div>
                <div class="modal-body">
                    <div class="row">



<!---- 添加模态框内容 ---->
<div class="form-group col-lg-4">
    <label for="" class="control-label">
        操作人
    </label>
    <small class="text-muted">必填</small>

    <input type="text" id="operator" readonly="readonly" class="form-control" placeholder="操作人姓名">
</div>

<div class="form-group col-lg-4">
    <label for="" class="control-label">
        创建时间
    </label>

    <input id="NowDate" type="text" class="form-control" readonly="readonly" value="当前时间"
        data-date-format="yyyy-mm-dd">
</div>

<div class="form-group col-lg-4">
        <label for="" class="control-label">
            出库类型
        </label>

        <input type="text" id="inStock" class="form-control" readonly="readonly" value="手动出库">
        {{-- <select class="form-control" name="" id="">
            <option value="">出库</option>
            <option value="">出库</option>
        </select> --}}
    </div>

<div class="form-group col-lg-4">
    <label for="" class="control-label">
        关联订单
    </label>
    <small class="text-muted">选填</small>

    <input type="text" id="orderId" class="form-control" placeholder="关联的订单号码">
</div>
<div class="form-group col-lg-8">
    <label for="" class="control-label">
        备注
    </label>
    <small class="text-muted">必填</small>

    <textarea class="form-control" id="remark" cols="30" rows="4"></textarea>
</div>
<!---- 商品列表 ---->
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">添加商品</h4>
        </div>
        <div id="content" class="form-group" style=" padding: 20px;">

            <!-- <div class="form-group DeleteThat panel" style="padding:20px;" >
                <div class="input-group" v-for="item1 in addList">
                    <div style="line-height: 34px;">@{{item1.zn_name}}</div>
                    <span style="width: 15%; padding: 10px; " class="input-group-btn">
                        <el-select v-model="item1.value" placeholder="请选择">
                            <el-option
                            v-for="item in item1.shelvesList"
                            :key="item.shelves_id"
                            :label="item.name"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </span>
                    <span style="padding: 10px;width:5%; " class="input-group-btn  ">
                        <button class="btn-sm btn-danger waves-effect waves-light " @click="addshelve(item1) " ><i class="fa fa-plus"></i>
                        </button>
                    </span>
                    <span style="padding: 10px;width:50%; " class="input-group-btn  ">
                    <div class="form-group" v-for="item11 in item1.addshelves">
                        <span class="input-group-btn  ">@{{item11.name}}</span>
                    </div>
                    
                    </span>
                    <span style="padding: 10px; " class="input-group-btn  ">
                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis" onclick="Delete1(this)" ><i class="fa fa-trash"></i>
                        </button>
                    </span>    
                </div>
            </div> -->

                <el-row v-for="(item1,index) in addList"  style="padding:10px;
                display:flex;
                align-items:center;
                border:1px solid #eee;
                border-radius: 5px;
                margin-top:10px;
                ">
                    <el-col :span="3">@{{item1.zn_name}}</el-col>
                    <el-col :span="3" style="padding-right:5px">
                        <el-select v-model="item1.value" placeholder="请选择">
                            <el-option
                            v-for="item in item1.shelvesList"
                            :key="item.shelves_id"
                            :label="item.name"
                            size="mini"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :span="1">
                        <button class="btn-sm btn-danger waves-effect waves-light " @click="addshelve(item1) " ><i class="fa fa-plus"></i>
                        </button>
                    </el-col>
                    <el-col :span="16">
                        &nbsp
                        <el-col v-for="(item11,index1) in item1.addshelves" style="padding:5px 0">
                            <el-col :span="5" class="text-center"> @{{item11.name?item11.name:'空'}}</el-col>
                            <el-col :span="8" class="text-center"> @{{item11.overdue+'('+item11.count+')'}}</el-col>
                            <el-col :span="8" style="padding-right:5px;">
                                <el-input size="mini" v-model="item11.need_count" placeholder="请输入内容"></el-input>
                            </el-col>
                            <el-col :span="3">
                                <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis" @click="Delete2(item1,index1)" ><i class="fa fa-trash"></i>
                                </button>
                            </el-col>
                        </el-col>
                    </el-col>
                    <el-col :span="1">
                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis" @click="Delete1(index)" ><i class="fa fa-trash"></i>
                        </button>
                    </el-col>
                    
                </el-row>

        </div>
        <div class="panel-body">
            <!---- 搜索并添加商品 ---->
            <div class="form-group col-lg-4">
                <div class="input-group">
                    <input class="form-control" id="searchString" type="text" placeholder="商品名称或SKU">
                    <span class="input-group-btn">
                        <button @click="doPostSearch();" class="btn btn-primary waves-effect waves-light"
                                type="button"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </div><!---- End 搜索并添加商品 ---->

            <!---- 添加的商品 ---->
            <div>

                <table id="table" class="table table-bordered table-striped display">

                <thead>
                    <tr v-if="seachList.length>0?true:false">
                        <th class="col-md-2 col-lg-2 exce"> 商品名称</th>
                        <th class="col-md-1 col-lg-1 exce">  SKU</th>
                        <th class="col-md-2 col-lg-2 exce"> 商品图片</th> 
                        <th class="col-md-2 col-lg-2 exce">成本价（$）</th>
                        <th class="col-md-2 col-lg-2 exce"> 实际库存</th>
                        <th class="col-md-2 col-lg-2 exce"> 冻结库存</th>
                        <th class="col-md-1 col-lg-1 exce">操作</th>
                     </tr>
                </thead>
                
                <tbody id="postContainer">

                <tr v-for="item in seachList">
                    <td class="exce">@{{item.zn_name}}<br/>@{{item.en_name}}</td>
                    <td class="exce">@{{item.sku}}</td>
                    <td class="exce"><img height="100px;" align=" middle"
                                    v-bind:src="item.product_image"
                                    alt="没有上传"/>
                    </td>
                    <td class="exce">@{{item.price}}</td>
                    <td class="exce">@{{item.origin_stock}}</td>
                    <td class="exce">@{{item.frozen_stock}}</td>
                    <td class="exce">
                        <a title="添加商品"
                            class="btn btn-small btn-success"
                            href="javascript:void (0);"
                            @click="funOrder(item)">
                            <i class="icon fa fa-shopping-basket"> </i>
                        </a>
                    </td>
                </tr>

                </tbody>
                </table>

            </div><!---- End 添加的商品 ---->

        </div><!---- end panel-body ---->
    </div>
</div><!---- 商品列表 ---->




                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-info waves-effect waves-light" id="save-item-btn"><i
                                class="fa fa-save"></i> Save
                    </button> -->
                    <button type="button" class="btn btn-info waves-effect waves-light" @click="save"><i
                                class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>

        </div>
    </div><!---- End 添加 ---->

<div> <!--startprint-->

</div><!--endprint-->
    <!---- 查看 ---->
    <div id="view-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">

            <div class="modal-content" id="printOne"> 
            <!--startprint-->

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-eye"></i> 查看记录</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('view-item-modal-content')
                    </div>

                </div> 
            <!--endprint-->
                <div class="modal-footer">
                    <button type="button" onclick="dealStock(this);" data-status="1" id="sure"
                            style="display: none;" class="btn btn-success waves-effect pull-left">确认出库
                    </button>
                    {{--<button type="button" id="start" data-status="1"--}}
                            {{--style="display: none;" class="btn btn-small btn-info waves-effect pull-left"><i class="fa fa-unlock-alt"></i>--}}
                    {{--</button>--}}
                    <a href="##"  id="Print" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div><!---- End 查看 ---->
    <div id="view-bunsiess-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">

            <div class="modal-content" id="printTwo"> 
            <!--startprinn-->

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-eye"></i> 查看记录</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('view-bunsiess-modal-content')
                    </div>

                </div> 
            <!--endprinn-->

                <div class="modal-footer">
                    <button type="button" onclick="dealStock(this);" data-status="1" id="bsure"
                             class="btn btn-success waves-effect pull-left">确认出库
                    </button>

                    <a href="##" id="bPrint" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div><!---- End 查看 ---->
    </div>
    <script>
    var vm = new Vue({
        el: '#xxcctty',
        data: {
            seachList:[],
            addList:[],
            value: '',
            abc:true
        },
        methods: {
            doPostSearch(){
                $.get('/stock/search', {'value': $('#searchString').val()}, function (res) {
                    if (res.status) {
                        if (res.data.length == 0) {
                            alertify.alert('搜索不到数据');
                            return;
                        } else {
                            vm.seachList=res.data
                        }
                    }    else {
                        alertify.alert(res.message);
                    }
                })
            },
            funOrder(item){
                var a=true
                for( var i=0;i<vm.addList.length;i++){
                    if(vm.addList[i].product_id==item.id){
                        a=false
                            alertify.alert('商品不能重复');
                        return
                    }
                }
                if(a){

                    $.get('/select/shelves', {'id': item.id}, function (res) {
                        if (res.status) {
                            if (res.data.length == 0) {
                                alertify.alert('该商品在货架中不存在');
                                return;
                            } else {
                                res.data.forEach((item1,index)=>{
                                    item1.id=index+""
                                })
                                let addList1={
                                    product_image:item.product_image,
                                    zn_name:item.zn_name,
                                    en_name:item.en_name,
                                    sku:item.sku,
                                    number:item.number,
                                    innersku:item.innersku,
                                    product_id:item.id,
                                    value:'',
                                    shelvesList:res.data,
                                    addshelves:[
                                    ]
                                }
                                vm.addList.push(addList1);
                            }
                        }
                        console.log(res)
                    })
                }
            },
            addshelve(item){
                var a=true
                var b=""
                if(item.value==''){

                    alertify.alert('请选择货架');
                    return
                }
                // console.log(item.value)
                item.addshelves.forEach((item1)=>{
                    if(item1.id==item.value){
                        a=false
                        alertify.alert('该商品下不能重复添加同批次商品');
                        return;
                    }
                })
                if(a){
                    b=item.shelvesList[item.value]
                    b.need_count=0
                    item.addshelves.push(b)
                }
                console.log(item)
            },
            Delete1(index){
                vm.addList.splice(index,1)
            },
            Delete2(item,index){
                item.addshelves.splice(index,1)
            },
            save(){
                // save-item-btn1
                 if(true){
//                    if(vm.abc){
                    vm.abc=false;
                    var b=0;
                    var products=[],
                    uproducts=[],
                    num=0
                    vm.addList.forEach((item)=>{
                        var c=0,
                            e=[]
                        if( item.addshelves.length >0 ){
                            item.addshelves.forEach((item1)=>{
                                if(item1.need_count>0){
                                    c+=item1.need_count*1
                                }else{
                                    b++
                                    alertify.alert(`商品(${item.zn_name})数量不能为空`);
                                    return false
                                }
                                e.push({
                                'product_id': item1.product_id,
                                "count": item1.need_count*1,
                                'overdue':item1.overdue,
                                'shelves_id':item1.shelves_id
                                })
                            })
                        }else{
                            b++
                            alertify.alert(`商品(${item.zn_name})未添加分配`);
                            return false
                        }
                        products.push({
                            'product_id': item.product_id,
                            "count": c
                        })
                        uproducts.push({
                            'product_id': item.product_id,
                            "count": c,
                            'postion':e
                        })
                        num+=c*1
                    })
                    if(b==0){
                        var datas = {
                            'products':JSON.stringify(products) ,
                            'uproducts':JSON.stringify(uproducts) ,
                            'operator': $('#operator').val(),
                            'num': num,
                            'orderId': $('#orderId').val(),
                            'remark': $('#remark').val(),
                            '_token': '{{csrf_token()}}'
                        };
                        $.post('/out/stock/deal/order', datas, function (res) {
                            if (res.status) {
                                alertify.success('创建出库订单成功')
                                vm.abc=true
                                setTimeout(function () {
                                    location.reload();
                                }, 1500)
                            } else {
                                alertify.alert(res.message)
                                vm.abc=true
                            }
                        })

                    }else{
                        vm.abc=true
                    }
                }
            }
        },
        })

    </script>


    <!---- End 弹窗 ---->
    <script>
        $('#operator').val('{{ Auth::user()->username }}');
        $('#orderId').val('');
        $('#remark').val('');
        $('#searchString').val('');
        $('#NowDate').val('当前时间');
        $('#inStock').val('手动出库');

        $('#start').click(function() {
            if ($(this).attr('data-status') != 2) {
                $(this).find('i').removeClass('fa fa-unlock-alt').addClass('fa fa-unlock');
                $(this).attr('data-status',2);
                $('input[name=editcount]').removeAttr('readonly');
                $('input[name=editdate]').removeAttr('readonly');
                $('.datepickers').datepicker({
                    numberOfMonths: 3,
                    showButtonPanel: true,
                });
                ++window.count;
            } else {
                $(this).find('i').removeClass('fa fa-unlock').addClass('fa fa-unlock-alt');
                $(this).attr('data-status',1);
                $('input[name=editcount]').attr('readonly','readonly');
                $('input[name=editdate]').attr('readonly','');
                $('.datepickers').unbind();
                ++window.count;
            }

        })
        var check = function (evnet) {
            alertify.confirm("确认出库吗？", function (e) {
                if (e) {
                    $.get('/stock/check', {'id': $(evnet).attr('data-id'), 'status': 2}, function (res) {
                        if (res.status) {

                            alertify.success('入库成功');
                            window.obj = [];
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

        //点击添加
        $('#save-item-btn').click(function () {
            // save-item-btn1
            $('#save-item-btn').removeAttr('disabled');
            window.obj = [];
            window.objs = [];
            var i = 0;
            $("input[name='productNumber']").each(function () {

                if ($(this).val() != 0) {
                    window.obj.push({
                        'product_id': $(this).attr('data-id'),
                        "count": $(this).val()
                    });
                    window.objs.push({
                        'product_id': $(this).attr('data-id'),
                        'overdue': $(this).parent().next().find('input').val(),
                        "count": $(this).val()
                    });
                    i += Number($(this).val());
                }


            });

            var datas = {
                'products': window.obj,
                'uproducts': window.objs,
                'operator': $('#operator').val(),
                'num': i,
                'orderId': $('#orderId').val(),
                'remark': $('#remark').val(),
                '_token': '{{csrf_token()}}'
            };
            console.log(datas);
            $.post('/out/stock/deal/order', datas, function (res) {
                if (res.status) {
                    alertify.success('创建出库订单成功');
                    $('#save-item-btn').attr('disabled', "false");
                    window.obj = [];
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                    $('#save-item-btn').removeAttr('disabled');
                }
            })

        })
        //删除
        var del = function (event) {

            alertify.confirm("确认删除吗？", function (e) {
                if (e) {

                    $.get('/enter/stock/order/del', {'id': $(event).attr('data-id')}, function (res) {

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

        var sse = function (event) {
            $.get('/out/stock/order/deal', {'id': $(event).attr('data-id')}, function (res) {

                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        var datas = '';
//                        for (let i in res.data.purchase) {
//
//                            var dates = res.data.purchase[i].overdue == null ? `<input class="form-control datepickers"  data-date-format="yyyy-mm-dd"
//                                 value="" name="editdate" readonly="readonly" type="text">`: `<input class="form-control datepickers" data-date-format="yyyy-mm-dd"
//                              name="editdate" value="${res.data.purchase[i].overdue}" readonly="readonly"  type="text">`;
//                            datas += `<tr>
//                                <td><img height="60px; align=" middle" src="${res.data.purchase[i].products.product_image}" alt="没有上传"></td>
//                                <td >${res.data.purchase[i].products.sku}</td>
//                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
//                                  <td><input type="text" data-id="${res.data.purchase[i].products.id}" name="editcount" class="form-control" readonly="readonly" value="${res.data.purchase[i].count}"></td>
//                                 <td><p class="text-center "style="padding-top:5px">${res.data.purchase[i].products.stock}</p></td>
//                               <td>${dates}</td>
//                            </tr>`;
//
//                        }
                        for (let i in res.data.purchase) {

                            var dates = res.data.purchase[i].overdue == null ? '' : `${res.data.purchase[i].overdue}`;
                            datas += `<tr>
                                <td><img height="60px; align=" middle" src="${res.data.purchase[i].products.product_image}" alt="没有上传"></td>
                                <td class="text-center">${res.data.purchase[i].products.sku}</td>
                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
                              <td><p class="text-center">${res.data.purchase[i].count}</p><input type="hidden" data-id="${res.data.purchase[i].products.id}" name="editcount" class="form-control" readonly="readonly" value="${res.data.purchase[i].count}"></td>
                                 <td><p class="text-center">${res.data.purchase[i].products.stock}</p></td>
                               <td>${dates}</td>
                            </tr>`;

                        }
                    }

                    if (res.data.pruchase_order_no != -1 && res.data.pruchase_order_no != -2) {
                        $('#eorderId').val(res.data.pruchase_order_no);
                        $('#eorderId').attr('value', res.data.pruchase_order_no);
                    } else {
                        $('#eorderId').val('');
                        $('#eorderId').attr('value', '');
                    }
                    $('#eoperator').val(res.data.operator);
                    $('#date').val(res.data.created_at);
                    $('#eremark').text(res.data.remark);

                    $('#eoperator').attr('value', res.data.operator);
                    $('#date').attr('value', res.data.created_at);
                    if (res.data.type == 1) {
                        $('#etype').val('自动出库');
                        $('#etype').attr('value', '自动出库');
                    } else {
                        $('#etype').val('手动出库');
                        $('#etype').attr('value', '手动出库');
                    }
                    $('#sure').attr('data-id', res.data.id);
                    $('#bsure').attr('data-status', 1);
//                $('#not').attr('data-id', res.data.id);
                    window.count = 0;
                    @if (in_array(Auth::user()->role,$auth))
                    if (res.data.state == 1 && res.data.type == 2) {
                        //未审核 手动 需要审核
                        $('#sure').show();
                        //显示锁
                        $('#start').attr('data-status', 1).show().find('i').removeClass('fa fa-unlock').addClass('fa fa-unlock-alt');
                    } else {
                        $('#sure').hide();
                        $('#start').hide();
                    }
                    @endif
                    alertify.success('获取成功');

                    $('#orderDeal').html(datas);
                    $('#view-item-modal').modal('show');
                    $("#Print").click(

                        function () {
                            $("#printOne .modal-footer").hide()
                            bdhtml = $("#printOne").html();
                            bdhtmll = window.document.body.innerHTML;
                            sprnstr = "<!--startprint-->";
                            eprnstr = "<!--endprint-->";
                            prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
                            prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
                            window.document.body.innerHTML = bdhtml;
                            window.print();
                            window.location.reload()
                        })
                } else {
                    alertify.alert(res.message);
                }
            })
        }

//        $("#Print").click(
//            function () {
//                bdhtml = window.document.body.innerHTML;
//                bdhtmll = window.document.body.innerHTML;
//                sprnstr = "<!--startprint-->";
//                eprnstr = "<!--endprint-->";
//                prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
//                prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
//                window.document.body.innerHTML = prnhtml;
//                window.print();
//                window.location.reload()
//            })

        var bunsiessSse = function (event) {
            $.get('/out/stock/order/deal', {'id': $(event).attr('data-id')}, function (res) {

                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        var datas = '';
                        for (let i in res.data.purchase) {

                            var dates = res.data.purchase[i].overdue == null ? '' : `${res.data.purchase[i].overdue}`;
                            datas += `<tr>
                                <td><img height="60px; align=" middle" src="${res.data.purchase[i].products.product_image}" alt="没有上传"></td>
                                <td class="text-center">${res.data.purchase[i].products.sku}</td>
                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
                              <td><p class="text-center">${res.data.purchase[i].count}</p><input type="hidden" data-id="${res.data.purchase[i].products.id}" name="editcount" class="form-control" readonly="readonly" value="${res.data.purchase[i].count}"></td>
                                 <td><p class="text-center">${res.data.purchase[i].products.stock}</p></td>
                               <td>${dates}</td>
                            </tr>`;

                        }
                    }

                    $('#beoperator').val(res.data.operator);
                    $('#beorderId').val(res.data.pruchase_order_no);
                    $('#bdate').val(res.data.created_at);
                    $('#beremark').text(res.data.remark);

                    $('#beoperator').attr('value', res.data.operator);
                    $('#beorderId').attr('value', res.data.pruchase_order_no);
                    $('#bdate').attr('value', res.data.created_at);
                    if (res.data.type == 1) {
                        $('#betype').val('自动出库');
                        $('#betype').attr('value', '自动出库');
                    } else {
                        $('#betype').val('手动出库');
                        $('#betype').attr('value', '手动出库');
                    }
                    if (res.data.state != 1) {
                        $('#bsure').hide();
                    } else {}
                    $('#bsure').attr('data-id', res.data.id);
                    $('#bsure').attr('data-status', 2);
                    alertify.success('获取成功');

                    $('#borderDeal').html(datas);
                    $('#view-bunsiess-modal').modal('show');
                    $("#bPrint").click(
                        function () {
                            $("#printTwo .modal-footer").hide()
                            bdhtml =  $("#printTwo").html();
                            bdhtmll = window.document.body.innerHTML;
                            sprnstr = "<!--startprinn-->";
                            eprnstr = "<!--endprinn-->";
                            prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
                            console.log(prnhtml)
                            prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
                            console.log(prnhtml)
                            window.document.body.innerHTML = bdhtml;
                            window.print();
                            window.location.reload()
                        })
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>


    <script>

        //搜索库存
        function doPostSearch() {

            $.get('/stock/search', {'value': $('#searchString').val()}, function (res) {

                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        var datas = '<thead>' +
                            ' <tr>' +
                            ' <th class="col-md-2 col-lg-2 exce"> 商品名称</th>' +
                            ' <th class="col-md-1 col-lg-1 exce">  SKU</th>' +
                            '<th class="col-md-2 col-lg-2 exce"> 商品图片</th> ' +
                            '<th class="col-md-2 col-lg-2 exce">成本价（$）</th>' +
                            '<th class="col-md-2 col-lg-2 exce"> 实际库存</th> ' +
                            '<th class="col-md-2 col-lg-2 exce"> 冻结库存</th> ' +
                            '<th class="col-md-1 col-lg-1 exce">操作</th>' +
                            ' </tr>' +
                            ' </thead><tbody id="postContainer">';

                        for (let i in res.data) {

                            datas += `<tr>
                                     <td class="exce">${res.data[i].zn_name}<br/>${res.data[i].en_name}</td>
                                   <td class="exce">${res.data[i].sku}</td>
                                        <td class="exce"><img height="100px; align=" middle"
                                                    src="${res.data[i].product_image}"
                                                    alt="没有上传"/>
                                                </td>
                                         <td class="exce">${res.data[i].price}
                                                </td>
                                                   <td class="exce">${res.data[i].stock + res.data[i].frozen_stock}</td>
                                                    <td class="exce">${res.data[i].frozen_stock}</td>
                                           <td class="exce">
                        <a title="添加商品" data-id="${res.data[i].id}" data-name="${res.data[i].zn_name}（${res.data[i].en_name}）"
                                                       class="btn btn-small btn-success"
                                                       href="javascript:void (0);"
                                                       onclick="funOrder(this)">
                                                        <i class="icon fa fa-shopping-basket"> </i>
                                                    </a>
                                                </td>
                                  </tr>`;
                        }
                        datas += ' </tbody>';
                    }
                    alertify.success('获取成功');
//                    $('#link').hide();
                    $('#table').html(datas);
                    jQuery('.datepicker').datepicker({
                        numberOfMonths: 3,
                        showButtonPanel: true,
                    });
                } else {
                    alertify.alert(res.message);
                }
            })
        }

        window.arr = [];
        var funOrder = function (event) {

            if ($("input[name='productNumber']").length > 0) {
                //重复添加

                if (arr.indexOf($(event).attr('data-id')) == -1) {

                    $('#content').append(`  <div class="form-group DeleteThat panel" style="padding:20px;" id='list${$(event).attr('data-id')}'>
                        <div class="input-group" >
                            <text style="line-height: 34px; width: 69%;">${$(event).attr('data-name')}</text>
                            <span style="width: 30%; padding: 10px; " class="input-group-btn">
                                           <input name="productNumber" data-id="${$(event).attr('data-id')}"  class="form-control"
                                                  placeholder="数量"  type="text">
                                                    </span>
                                                    <span style="width: 30%;" class="input-group-btn">
                                           <input class="form-control datepicker" data-date-format="yyyy-mm-dd"
                                                  placeholder="批次过期时间 选填"  type="text">
                                                    </span>
                                                    <span style="padding: 10px; " class="input-group-btn ">
                                                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis " data-id="${$(event).attr('data-id')}" onclick="Delete1(this)"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </span>

                        </div>

                    </div>`);
                    window.arr.push($(event).attr('data-id'));
                } else {
                    return;
                }


            } else {
                $('#content').append(`  <div class="form-group DeleteThat panel" style="padding:20px;" id='list${$(event).attr('data-id')}'>
                        <div class="input-group" >
                            <text style="line-height: 34px; width: 69%;">${$(event).attr('data-name')}</text>
                            <span style="width: 30%; padding: 10px; " class="input-group-btn">
                                           <input name="productNumber" data-id="${$(event).attr('data-id')}"  class="form-control"
                                                  placeholder="数量"  type="text">
                                                    </span>
                                                    <span style="width: 30%;" class="input-group-btn">
                                           <input class="form-control datepicker" data-date-format="yyyy-mm-dd"
                                                  placeholder="批次过期时间 选填"  type="text">
                                                    </span>
                                                    <span style="padding: 10px; " class="input-group-btn ">
                                                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis " data-id="${$(event).attr('data-id')}" onclick="Delete1(this)"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </span>

                        </div>

                    </div>`);

                window.arr.push($(event).attr('data-id'));


            }
            jQuery('.datepicker').datepicker({
                numberOfMonths: 3,
                showButtonPanel: true,
            });

        }

    </script>

    <script>
        //处理订单
        var dealStock = function (event) {


            window.obj = [];
            window.objs = [];
            var i = 0;
//            datas.status = 2;
            $("input[name='editcount']").each(function () {

                if ($(this).val() != 0) {
                    window.obj.push({
                        'product_id': $(this).attr('data-id'),
                        "count": $(this).val()
                    });
                    window.objs.push({
                        'product_id': $(this).attr('data-id'),
                        'overdue': $(this).parent().nextAll().find('input.datepickers').val(),
                        "count": $(this).val()
                    });
                    i += Number($(this).val());
                }


            });
            var datas = {
                'id': $(event).attr('data-id'),
                'products': window.obj,
                'uproducts': window.objs,
                'status': $(event).attr('data-status'),
                '_token': '{{csrf_token()}}',
                'num': i
            };

            $.post('/stock/out/confirm', datas, function (res) {
                if (res.status) {
                    window.count = 0;
                    alertify.success('处理成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }


        var Delete1 = function (event) {

            if (window.arr.indexOf($(event).attr('data-id')) == -1) {
                return;
            } else {
                var index = window.arr.indexOf($(event).attr('data-id'));
                $('#list' + $(event).attr('data-id')).remove();
                window.arr.splice(index, 1);
            }

        }
    </script>
@endsection