@extends('admin/layout.app') @section('content')
<!-- Page-Title -->
<style>
    * {
        margin: 0;
        padding: 0
    }
    
    li {
        list-style: none
    }
</style>
<div id="view-product" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">商品详细信息</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>商品名称 :
                            <text style="font-weight: 400;" id="pname"></text>
                        </label>
                </div>

                <div class="form-group">
                    <label>商品SKU :
                            <text style="font-weight: 400;" id="psku"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>商品内部SKU :
                            <text style="font-weight: 400;" id="pinnersku"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>商品保质期 （天）:
                            <text style="font-weight: 400;" id="pterm"></text>
                        </label>
                </div>

                <div class="form-group">
                    <label>成本价 （$）:
                            <text style="font-weight: 400;" id="pprice"></text>
                        </label>
                </div>

                <div class="form-group">
                    <label>代理商 （$）:
                            <text style="font-weight: 400;" id="pprice1"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>分销商（$） :
                            <text style="font-weight: 400;" id="pprice2"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>商业用户（$） :
                            <text style="font-weight: 400;" id="pprice3"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>零售 （$）:
                            <text style="font-weight: 400;" id="pprice4"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>商品状态 :
                            <text style="font-weight: 400;" id="pstatus"></text>
                        </label>
                </div>

                <div class="form-group">
                    <label>商品分类 :
                            <text style="font-weight: 400;" id="pcategory"></text>
                        </label>
                </div>

                <div class="form-group">
                    <label>商品品牌 :
                            <text style="font-weight: 400;" id="pbrand"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>箱规 :
                            <text style="font-weight: 400;" id="pnumber"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>邮寄重量 :
                            <text style="font-weight: 400;" id="pweight"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>商品规格 :
                            <text style="font-weight: 400;" id="pcompany"></text>
                        </label>
                </div>
                {{--
                <div class="form-group">--}} {{--
                    <label>净重量 :--}}
                    {{--<text style="font-weight: 400;" id="pnet_weight"></text>--}}
                    {{--</label>--}} {{--
                </div>--}}

                <div class="form-group">
                    <label>录入商品时间 :
                            <text style="font-weight: 400;" id="pcreated_at"></text>
                        </label>
                </div>
                <div class="form-group">
                    <label>商品关键词 :
                            <text style="font-weight: 400;" id="psummary"></text>
                        </label>
                </div>
                <div class="form-group" style="width:300px;margin-bottom: 20px;">
                    <label class="control-label">批次：<span style="color:red;"></span></label>
                    <select class="form-control" id="datede" onchange="funci(this);">
                            {{--<option value="1">1</option>--}}
                            {{--<option value="2">2</option>--}}
                            {{--<option value="3">3</option>--}}
                            {{--<option value="4">4</option>--}}
                            {{--<option value="5">5</option>--}}
                        </select>
                    <label class="control-label">过期时间：

                            <text style="font-weight: 400;" id="datedeText"></text>
                        </label>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- 产品发布 Modal -->
<div id="add-product" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 1000px;height: 300px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">添加商品</h4>
            </div>

            <div class="form-group">
                <ul id="myTab" class="nav nav-tabs navtab-bg nav-justified">
                    <li class="active">
                        <a href="#attr" data-toggle="tab">基础</a>
                    </li>
                    <li>
                        <a href="#prices" data-toggle="tab">价格</a>
                    </li>

                    <li>
                        <a href="#img" data-toggle="tab">展示图片</a>
                    </li>
                    <li>
                        <a href="#describe" data-toggle="tab">描述</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">属性 <b class="caret"></b>
                            </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
                            <li><a href="#size" tabindex="-1" data-toggle="tab">
                                        箱规</a>
                            </li>
                            <li><a href="#weights" tabindex="-1" data-toggle="tab">
                                        邮寄重量</a>
                            </li>
                            <li><a href="#attribute" tabindex="-1" data-toggle="tab">
                                        商品属性</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div id="myTabContent" style="box-shadow: none !important;border-right: 1px;border-left: 1px" class="tab-content">
                    <div class="tab-pane fade in active" id="attr">
                        <div class="form-group">
                            <label class="control-label">商品分类<span class="red">＊</span></label>

                            <select class="form-control" id="category">
                                    <option selected="selected" id="category1" value="">请选择商品分类</option>

                                    @foreach ($category as $items)
                                        @if (!empty($items['pid']))
                                            <option disabled="disabled" value="{{$items['id']}}">{{$items['zn_name']}}
                                                （{{ $items['en_name'] }}）
                                            </option>
                                            @foreach ($items['pid'] as $v)
                                                <option value="{{$v['id']}}">{{$v['html']}}{{$v['zn_name']}}
                                                    （{{ $v['en_name'] }}）
                                                </option>
                                            @endforeach
                                        @else
                                            <option disabled="disabled" value="{{$items['id']}}">{{$items['zn_name']}}
                                                （{{ $items['en_name'] }}）
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品品牌<span class="red">＊</span></label>
                            <select class="form-control" id="brand">
                                    <option selected="selected" id="brand1" value="">请选择商品品牌</option>
                                    @foreach ($brand as $items)

                                        <option value="{{$items->id}}">{{$items->zn_name}}
                                            （{{ $items->en_name }}）
                                        </option>

                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品所属货架</label>
                            <ul id="selectshelve" style="display:flex; display: -webkit-flex; flex-wrap:wrap; ">
                            </ul>
                            <select class="form-control" id="shelves">
                                    <option selected="selected" id="shelves1" value="">请选择商品所属货架</option>
                                    @foreach ($shelves as $items)
                                        @if ($items->status == 1)
                                            <option style="color: red;" value="{{$items->id}}">{{$items->name}}
                                                （{{ $items->number }}）【已满】
                                            </option>
                                        @else
                                            <option value="{{$items->id}}">{{$items->name}}
                                                （{{ $items->number }}）
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品是否上架<span class="red">＊</span></label>
                            <select class="form-control" id="stat">
                                    <option selected="selected" value="1">是</option>
                                    <option value="2">否</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sku">SKU<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="sku" id="sku" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="innersku">内部SKU<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="innersku" id="innersku" class="form-control" value="" required="required" />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="prices">
                        <div class="form-group">
                            <label class="control-label" for="price">成本价（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="price" id="price" class="form-control" value="0.00" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="one_price">代理商价格（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="one_price" id="one_price" class="form-control" value="0.00" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="two_price">分销商价格（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="two_price" id="two_price" class="form-control" value="0.00" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="three_price">商业用户（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="three_price" id="three_price" class="form-control" value="0.00" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="four_price">零售（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="four_price" id="four_price" class="form-control" value="0.00" required="required" />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="img">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品图片<br/>（最多5张）<span
                                            style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="file" name="img" id="uploadfile" multiple class="file-loading" />
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="describe" style="overflow: hidden;">

                        <div class="col-md-6 col-lg-6" style="padding-left: 0px;">
                            <div class="form-group">
                                <label class="control-label" for="zn_name">商品名称（中）（最多50字）<span
                                                style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="zn_name" id="zn_name" class="form-control" value="" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6" style="padding-right: 0px;">
                            <div class="form-group">
                                <label class="control-label" for="en_name">商品名称（英）（最多100字）<span
                                                class="red">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="en_name" id="en_name" class="form-control" value="" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="summary">商品关键词（最多100字）<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <textarea maxlength="100" name="summary" id="summary" style=" resize: none;height: 100px;" class="form-control" value=""></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="term">商品保质期（天）<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="term" id="term" class="form-control" value="" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">商品规格<span class="red">＊</span></label>
                            <select class="form-control" id="numberUnit">
                                    <option selected="selected" id="numberUnit1" value="">请选择商品规格</option>
                                    @foreach ($number as $items)
                                        <option value="{{$items->name}}|{{$items->unit}}">{{$items->name}}
                                            （{{$items->unit}}）
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                        {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label" for="net_weight">净重量（克）<span--}}
                            {{--style="color:red;">＊</span></label>--}} {{--
                            <div class="controls">--}} {{--
                                <input type="text" name="net_weight" id="net_weight" --}} {{--class="form-control" --}} {{--value="" required="required" />--}} {{--
                            </div>--}} {{--
                        </div>--}} {{--

                        <div class="form-group">--}} {{--
                            <label class="control-label" for="net_weightUnit">重量单位<span--}}
                            {{--style="color:red;">＊</span></label>--}} {{--
                            <select class="form-control" id="net_weightUnit">--}}
                            {{--<option selected="selected" id="net_weightUnit1" value="">请选择重量单位</option>--}}
                            {{--@foreach ($weight as $items)--}}
                            {{--<option value="{{$items->name}}|{{$items->unit}}">{{$items->name}}--}}
                            {{--（{{$items->unit}}）--}}
                            {{--</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}} {{--
                        </div>--}} {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label" for="title">商品保质到期时间</label>--}} {{--
                            <div class="controls">--}} {{--
                                <input class="form-control" id="term" name="indate" value="" type="text" placeholder="请选择查询日期" readonly>--}} {{--
                            </div>--}} {{--
                        </div>--}}
                        <div class="form-group">
                            <label class="control-label">详细描述（中）<span class="red">＊</span></label>
                            <div class="controls">
                                <div id="zn_describe">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">详细描述（英）<span class="red">＊</span></label>
                            <div class="controls">
                                <div id="en_describe">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="size">
                        <div class="form-group">
                            <label class="control-label" for="number">每箱数量<span
                                            style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="number" id="number" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label">单品单位<span class="red">＊</span></label>--}} {{--
                            <select class="form-control" id="numberUnit">--}}
                            {{--<option selected="selected" id="numberUnit1" value="">请选择单品单位</option>--}}
                            {{--@foreach ($number as $items)--}}
                            {{--<option value="{{$items->name}}|{{$items->unit}}">{{$items->name}}--}}
                            {{--（{{$items->unit}}）--}}
                            {{--</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}} {{--
                        </div>--}}
                    </div>
                    <div class="tab-pane fade" id="weights">
                        <div class="form-group">
                            <label class="control-label" for="weight">每箱重量<span
                                            style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="weight" id="weight" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="weightUnit">重量单位<span
                                            style="color:red;">＊</span></label>
                            <select class="form-control" id="weightUnit">
                                    <option selected="selected" id="weightUnit1" value="">请选择重量单位</option>
                                    @foreach ($weight as $items)
                                        <option value="{{$items->name}}|{{$items->unit}}">{{$items->name}}
                                            （{{$items->unit}}）
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="attribute">
                        <div class="form-group" id="addProductId">
                            <button type="button" class="btn btn-info dropdown-toggle waves-effect" id="addProduct">添加产品属性
                                </button>
                        </div>


                    </div>
                </div>
            </div>

            <div class="modal-footer" style="border: 0">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="sa-success" onclick="funb();" class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                    </button>
            </div>
        </div>
    </div>
