@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->

    <!-- 添加 Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 1000px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">添加商家订单</h4>
                </div>

                <div class="form-group">
                    <ul id="myTab" class="nav nav-tabs navtab-bg ">
                        <li class="active">
                            <a href="#shop" data-toggle="tab">订单商品</a>
                        </li>
                        <li>
                            <a href="#adds" data-toggle="tab">收货地址</a>
                        </li>
                        </li>

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="shop">
                            <div class="form-group" style="width:100px;margin-bottom: 20px;display:none">
                                <label class="control-label">价格类型<span style="color:red;">＊</span></label>
                                <select class="form-control" id="pstatus">
                                    <option value="1">成本价</option>
                                    <option value="2">代理商</option>
                                    <option value="3">分销商</option>
                                    <option value="4">商业用户</option>
                                    <option value="5">零售</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label class="control-label">商家昵称:<span id="searchUserName"></span></label>
                                <div class="input-group">
                                    <input id="searchUser" class="form-control"
                                        placeholder="请输入商家昵称" type="text">
                                    <span class="input-group-btn">
                                                        <button type="button" onClick="SearchUser()"
                                                                class="btn waves-effect waves-light btn-primary">
                                                            <i class="fa fa-search"></i>
                                                        </button>

                                                        </span>
                                </div>
                            </div>

                            <div id="searchUserList" class="form-group">

                            </div>

                            <div id="content" class="form-group">
                            </div>
                            <div class="input-group">
                                <input id="searchString" class="form-control"
                                       placeholder="请输入SKU或者商品中文名称" type="text">
                                <span class="input-group-btn">
                                                    <button type="button" onClick="doPostSearch();"
                                                            class="btn waves-effect waves-light btn-primary">
                                                        <i class="fa fa-search"></i>
                                                    </button>

                                                    </span>
                            </div>

                            <div class="form-group">
                                <table id="table" class="table table-bordered" style="margin-top: 30px;">
                                </table>
                            </div>

                            {{--<div id="content" class="form-group">--}}
                            {{--</div>--}}

                        </div>

                        <div class="tab-pane fade" id="adds">
                            <div class="form-group">
                                <label class="control-label" for="name">收件人（最多40字）<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="name" id="name"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="mobile">联系电话<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="mobile" id="mobile"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">email<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="email" id="email"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="country">地址1<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="country" id="country"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="detail">地址2<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="detail" id="detail"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="city">城市<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="city" id="city"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="province">州<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="province" id="province"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="zip">邮编<span
                                            style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="zip" id="zip"
                                           class="form-control"
                                           value="" required="required"/>
                                </div>
                            </div>
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

    <!-- 编辑 Modal -->


    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">商家订单管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">商家订单管理</a></li>
                <li class="active">商家订单列表</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">商家订单管理</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <!-- 搜索 -->
                <form class="form-horizontal" role="form">

                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal"
                                    data-target="#add">
                                <i class="fa fa-plus"></i> Add
                            </button>


                        </div>

                        {{--<div class="col-sm-3 col-md-offset-6">--}}
                            {{--<div class="input-group">--}}
                                {{--<input id="example-input2-group2" name="example-input2-group2" class="form-control"--}}
                                       {{--placeholder="Search" type="email">--}}
                                {{--<span class="input-group-btn">--}}
                                                    {{--<button type="button"--}}
                                                            {{--class="btn waves-effect waves-light btn-primary">--}}
                                                        {{--<i class="fa fa-search"></i>--}}
                                                    {{--</button>--}}
                                                    {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <!-- 搜索 -->

                </form>

                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">商家订单列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                {{--<div class="btn-group col-md-2">--}}
                                    {{--<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"--}}
                                            {{--aria-expanded="true">{{$limit}} <span class="caret"></span></button>--}}
                                    {{--<ul class="dropdown-menu" role="menu">--}}
                                        {{--<li><a id="select" href="">20条</a></li>--}}
                                        {{--<li><a id="select10" href="">50条</a></li>--}}
                                        {{--<li><a id="select15" href="">100条</a></li>--}}
                                        {{--<li><a id="select20" href="">20条</a></li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    {{--<table class="table table-bordered">--}}
                                    <table class="table table-bordered table-striped display" id="datatable-buttons">
                                        <thead>
                                        <tr>
                                            <th class="col-md-2 col-lg-2 exce"> 订单号</th>
                                            <th class="col-md-2 col-lg-2 exce"> 总数量</th>
                                            <th class="col-md-2 col-lg-2 exce"> 总价格($)</th>
                                            <th class="col-md-1 col-lg-2 exce"> 下单时间</th>
                                            <th class="col-md-2 col-lg-2 exce">
                                                状态
                                                {{--<div class="btn-group ">--}}
                                                    {{--<button type="button"--}}
                                                            {{--class="btn btn-default dropdown-toggle waves-effect"--}}
                                                            {{--data-toggle="dropdown" aria-expanded="false">{{$title}}--}}
                                                        {{--<span--}}
                                                                {{--class="caret"></span></button>--}}
                                                    {{--<ul class="dropdown-menu" role="menu">--}}
                                                        {{--<li><a id="statusAll" href="javascript:void(0);">全部状态</a></li>--}}
                                                        {{--<li><a id="status1" href="javascript:void(0);">已完成</a></li>--}}
                                                        {{--<li><a id="status2" href="javascript:void(0);">已下单</a></li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                            </th>

                                            <th class="col-md-2 col-lg-2 exce" class="td-actions"> 操作</th>
                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $item)
                                            <tr>

                                                <td class="exce">{{ $item->order_no }}</td>
                                                <td class="exce">{{ $item->total_count }}</td>
                                                <td class="exce">{{ $item->total_price }}</td>
                                                <td class="exce">{{ $item->created_at }}</td>
                                                <td class="exce">{{ $item->state }}</td>


                                                <td class="exce">
                                                    <a title="查看订单" id="info" data-id="{{$item->id}}"
                                                       class="btn btn-small btn-success"
                                                       href="/business/detail/id/{{$item->id}}/status/{{$item->status}}"
                                                    >
                                                        <i class="icon fa fa-file-text"> </i>
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
                                    <div style="clear: both;text-align: center;">
                                        {{ $data->links() }}
                                    </div>

                                </div>
                                @if(!$data->count())
                                    <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                @endif
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

        var url = window.location.pathname;
        strs = url.split("/");

        //替换limit为5
        strs.splice(6, 1, 20);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(6, 1, 50);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(6, 1, 100);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
//        strs.splice(6, 1, 20);
//        var val3 = strs.join('/');
//        $('#select20').attr('href', val3);

        var url = window.location.pathname;
        strs = url.split("/");

        //替换status为5
        strs.splice(4, 1, -1);
        var val4 = strs.join('/');
        $('#statusAll').attr('href', val4);


        //替换status为5
        strs.splice(4, 1, 1);
        var val5 = strs.join('/');
        $('#status1').attr('href', val5);


        //替换status为5
        strs.splice(4, 1, 2);
        var val6 = strs.join('/');
        $('#status2').attr('href', val6);

    </script>




    <script>

        //删除
        var del = function (event) {

            alertify.confirm("确认删除吗？", function (e) {
                if (e) {

                    $.get('/business/order/del', {'id': $(event).attr('data-id')}, function (res) {

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
        var SearchUserRole=(aa)=>{
            console.log(aa)
            if(aa==2){
                return "分销商"

            }else if(aa==3){

                return "代理商"
            }else{

                return "商业用户"
            }
            // switch(aa)
            // {
            //     case 2:
            // console.log(2)
            //     break;
            //     case 3:
            // console.log(3)
            //     break;
            //     case 4:
            // console.log(4)
            //     break;

            // console.log(5)
            // }
        }
        //搜索用户
         var SearchUserData
         var SearchUserText
         var SearchUser = ()=>{
            if(SearchUserText==$("#searchUser").val()){
                return false
            }else{
                SearchUserText=$("#searchUser").val()
                $.get('/business/users', {'value': $('#searchUser').val()}, function (res) {
                    console.log(res)
                    if (res.status) {
                        if (res.data.length == 0) {
                            alertify.alert('搜索不到数据');
                            return;
                        } else {
                            SearchUserData=res.data
                            var datas = '<table class="table table-bordered" style="margin-top: 30px;"><thead >' +
                                ' <tr>' +
                                ' <th class="col-md-3 exce">商家昵称</th>' +
                                ' <th class="col-md-3 exce">商家类型</th>' +
                                '<th class="col-md-3 exce">商家邮箱</th> ' +
                                '<th class="col-md-3 exce">操作</th>' +
                                ' </tr>' +
                                ' </thead><tbody id="searchUserNameListPro">';

                            for (let i in res.data) {
                                console.log(SearchUserRole(res.data[i].role))
                                datas += `<tr>
                                        <td class="exce">${res.data[i].name}</td>
                                    <td class="exce">${SearchUserRole(res.data[i].role)}</td>
                                            <td class="exce">${res.data[i].email}</td>
                                           <td class="exce">
                        <a title="添加商品"  data-name=""
                                                       class="btn btn-small btn-success"
                                                       href="javascript:void (0);"
                                                       onclick="Usercode(${i})" >
                                                        <i class="icon fa fa-check"> </i>
                                                    </a>
                                                </td>
                                    </tr>`;
                            }
                            datas += '</tbody></table>';
                            
                            $("#searchUserList").html(datas)
                        }
                        alertify.success('获取成功');
                    //                    $('#link').hide();
                        // $('#table').html(datas);
                    } else {
                        alertify.alert(res.message);
                    }
                })
            }
        }
        //选择商家用户
        var Usercode=(i)=>{
            $("#searchUserName").html(`${SearchUserData[i].name} (${SearchUserRole(SearchUserData[i].role)})`)

            $("#searchUserList").html("");
            $('#pstatus').val(SearchUserData[i].role)
            $('#name').val(SearchUserData[i].manys[0].name)
            $('#mobile').val(SearchUserData[i].manys[0].mobile)
            $('#province').val(SearchUserData[i].manys[0].province)
            $('#city').val(SearchUserData[i].manys[0].city)
            $('#country').val(SearchUserData[i].manys[0].country)
            $('#detail').val(SearchUserData[i].manys[0].detail)
            $('#zip').val(SearchUserData[i].manys[0].zip)
            $('#email').val(SearchUserData[i].email)
            
        }
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
                            ' <th class="col-md-2 col-lg-2 exce">  SKU</th>' +
                            '<th class="col-md-2 col-lg-2 exce"> 商品图片</th> ' +
                            '<th class="col-md-2 col-lg-2 exce">价格（$）</th>' +
                            '<th class="col-md-2 col-lg-2 exce">库存</th>' +
                            '<th class="col-md-2 col-lg-2 exce">操作</th>' +
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
                                         <td class="exce">
                                            <b>成本价</b>：${res.data[i].price}</br>
                                            <b>代理商</b>：${res.data[i].distributor.level_one_price}</br>
                                            <b>分销商</b>：${res.data[i].distributor.level_two_price}</br>
                                            <b>商业用户</b>：${res.data[i].distributor.level_three_price}</br>
                                            <b>零售</b>：${res.data[i].distributor.level_four_price}
                                                </td>
                                            <td class="exce">${res.data[i].stock}
                                                </td>
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

                    $('#content').append(` <div class="form-group DeleteThat panel" style="padding:20px;">
                        <div class="input-group">
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
                                                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis " onclick="Delete1(this)"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </span>

                        </div>

                    </div>`);
                    window.arr.push($(event).attr('data-id'));
                } else {
                    return;
                }


            } else {
                $('#content').append(` <div class="form-group DeleteThat panel" style="padding:20px;">
                        <div class="input-group">
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
                                                        <button class="btn-sm btn-danger waves-effect waves-light delete-item-btn DeleteThis " onclick="Delete1(this)"><i class="fa fa-trash"></i>
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

        //点击添加
        $('#sa-save').click(function () {

            window.obj = [];
            window.objs = [];

            var i = 0;

            $("input[name='productNumber']").each(function () {

                window.obj.push({'product_id': window.arr[i], "count": $(this).val()});
                i++;
                window.objs.push({
                    'product_id': $(this).attr('data-id'),
                    'overdue': $(this).parent().next().find('input').val(),
                    "count": $(this).val()
                });
            });

//            $("input[name='productNumber']").each(function () {
//
//                if ($(this).val() != 0) {
//                    window.obj.push({
//                        'product_id': $(this).attr('data-id'),
//                        "count": $(this).val()
//                    });
//                    window.objs.push({
//                        'product_id': $(this).attr('data-id'),
//                        'overdue': $(this).parent().next().find('input').val(),
//                        "count": $(this).val()
//                    });
//                    i += Number($(this).val());
//                }
//
//
//            });
            var datas = {
                'products': window.obj,
                'uproducts': window.objs,
                'pstatus' : $('#pstatus').val(),
                'name': $('#name').val(),
                'mobile': $('#mobile').val(),
                'province': $('#province').val(),
                'city': $('#city').val(),
                'country': $('#country').val(),
                'detail': $('#detail').val(),
                'zip': $('#zip').val(),
                'email':$('#email').val(),
                '_token': '{{csrf_token()}}'

            }

            $.post('/business/order/add', datas, function (res) {
                if (res.status) {
                    alertify.success('创建订单成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })

        })

        var Delete1 =function(aa){
            var that=$(".DeleteThis").index(aa);
            console.log(that);
            var data_id_index
            var data_id=$(".DeleteThat input").eq(0).attr('data-id')
            $(".DeleteThat").eq(that).remove();
            for(var i=0;i<window.arr.length;i++){
                if(window.arr[i]==data_id){
                    data_id_index=i
                }
            }
            window.arr.splice(data_id_index+1, 1)
        }
    </script>






@endsection
