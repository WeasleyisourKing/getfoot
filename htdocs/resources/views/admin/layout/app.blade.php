<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="shortcut icon" href="/uploads/12buy.ico">

    <title>SnackTalk商城管理系统</title>

    <style>

        .exce {
            text-align: center;
            vertical-align: middle !important;
        }

        .red {
            color: red;
        }

        .panel-title {
            font-size: 16px !important;
            font-weight: 600;
            margin-bottom: 0;
            margin-top: 0;
            text-transform: uppercase;

    </style>
    <!-- CSS Libs -->
    <link href="{{ asset('lib/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/css/alertify.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/css/fileinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/css/jedate.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/css/jedate.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('/css/pages.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('lib/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
          rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <link href="{{ asset('/css/icons.css') }}" rel="stylesheet">
    <!-- Javascript Lib -->
    <script src="{{ asset('js/vue.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/alertify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/wangEditor.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/fileinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/ileinput_locale_zh.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/jquery.jedate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/check.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('lib/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/element.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/echarts.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('/js/detect.js') }}"></script>--}}
{{--<script src="{{ asset('/js/fastclick.js') }}"></script>--}}
{{--<script src="{{ asset('/js/jquery.slimscroll.js') }}"></script>--}}
{{--<script src="{{ asset('/js/jquery.blockUI.js') }}"></script>--}}

{{--<script src="{{ asset('/js/jquery.nicescroll.js') }}"></script>--}}
{{--<script src="{{ asset('/js/jquery.scrollTo.min.js') }}"></script>--}}


{{--<!-- moment js  -->--}}
{{--<script src="{{ asset('/js/plugins/moment/moment.js') }}"></script>--}}

{{--<!-- counters  -->--}}
{{--<script src="{{ asset('/js/plugins/waypoints/lib/jquery.waypoints.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/counterup/jquery.counterup.min.js') }}"></script>--}}

