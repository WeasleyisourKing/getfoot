@extends('web/layout.app')

@section('content')

    @include('web/layout.category')

	<style type="text/css">
		.maxCentr .am-u-sm-3{
			height: 370px;
			overflow: hidden;
		}
	</style>
    <div class="ProBannerBox">
        <img src="/home/img/ProBanner.png" alt=""/>
        <div class=""></div>
    </div>
    <script type="text/javascript">
//  	设置图片宽度
$(function(){
	$(".ProBannerBox img").width($(document).width()>1920?"100%":"1920px")
})
    </script>
    <div class="qualityBox ">
        <div class="maxCentr clearfloat">
            <!--<div class="qualityTitle oneLine">
                <script>
				          Language("{{$fine->zn_name}}","{{$fine->en_name}}")
				        </script>
            </div>-->
            @if(!empty($fine))
            @foreach($fine->hot as $items)
            <!--<div class="am-u-sm-3">
                <a href="/details/{{$items->id}}">
                <img class="qualityPro" src="{{$items->product_image}}" alt=""/>

                <ul class="qualityText clearfloat" style="padding-top: 2%;">
                    <li class="qualityLeft">
                      <p class="oneLine" >
                      <script>
				                Language("{{$items->brand->zn_name}}","{{$items->brand->en_name}}")
				              </script>
                      </p>
                    </li>
                    {{--<li class="qualityRight title"><img src="/home/img/ffffff.png" alt=""/><img src="/home/img/hhh.png" alt=""/>--}}
                    </li>
                </ul>
                <ul class="qualityText clearfloat">
                    <li class="qualityLeft">
                      <p class="oneLine" >
                        <script>
                          Language("{{$items->zn_name}}","{{$items->en_name}}")
                        </script>
                      </p>
                    </li>
                    <li class="qualityRight"><span>{{$items->distributor->level_four_price}}</span></li>
                </ul>
                </a>
            </div>-->

                @endforeach
                @endif

        </div>
    </div>
    @if (!empty($product))
    <div class="snacksBg maxCentr">
        <div class="qualityTitle" style="background: #FFFFFF;color: #82b7d7;">
          <script>
            Language("{{$product[0]->zn_name}}","{{$product[0]->en_name}}")
          </script>
        </div>
        <div class="snacksBox clearfloat">

            @foreach($product[0]->product as $item)
                <div class="snacksPro pointer" data-router="/details/{{$item->id}}">
                    <img src="{{$item->product_image}}" alt=""/>
                    <p class="threeLine">
                      <script>
                        Language("{{$item->brand->zn_name}}","{{$item->brand->en_name}}")
                      </script><br/>
                      <script>
                        Language("{{$item->zn_name}}","{{$item->en_name}}")
                      </script>
                    </p>
                    <div class="snacksShow ">
                        <ul class="clearfloat">
                            <li class="float_left oneLine" style="font-weight: bold; width: 100%;">
                              <script>
                                Language("{{$item->zn_name}}","{{$item->en_name}}")
                              </script>
                            </li>
                            <!--<li class="float_right title"><img src="/home/img/wx.png" alt=""/><img src="/home/img/wxx.png" alt=""/></li>-->
                        </ul>
                        <ul class="clearfloat">
                            <li class="float_left">
                                        @if(!empty(Auth::guard("pc")->user()))
                            	<script type="text/javascript">
                            		Spricedetails({{$item->distributor->level_four_price}},{{$item->distributor->level_two_price}},{{$item->distributor->level_one_price}},{{$item->distributor->level_three_price}})
                            	</script>
                                        @endif
                            </li>
                            <li class="float_right snacksBut">
                              <script>
                                Language(`<button data-number="1" data-name="{{$item->zn_name}}" data-price="@if(!empty(Auth::guard("pc")->user()))${Sprice1({{$item->distributor->level_four_price}},{{$item->distributor->level_two_price}},{{$item->distributor->level_one_price}},{{$item->distributor->level_three_price}})}@endif" data-img="{{$item->product_image}}" data-id="{{$item->id}}" class="shopAdd" >加入购物车`,
                                `<button data-number="1" data-name="{{$item->en_name}}" data-price="@if(!empty(Auth::guard("pc")->user()))${Sprice1({{$item->distributor->level_four_price}},{{$item->distributor->level_two_price}},{{$item->distributor->level_one_price}},{{$item->distributor->level_three_price}})}@endif" data-img="{{$item->product_image}}" data-id="{{$item->id}}" class="shopAdd" >Shopping Cart`)
                              </script>
                              </button>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
    <script type="text/javascript">
    	$(".maxCentr .am-u-sm-3:last-child").addClass("am-u-end")
    </script>
    @endif
    
@endsection
