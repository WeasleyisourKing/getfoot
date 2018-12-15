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
                            <!-- 搜索 -->
                            <div class="input-group">
                                <input type="text" id="example-input1-group2" name="example-input1-group2"
                                       class="form-control input" placeholder="Search">
                                <span class="input-group-btn">
                                <button onclick="search();" type="button"
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
            <div class="col-sm-4 col-lg-3 panel_box">
                <div class="panel">
                    <div class="panel-body">

                        <div class="row text-center">
                            <div class="col-lg-12">
                                <!---- 货架名称 ---->
                                <h4>{{$item->name}}</h4>

                                <!---- 货架位置/编号 ---->
                                <h5>{{$item->number}}</h5>

                                <!---- 货架状态 ---->
                                <h6>{{($item->status) != 1 ? '未满' : '已满'}}</h6>
                            </div>


                        </div><!---- End row ---->

                    </div>

                    <div class="panel-footer">
                        <!---- 编辑按钮 ---->
                        <button class="btn-sm btn-info waves-effect waves-light edit-item-btn" data-toggle="modal"
                                data-target="#edit-item-modal" onclick="edit(this);"
                                data-id="{{$item->id}}" data-name="{{$item->name}}" data-remark="{{$item->remark}}"
                                data-number="{{$item->number}}" data-status="{{$item->status}}"><i
                                    class="fa fa-edit"></i></button><!---- End 编辑按钮 ---->
                        <!---- 删除按钮 ---->
                        <button data-id="{{$item->id}}"
                                class="btn-sm btn-danger waves-effect waves-light delete-item-btn" onclick="del(this);">
                            <i class="fa fa-trash"></i></button><!---- End 删除按钮 ---->
                    </div>
                </div>
            </div><!---- End 货架 ---->


            <!---- End 货架列表 ---->
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
                    <button type="button" class="btn btn-info waves-effect waves-light" id="save-item-btn"><i
                                class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 添加 ---->


    <!---- 编辑 ---->
    <div id="edit-item-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModal"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title"><i class="fa fa-pencil"></i> 编辑货架</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @yield('edit-item-modal-content')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" id="edit-save"
                            onclick="efunb(this);"><i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div><!---- End 编辑 ---->

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
        var efunb = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'name': $('#ename').val(),
                'number': $('#enumber').val(),
                'status': $('#estatus').val(),
                'remark': $('#eremark').val(),
                '_token': '{{csrf_token()}}'
            };

//            console.log(window.eseshelve.length);
//            alertwindow.eseshelve);
            if (window.eseshelve.length > 0)
                datas.shelves = window.eseshelve;
//            console.log(datas);
            $.post('/shelves/editor', datas, function (res) {
                if (res.status) {
                    alertify.success('修改货架成功');
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
        $("#example-input1-group2").bind('input propertychange', function () {
            var str = $(this).val();
            var name = $(".panel_box h4");
            if ($(this).val() == "") {
                $(".panel_box").show();
            } else {
                $(".panel_box").hide();
                for (let i = 0; i < name.length; i++) {
                    console.log(name.eq(i).html().indexOf(str))
                    if (name.eq(i).html().indexOf(str) != -1) {
                        $(".panel_box").eq(i).show()
                    }
                }
            }
        })
    </script>


@endsection
