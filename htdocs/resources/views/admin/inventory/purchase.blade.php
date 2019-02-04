@extends('admin/layout.app')




@section('add-item-modal-content')

@endsection





@section('view-item-modal-content')
    <!---- 查看模态框内容 ---->







@endsection





@section('content')
<!-- vue作用域 -->

<div class="row" id="xxcctty">

    <!---- 头部标题及导航链接 ---->
    <div class="row hidden_p">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">采购订单</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

    <!---- 搜索及按钮功能区域 ---->
    <div class="row hidden_p">
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

                        <div class="col-sm-12 m-t-10">
                            <!-- 批量操作按钮 -->
                            <div class="btn-group dropdown">
                                <button id="bulk-btn" type="button" class="btn btn-warning waves-effect waves-light">
                                    Bulk <i class="fa fa-check-square-o"></i></button>
                                <button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light"
                                        data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="">打印</a></li>
                                    <li class="divider"></li>
                                    <li class="text-danger"><a href="javascript:viod(0);" id="delete_btn">删除</a></li>
                                </ul>
                            </div>
                            <!-- 批量操作按钮 -->
                        </div>

                    </div><!---- End row ---->

                </div>
            </div>
        </div>
    </div><!---- End 搜索及按钮功能区域  ---->

    <!---- 库存列表 ---->
    <div class="row hidden_p">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <!-- 数据表 -->
                    <table class="table table-bordered table-striped display" id="datatable-buttons">
                        <thead>
                        <tr>
                            <th>采购订单编号</th>
                            <th>采购人</th>
                            <th>供货商</th>
                            <th>创建时间</th>
                            <th>总金额</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($res as $item)
                            <tr>
                                <!---- 选择框及编号 ---->
                                <td>
                                    <div class="checkbox checkbox-success">
                                        <input id="item-checkbox-id" name="image_input" type="checkbox"
                                               value="{{$item->id}}" class="item-checkbox">
                                        <label for="item-checkbox-id">
                                            {{$item->order_no}}
                                        </label>
                                    </div>
                                </td><!---- 选择框及编号 ---->
                                <td> {{$item->name}}</td>
                                <td> {{$item->supplier}}</td>
                                <td> {{$item->created_at}}</td>
                                <td><i class="fa fa-dollar"></i>{{$item->total_price}}</td>
                                @if($item->status == 1)
                                    <td class="text-info">已下单</td>
                                @else
                                    <td >已审核入库</td>
                            @endif
                            <!-- 操作按钮 -->
                                <td class="actions">
                                    <!---- 查看按钮 ---->
                                    <!-- <button class="btn-sm btn-success waves-effect waves-light edit-item-btn"
                                            data-toggle="modal" data-target="#view-item-modal" data-id="{{$item->id}}"
                                            onclick="sse(this);"><i class="fa fa-eye"></i></button> -->
                                    <button class="btn-sm btn-success waves-effect waves-light edit-item-btn"
                                            data-toggle="modal" data-target="#view-item-modal"
                                            @click="sse({{$item->id}});"><i class="fa fa-eye"></i></button>
                                            <!---- End 编辑按钮 ---->
                                    <!---- 删除按钮 ---->
                                    @if((Auth::user()->role == 1 && $item->status != 2 ))
                                    <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn"
                                            data-id="{{$item->id}}" onclick="del(this);"><i class="fa fa-trash"></i>
                                    </button><!---- End 删除按钮 ---->
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
    <div id="showPBox"></div>
    <!---- 添加 ---->
    <div id="add-item-modal" class="modal fade hidden_p" tabindex="-1" role="dialog" aria-labelledby="addModal"
         aria-hidden="true">
        <div class="modal-dialog show_p" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-plus"></i> 新建采购订单</h3>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <!-- 123 -->

                        <!---- 添加模态框内容 ---->
                        <div class="form-group col-lg-4">
                            <label for="" class="control-label">
                                采购人
                            </label>
                            <small class="text-muted">必填</small>

                            <input type="text" id="name" value='{{ Auth::user()->username }}' readonly="readonly" class="form-control" placeholder="采购人姓名">
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="" class="control-label">
                                供货商
                            </label>
                            <small class="text-muted">必填</small>
                            <select class="form-control" id="supplier">
                                @foreach($supplier as $item)
                                    <option value="{{$item->company}}">{{$item->company}}</option>
                                @endforeach
                            </select>
                            {{--<input type="text" id="supplier" class="form-control" placeholder="供货商名称或电话">--}}

                        </div>

                        <div class="form-group col-lg-6">
                            <label for="" class="control-label">
                                订单金额
                            </label>
                            <small class="text-muted">选填</small>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <input id="price" type="text" class="form-control" placeholder="0000.00">
                            </div>

                        </div>
                        <div class="form-group col-lg-8">
                            <label for="" class="control-label">
                                备注
                            </label>
                            <small class="text-muted">选填</small>

                            <textarea id="remark" class="form-control" name="" id="" cols="30" rows="4"></textarea>
                        </div>

                        <!---- 商品列表 ---->
                        <div class="col-lg-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">添加商品</h4>
                                </div>
                                <div id="content" class="form-group"style="
                                padding: 10px;">


                        <div class="row py-1" v-if="addList.length>0" >
                            <div class="col-sm-2">sku</div>
                            <div class="col-sm-2">内部SKU</div>
                            <div class="col-sm-4">商品名称</div>
                            <div class="col-sm-2">箱规</div>
                            <!-- <div class="col-sm-1">订单总数</div> -->
                            <div class="col-sm-2">数量</div>
                            <!-- <div class="col-sm-2">过期日期</div> -->
                            <!-- <div class="col-sm-1">pallet</div> -->
                            <!-- <div class="col-sm-1"></div> -->
                        </div>
                        <div class="row flex py-1" v-for="(item,index) in addList" style="padding:5PX 0">
                            <div class="col-sm-2">@{{item.sku}}</div>
                            <div class="col-sm-2">@{{item.innersku}}</div>
                            <div class="col-sm-4">@{{item.zn_name+item.en_name}}</div>
                            <div class="col-sm-2">@{{item.number}}</div>
                            <!-- <div class="col-sm-1">@{{total(index)}}</div> -->
                            <div class="col-sm-2">
                                <div class="row py-1" v-for="(item1,index1) in item.pallet" style="padding:3PX 0">
                                    <!-- <div class="col-sm-12"> -->
                                        <div class="col-sm-8">
                                            <input type="text" data-id="" name="editcount" class="form-control"  v-model="item1.count">
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn"
                                            @click="delNew(index);"><i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    <!-- </div> -->
                                    <!-- <div class="col-sm-4">
                                        <div class="row">
                                            <el-date-picker
                                            v-model="item1.overdue"
                                            type="date"
                                            style='width:100%'
                                            size='small'
                                            value-format="yyyy-MM-dd"
                                            placeholder="选择日期">
                                            </el-date-picker>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-3">
                                        <input type="text" data-id="" name="editcount" class="form-control"  v-model="item1.pallet_id">
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="row">
                                            <div class="col-sm-6" v-if="index1==item.pallet.length-1?true:false">
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm" @click="addPallet(index)" > <i class="fa fa-plus"></i>
                                                    </button>
                                            </div>
                                            <div class="col-sm-6" v-if="index1==0?false:true">
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm" @click="removePallet(index,index1)"> <i class="fa fa-minus-square"></i>
                                                    </button>
                                            </div>
                                        </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                                </div>
                                <div class="panel-body">
                                    <!---- 搜索并添加商品 ---->
                                    <div class="form-group col-lg-4">
                                        <div class="input-group">
                                        <input class="form-control" type="text" placeholder="商品名称或SKU" id="searchString">
                                            <span class="input-group-btn">
                                                <button @click="doPostSearch();" class="btn btn-primary waves-effect waves-light"
                                                        type="button"><i class="fa fa-plus"></i></button>
                                            </span>
                                        </div>
                                    </div><!---- End 搜索并添加商品 ---->

                                    <!---- 添加的商品 ---->
                                    <div>
                                        <table id="table" class="table table-bordered table-striped display">
                                            <thead v-if="seachList.length>0?true:false">
                                                    <tr>
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
                                                <td class="exce">@{{item.stock + item.frozen_stock}}</td>
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
                                    <!-- </div>-- End 添加的商品 -- -->

                                </div><!---- end panel-body ---->
                            </div>
                        </div><!---- 商品列表 ---->
                        <!-- 123 -->
                                <div id="show"></div>
                    </div>
                <div class="modal-footer col-sm-12">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" onclick="hiddenModal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" id="save-item-btn" @click="qw"><i
                                class="fa fa-save"></i> Save
                    </button>
                </div>
                </div>
            </div>
        </div>
        </div>
    </div><!---- End 添加 ---->


    <!---- 查看 ---->
    <div id="view-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">
            	<!--startprint-->
            <div class="modal-content" style="width:100%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-eye"></i> 查看采购订单</h3>
                </div>
                <div class="modal-body row ">
                    <div class="col-sm-12">
                    <!-- body  内容 -->
    <div class="col-sm-12">

