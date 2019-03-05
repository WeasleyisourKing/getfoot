@extends('admin/layout.app')




@section('add-item-modal-content')
    <!---- 添加模态框内容 ---->

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架名称
        </label>

        <input type="text" id="name" class="form-control" placeholder="零食货架">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架编号
        </label>

        <input type="text" id="number" class="form-control" placeholder="货架编号">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架状态
        </label>
        <br>
        <select class="form-control" name="" id="status">
            <option value="1">已满</option>
            <option value="2">未满</option>
        </select>
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">选填</small>

        <textarea class="form-control" id="remark" cols="30" rows="4"></textarea>
    </div>
                <!-- 修改添加商品 -->
                    <!-- <div class="form-group col-lg-12">
                        <div class="row py-1 text-center" >
                            <div class="col-sm-2">商品名称</div>
                            <div class="col-sm-1">图片</div>
                            <div class="col-sm-2">sku</div>
                            <div class="col-sm-1">数量</div>
                            <div class="col-sm-2">过期日期</div>
                            <div class="col-sm-4">调拨</div>
                        </div>
                        <div class="row flex py-1 text-center table-center"  
                        style="padding:8PX 0;
                            display:flex;
                            align-items:center;
                            justify-content: center;">

                            <div class="col-sm-2">name</div>
                            <div class="col-sm-1">img</div>
                            <div class="col-sm-2">sku</div>
                            <div class="col-sm-1">number</div>
                            <div class="col-sm-2">date</div>
                            <div class="col-sm-4">
                                <div class="row " style="padding:3px 0">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control input-sm" placeholder="数量">
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control input-sm">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-6" >
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm"  > <i class="fa fa-plus"></i>
                                                    </button>
                                            </div>
                                            <div class="col-sm-6" >
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm" > <i class="fa fa-minus-square"></i>
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row table-center">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="数量">
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-6" >
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm"  > <i class="fa fa-plus"></i>
                                                    </button>
                                            </div>
                                            <div class="col-sm-6" >
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm" > <i class="fa fa-minus-square"></i>
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row table-center">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="数量">
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-6" >
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm"  > <i class="fa fa-plus"></i>
                                                    </button>
                                            </div>
                                            <div class="col-sm-6" >
                                                <button class="btn btn-primary waves-effect waves-ligh  btn-sm" > <i class="fa fa-minus-square"></i>
                                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <!-- 修改添加商品end -->
@endsection



@section('edit-item-modal-content')
    <!---- 编辑模态框内容 ---->
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架名称
        </label>

        <input id="ename" type="text" class="form-control" placeholder="零食货架">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架编号
        </label>

        <input id="enumber" type="text" class="form-control" placeholder="货架编号">
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架状态
        </label>

        <select class="form-control" name="" id="estatus">
            {{--<option value="1">已满</option>--}}
            {{--<option value="2">未满</option>--}}
        </select>
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">选填</small>

        <textarea class="form-control" id="eremark" cols="30" rows="4"></textarea>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">货架商品</h4>
            </div>
            <div class="panel-body">

                <!---- 添加的商品 ---->
                <div>

                    <table id="table" class="table table-bordered table-striped display">
                        <thead>
                        <tr>
                            <th class=" col-md-3 col-lg-3 exce"> 商品名称</th>
                            <th class=" col-md-2 col-lg-2 exce"> SKU</th>
                            <th class=" col-md-1 col-lg-1 exce"> 数量</th>
                            <th class=" col-md-2 col-lg-2 exce"> 过期时间</th>
                            <th class=" col-md-4 col-lg-4 exce"> 商品所属货架</th>
                        </tr>
                        </thead>
                        <tbody id="shelf-product-rows">

                        </tbody>
                    </table>
                </div><!---- End 添加的商品 ---->

            </div><!---- end panel-body ---->
        </div>
    </div>
@endsection





@section('content')

