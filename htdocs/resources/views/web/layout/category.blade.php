<div class="allProBg">
    <div class="maxCentr allPro am-g">
        <div class="am-u-sm-2 allClassIfy clearfloat">
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-primary am-dropdown-toggle" data-am-dropdown-toggle>
            <script>
            	Language("全部商品分类","Categories")
            </script> <span
                            class="am-icon-caret-down"><img src="/home/img/allPro.png" alt=""/></span></button>
                <ul class="am-dropdown-content">

                    @foreach($category as $item)
                        <li class="am-dropdown-header">
            <script>
            	Language("{{$item['zn_name']}}","{{$item['en_name']}}")
            </script></li>
                        @if(!empty($item['pid']))
                            {{--@foreach($item['pid'] as $items)--}}
                                {{--<li class="am-g clearfloat">--}}
                                    {{--<div class="am-u-sm-4"><a class="oneline" href="/shop/{{$items['id']}}">--{{$items['zn_name']}}</a></div>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                            <li class="am-g clearfloat">
                            @foreach($item['pid'] as $items)
                                    <div class="tuoNav"><a class="oneline" href="/shop/{{$items['id']}}">
            <script>
            	Language("{{$items['zn_name']}}","{{$items['en_name']}}")
            </script></a></div>

                            @endforeach
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @for ($i = 0; $i < 5; $i++)
            <div class="am-u-sm-2 ProClassIfy">
                <a href="/categorys/detail/{{$category[$i]['id']}}">
            <script>
            	Language("{{$category[$i]['zn_name']}}","{{$category[$i]['en_name']}}")
            </script></a>
            </div>
        @endfor
    </div>
</div>