@extends('/app/layouts.app')

@section('content')

    <div class="container amount-input py-2 fixed-top">
        <div class="d-flex justify-content-between align-items-center text-mute">
            <a href="javascript:history.back(-1);" class="top-nav-item"><i class="fa fa-angle-left"></i></a>

            <!--<a href="" class="top-nav-item"><i class="fa fa-share-alt"></i></a>-->
        </div>
    </div>

    <!-- Banner Container -->
    <div class="container scrolling-wrapper-flexbox p-0 bannerBox" style="overflow: hidden;">

        @for( $i = 0; $i < count($product->image); $i++ )
            <div class="col-12 p-0">
                <img class="w-100 {{$i}} " src="{{$product->image[$i]->link}}" alt="">
            </div>
        @endfor
    </div><!-- End Banner Container-->

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
                                $('.bannerBox .col-12').eq(munBer - 1).animate({"margin-left": -$(window).width()}, 500);
                                munBer++
                            }
                        } else {
                            if (munBer > 1) {
                                $('.bannerBox .col-12').eq(munBer - 2).animate({"margin-left": "0"}, 500);
                                munBer--
                            }
                        }
                    }
                }
            })
        });

    </script>

    <div class="container py-3">
        <span class="d-inline stock_text"data-stock="{{$product->stock}}">
                	<script type="text/javascript">
                	Language("{{$product->zn_name}}","{{$product->en_name}}")
                </script></span>
    </div>

    <div class="container py-2 bg-light">
        <span class="d-inline">
                	<script type="text/javascript">
                	Language("价格","Price")
                </script></span>
        <h5 class="d-inline pl-2 text-red">
        
        <script>
            Spricedetails({{$product['distributor']['level_four_price']}},{{$product['distributor']['level_two_price']}},{{$product['distributor']['level_one_price']}},{{$product['distributor']['level_three_price']}})
        </script>
        </h5>
    </div>
    <div class="container">
        <div class="d-flex justify-content-between mt-4">
            <div><h6 class="pl-2 title-border text-secondary">
                	<script type="text/javascript">
                	Language("商品评论","Product Reviews")
                </script><span class="text-red">({{count($product['message'])}}
                        )</span></h6></div>
            <div><a href="/apps/products/comments/{{$product->id}}" class="card-link text-red">
                	<script type="text/javascript">
                	Language("更多","More")
                </script> <i
                            class="fa fa-angle-right"></i></a></div>
        </div>
    </div>

    <!-- 分类 Container -->
    <div class="container mb-2 border-bottom px-0">

        <div class="container border-top">
            <div class="d-flex justify-content-between mt-4">
                <div><h6 class="pl-2 title-border text-secondary">
                	<script type="text/javascript">
                	Language("分类"," Categories")
                </script></h6></div>
            </div>
        </div>

        <div class="container py-3">
            <!-- <a href="/apps/product/"> -->
            {{--<a href="/apps/category/categorylist/{{$product->category->id}}">--}}
            {{--<button type="button" class="btn btn-sm btn-light m-2">{{$product->category->zn_name}}</button>--}}
            {{--</a>--}}
            @if (!empty($product->category))
                <a href="/apps/category/categorylist/{{$product->category->id}}">
                    <button type="button" class="btn btn-sm btn-light m-2">
                	<script type="text/javascript">
                	Language("{{ $product->category->zn_name }}","{{ $product->category->en_name }}")
                </script></button>
                </a>
            @else
                <small class="text-muted">
                	<script type="text/javascript">
                	Language("暂未归属任何分类"," No Categories Matched")
                </script></small>
            @endif
            {{--@foreach($product->products as $items)--}}
            {{--<a href="/apps/activielist/{{$items->id}}">--}}
            {{--<button type="button" class="btn btn-sm btn-light m-2">{{$items->zn_name}}</button>--}}
            {{--</a>--}}
            {{--@endforeach--}}

        </div>

    </div><!-- End 分类 container -->



    <!-- 分类 Container -->
    <div class="container mb-2 border-bottom px-0">

        <div class="container">
            <div class="d-flex justify-content-between mt-4">
                <div><h6 class="pl-2 title-border text-secondary">
                	<script type="text/javascript">
                	Language("品牌","Brand")
                </script></h6></div>
            </div>
        </div>

        <div class="container py-3">
            @if (!empty($product->brand))
                <a href="/apps/brand/brandlist/{{$product->brand->id}}">
                    <button type="button" class="btn btn-sm btn-light m-2">
                	<script type="text/javascript">
                	Language("{{ $product->brand->zn_name }}","{{ $product->brand->en_name }}")
                </script></button>
                </a>
            @else
                <small class="text-muted">
                	<script type="text/javascript">
                	Language("暂未归属任何品牌","No Brand Matched")
                </script></small>
            @endif
            {{--@for($i=0;$i<10;$i++)--}}
            {{--<button type="button" class="btn btn-sm btn-light m-2">分类</button>--}}
            {{--@endfor--}}
        </div>

    </div><!-- End 分类 container -->

    <div class="container mb-2 border-bottom px-0">

        <div class="container">
            <div class="d-flex justify-content-between mt-4">
                <div><h6 class="pl-2 title-border text-secondary">
                	<script type="text/javascript">
                	Language("活动","Special Deals")
                </script></h6></div>
            </div>
        </div>

        <div class="container py-3">
            @if (!empty($product->products->toArray()))
                @foreach($product->products as $items)
                    <a href="/apps/activielist/{{$items->id}}">
                        <button type="button" class="btn btn-sm btn-light m-2">
                	<script type="text/javascript">
                	Language("{{$items->zn_name}}","{{$items->en_name}}")
                </script></button>
                    </a>
                @endforeach
            @else
                <small class="text-muted">
                	<script type="text/javascript">
                	Language("暂未归属任何活动","No Special Deals Matched")
                </script></small>
            @endif
        </div>

    </div><!-- End 分类 container -->


    <!-- 商品详情 Container -->
    <div class="container mb-2 border-bottom px-0">


        <div class="container">
            <div class="d-flex justify-content-between mt-4">
                <div><h6 class="pl-2 title-border text-secondary">
                	<script type="text/javascript">
                	Language("商品详情"," Product Description ")
                </script></h6></div>
            </div>
        </div>

        <div class="container">
            {{--<h1>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit quo aliquam fuga laborum blanditiis tempora dolore sunt nemo reprehenderit cumque, mollitia delectus accusamus, qui ea iure nobis voluptate quod, adipisci!</h1>--}}
            <small class="text-muted" id="code">
                <script type="text/javascript">
                    $('#code').html(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? '{!! $product->zn_describe !!}' : '{!! $product->en_describe !!}');
                </script>
            </small>

        </div>

    </div><!-- End 商品详情 container -->

    <!-- 购物按钮 Container -->
    <div class="container bg-white fixed-bottom CTA-container py-2" id="cart_btn">
        <div class="row">
            <!--收藏按钮-->
            <!-- <div class="col-2">
                <a href="##" class="text-muted btn Collection"><i class=" ">收藏</i></a>
            </div> -->
            <div class="col-12">
                <button id="add" type="button" class="btn btn-block btn-red btn-collection"
                        product_image="{{$product->product_image}}"
                        zn_name="{{$product->zn_name}}"
                        price="{{$product->distributor->level_four_price}}"
                        onclick=""
                        shop_id="{{$product->id}}"
                ><i class="fa fa-shopping-cart"> 
                	<script type="text/javascript">
                	Language("加入购物车","Add to Cart")
                </script></i></button>

            </div>
            {{--<div class="col-6">--}}
            {{--<button id="buy-now-btn" type="button" class="btn btn-block btn-red"><i class="fa fa-credit-card"> 立即购买</i></button>--}}
            {{--</div>--}}
        </div>

    </div><!-- End 购物按钮 Container -->
    <!-- 模态框 -->
    <!-- <div class="modal fade" id="myModal">
        <div class="modal-dialog" style="z-index:99;">
            <div class="modal-content"> -->

    <!-- 模态框头部 -->
    <!-- <div class="modal-header">
        <h4 class="modal-title">模态框头部</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div> -->

    <!-- 模态框主体 -->
    <!-- <div class="modal-body">
        模态框内容..
    </div> -->

    <!-- 模态框底部 -->
    <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
    </div>

    </div>