<!-- vue作用域 -->
<div id="xxcctty">
    <!---- 头部标题及导航链接 ---->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">12Buy商城管理系统</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">货架管理</li>
            </ol>
        </div>
    </div><!---- End 头部标题及导航链接 ---->

    <!---- 搜索及按钮功能区域 ---->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-2">
                            <!-- Add 按钮 -->
                            <button class="btn btn-block btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#add-item-modal" id="add-item-btn">添加货架<i class="fa fa-plus"></i>
                            </button><!-- End Add 按钮 -->
                        </div>

                        <div class="col-lg-10">
                            <form action="/shelves/search" method="get">
                            <!-- 搜索 -->
                            <div class="input-group">
                                <input type="text"
                                       class="form-control input" name="search" placeholder="Search">
                                <span class="input-group-btn">
                                <button type="submit"
                                        class="btn waves-effect waves-light btn-primary w-md"><i
                                            class="fa fa-search"></i></button>
                            </span>
                            </div><!-- End 搜索 -->
                        </div>

                    </div><!---- End row ---->


                </div>
            </div>
        </div>
    </div><!---- End 搜索及按钮功能区域  ---->
    <div class="row">
        <!---- 货架列表 ---->
    @foreach($res as $item)
        <!---- 货架 ---->
        <div class="col-sm-6 col-lg-4 panel_box" style="height: 320px;">
                <div class="panel">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <h6>图片</h6>
                            </div>
                            <div class="col-sm-4 text-center">
                                <h6>商品名称</h6>
                            </div>
                            <div class="col-sm-3 text-center">
                                <h6>可调/冻结数量</h6>
                            </div>
                            <div class="col-sm-3 text-center">
                                <h6>日期</h6>
                            </div>
                        </div>
                        <!-- 循环列表 -->
                        <div class="row" style="height:180px;overflow-y: scroll;">
                        @if(!empty($item['goods']))
                            @php $k = 0 ;@endphp
                        @foreach($item['goods'] as $v)
                                <div class="row">
                            <div class="col-sm-2" style="padding-top:5px">
                                <img src="{{$v['product_image']}}" alt="" class="img-thumbnail">
                            </div>
                            <div class="col-sm-4 ">
                                <h6 style="
                                display: inline-block;
                                white-space: nowrap; 
                                width: 100%; 
                                overflow: hidden;
                                text-overflow:ellipsis;"
                                >{{$v['zn_name']}}</h6>
                            </div>
                            <div class="col-sm-3  text-center">
                                <h6>{{$v['info']['count']}}/{{$v['info']['frozen_count']}}</h6>
                            </div>
                            <div class="col-sm-3  text-center">
                                <h6>{{$v['info']['overdue']}}</h6>
                            </div>
                                </div>
                                    @php
                                        ++$k;
                                    if($k >= 3) break;
                                    @endphp

                        <!-- 循环列表end -->
                        @endforeach
                            @else
                                <div class="row col-sm-12 text-center" >
                                    无数据
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="panel-footer ">
                        <div class=" row">
                        <div class="col-sm-4">
                            <button class="btn-sm btn-info waves-effect waves-light edit-item-btn" data-toggle="modal"
                                    data-target="#edit-item-modal" @click="edit({{$item['id']}});"
                                    data-id="{{$item['id']}}" data-name="{{$item['name']}}" data-remark="{{$item['remark']}}"
                                    data-number="{{$item['number']}}" data-status="{{$item['status']}}"><i
                                        class="fa fa-edit"></i></button><!---- End 编辑按钮 ---->
                            <!---- 删除按钮 ---->
                            <button data-id="{{$item['id']}}"
                                    class="btn-sm btn-danger waves-effect waves-light delete-item-btn" onclick="del(this);">
                                <i class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
                        </div>
                        <div class="col-sm-8" style="left: right;">
                            <p class=" col-sm-8 taxt-center">{{$item['name']}}</p>
                            <p class="col-sm-4 taxt-center">{{$item['status'] != 1 ? '未满' : '已满'}}</p>
                        </div>
                        <!---- 编辑按钮 ---->
                        </div>
                    </div>
                </div>
            </div><!---- End 货架 ---->
        @endforeach
    </div>




    <!---- 弹窗 ---->
    <!---- 添加 ---->
    <div id="add-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-plus"></i> 新建一个货架</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('add-item-modal-content')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-info waves-effect waves-light" @click="sa();" id="save-item-btn"><i -->
                    <button type="button" class="btn btn-info waves-effect waves-light" @click="sa();" id=""><i
                                class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 添加 ---->


    <!---- 编辑 ---->
    <div id="edit-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-pencil"></i> 编辑货架</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <!-- 编辑 body -->
                    
    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架名称
        </label>
        <el-input v-model="shelfDetails.name" size="small " placeholder="请输入内容"></el-input>
        <!-- <input id="ename" type="text" v-bind:value="shelfDetails.name" class="form-control" placeholder="零食货架"> -->
    </div>

    <div class="form-group col-lg-4">
        <label for="" class="control-label">
            货架编号
        </label>
        <el-input v-model="shelfDetails.number" size="small " placeholder="请输入内容"></el-input>
        <!-- <input id="enumber" type="text" v-bind:value="shelfDetails.number" class="form-control" placeholder="货架编号"> -->
    </div>

    <div class="form-group col-lg-4">
        <label class="control-label">
            货架状态
        </label>
        <br>
        <el-select v-model="shelfDetails.status" size="small " placeholder="请选择">
            <el-option
            v-for="item in options"
            :key="item.label"
            :label="item.value"
            :value="item.label">
            </el-option>
        </el-select>
    </div>
    <div class="form-group col-lg-8">
        <label for="" class="control-label">
            备注
        </label>
        <small class="text-muted">选填</small>

        <el-input type="textarea" :autosize="{ minRows: 2, maxRows: 4}" placeholder="请输入内容" v-model="shelfDetails.remark">
