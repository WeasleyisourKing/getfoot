@extends('web/layout.app')

@section('content')

    @include('web/layout.category')
    <style type="text/css">
    	.category li{
    		height: 277px;
    		overflow: hidden;
    	}
    </style>
    <!--中间体-->
    <div class="categoryBg">
        <div class=" maxCentr clearfloat">
            <!--<div class="categoryHot">
                <p class="oneLine"> 
            <script>
            	Language("{{$hot->zn_name}}","{{$hot->en_name}}")
            </script></p>
                <div class="categoryHotBox clearfloat">
                    @if(!empty($hot))
                    @foreach($hot->products as $items)
                    <div class="categoryHotPro"style="position: relative;"data-router="/details/{{$items['id']}}">
                        <img src="{{$items->product_image}}" alt=""/>
                        <div class="categoryHotPro_1" style="position: absolute;width: 100%;top: 0;left: 0;height: 238.8px;background:rgba(255,255,255,0.7);display: none;">
	                        	<p class="towLine" style="width: 80%;margin: 0 auto;text-align: center;font-size: 2rem; color: #666;margin-top: 40px;">
            <script>
            	Language("{{$items->zn_name}}","{{$items->en_name}}")
            </script></p>
	                        	<p style="width: 80%;margin: 0 auto;text-align: center;font-size: 2rem;  color: #222222 ;">${{$items['distributor']['level_four_price']}}</p>
                        </div>
                    </div>
                    @endforeach
                        @endif
                </div>
                <script type="text/javascript">
                		$(".categoryHotPro").mousemove(function(){
                			$(this).find(".categoryHotPro_1").show()
                		}).mouseout(function(){
                			$(this).find(".categoryHotPro_1").hide()
                		})
                </script>
            </div>-->
            <div class="am-u-sm-2 ">
                <nav class="categoryNav scrollspy-nav" data-am-sticky
                     data-am-scrollspynav="{className: {active: 'categoryNavshow'}}">
                    <ul>
                        @if(!empty($category[0]))
                            <a href="#category_1" class="categoryNavshow">
                                <img src="home/img/class8.png" alt=""/>
                                <p> 
            <script>
            	Language("{{$category[0]['zn_name']}}","{{$category[0]['en_name']}}")
            </script></p>
                            </a>
                        @endif
                        @if(!empty($category[1]))
                            <img class="classNav" src="home/img/classnav.png" alt=""/>
                            <a href="#category_2">
                                <img src="home/img/class7.png" alt=""/>
                                <p> 
            <script>
            	Language("{{$category[1]['zn_name']}}","{{$category[1]['en_name']}}")
            </script></p>
                            </a>
                        @endif
                        @if(!empty($category[2]))
                            <img class="classNav" src="home/img/classnav.png" alt=""/>
                            <a href="#category_3">
                                <img src="home/img/class6.png" alt=""/>
                                <p> 
            <script>
            	Language("{{$category[2]['zn_name']}}","{{$category[2]['en_name']}}")
            </script></p>
                            </a>
                        @endif
                        @if(!empty($category[3]))
                            <img class="classNav" src="home/img/classnav.png" alt=""/>
                            <a href="#category_4">
                                <img src="home/img/class5.png" alt=""/>
                                <p> 
            <script>
            	Language("{{$category[3]['zn_name']}}","{{$category[3]['en_name']}}")
            </script></p>
                            </a>
                        @endif
                        @if(!empty($category[4]))
                            <img class="classNav" src="home/img/classnav.png" alt=""/>
                            <a href="#category_5">
                                <img src="home/img/class4.png" alt=""/>
                                <p> 
            <script>
            	Language("{{$category[4]['zn_name']}}","{{$category[4]['en_name']}}")
            </script></p>
                            </a>
                        @endif

                    </ul>
                </nav>
            </div>

            <div class="am-u-sm-10 categoryBox" style="padding-top: 100px;">
                @for($i = 0; $i < 5; $i++)

                    @if (!empty($category[$i]))
                        <div class="categoryPro" id="category_{{$i+1}}">
                            {{--<a href="/categorys/detail/{{$category[$i]['id']}}">--}}
                            <div class="categoryTitle"  data-router="/categorys/detail/{{$category[$i]['id']}}">
            <script>
            	Language("{{$category[$i]['zn_name']}}","{{$category[$i]['en_name']}}")
            </script></div>
                            <ul class="category clearfloat">

                                @if (!empty($category[$i]['pid']))
                                    @php $j = 0;  @endphp

                                    @foreach($category[$i]['pid'] as $key)
                                        @foreach($key['product'] as $item)
                                            @if ($j == 10)
                                                @php break; @endphp
                                            @endif
                                            <li>
                                                <a href="/details/{{$item['id']}}"><img 
                                                        src="{{$item['product_image']}}" alt=""/></a>
                                                <p class="threeLine">
										            <script>
										            	Language("{{$item['brand']['zn_name']}}","{{$item['brand']['en_name']}}")
										            </script><br>
										                                                    
										            <script>
										            	Language("{{$item['zn_name']}}","{{$item['en_name']}}")
										            </script>
									            </p>
									            <div class="categoryBtn">
									            		<p>
									            			
											            @if(!empty(Auth::guard("pc")->user()))
											            <script>
											            	Spricedetails({{$item['distributor']['level_four_price']}},{{$item['distributor']['level_two_price']}},{{$item['distributor']['level_one_price']}},{{$item['distributor']['level_three_price']}})
											            </script>
											            @endif
									            		</p>
	                                                <a href="/details/{{$item['id']}}">
										            		<button>                           
										            <script>
										            	Language("点击购买"," Check Out ")
										            </script></button>
										            	</a>
									            </div>
                                            </li>
                                            @php $j++; @endphp
                                        @endforeach
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif
                @endfor
            </div>

        </div>
    </div>

@endsection