</div>
</div> -->
    <!-- 模态框 -->

    <div class="modal fade bs-example-modal-sm " id="showx" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content " id="show_text" style="padding: 2% 5% 10% 5%; ">
                <!-- 数量 container -->
                <div class="container py-3">
                    <div class="row py-1">
                        <div class="col-6 align-middle">
                            <span class="pl-2 text-secondary align-middle">
                	<script type="text/javascript">
                	Language("数量","Quantities")
                </script></span>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <div id="minus-btn" class="input-group-prepend">
                                    <button class="btn btn-sm btn-light border"><i class="fa fa-minus"></i></button>
                                </div>
                                <input id="amount-input" type="text" class="form-control text-center" value="1">
                                <div id="plus-btn" class="input-group-append">
                                    <button class="btn btn-sm btn-light border"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="container py-3">
                        <span class="d-inline">
                	<script type="text/javascript">
                	Language("库存：","In Stock:")
                </script><span>{{$product->stock}}</span></span>
                        {{--<span class="d-inline">--}}
                	{{--<script type="text/javascript">--}}
                	{{--Language("箱规：","Box gauge:")--}}
                {{--</script><span>{{$product->number}}{{$product->zn_number}}</span></span>--}}
                    </div>
                        <div class="container py-3">
                                  <span class="d-inline">
                	<script type="text/javascript">
                	 Language("箱规：{{$product->number}}{{$product->zn_number}}", "Box gauge：{{$product->number}}{{$product->en_number}}")</script>
                {{--</script><span>{{$product->number}}{{$product->zn_number}}</span></span>--}}
                        </div>
                </div>
                <div class="row">

                    <div class="col-12 py-2">
                        <button id="add-to-cart-btn" type="button" class="btn btn-block btn-red btn-collection py-2"
                                product_image="{{$product->product_image}}"
                                zn_name="{{$product->zn_name}}"
                                en_name="{{$product->en_name}}"
                                price="{{$product->distributor->level_four_price}}"
                                onclick="addShopCart(this) "
                                shop_id="{{$product->id}}"
                                stock="{{$product->stock}}"
                        ><i class="fa fa-shopping-cart"> 
                	<script type="text/javascript">
                	Language("确认加入购物车","Confirm Add to Cart")
                </script></i></button>

                    </div>
                </div>
            </div><!-- End 数量 container -->
        </div>
    </div>
    </div>
    <div id="pp" style="display: none;"></div>

    <script>
        $("#add").click(function () {
            $("#showx").modal('show');
        })
        $("#add-to-cart-btn").click(function () {
            $("#showx").modal('hide');
        })
    </script>