{{--<!-- sweet alert  -->--}}
{{--<script src="{{ asset('/js/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>--}}


{{--<!-- flot Chart -->--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.time.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.tooltip.min.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.resize.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.pie.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.selection.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.stack.js') }}"></script>--}}
{{--<script src="{{ asset('/js/plugins/flot-chart/jquery.flot.crosshair.js') }}"></script>--}}

<!-- Javascript -->
    {{--<script src="{{ asset('/js/modernizr.min.js') }}" type="text/javascript"></script>--}}
    {{--<!-- todos app  -->--}}
    {{--<script src="{{ asset('/js/jquery.todo.js') }}" type="text/javascript"></script>--}}
    {{--<!-- chat app  -->--}}
    {{--<script src="{{ asset('/js/jquery.chat.js') }}" type="text/javascript"></script>--}}
    {{--<!-- dashboard  -->--}}
    {{--<script src="{{ asset('/js/jquery.dashboard.js') }}" type="text/javascript"></script>--}}
</head>


<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <div class="text-center">
                <a href="/dashboard" class="logo">
                    <i class="md md-dashboard"></i>
                    <span>SnackTalk</span>
                </a>
            </div>
        </div>
        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="">
                    <div class="pull-left">
                        <button class="button-menu-mobile open-left">
                            <i class="fa fa-bars"></i>
                        </button>
                        <span class="clearfix"></span>
                    </div>
                    <form class="navbar-form pull-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control search-bar" placeholder="搜索">
                        </div>
                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                    </form>

                    <ul class="nav navbar-nav navbar-right pull-right">
                        <li class="dropdown hidden-xs">
                            {{--<a href="#" data-target="#" class="dropdown-toggle waves-effect" data-toggle="dropdown"--}}
                               {{--aria-expanded="true">--}}
                                {{--<i class="md md-notifications"></i>--}}

                                {{--<!-- Notification 数量 -->--}}
                                {{--<span class="badge badge-xs badge-danger">数量</span>--}}

                            {{--</a>--}}
                            <ul class="dropdown-menu dropdown-menu-lg">
                                <li class="text-center notifi-title">消息</li>
                                <li class="list-group">
                                    <!-- list item-->
                                {{--<a href="javascript:void(0);" class="list-group-item">--}}
                                {{--<div class="media">--}}
                                {{--<div class="pull-left">--}}
                                {{--<em class="fa fa-user-plus fa-2x text-info"></em>--}}
                                {{--</div>--}}
                                {{--<div class="media-body clearfix">--}}
                                {{--<div class="media-heading">New user registered</div>--}}
                                {{--<p class="m-0">--}}
                                {{--<small>You have 10 unread messages</small>--}}
                                {{--</p>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</a>--}}
                                <!-- list item-->
                                {{--<a href="javascript:void(0);" class="list-group-item">--}}
                                {{--<div class="media">--}}
                                {{--<div class="pull-left">--}}
                                {{--<em class="fa fa-diamond fa-2x text-primary"></em>--}}
                                {{--</div>--}}
                                {{--<div class="media-body clearfix">--}}
                                {{--<div class="media-heading">New settings</div>--}}
                                {{--<p class="m-0">--}}
                                {{--<small>There are new settings available</small>--}}
                                {{--</p>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</a>--}}
                                <!-- list item-->
                                    <a href="javascript:void(0);" class="list-group-item">
                                        <div class="media">
                                            <div class="pull-left">
                                                <em class="fa fa-bell-o fa-2x text-danger"></em>
                                            </div>
                                            <div class="media-body clearfix">
                                                <div class="media-heading">Updates</div>
                                                <p class="m-0">
                                                    <small>There are
                                                        <span class="text-primary">2</span> new updates available
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- last list item -->
                                    <a href="javascript:void(0);" class="list-group-item">
                                        <small>See all notifications</small>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="hidden-xs">
                            <a href="#" id="btn-fullscreen" class="waves-effect"><i class="md md-crop-free"></i></a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->

    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">
            <div class="user-details">
                <div class="pull-left">
                    <img src="/image/timg.jpg" alt="" class="thumb-md img-circle">
                </div>
                <div class="user-info">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                           aria-expanded="false">{{Auth::user()->username}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            {{--<li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> 个人资料--}}
                            {{--<div class="ripple-wrapper"></div>--}}
                            {{--</a></li>--}}
                            {{--<li><a href="javascript:void(0)"><i class="md md-settings"></i> 设置</a></li>--}}
                            {{--<li><a href="javascript:void(0)"><i class="md md-lock"></i> 锁屏</a></li>--}}
                            {{--<li>--}}
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="md md-settings-power"></i> 注销
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            </li>
                            {{--<li><a href="javascript:void(0)"><i class="md md-settings-power"></i> 注销</a></li>--}}
                        </ul>
                    </div>

                    <p class="text-muted m-0">Administrator</p>
                </div>
            </div>
            <!--- Divider -->
            <?php
            use App\Http\Model\AdminRoleModel;
            use App\Http\Controllers\Common;
            use App\Http\Model\PrivilegeModel;

            $role = AdminRoleModel::with('auth')->where('id', '=', Auth::user()->role)->first();

            if (!is_null($role)) {
                $role = $role->toArray();

                $all = PrivilegeModel::whereIn('id',[1,2,3,4,5,6,41])->get()->toArray();

                $role = Common::getTree(array_merge($all,$role['auth']), 0);
            } else {
                $role = [];
            }


            ?>
            <div id="sidebar-menu">
                <ul>
                    @foreach($role as $key => $item)
                        @if (!empty($item['pid']))
                            <li class="has_sub">
                                <a id="select{{$item['id']}}" href="#" class="waves-effect waves-light "><i class="{{$item['icon']}}"></i>
                                    <span>{{$item['name']}}</span>
                                    <span class="pull-right"><i id="select{{$item['id']}}i" class="md md-add"></i></span></a>
                                <ul id="select{{$item['id']}}ul" class="list-unstyled">
                                    @foreach($item['pid'] as $items)
                                        <li><a href="{{$items['origin_route']}}">{{$items['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            @if (is_null($item['origin_route']))

                               <?php continue; ?>
                                @else
                                <li>
                                    <a id="select{{$item['id']}}" href="{{$item['origin_route']}}" class="waves-effect waves-light "><i class="{{$item['icon']}}"></i>
                                        <span>{{$item['name']}}</span>
                                    </a>
                                </li>
                            @endif

                            @endif


                     @endforeach

                        {{--<li>--}}
                            {{--<a id="select9" href="/business/list/status/-1/limit/20" class="waves-effect waves-light "><i--}}
                                        {{--class="md md-home"></i>--}}
                                {{--<span>商家订单管理</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}

                    {{--<li class="has_sub">--}}
                        {{--<a id="select2" href="#" class="waves-effect waves-light "><i class="md md-settings"></i>--}}
                            {{--<span>设置</span>--}}
                            {{--<span class="pull-right"><i id="select2i" class="md md-add"></i></span></a>--}}
                        {{--<ul id="select2ul" class="list-unstyled">--}}
                            {{--<li><a href="/set/general">通用设置</a></li>--}}
                            {{--<li><a href="/set/mail/status/1">邮件设置</a></li>--}}
                            {{--<li><a href="/set/deliver">邮递设置</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--<li class="has_sub">--}}
                        {{--<a href="#" id="select3" class="waves-effect waves-light"><i class="md md-palette"></i><span>内容管理</span>--}}
                            {{--<span class="pull-right"><i id="select3i" class="md md-add"></i></span></a>--}}
                        {{--<ul id="select3ul" class="list-unstyled">--}}
                            {{--<li><a href="/content/home/status/-1/category/-1/brand/-1/limit/5">首页内容</a></li>--}}
                            {{--<li><a href="/content/list">页面管理</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--<li class="has_sub">--}}
                        {{--<a href="#" id="select4" class="waves-effect waves-light"><i--}}
                                    {{--class="md md-group"></i><span>用户管理</span><span--}}
                                    {{--class="pull-right"><i id="select4i" class="md md-add"></i></span></a>--}}
                        {{--<ul id="select4ul" class="list-unstyled">--}}
                            {{--<li><a href="/user/role/limit/5">用户角色</a></li>--}}
                            {{--<li><a href="/user/list/status/-1/limit/5">用户管理</a></li>--}}
                            {{--<li><a href="/user/manager/limit/5">管理员角色</a></li>--}}
                            {{--<li><a href="/user/manager/type/-1/status/-1/limit/5">管理员管理</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--<li class="has_sub">--}}
                        {{--<a href="#" id="select5" class="waves-effect waves-light"><i--}}
                                    {{--class="md md-redeem"></i><span>产品管理</span> <span--}}
                                    {{--class="pull-right"><i id="select5i" class="md md-add"></i></span></a>--}}
                        {{--<ul id="select5ul" class="list-unstyled">--}}
                            {{--<li><a href="/product/category/status/-1/limit/20">分类管理</a></li>--}}
                            {{--<li><a href="/product/brand/status/-1/limit/20">品牌管理</a></li>--}}
                            {{--<li><a href="/product/list/status/-1/category/-1/brand/-1/limit/20">商品管理</a></li>--}}
                            {{--<li><a href="/product/message/status/-1/limit/5">商品评论</a></li>--}}
                            {{--<li><a href="/product/discount/status/-1/limit/5">优惠券管理</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--<li class="has_sub">--}}
                        {{--<a href="#" id="select6" class="waves-effect waves-light"><i class="md md-storage"></i><span>库存管理</span><span--}}
                                    {{--class="pull-right"><i id="select6i" class="md md-add"></i></span></a>--}}
                        {{--<ul id="select6ul" class="list-unstyled">--}}
                            {{--<li><a href="/stock/shelves">货架管理</a></li>--}}
                            {{--<li><a href="/stock/list">库存列表</a></li>--}}
                            {{--<li><a href="/stock/in">入库</a></li>--}}
                            {{--<li><a href="/stock/out">出库</a></li>--}}
                            {{--<li><a href="/stock/purchase">采购</a></li>--}}

                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--<li class="has_sub">--}}
                        {{--<a href="#" id="select7" class="waves-effect waves-light"><i--}}
                                    {{--class="md md-view-list"></i><span>订单管理</span><span class="pull-right"><i--}}
                                        {{--id="select7i" class="md md-add"></i></span></a>--}}
                        {{--<ul id="select7ul" class="list-unstyled">--}}
                            {{--<li><a href="/order/list/status/-1/limit/20">订单列表</a></li>--}}
                            {{--<li><a href="/order/mail">邮寄列表</a></li>--}}
                            {{--<li><a href="/order/freight">邮费设置</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a id="select8" href="/catch/list" class="waves-effect waves-light "><i class="md md-home"></i>--}}
                            {{--<span>抓货打包</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a id="select9" href="/business/list/status/-1/limit/20" class="waves-effect waves-light "><i--}}
                                    {{--class="md md-home"></i>--}}
                            {{--<span>商家订单管理</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}

                    {{--<li>--}}
                    {{--<a id="select1" href="/catch/show" class="waves-effect waves-light "><i class="md md-home"></i>--}}
                    {{--<span>支付测试</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                @yield("content")


            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer text-right">
            2018 © 普乐斯科技
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

</div>


<script>
    var resizefunc = [];
</script>
<script src="{{ asset('/js/wow.min.js') }}"></script>
<script src="{{ asset('/js/waves.js') }}"></script>
<script src="{{ asset('/js/jquery.app.js') }}"></script>
{{--<script src="{{ asset('lib/js/bootstrap.min.js') }}" type="text/javascript"></script>--}}

<!-- Datatable init js -->
<script src="{{ asset('lib/assets/pages/datatables.init.js') }}"></script>
<!-- Datatables-->
<script src="{{ asset('lib/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lib/assets/plugins/datatables/buttons.print.min.js') }}"></script>

<script>
    TableManageButtons.init();
</script>
<script>
    $("#bulk-btn").click(function () {
        if ($('.item-checkbox').is(':checked')) {
            $('.item-checkbox').prop('checked', false);
        } else {
            $('.item-checkbox').prop('checked', true);
        }
    });
</script>

<script>
    // Date Picker
    jQuery('.datepicker').datepicker({
        numberOfMonths: 3,
        showButtonPanel: true,
    });
</script>
<script>


    var url = window.location.pathname;
    strs = url.split("/");
    var obj = {
//        select1: ['dashboard'],
        select1: ['set'],
        select2: ['content'],
        select3: ['user'],
        select4: ['product'],
        select5: ['stock'],
        select6: ['order'],
        select7: ['catch'],
        select8: ['business']

    };

    for (let i = 1; i < 10; i++) {
        //匹配成功
        if ((obj['select' + i]).indexOf(strs[1]) != -1) {
            $('#select' + i).addClass('subdrop').siblings().removeClass('subdrop');
            $('#select' + i + 'i').addClass('md-remove').removeClass('md-add').siblings().removeClass('md-remove');
            $('#select' + i + 'ul').css('display', 'block');
        }
    }
</script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
    });
</script>


</body>
</html>