@extends('admin/layout.app')

@section('content')

    <script language="javascript">

        window.onbeforeunload = function (event) {

            event.returnValue = "";
            if (!window.datas) {
                return;
            }

            var res = {
                'id': window.datas.id
            };

            $.get('/catch/reduction', res, function () {

                if (res.status) {

                    return;
                } else {
                    alertify.alert(res.message);
                }
            })
        };

    </script>
    <div class="row">

        <div id="handle" style="display: block;" class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="jumbotron">
                        <h3>{{$name}}，下午好！</h3>
                        <h5>今天还有<span id="status">{{$number}}</span>个订单等待处理！</h5>
                    </div>
                    <button id="ProcessOrder" class="btn btn-info waves-effect waves-light btn-lg btn-block">开始处理订单
                    </button>

                </div>
            </div>
        </div>

        <div id="distribution" style="display: none;" class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="jumbotron">
                        <h2>正在分配订单。。。</h2>
                    </div>
                    <button class="btn btn-success disabled waves-effect waves-light btn-lg btn-block">正在分配</button>

                </div>
            </div>
        </div>

        <div name="shopInfo" style="display: none;" class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="jumbotron">
                        <h5>订单编号:</h5>
                        <p id="orderId"></p>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label" for="example-input1-group1">请用扫码枪扫码商品包装上的条形码</label>
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="text" autofocus="autofocus" id="sku" class="form-control" placeholder="SKU" />

                            </div>
                        </div>
                    </div> <!-- form-group -->


                    <div class="col-md-12 m-t-20" id="productDetailed" style="display: none;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">当前商品</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>存放位置</th>
                                                    <th>SKU</th>
                                                    <th>商品名称</th>
                                                    <th>订单数量</th>
                                                </tr>
                                                </thead>
                                                <tbody id="productData">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 m-t-20">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle waves-effect"
                                            data-toggle="dropdown" aria-expanded="false"><span id="prompt">全部</span>
                                        <span
                                                class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="all" href="javascript:void(0);">全部</a></li>
                                        <li><a id="Packing" href="javascript:void(0)">已打包</a></li>
                                        <li><a id="Packed" href="javascript:void(0)">未打包</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>存放位置</th>
                                                    <th>SKU</th>
                                                    <th>商品名称</th>
                                                    <th>订单数量</th>
                                                </tr>
                                                </thead>
                                                <tbody id="orderData">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >
                    <label class="col-md-12 control-label" for="example-input1-group1">快递单号</label>
                    <div class="col-md-12">
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                    <input type="text" id="track"
                    class="form-control" placeholder="tracking number">
                    </div>
                    </div>
                    </div> <!-- form-group -->
                </div>
            </div>
        </div>


        <div name="shopInfo" style="display: none;" class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="jumbotron">
                        <h2>完成抓货后</h2>
                        <p>确认订单无异常请点击完成，若订单未完成请点击订单异常</p>
                    </div>
                    <button onclick="success();" class="btn btn-success waves-effect waves-light btn-lg">订单完成</button>
                    <button onclick="fail();" class="btn btn-danger waves-effect waves-light btn-lg">订单异常</button>
                </div>
            </div>
        </div>

    </div>


    <script>

        if ($('#status').text() <= 0) {
            $('#ProcessOrder').addClass('disabled btn-success').removeAttr('id').removeClass('btn-info');
        }

        //点击处理订单
        $('#ProcessOrder').click(function () {

            $('#handle').css('display', 'none');
            $('#distribution').css('display', 'block');

            $.get('/catch/order', '', function (res) {

                if (res.status) {

                    window.datas = res.data.data;


                    window.products = JSON.parse(JSON.stringify(res.data.product));
//                    window.packingProduct = [];
                    window.packingProduct = JSON.parse(JSON.stringify(res.data.product));
                    window.packedProduct = JSON.parse(JSON.stringify(res.data.product));


                    $('#orderId').text(res.data.data.order_no);
                    var data = '';
                    var shop = [];
                    for (let i in res.data.product) {

                        shop.push({'id': res.data.product[i].id, 'count': res.data.product[i].count});

                        data += `<tr><td>${res.data.product[i].shelves}</td>
                            <td>${res.data.product[i].sku}</td>
                            <td>${res.data.product[i].name}</td>
                             <td>${res.data.product[i].count}</td>
                             </tr>`;
                    }
                    window.shop = shop;

                    $('#distribution').css('display', 'none');
                    $('#orderData').html(data);
                    $("div[name='shopInfo']").show();

                    //初始化已打包
                    for (let j in window.packingProduct) {

                        window.packingProduct[j].first = 1;
                        window.packingProduct[j].count = 0;

                    }
                } else {
                    alertify.alert(res.message);
                }
            })

        })
    </script>

    <script>

        //全部
        $('#all').click(function () {

            allfun();
        })

        var allfun = function () {
            var all = '';
            for (let i in window.products) {

                all += `<tr><td>${window.products[i].shelves}</td>
                            <td>${window.products[i].sku}</td>
                            <td>${window.products[i].name}</td>
                             <td>${window.products[i].count}</td>
                             </tr>`;
            }
            $('#prompt').attr('data-sta', 1).text('全部');
            $('#orderData').html(all);
        }


        //已打包
        $('#Packing').click(function () {

            Packingdfun();
        })

        var Packingdfun = function () {
            var Packing = '';
            for (let i in window.packedProduct) {

                Packing += `<tr><td>${window.packingProduct[i].shelves}</td>
                            <td>${window.packingProduct[i].sku}</td>
                            <td>${window.packingProduct[i].name}</td>
                             <td>${window.packingProduct[i].count}</td>
                             </tr>`;
            }

            $('#prompt').attr('data-sta', 2).text('已打包');
            $('#orderData').html(Packing);
        }

        //未打包
        $('#Packed').click(function () {

            Packedfun();
        })

        var Packedfun = function () {
            var Packed = '';
            for (let i in window.packedProduct) {

                Packed += `<tr><td>${window.packedProduct[i].shelves}</td>
                            <td>${window.packedProduct[i].sku}</td>
                            <td>${window.packedProduct[i].name}</td>
                             <td>${window.packedProduct[i].count}</td>
                             </tr>`;
            }

            $('#prompt').attr('data-sta', 3).text('未打包');
            $('#orderData').html(Packed);
        }

        //输入框变化
        $('#sku').on('input propertychange', function () {

            var status = -1,
                dataInfo = '',
                pInfo;

            for (let i in window.packingProduct) {

                //对比sku
                if (window.packingProduct[i].sku == $(this).val()) {

                    status = 1;
                    pInfo = i;
                    console.log(pInfo);
                }
            }

            if (status == -1) {
                alertify.alert('该订单没有此商品的SKU');
                return;
            }
            //已打包
            window.packingProduct[pInfo].count++;

            //未打包
            window.packedProduct[pInfo].count--;

            //数量处理
            if (window.packingProduct[pInfo].count > Number(window.products[pInfo].count)) {

                window.packingProduct[pInfo].count--;
                window.packedProduct[pInfo].count++;
                alertify.alert(window.packingProduct[pInfo].name + '商品没有订单数量了');
                return;
            }

            //显示扫码所对应商品
            dataInfo += `<tr><td>${window.packingProduct[pInfo].shelves}</td>
                            <td>${window.packingProduct[pInfo].sku}</td>
                            <td>${window.packingProduct[pInfo].name}</td>
                             <td>${window.packingProduct[pInfo].count}</td>
                             </tr>`;

            $('#productDetailed').show();
            $('#productData').html(dataInfo);


            switch ($('#prompt').attr('data-sta')) {
                case '2' :
                    Packingdfun();
                    break;
                case '3' :
                    Packedfun();
                    break;
            }

        })

        //点击完成
        var success = function () {

            for (let i in window.packedProduct) {
                if (window.packedProduct[i].count > 0) {
                    alertify.alert('订单中没有抓完' + window.packedProduct[i].name + '商品');
                    return;
                }
            }

            Interface(1);

        }

        //点击失败
        var fail = function () {
            alertify.confirm("确认框", function (e) {
                if (e) {
                    Interface(2);
                }

            });

        }

        var Interface = function (status) {


            var res = {
                'id': window.datas.id,
                'status': status,
//                'products':window.shop,
//                'track' : $('#track').val(),
                '_token': '{{csrf_token()}}'
            };
            if (status != 2) {
                //成功
                var track = $('#track').val().replace(/(^s*)|(s*$)/g, "");//去除空格
                if (track == '' || track == undefined || track == null || track.length == 0) {
                    alertify.alert('快递单号不能为空');
                    return;
                }
                res.track = track;
            }
            $.post('/catch/status', res, function (res) {

                if (res.status) {

                    alertify.alert('订单更新成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }

    </script>

@endsection