<div class="col-sm-12">
    <div class="pull-left">
        <h4>订单编号<br>
            <strong id="numOrder">@{{order_no}}</strong>
        </h4>
    </div>
    <div class="pull-right">
        <p id="create"><strong>创建时间: </strong> @{{created_at}}</p>
        <p id="puser"><strong>采购人: </strong>@{{name}}</p>
        <p id="orderStatus"><strong>订单状态: </strong><span class="label label-pink">Pending</span></p>
    </div>
</div>

</div>
<div class="col-sm-12">
<div class="col-sm-12" id="m649">

    <!-- 修改palletId -->

    <el-dialog
  title="请输入新的pallet编号"
  :visible.sync="modal"
  :modal=false
  width="30%">
    <el-input v-model="newModify"></el-input>
  <span slot="footer" class="dialog-footer">
    <el-button @click="modal = false">取 消</el-button>
    <el-button type="primary" @click="makeOver">确 定</el-button>
  </span>
</el-dialog>

    <!-- 修改palletId -->

    <!-- <div class="table-responsive"> -->
    <div class="">
        <div class="">
        <div class="" >
        <!-- productlist -->
                <div class="row flex py-1 text-center"  style="padding:5PX 0;display:flex;align-items:center;width:100%" >
                    <div class="col-sm-1">sku</div>
                    <div class="col-sm-1">内部SKU</div>
                    <div class="col-sm-1">商品图片</div>
                    <div class="col-sm-1">价格</div>
                    <div class="col-sm-1">箱规</div>
                    <div class="col-sm-1">差异量</div>
                    <div class="col-sm-1">订单总量</div>
                    <div class="col-sm-1">实际数量</div>
                    <div class="col-sm-1">总价</div>
                    <div class="col-sm-3" style="display:flex;align-items:center;">
                        <div class="col-sm-4">分数量</div>
                        <div class="col-sm-4">过期日期</div>
                        <div class="col-sm-4">pallet</div>
                    </div>

                </div>
                <div class="row flex py-1 text-center" v-for="(item,index) in purchase" style="padding:5PX 0;display:flex;align-items:center;" >
                    <div class="col-sm-1">@{{item.products.sku}}</div>
                    <div class="col-sm-1">@{{item.products.innersku?item.products.innersku:' '}}</div>
                    <!-- <div class="col-sm-1">@{{item.products.zn_name+item.products.en_name}}</div> -->
                    <div class="col-sm-1">
                        <!-- <el-tooltip class="item" effect="dark" v-bind:content="item.products.zn_name+item.products.en_name" placement="top" > -->
                        <el-tooltip class="item" placement="top" >
                            <div slot="content">@{{item.products.zn_name}}<br/>@{{item.products.en_name}}</div>
                            <img v-bind:src="item.products.product_image" alt="" class="img-thumbnail" style="width:68px">
                        </el-tooltip>
                    </div>
                    <div class="col-sm-1">$@{{item.products.price}}</div>
                    <div class="col-sm-1">@{{item.products.number}}</div>
                    <div class="col-sm-1" v-bind:class="[{'text-success':cyl(index)<0},{'text-warning':cyl(index)>0}]">@{{cyl(index)}}</div>
                    <div class="col-sm-1">
                    <el-input v-model="item.count" :disabled="entry" size='small' placeholder="请输入内容"></el-input>
                    </div>
                    <div class="col-sm-1">@{{total1(index)}}</div>
                    <div class="col-sm-1">$@{{(item.products.price*total1(index)).toFixed(2)}}</div>
                    <div class="col-sm-3">
                        <div class="col-sm-12" v-if="item.pallets.length==0">空</div>
                        <div class="col-sm-12 py-1"v-if="item.pallets.length>0" v-for="(item1,index1) in item.pallets" style="padding:3PX 0;display:flex;align-items:center;">
                            <div class="col-sm-3">
                                @{{item1.count}}
                                <!-- <el-input v-model="item1.count" :disabled="entry" size='small' placeholder="请输入内容"></el-input> -->
                            </div>
                            <div class="col-sm-6">
                                @{{item1.overdue}}
                                <!-- <div class="row">
                                    <el-date-picker
                                    v-model="item1.overdue"
                                    type="date"
                                    style='width:100%'
                                    :disabled="entry"
                                    size='small'
                                    value-format="yyyy-MM-dd"
                                    placeholder="选择日期">
                                    </el-date-picker>
                                </div> -->
                            </div>
                            <div class="col-sm-3">
                                @{{item1.name.number}}
                                <!-- <el-input v-model="item1.name.number" :disabled="entry" size='small' placeholder="请输入内容"></el-input> -->
                            </div>
                            </div>
                        <div class="col-sm-4" v-if="abcd">
                            <button type="button" id="start"
                                    @click="addthis(item);abcd=!abcd" class="btn btn-small btn-info waves-effect pull-left" ><i class="fa "v-bind:class="{'fa-plus': true}"></i>
                            </button>
                        </div>
                        </div>
                        <!-- <div class="row py-1" v-if="item.pallets.length==0">
                                    <div class="col-sm-12" >
                                        <button class="btn btn-primary waves-effect waves-ligh  btn-sm" @click="addPallet1(index)"  v-if="!entry"> <i class="fa fa-plus"></i>
                                            </button>
                                    </div>
                        </div> -->


                    </div>
                </div>
        <!-- productlist end -->

                <!-- pallet list -->
                <div class="row py-1 text-center" v-if="!entry">
                    <div class="col-sm-12" style="margin-top:30px;">
                        <div class="col-sm-3">
                            <h5>添加Pallet</h5>
                            <el-input placeholder="请输入内容" v-model="input5" class="input-with-select">
                                <el-button slot="append" icon="el-icon-plus" @click="abcde"></el-button>
                            </el-input>
                        </div>
                    </div>
                    <div class="col-sm-12" v-if="palletList.length>0" style="background:#eee;margin:20px 0 10px 0;padding:8px 0">
                    <div class="col-sm-2">
                        pallet编号
                        </div>
                        <div class="col-sm-9" >
                            <div class="col-sm-12" >
                                <div class="row" >
                                    <div class="col-sm-2">
                                    SKU
                                    </div>
                                    <div class="col-sm-2">
                                    内部SKU
                                    </div>
                                    <div class="col-sm-4">
                                    商品名称
                                    </div>
                                    <div class="col-sm-4" >
                                        <div class="row" >
                                            <div class="col-sm-4">
                                            分数量
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="row">
                                                过期日期
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            操作
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            操作
                        </div>
                    </div>
                    <div class="col-sm-12" v-for="item in palletList" style="display:flex;align-items: center;padding:10px 0;border:1px solid #eee;border-radius:8px;margin-top:10px">

                    <div class="col-sm-2" >
                    <div class="col-sm-6"> @{{item}} </div>
                    <div class="col-sm-6">
                        <span style="color:#999;cursor:pointer " @click="delPallet(item)">删除</span><br>
                    <span style="color:#999;cursor:pointer " @click="modifyPallet(item)">修改</span>
                    </div>

                        </div>
                        <div class="col-sm-9" >
                            <div class="col-sm-12" >
                                <div class="row" v-for="item1 in indexPallet(item)">
                                    <div class="col-sm-2">
                                    @{{item1.products.sku}}
                                    </div>
                                    <div class="col-sm-2">
                                    @{{item1.products.innersku}}
                                    </div>
                                    <div class="col-sm-4">
                                    @{{item1.products.zn_name+item1.products.en_name}}
                                    </div>
                                    <div class="col-sm-4" v-for="(item2,index2) in item1.pallets">
                                        <div class="row" v-if="item2.name.number==item">
                                            <div class="col-sm-4">
                                            <el-input v-model="item2.count" :disabled="entry" size='small' placeholder="请输入内容"></el-input>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="row">
                                                    <el-date-picker
                                                    v-model="item2.overdue"
                                                    type="date"
                                                    style='width:100%'
                                                    :disabled="entry"
                                                    size='small'
                                                    value-format="yyyy-MM-dd"
                                                    placeholder="选择日期">
                                                    </el-date-picker>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm" @click="removePallet1(item1,index2)" > <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button type="button"  @click="abcd=!abcd;palletId=item" class="btn btn-small btn-info waves-effect pull-left" ><i class="fa "v-bind:class="{'fa-plus': true}"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- pallet list -->
        </div>
            <div class="container-fluid">
        </div>

        <div class="col-md-12">
            <div class="col-md-3 col-md-offset-9">
                <hr>
                <!-- <h3 id="totalPrice" class="text-right"><i class="fa fa-dollar"></i> @{{total_price}}</h3> -->
                <h3 id="totalPrice" class="text-right"><i class="fa fa-dollar"></i> @{{allTotal.toFixed(2)}}</h3>
            </div>
        </div>
    </div>