@endsection
<style>
    /* 模态框样式修改 */
    .app .modal-dialog {
        position: absolute;
        width: auto;
        margin: .5rem;
        pointer-events: none;
        bottom: 0;
    }
</style>


@section('scripts')
    <!-- 隐藏nav -->
    <script type="text/javascript">
        $(document).ready(function () {
//          $('#mobile-nav').hide();
//      判断有没有登录来显示加入购物车按钮的高度
            $("#cart_btn").css("bottom", $("#mobile-nav").height() + $("#cart_btn").height() / 2 + "px")

        });

        $(window).scroll(function () {
            var height = $(window).scrollTop();

            if (height = 200) {
                $('#top-nav-box').toggleClass('bg-white')
            }
        });

    </script>


    <script type="text/javascript">

        $('#buy-now-btn').on('click', buyNow);
        $('#minus-btn').on('click', minusAmount);
        $('#plus-btn').on('click', plusAmount);
        $('#amount-input').on('keypress keyup blur', amountCorrection);


        function buyNow() {
            swal({
                title: LanguageHtml('立即购买',"Check Out"),
                type: 'success',
                showConfirmButton: false,
                timer: 1000
            })
        }

        function minusAmount() {
            if ($('#amount-input').val() > 1) {
                $('#amount-input').val(Number($('#amount-input').val()) - 1);
                cartNumber()
            }
        }

        function plusAmount() {
            $('#amount-input').val(Number($('#amount-input').val()) + 1);
            cartNumber()
        }

        function amountCorrection() {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }

            // if ($(this).val() == "") {
            //     $(this).val(0);
            // }
            cartNumber()
        }
        //购物车数量
        function cartNumber() {
            $('#add-to-cart-btn').attr("product_number", $('#amount-input').val());
        };
        cartNumber();

        function addShopCart(item) {

            var id = {{ !empty(Auth::guard("pc")->user()) ? Auth::guard("pc")->user()->id : '-1'}};

            if (id == -1) {

                swal({
                    title: LanguageHtml('请先登录!',"Please Log In!"),
                    type: 'warning',
                    showConfirmButton: true
                });
                return;
            }
			if(item.attributes["stock"].value<=0){
	            swal({
	                title: LanguageHtml('商品库存不足!',"Sold Out!"),
	                type: 'info',
	                showConfirmButton: true,
	            })
	            return false;
			}
            var project = {
                zn_name: item.attributes["zn_name"].value,
                en_name: item.attributes["en_name"].value,
                price: item.attributes["price"].value,
                shop_id: item.attributes["shop_id"].value,
                image: item.attributes["product_image"].value,
                number: item.attributes["product_number"] ? item.attributes["product_number"].value : 1,
            }
            var cart = JSON.parse(localStorage.getItem("shopcart"));
            if (cart) {
                for (let i = 0; i < cart.length; i++) {
                    if (cart[i].shop_id == item.attributes["shop_id"].value) {
//        console.log(cart[i].shop_id);
//        console.log(item.attributes["shop_id"].value);
                        cart[i].number = item.attributes["product_number"].value * 1 + cart[i].number * 1;
                        localStorage.setItem("shopcart", JSON.stringify(cart));
                        swal({
                            title:  LanguageHtml('添加商品成功!',"Added to Cart"),
                            type: 'success',
                            showConfirmButton: true
                        })
                			CartNumber();
                        return;
                    }
                }
                cart.push(project);
                localStorage.removeItem("shopcart");
                localStorage.setItem("shopcart", JSON.stringify(cart));
                swal({
                    title:  LanguageHtml('添加商品成功!',"Added to Cart"),
                    type: 'success',
                    showConfirmButton: true
                })
                CartNumber();
            } else {
                cart = [];
                cart.push(project);
                localStorage.setItem("shopcart", JSON.stringify(cart));
                swal({
                    title:  LanguageHtml('添加商品成功!',"Added to Cart"),
                    type: 'success',
                    showConfirmButton: true
                })
                CartNumber();
            }
        }
        //end购物车数量

    </script>
    <script>

        var Collection = JSON.parse(localStorage.getItem("collection"));
        var That = 0;
        var collText = {
            zn_name: $(".btn-collection").eq(That).attr("zn_name"),
            price: $(".btn-collection").eq(That).attr("price"),
            shop_id: $(".btn-collection").eq(That).attr("shop_id"),
            image: $(".btn-collection").eq(That).attr("product_image")
        }

        if (Collection) {
            var d = -1;
            for (let i = 0; i < Collection.length; i++) {
                if (Collection[i].shop_id == collText.shop_id) {
                    d = i
                }
            }
            ;
            if (d > -1) {
                Collection.splice(d, 1);
                Collection.push(collText);
            } else {
                Collection.push(collText);

            }
        } else {
            Collection = [];
            Collection.push(collText);

        }
        ;
        if (Collection.length > 20) {
            Collection.shift();
        }
        localStorage.setItem("collection", JSON.stringify(Collection));
    </script>


@endsection
