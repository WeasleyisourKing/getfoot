@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->


    {{--留言--}}
    <div id="messgageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">用户留言历史</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <table class="table table-striped">
                            <tbody id="users">
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">回复留言信息</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>评论人名称 :
                            <text style="font-weight: 400;" id="name"></text>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>评论消息 :
                            <text style="font-weight: 400;" id="news"></text>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="messgage">回复（最多200字）</label>
                        <div class="controls">
                                        <textarea maxlength="200" name="messgage" id="messgage"
                                                  style=" resize: none;height: 100px;" class="form-control"
                                                  value=""></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="submit();" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">产品管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">产品管理</a></li>
                <li class="active">商品评论</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">商品评论</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <!-- 搜索 -->
                <form class="form-horizontal" role="form">

                    <!-- 搜索 -->
                    <div class="row">
                        <div class="col-sm-3">


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
                            <h3 class="panel-title">评论列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="btn-group col-md-2">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="true">{{$limit}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="select" href="">5条</a></li>
                                        <li><a id="select10" href="">10条</a></li>
                                        <li><a id="select15" href="">15条</a></li>
                                        <li><a id="select20" href="">20条</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="table" class="table table-striped table-bordered">
                                        <thead>

                                        <tr>
                                            <th class="col-md-2 col-lg-2 exce"> 商品名称</th>
                                            <th class="col-md-2 col-lg-2 exce"> 商品图片</th>
                                            <th class="col-md-1 col-lg-1 exce"> 评论人</th>
                                            <th class="col-md-2 col-lg-2 exce"> 评论内容</th>

                                            <th class="col-md-1 col-lg-1 exce">
                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-default dropdown-toggle waves-effect"
                                                            data-toggle="dropdown" aria-expanded="false">{{$status}}
                                                        <span
                                                                class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="statusAll" href="javascript:void(0);">全部状态</a></li>
                                                        <li><a id="statusShow" href="javascript:void(0);">回复</a></li>
                                                        <li><a id="statusHide" href="javascript:void(0);">没回复</a></li>

                                                    </ul>
                                                </div>
                                            </th>
                                            <th class="col-md-2 col-lg-2 exce"> 评论时间</th>
                                            <th class="col-md-2 col-lg-2 exce" class="td-actions"> 操作</th>
                                        </tr>
                                        </thead>
                                        <tbody id="postContainer">

                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td class="exce">{{$item->messageImg->zn_name}}</br>{{ $item->messageImg->en_name }}</td>
                                                <td class="exce"><img height="100px; align=" middle" src="{{ $item->messageImg->product_image }}"
                                                    alt="没有上传"/>
                                                </td>
                                                <td class="exce">{{ $item->name }}</td>
                                                <td class="exce">{{ $item->content }}</td>
                                                @if ($item->status == 1)
                                                    <td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i></td>
                                                @else
                                                    <td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i></td>
                                                @endif
                                                <td class="exce">{{ $item->created_at }}</td>

                                                <td class="exce">
                                                    <a title="回复信息" id="message{{$item->id}}"
                                                       data-id="{{$item->id}}" data-name="{{$item->name}}"
                                                       data-new="{{$item->content}}"
                                                       class="btn btn-small btn-success" href="javascript:;"
                                                       onclick="onfunc(this);">
                                                        <i class="icon fa fa-comments-o"> </i>
                                                    </a>
                                                    <a title="查看历史" id="info" data-id="{{$item->user_id}}" data-product="{{$item->product_id}}"
                                                       data-order="{{$item->order_id}}"
                                                       class="btn btn-small btn-info" href="javascript:;"
                                                       onclick="func(this);">
                                                        <i class="icon fa fa-history"> </i>
                                                    </a>
                                                    {{--<a title="删除" class="btn btn-small btn-danger"--}}
                                                       {{--href="javascript:void(0);" data-id="{{$item->id}}"--}}
                                                       {{--onclick="del(this);">--}}
                                                        {{--<i class="icon fa fa-trash-o"> </i>--}}
                                                    {{--</a>--}}
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
        strs.splice(6, 1, 5);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(6, 1, 10);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(6, 1, 15);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
        strs.splice(6, 1, 20);
        var val3 = strs.join('/');
        $('#select20').attr('href', val3);

        var url = window.location.pathname;
        strs = url.split("/");

        //替换status为5
        strs.splice(4, 1, -1);
        var val4 = strs.join('/');
        $('#statusAll').attr('href', val4);


        //替换status为5
        strs.splice(4, 1, 1);
        var val5 = strs.join('/');
        $('#statusShow').attr('href', val5);


        //替换status为5
        strs.splice(4, 1, 2);
        var val6 = strs.join('/');
        $('#statusHide').attr('href', val6);
    </script>


    <script>
        //回复窗口
        function onfunc(event) {

            $('#name').text($(event).attr('data-name'));
            $('#news').attr('data-id', $(event).attr('data-id'));
            $('#news').text($(event).attr('data-new'));
            $('#myModal').modal('toggle');
        }
        //点击提交
        function submit() {

            var obj = $("#message" + $('#news').attr('data-id'));

            $.post('/reply/message', {
                'news': $('#messgage').val(),
                'id': obj.attr('data-id'),
                'name' : obj.attr('data-name'),
                '_token': "{{csrf_token()}}"
            }, function (res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    $('#message').text('');
                    alertify.success('回复成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }

        //查看以往历史
        function func(event) {

            $.post('/search/history', {
                'userId': $(event).attr('data-id'),
                'productId': $(event).attr('data-product'),
                'orderId': $(event).attr('data-order'),
                '_token': "{{csrf_token()}}"
            }, function (res) {

                if (res.status) {
                    if (res.data.length == 0) {
                        var datas = '<div><h5 style="color: red;">暂时没有记录</h5></div>';
                    } else {
                        var datas = '';

                        for (let i in res.data) {

                            if (i == 0) {
                                datas += `<tr><td class="col-md-8 col-lg-8"><label>${res.data[i].name} : <text style="font-weight: 400;">${res.data[i].content}</text></label></td>
<td class="col-md-2 col-lg-2" style="height: 10px;"><span style="float: right;text-align: center;">${res.data[i].created_at}</span></td><td class="col-md-2 col-lg-2 exce" style=" cursor: pointer;" data-message="${res.data[i].message_id}" data-id="${res.data[i].id}" data-user_id="${res.data[i].user_id}" data-status="1" onclick="del(this);">删除</td></tr>`;
                                continue;
                            }
                            datas += `<tr><td class="col-md-8 col-lg-8"><label>${res.data[i].name} <span style="font-weight: 400;">回复</span> ${res.data[i].message_name} : <text style="font-weight: 400;">${res.data[i].content}</text></label></td>
<td class="col-md-2 col-lg-2" style="height: 10px;"><span style="float: right;text-align: center;">${res.data[i].created_at}</span></td><td class="col-md-2 col-lg-2 exce" style=" cursor: pointer;" data-message="${res.data[i].message_id}" data-id="${res.data[i].id}" data-user_id="${res.data[i].user_id}" data-status="2" onclick="del(this);">删除</td></tr>`;

                        }
                    }
                }
                $('#users').html(datas);
                $('#messgageModal').modal('toggle');

            })
        }


        //删除
        var del = function (event) {

            var meg = $(event).attr('data-status') != 1 ? '确认删除此条信息吗？' : '确认删除全部信息吗？';

            alertify.confirm(meg, function (e) {
                if (e) {

                    $.get('/message/del', {'id': $(event).attr('data-id'),'status': $(event).attr('data-status'),'user_id': $(event).attr('data-user_id')}, function (res) {

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

@endsection