</div>
</div>
                    <!-- body 内容 end -->
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" onclick="dealStock(this);" data-status="1" id="sure"
                            v-if="status==1?true:false" class="btn btn-success waves-effect pull-left">确认入库
                    </button> -->
                    <button type="button" @click="dealStock" data-status="1" id="sure"
                            v-if="status==1?true:false" class="btn btn-success waves-effect pull-left">审核确认
                    </button>
                    <!-- <button type="button" id="start" data-status="1"
                            v-if="status==1?true:false" class="btn btn-small btn-info waves-effect pull-left"><i class="fa fa-unlock-alt"></i>
                    </button> -->
                    <button type="button" id="start" data-status="1"
                            v-if="status==1?true:false" @click=" entry=!entry" class="btn btn-small btn-info waves-effect pull-left" ><i class="fa "v-bind:class="{'fa-unlock': !entry,'fa-unlock-alt':entry}"></i>
                    </button>
                    <a href="##" id="Print" @click="print" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
                <!--endprint-->
        </div>
    </div><!---- End 查看 ---->

</div>
<!-- vue作用域end -->
    <script type="text/javascript">
        $('#name').val('{{ Auth::user()->username }}');
        $('#supplier').val('');
        window.count = 0;
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
        $("#Print").click(
			function () {
                console.log(111)
			    bdhtml=window.document.body.innerHTML;
			    bdhtmll=window.document.body.innerHTML;
			    sprnstr="<!--startprint-->";
			    eprnstr="<!--endprint-->";
			    prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+17);
			    prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
			    window.document.body.innerHTML=prnhtml;
			    window.print();
			    window.location.reload()
			})
    </script>


    <!---- End 弹窗 ---->


    <script>
        window.eseshelve = [];
        window.shelves = [];
        window.dta = '';
            @foreach($shelves as $item) {
            window.shelves.push({!! $item !!});
        }
        @endforeach



            for (let i in window.shelves) {

            window.dta += `<option  value="${window.shelves[i].id}">${window.shelves[i].name}（${window.shelves[i].number}）</option>`;
        }
        //点击添加
        $('#save-item-btn').click(function () {

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
                        'overdue' : $(this).parent().next().find('input').val(),
                        "count": $(this).val()
                    });
                    i += Number($(this).val());
                }


            });

            var datas = {
                'products': window.obj,
                'name': $('#name').val(),
                'uproducts':window.objs,
                'supplier': $('#supplier').val(),
                'num': i,
//                'price': $('#price').val(),
                'remark': $('#remark').val(),
                '_token': '{{csrf_token()}}'
            };

            if ($('#price').val().length > 0) {
                datas.price = $('#price').val();
            }

            if (window.eseshelve.length > 0)
                datas.shelves = window.eseshelve;
            $.get('/shelves/deal/order', datas, function (res) {


                if (res.status) {
                    alertify.success('创建采购订单成功');
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

                    $.get('/shelves/order/del', {'id': $(event).attr('data-id')}, function (res) {

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

        $('#delete_btn').click(function () {

            var arr = [];
            $('input[name=image_input]:checked').each(function () {

                arr.push($(this).val());
            });

            if (arr.length == 0) {
                alertify.alert('没有选择任何记录');
                return;
            }

            $.get('/shelves/Batch/del', {'arr': arr}, function (res) {

                if (res.status) {
                    alertify.success('删除成功');
                    $("input[name='image_input']").removeAttr("checked", false);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }

            });
        });

        var sse = function (event) {

            $.get('/shelves/order/deal', {'id': $(event).attr('data-id')}, function (res) {
                console.log(res)
                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        var datas = '', Num ='', totalPrice = 0;
                        for (let i in res.data.purchase) {

                            var middle = (res.data.purchase[i].products.price * res.data.purchase[i].count).toFixed(2);
                            totalPrice += Number(middle);
                            var dates = res.data.status == 1?(res.data.purchase[i].overdue == null ? `<input class="form-control datepickers" id="datepicker" data-date-format="yyyy-mm-dd"
                                 value="" name="editdate" readonly="readonly" type="text">`: `<input class="form-control datepickers" data-date-format="yyyy-mm-dd"
                              name="editdate" value="${res.data.purchase[i].overdue}" readonly="readonly" id="datepicker" type="text">`):(res.data.purchase[i].overdue == null ?"":res.data.purchase[i].overdue);
                            var Num = res.data.status == 1?`<input type="text" data-id="${res.data.purchase[i].products.id}" name="editcount" class="form-control" readonly="readonly" value="${res.data.purchase[i].count}">`:res.data.purchase[i].count;

                            var innersku = res.data.purchase[i].products.innersku == null ? '' :res.data.purchase[i].products.innersku,
                                numbers = res.data.purchase[i].products.number == null ? '' :res.data.purchase[i].products.number,
                                shelves = '';

                            if (res.data.purchase[i].products.shelves .length > 0) {
                                for (let j in res.data.purchase[i].products.shelves) {
                                    shelves += res.data.purchase[i].products.shelves[j].name + '，';
                                }
                            }

                            datas += `<tr>
                                <td>${res.data.purchase[i].products.sku}</td>
                                <td >${innersku}</td>
                                <td>${res.data.purchase[i].products.zn_name}${res.data.purchase[i].products.en_name}</td>
                               <td>${Num}</td>
                                <td>$${res.data.purchase[i].products.price}</td>
                                 <td>${numbers}</td>
                                  <td>${dates}</td>
                                  <td>${shelves}</td>
                            </tr>`;

                        }

                    }

                    switch (res.data.status) {
                        case '1' :
                            var word = '已下单';
                            break;
                        case '2' :
                            var word = '已审核入库';
                            break;
                        default :
                            var word = '已取消';
                    }
                    $('#numOrder').html(`${res.data.order_no}`);
                    $('#create').html(`<strong>创建时间: </strong> ${res.data.created_at}`);
                    $('#puser').html(`<strong>采购人: </strong> ${res.data.name}`);
                    $('#orderStatus').html(`<strong>订单状态: </strong><span class="label label-pink">${word}</span>`);
                    $('#totalPrice').html(`$${totalPrice.toFixed(2)}`);


                    @if (in_array(Auth::user()->role,$auth))
                    if (res.data.status == 1 ) {
                        //未审核 手动 需要审核
                        $('#sure').attr('data-id', res.data.id).show();
                        $('#not').attr('data-id', res.data.id).show();
                        $('#start').show();
                    } else {
                        $('#sure').hide();
                        $('#not').hide();
                        $('#start').hide();
                    }
                    @endif
                    alertify.success('获取成功');

                    $('#orderDeal').html(datas);

                    jQuery('.datepicker').datepicker({
                        numberOfMonths: 3,
                        showButtonPanel: true,
                    });
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>

    <script>
        //处理订单
        var dealStock = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'status': $(event).attr('data-status')
            };
            //update in stock
            if (window.count > 0) {
//            if ($(event).attr('data-status') != 1) {
                window.obj = [];
                window.objs = [];
                var i = 0;
                $("input[name='editcount']").each(function () {

                    if ($(this).val() != 0) {
                        window.obj.push({
                            'product_id': $(this).attr('data-id'),
                            "count": $(this).val()
                        });
                        window.objs.push({
                            'product_id': $(this).attr('data-id'),
                            'overdue' : $(this).parent().nextAll().find('input.datepicker').val(),
                            "count": $(this).val()
                        });
                        i += Number($(this).val());
                    }


                });
                datas.products = window.obj;
                datas.uproducts = window.objs;
                datas.num = i;
            }

            $.get('/stock/put', datas, function (res) {
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
    </script>

    <script>

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
                                                    <span style="padding: 10px; " class="input-group-btn  ">
                                                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis" data-id="${$(event).attr('data-id')}" onclick="Delete1(this)" ><i class="fa fa-trash"></i>
                                                        </button>
                                                    </span>

                        </div>

                    </div>`);
//                <ul id="eselectshelve${$(event).attr('data-id')}" style="display:flex; display: -webkit-flex; flex-wrap:wrap; ">
//                        ${$(event).attr('data-shelve')}
//                        </ul>
//                        <select class="form-control" data-id='${$(event).attr('data-id')}'  onchange="eshelves(this)" >
//                        ${window.dta}
//                        </select>

                    jQuery('.datepicker').datepicker({
                        numberOfMonths: 3,
                        showButtonPanel: true,
                    });
                    window.arr.push($(event).attr('data-id'));
                } else {
                    return;
                }


            } else {
                $('#content').append(` <div class="form-group DeleteThat panel" style="padding:20px;" id='list${$(event).attr('data-id')}'>
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
                                                    <span style="padding: 10px; " class="input-group-btn  ">
                                                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis" data-id="${$(event).attr('data-id')}" onclick="Delete1(this)" ><i class="fa fa-trash"></i>
                                                        </button>
                                                    </span>

                        </div>

                    </div>`);
//            <ul id="eselectshelve${$(event).attr('data-id')}" style="display:flex; display: -webkit-flex; flex-wrap:wrap; ">
//                    ${$(event).attr('data-shelve')}
//                    </ul>
//                    <select class="form-control" data-id='${$(event).attr('data-id')}'  onchange="eshelves(this)" >
//                    ${window.dta}
//                    </select>
                window.arr.push($(event).attr('data-id'));

                jQuery('.datepicker').datepicker({
                    numberOfMonths: 3,
                    showButtonPanel: true,
                });
            }

        }

//PDF打印按钮
//	    $("datatable-buttons_wrapper").ready(()=>{
//	    		$("#datatable-buttons_wrapper .dt-buttons a").eq(3).hide();
//	    		console.log("chengg")
//	    })
        var Delete1 =function(event){

            if (window.arr.indexOf($(event).attr('data-id')) == -1) {
                return;
            } else {
                var index = window.arr.indexOf($(event).attr('data-id'));
                $('#list' + $(event).attr('data-id')).remove();
                window.arr.splice(index, 1);
            }

        }
        // 模态框关闭
        var hiddenModal=()=>{
            $("#add-item-modal").modal('hide')
        }
    </script>

    <!-- 修改审核采购 -->
    <script>
    var vm = new Vue({
        el: '#xxcctty',
        data: {
            modal:false,
            modify:'',
            newModify:'',
            order_no:'',
            created_at:'',
            name:'',
            total_price:'',
            id:'',
            status:'',
            entry:true,
            purchase:[],
            order:[],
            seachList:[],
            addList:[],
            abcd:false,
            input5:'',
            palletList:[],
            palletId:'',
        },
        methods: {
            doPostSearch(){
                $.get('/stock/search', {'value': $('#searchString').val()}, function (res) {
                    if (res.status) {
                        if (res.data.length == 0) {
                            alertify.alert('搜索不到数据');
                            return;
                        } else {
                            console.log(res)
                            console.log(123)
                            vm.seachList=res.data
                        }
                    }    else {
                        alertify.alert(res.message);
                    }
                })
            },
            funOrder(item){
                for( var i=0;i<vm.addList.length;i++){
                    if(vm.addList[i].product_id==item.id){
                        alertify.alert("商品不能重复");
                        return
                    }
                }
                let addList={
                    product_image:item.product_image,
                    zn_name:item.zn_name,
                    en_name:item.en_name,
                    cyl:'',
                    sku:item.sku,
                    number:item.number,
                    innersku:item.innersku,
                    product_id:item.id,
                    pallet:[{
                        "overdue":"",
                        "pallet_id":"",
                        "count":""
                    }]
                }
                vm.addList.push(addList)
            },
            addPallet(index){
                console.log(index)
                console.log(vm.addList[index].pallet)
                let aa={
                        "overdue":"",
                        "pallet_id":"",
                        "count":""
                    }
                vm.addList[index].pallet.push(aa)
            },
            removePallet(index,index1){
                vm.addList[index].pallet.splice(index1,1)
            },
            delNew(index){
                vm.addList.splice(index,1)
            },
            addPallet1(index){
                let aa={
                        "overdue":"",
                        "pallet_id":"",
                        "name":{
                            number:""
                        }
                    }
                    vm.purchase[index].pallets.push(aa)
            },
            removePallet1(item,index){
                item.pallets.splice(index,1)
            },
            qw(){
                var ttg=0;
                var ggt=0;
                vm.addList.forEach((item,index)=>{
                    // if( item.cyl.indexOf('-')<0 && item.cyl.indexOf('+')<0){
                    //     if(item.cyl){
                    //     alertify.alert('差异量请以+或-开头');
                    //     return
                    //     }
                    // }
                    item.pallet.forEach((item1)=>{
                        if(item1.count==""){
                            alertify.alert(`商品：${item.zn_name},数量、日期以及pallet不能为空`);
                            return
                        }else{
                            ttg++
                        }
                        ggt++
                    })
                })
                if(ttg==ggt){
                    var products=[]
                    var uproducts=[]
                    var num1=0

                        vm.addList.forEach((item)=>{
                            var num=0
                            item.pallet.forEach((item1)=>{
                                        num=num+item1.count*1
                                    })

                            var ee={
                                "product_id":item.product_id,
                                "count":num
                            }
                            products.push(JSON.stringify(ee))
                        })

                        vm.addList.forEach((item)=>{
                            var num=0
                            item.pallet.forEach((item1)=>{
                                num=num+item1.count*1
                            })
                            var need_count=0

                            // if(item.cyl.indexOf("-")>-1){
                            //             need_count = num*1-item.cyl.substring(1,item.cyl.length)*1
                            //             console.log(11)
                            //         }else if(item.cyl.indexOf("+")>-1){
                            //             console.log(22)
                            //             need_count = num*1+item.cyl.substring(1,item.cyl.length)*1
                            //         }else if(!item.cyl){
                            //             need_count = num
                            //         }
                            var yy={
                                "product_id":item.product_id,
                                "count":num,
                                "pallet":item.pallet,
                                "need_count":num
                            }
                            uproducts.push(yy)
                        })
                         var arrs = [];
                        uproducts.forEach((item)=>{

                            num1+=item.need_count
                            arrs.push(JSON.stringify(item))
                        })

                    var data={

                        "products":`[${products}]`,
                        "name":$('#name').val(),
                        "supplier":$('#supplier').val(),
                        "num":num1,
                        // "uproducts":`[${arrs}]`,
                        // "uproducts":'[{"count":2,"need_count":2, "pallet":[{"pallet_id":"001","overdue":"2018-01-21","count":1},{"pallet_id":"002","overdue":"2018-01-21","count":1}], "product_id":236},{"count":4,"need_count":3,"pallet":[{"pallet_id":"002","overdue":"2018-01-22","count":1},{"pallet_id":"003","overdue":"2018-01-22","count":3}], "product_id":146}]',

                        "remark": $('#remark').val(),
                        "_token": '{{csrf_token()}}'
                    }
//                    console.log(data)
                    $.post('/shelves/deal/order', data, function (res) {

                        console.log(res)
                        if (res.status) {
                            alertify.success('创建采购订单成功');
                            $('#save-item-btn').attr('disabled', "false");
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            alertify.alert(res.message);
                            $('#save-item-btn').removeAttr('disabled');
                        }
                    })
                }
            },
            sse(id){
                vm.entry=true
             $.get('/shelves/order/deal', {'id': id}, function (res) {
                console.log(res)
                if (res.status) {
                    if (res.data.length == 0) {
                        alertify.alert('搜索不到数据');
                        return;
                    } else {
                        // res.data.purchase.forEach((item)=>{
                        //     item.pallets.push({
                        //         "overdue":'' ,
                        //         "pallet_id":'',
                        //         "name":{
                        //             'number':''
                        //         }

                        //     })
                        // })
                        vm.order_no=res.data.order_no
                        vm.created_at=res.data.created_at
                        vm.name=res.data.name
                        vm.purchase=res.data.purchase
                        vm.total_price=res.data.total_price
                        vm.status=res.data.status
                        vm.id=res.data.id
                        console.log(vm.purchase)

                    }

                } else {
                    alertify.alert(res.message);
                }

            })
            },
            dealStock(){

                var ttg=0;
                var ggt=0;

                var arrs = [];
                vm.purchase.forEach((item,index)=>{

                    var arrs1=[]
                    item.pallets.forEach((item1)=>{

                        var e={
                        "overdue":item1.overdue ,
                        "pallet_id":item1.name.number ,
                        "count":item1.count
                        }
                    arrs1.push(e)
                        ggt++
                        if(item1.overdue ==""||item1.name.number==""||item1.count==""){
                             alertify.alert(`商品数量、日期以及pallet不能为空`);
                             return
                        }else{
                            ttg++
                        }
                    })
                    console.log(item)
                    console.log(item.count)
                    var a={
                        "product_id":item.product_id,
                        "count":item.count,
                        "pallet":arrs1,
//                        "pallet":`{[arrs1]}`,
                        "need_count":vm.total1(index)
                    }
//                arrs.push(JSON.stringify(a))
                arrs.push(a)
                })
                if(ggt==ttg){
                    $.post('/stock/put',{'id':vm.id,'uproducts':JSON.stringify(arrs),'_token': '{{csrf_token()}}'},(res)=>{
                    if (res.status) {
                        alertify.success('采购订单入库成功');
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                    } else {
                        alertify.alert(res.message);
                    }

                    })

                }

            },
            abcde(){
                if(vm.input5==""){
                    alertify.alert('pallet不能为空');
                }else{
                    vm.palletList.push(vm.input5);
                    vm.input5=""
                }
            },
            addthis(item){
                let aa={
                        "overdue":"",
                        "pallet_id":"",
                        "name":{
                            number:vm.palletId
                        }
                    }
                var b=true
                item.pallets.forEach((item1)=>{
                    if(item1.name.number==vm.palletId){
                        alertify.alert("pallet下不能添加多个同样商品");
                        b=!b
                        return
                    }
                })
                if(b){
                    item.pallets.push(aa);
                }
            },
            print(){

			    // bdhtml=$("#xxcctty").html();
			    // bdhtmll=window.document.body.innerHTML;
			    // sprnstr="<!--startprint-->";
			    // eprnstr="<!--endprint-->";
			    // prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+17);
			    // prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
			    // $("#xxcctty").html(prnhtml);
                // console.log(prnhtml)
                // console.log($("#xxcctty").html())
                $(".hidden_p").hide()
                $("#view-item-modal").modal("hide")
                $("#showPBox").html($("#view-item-modal .modal-body").html())
                // $("#showPBox .modal-dialog").width("100%")
                // $("#showPBox .modal-dialog").css("margin-top","0")
                // $(".modal-content").width("100%")
			    window.print();
			    window.location.reload()
            },
            modifyPallet(item){
                vm.modify=item;
                vm.modal=true;

                $(".el-dialog__wrapper").css('top',$("#m649").height()*1-300+'px')

            },
            makeOver(){
                if(vm.palletList.indexOf(vm.newModify)>-1){
                    alertify.alert('编号不能重复');

                }else{
                    if(vm.newModify){
                        vm.palletList.forEach((item,index)=>{
                            if(vm.palletList[index]==vm.modify){
                                vm.palletList[index]=vm.newModify
                            }
                        })

                        vm.purchase.forEach((item)=>{
                            item.pallets.forEach((item1)=>{
                                if(item1.name.number==vm.modify){
                                    item1.name.number=vm.newModify
                                }
                            })
                        })
                        vm.modal=false
                        vm.modify="";
                        vm.newModify="";
                    }else{
                        alertify.alert('编号不能为空');

                    }

                }
            },
            delPallet(id){

                vm.palletList.forEach((item,index)=>{
                            if(vm.palletList[index]==id){
                                vm.palletList.splice(index,1)
                            }
                        })

                        vm.purchase.forEach((item)=>{
                            item.pallets.forEach((item1,index1)=>{
                                if(item1.name.number==id){
                                    item.pallets.splice(index1,1)
                                }
                            })
                        })
            }
        },
        computed: {
            total(){
                return function(index){
                    var all=0;
                    for(var i=0;i<vm.addList[index].pallet.length;i++){
                        all= all+(vm.addList[index].pallet[i].count?vm.addList[index].pallet[i].count:0)*1
                    }
                    return all
                }
            },
            total1(){
                return function(index){
                    var all=0;
                    for(var i=0;i<vm.purchase[index].pallets.length;i++){
                        all= all+(vm.purchase[index].pallets[i].count?vm.purchase[index].pallets[i].count:0)*1
                    }
                    return all
                }
            },
            cyl(){
                return (index)=>{
                    var all=0;
                    for(var i=0;i<vm.purchase[index].pallets.length;i++){
                        all= all+(vm.purchase[index].pallets[i].count?vm.purchase[index].pallets[i].count:0)*1
                    }
                   var b=all*1-vm.purchase[index].count*1;
                    if(b>0){
                        return `+${b}`
                    }else{
                        return b
                    }
                }
            },
            indexPallet(){
                return (palletId)=>{
                    var a=[];
                    this.purchase.forEach((item)=>{
                        item.pallets.forEach((item1)=>{
                            if(item1.name.number==palletId){
                                a.push(item)
                            }
                        })
                    })
                    console.log(a)
                    return a
                }
            },
            allTotal(){
                var all=0
                this.purchase.forEach((item)=>{
                    item.pallets.forEach((item1)=>{
                        all+=item.products.price*item1.count
                    })
                })
                return all
            }
        },
        })
    </script>
@endsection