</el-input>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">货架商品</h4>
            </div>
            <div class="panel-body">

                <!---- 添加的商品 ---->
                <div>
                    <div class="form-group col-lg-12">
                        <div class="row py-1 text-center" >
                            <div class="col-sm-2">商品名称</div>
                            <div class="col-sm-1">图片</div>
                            <div class="col-sm-2">sku</div>
                            <div class="col-sm-1">可调/冻结数量</div>
                            <div class="col-sm-2">过期日期</div>
                            <div class="col-sm-4">调拨</div>
                        </div>
                        <div class="row flex py-1 text-center table-center"  
                        style="padding:8PX 0;
                            display:flex;
                            align-items:center;
                            justify-content: center;" v-for="item in shelfDetails.goods" >

                            <div class="col-sm-2">@{{item.zn_name}}</div>
                            <div class="col-sm-1">
                                <img v-bind:src="item.product_image" alt="" class="img-thumbnail">
                            </div>
                            <div class="col-sm-2">@{{item.sku}}</div>
                            <div class="col-sm-1">@{{item.info.count}} / @{{item.info.frozen_count}}</div>
                            <div class="col-sm-2">@{{item.info.overdue}}</div>
                            <div class="col-sm-4">
                                <div class="row " style="padding:3px 0">
                                    <div class="col-sm-10" v-for="(item1,index1) in item.allot">
                                        <div class="col-sm-5">
                                            <el-input v-model="item1.count" size="small " placeholder="数量"></el-input> 
                                        </div>
                                        <div class="col-sm-5">
                                            <el-select v-model="item1.shelves_id" size="small "placeholder="货架">
                                                <el-option
                                                v-for="item in shelves"
                                                :key="item.id"
                                                :label="item.name"
                                                :value="item.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-sm-2">
                                                    <button class="btn btn-primary waves-effect waves-ligh  btn-sm" @click="removeAllot(item,index1)" > <i class="fa fa-minus-square"></i>
                                                        </button>
                                        </div>
                                        
                                    </div> 
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary waves-effect waves-ligh  btn-sm" @click="addAllot(item)" > <i class="fa fa-plus"></i>
                                            </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div><!---- End 添加的商品 ---->

            </div><!---- end panel-body ---->
        </div>
    </div>
                    <!-- 编辑 body end -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" id="edit-save"
                            @click="allocation"><i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 编辑 ---->

    <!---- End 弹窗 ---->

    </div>
    <!-- vue作用域 -->

    <script>

        window.eseshelve = [];
        window.shelves = [];
        window.dta = '';
            @foreach($shelves as $item) {
            window.shelves.push({!! $item !!});
        }
        @endforeach

