@extends('/app/layouts.app')


@section('content')
    <style type="text/css">
        .app h6 {

            display: block !important;
            margin: 0;
        }

        .app small {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
    <!-- Mobile Top Nav -->

    <div class="container bg-gradient pb-2">
        <div class="d-flex justify-content-between pt-3 align-items-center">
            <div class="col-3 px-2">
                <img class="w-100" src="/uploads/snackicon.png" alt="logo">
            </div>
            <div class="col-7 pl-2 pr-0" id="seach">
                <form action="/apps/productList" method="get">
                    <div class="input-group">
                        <div class="input-group-prepend">
                       <span class="input-group-btn top-search-prepend shaddow-light  input-group-text ">
						<button class="btn btn-default input-group-btn top-search-prepend   input-group-text"
                                onsubmit="$('#Search').submit();" style="background: none">
							<i class="fa fa-search"></i>
						</button>
					</span>

                        </div>

                        <input name="search" type="text" class="form-control top-search-input shaddow-light"
                               aria-label="Search" aria-describedby="">


                    </div>
                </form>

            </div>

            <div class="col-2 px-2 d-flex justify-content-around d-block d-sm-none">
                <!--<a href="##"  class="btn btn-circle btn-white shaddow-light" style="
position: relative;
border-radius: 50%;
overflow: hidden;">-->
                <a href="##" id="LanguageToggle" class="btn btn-circle btn-white shaddow-light" style="">
                    <i class="fa fa-language"></i>
                    <!--<img id="LanguageToggle" src="uploads/logo5.png" alt="" style="
                        width: 100%;
                        position: absolute;
                        top: 0;
                        left: 0;
                    ">-->
                </a>
            </div>
        </div>
    </div>
    <!-- End Mobile Top Nav -->
    <style>
        .flxe {
            position: fixed !important;
            top: 2%;
            left: 20%;
            width: 80%;
            z-index: 999;
        }
    </style>
    <script>
        //  	设置中英文切换
        $("#LanguageToggle").click(function () {
            if (window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1) {
                window.localStorage.setItem("lang", 2);
                location.reload()
            } else {
                window.localStorage.setItem("lang", 1);
                location.reload()
            }
        })
        //页面下拉，搜索窗口定位顶部
        //滚动监听
        $(window).scroll(function (event) {
            //获取滚动高度
            var top = $(window).scrollTop();
            //滑动大于100px，搜索框定位
            if (top > 100) {
                $("#seach").addClass("flxe")
            }
            //滑小雨100px，恢复
            if (top < 100) {
                $("#seach").removeClass("flxe")
            }

        });
    </script>


    <!-- Banner Container -->
    <div class="container position-relative">

        <div class="bg-curved bg-gradient"></div>

        <div class="d-flex flex-row scrolling-wrapper-flexbox rounded shaddow-dark bannerBox" style="overflow: hidden;">

            @for( $i = 0; $i < count($banner); $i++ )
                <div class="col-12 p-0 bannerNum">
                    <a href="{{$banner[$i]->url}}">
                        <img class="w-100 h-100" src="{{$banner[$i]->img->url}}" alt=""></a>
                </div>
            @endfor
        </div>
        <!-- End Banner Container-->

        <!--banner提示图标-->
        <div class=" row justify-content-center" id="bannerBtn">
        </div>

        <style type="text/css">
            #bannerBtn {
                margin-top: -10px;
                position: relative;
                z-index: 999;
            }

            #bannerBtn span {
                width: 7px;
                height: 7px;
                border: 1px solid white !important;
            }
        </style>
        <script type="text/javascript">
            $(".bannerNum").length
            for (let i = 0; i < $(".bannerNum").length; i++) {
                $("#bannerBtn").html($("#bannerBtn").html() + '<span class=" mx-1 rounded-50"></span>')
            }
            $("#bannerBtn span").eq(0).addClass("bg-color-1")
        </script>
        <!--banner提示图标 end-->

        <script>
            //banner轮播滑动事件
            $(function () {
                //当前显示图片
                var munBer = 1
                // 获取手指在轮播图元素上的一个滑动方向（左右）

                // 获取界面上轮播图容器
                var $carousels = $('.bannerBox');
                var startX, endX;
                // 在滑动的一定范围内，才切换图片
                var offset = 50;
                // 注册滑动事件
                $carousels.on('touchstart', function (e) {
                    // console.log(e);
                    // 手指触摸开始时记录一下手指所在的坐标x
                    startX = e.originalEvent.touches[0].clientX;

                });
                $carousels.on('touchmove', function (e) {
                    // 目的是：记录手指离开屏幕一瞬间的位置 ，用move事件重复赋值
                    endX = e.originalEvent.touches[0].clientX;
                });
                $carousels.on('touchend', function (e) {
                    //console.log(endX);
                    //结束触摸一瞬间记录手指最后所在坐标x的位置 endX
                    //比较endX与startX的大小，并获取每次运动的距离，当距离大于一定值时认为是有方向的变化
                    var distance = Math.abs(startX - endX);
                    if (distance > offset) {
                        //说明有方向的变化
                        //根据获得的方向 判断是上一张还是下一张出现
//              $(this).carousel(startX >endX ? 'next':'prev');
                        if ($('.bannerBox img').length > 1) {
                            if (startX > endX) {
                                if ($('.bannerBox img').length > munBer) {
                                    $('.bannerBox .col-12').eq(munBer - 1).animate({"margin-left": -$('.bannerBox .col-12').width()}, 500);
                                    $("#bannerBtn span").eq(munBer).addClass("bg-color-1");
                                    munBer++
                                }
                            } else {
                                if (munBer > 1) {
                                    $('.bannerBox .col-12').eq(munBer - 2).animate({"margin-left": "0"}, 500);
                                    $("#bannerBtn span").eq(munBer - 1).removeClass("bg-color-1");
                                    munBer--
                                }
                            }
                        }
                    }
                })
            });

        </script>

        <!-- Icon Nav Container -->
        <div class="container mt-3">
            <div class="d-flex flex-row justify-content-between">
                @for( $i = 0; $i < 5; $i++ )
                    <div>
                        <a href="/apps/category?id={{$i}}">
                            <button type="button" class="btn btn-lg btn-circle btn-white shaddow-dark"><i
                                        class="{{!empty($categorys[$i]['icon']) ? $categorys[$i]['icon'] : 'fa fa-user'}}"></i>
                            </button>
                        </a>
                        <small class="d-block py-2 " style="text-align: center;" >
                            <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{$categorys[$i]['zn_name']}} " : " {{$categorys[$i]['en_name']}} "); </script>
                        </small>
                    </div>
                @endfor
            </div>
        </div><!-- End Icon Nav Container -->


        <!-- 秒杀 Container -->
        <div class="container mb-2 pb-1">

            <div class="d-flex justify-content-between my-4">
                <div>
                    <h4 class="pl-2 title-border">
                        <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{$modular[0]['zn_name']}} " : " {{$modular[0]['en_name']}} "); </script>
                    </h4>
                </div>
                <div><a href="/apps/activielist/2" class="text-muted">
                        <script>Language("更多", "More")</script>
                        <i class="fa fa-angle-right"></i></a></div>
            </div>

            <div class="d-flex justify-content-between position-relative my-4">
                <!--<p class="text-dark">
                	Language("距离本场结束还有","There is still the end of the field")</p>-->
            </div>

            <!-- Row -->
            <div class="row justify-content-center">
                {{--@for( $i = 0; $i < count($modular[0]['products']); $i++ )--}}

                @if (!empty($modular[0]['products']))
                    @for( $i = 0; $i < (count($modular[0]['products']) < 4 ? count($modular[0]['products']) : 3 ); $i++ )

                        <div class="card shaddow-dark mb-2 mx-1 w-30 border-0">
                            <a href="/apps/product/{{$modular[0]['products'][$i]['id']}}"><img
                                        src="{{$modular[0]['products'][$i]['product_image']}}"
                                        class="img-fluid card-img-top rounded-top img-bg-{{$i+1}} mb-1" alt=""></a>
                            <div class="card-body p-1">
                                <!--<small class="mt-0 d-block text-dark stock_text"data-stock="{{$modular[0]['products'][$i]['stock']}}">-->
                                <small class="mt-0 d-block text-dark stock_text"data-stock="{{$modular[0]['products'][$i]['stock']}}">
                                    <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{$modular[0]['products'][$i]['zn_name']}} " : " {{$modular[0]['products'][$i]['en_name']}} "); </script>
                                </small>
                                <h6 class="card-title d-inline text-red">
                                    <script>
                                        Spricedetails({{$modular[0]['products'][$i]['distributor']['level_four_price']}},{{$modular[0]['products'][$i]['distributor']['level_two_price']}},{{$modular[0]['products'][$i]['distributor']['level_one_price']}},{{$modular[0]['products'][$i]['distributor']['level_three_price']}})
                                    </script>
                                    </h6>

                            </div>
                        </div>
                    @endfor

                @endif
            </div><!-- Row -->
        </div><!-- End 秒杀 container -->


        <!-- 热销 Container -->
        <div class="container mb-2 px-0">

            <div class="container">
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <h4 class="pl-2 title-border">
                            <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{$modular[1]['zn_name']}} " : " {{$modular[1]['en_name']}}  "); </script>
                        </h4>
                    </div>
                    <div><a href="/apps/activielist/1" class="text-muted">
                            <script>Language("更多", "More")</script>
                            <i class="fa fa-angle-right"></i></a></div>
                </div>
            </div>

            <!-- Flex container(scrolling wrapper) -->
            <div class="d-flex flex-row scrolling-wrapper-flexbox">

                @for( $i = 0; $i < count($modular[1]['products']); $i++ )
                    <div class="card bg-color-{{$i%3+1}} border-0 mb-2 mx-1 w-25 mw-25 mt-5">
                        <a href="/apps/product/{{$modular[1]['products'][$i]['id']}}"><img
                                    src="{{$modular[1]['products'][$i]['product_image']}}"
                                    class="img-fluid card-img-top rounded img-bg-{{$i+1}} mb-1 position-relative hot-sale-img shaddow"
                                    alt=""></a>
                        <div class="card-body hot-sale-card-body text-white text-center p-1">
                            <small class="mt-0 d-block">
                                <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{$modular[1]['products'][$i]['zn_name']}} " : " {{$modular[1]['products'][$i]['en_name']}} "); </script>
                            </small>
                            <h6 class="card-title mb-0">
                                    <script>
                                        Spricedetails({{$modular[1]['products'][$i]['distributor']['level_four_price']}},{{$modular[1]['products'][$i]['distributor']['level_two_price']}},{{$modular[1]['products'][$i]['distributor']['level_one_price']}},{{$modular[1]['products'][$i]['distributor']['level_three_price']}})
                                    </script>
                            </h6>

                        </div>
                    </div>
                @endfor

            </div><!-- Flex container(scrolling wrapper) -->
        </div><!-- End 热销 container -->

        <!-- 分类商品 Container -->

        {{--        {{$nums = (count($categorys) < 6 ? count($categorys) : 6)}}--}}
        @for( $i = 0; $i < (count($categorys) < 6 ? count($categorys) : 6); $i++ )
            <div class="container mb-2 pb-1">
                <div class="d-flex justify-content-between my-4">
                    <div>
                        <h4 class="pl-2 title-border">
                            <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? "{{$categorys[$i]['zn_name']}}" : "{{$categorys[$i]['en_name']}}"); </script>
                        </h4>
                    </div>
                    <div><a href="/apps/category?id={{$i}}" class="text-muted">
                            <script>Language("更多", "More")</script>
                            <i class="fa fa-angle-right"></i></a></div>
                </div>

                <!-- Row -->
                <!--<div class="row justify-content-center">-->
                <div class="row justify-content-start">
                    @if (!empty($categorys[$i]['pid']))
                        @php $j = 0;  @endphp

                        @foreach($categorys[$i]['pid'] as $key)
                            @foreach($key['product'] as $items)
                                @if ($j == 15)
                                    @php break; @endphp
                                @endif
                                <div class="card shaddow mb-2 mx-1 border-0 w-30">
                                    <a href="/apps/product/{{$items['id']}}"><img src="{{$items['product_image']}}"
                                                                                  class="img-fluid card-img-top rounded-top mb-1"
                                                                                  alt=""></a>
                                    <div class="card-body p-1">
                                        <small class="mt-0 d-block text-dark stock_text"data-stock="{{$items['stock']}}">
                                            <script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{$items['zn_name']}} " : " {{$items['en_name']}} "); </script>
                                        </small>
                                        <h6 class="card-title d-inline text-red">
                                    <script>
                                        Spricedetails({{$items['distributor']['level_four_price']}},{{$items['distributor']['level_two_price']}},{{$items['distributor']['level_one_price']}},{{$items['distributor']['level_three_price']}})
                                    </script>
                                            </h6>

                                    </div>
                                </div>
                                @php $j++; @endphp
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        @endfor

    <!-- Row -->
        <!-- End 分类商品 container -->

        <!-- 晒单 Container -->
        {{--<div class="container mb-2 px-0">--}}
        {{----}}
        {{--<div class="container">--}}
        {{--<div class="d-flex justify-content-between mt-4">--}}
        {{--<div><h4 class="pl-2 title-border">晒单</h4></div>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--<!-- Flex container(scrolling wrapper) -->--}}
        {{--<div class="d-flex flex-row scrolling-wrapper-flexbox">--}}

        {{--@for( $i = 0; $i < 6; $i++ )--}}
        {{--<div class="card text-muted my-2 mx-1 w-30">--}}
        {{--<a href=""><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1528363795671&di=73dc97030e6d76df68393bd53fc17401&imgtype=0&src=http%3A%2F%2Fc.hiphotos.baidu.com%2Fimage%2Fpic%2Fitem%2Fa044ad345982b2b7cac747293badcbef77099b86.jpg" class="img-fluid card-img-top rounded" alt=""></a>--}}
        {{-- <div class="card-footer">--}}
        {{--2 days ago--}}
        {{--</div> --}}
        {{--</div>--}}
        {{--@endfor--}}

        {{--</div><!-- Flex container(scrolling wrapper) -->--}}
        {{--</div><!-- End 晒单 container -->--}}
        @endsection

        @section('scripts')
            {{--<script type="text/javascript">--}}
            {{--$(document).ready(function () {--}}
            {{--$.ajax({--}}
            {{--url: 'http://buy.yn-pulse.com/api/home/page',--}}
            {{--method: 'get',--}}
            {{--async: false,--}}
            {{--dataType: "jsonp",--}}
            {{--jsonp: "callbackparam",--}}
            {{--crossDomain: true, //是否跨域:是--}}
            {{--cache: false, //是否缓存：否--}}
            {{--jsonpCallback: "my",--}}
            {{--success: function (json) {--}}
            {{--console.log(json.data.items[3].products)--}}
            {{--if (json.status) {--}}

            {{--}--}}
            {{--}--}}
            {{--})--}}
            {{--});--}}
            {{--function joinShopCart(item) {--}}
            {{--console.log(item.zn_name)--}}
            {{--}--}}
            {{--</script>--}}
            <script>
                //底部导航显示当前所在页面样式
                $("#mobile-nav a").eq(0).css({"background": "#fdb3d3", "color": "#ffffff"});
                //解决样式bug
                $(document).ready(function () {

                })
            </script>

@endsection