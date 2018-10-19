@extends('web/layout.app')

@section('content')
<style type="text/css">
	a:hover{
		outline: none;
		text-decoration: none;
	}
</style>
    <div class="maxCentr classifyBox clearfloat">
        <div class="classify float_left">
            <ul>
                @for($i = 0;$i < 5; $i++)
                    <li data-router="/categorys/detail/{{$categorys[$i]['id']}}">
            <script>
            	Language("{{$categorys[$i]['zn_name']}}","{{$categorys[$i]['en_name']}}")
            </script></li>
                @endfor
            </ul>
        </div>

        <div class="bannerBox float_left">
            <div class="bannerShow">
                <div class="classifyProBox">
                    <div class="classifyPro clearfloat" style="display: none;">
                        <ol class="">

                            @if (!empty($categorys[0]))
                                @foreach($categorys[0]['pid'] as $items)
                                    <li><a href="/shop/{{$items['id']}}">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></a></li>
                                @endforeach
                            @endif
                        </ol>
                    </div>
                    <div class="classifyPro clearfloat " style="display: none;">
                        <ol class="float_left am-u-sm-4">
                            @if (!empty($categorys[1]))
                                @foreach($categorys[1]['pid'] as $items)
                                    <li><a href="/shop/{{$items['id']}}">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></a></li>
                                @endforeach
                            @endif
                        </ol>

                    </div>
                    <div class="classifyPro clearfloat  "style="display: none;">
                        <ol class="float_left am-u-sm-4">
                            @if (!empty($categorys[2]))
                                @foreach($categorys[2]['pid'] as $items)
                                    <li><a href="/shop/{{$items['id']}}">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></a></li>
                                @endforeach
                            @endif
                        </ol>

                    </div>
                    <div class="classifyPro clearfloat" style="display: none;">
                        <ol class="float_left am-u-sm-4">
                            @if (!empty($categorys[3]))
                                @foreach($categorys[3]['pid'] as $items)
                                    <li><a href="/shop/{{$items['id']}}">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></a></li>
                                @endforeach
                            @endif
                        </ol>
                    </div>
                    <div class="classifyPro clearfloat " style="display: none;">
                        <ol class="float_left am-u-sm-4">
                            @if (!empty($categorys[4]))
                                @foreach($categorys[4]['pid'] as $items)
                                    <li><a href="/shop/{{$items['id']}}">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></a></li>
                                @endforeach
                            @endif
                        </ol>
                    </div>
                </div>
                <div data-am-widget="slider" class="am-slider am-slider-default banner_show"
                     data-am-slider='{&quot;directionNav&quot;:false}'>
                    <ul class="am-slides">
                        @for( $i = 0; $i < count($banner); $i++ )
                            <li class="col-12 p-0">
                                <a href="{{$banner[$i]->url}}">
                                    <img class="w-100 h-100" src="{{$banner[$i]->img->url}}" alt=""></a>
                            </li>
                        @endfor

                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="maxCentr ">
        <div class="second ">
            <div class="secondBg clearfloat">
                <div class="secondBg1 float_left">
                </div>
                <div class="secondBg2 float_left">
                </div>
            </div>
            <div class="countDown clearfloat">
                <p class="float_left">
            <script>
            	Language("{{$modular[1]['zn_name']}}","{{$modular[1]['en_name']}}")
            </script><br/><span>
            <script>
            	Language("本场秒杀商品","Flash Sales Products")
            </script></span></p>
                <!--<p class="float_left">秒杀<br/><span>距离本场结束还有</span></p>-->
                <!--<div class="count float_left">
                    <div class="time">
                        <div class="data-show-box clearfloat" id="dateShow1">
                            <span class="date-tiem-span d">00</span>
                            <span class="date-tiem-span h">00</span>
                            <span class="date-tiem-span m">00</span>
                            <span class="date-s-span s">00</span>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $.leftTime("2018/08/22 23:45:24", function (d) {
                                    if (d.status) {
                                        var $dateShow1 = $("#dateShow1");
                                        $dateShow1.find(".d").html(d.d);
                                        $dateShow1.find(".h").html(d.h);
                                        $dateShow1.find(".m").html(d.m);
                                        $dateShow1.find(".s").html(d.s);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="text">The end of the field</div>
                </div>-->
            </div>
            <div class="secondBanner">
                <div data-am-widget="slider" class="am-slider am-slider-default"
                     data-am-slider='{"animation":"slide","animationLoop":false,"itemWidth":250,"itemMargin":2, "directionNav": true}'>
                    <ul class="am-slides">
                        {{--                    @if ($modular->id == 1)--}}
                        @foreach($modular[0]['products'] as $item)
                            <li >
                                <div class="secondBannerPro" data-router="/details/{{$item['id']}}">
                                    <img class="secondImg" src="{{$item['product_image']}}" alt=""/>
                                    <div class="title clearfloat">
                                        <p class="oneLine">
																				<script>
																					Language("{{$item['zn_name']}}","{{$item['en_name']}}")
																				</script></p>
                                        <img src="home/img/ffffff.png" alt=""/>
                                        <img src="home/img/hhh.png" alt=""/>
                                    </div>
                                    <div class="searchBut clearfloat">
                                        @if(!empty(Auth::guard("pc")->user()))
                                        <p>${{$item['distributor']['level_four_price']}}</p>
                                        @endif
                                        
            <script>
            	Language(`<button data-number="1" data-zn-name="{{$item['zn_name']}}" data-en-name="{{$item['en_name']}}"  datas-tock="{{$item['stock']}}" data-price="{{$item['distributor']['level_four_price']}}" data-img="{{$item['product_image']}}" data-id="{{$item['id']}}" class="shopAdd">加入购物车`,
            		`<button data-number="1" data-zn-name="{{$item['zn_name']}}" data-en-name="{{$item['en_name']}}" datas-tock="{{$item['stock']}}" data-price="{{$item['distributor']['level_four_price']}}" data-img="{{$item['product_image']}}" data-id="{{$item['id']}}" class="shopAdd"> Shopping Cart`)
            </script></button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="iocBg">
        <div class="maxCentr clearfloat">
            @if (!empty($categorys[0]))
                <a href="/shop/{{$categorys[0]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico1 (1).png" alt=""/>
                        <img src="home/img/ico1 (2).png" alt=""/>
                        <p>{{$categorys[0]['zn_name']}}<br/><span>{{$categorys[0]['en_name']}}</span></p>
                    </div>
                </a>
            @endif

            @if (!empty($categorys[1]))
                <a href="/shop/{{$categorys[1]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ioc2 (2).png" alt=""/>
                        <img src="home/img/ioc2 (1).png" alt=""/>
                        <p>{{$categorys[1]['zn_name']}}<br/><span>{{$categorys[1]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
            @if (!empty($categorys[2]))
                <a href="/shop/{{$categorys[2]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico3 (2).png" alt=""/>
                        <img src="home/img/ico3 (1).png" alt=""/>
                        <p>{{$categorys[2]['zn_name']}}<br/><span>{{$categorys[2]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
            @if (!empty($categorys[3]))
                <a href="/shop/{{$categorys[3]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico4 (1).png" alt=""/>
                        <img src="home/img/ico4 (2).png" alt=""/>
                        <p>{{$categorys[3]['zn_name']}}<br/><span>{{$categorys[3]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
            @if (!empty($categorys[4]))
                <a href="/shop/{{$categorys[4]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico5 (2).png" alt=""/>
                        <img src="home/img/ico5 (1).png" alt=""/>
                        <p>{{$categorys[4]['zn_name']}}<br/><span>{{$categorys[4]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
            @if (!empty($categorys[5]))
                <a href="/shop/{{$categorys[5]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico6 (2).png" alt=""/>
                        <img src="home/img/ico6 (1).png" alt=""/>
                        <p>{{$categorys[5]['zn_name']}}<br/><span>{{$categorys[5]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
            @if (!empty($categorys[6]))
                <a href="/shop/{{$categorys[6]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico8 (1).png" alt=""/>
                        <img src="home/img/ico8 (2).png" alt=""/>
                        <p>{{$categorys[6]['zn_name']}}<br/><span>{{$categorys[6]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
            @if (!empty($categorys[7]))
                <a href="/shop/{{$categorys[7]['id']}}">
                    <div class="icoPro am-u-sm-3 clearfloat">
                        <img src="home/img/ico7 (1).png" alt=""/>
                        <img src="home/img/ico7 (2).png" alt=""/>
                        <p>{{$categorys[7]['zn_name']}}<br/><span>{{$categorys[7]['en_name']}}</span></p>
                    </div>
                </a>
            @endif
        </div>
    </div>

    <div class="maxCentr hotBox">
        <div class="hotTitle">
            <script>
							Language("{{$modular[0]['zn_name']}}","{{$modular[0]['en_name']}}")
						</script>
            <p>■&nbsp;HOT</p>
        </div>
        <div class="hotPro clearfloat">
            <ul>
                <li class="hotPro1"><a
                            href="{{!empty($hotImg[0]['url']) ? $hotImg[0]['url'] : ''}}"><img
                                src="{{!empty($hotImg[0]['img']) ? $hotImg[0]['img'] : '' }}"
                                alt=""/></a></li>
                <li class="hotPro3"><a
                            href="{{!empty($hotImg[2]['url']) ? $hotImg[2]['url'] : ''}}"><img
                                src="{{!empty($hotImg[2]['img']) ? $hotImg[2]['img'] : '' }}"
                                alt=""/></a></li>
            </ul>
            <ul>
            <li class="hotPro2" style="margin-bottom: 2%;"><a
                        href="{{!empty($hotImg[1]['url']) ? $hotImg[1]['url'] : ''}}"><img
                            src="{{!empty($hotImg[1]['img']) ? $hotImg[1]['img'] : '' }}"
                            alt=""/></a></li>
            <li class="hotPro2" style="margin-bottom: 1%;"><a
                        href="{{!empty($hotImg[3]['url']) ? $hotImg[3]['url'] : ''}}"><img
                            src="{{!empty($hotImg[3]['img']) ? $hotImg[3]['img'] : '' }}"
                            alt=""/></a></li>
            <li class="hotPro2"><a
                        href="{{!empty($hotImg[4]['url']) ? $hotImg[4]['url'] : ''}}"><img
                            src="{{!empty($hotImg[4]['img']) ? $hotImg[4]['img'] : '' }}"
                            alt=""/></a></li>
            </ul>
            <ul>
            <li class="hotPro3"><a
                        href="{{!empty($hotImg[5]['url']) ? $hotImg[5]['url'] : ''}}"><img
                            src="{{!empty($hotImg[5]['img']) ? $hotImg[5]['img'] : '' }}"
                            alt=""/></a></li>
            <li class="hotPro1"><a
                        href="{{!empty($hotImg[6]['url']) ? $hotImg[6]['url'] : ''}}"><img
                            src="{{!empty($hotImg[6]['img']) ? $hotImg[6]['img'] : '' }}"
                            alt=""/></a></li>
            </ul>
            {{--<ul>--}}
                {{--<li class="hotPro1"><a--}}
                            {{--href="{{!empty($modular[1]['products'][0]['id']) ? '/details/'.$modular[1]['products'][0]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][0]['product_image']) ? $modular[1]['products'][0]['product_image'] : '' }}"--}}
                                {{--alt=""/></a></li>--}}
                {{--<li class="hotPro3"><a--}}
                            {{--href="{{!empty($modular[1]['products'][1]['id']) ? '/details/'.$modular[1]['products'][1]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][1]['product_image']) ? $modular[1]['products'][1]['product_image'] : '' }}"--}}
                                {{--alt=""/></a></li>--}}
            {{--</ul>--}}
            {{--<ul>--}}
                {{--<li class="hotPro2" style="margin-bottom: 2%;"><a--}}
                            {{--href="{{!empty($modular[1]['products'][2]['id']) ? '/details/'.$modular[1]['products'][2]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][2]['product_image']) ? $modular[1]['products'][2]['product_image'] : '' }}"--}}
                                {{--alt=""/></a></li>--}}
                {{--<li class="hotPro2" style="margin-bottom: 1%;"><a--}}
                            {{--href="{{!empty($modular[1]['products'][3]['id']) ? '/details/'.$modular[1]['products'][3]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][3]['product_image']) ? $modular[1]['products'][3]['product_image'] : '' }}"--}}
                                {{--alt=""/></a></li>--}}
                {{--<li class="hotPro2"><a--}}
                            {{--href="{{!empty($modular[1]['products'][4]['id']) ? '/details/'.$modular[1]['products'][4]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][4]['product_image']) ? $modular[1]['products'][4]['product_image'] : '' }}"--}}
                                {{--alt=""/></li>--}}
            {{--</ul>--}}
            {{--<ul>--}}
                {{--<li class="hotPro3"><a--}}
                            {{--href="{{!empty($modular[1]['products'][5]['id']) ? '/details/'.$modular[1]['products'][5]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][5]['product_image']) ? $modular[1]['products'][5]['product_image'] : '' }}"--}}
                                {{--alt=""/></a></li>--}}
                {{--<li class="hotPro1"><a--}}
                            {{--href="{{!empty($modular[1]['products'][6]['id']) ? '/details/'.$modular[1]['products'][6]['id'] : ''}}"><img--}}
                                {{--src="{{!empty($modular[1]['products'][6]['product_image']) ? $modular[1]['products'][6]['product_image'] : '' }}"--}}
                                {{--alt=""/></a></li>--}}
            {{--</ul>--}}
        </div>
    </div>

    <div class="classIfyBg">
        <div class="maxCentr">
            <div class="DrinksTitle">
                <p  data-router="/categorys/detail/{{$categorys[0]['id']}}">
            <script>
            	Language("{{$categorys[0]['zn_name']}}","{{$categorys[0]['en_name']}}")
            </script></p>
                {{--<p>饮料冲饮<br /><span>■&nbsp;BUY</span></p>--}}
            </div>
            <div class="Drinks clearfloat">
				<div class="DrinksMore" style="position: absolute;top: -42px;right: 17px;font-size: 50px;">
					<p data-router="/categorys/detail/99" style="cursor: pointer;font-size: 20px;font-weight: bold;color: #666;">MORE</p>
				</div>
                @php
                    $j = 0;
                @endphp

                @foreach($categorys[0]['pid'] as $item)
                    @foreach($item['product'] as $items)

                        @if ($j == 8)
                            @php
                                break;
                            @endphp
                        @endif

                        <div class="am-u-sm-3 ">
                            <div class="DrinksPro" data-router="/details/{{$items['id']}}">
                                <img  src="{{$items['product_image']}}" alt=""/>
                               @if(!empty(Auth::guard("pc")->user()))
                                    <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                @endif
                                <div class="DrinksShow">
                                    <div class="classifyProName towLine">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></div>
                             
            <script>
            	Language(`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd">加入购物车</button>`,
            		`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}" data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd"> Shopping Cart</button>`)
            </script>
                                    @if(!empty(Auth::guard("pc")->user()))
                                    <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                        @endif
                                </div>

                            </div>
                        </div>
                        @php
                            $j++;
                        @endphp
                    @endforeach
                @endforeach

            </div>

            <div class="DrinksTitle">
                <p  data-router="/categorys/detail/{{$categorys[1]['id']}}">
            <script>
            	Language("{{$categorys[1]['zn_name']}}","{{$categorys[1]['en_name']}}")
            </script></p>
                {{--<p>休闲零食<br/><span>■&nbsp;BUY</span></p>--}}
            </div>
            <div class="Drinks clearfloat">
				<div class="DrinksMore" style="position: absolute;top: -42px;right: 17px;font-size: 50px;">
					<p data-router="/categorys/detail/99" style="cursor: pointer;font-size: 20px;font-weight: bold;color: #666;">MORE</p>
				</div>
                @php
                    $j = 0;
                @endphp

                @foreach($categorys[1]['pid'] as $item)
                    @foreach($item['product'] as $items)

                        @if ($j == 8)
                            @php
                                break;
                            @endphp
                        @endif

                        <div class="am-u-sm-3 ">
                            <div class="DrinksPro" data-router="/details/{{$items['id']}}">
                                <img src="{{$items['product_image']}}" alt=""/>
                                @if(!empty(Auth::guard("pc")->user()))
                                <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                @endif
                                <div class="DrinksShow">
                                    <div class="classifyProName towLine">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></div>
                            
            <script>
            	Language(`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd">加入购物车`,
            		`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd"> Shopping Cart`)
            </script></button>
                                    @if(!empty(Auth::guard("pc")->user()))
                                    <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                        @endif
                                </div>

                            </div>
                        </div>
                        @php
                            $j++;
                        @endphp
                    @endforeach
                @endforeach

            </div>

            <div class="DrinksTitle">
                <p  data-router="/categorys/detail/{{$categorys[2]['id']}}">
            <script>
            	Language("{{$categorys[2]['zn_name']}}","{{$categorys[2]['en_name']}}")
            </script></p>
            </div>
            <div class="Drinks clearfloat">
				<div class="DrinksMore" style="position: absolute;top: -42px;right: 17px;font-size: 50px;">
					<p data-router="/categorys/detail/99" style="cursor: pointer;font-size: 20px;font-weight: bold;color: #666;">MORE</p>
				</div>
                @php
                    $j = 0;
                @endphp

                @foreach($categorys[2]['pid'] as $item)
                    @foreach($item['product'] as $items)

                        @if ($j == 8)
                            @php
                                break;
                            @endphp
                        @endif

                        <div class="am-u-sm-3 ">
                            <div class="DrinksPro" data-router="/details/{{$items['id']}}">
                                <img  src="{{$items['product_image']}}" alt=""/>
                                @if(!empty(Auth::guard("pc")->user()))
                                <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                @endif
                                <div class="DrinksShow">
                                    <div class="classifyProName towLine">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></div>
                            
            <script>
            	Language(`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd">加入购物车`,
            		`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd"> Shopping Cart`)
            </script></button>
                                    @if(!empty(Auth::guard("pc")->user()))
                                    <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                        @endif
                                </div>

                            </div>
                        </div>
                        @php
                            $j++;
                        @endphp
                    @endforeach
                @endforeach

            </div>

            <div class="DrinksTitle">
                <p  data-router="/categorys/detail/{{$categorys[3]['id']}}">
            <script>
            	Language("{{$categorys[3]['zn_name']}}","{{$categorys[3]['en_name']}}")
            </script></p>
            </div>
            <div class="Drinks clearfloat">
				<div class="DrinksMore" style="position: absolute;top: -42px;right: 17px;font-size: 50px;">
					<p data-router="/categorys/detail/99" style="cursor: pointer;font-size: 20px;font-weight: bold;color: #666;">MORE</p>
				</div>
                @php
                    $j = 0;
                @endphp

                @foreach($categorys[3]['pid'] as $item)
                    @foreach($item['product'] as $items)

                        @if ($j == 8)
                            @php
                                break;
                            @endphp
                        @endif

                        <div class="am-u-sm-3 ">
                            <div class="DrinksPro" data-router="/details/{{$items['id']}}">
                                <img  src="{{$items['product_image']}}" alt=""/>
                                @if(!empty(Auth::guard("pc")->user()))
                                <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                @endif
                                <div class="DrinksShow">
                                    <div class="classifyProName towLine">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></div>

            <script>
            	Language(`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd">加入购物车`,
            		`<button data-number="1" datas-tock="{{$items['stock']}}"data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd"> Shopping Cart`)
            </script>
            </button>
                                    @if(!empty(Auth::guard("pc")->user()))
                                    <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                        @endif
                                </div>

                            </div>
                        </div>
                        @php
                            $j++;
                        @endphp
                    @endforeach
                @endforeach

            </div>
            <div class="DrinksTitle">
                <p  data-router="/categorys/detail/{{$categorys[4]['id']}}">
            <script>
            	Language("{{$categorys[4]['zn_name']}}","{{$categorys[4]['en_name']}}")
            </script></p>
            </div>
            <div class="Drinks clearfloat">
				<div class="DrinksMore" style="position: absolute;top: -42px;right: 17px;font-size: 50px;">
					<p data-router="/categorys/detail/99" style="cursor: pointer;font-size: 20px;font-weight: bold;color: #666;">MORE</p>
				</div>
                @php
                    $j = 0;
                @endphp

                @foreach($categorys[4]['pid'] as $item)
                    @foreach($item['product'] as $items)

                        @if ($j == 8)
                            @php
                                break;
                            @endphp
                        @endif

                        <div class="am-u-sm-3 ">
                            <div class="DrinksPro" data-router="/details/{{$items['id']}}">
                                <img  src="{{$items['product_image']}}" alt=""/>
                                @if(!empty(Auth::guard("pc")->user()))
                                <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                @endif
                                <div class="DrinksShow">
                                    <div class="classifyProName towLine">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></div>
                        
            <script>
            	Language(`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd">加入购物车`,
            		`<button data-number="1" datas-tock="{{$items['stock']}}" data-zn-name="{{$items['zn_name']}}" data-en-name="{{$items['en_name']}}"  data-price="{{$items['distributor']['level_four_price']}}" data-img="{{$items['product_image']}}" data-id="{{$items['id']}}" class="shopAdd"> Shopping Cart`)
            </script></button>
                                    @if(!empty(Auth::guard("pc")->user()))
                                    <div class="Price">${{$items['distributor']['level_four_price']}}</div>
                                @endif
                                </div>

                            </div>
                        </div>
                        @php
                            $j++;
                        @endphp
                    @endforeach
                @endforeach

<script >
	
</script>
            </div>
        </div>
    </div>
    <div class="maxCentr ToShowBox">
        <div class="ToShowTitle">
            <p>晒单<br/><span>■&nbsp;SUN INGLE</span></p>
        </div>
        <div class="ToShow clearfloat">
            <div class="ToShowPro">
                <img src="home/img/mag.png" alt=""/>
                <p>happy <br/>06/06/2018</p>
            </div>
            <div class="ToShowPro">
                <img src="home/img/mag1.png" alt=""/>
                <p>happy <br/>06/06/2018</p>
            </div>
            <div class="ToShowPro">
                <img src="home/img/mag2.png" alt=""/>
                <p>happy <br/>06/06/2018</p>
            </div>
            <div class="ToShowPro">
                <img src="home/img/mag.png" alt=""/>
                <p>happy <br/>06/06/2018</p>
            </div>
            <div class="ToShowPro">
                <img src="home/img/mag1.png" alt=""/>
                <p>happy <br/>06/06/2018</p>
            </div>
        </div>
    </div>
    <div class="ButBannerBg">
        <div class="maxCentr">
            <div class="ButBannerBtn">
                <div>HOW IT WORKS</div>
            </div>
            <div class="ButBanner clearfloat">
                <div class="ButBannerPro float_left">
                    <img src="home/img/001.png" alt=""/>
                    <p>SUBSCRISE TO <br/>JAPAN CRATE</p>
                </div>
                <div class="ButBannerPro float_left">
                    <img src="home/img/002.png" alt=""/>
                    <p>SUBSCRISE TO <br/>JAPAN CRATE</p>
                </div>
                <div class="ButBannerPro float_left">
                    <img src="home/img/003.png" alt=""/>
                    <p>SUBSCRISE TO <br/>JAPAN CRATE</p>
                </div>
                <div class="ButBannerPro float_left">
                    <img src="home/img/004.png" alt=""/>
                    <p>SUBSCRISE TO <br/>JAPAN CRATE</p>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
//	屏蔽热销路由
	$(".hotPro a").click(function(){
		return false
	})
</script>
@endsection

