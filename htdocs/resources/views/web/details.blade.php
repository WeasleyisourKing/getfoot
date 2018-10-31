@extends('web/layout.app')

@section('content')

    @include('web/layout.category')

    <!--中间体-->
    <div class="maxCentr clearfloat ">
        <div class="con-FangDa detailsImg" id="fangdajing">
            <div class="con-fangDaIMg">
                <!-- 正常显示的图片-->

                <img src="{{$product->product_image}}">
                <!-- 滑块-->
                <div class="magnifyingBegin"></div>
                <!-- 放大镜显示的图片 -->
                <div class="magnifyingShow">
                    <img src="{{$product->product_image}}">
                </div>
            </div>

            <ul class="con-FangDa-ImgList">
                <!-- 图片显示列表 -->
                @foreach($product->image as $val)
                    <li class="active border-1">
                        <img src="{{$val['link']}}" data-bigimg="{{$val['link']}}">
                    </li>
            @endforeach
        </div>

        <div class="detailsBox">
            <p class="title">
                <script>
                    Language("{{$product->zn_name}}", "{{$product->en_name}}")
                </script>
            </p>
            <div class="detailsAll clearfloat">
                <p class="float_left">
                    <script>
                        Language("价格", "Price")
                    </script>
                    <span>
                        @if(!empty(Auth::guard("pc")->user()))
                            <script>
                                Spricedetails({{$product->distributor->level_four_price}},{{$product->distributor->level_two_price}},{{$product->distributor->level_one_price}},{{$product->distributor->level_three_price}});
                            </script>
                        @endif
                    </span></p>
                <div class="float_right">
                    <script>
                        Language("品牌：", "Brand:")
                    </script>
                                                        <script>
                                                            Language("{{!empty($product->brand) ? $product->brand->zn_name : '暂未归属任何品牌'}}","{{!empty($product->brand) ? $product->brand->en_name : 'No Brand Matched '}}")
                                                        </script></div>
            </div>
            <div class="detailsClass clearfloat">
                <div class="float_left">
                    <script>
                        Language(" 产品分类：", "Categories:")
                    </script>
                </div>
                <ul class="float_left">
                    <li>
                <script>
                    Language("{{!empty($product->category) ? $product->category->zn_name : '暂未归属任何分类'}}", "{{!empty($product->category) ? $product->category->en_name : ' No Category Matched '}}")
                </script></li>
                </ul>
            </div>
            <div class="detailsNumber clearfloat ">
                <p class="float_left">
                    <script>
                        Language("数量", "Quantities")
                    </script>
                </p>
                <button class="float_left "id="increase">＋</button>
                <input type="text" id="prdoctNumbers" value="1" class="float_left productNumber" style=" width: 50px;text-align: center;line-height: 29px;">
                <button class="float_left"id=" reduce">－</button>
                <div class="float_left">&nbsp;
                    <script>
                        Language("（库存{{$product->stock}}{{$product->zn_number}}）", "（In Stock{{$product->stock}}{{$product->en_number}}）")
                    </script>
                </div>
            </div>
            <div class="detailsClassBut">
                {{--<button>立即购买</button>--}}

                <script>
                    Language(`<button id="addCart" class="shopAdd" data-number="1" datas-tock="{{$product->stock}}" data-zn-name="{{$product->zn_name}}"data-en-name="{{$product->en_name}}" data-price="@if(!empty(Auth::guard("pc")->user()))${Sprice1({{$product->distributor->level_four_price}},{{$product->distributor->level_two_price}},{{$product->distributor->level_one_price}},{{$product->distributor->level_three_price}})}@endif" data-img="{{$product->product_image}}" data-id="{{$product->id}}" style="background: #f14067;"><img src="/home/img/nav-1.png" alt=""/>&nbsp;加入购物车</button>`,
                        `<button id="addCart" class="shopAdd"  data-number="1" datas-tock="{{$product->stock}}" data-zn-name="{{$product->zn_name}}"data-en-name="{{$product->en_name}}" data-price="@if(!empty(Auth::guard("pc")->user()))${Sprice1({{$product->distributor->level_four_price}},{{$product->distributor->level_two_price}},{{$product->distributor->level_one_price}},{{$product->distributor->level_three_price}})}@endif" data-img="{{$product->product_image}}" data-id="{{$product->id}}" style="background: #f14067;"><img src="/home/img/nav-1.png" alt=""/>&nbsp;Check Out </button>`)
                </script>
            </div>
            {{--<div class="detailsIco">--}}
            {{--<ul class="clearfloat">--}}
            {{--<li >--}}
            {{--<img src="/home/img/1111.png" alt="" />--}}
            {{--<img src="/home/img/1112.png" alt="" />--}}
            {{--</li>--}}
            {{--<li >--}}
            {{--<img src="/home/img/2221.png" alt="" />--}}
            {{--<img src="/home/img/221.png" alt="" />--}}
            {{--</li>--}}
            {{--<li >--}}
            {{--<img src="/home/img/3331.png" alt="" />--}}
            {{--<img src="/home/img/331.png" alt="" />--}}
            {{--</li>--}}
            {{--<li >--}}
            {{--<img src="/home/img/4441.png" alt="" />--}}
            {{--<img src="/home/img/441.png" alt="" />--}}
            {{--</li>--}}
            {{--<li>--}}
            {{--<img src="/home/img/5551.png" alt="" />--}}
            {{--<img src="/home/img/551.png" alt="" />--}}
            {{--</li>--}}
            {{--<li >--}}
            {{--<img src="/home/img/6661.png" alt="" />--}}
            {{--<img src="/home/img/661.png" alt="" />--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="maxCentr clearfloat detailsBtnBox">
        <div class="am-u-sm-3 detailsBtn">
            <div class="detailsHot">
                <script>
                    Language("{{$relevant->zn_name}} ", "{{$relevant->en_name}}")
                </script>
            </div>
            <ul>
                @if(!empty($theme))
                    @foreach($theme as $items)
                        <li>
                            <a href="/details/{{$items->id}}">
                            		<img src="{{$items->product_image}}" alt=""/>
                            </a>
                            <div class="clearfloat">
                                <p class="oneLine">
                                    <script>
                                        Language("{{$items->zn_name}}","{{$items->en_name}}")
                                    </script>
                                </p>
                                <!--<span>${{$items->distributor->level_four_price}}</span>-->
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="am-u-sm-9 details">
            <div data-am-widget="tabs" class="am-tabs am-tabs-d2">
                <ul class="am-tabs-nav am-cf">
                    <li class="am-active"><a href="[data-tab-panel-0]">
                            <script>
                                Language("商品描述", "Product Description")
                            </script>
                        </a></li>
                    <!--<li class="" id="commentList"><a href="[data-tab-panel-1]">
                            <script>
                                Language("商品评论", "Reviews")
                            </script>
                            <span>(0)</span></a></li>-->
                </ul>

                <div class="am-tabs-bd">
                    <div data-tab-panel-0 class="am-tab-panel am-active">
                        <div class="detailsText">
                            <ul class="clearfloat">
                                <li class="float_left">
                                    <p>
                                        <script>
                                            Language("净含量: {{$product->category->zn_name}}", "Net weight: {{$product->category->en_name}}")
                                        </script>
                                    </p>
                                    <!--<p>
                                        <script>
                                            Language("保质期（天）", "Shelf life (days)")
                                        </script>
                                        : {{$product->term}}</p>
                                    <p>
                                        <script>
                                            Language("重量单位: {{$product->zn_weight}}", "Weight unit: {{$product->en_weight}}")
                                        </script>
                                    </p>-->
                                    <p>
                                        <script>
                                            Language("品牌:{{!empty($product->brand) ? $product->brand->zn_name : '暂未归属任何品牌'}}", "Brand:{{!empty($product->brand) ? $product->brand->en_name : 'Not yet owned by any brand'}}")
                                        </script>
                                    </p>
                                    <p>
                                        <script>
                                            Language("分类:{{!empty($product->category) ? $product->category->zn_name : '暂未归属任何分类'}}", "Classification:{{!empty($product->category) ? $product->category->en_name : 'Not yet owned by any brand'}}")
                                        </script>
                                    </p>
                                </li>

                            </ul>
                            {{--<div class="Date">--}}
                                {{--<h6 style="color: #eaeaea;">1221<h6>--}}
                            {{--</div>--}}
                            {{--<img src="/home/img/20180413140707.png" alt=""/>--}}
                            <div class="detailsTextImg">
                                <div class="detailsTextImgTitle">
                                    <script>
                                        Language("商品展示", "Product showcase")
                                    </script>
                                </div>
                                {!! $product->zn_describe !!}
                            </div>
                            <div class="detailsTs clearfloat">
                                <div class="detailsTsTitle">
                                    <script>
                                        Language("{{$hot->zn_name}}", "{{$hot->en_name}}")
                                    </script>
                                </div>

                                @if(!empty($hot))
                                    @foreach($hot->products as $items)
                                        <div class="am-u-sm-3 " style="padding: -5px;height: 277px;overflow: hidden;border: 1px solid #EEEEEE; margin-top: 20px;">
                                        	
                                        	<a href="/details/{{$items->id}}">
                                            <img style="width: 90%;" src="{{$items->product_image}}" alt=""/>
                                        	</a>
                                            <ul class="clearfloat">
                                                <li class="title clearfloat">
                                                    <p class="float_left">
                                                        <script>
                                                            Language("{{$items->brand->zn_name}}","{{$items->brand->en_name}}")
                                                        </script>
                                                    </p>
                                                    <!--<span class="float_right">${{$items->distributor->level_four_price}}</span>-->
                                                </li>
                                                <li class="clearfloat">
                                                    <p class="float_left oneLine">
                                                        <script>
                                                            Language("{{$items->zn_name}}","{{$items->en_name}}")
                                                        </script></p>
                                                </li>
                                            </ul>
                                        </div>
                                    @endforeach
                                @endif
                                {{--<div class="am-u-sm-4">--}}
                                {{--<img src="/home/img/r11.png" alt=""/>--}}
                                {{--<ul class="clearfloat">--}}
                                {{--<li class="title clearfloat">--}}
                                {{--<p class="float_left">星巴克</p>--}}
                                {{--<img class="float_right" src="img/ffffff.png" alt=""/>--}}
                                {{--<img class="float_right" src="img/hhh.png" alt=""/>--}}
                                {{--</li>--}}
                                {{--<li class="clearfloat">--}}
                                {{--<p class="float_left">新款原味气泡水</p>--}}
                                {{--<span class="float_right">$99.99</span>--}}
                                {{--</li>--}}
                                {{--</ul>--}}
                                {{--</div>--}}
                                {{--<div class="am-u-sm-4">--}}
                                {{--<img src="/home/img/r12.png" alt=""/>--}}
                                {{--<ul class="clearfloat">--}}
                                {{--<li class="title clearfloat">--}}
                                {{--<p class="float_left">星巴克</p>--}}
                                {{--<img class="float_right" src="img/ffffff.png" alt=""/>--}}
                                {{--<img class="float_right" src="img/hhh.png" alt=""/>--}}
                                {{--</li>--}}
                                {{--<li class="clearfloat">--}}
                                {{--<p class="float_left">新款原味气泡水</p>--}}
                                {{--<span class="float_right">$99.99</span>--}}
                                {{--</li>--}}
                                {{--</ul>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                    <!--评论-->
                    {{--<div data-tab-panel-1 class="am-tab-panel commentListBox">
                        <div class="commentListPro">
                            <div class="am-g clearfloat">
                                <div class="am-u-sm-2 ">
                                    <div class="commentListProImg">
                                        <img src="" alt=""/>
                                    </div>
                                </div>
                                <div class="am-u-sm-2">
                                    <p>name</p>
                                </div>
                                <div class="am-u-sm-3">
                                    <p level="3" class="level">
                                        <span>★</span>
                                        <span>★</span>
                                        <span>★</span>
                                        <span>★</span>
                                        <span>★</span>
                                    </p>
                                </div>
                                <div class="am-u-sm-3">
                                    <p class="time">2018-07-18 19:22:00</p>
                                </div>
                            </div>
                            <div class="am-g clearfloat">
                                <div class="am-u-sm-9">
                                    <p>大煞风景是你粉丝点击阿斯顿那就是你打就能收到阿森纳点击阿斯顿啊</p>
                                </div>
                                <div class="am-u-sm-3">
                                    <button type="button" class="am-btn am-btn-danger btn-loading-example">评论</button>
                                </div>
                            </div>
                            <!--次级评论-->
                            <div class="am-g clearfloat commentList">
                                <div class="am-u-sm-2">
                                    <div class="commentListProImg">
                                        <img src="" alt=""/>
                                    </div>
                                </div>
                                <div class="am-u-sm-10">
                                    <p>name</p>
                                </div>
                                <div class="am-u-sm-12">
                                    <p>大煞风景是你粉丝点击阿斯顿那就是你打就能收到阿森纳点击阿斯顿啊</p>
                                </div>

                            </div>
                            <!--end次级评论-->
                        </div>
                    </div>--}}
                    <!--end评论-->
                </div>
            </div>
        </div>
    </div>
    <script>
        //浏览历史存本地
        var Collection = JSON.parse(localStorage.getItem("collection"));
        var That = 0;
        var collText = {
            zn_name: "{{$product->zn_name}}",
            en_name: "{{$product->en_name}}",
            price: "{{$product->distributor->level_four_price}}",
            shopid: "{{$product->id}}",
            image: "{{$product->product_image}}"
        }
        if (Collection) {
            var d = -1;
            for (let i = 0; i < Collection.length; i++) {
                if (Collection[i].shopid == collText.shopid) {
                    d = i
                }
            }
            ;
            if (d > -1) {
                Collection.splice(d, 1);
                Collection.unshift(collText);
            } else {
                Collection.unshift(collText);

            }
        } else {
            Collection = [];
            Collection.unshift(collText);

        }
        ;
        if (Collection.length > 20) {
            Collection.pop();
        }
        localStorage.setItem("collection", JSON.stringify(Collection));
        $("#commentList").click(function () {

        })
        //加载评论
        var Http = window.location.href;
        Http = Http.split("details/");
        console.log(Http[1]);
        $.post('/api/shop/message',
            {
                'id': Http[1]
            },
            function (data) {
                console.log(data)
                if (data.data.length == 0) {
                    $(".commentListBox").html(LanguageHtml("该商品还没有评论","No Reviews for This Product"));
                    return
                }
                ;
                console.log(data.data.length)
                var commentTextPro = "";
                for (var i = 0; i < data.data.length; i++) {
                    var commentTextProList = ""
                    for (var e = 0; e < data.data[i].reply.length; e++) {
                        commentTextProList += `
				 			<div class="am-g clearfloat commentList">
	                    		<div class="am-u-sm-2">
	                    			<div class="commentListProImg">
	                    				<img class="businessLogo" src="" alt="" />
	                    			</div>
	                    		</div>
	                    		<div class="am-u-sm-10">
	                    			<p>${data.data[i].reply[e].name}</p>
	                    		</div>
	                    		<div class="am-u-sm-12">
	                    			<p  class="commentText">${data.data[i].reply[e].content}</p>
	                    		</div>
	                    		
	                    	</div>`;
                    }
                    commentTextPro += `
					                    	<div class="commentListPro">
						                    	<div class="am-g clearfloat">
						                    		<div class="am-u-sm-2 ">
						                    			<div class="commentListProImg">
						                    				<img src="${data.data[i].users.avatar}" alt="" />
						                    			</div>
						                    		</div>
						                    		<div class="am-u-sm-2">
						                    			<p>${data.data[i].users.name}</p>
						                    		</div>
						                    		<div class="am-u-sm-3">
						                    			<p level="${data.data[i].score}" class="level" >
							                    			<span>★</span>
							                    			<span>★</span>
							                    			<span>★</span>
							                    			<span>★</span>
							                    			<span>★</span>
						                    			</p>
						                    		</div>
						                    		<div class="am-u-sm-3">
						                    			<p class="time">${data.data[i].created_at}</p>
						                    		</div>
						                    	</div>
						                    	<div class="am-g clearfloat">
						                    		<div class="am-u-sm-9">
						                    			<p class="commentText">${data.data[i].content}</p>
						                    		</div>
						                    		<div class="am-u-sm-3">
						                    			<button type="button" class="am-btn am-btn-danger btn-loading-example">${LanguageHtml("查看回复","View Replies")}</button>
						                    		</div>
						                    	</div>
						                    	 <!--次级评论-->
                        ${commentTextProList}
                        <!--end次级评论-->
                        </div>`

                                ;
                                                     };
                                                     $(".commentListBox ").html(commentTextPro);
                                                    //隐藏次级评论
                                                    $(".commentList").hide();

                                                    //点击按钮切换次级评论状态
                                                    $(".commentListPro button").click(function(){
                                                        var That = $(".commentListPro button").index(this);
                                                        console.log(That);
                                                        console.log($(".commentListPro").eq(That).children(".commentList").is(':hidden'));
                                                        console.log($(".commentListPro").eq(That).children(".commentList"));
                                                        if($(".commentListPro").eq(That).children(".commentList").eq(0).is(':hidden')){
                                                            $(".commentListPro").eq(That).children(".commentList").fadeIn();
                                                        }else{
                                                            $(".commentListPro").eq(That).children(".commentList").fadeOut();
                                                        }
                                                    });
                                                    //显示评论星级
                                                    for(var i=0; i<$(".level").length;i++){
                                                        console.log($(".level").eq(i).attr("level"))
                                                        for(var e=0;e<$(".level").eq(i).attr("level");e++){
                                                            $(".level ").eq(i).find("span").eq(e).css("color","red")
                                                        }
                                                    };
                                                    //获取商家评论头像
                                                      $.ajax({
                                                                url:'/api/home/login',
                                                                method: 'get',
                                                                success: function(logo){
                                                                    $('.businessLogo').attr('src',"/"+logo.data.logo);

                                                                }
                                                            });

                                                },"json")

</script>
<script>	
    //商品详情页加减按钮
    $("#increase").click(function () {
        var number = $("#prdoctNumbers").attr("value")
        $("#prdoctNumbers").attr("value",parseInt(number) + 1)
        $("#addCart").attr("data-number",parseInt(number) + 1)
    });
    $("#prdoctNumbers").change(function(){
        $("#prdoctNumbers").attr("value",$(this).val())
        $("#addCart").attr(	"data-number",$(this).val())
    })
    $("#reduce").click(function () {
        var number = $("#prdoctNumbers").attr("value")
        if (parseInt(number) == 1) {
        } else {
            $("#prdoctNumbers").attr("value",parseInt(number) - 1)
        $("#addCart").attr("data-number",parseInt(number) - 1)
        }
    });
//
//$.ajax({
//          url:'https://api.zip-tax.com/request/v40',
//          method: 'get',
//          data:{
//          		key:"9xQ6b4ORtV5IXdGi",
//          		postalcode:"90804"
//          },
//          success: function(tax){
//          		console.log(tax)
//          		console.log(111)
//
//          }
//      });
</script>
@endsection