</div>

<!-- 编辑产品 Modal -->
<div id="edit-product" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 1000px;height: 300px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">编辑商品</h4>
            </div>

            <div class="form-group">
                <ul id="myTab" class="nav nav-tabs navtab-bg nav-justified">
                    <li class="active">
                        <a href="#eattr" data-toggle="tab">基础</a>
                    </li>
                    <li>
                        <a href="#eprices" data-toggle="tab">价格</a>
                    </li>

                    <li>
                        <a href="#eimg" data-toggle="tab">展示图片</a>
                    </li>
                    <li>
                        <a href="#edescribe" data-toggle="tab">描述</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" id="emyTabDrop1" class="dropdown-toggle" data-toggle="dropdown">属性 <b class="caret"></b>
                            </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="emyTabDrop1">
                            <li><a href="#esize" tabindex="-1" data-toggle="tab">
                                        箱规</a>
                            </li>
                            <li><a href="#eweights" tabindex="-1" data-toggle="tab">
                                        邮寄重量</a>
                            </li>
                            <li><a href="#eattribute" tabindex="-1" data-toggle="tab">
                                        商品属性</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div id="myTabContent" style="box-shadow: none !important;border-right: 1px;border-left: 1px" class="tab-content">
                    <div class="tab-pane fade in active" id="eattr">
                        <div class="form-group">
                            <label class="control-label">商品分类<span class="red">＊</span></label>
                            <select class="form-control" id="ecategory">

                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品品牌<span class="red">＊</span></label>
                            <select class="form-control" id="ebrand">

                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品是否上架<span class="red">＊</span></label>
                            <select class="form-control" id="estat">

                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品所属货架</label>
                            <ul id="eselectshelve" style="display:flex; display: -webkit-flex; flex-wrap:wrap; ">

                            </ul>
                            <select class="form-control" id="eshelves">

                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="esku">SKU<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="esku" id="esku" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="einnersku">内部SKU<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="einnersku" id="einnersku" class="form-control" value="" required="required" />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="eprices">
                        <div class="form-group">
                            <label class="control-label" for="eprice">成本价（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="eprice" id="eprice" class="form-control" value="0.00" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="eone_price">代理商（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="eone_price" id="eone_price" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="etwo_price">分销商（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="etwo_price" id="etwo_price" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="ethree_price">商业用户（$）<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="ethree_price" id="ethree_price" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="efour_price">零售（$）<span class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="efour_price" id="efour_price" class="form-control" value="" required="required" />
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="eimg">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品图片<br/>（最多5张）<span
                                            style="color:red;">＊</span></label>
                            <div class="controls" id="control">

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="edescribe" style="overflow: hidden;">

                        <div class="col-md-6 col-lg-6" style="padding-left: 0px;">
                            <div class="form-group">
                                <label class="control-label" for="ezn_name">商品名称（中）（最多50字）<span
                                                style="color:red;">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="ezn_name" id="ezn_name" class="form-control" value="" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6" style="padding-right: 0px;">
                            <div class="form-group">
                                <label class="control-label" for="een_name">商品名称（英）（最多100字）<span
                                                class="red">＊</span></label>
                                <div class="controls">
                                    <input type="text" name="een_name" id="een_name" class="form-control" value="" required="required" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="esummary">商品关键词（最多100字）<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <textarea maxlength="100" name="esummary" id="esummary" style=" resize: none;height: 100px;" class="form-control" value=""></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="eterm">商品保质期（天）<span
                                            class="red">＊</span></label>
                            <div class="controls">
                                <input type="text" name="eterm" id="eterm" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商品规格<span class="red">＊</span></label>
                            <select class="form-control" id="enumberUnit">

                                </select>
                        </div>
                        {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label" for="enet_weight">净重量（克）<span--}}
                            {{--style="color:red;">＊</span></label>--}} {{--
                            <div class="controls">--}} {{--
                                <input type="text" name="enet_weight" id="enet_weight" --}} {{--class="form-control" --}} {{--value="" required="required" />--}} {{--
                            </div>--}} {{--
                        </div>--}} {{--

                        <div class="form-group">--}} {{--
                            <label class="control-label" for="eweight">每箱重量<span--}}
                            {{--style="color:red;">＊</span></label>--}} {{--
                            <div class="controls">--}} {{--
                                <input type="text" name="eweight" id="eweight" --}} {{--class="form-control" --}} {{--value="" required="required" />--}} {{--
                            </div>--}} {{--
                        </div>--}} {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label">重量单位<span class="red">＊</span></label>--}} {{--
                            <select class="form-control" id="enet_weightUnit">--}}

                            {{--</select>--}} {{--
                        </div>--}} {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label" for="title">商品保质到期时间</label>--}} {{--
                            <div class="controls">--}} {{--
                                <input class="form-control" id="eterm" name="indate" value="" type="text" --}} {{--placeholder="请选择查询日期" readonly>--}} {{--
                            </div>--}} {{--
                        </div>--}}

                        <div class="form-group">
                            <label class="control-label">详细描述（中）<span class="red">＊</span></label>
                            <div class="controls">
                                <div id="ezn_describe">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">详细描述（英）<span class="red">＊</span></label>
                            <div class="controls">
                                <div id="een_describe">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="esize">
                        <div class="form-group">
                            <label class="control-label" for="enumber">每箱数量<span
                                            style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="enumber" id="enumber" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        {{--
                        <div class="form-group">--}} {{--
                            <label class="control-label">单品单位<span class="red">＊</span></label>--}} {{--
                            <select class="form-control" id="enumberUnit">--}}

                            {{--</select>--}} {{--
                        </div>--}}
                    </div>
                    <div class="tab-pane fade" id="eweights">
                        <div class="form-group">
                            <label class="control-label" for="eweight">每箱重量<span
                                            style="color:red;">＊</span></label>
                            <div class="controls">
                                <input type="text" name="eweight" id="eweight" class="form-control" value="" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="eweightUnit">重量单位<span
                                            style="color:red;">＊</span></label>
                            <select class="form-control" id="eweightUnit">

                                </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="eattribute">
                        <div class="form-group" id="eaddProductId">
                            <button type="button" class="btn btn-info dropdown-toggle waves-effect" id="eaddProduct">添加产品属性
                                </button>
                        </div>


                    </div>
                </div>
            </div>

            <div class="modal-footer" style="border: 0">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="sa-save" data-id="" onclick="efunb(this);" class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                    </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h4 class="pull-left page-title">产品管理</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Admin Panel</a></li>
            <li><a href="#">产品管理</a></li>
            <li class="active">商品管理</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">商品管理</h3>
        </div>
        <div class="panel-body">
            <!-- Start Form -->


            <!-- 搜索 -->
            <div class="row">
                <div class="col-sm-3">
                    <button type="button" class="btn waves-effect waves-light btn-primary" data-toggle="modal" data-target="#add-product">
                            <i class="fa fa-plus"></i> Add
                        </button>

                </div>
                <div class="col-sm-6">
                    <div class="input-group ">
                        <div class="btn-group">
                            <button id="fcategory" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="max-width: 96px; overflow-x: hidden;">{{$categoryVal}} <span
                                            class="caret"></span></button> @if (count($category) > 9)
                            <ul id="ccategory" class="dropdown-menu" role="menu" style="height:300px; overflow-y:scroll;">
                                @else
                                <ul id="ccategory" class="dropdown-menu" role="menu">
                                    @endif
                                    <li><a data-data="-1" data-name="全部分类" href="javascript:void(0);">全部分类</a></li>

                                    @foreach ($category as $items) @if (!empty($items['pid']))

                                    <li style="pointer-events:none; "><a href="javascript:void(0);" data-data="{{$items['id']}}" data-name="{{$items['zn_name']}}
                                                                                                     （{{ $items['en_name'] }}）">{{$items['zn_name']}}
                                                                （{{ $items['en_name'] }}）
                                                            </a></li>

                                    @foreach ($items['pid'] as $v)
                                    <li><a href="javascript:void(0);" data-data="{{$v['id']}}" data-name="{{$v['zn_name']}}
                                                                           （{{ $v['en_name'] }}）">{{$v['html']}}{{$v['zn_name']}}
                                                                    （{{ $v['en_name'] }}）
                                                                </a></li>
                                    @endforeach @else
                                    <li style="pointer-events:none; "><a href="javascript:void(0);" data-data="{{$items['id']}}" data-name="{{$items['zn_name']}}
                                                                                                     （{{ $items['en_name'] }}）">{{$items['zn_name']}}
                                                                （{{ $items['en_name'] }}）
                                                            </a></li>
                                    @endif @endforeach
                                </ul>
                        </div>
                        <div class="btn-group">
                            <button id="fbrand" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="max-width: 96px; overflow-x: hidden;">{{$brandVal}}
                                    <span class="caret"></span></button> @if (count($brand) > 9)
                            <ul id="cbrand" class="dropdown-menu" role="menu" style="height:300px; overflow-y:scroll;">
                                @else
                                <ul id="cbrand" class="dropdown-menu" role="menu">
                                    @endif
                                    <li><a data-data="-1" data-name="全部品牌" href="javascript:void(0);">全部品牌</a></li>
                                    @foreach ($brand as $items)
                                    <li>
                                        <a data-data="{{$items->id}}" data-name="{{$items->zn_name}}
                                                                （{{ $items->en_name }}）" href="javascript:void(0);">{{$items->zn_name}}
                                                            （{{ $items->en_name }}）</a></li>
                                    @endforeach
                                </ul>
                        </div>
                        <div class="btn-group">
                            <button id="status" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="max-width: 96px; overflow-x: hidden;">{{$status}}
                                    <span class="caret"></span></button>
                            <ul id="cstatus" class="dropdown-menu" role="menu">
                                <li><a data-data="-1" data-name="全部状态" href="javascript:void(0);">全部状态</a></li>
                                <li><a data-data="1" data-name="上架" href="javascript:void(0);">上架</a></li>
                                <li><a data-data="2" data-name="下架" href="javascript:void(0);">下架</a></li>
                            </ul>
                        </div>

                        <div class="btn-group ">
                            <button class="btn waves-effect waves-light btn-primary" type="button" id="searchBtn" onClick="doPostSearch();"><span
                                            class="fa fa-search"></span></button>
                        </div>
                    </div>

                </div>
                {{--
                <div class="col-sm-2">--}} {{----}} {{--
                </div>--}}
                <div class="col-sm-3 ">
                    <!--<div class="col-sm-3 col-md-offset-6">-->
                    <div class="input-group">
                        <input id="searchString" class="form-control" placeholder="请输入商品中文名称" type="text">
                        <span class="input-group-btn">
                                                    <button type="button" onClick="doSearch();"
                                                            class="btn waves-effect waves-light btn-primary">
                                                        <i class="fa fa-search"></i>
                                                    </button>

                                                    </span>
                    </div>
                    <!--</div>-->
                </div>
            </div>
            <!-- 搜索 -->

            <!-- 表单 -->
            <div class="row m-t-30">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">商品列表</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="btn-group col-md-2">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{$limit}} <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="select" href="">20条</a></li>
                                    <li><a id="select10" href="">50条</a></li>
                                    <li><a id="select15" href="">100条</a></li>
                                    {{--
                                    <li><a id="select20" href="">20条</a></li>--}}
                                </ul>
                            </div>
                            <div class="col-md-8">
                                {{--
                                <div class="controls col-md-1">--}} {{--
                                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" --}} {{--id="confirm">确定--}}
                                    {{--</button>--}} {{--
                                </div>--}} {{--
                                <div class="controls col-md-2">--}} {{--
                                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" --}} {{--id="addProduct">添加产品属性--}}
                                    {{--<span class="caret"></span>--}}
                                    {{--</button>--}} {{--
                                </div>--}} {{--

                                <div id="addProductId" class="controls col-md-9">--}} {{--

                                </div>--}}

                            </div>


                            <div class="btn-group col-md-2">
                                <button type="button" class="btn btn-info dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">批量操作
                                        <span class="caret"></span>
                                    </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="javascript:void();" id="ups">全部上架</a></li>
                                    <li><a href="javascript:void();" id="downs">全部下架</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row m-t-10">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <tr>

                                                <th class="col-md-2 col-lg-2 exce">
                                                    <div class="checkbox checkbox-success checkbox-inline">
                                                        <input type="checkbox" data-id="1212" id="all" name="all" />
                                                        <label for="all"> 商品名称 </label>
                                                    </div>
                                                </th>
                                                <th class="col-md-2 col-lg-2 exce"> 商品图片</th>
                                                <th class="col-md-2 col-lg-2 exce"> 成本价（$）</th>
                                                <th class="col-md-2 col-lg-2 exce"> 分类</th>
                                                <th class="col-md-2 col-lg-2 exce"> 状态</th>
                                                <th class="col-md-2 col-lg-2 exce" class="td-actions"> 操作</th>
                                            </tr>
                                    </thead>

                                    <tbody id="postContainer">
                                        @foreach ($data as $item)
                                        <tr>
                                            <td class="exce">
                                                <div class="checkbox checkbox-success checkbox-inline">
                                                    <input type="checkbox" name="radio" id="productCheckBox{{ $item->id }}" value="{{ $item->id }}" />
                                                    <label for="productCheckBox{{ $item->id }}">{{ $item->zn_name }}
                                                            <br/>{{ $item->en_name }}</label>
                                                </div>
                                            </td>
                                            <td class="exce"><img height="100px; align=" middle "
                                                    src="{{ $item->product_image }}" alt="没有上传"/>
                                            </td>

                                            <td class="exce">{{ $item->price }}</td>

                                            <td class="exce">{{ $item->category->zn_name}}
                                                <br/>{{ $item->category->en_name }}
                                            </td>

                                            @if ($item->status == 1)
                                            <td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i>
                                            </td>
                                            @else
                                            <td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i>
                                            </td>
                                            @endif
                                            <td class="exce">

                                                <a title="查看信息" class="btn btn-success waves-effect waves-light" href="javascript:void(0);" onclick="viewProduct(this);" data-id="{{$item->id}}" data-name="{{ $item->zn_name }}（{{ $item->en_name }}）" data-sku="{{ $item->sku }}" data-innersku="{{$item->innersku}}"
                                                    data-price="{{ $item->price }}" data-oneprice="{{ empty($item->distributor->level_one_price) ? 0: $item->distributor->level_one_price}}" data-twoprice="{{ empty($item->distributor->level_two_price) ? 0:  $item->distributor->level_two_price}}"
                                                    data-threeprice="{{ empty($item->distributor->level_three_price) ? 0:  $item->distributor->level_three_price}}" data-fourprice="{{ empty($item->distributor->level_four_price) ? 0:  $item->distributor->level_four_price}}"
                                                    data-term="{{$item->term}}" data-stock="{{ $item->stock }}" data-status="{{ $item->status }}" data-summary="{{ $item->summary }}" data-created_at="{{ $item->created_at }}" data-category="{{ $item->category->zn_name }}（{{ $item->category->en_name }}）"
                                                    data-brand="{{ $item->brand->zn_name }}（{{ $item->brand->en_name }}）" data-number="每箱数量{{$item->number}}" data-company="{{ $item->zn_number }}（{{ $item->en_number }}）" data-weight="{{$item->weight}} {{ $item->zn_weight }}（{{ $item->en_weight }}）"
                                                    data-date="{{$item->date}}" {{--data-netWeight="{{$item->net_weight}} 克（g）" --}} {{-- data-attr="{{$item->attr}} " --}}>
                                                    <i class="fa fa-external-link"> </i>
                                                </a>
                                                <a title="修改信息" onclick="edit(this);" class="btn btn-small btn-info" data-id="{{$item->id}}" href="javascript:void(0);">
                                                    <i class="icon fa fa-pencil"> </i>
                                                </a>
                                                <a title="删除" class="btn btn-small btn-danger" href="javascript:void(0);" data-id="{{$item->id}}" onclick="del(this);">
                                                    <i class="icon fa fa-trash-o"> </i>
                                                </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="clear: both;text-align: center;">
                                    {{ $data->links() }}
                                </div>

                            </div>
                            @if(!$data->count())
                            <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- 表单 -->


            <!-- End Form -->
        </div>
    </div>
</div>

<script>
    //        $("#term").jeDate({
    //            format:"YYYY-MM-DD",
    //            skinCell:"jedategreen",
    //            isTime:false,
    //            zIndex:99999,
    //            minDate:"2000-01-01 00:00:00"
    //        })
    //        $("#eterm").jeDate({
    //            format:"YYYY-MM-DD",
    //            skinCell:"jedategreen",
    //            isTime:false,
    //            zIndex:99999,
    //            minDate:"2000-01-01 00:00:00"
    //        })
    var viewProduct = function(event) {

        $('#pname').text($(event).attr('data-name'));
        $('#psku').text($(event).attr('data-sku'));
        $('#pinnersku').text($(event).attr('data-innersku'));
        $('#pprice').text($(event).attr('data-price'));
        $('#pprice1').text($(event).attr('data-oneprice'));
        $('#pprice2').text($(event).attr('data-twoprice'));
        $('#pprice3').text($(event).attr('data-threeprice'));
        $('#pprice4').text($(event).attr('data-fourprice'));
        $('#pstock').text($(event).attr('data-stock'));
        $('#pstatus').text($(event).attr('data-status') == 1 ? '上架' : '下架');
        $('#pbrand').text($(event).attr('data-brand'));
        $('#pnumber').text($(event).attr('data-number'));
        $('#pcategory').text($(event).attr('data-category'));
        $('#pweight').text($(event).attr('data-weight'));
        $('#psummary').text($(event).attr('data-summary'));
        $('#pterm').text($(event).attr('data-term'));
        $('#pcreated_at').text($(event).attr('data-created_at'));
        $('#pcompany').text($(event).attr('data-company'));

        var dates = '',
            dd = JSON.parse($(event).attr('data-date'));

        if (dd > 0) {

            for (let i in dd) {
                var mid = dd[i].overdue != null ? dd[i].overdue : '未填写';
                dates += `<option value="${mid}">${dd[i].info.order_no}</option>`;
            }

            $('#datede').html(dates);
            $('#datedeText').html(dd[0].overdue != null ? dd[0].overdue : '未填写');

        } else {
            $('#datede').html('');
            $('#datedeText').text('');
        }


        //            $('#pnet_weight').text($(event).attr('data-netWeight'));
        $('#view-product').modal('toggle');


    }
    var funci = function(event) {
        $('#datedeText').text($(event).val());
    }
</script>

<script>
    //添加编辑器
    var E = window.wangEditor;

    var zn_editor = new E('#zn_describe');
    //图片名
    zn_editor.customConfig.uploadFileName = 'img';
    //接口
    zn_editor.customConfig.uploadImgServer = "/imgHandle"; // 上传图片
    //传递参数 POST
    zn_editor.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
    zn_editor.customConfig.uploadImgHooks = {
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
        fail: function(xhr, editor, result) {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            editor.customConfig.customAlert(result.data[0]);

        },
        // 图片上传出错时触发
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
        error: function(xhr, editor) {
            editor.customConfig.customAlert(result.data[0]);
        },
    };
    //自定义提示方法
    zn_editor.customConfig.customAlert = function(info) {
        alertify.alert(info);
    };
    zn_editor.create();
</script>

<script>
    //添加编辑器
    var E = window.wangEditor;

    var en_editor = new E('#en_describe');
    //图片名
    en_editor.customConfig.uploadFileName = 'img';
    //接口
    en_editor.customConfig.uploadImgServer = "/imgHandle"; // 上传图片
    //传递参数 POST
    en_editor.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
    en_editor.customConfig.uploadImgHooks = {
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
        fail: function(xhr, editor, result) {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            editor.customConfig.customAlert(result.data[0]);

        },
        // 图片上传出错时触发
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
        error: function(xhr, editor) {
            editor.customConfig.customAlert(result.data[0]);
        },
    };
    //自定义提示方法
    en_editor.customConfig.customAlert = function(info) {
        alertify.alert(info);
    };
    en_editor.create();
</script>

<script>
    //添加编辑器
    var E = window.wangEditor;

    var ezn_editor = new E('#ezn_describe');
    //图片名
    ezn_editor.customConfig.uploadFileName = 'img';
    ezn_editor.customConfig.fontNames = [
            '宋体',
            '微软雅黑',
            'Arial',
            'Tahoma',
            'Verdana'
        ]
        //接口
    ezn_editor.customConfig.uploadImgServer = "/imgHandle"; // 上传图片
    //传递参数 POST
    ezn_editor.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
    ezn_editor.customConfig.uploadImgHooks = {
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
        fail: function(xhr, editor, result) {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            editor.customConfig.customAlert(result.data[0]);

        },
        // 图片上传出错时触发
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
        error: function(xhr, editor) {
            editor.customConfig.customAlert(result.data[0]);
        },
    };
    //自定义提示方法
    ezn_editor.customConfig.customAlert = function(info) {
        alertify.alert(info);
    };
    ezn_editor.create();
</script>

<script>
    //添加编辑器
    var E = window.wangEditor;

    var een_editor = new E('#een_describe');
    //图片名
    een_editor.customConfig.uploadFileName = 'img';
    //接口
    een_editor.customConfig.uploadImgServer = "/imgHandle"; // 上传图片
    //传递参数 POST
    een_editor.customConfig.uploadImgParams = {
            _token: '{{csrf_token()}}'
        }
        //监听
    een_editor.customConfig.uploadImgHooks = {
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
        fail: function(xhr, editor, result) {
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            editor.customConfig.customAlert(result.data[0]);

        },
        // 图片上传出错时触发
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
        error: function(xhr, editor) {
            editor.customConfig.customAlert(result.data[0]);
        },
    };
    //自定义提示方法
    een_editor.customConfig.customAlert = function(info) {
        alertify.alert(info);
    };
    een_editor.create();
</script>
<script>
    //添加编辑器
    window.imgAddress = [];
    window.imgId = '';
    $("#uploadfile").fileinput({
        language: 'zh', //设置语言
        uploadUrl: "/imgHandle", //上传的地址
        allowedFileExtensions: ['jpg', 'gif', 'png'], //接收的文件后缀
        initialPreview: [ //预览图片的设置
        ],
        uploadAsync: true, //默认异步上传
        showUpload: true, //是否显示上传按钮
        showRemove: true, //显示移除按钮
        showPreview: true, //是否显示预览+
        showCaption: true, //是否显示标题
        browseClass: "btn btn-primary", //按钮样式
        dropZoneEnabled: false, //是否显示拖拽区域
        //minImageWidth: 50, //图片的最小宽度
        //minImageHeight: 50,//图片的最小高度
        maxImageWidth: 900, //图片的最大宽度
        maxImageHeight: 900, //图片的最大高度
        maxFileSize: 5120, //单位为kb，如果为0表示不限制文件大小
        //minFileCount: 0,
        maxFileCount: 5, //表示允许同时上传的最大文件个数
        enctype: 'multipart/form-data',
        validateInitialCount: true,
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
        //传递参数
        uploadExtraData: function(previewId, index) { //额外参数的关键点
            var data = {
                '_token': '{{csrf_token()}}'
            };
            return data;
        }
    });

    //异步上传返回结果处理
    $("#uploadfile").on("fileuploaded", function(event, data) {
        var obj = data.response;

        if (obj.errno == 1) {
            alertify.alert(obj.data[0]);
            return;
        } else {
            imgAddress.push(obj.data);
            alertify.success('上传成功');
        }
    });
</script>

<script>
    //不可选中
    window.seshelve = [];
    window.eseshelve = [];
    $('#category').click(function() {
        $("#category1").attr('disabled', 'disabled');
    })
    $('#brand').click(function() {
        $("#brand1").attr('disabled', 'disabled');
    })
    $('#numberUnit').click(function() {
        $("#numberUnit1").attr('disabled', 'disabled');
    })
    $('#weightUnit').click(function() {
        $("#weightUnit1").attr('disabled', 'disabled');
    })
    $('#shelves').click(function() {
        $("#shelves1").attr('disabled', 'disabled');

    })
    $('#eshelves').click(function() {
        $("#shelves11").attr('disabled', 'disabled');
    })
    $('#shelves').change(function() {

        var cent = '',
            arr = {
                'shelves_id': $(this).val(),
                'name': $(this).find("option:selected").text()
            };
        window.seshelve.push(arr);
        for (let i in window.seshelve) {
            cent += `<li  style="padding:10px 5px;flex: 1;margin:5px;min-width: 19%;max-width: 20%; text-align:center;background: #eee;border-radius: 5px;">${seshelve[i].name} <i class="fa fa-times"onclick="delseshelve(${i})"></i></li>`;
        }
        $('#selectshelve').html(cent);
    })
    $('#eshelves').change(function() {

            var cent = '',
                arr = {
                    'shelves_id': $(this).val(),
                    'name': $(this).find("option:selected").text()
                };
            window.eseshelve.push(arr);
            for (let i in window.eseshelve) {
                cent += `<li  style="padding:10px 5px;margin:5px;flex: 1;min-width: 20%;max-width: 19%; text-align:center;background: #eee;border-radius: 5px;">${eseshelve[i].name} <i class="fa fa-times"onclick="deleseshelve(${i})"></i></li>`;
            }
            $('#eselectshelve').html(cent);
        })
        //删除选中的货架
    var deleseshelve = function(index) {
        window.eseshelve.splice(index, 1)
        $("#eselectshelve li").eq(index).remove()
    }
    var delseshelve = function(index) {
            window.seshelve.splice(index, 1)
            $("#selectshelve li").eq(index).remove()
        }
        //        $('#net_weightUnit').click(function () {
        //            $("#net_weightUnit1").attr('disabled', 'disabled');
        //        })
</script>
<script>
    //点击保存添加商品
    var funb = function() {
        if (imgAddress.length == 0) {
            alertify.alert('商品图片没有上传');
            return;
        }
        window.attrData = [];

        for (var i = 0; i < window.num; i++) {

            var attrText = [];

            $("input[name='attribute" + i + "']").each(function() {
                if ($(this).val() != '' || $(this).val().length != 0) {

                    attrText.push($(this).val());
                }
                //
                //                    if ($(this).val().length > 30) {
                //                        alertify.alert($(this).val() + '超过30个字');
                //                        return;
                //
                //                    }

            });

            //删除
            if (typeof $('#attr' + i).val() == 'undefined' || $('#attr' + i).val().length == 0) {
                continue;
            }
            if (attrText.length == 0) {
                alertify.alert($('#attr' + i).val() + '属性为空');
            }
            //
            //                if ($('#attr' + i).val().length > 30) {
            //                    alertify.alert($('#attr' + i).val() + '超过30个字');
            //                    return;
            //                }
            window.attrData.push({
                'name': $('#attr' + i).val(),
                'attr': attrText
            });
        }

        //                if(window.attrData.length == 0) {
        //                    alertify.alert('商品属性为空');
        //                }

        var datas = {
            'id': 1,
            'sku': $('#sku').val(),
            'inner_sku': $('#innersku').val(),
            'zn_name': $('#zn_name').val(),
            'en_name': $('#en_name').val(),
            'imgId': window.imgAddress,
            'en_editor': en_editor.txt.html(),
            'zn_editor': zn_editor.txt.html(),
            'summary': $('#summary').val(),
            'price': $('#price').val(),
            'one_price': $('#one_price').val(),
            'two_price': $('#two_price').val(),
            'three_price': $('#three_price').val(),
            'four_price': $('#four_price').val(),
            'category': $('#category').val(),
            'brand': $('#brand').val(),
            //                'shelves': $('#shelves').val(),
            'number': $('#number').val(),
            'weight': $('#weight').val(),
            'numberUnit': $('#numberUnit').val(),
            'weightUnit': $('#weightUnit').val(),
            'term': $('#term').val(),
            'status': $('#stat').val(),
            'attribute': attrData,
            //                'net_weight':$('#net_weight').val(),
            //                'net_weightUnit': $('#net_weightUnit').val(),
            '_token': '{{csrf_token()}}'
        };

        if (window.seshelve.length > 0)
            datas.shelves = window.seshelve;

        $.post('/product/establish', datas, function(res) {
            if (res.status) {
                alertify.success('创建商品成功');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                alertify.alert(res.message);
            }
        })
    }
</script>


<script>
    var arr = {
        'status': '{{$statusId}}',
        'category': '{{$categoryId}}',
        'brand': '{{$brandId}}',
        'limit': '{{$limitId}}',
    };

    //点击状态
    $('#status').on("click", function() {
        var event = $(this);
        $('#cstatus li a').on("click", function() {
            event.text($(this).attr('data-name'));
            arr.status = $(this).attr('data-data');
        })
    })

    //点击分类
    $('#fcategory').on("click", function() {
        var event = $(this);
        $('#ccategory li a').on("click", function() {
            event.text($(this).attr('data-name'));
            arr.category = $(this).attr('data-data');
        })
    })

    //点击品牌
    $('#fbrand').on("click", function() {
        var event = $(this);
        $('#cbrand li a').on("click", function() {
            event.text($(this).attr('data-name'));
            arr.brand = $(this).attr('data-data');
        })
    })

    var doPostSearch = function() {

        window.location.href = "/product/list/status/" + arr.status + "/category/" + arr.category + "/brand/" + arr.brand + "/limit/" + arr.limit;
    }
    var clean = function() {
        window.location.href = "/product/list/status/-1/category/-1/brand/-1/limit/5";
    }
</script>

<script>
    var url = window.location.pathname;
    strs = url.split("/");

    //替换status为1
    strs.splice(10, 1, 20);
    var vals = strs.join('/');
    $('#select').attr('href', vals);


    //替换status为1
    strs.splice(10, 1, 50);
    var val1 = strs.join('/');
    $('#select10').attr('href', val1);


    //替换status为1
    strs.splice(10, 1, 100);
    var val2 = strs.join('/');
    $('#select15').attr('href', val2);

    //
    //        //替换status为1
    //        strs.splice(10, 1, 20);
    //        var val3 = strs.join('/');
    //        $('#select20').attr('href', val3);
</script>

<script>
    //全选效果

    $("#all").click(function() {

        //判断全选框是不是checked效果
        if (this.checked) {
            //为所有的复选框加选中效果
            $("input[name='radio']").prop("checked", true);
            //$("input[name='radio']").attr("checked", true);会出现第一次能选中，再次全选中不好使的现象，可以亲身试验，我的印象很深刻

        } else {
            //取消所有复选框的选中效果
            $("input[name='radio']").removeAttr("checked", false);
        }
    });
</script>


<script>
    //上架
    $("#ups").click(function() {
            var data = filter();

            $.get('/product/up', {
                'arr': data
            }, function(res) {

                if (res.status) {
                    alertify.success("修改成功");
                    //取消所有复选框的选中效果
                    $("input[name='radio']").removeAttr("checked", false);
                    $("input[name='all']").removeAttr("checked", false);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        })
        //下架
    $("#downs").click(function() {

        var data = filter();

        $.get('/product/down', {
            'arr': data
        }, function(res) {

            if (res.status) {
                alertify.success("修改成功");
                //取消所有复选框的选中效果
                $("input[name='radio']").removeAttr("checked", false);
                $("input[name='all']").removeAttr("checked", false);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                alertify.alert(res.message);
            }
        })
    })

    var filter = function() {
            var data = [];
            $("input[name='radio']:checked").each(function() {
                data.push($(this).val());
            });

            if (data.length == 0) {
                alertify.alert('没有选择商品');
                return;
            }

            return data;
        }
        //删除
    var del = function(event) {

        alertify.confirm("确认框", function(e) {
            if (e) {

                $.get('/product/del', {
                    'id': $(event).attr('data-id')
                }, function(res) {

                    if (res.status) {
                        alertify.success("删除成功");
                        //取消所有复选框的选中效果
                        $("input[name='radio']").removeAttr("checked", false);
                        $("input[name='all']").removeAttr("checked", false);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alertify.alert(res.message);
                    }
                })
            }

        });
    }
</script>

<script>
    //某商品
    var edit = function(event) {
        data = []
        $('#eone_price').val('0.00');
        $('#etwo_price').val('0.00');
        $('#ethree_price').val('0.00');
        $('#efour_price').val('0.00');

        $.get('/modify', {
            'id': $(event).attr('data-id')
        }, function(res) {
            data = []
            if (res.status) {
                for (let i in res.data.res) {
                    if (res.data.res[i] != null) {
                        $('#e' + i).val(res.data.res[i]);
                    } else {
                        $('#e' + i).val('空');
                    }
                }
                if (res.data.distributor != null) {
                    for (let i in res.data.distributor) {
                        $('#e' + i).val(res.data.distributor[i]);
                    }
                }
                $('#ezn_describe p').html(res.data.res.zn_describe);
                $('#een_describe p').html(res.data.res.en_describe);


                if (res.data.res.status != 1) {
                    $('#estat').html('<option value="1">是</option> <option selected="selected"  value="2">否</option>');
                } else {

                    $('#estat').html('<option selected="selected" value="1">是</option> <option  value="2">否</option>');
                }

                var data1 = '';
                for (let i in res.data.category) {
                    if (res.data.category[i].pid.length > 0) {
                        data1 += `<option disabled="disabled" value="${res.data.category[i].id}">${res.data.category[i].zn_name}（${res.data.category[i].en_name}）</option>`;

                        for (let j in res.data.category[i].pid) {
                            if (res.data.category[i].pid[j].id != res.data.res.category_id) {
                                //
                                data1 += `<option value="${res.data.category[i].pid[j].id}">${res.data.category[i].pid[j].html}${res.data.category[i].pid[j].zn_name}（${res.data.category[i].pid[j].en_name}）</option>`;
                            } else {
                                data1 += `<option selected="selected"  value="${res.data.category[i].pid[j].id}">${res.data.category[i].pid[j].html}${res.data.category[i].pid[j].zn_name}（${res.data.category[i].pid[j].en_name}）</option>`;
                            }
                        }

                    } else {
                        data1 += `<option disabled="disabled" value="${res.data.category[i].id}">${res.data.category[i].zn_name}（${res.data.category[i].en_name}）</option>`;
                    }
                }
                $('#ecategory').html(data1);

                var data2 = '';
                for (let i in res.data.brand) {
                    if (res.data.brand[i].id != res.data.res.brand_id) {
                        data2 += `<option  value="${res.data.brand[i].id}">${res.data.brand[i].zn_name}（${res.data.brand[i].en_name}）</option>`;
                    } else {
                        data2 += `<option selected="selected" value="${res.data.brand[i].id}">${res.data.brand[i].zn_name}（${res.data.brand[i].en_name}）</option>`;
                    }
                }
                $('#ebrand').html(data2);


                var data3 = '';
                for (let i in res.data.number) {
                    if (res.data.number[i].unit != res.data.res.en_number) {
                        data3 += `<option  value="${res.data.number[i].name}|${res.data.number[i].unit}">${res.data.number[i].name}（${res.data.number[i].unit}）</option>`;
                    } else {
                        data3 += `<option selected="selected" value="${res.data.number[i].name}|${res.data.number[i].unit}">${res.data.number[i].name}（${res.data.number[i].unit}）</option>`;
                    }
                }
                $('#enumberUnit').html(data3);

                var data4 = '';
                for (let i in res.data.weight) {
                    if (res.data.weight[i].unit != res.data.res.en_weight) {
                        data4 += `<option  value="${res.data.weight[i].name}|${res.data.weight[i].unit}">${res.data.weight[i].name}（${res.data.weight[i].unit}）</option>`;
                    } else {
                        data4 += `<option selected="selected" value="${res.data.weight[i].name}|${res.data.weight[i].unit}">${res.data.weight[i].name}（${res.data.weight[i].unit}）</option>`;
                    }
                }

                $('#eweightUnit').html(data4);

                var data5 = '<option selected="selected" id="shelves11" value="">请选择商品所属货架</option>';
                for (let i in res.data.shelves) {
                    data5 += `<option  value="${res.data.shelves[i].id}">${res.data.shelves[i].name}（${res.data.shelves[i].number}）</option>`;
                }
                $('#eshelves').html(data5);
                //
                var data6 = '';
                for (let i in res.data.res.shelves) {
                    data6 += `<li>${res.data.res.shelves[i].name}，</li>`;
                }
                $('#eselectshelve').html(data6);
                //                    var data5 = '';
                //
                //                    for (let i in res.data.weight) {
                //                        if (res.data.weight[i].unit != res.data.res.en_net_weight) {
                //                            data5 += `<option  value="${res.data.weight[i].name}|${res.data.weight[i].unit}">${res.data.weight[i].name}（${res.data.weight[i].unit}）</option>`;
                //                        } else {
                //                            data5 += `<option selected="selected" value="${res.data.weight[i].name}|${res.data.weight[i].unit}">${res.data.weight[i].name}（${res.data.weight[i].unit}）</option>`;
                //                        }
                //                    }
                //
                //                    $('#enet_weightUnit').html(data5);

                var datas = [];
                var datas = `<input type="file"  name="img"  id="euploadfile" multiple class="file-loading"/>`;


                $('#control').html(datas);

                var data = [];
                for (let i in res.data.image) {
                    data.push(`<img class='file-preview-frame' data-fileindex='0' data-template='image' src='${res.data.image[i].link}'/>`);
                }

                showImage(res.data.res.id, data);

                $('#sa-save').attr('data-id', res.data.res.id);

                //属性
                window.enum = 0;
                for (let i in res.data.res.attr) {
                    $('#eaddProductId').append(`<div class="form-group col-md-12" style="margin-top: 20px" id = "edd${window.enum}"><div class="controls col-md-1">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            style="display: inline-block;margin-top: 10px" >操作
                                        <span class="caret"></span>
                                    </button>
                                        <ul class="dropdown-menu" role="menu">
                                        <li><a  onclick="eaddAttrBtn(this);" data-enum="${window.enum}" href="javascript:void(0);">添加</a></li>
                                        <li><a onclick="edelAttrBtn(this);" data-enum="${window.enum}" href="javascript:void(0);">删除</a></li>

                                    </ul>
                                    </div>
                                    <div class="controls col-md-2" style="display: inline-block;margin-top: 10px" >
                                        <input type="text"  id="eattr${window.enum}" class="form-control"
                                               value="${res.data.res.attr[i].name}" required="required"/>
                                    </div>
                                    <div id="einputWrapper${window.enum}" class="col-md-1"  style="display: inline-block;padding-top: 18px">
                                    ===>
                                    </div></div>`);
                    ++window.enum;
                }
                for (let j = 0; j < window.enum; j++) {
                    for (let i in res.data.res.attr[j].attr_value) {

                        $('#einputWrapper' + j).after(`<div class="col-md-2" style="display: inline-block;margin-top: 10px"><input type="text" name="eattribute${j}"  class="form-control" value="${res.data.res.attr[j].attr_value[i].name}" required="required"/>  </div>`);
                    }
                }


                $('#edit-product').modal('toggle');

            } else {
                alertify.alert('获取信息失败');
            }

        })

    }
</script>

<script>
    var showImage = function(ctrlName, eimage) {

        //            window.control = $('#euploadfile' + ctrlName);
        //添加编辑器
        window.eimgAddress = [];
        window.eimgId = '';
        $('#euploadfile').fileinput('refresh', {
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'], //接收的文件后缀
            initialPreview: eimage, //预览图片的设置

            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: true, //是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false, //是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 900, //图片的最大宽度
            maxImageHeight: 900, //图片的最大高度
            maxFileSize: 5120, //单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 5, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function(previewId, index) { //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}'
                };
                return data;
            }
        });

        //异步上传返回结果处理
        $('#euploadfile').on("fileuploaded", function(event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {

                window.eimgAddress.push(obj.data);
                alertify.alert('上传成功');
            }
        });
    }
</script>

<script>
    var efunb = function(event) {


        window.eattrData = [];

        for (var i = 0; i < window.enum; i++) {

            var eattrText = [];

            $("input[name='eattribute" + i + "']").each(function() {
                if ($(this).val() != '' || $(this).val().length != 0) {

                    eattrText.push($(this).val());
                }
                //                    if ($(this).val().length > 30) {
                //                        alertify.alert($(this).val() + '超过30个字');
                //
                //                        return;
                //                    }

            });

            //删除
            if (typeof $('#eattr' + i).val() == 'undefined' || $('#eattr' + i).val().length == 0) {
                continue;
            }
            if (eattrText.length == 0) {
                alertify.alert($('#eattr' + i).val() + '属性为空');
            }

            window.eattrData.push({
                'name': $('#eattr' + i).val(),
                'attr': eattrText
            });
        }


        var datas = {
            'id': $(event).attr('data-id'),
            'sku': $('#esku').val(),
            'inner_sku': $('#einnersku').val(),
            'term': $('#eterm').val(),
            'zn_name': $('#ezn_name').val(),
            'en_name': $('#een_name').val(),
            'imgId': window.eimgAddress,
            'en_editor': een_editor.txt.html(),
            'zn_editor': ezn_editor.txt.html(),
            'summary': $('#esummary').val(),
            'price': $('#eprice').val(),
            'one_price': $('#eone_price').val(),
            'two_price': $('#etwo_price').val(),
            'three_price': $('#ethree_price').val(),
            'four_price': $('#efour_price').val(),
            'category': $('#ecategory').val(),
            'brand': $('#ebrand').val(),
            //                'shelves': $('#eshelves').val(),
            'number': $('#enumber').val(),
            'weight': $('#eweight').val(),
            'status': $('#estat').val(),
            'numberUnit': $('#enumberUnit').val(),
            'weightUnit': $('#eweightUnit').val(),
            //                'net_weight':$('#enet_weight').val(),
            //                'net_weightUnit': $('#enet_weightUnit').val(),
            'attribute': window.eattrData,
            '_token': '{{csrf_token()}}'
        };
        if (window.eseshelve.length > 0)
            datas.shelves = window.eseshelve;
        //           console.log(window.eimgAddress);return;
        $.post('/product/revise', datas, function(res) {
            if (res.status) {
                alertify.success('修改商品成功');
                setTimeout(function() {
                    location.reload();
                }, 1500);

            } else {
                alertify.alert(res.message);
            }
        })
    }
</script>

<script>
    window.num = 0;
    $('#addProduct').click(function() {

        $('#addProductId').append(`<div class="form-group col-md-12" style="margin-top: 20px" id = "dd${window.num}"><div class="controls col-md-1">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            style="display: inline-block;margin-top: 10px" >操作
                                        <span class="caret"></span>
                                    </button>
                                        <ul class="dropdown-menu" role="menu">
                                        <li><a  onclick="addAttrBtn(this);" data-num="${window.num}" href="javascript:void(0);">添加</a></li>
                                        <li><a onclick="delAttrBtn(this);" data-num="${window.num}" href="javascript:void(0);">删除</a></li>

                                    </ul>
                                    </div>
                                    <div class="controls col-md-2" style="display: inline-block;margin-top: 10px" >
                                        <input type="text" name="attribute[]" id="attr${window.num}" class="form-control"
                                               value="" required="required"/>
                                    </div>
                                    <div id="inputWrapper${window.num}" class="col-md-1"  style="display: inline-block;padding-top: 18px">
                                    ===>
                                    </div></div>`);
        ++window.num;
    })

    var addAttrBtn = function(event) {

        $('#inputWrapper' + $(event).attr('data-num')).after(`<div class="col-md-2" style="display: inline-block;margin-top: 10px"><input type="text" name="attribute${$(event).attr('data-num')}"  class="form-control" value="" required="required"/>  </div>`);
    }

    //删除
    var delAttrBtn = function(event) {
        $('#dd' + $(event).attr('data-num')).remove();
        $("input[name='attribute" + $(event).attr('data-num') + "']").remove();
    }
</script>
{{--编辑--}}
<script>
    window.enum = 0;
    $('#eaddProduct').click(function() {

        $('#eaddProductId').append(`<div class="form-group col-md-12" style="margin-top: 20px" id = "edd${window.enum}"><div class="controls col-md-1">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            style="display: inline-block;margin-top: 10px" >操作
                                        <span class="caret"></span>
                                    </button>
                                        <ul class="dropdown-menu" role="menu">
                                        <li><a  onclick="eaddAttrBtn(this);" data-enum="${window.enum}" href="javascript:void(0);">添加</a></li>
                                        <li><a onclick="edelAttrBtn(this);" data-enum="${window.enum}" href="javascript:void(0);">删除</a></li>

                                    </ul>
                                    </div>
                                    <div class="controls col-md-2" style="display: inline-block;margin-top: 10px" >
                                        <input type="text"  id="eattr${window.enum}" class="form-control"
                                               value="" required="required"/>
                                    </div>
                                    <div id="einputWrapper${window.enum}" class="col-md-1"  style="display: inline-block;padding-top: 18px">
                                    ===>
                                    </div></div>`);
        ++window.enum;
    })

    var eaddAttrBtn = function(event) {

        $('#einputWrapper' + $(event).attr('data-enum')).after(`<div class="col-md-2" style="display: inline-block;margin-top: 10px"><input type="text" name="eattribute${$(event).attr('data-enum')}"  class="form-control" value="" required="required"/>  </div>`);
    }

    //删除
    var edelAttrBtn = function(event) {
        $('#edd' + $(event).attr('data-enum')).remove();
        $("input[name='eattribute" + $(event).attr('data-enum') + "']").remove();
    }
</script>

<script>
    //搜索库存
    function doSearch() {

        var search = $('#searchString').val().replace(/(^s*)|(s*$)/g, ""); //去除空格;

        if (search == '' || search == undefined || search == null || search.length == 0) {
            alertify.alert('搜索不能为空');
            return;
        }

        $.get('/api/product/search', {
            'search': search
        }, function(res) {

            if (res.status) {
                if (res.data.length == 0) {
                    alertify.alert('搜索不到数据');
                    return;
                } else {
                    var datas = '',
                        middle = '';

                    for (let i in res.data) {

                        middle = res.data[i].status == 1 ? '<td class="exce"><i class="icon fa fa-2x fa-check-circle"> </i> </td>' : '<td class="exce"><i class="icon fa fa-2x fa-times-circle"> </i> </td>';
                        datas += `<tr>
                        <td class="exce">
                                <div class="checkbox checkbox-success checkbox-inline">
                                <input type="checkbox" name="radio"
                            id="productCheckBox${res.data[i].id}"
                            value="{{ $item->id }}"/>
                                <label for="productCheckBox${res.data[i].id}">${res.data[i].zn_name}
                                <br/>${res.data[i].en_name}</label>
                                </div>
                                </td>
                         <td class="exce"><img height="100px; align=" middle"
                            src="${res.data[i].product_image}"
                            alt="没有上传"/>
                                </td>
                                  <td class="exce">${res.data[i].price }</td>
                                   <td class="exce">${res.data[i].category.zn_name }
                                <br/>${res.data[i].category.en_name }
                                </td>` +
                            middle +
                            `  <td class="exce">

                                <a title="查看信息" class="btn btn-success waves-effect waves-light"
                            href="javascript:void(0);" onclick="viewProduct(this);"
                            data-id="${res.data[i].id}"
                            data-name="${res.data[i].zn_name}（${res.data[i].en_name}）"
                            data-sku="${res.data[i].sku}"
                            data-innersku="${res.data[i].innersku}"
                            data-price="${res.data[i].price}"
                            data-oneprice="{{ empty($item->distributor->level_one_price) ? 0: $item->distributor->level_one_price}}"
                            data-twoprice="{{ empty($item->distributor->level_two_price) ? 0:  $item->distributor->level_two_price}}"
                            data-threeprice="{{ empty($item->distributor->level_three_price) ? 0:  $item->distributor->level_three_price}}"
                            data-fourprice="{{ empty($item->distributor->level_four_price) ? 0:  $item->distributor->level_four_price}}"
                            data-term="${res.data[i].term}"
                            data-stock="${res.data[i].stock}"
                            data-status="${res.data[i].status}"
                            data-summary="${res.data[i].summary}"
                            data-created_at="${res.data[i].created_at}"
                            data-category="${res.data[i].category.zn_name}（${res.data[i].category.en_name}）"
                            data-brand="${res.data[i].brand.zn_name}（${res.data[i].brand.en_name}）"
                            data-number="每箱数量${res.data[i].number}"
                            data-company="${res.data[i].zn_number}（${res.data[i].en_number}）"
                            data-weight=${res.data[i].weight}${res.data[i].zn_weight}（${res.data[i].en_weight}）"
                                    {{--data-netWeight="{{$item->net_weight}} 克（g）"--}}
                                        {{--  data-attr="{{$item->attr}} "--}}
                                    >
                                    <i class="fa fa-external-link"> </i>
                                    </a>
                                    <a title="修改信息" onclick="edit(this);" class="btn btn-small btn-info"
                                data-id="${res.data[i].id}"
                            href="javascript:void(0);">
                                <i class="icon fa fa-pencil"> </i>
                                </a>
                                <a title="删除" class="btn btn-small btn-danger"
                            href="javascript:void(0);" data-id="${res.data[i].id}"
                            onclick="del(this);">
                                <i class="icon fa fa-trash-o"> </i>
                            </a>
                            </td></tr>`;

                    }
                    $('#postContainer').html(datas);
                }
            } else {
                alertify.alert(res.message);
            }
        })
    }
</script>
@endsection