//            for (let i in window.shelves) {
//
//            window.dta += `<option  value="${window.shelves[i].id}">${window.shelves[i].name}（${window.shelves[i].number}）</option>`;
//        }


        //点击添加
//        $('#save-item-btn').click(function () {
        $('#save-item-btn').on("click",function(){
            var datas = {
                'id': 1,
                'name': $('#name').val(),
                'number': $('#number').val(),
                'status': $('#status').val(),
                'remark': $('#remark').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/shelves/insert', datas, function (res) {
                if (res.status) {
                    alertify.success('创建货架成功');
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
            $('#ename').val($(event).attr('data-name'));
            $('#enumber').val($(event).attr('data-number'));
            $('#eremark').text($(event).attr('data-remark'));
            $('#edit-save').attr('data-id', $(event).attr('data-id'));
            $.get('/shelves/product', {id: $(event).attr('data-id')}, function (res) {
                if (res.status) {

                    var doc = '';


                    for (let i in res.data.goods) {
                        var sho = '';
                        for (let p in res.data.goods[i].shelves) {
                            sho += `${(res.data.goods[i].shelves[p].name)}，`;

                        }
                        var midd = (res.data.goods[i].overdue == null || res.data.goods[i].overdue.overdue == null) ? '未填写' : res.data.goods[i].overdue.overdue;
                        doc += `<tr><td class="exce">${res.data.goods[i].zn_name }</br>${res.data.goods[i].en_name}</td>
                     <td class="exce">${res.data.goods[i].sku}</td>
                      <td class="exce">${res.data.goods[i].stock}</td>
                     <td class="exce">${midd}</td>


                    <td>  <ul id="eselectshelve${res.data.goods[i].id}" style="display:flex; display: -webkit-flex; flex-wrap:wrap; ">
                      ${sho}
                      </ul>
                       <select class="form-control" data-id='${res.data.goods[i].id}'  onchange="eshelves(this)" >
                       ${window.dta}
                       </select>
                    </td>
`;
                    }
                    $('#shelf-product-rows').html(doc);
                } else {
                    alertify.alert(res.message);
                }
            })

            if (1 != $(event).attr('data-status')) {

                var data = ' <option value="1">已满</option><option value="2" selected="selected">未满</option>'
            } else {
                var data = ' <option value="1" selected="selected">已满</option><option value="2">未满</option>'
            }

            $('#estatus').html(data);
//        $('#edit-item-modal').modal('toggle');
        }

        window.fu = [];
        var eshelves = function (event) {

            if (window.eseshelve.length == 0) {
                //第一次
                var cent = '',
                    arr = {};
                arr = {
                    id :  $(event).attr('data-id'),
                    data : []
                };
                arr.data.push({
                    'shelves_id': $(event).val(),
                    'name': $(event).find("option:selected").text()
                });

                window.fu.push($(event).attr('data-id'));
                window.eseshelve.push(arr);

                for (let i in window.eseshelve[0].data) {
                    cent += `<li id="ese${0}${i}" style="padding:10px 5px;margin:5px;width: 100%; text-align:center;background: #eee;border-radius: 5px;">${window.eseshelve[0].data[i].name} <i class="fa fa-times"onclick="deleseshelve(0,${i},${$(event).attr('data-id')})"></i></li>`;
                }
                $('#eselectshelve' + $(event).attr('data-id')).html(cent);
                console.log(window.eseshelve);
            } else {

                //存在
                //获取下标
                var indexs = window.fu.indexOf($(event).attr('data-id')),
                cent = '';
                //已经存在

                if (indexs > -1) {
                    //去重
//                    for (let f in window.eseshelve[indexs].data) {
//                        if (window.eseshelve[indexs].data[f].shelves_id == $(event).val()) {
//                            console.log(window.eseshelve[indexs]);
//                            alertify.alert('不能重复选择');
//                            return;
//                        }
//                    }
                    window.eseshelve[indexs].data.push({
                        'shelves_id': $(event).val(),
                        'name': $(event).find("option:selected").text()
                    })

                    for (let i in window.eseshelve[indexs].data) {
                        cent += `<li id="ese${indexs}${i}" style="padding:10px 5px;margin:5px;width: 100%; text-align:center;background: #eee;border-radius: 5px;">${window.eseshelve[indexs].data[i].name} <i class="fa fa-times"onclick="deleseshelve(${indexs},${i},${$(event).attr('data-id')})"></i></li>`;
                    }

                    $('#eselectshelve' + $(event).attr('data-id')).html(cent);
//                    console.log(window.eseshelve);


                } else {

                    //新一类 存在
                    var cent = '',
                        arrs = {};
                    arrs = {
                        id :  $(event).attr('data-id'),
                        data : []
                    };
                    arrs.data.push({
                        'shelves_id': $(event).val(),
                        'name': $(event).find("option:selected").text()
                    });

                    window.fu.push($(event).attr('data-id'));
                    window.eseshelve.push(arrs);

                    for (let g in window.eseshelve) {
                        if (window.eseshelve[g].id == $(event).attr('data-id')) {
                            var ind = g;
                        }
                    }

                    for (let i in window.eseshelve[ind].data) {
                        cent += `<li  id="ese${ind}${i}" style="padding:10px 5px;margin:5px;width: 100%; text-align:center;background: #eee;border-radius: 5px;">${window.eseshelve[ind].data[i].name} <i class="fa fa-times"onclick="deleseshelve(${ind},${i},${$(event).attr('data-id')})"></i></li>`;
                    }
                    $('#eselectshelve' + $(event).attr('data-id')).html(cent);
//                    console.log(window.eseshelve);
                }

            }


//
//            for (let i in window.eseshelve) {
//                cent += `<li  style="padding:10px 5px;margin:5px;width: 100%; text-align:center;background: #eee;border-radius: 5px;">${eseshelve[i].name} <i class="fa fa-times"onclick="deleseshelve(${i},${$(event).attr('data-id')})"></i></li>`;
//            }
//            $('#eselectshelve' + $(event).attr('data-id')).html(cent);
//            console.log( window.eseshelve);
        }
        //删除选中的货架
        var deleseshelve = function (index, i,id) {

            if (window.eseshelve[index].data.length == 1) {

                window.eseshelve.splice(index, 1);
//                $("#eselectshelve" + id + ' li').remove();

            } else {
                window.eseshelve[index].data.splice(i, 1)

            }

            $("#ese" + index + i).remove()
            console.log( window.eseshelve);
        }

        //修改
//         var efunb = function (event) {

//             var datas = {
//                 'id': $(event).attr('data-id'),
//                 'name': $('#ename').val(),
//                 'number': $('#enumber').val(),
//                 'status': $('#estatus').val(),
//                 'remark': $('#eremark').val(),
//                 '_token': '{{csrf_token()}}'
//             };

// //            console.log(window.eseshelve.length);
// //            alertwindow.eseshelve);
//             if (window.eseshelve.length > 0)
//                 datas.shelves = window.eseshelve;
// //            console.log(datas);
//             $.post('/shelves/editor', datas, function (res) {
//                 if (res.status) {
//                     alertify.success('修改货架成功');
//                     setTimeout(function () {
//                         location.reload();
//                     }, 1500);
//                 } else {
//                     alertify.alert(res.message);
//                 }
//             })
//         }

        //删除
        var del = function (event) {

            alertify.confirm("确认删除吗？", function (e) {
                if (e) {

                    $.get('/shelves/del', {'id': $(event).attr('data-id')}, function (res) {

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
    <!--搜索功能-->
    <script>
        // $("#example-input1-group2").bind('input propertychange', function () {
        //     var str = $(this).val();
        //     var name = $(".panel_box h4");
        //     if ($(this).val() == "") {
        //         $(".panel_box").show();
        //     } else {
        //         $(".panel_box").hide();
        //         for (let i = 0; i < name.length; i++) {
        //             console.log(name.eq(i).html().indexOf(str))
        //             if (name.eq(i).html().indexOf(str) != -1) {
        //                 $(".panel_box").eq(i).show()
        //             }
        //         }
        //     }
        // })
    </script>
    <script>
    var vv=new Vue({
        el:'#xxcctty',
        data:{
            shelfDetails:'',
            options:[
                {
                    value:'已满（1）',
                    label:'1'
                },
                {
                    value:'未满（2）',
                    label:'2'
                },
            ],
            shelves:window.shelves,
            id:''

        },
        methods: {
            edit(id){
                vv.id=id
                vv.shelfDetails=""
                $.get('/shelves/product',{'id':id},(res)=>{
                    if(res.status){
                        if(res.data.length==0){
                        alertify.alert('没有pallet');
                        return;
                        }else{
                            if(res.data.goods.length>0){
                                res.data.goods.forEach((item)=>{
                                    item.allot=[]
                                })
                            }
                            vv.shelfDetails=res.data
                        }
                    }else{
                        alertify.alert(res.message);
                    }
                })
            },
            addAllot(item){
                var a={
                    shelves_id :"",
                    count :""
                }
                item.allot.push(a)
            },
            removeAllot(item,index){
                item.allot.splice(index,1)
            },
            allocation(){
                var a=0,
                b=0,
                arr=[]
                vv.shelfDetails.goods.forEach((item)=>{
                    var arr1=[];
                    var num=0;
                    item.allot.forEach((item1)=>{
                        arr1.push({
                            shelves_id :item1.shelves_id,
                            count :item1.count,
                            overdue:item.info.overdue
                        })
                        num=num+item1.count*1
                        b++
                        if(item1.shelves_id==""||item1.count==""){
                            alertify.alert(`商品数量、货架不能为空`);
                            return
                        }else{
                            a++
                        }
                    })

                    arr.push({
                        product_id:item.id,
                        total_count:item.info.count,
                        allot:arr1
                    })
                })
                if(a==b){
                    $.post('/shelves/allocation',{
                        'shelve_id':vv.id,
                        'id':vv.id,
                        'product':JSON.stringify(arr),
                        '_token': '{{csrf_token()}}',
                        'number':vv.shelfDetails.number,
                        'name':vv.shelfDetails.name,
                        'remark':vv.shelfDetails.remark,
                        'status':vv.shelfDetails.status,
                    },(res)=>{
                    if (res.status) {
                        alertify.success('货架修改成功');
                               setTimeout(function () {
                                   location.reload();
                               }, 1500);
                    } else {
                        alertify.alert(res.message);
                    }
                })
                }
            },
             sa() {

            var datas = {
                'id': 1,
                'name': $('#name').val(),
                'number': $('#number').val(),
                'status': $('#status').val(),
                'remark': $('#remark').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/shelves/insert', datas, function (res) {
                if (res.status) {
                    alertify.success('创建货架成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })

             }
        },
    })
    </script>


@endsection
