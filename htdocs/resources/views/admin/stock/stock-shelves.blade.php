@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->
    <!-- 编辑 Modal -->

    <div id="edit" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">修改商品货架</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>商品名称 :
                            <text style="font-weight: 400;" id="name"></text>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="shelves">商品货架<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="shelves" id="shelves"
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
            <h4 class="pull-left page-title">库存管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">库存管理</a></li>
                <li class="active">货架管理</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">货架管理</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <!-- 搜索 -->


                <!-- 搜索 -->
                <div class="row">
                    <div class="col-sm-3">

                    </div>

                    <!-- 搜索框 -->

                    <div class="col-sm-3 col-md-offset-6">
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
                    </div>

                </div>
                <!-- 搜索 -->


                <!-- 表单 -->
                <div class="row m-t-30">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">商品列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="btn-group col-md-2">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="true">{{$limit}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="select" href="">20条</a></li>
                                        <li><a id="select10" href="">50条</a></li>
                                        <li><a id="select15" href="">100条</a></li>
                                        {{--<li><a id="select20" href="">20条</a></li>--}}
                                    </ul>
                                </div>
                                <div class="col-md-8"></div>

                            </div>

                            <div class="row m-t-10">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="table" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="col-md-2 col-lg-2 exce"> 商品名称</th>
                                            <th class="col-md-2 col-lg-2 exce"> SKU</th>
                                            <th class="col-md-3 col-lg-3 exce"> 商品图片</th>
                                            <th class="col-md-3 col-lg-3 exce"> 商品货架</th>
                                            <th class="col-md-2 col-lg-2 exce"> 操作</th>

                                        </tr>
                                        </thead>

                                        <tbody id="postContainer">
                                        @foreach ($data as $item)
                                            <tr>

                                                <td class="exce">{{ $item->zn_name }} <br/>{{ $item->en_name }}</td>
                                                <td class="exce">{{ $item->sku }}</td>
                                                <td class="exce"><img height="100px; align=" middle"
                                                    src="{{ $item->product_image }}"
                                                    alt="没有上传"/>
                                                </td>
                                                <td class="exce">{{ $item->shelves }}</td>

                                                <td class="exce">
                                                    <a title="修改信息" onclick="edit(this);"  class="btn btn-small btn-info"
                                                       data-id="{{$item->id}}" data-name="{{$item->zn_name}}（{{$item->en_name}}）"
                                                       data-shelves="{{ $item->shelves }}"
                                                       href="javascript:void(0);">
                                                        <i class="icon fa fa-pencil"> </i>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                    <div id="link" style="clear: both;text-align: center;">
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
        strs.splice(4, 1, 20);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换limit为5
        strs.splice(4, 1, 50);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换limit为5
        strs.splice(4, 1, 100);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换limit为5
//        strs.splice(4, 1, 20);
//        var val3 = strs.join('/');
//        $('#select20').attr('href', val3);


        var url = window.location.pathname;
        strs = url.split("/");
        $('#form').attr('action', '/stock/search/' + strs[4]);
    </script>

    <script>
        //显示
        var edit = function (event) {
            $('#name').text($(event).attr('data-name'));
            $('#shelves').val($(event).attr('data-shelves'));
            $('#edit-save').attr('data-id',$(event).attr('data-id'));
            $('#edit').modal('toggle');
        }
        //修改
        var efunb = function (event) {

            var datas = {
                'id':$(event).attr('data-id'),
                'shelves': $('#shelves').val(),
                '_token': '{{csrf_token()}}'
            };

            $.post('/edit/shelves', datas, function (res) {
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
                            ' <th class="col-md-2 col-lg-2 exce">  SKU</th>' +
                            '<th class="col-md-3 col-lg-3 exce"> 商品图片</th> ' +
                            ' <th class="col-md-3 col-lg-3 exce"> 商品货架</th>'+
                            '<th class="col-md-2 col-lg-2 exce">操作</th>' +
                            ' </tr>' +
                            ' </thead><tbody id="postContainer">';

                        for (let i in res.data) {


                            if (typeof res.data[i].shelves == 'object') {
                                var shelves = ' ';
                            } else {
                                var shelves = res.data[i].shelves ;
                            }

                            datas += `<tr>
                                     <td class="exce">${res.data[i].zn_name}<br/>${res.data[i].en_name}</td>
                                   <td class="exce">${res.data[i].sku}</td>
                                        <td class="exce"><img height="100px; align=" middle"
                                                    src="${res.data[i].product_image}"
                                                    alt="没有上传"/>
                                                </td>
                                                 <td class="exce">${shelves}</td>
                                                <td class="exce">
                                                    <a title="修改信息" onclick="edit(this);"  class="btn btn-small btn-info"
                                                       data-id="${res.data[i].id}" data-name="${res.data[i].zn_name}（${res.data[i].en_name}）"
                                                       data-shelves="${ shelves }"
                                                       href="javascript:void(0);">
                                                        <i class="icon fa fa-pencil"> </i>
                                                    </a>
                                                </td>
                                  </tr>`;
                        }
                        datas += ' </tbody>';
                    }
                    alertify.success('获取成功');
                    $('#link').hide();
                    $('#table').html(datas);
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>



@endsection
