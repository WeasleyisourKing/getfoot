@extends('web/layout.app')

@section('content')

    {{--@include('web/layout.category')--}}


    <div class="ProBannerBox">
        <img src="/home/img/ProBanner.png" alt=""/>
        <div class=""></div>
    </div>
    <div class="qualityBox " style="background: #FFFFFF;">
        <div class="maxCentr clearfloat">
            <div class="qualityTitle">                                                             
            	<script>
								Language("搜索结果","Search Results")
							</script>
            </div>
            {{--<div class="am-u-sm-6">--}}
                {{--<img class="qualityPro" src="/home/img/quality01.png" alt=""/>--}}
                {{--<ul class="qualityText clearfloat" style="padding-top: 2%;">--}}
                    {{--<li class="qualityLeft"><p>星巴克</p></li>--}}
                    {{--<li class="qualityRight title"><img src="/home/img/ffffff.png" alt=""/><img src="/home/img/hhh.png" alt=""/>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<ul class="qualityText clearfloat">--}}
                    {{--<li class="qualityLeft"><p>新款原味气泡水</p></li>--}}
                    {{--<li class="qualityRight"><span>$99.99</span></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-6">--}}
                {{--<img class="qualityPro" src="/home/img/quality02.png" alt=""/>--}}
                {{--<ul class="qualityText clearfloat" style="padding-top: 2%;">--}}
                    {{--<li class="qualityLeft"><p>星巴克</p></li>--}}
                    {{--<li class="qualityRight title"><img src="/home/img/ffffff.png" alt=""/><img src="/home/img/hhh.png" alt=""/>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<ul class="qualityText clearfloat">--}}
                    {{--<li class="qualityLeft"><p>新款原味气泡水</p></li>--}}
                    {{--<li class="qualityRight"><span>$99.99</span></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-6">--}}
                {{--<img class="qualityPro" src="/home/img/quality03.png" alt=""/>--}}
                {{--<ul class="qualityText clearfloat" style="padding-top: 2%;">--}}
                    {{--<li class="qualityLeft"><p>星巴克</p></li>--}}
                    {{--<li class="qualityRight title"><img src="/home/img/ffffff.png" alt=""/><img src="/home/img/hhh.png" alt=""/>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<ul class="qualityText clearfloat">--}}
                    {{--<li class="qualityLeft"><p>新款原味气泡水</p></li>--}}
                    {{--<li class="qualityRight"><span>$99.99</span></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-6">--}}
                {{--<img class="qualityPro" src="/home/img/quality04.png" alt=""/>--}}
                {{--<ul class="qualityText clearfloat" style="padding-top: 2%;">--}}
                    {{--<li class="qualityLeft"><p>星巴克</p></li>--}}
                    {{--<li class="qualityRight title"><img src="/home/img/ffffff.png" alt=""/><img src="/home/img/hhh.png" alt=""/>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<ul class="qualityText clearfloat">--}}
                    {{--<li class="qualityLeft"><p>新款原味气泡水</p></li>--}}
                    {{--<li class="qualityRight"><span>$99.99</span></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
    @if (!empty($product))
    <div class="snacksBg maxCentr">
        <div class="qualityTitle" style="background: #FFFFFF;color: #fdb3d3;">
           {{--{{$product->zn_name}}--}}
        </div>
        <div class="snacksBox clearfloat">

            @foreach($product as $item)
                <div class="snacksPro pointer" data-router="/details/{{$item->id}}">
                    <img src="{{$item->product_image}}" alt=""/>
                    <p class="threeLine">
											<script>
												Language("{{$item->category->zn_name}}","{{$item->category->en_name}}")
											</script>
										<br/>
											<script>
												Language("{{$item->zn_name}}","{{$item->en_name}}")
											</script>
										</p>
                    <div class="snacksShow">
                        <ul class="clearfloat">
                            <li class="float_left oneLine" style="font-weight: bold;width: 100%;">
														<script>
															Language("{{$item->zn_name}}","{{$item->en_name}}")
														</script>
														</li>
                            <!--<li class="float_right title"><img src="/home/img/wx.png" alt=""/><img src="/home/img/wxx.png" alt=""/></li>-->
                        </ul>
                        <ul class="clearfloat">
                            <li class="float_left">${{$item->distributor->level_four_price}}</li>
                            <li class="float_right snacksBut">
																<script>
																	Language(`<button data-number="1" data-name="{{$item->zn_name}}" data-price="{{$item->distributor->level_four_price}}" data-img="{{$item->product_image}}" data-id="{{$item->id}}" class="shopAdd" >加入购物车`,
																		`<button data-number="1" data-name="{{$item->en_name}}" data-price="{{$item->distributor->level_four_price}}" data-img="{{$item->product_image}}" data-id="{{$item->id}}" class="shopAdd" >Add to cart`)
																</script>
																</button>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
    @endif
    
<script >
	
	$(".snacksPro").click(function(){
		var Router=$(this).attr("data-router");
		window.location.href = Router;
	})
</script>
@endsection
