@extends('admin/layout.app')

@section('content')
    <!-- Page-Title -->

    <style>
        .portfolio-area {
            margin-right: -20px;
        }

        .portfolio-area li .portfoliobox {
            position: absolute;
            top: 0;
            left: 0;
            padding: 5px;
            border: solid 1px #eee;
            background-color: #fff;
        }

        .portfolio-area li .picbox {
            width: 150px;
            height: 150px;
            overflow: hidden;
            text-align: center;
            vertical-align: middle;
            display: table-cell;
            line-height: 150px;
        }

        .portfolio-area li {
            position: relative;
            float: left;
            margin-right: 20px;
            width: 162px;
            height: 162px;
            margin-top: 20px;
        }

        input[type="radio"], input[type="checkbox"] {
            line-height: normal;
            margin-top: -4px;
        }

        .portfolio-area li .picbox img {
            max-width: 150px;
            max-height: 150px;
            vertical-align: middle;
        }

        .portfolio-area li .checkbox {
            position: absolute;
            top: 10px;
            right: 5px;
            cursor: pointer;
        }

        ul, ol, dl {
            list-style-type: none;
        }

        .check {
            background: #EFEFEF;
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 5px 10px;
            margin-left: 1rem;
        }
    </style>
    <div id="bannerAdd" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">链接管理</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="url_name">链接地址</label>
                        <div class="controls">

                            <input type="text" data-url="" name="url_name" id="url_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="banner-save" data-id=""
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="uploadImg" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">热销产品上传图片</h4>
                </div>
                <div class="modal-body" id="pppxxx">

                    <!--<input type="file" name="img" id="uploadfileC" multiple class="file-loading"/>-->

                    <div>
                        <input type="file" data-id="1" data-width="999" data-height="999" name="img" id="uploadFileImg1"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ti1" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="1" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="2" data-width="999" data-height="999" name="img" id="uploadFileImg2"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ti2" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="2" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="3" data-width="999" data-height="999" name="img" id="uploadFileImg3"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ti3" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="3" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="4" data-width="999" data-height="999" name="img" id="uploadFileImg4"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ti4" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="4" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="5" data-width="999" data-height="999" name="img" id="uploadFileImg5"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ti5" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="5" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="6" data-width="999" data-height="999" name="img" id="uploadFileImg6"
                               multiple class="file-loading"/>
                        <div class="input-group" style="padding-top: 10px;padding-bottom: 20px;">
                            <input type="text" class="form-control" id="ti6" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="6" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="7" data-width="999" data-height="999" name="img" id="uploadFileImg7"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="ti7" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="7" onclick="tijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>--}}
                    {{--<button type="button" id="up-save" data-id=""--}}
                    {{--class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save--}}
                    {{--</button>--}}
                    {{--</div>--}}
                </div>
                <script type="text/javascript">
                    $("#pppxxx").children("div").css("padding", "10px 0")
                </script>
            </div>
        </div>
    </div>
    <div id="stuploadImg" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">热销产品上传图片</h4>
                </div>
                <div class="modal-body" id="pppxxx">

                    <!--<input type="file" name="img" id="uploadfileC" multiple class="file-loading"/>-->

                    <div>
                        <input type="file" data-id="8" data-width="999" data-height="999" name="img" id="stuploadFileImg8"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="stti8" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="8" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="9" data-width="999" data-height="999" name="img" id="stuploadFileImg9"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="stti9" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="9" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="10" data-width="999" data-height="999" name="img" id="stuploadFileImg10"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="stti10" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="10" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="11" data-width="999" data-height="999" name="img" id="stuploadFileImg11"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="stti11" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="11" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="12" data-width="999" data-height="999" name="img" id="stuploadFileImg12"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="stti12" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="12" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="13" data-width="999" data-height="999" name="img" id="stuploadFileImg13"
                               multiple class="file-loading"/>
                        <div class="input-group" style="padding-top: 10px;padding-bottom: 20px;">
                            <input type="text" class="form-control" id="stti13" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="13" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    <div>
                        <input type="file" data-id="14" data-width="999" data-height="999" name="img" id="stuploadFileImg14"
                               multiple class="file-loading"/>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 20px;">
                            <input type="text" class="form-control" id="stti7" placeholder="链接">
                            <span class="input-group-btn">
					        <button class="btn btn-default" data-id="14" onclick="sttijiao(this)" type="button">提交</button>
					      </span>
                        </div>
                    </div>
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>--}}
                    {{--<button type="button" id="up-save" data-id=""--}}
                    {{--class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save--}}
                    {{--</button>--}}
                    {{--</div>--}}
                </div>
                <script type="text/javascript">
                    $("#pppxxx").children("div").css("padding", "10px 0")
                </script>
            </div>
        </div>
    </div>
    <!-- 添加 Modal -->
    <div id="add-active" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">添加活动</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label" for="zn_name">活动名称（中）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="zn_name" id="zn_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="en_name">活动名称（英）（最多60字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="en_name" id="en_name"
                                   class="form-control"
                                   value="" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">能否删除<span
                                    class="red">＊</span></label>
                        <select class="form-control" id="del">
                            <option selected="selected" value="2">能</option>
                            <option value="1">否</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">添加活动头图<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="file" name="img" id="uploadfileC" multiple class="file-loading"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="sa-save" data-id=""
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="seeActivie" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="activieName"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <table class="table table-striped table-bordered" id="address">
                            {{--<thead>--}}
                            {{--<tr>--}}
                            {{--<th class=" col-md-2 col-lg-2 exce"> 序号</th>--}}
                            {{--<th class=" col-md-4 col-lg-4 exce"> 商品名称</th>--}}
                            {{--<th class="col-md-6 col-lg-6 exce"> 商品图片</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody id="address">--}}

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addProduct" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 800px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">添加活动</h4>
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
                        <label>所属活动 :
                        </label>
                        <div id="checkBox"></div>
                    </div>
                    {{--点击精品推荐--}}
                    <div id="hotRecommend" style="display: none;">
                        <div class="btn-group" style="padding-bottom:10px ">
                            <label>精品推荐所属分类 : </label>
                            <br>

                            <button id="fcategory1" type="button" class="btn btn-primary dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-expanded="true">全部分类 <span class="caret"></span>
                            </button>
                            @if (count($category) > 9)
                                <ul id="ccategory" class="dropdown-menu" role="menu"
                                    style="height:300px; overflow-y:scroll;">
                                    @else
                                        <ul id="ccategory1" class="dropdown-menu" role="menu">
                                            @endif
                                            <li><a data-data="-1" data-name="全部分类"
                                                   href="javascript:void(0);">全部分类</a></li>
                                            @foreach ($category as $items)
                                                @if (!empty($items['pid']))

                                                    <li style="pointer-events:none; "><a
                                                                href="javascript:void(0);"
                                                                data-data="{{$items['id']}}"
                                                                data-name="{{$items['zn_name']}}
                                                                        （{{ $items['en_name'] }}）">{{$items['zn_name']}}
                                                            （{{ $items['en_name'] }}）
                                                        </a></li>

                                                    @foreach ($items['pid'] as $v)
                                                        <li><a href="javascript:void(0);"
                                                               data-data="{{$v['id']}}"
                                                               data-name="{{$v['zn_name']}}
                                                                       （{{ $v['en_name'] }}）">{{$v['html']}}{{$v['zn_name']}}
                                                                （{{ $v['en_name'] }}）
                                                            </a></li>
                                                    @endforeach
                                                @else
                                                    <li style="pointer-events:none; "><a
                                                                href="javascript:void(0);"
                                                                data-data="{{$items['id']}}"
                                                                data-name="{{$items['zn_name']}}
                                                                        （{{ $items['en_name'] }}）">{{$items['zn_name']}}
                                                            （{{ $items['en_name'] }}）
                                                        </a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="activeAdd" data-id="" onclick="activeAdd(this);"
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 编辑 Modal -->

    <div id="edit" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 800px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑活动</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="ezn_name">活动名称（中）（最多50字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="ezn_name" id="ezn_name"
                                   class="form-control"
                                   value="" required="required"/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="een_name">活动名称（英）（最多60字）<span
                                    style="color:red;">＊</span></label>
                        <div class="controls">
                            <input type="text" name="een_name" id="een_name"
                                   class="form-control"
                                   value="" required="required"/>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">活动头图</label>
                        <div class="controls">
                            <input type="file" name="img" id="uploadfileE" multiple class="file-loading"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" id="edit-save" data-id="" onclick="efunb(this);"
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">内容管理</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Admin Panel</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">首页内容</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">首页内容</h3></div>
            <div class="panel-body">
                <!-- Start Form -->

                <div class="form-group">
                    <ul id="myTab" class="nav nav-tabs navtab-bg ">
                        <li class="active">
                            <a href="#activite" data-toggle="tab">添加活动</a>
                        </li>
                        <li>
                            <a href="#Sowing" data-toggle="tab">app首页轮播图</a>
                        </li>
                        <li>
                            <a href="#pcSowing" data-toggle="tab">pc首页轮播图</a>
                        </li>
                        <li>
                            <a href="#theme" data-toggle="tab">活动列表</a>
                        </li>
                        <li>
                            <a href="#STactivite" data-toggle="tab">ST-活动列表</a>
                        </li>
                        <li>
                            <a href="#STappSowing" data-toggle="tab">STapp-首页轮播图</a>
                        </li>
                        <li>
                            <a href="#STwebSowing" data-toggle="tab">STweb-首页轮播图</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade " id="Sowing">
                            <div class="panel-footer">
                                <a style="background-color: #dd514c;" href="javascript:void(0);" id="delete_btn"
                                   class="btn btn-danger radius"><i class="icon fa fa-trash"></i> 批量删除</a>
                            </div>
                            <div class="form-group" style="overflow: hidden;">
                                <ul class="cl portfolio-area">

                                    @foreach ($data as $item)
                                        <li class="item">
                                            <div class="portfoliobox">
                                                <input id="{{ $item["id"] }}" class="checkbox" name="image_input"
                                                       type="checkbox"
                                                       value="{{ $item["id"] }}">
                                                <div class="picbox" style="line-height:0">
                                                    <label for="{{ $item["id"] }}"> <img style="padding: 20px 0;"
                                                                                         src='{{$item["img"]["url"]}}'>
                                                        <button data-toggle="modal" data-id="{{ $item["id"] }}"
                                                                data-url="{{ $item["url"] }}"
                                                                onclick="edit(this);"
                                                                class="btn btn-info dropdown-toggle">轮播图链接
                                                        </button>
                                                    </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="padding-left: 0;padding-top:8px; ">添加轮播图（最多5张图片）</label>
                                <div class="controls">
                                    <input type="file" name="img" id="uploadfile" multiple class="file-loading"/>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade " id="pcSowing">
                            <div class="panel-footer">
                                <a style="background-color: #dd514c;" href="javascript:void(0);" id="delete_btn1"
                                   class="btn btn-danger radius"><i class="icon fa fa-trash"></i> 批量删除</a>
                            </div>
                            <div class="form-group" style="overflow: hidden;">
                                <ul class="cl portfolio-area">

                                    @foreach ($pc as $item)
                                        <li class="item">
                                            <div class="portfoliobox">
                                                <input id="{{ $item["id"] }}" class="checkbox" name="image_input1"
                                                       type="checkbox"
                                                       value="{{ $item["id"] }}">
                                                <div class="picbox" style="line-height:0">
                                                    <label for="{{ $item["id"] }}"> <img style="padding: 20px 0;"
                                                                                         src='{{$item["img"]["url"]}}'>
                                                        <button data-toggle="modal" data-id="{{ $item["id"] }}"
                                                                data-url="{{ $item["url"] }}"
                                                                onclick="edit(this);"
                                                                class="btn btn-info dropdown-toggle">轮播图链接
                                                        </button>
                                                    </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="padding-left: 0;padding-top:8px; ">添加轮播图（最多5张图片）</label>
                                <div class="controls">
                                    <input type="file" name="img" id="uploadfile1" multiple class="file-loading"/>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade in active" id="activite">
                            <div class="row">
                                <div class="col-sm-3">

                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-3">
                                    <div class="input-group ">
                                        <div class="btn-group">
                                            <button id="fcategory1" type="button"
                                                    class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-expanded="true">{{$categoryVal}} <span class="caret"></span>
                                            </button>
                                            @if (count($category) > 9)
                                                <ul id="ccategory1" class="dropdown-menu" role="menu"
                                                    style="height:300px; overflow-y:scroll;">
                                                    @else
                                                        <ul id="ccategory1" class="dropdown-menu" role="menu">
                                                            @endif
                                                            <li><a data-data="-1" data-name="全部分类"
                                                                   href="javascript:void(0);">全部分类</a></li>
                                                            @foreach ($category as $items)
                                                                @if (!empty($items['pid']))

                                                                    <li style="pointer-events:none; "><a
                                                                                href="javascript:void(0);"
                                                                                data-data="{{$items['id']}}"
                                                                                data-name="{{$items['zn_name']}}
                                                                                        （{{ $items['en_name'] }}）">{{$items['zn_name']}}
                                                                            （{{ $items['en_name'] }}）
                                                                        </a></li>

                                                                    @foreach ($items['pid'] as $v)
                                                                        <li><a href="javascript:void(0);"
                                                                               data-data="{{$v['id']}}"
                                                                               data-name="{{$v['zn_name']}}
                                                                                       （{{ $v['en_name'] }}）">{{$v['html']}}{{$v['zn_name']}}
                                                                                （{{ $v['en_name'] }}）
                                                                            </a></li>
                                                                    @endforeach
                                                                @else
                                                                    <li style="pointer-events:none; "><a
                                                                                href="javascript:void(0);"
                                                                                data-data="{{$items['id']}}"
                                                                                data-name="{{$items['zn_name']}}
                                                                                        （{{ $items['en_name'] }}）">{{$items['zn_name']}}
                                                                            （{{ $items['en_name'] }}）
                                                                        </a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                        </div>
                                        <div class="btn-group">
                                            <button id="fbrand" type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-expanded="true">{{$brandVal}} <span class="caret"></span>
                                            </button>
                                            @if (count($brand) > 9)
                                                <ul id="cbrand" class="dropdown-menu" role="menu"
                                                    style="height:300px; overflow-y:scroll;">
                                                    @else
                                                        <ul id="ccategory" class="dropdown-menu" role="menu">
                                                            @endif
                                                            <li><a data-data="-1" data-name="全部品牌"
                                                                   href="javascript:void(0);">全部品牌</a></li>
                                                            @foreach ($brand as $items)
                                                                <li>
                                                                    <a data-data="{{$items->id}}"
                                                                       data-name="{{$items->zn_name}}
                                                                               （{{ $items->en_name }}）"
                                                                       href="javascript:void(0);">{{$items->zn_name}}
                                                                        （{{ $items->en_name }}）</a></li>
                                                            @endforeach
                                                        </ul>
                                        </div>
                                        <div class="btn-group">
                                            <button id="status" type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-expanded="true">{{$status}} <span class="caret"></span>
                                            </button>
                                            <ul id="cstatus" class="dropdown-menu" role="menu">
                                                <li><a data-data="-1" data-name="全部状态"
                                                       href="javascript:void(0);">全部状态</a></li>
                                                <li><a data-data="1" data-name="上架" href="javascript:void(0);">上架</a>
                                                </li>
                                                <li><a data-data="2" data-name="下架" href="javascript:void(0);">下架</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="btn-group ">
                                            <button class="btn waves-effect waves-light btn-primary" type="button"
                                                    id="searchBtn"
                                                    onClick="doPostSearch();"><span
                                                        class="fa fa-search"></span></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">商品列表</h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row">

                                            <div class="btn-group col-md-2">
                                                <button type="button" class="btn btn-info dropdown-toggle"
                                                        data-toggle="dropdown"
                                                        aria-expanded="true">{{$limit}} <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a id="select" href="">5条</a></li>
                                                    <li><a id="select10" href="">10条</a></li>
                                                    <li><a id="select15" href="">15条</a></li>
                                                    <li><a id="select20" href="">20条</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-8"></div>

                                            <div class="btn-group col-md-2">
                                                {{--<button type="button" class="btn btn-info dropdown-toggle waves-effect"--}}
                                                {{--data-toggle="dropdown" aria-expanded="false">批量操作--}}
                                                {{--<span class="caret"></span>--}}
                                                {{--</button>--}}
                                                {{--<ul class="dropdown-menu" role="menu">--}}
                                                {{--<li><a href="javascript:void();" id="up">全部上架</a></li>--}}
                                                {{--<li><a href="javascript:void();" id="down">全部下架</a></li>--}}
                                                {{--</ul>--}}
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-2 col-lg-2 exce"> 商品名称</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 商品图片</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 分类</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 品牌</th>
                                                        <th class="col-md-2 col-lg-2 exce"> 所属活动</th>
                                                        <th class="col-md-1 col-lg-1 exce"> 状态</th>
                                                        <th class="col-md-1 col-lg-1 exce" class="td-actions"> 操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="postContainer">
                                                    @foreach ($product as $item)
                                                        <tr>

                                                            <td class="exce">{{ $item->zn_name }}
                                                                <br/>{{ $item->en_name }}</td>
                                                            <td class="exce"><img height="100px; align=" middle"
                                                                src="{{ $item->product_image }}"
                                                                alt="没有上传"/>
                                                            </td>

                                                            <td class="exce">{{ $item->category->zn_name}}
                                                                <br/>{{ $item->category->en_name }}
                                                            </td>
                                                            <td class="exce">{{ $item->brand->zn_name}}
                                                                <br/>{{ $item->brand->en_name }}
                                                            </td>

                                                            <td class="exce ">
                                                                @foreach ($item->products as $v)
                                                                    <span style="display: inline-block;"
                                                                          class="check"> {{ $v->zn_name}} </span>
                                                                    <br/>
                                                                @endforeach
                                                            </td>

                                                            @if ($item->status == 1)
                                                                <td class="exce"><i
                                                                            class="icon fa fa-2x fa-check-circle"> </i>
                                                                </td>
                                                            @else
                                                                <td class="exce"><i
                                                                            class="icon fa fa-2x fa-times-circle"> </i>
                                                                </td>
                                                            @endif
                                                            <td class="exce">

                                                                <a title="查看信息"
                                                                   class="btn btn-success waves-effect waves-light"
                                                                   href="javascript:void(0);"
                                                                   onclick="addProduct(this);"
                                                                   data-id="{{$item->id}}"
                                                                   data-product="{{$item->products}}"
                                                                   data-name="{{ $item->zn_name }}（{{ $item->en_name }}）"
                                                                   data-sku="{{ $item->sku }}"
                                                                >
                                                                    <i class="fa fa-plus-square"> </i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div style="clear: both;text-align: center;">
                                                    {{ $product->links() }}
                                                </div>
                                            </div>
                                            @if(!$product->count())
                                                <div class="col-md-12" style="text-align: center;">暂时没有数据</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade " id="theme">
                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="button" class="btn waves-effect waves-light btn-primary"
                                            data-toggle="modal"
                                            data-target="#add-active">
                                        <i class="fa fa-plus"></i> Add
                                    </button>


                                </div>

                            </div>
                            <div class="row m-t-30">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">活动列表</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="btn-group col-md-2">
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-3 col-lg-3 exce"> 活动名称</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 活动头图</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 创建时间</th>
                                                        <th class="col-md-3 col-lg-3 exce" class="td-actions"> 操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="postContainer">
                                                    @foreach ($theme as $item)
                                                        <tr>
                                                            <?php
                                                            if ($item->id == 6)
                                                                continue;
                                                            ?>

                                                            <td class="exce">{{ $item->zn_name }}</br>{{ $item->en_name }} </td>
                                                            <td class="exce"><img height="100px; align=" middle"
                                                                src="{{ $item->head_image_id }}"
                                                                alt="没有上传"/>
                                                            </td>
                                                            <td class="exce">{{ $item->created_at }} </td>
                                                            <td class="exce">
                                                                <a title="查看" class="btn btn-small btn-success"
                                                                   href="javascript:void(0);" data-id="{{$item->id}}"
                                                                   data-name="{{ $item->zn_name }}"
                                                                   onclick="see(this);">
                                                                    <i class="icon fa fa-bars"> </i>
                                                                </a>
                                                                <a title="修改信息" onclick="actionedit(this);"
                                                                   class="btn btn-small btn-info"
                                                                   data-id="{{$item->id}}"
                                                                   data-zname="{{$item->zn_name}}"
                                                                   data-ename="{{$item->en_name}}"
                                                                   data-img="{{$item->head_image_id}}"
                                                                   href="javascript:void(0);">
                                                                    <i class="icon fa fa-pencil"> </i>
                                                                </a>
                                                                @if($item->id == 2)
                                                                    <a title="上传" class="btn btn-small btn-success"
                                                                       data-toggle="modal" data-target="#uploadImg"
                                                                       href="javascript:void(0);"
                                                                       data-id="{{$item->id}}"
                                                                    >
                                                                        <i class="icon fa fa-television"> </i>
                                                                    </a>
                                                                @endif
                                                                @if($item->status != 1)
                                                                    {{--<a title="删除" class="btn btn-small btn-danger" disabled="disabled"--}}
                                                                    {{--href="javascript:return false;" data-id="{{$item->id}}"--}}
                                                                    {{--onclick="return false;" style="cursor: not-allowed;">--}}
                                                                    {{--<i class="icon fa fa-trash-o"> </i>--}}
                                                                    {{--</a>--}}
                                                                    <a title="删除" class="btn btn-small btn-danger"
                                                                       href="javascript:void(0);"
                                                                       data-id="{{$item->id}}"
                                                                       onclick="del(this);">
                                                                        <i class="icon fa fa-trash-o"> </i>
                                                                    </a>
                                                                @endif

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="STactivite">
                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="button" class="btn waves-effect waves-light btn-primary"
                                            data-toggle="modal"
                                            data-target="#add-active">
                                        <i class="fa fa-plus"></i> Add
                                    </button>


                                </div>

                            </div>
                            <div class="row m-t-30">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">ST-活动列表</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="btn-group col-md-2">
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-3 col-lg-3 exce"> 活动名称</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 活动头图</th>
                                                        <th class="col-md-3 col-lg-3 exce"> 创建时间</th>
                                                        <th class="col-md-3 col-lg-3 exce" class="td-actions"> 操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="postContainer">
                                                    @foreach ($sttheme as $item)
                                                        <tr>


                                                            <td class="exce">{{ $item->zn_name }}</br>{{ $item->en_name }} </td>
                                                            <td class="exce"><img height="100px; align=" middle"
                                                                src="{{ $item->head_image_id }}"
                                                                alt="没有上传"/>
                                                            </td>
                                                            <td class="exce">{{ $item->created_at }} </td>
                                                            <td class="exce">
                                                                <a title="查看" class="btn btn-small btn-success"
                                                                   href="javascript:void(0);" data-id="{{$item->id}}"
                                                                   data-name="{{ $item->zn_name }}"
                                                                   onclick="see(this);">
                                                                    <i class="icon fa fa-bars"> </i>
                                                                </a>
                                                                <a title="修改信息" onclick="actionedit(this);"
                                                                   class="btn btn-small btn-info"
                                                                   data-id="{{$item->id}}"
                                                                   data-zname="{{$item->zn_name}}"
                                                                   data-ename="{{$item->en_name}}"
                                                                   data-img="{{$item->head_image_id}}"
                                                                   href="javascript:void(0);">
                                                                    <i class="icon fa fa-pencil"> </i>
                                                                </a>
                                                                @if($item->id == 8)
                                                                    <a title="上传" class="btn btn-small btn-success"
                                                                       data-toggle="modal" data-target="#stuploadImg"
                                                                       href="javascript:void(0);"
                                                                       data-id="{{$item->id}}"
                                                                    >
                                                                        <i class="icon fa fa-television"> </i>
                                                                    </a>
                                                                @endif
                                                                {{--@if($item->status != 1)--}}
                                                                    {{--<a title="删除" class="btn btn-small btn-danger" disabled="disabled"--}}
                                                                    {{--href="javascript:return false;" data-id="{{$item->id}}"--}}
                                                                    {{--onclick="return false;" style="cursor: not-allowed;">--}}
                                                                    {{--<i class="icon fa fa-trash-o"> </i>--}}
                                                                    {{--</a>--}}
                                                                    {{--<a title="删除" class="btn btn-small btn-danger"--}}
                                                                       {{--href="javascript:void(0);"--}}
                                                                       {{--data-id="{{$item->id}}"--}}
                                                                       {{--onclick="del(this);">--}}
                                                                        {{--<i class="icon fa fa-trash-o"> </i>--}}
                                                                    {{--</a>--}}
                                                                {{--@endif--}}

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="STappSowing">
                            <div class="panel-footer">
                                <a style="background-color: #dd514c;" href="javascript:void(0);" id="delete_btn2"
                                   class="btn btn-danger radius"><i class="icon fa fa-trash"></i> 批量删除</a>
                            </div>
                            <div class="form-group" style="overflow: hidden;">
                                <ul class="cl portfolio-area">

                                    @foreach ($stapp as $item)
                                        <li class="item">
                                            <div class="portfoliobox">
                                                <input id="{{ $item["id"] }}" class="checkbox" name="image_input2"
                                                       type="checkbox"
                                                       value="{{ $item["id"] }}">
                                                <div class="picbox" style="line-height:0">
                                                    <label for="{{ $item["id"] }}"> <img style="padding: 20px 0;"
                                                                                         src='{{$item["img"]["url"]}}'>
                                                        <button data-toggle="modal" data-id="{{ $item["id"] }}"
                                                                data-url="{{ $item["url"] }}"
                                                                onclick="edit(this);"
                                                                class="btn btn-info dropdown-toggle">STapp-首页轮播图
                                                        </button>
                                                    </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="padding-left: 0;padding-top:8px; ">添加轮播图（最多5张图片）</label>
                                <div class="controls">
                                    <input type="file" name="img" id="uploadfile2" multiple class="file-loading"/>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade " id="STwebSowing">
                            <div class="panel-footer">
                                <a style="background-color: #dd514c;" href="javascript:void(0);" id="delete_btn3"
                                   class="btn btn-danger radius"><i class="icon fa fa-trash"></i> 批量删除</a>
                            </div>
                            <div class="form-group" style="overflow: hidden;">
                                <ul class="cl portfolio-area">

                                    @foreach ($stpc as $item)
                                        <li class="item">
                                            <div class="portfoliobox">
                                                <input id="{{ $item["id"] }}" class="checkbox" name="image_input3"
                                                       type="checkbox"
                                                       value="{{ $item["id"] }}">
                                                <div class="picbox" style="line-height:0">
                                                    <label for="{{ $item["id"] }}"> <img style="padding: 20px 0;"
                                                                                         src='{{$item["img"]["url"]}}'>
                                                        <button data-toggle="modal" data-id="{{ $item["id"] }}"
                                                                data-url="{{ $item["url"] }}"
                                                                onclick="edit(this);"
                                                                class="btn btn-info dropdown-toggle">STweb-首页轮播图
                                                        </button>
                                                    </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="padding-left: 0;padding-top:8px; ">添加轮播图（最多5张图片）</label>
                                <div class="controls">
                                    <input type="file" name="img" id="uploadfile3" multiple class="file-loading"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>

        //添加编辑器
        window.imgAddress = '';
        $("#uploadfile").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
            ],
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 1600,//图片的最大宽度
            maxImageHeight: 900,//图片的最大高度
            //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 5, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function (previewId, index) {   //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}',
                    'status': 1
                };
                return data;
            }
        });
        //异步上传返回结果处理
        $("#uploadfile").on("fileuploaded", function (event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {
                imgAddress = obj.data;
                alertify.alert('上传成功');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        });

        $("#uploadfile1").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
            ],
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 1600,//图片的最大宽度
            maxImageHeight: 900,//图片的最大高度
            //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 5, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function (previewId, index) {   //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}',
                    'status': 2
                };
                return data;
            }
        });
        //异步上传返回结果处理
        $("#uploadfile1").on("fileuploaded", function (event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {
                imgAddress = obj.data;
                alertify.alert('上传成功');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        });

        $("#uploadfile2").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
            ],
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 1600,//图片的最大宽度
            maxImageHeight: 900,//图片的最大高度
            //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 5, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function (previewId, index) {   //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}',
                    'status': 3
                };
                return data;
            }
        });
        //异步上传返回结果处理
        $("#uploadfile2").on("fileuploaded", function (event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {
                imgAddress = obj.data;
                alertify.alert('上传成功');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        });

        $("#uploadfile3").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
            ],
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 1600,//图片的最大宽度
            maxImageHeight: 900,//图片的最大高度
            //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 5, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function (previewId, index) {   //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}',
                    'status': 4
                };
                return data;
            }
        });
        //异步上传返回结果处理
        $("#uploadfile3").on("fileuploaded", function (event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {
                imgAddress = obj.data;
                alertify.alert('上传成功');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        });
    </script>


    <script>

        //添加编辑器
        window.cimgAddress = '';
        $("#uploadfileC").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "/imgHandle", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            initialPreview: [ //预览图片的设置
            ],
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showPreview: true, //是否显示预览+
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            maxImageWidth: 19999,//图片的最大宽度
            maxImageHeight: 19999,//图片的最大高度
            //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 1, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount: true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
            //传递参数
            uploadExtraData: function (previewId, index) {   //额外参数的关键点
                var data = {
                    '_token': '{{csrf_token()}}',
                };
                return data;
            }
        });
        //异步上传返回结果处理
        $("#uploadfileC").on("fileuploaded", function (event, data) {
            var obj = data.response;

            if (obj.errno == 1) {
                alertify.alert(obj.data[0]);
                return;
            } else {
                cimgAddress = obj.data;
                alertify.alert('上传成功');
            }
        });
    </script>

    <script>

        var img = function (arr) {

            //添加编辑器
            window.EimgAddress = '';

            $("#uploadfileE").fileinput('refresh', {
                language: 'zh', //设置语言
                uploadUrl: "/imgHandle", //上传的地址
                allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
                initialPreview: arr,
                uploadAsync: true, //默认异步上传
                showUpload: true, //是否显示上传按钮
                showRemove: true, //显示移除按钮
                showPreview: true, //是否显示预览+
                showCaption: false,//是否显示标题
                browseClass: "btn btn-primary", //按钮样式
                dropZoneEnabled: false,//是否显示拖拽区域
                //minImageWidth: 50, //图片的最小宽度
                //minImageHeight: 50,//图片的最小高度
                maxImageWidth: 900,//图片的最大宽度
                maxImageHeight: 900,//图片的最大高度
                //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
                //minFileCount: 0,
                maxFileCount: 1, //表示允许同时上传的最大文件个数
                enctype: 'multipart/form-data',
                validateInitialCount: true,
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
                msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
                //传递参数
                uploadExtraData: function (previewId, index) {   //额外参数的关键点
                    var data = {
                        '_token': '{{csrf_token()}}',
                    };
                    return data;
                }
            });
//            $('#uploadfileE').fileinput('clear');
            //异步上传返回结果处理
            $("#uploadfileE").on("fileuploaded", function (event, data) {
                var obj = data.response;

                if (obj.errno == 1) {
                    alertify.alert(obj.data[0]);
                    return;
                } else {
                    EimgAddress = obj.data;
                    alertify.alert('上传成功');
                }
            });
        }
    </script>
    <script>
        $('#delete_btn').click(function () {
            alertify.confirm("确认删除吗？", function (e) {
                if (e) {
                    var arr = [];
                    $('input[name=image_input]:checked').each(function () {

                        arr.push($(this).val());
                    });

                    if (arr.length == 0) {
                        alertify.alert('没有选择任何一张图片');
                        return;
                    }
                    $.get('/content/del', {'arr': arr}, function (res) {

                        if (res.status) {
                            alertify.success('删除成功');
                            $("input[name='image_input']").removeAttr("checked", false);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            alertify.alert(res.message);
                        }

                    });
                }
            });
        });

        $('#delete_btn1').click(function () {
            alertify.confirm("确认删除吗？", function (e) {
                if (e) {
                    var arr = [];
                    $('input[name=image_input1]:checked').each(function () {

                        arr.push($(this).val());
                    });

                    if (arr.length == 0) {
                        alertify.alert('没有选择任何一张图片');
                        return;
                    }
                    $.get('/content/del', {'arr': arr}, function (res) {

                        if (res.status) {
                            alertify.success('删除成功');
                            $("input[name='image_input1']").removeAttr("checked", false);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            alertify.alert(res.message);
                        }

                    });
                }
            });
        });
        $('#delete_btn2').click(function () {
            alertify.confirm("确认删除吗？", function (e) {
                if (e) {
                    var arr = [];
                    $('input[name=image_input2]:checked').each(function () {

                        arr.push($(this).val());
                    });

                    if (arr.length == 0) {
                        alertify.alert('没有选择任何一张图片');
                        return;
                    }
                    $.get('/content/del', {'arr': arr}, function (res) {

                        if (res.status) {
                            alertify.success('删除成功');
                            $("input[name='image_input2']").removeAttr("checked", false);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            alertify.alert(res.message);
                        }

                    });
                }
            });
        });
        $('#delete_btn3').click(function () {
            alertify.confirm("确认删除吗？", function (e) {
                if (e) {
                    var arr = [];
                    $('input[name=image_input3]:checked').each(function () {

                        arr.push($(this).val());
                    });

                    if (arr.length == 0) {
                        alertify.alert('没有选择任何一张图片');
                        return;
                    }
                    $.get('/content/del', {'arr': arr}, function (res) {

                        if (res.status) {
                            alertify.success('删除成功');
                            $("input[name='image_input3']").removeAttr("checked", false);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            alertify.alert(res.message);
                        }

                    });
                }
            });
        });

    </script>

    <script>

        var arr = {
            'status': '{{$statusId}}',
            'category': '{{$categoryId}}',
            'brand': '{{$brandId}}',
            'limit': '{{$limitId}}',
        };

        //点击状态
        $('#status').on("click", function () {
            var event = $(this);
            $('#cstatus li a').on("click", function () {
                event.text($(this).attr('data-name'));
                arr.status = $(this).attr('data-data');
            })
        })

        //点击分类
        $('#fcategory').on("click", function () {
            var event = $(this);
            $('#ccategory li a').on("click", function () {
                event.text($(this).attr('data-name'));
                arr.category = $(this).attr('data-data');
            })
        })

        window.status = -1;

        $('#fcategory1').on("click", function () {
            var event = $(this);
            $('#ccategory1 li a').on("click", function () {
                event.text($(this).attr('data-name'));
                window.status = $(this).attr('data-data');
            })
        })

        //点击品牌
        $('#fbrand').on("click", function () {
            var event = $(this);
            $('#cbrand li a').on("click", function () {
                event.text($(this).attr('data-name'));
                arr.brand = $(this).attr('data-data');
            })
        })

        var doPostSearch = function () {

            window.location.href = "/content/home/status/" + arr.status + "/category/" + arr.category + "/brand/" + arr.brand + "/limit/" + arr.limit;
        }
        var clean = function () {
            window.location.href = "/content/home/status/-1/category/-1/brand/-1/limit/5";
        }
    </script>

    <script>

        var url = window.location.pathname;
        strs = url.split("/");

        //替换status为1
        strs.splice(10, 1, 5);
        var vals = strs.join('/');
        $('#select').attr('href', vals);


        //替换status为1
        strs.splice(10, 1, 10);
        var val1 = strs.join('/');
        $('#select10').attr('href', val1);


        //替换status为1
        strs.splice(10, 1, 15);
        var val2 = strs.join('/');
        $('#select15').attr('href', val2);


        //替换status为1
        strs.splice(10, 1, 20);
        var val3 = strs.join('/');
        $('#select20').attr('href', val3);

    </script>

    <script>
        //显示
        var actionedit = function (event) {
//            $('#uploadfileE').attr('id','uploadfileE'+$(event).attr('data-id'));
            $('#ezn_name').val($(event).attr('data-zname'));
            $('#een_name').val($(event).attr('data-ename'));
            var image = [];
            image.push(`<img class='file-preview-frame' data-fileindex='0' data-template='image' src='${$(event).attr('data-img')}'/>`);
            img(image);
            $('#edit-save').attr('data-id', $(event).attr('data-id'));
            $('#edit').modal('toggle');
        }
        //修改
        var efunb = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'zn_name': $('#ezn_name').val(),
                'en_name': $('#een_name').val(),
                'img': EimgAddress,
                '_token': '{{csrf_token()}}'
            };

            $.post('/activity/modify', datas, function (res) {
                if (res.status) {
                    alertify.success('修改活动成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }

        //删除
        var del = function (event) {

            alertify.confirm("确认框", function (e) {
                if (e) {

                    $.get('/activity/del', {'id': $(event).attr('data-id')}, function (res) {

                        if (res.status) {
                            alertify.success("删除成功");

                            setTimeout(function () {
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
        //点击添加
        $('#sa-save').click(function () {

            if (!cimgAddress) {
                alertify.alert('图片没有上传');
                return;
            }

            var datas = {
                'id': 1,
                'zn_name': $('#zn_name').val(),
                'en_name': $('#en_name').val(),
                'status': $('#del').val(),
                'img': cimgAddress,
                '_token': '{{csrf_token()}}'
            };

            $.post('/article/add', datas, function (res) {
                if (res.status) {
                    alertify.success('创建活动成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })

        })

        $('#sa-stsave').click(function () {

            if (!cimgAddress) {
                alertify.alert('图片没有上传');
                return;
            }

            var datas = {
                'id': 1,
                'zn_name': $('#zn_name').val(),
                'en_name': $('#en_name').val(),
                'status': $('#del').val(),
                'img': cimgAddress,
                'type': 2,
                '_token': '{{csrf_token()}}'
            };

            $.post('/article/add', datas, function (res) {
                if (res.status) {
                    alertify.success('创建活动成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })

        })
    </script>

    <script>
        var theme = '';
        @foreach ($theme as $item)
            theme += '<span class="check"><input type="checkbox" checked ="false" id="productCheckBox{{ $item->id }}"  name="radio" value="{{ $item->id }}" /><label for="productCheckBox{{ $item->id }}">{{ $item->zn_name }}</label></span>';
        @endforeach
        $('#checkBox').html(theme);

        var addProduct = function (event) {


            var dd = JSON.parse($(event).attr('data-product'));
            var attr = [];
            for (let i in dd) {
                attr.push(String(dd[i].id));
            }
            $("input[name='radio']").each(function () {

                if (attr.indexOf($(this).val()) != -1) {
                    $('#checkBox').find('#productCheckBox' + $(this).val()).prop("checked", true);
                } else {
                    $('#checkBox').find('#productCheckBox' + $(this).val()).removeAttr('checked');

                }
            });

            if ($('#productCheckBox3').is(':checked')) {

                window.productCheckBox3 = 1;
                $('#hotRecommend').show();
            } else {
                window.productCheckBox3 = 0;
                $('#hotRecommend').hide();
            }
            var dd = JSON.parse($(event).attr('data-product'));

            $('#pname').text($(event).attr('data-name'));
            $('#psku').text($(event).attr('data-sku'));
            $('#activeAdd').attr('data-id', $(event).attr('data-id'));
//            alert(345);
            $('#addProduct').modal('toggle');
        }

        var activeAdd = function (event) {

            var data = [], sta = -1;

            $("input[name='radio']:checked").each(function () {
                //精品推荐
                if (window.productCheckBox3 != 1 && $(this).val() == 3 && window.status == -1) {

                    alertify.alert('请选择精品推荐所属分类');
                    sta = 1;
                }
                data.push($(this).val());
            });

            if (sta == 1)
                return;

            var datas = {
                'id': $(event).attr('data-id'),
                'theme': data,
                '_token': '{{csrf_token()}}'
            };
            //加入精品推荐
            if (window.status != -1) {
                datas.hot = window.status;
            }
            // 如果没有选择任何活动，设置datas{'theme'==['0']}
            if (data.length == 0) {
                datas = {
                    'id': $(event).attr('data-id'),
                    'theme': ['0'],
                    '_token': '{{csrf_token()}}'
                };
            }
            $.post('/product/article/add', datas, function (res) {
                if (res.status) {
                    if (datas['theme'] == '0') {
                        alertify.success('活动修改成功');
                    }
                    else {
                        alertify.success('添加活动成功');
                    }
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }

    </script>

    <script>

        //点击添加


        var edit = function (event) {
            $('#banner-save').attr('data-id', $(event).attr('data-id'));
            $('#url_name').val($(event).attr('data-url'));
//            $('#banner-save').attr('data-url', $(event).attr('data-url'));
            $('#bannerAdd').modal('toggle');
        }

        $('#banner-save').click(function () {

            var url = $('#url_name').val();

            //判断URL
            if (url.length <= 0) {

                alertify.success('链接不能为空');
                return;
            }

            var datas = {
                'id': $(this).attr('data-id'),
                'url': url
            };

            $.get('/content/url', datas, function (res) {
                if (res.status) {
                    alertify.success('添加链接成功');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })

        })
    </script>

    <script>
        //        seeActivie
        function see(event) {

            if ($(event).attr('data-id') != 3) {
                //不是精品推荐
                var info = {
                    'id': $(event).attr('data-id')
                };
            } else {
                var info = {
                    'id': $(event).attr('data-id'),
                    'status': 1
                };
            }

            $.get('/see/activie', info, function (res) {
//                consoele.log(res);
                if (res.status) {

                    if (res.data.products.length == 0) {

                        var datas = `<thead> <tr><th class=" col-md-2 col-lg-2 exce"> 序号</th>
                            <th class=" col-md-3 col-lg-3 exce"> 商品名称</th>
                             <th class=" col-md-3 col-lg-3 exce"> 商品是否上架</th>
                            <th class="col-md-4 col-lg-4 exce"> 商品图片</th>
                            </tr>
                            </thead>
                            <tbody><div style="width:100px;text-align: center"><h5 style="color: red;">活动下暂时没有商品</h5></div></tbody>`;

                    } else {

                        //精品推荐
                        if (res.data.val == 1) {
                            var j = 1,
                                datas = `<thead> <tr><th class=" col-md-2 col-lg-2 exce"> 序号</th>
                                <th class=" col-md-3 col-lg-3 exce"> 商品名称</th>
                                      <th class=" col-md-3 col-lg-3 exce"> 商品精品分类</th>
                                       <th class=" col-md-2 col-lg-2 exce"> 商品是否上架</th>
                                <th class="col-md-2 col-lg-2 exce"> 商品图片</th>
                                </tr>
                                </thead>
                                <tbody>`;

                            for (let i in res.data.products) {

                                var meddle = res.data.products[i].status == 1 ? '上架' : '下架';
                                datas += `<tr><td class="exce">${j}</td>
                                    <td class="exce">${res.data.products[i].zn_name}<br/>${res.data.products[i].en_name}</td>
                                      <td class="exce">${res.data.products[i].hot.cat.zn_name}</td>
                                  <td class="exce">${meddle}</td>
                                   <td class="exce"><img height="100px; align=" middle"
                                                                src="${res.data.products[i].product_image}"
                                                                alt="没有上传"/>
                                                            </td>
                                   </tr>`;
                                ++j;
                            }

                        } else {

                            var j = 1,
                                datas = `<thead>
                            <tr>
                            <th class=" col-md-2 col-lg-2 exce"> 序号</th>
                                <th class=" col-md-3 col-lg-3 exce"> 商品名称</th>
                                 <th class=" col-md-3 col-lg-3 exce"> 商品是否上架</th>
                                <th class="col-md-4 col-lg-4 exce"> 商品图片</th>
                                </tr>
                                </thead>
                                <tbody>`;
                            for (let i in res.data.products) {
                                var meddle = res.data.products[i].status == 1 ? '上架' : '下架';
                                datas += ` <tr><td class="exce">${j}</td>
                                    <td class="exce">${res.data.products[i].zn_name}<br/>${res.data.products[i].en_name}</td>
                                   <td class="exce">${meddle}</td>
                                   <td class="exce"><img height="100px; align=" middle"
                                                                src="${res.data.products[i].product_image}"
                                                                alt="没有上传"/>
                                                            </td>
                                   </tr>`;
                                ++j;
                            }
//                            $('#count').text(j - 1);
                        }
                    }


                    $('#activieName').html($(event).attr('data-name') + '活动列表');
                    $('#address').html(datas);
                    $('#seeActivie').modal('toggle');
                } else {
                    alertify.alert('获取信息失败');
                }
            })
        }

    </script>

    <script>
        window.hotImgAddress = '';
        var info = [], infos = '';
        @foreach ($hot as $items)

            info.push({"id": "{{$items->id}}", "img": "{{$items->img}}", 'url': "{{$items->url}}"});

        @endforeach


        for (let i = 1; i < 8; i++) {


            for (let j in info) {

                if (info[j].id == i) {

                    $('#ti' + i).val(`${info[j].url}`);
                    infos = `<img class='file-preview-frame' data-fileindex='0' data-template='image' src='${info[j].img}'/>`;
                    break;

                }
                infos = '';
            }

            var objs = $("#uploadFileImg" + i);

            data1 = {
                language: 'zh', //设置语言
                uploadUrl: "/hot/imgHandle", //上传的地址
                allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
                initialPreview: [ //预览图片的设置
//                infos
                ],
                uploadAsync: true, //默认异步上传
                showUpload: true, //是否显示上传按钮
                showRemove: true, //显示移除按钮
                showPreview: true, //是否显示预览+
                showCaption: false,//是否显示标题
                browseClass: "btn btn-primary", //按钮样式
                dropZoneEnabled: false,//是否显示拖拽区域
                //minImageWidth: 50, //图片的最小宽度
                //minImageHeight: 50,//图片的最小高度
                maxImageWidth: objs.attr('data-width'),//图片的最大宽度
                maxImageHeight: objs.attr('data-height'),//图片的最大高度
                //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
                //minFileCount: 0,
                maxFileCount: 1, //表示允许同时上传的最大文件个数
                enctype: 'multipart/form-data',
                validateInitialCount: true,
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
                msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
                //传递参数
                uploadExtraData: function (previewId, index, objs) {   //额外参数的关键点

                    var data = {
                        'id': i,
                        '_token': '{{csrf_token()}}'
                    };
                    return data;
                }
            };
            if (infos.length > 0)
                data1['initialPreview'] = [infos];

            objs.fileinput('refresh', data1);
            //异步上传返回结果处理
            objs.on("fileuploaded", function (event, data) {
                var obj = data.response;

                if (obj.errno == 1) {
                    alertify.alert(obj.data[0]);
                    return;
                } else {
                    hotImgAddress = obj.data;
                    alertify.alert('上传成功');
                }
            });

        }
    </script>
    <script>
        window.sthotImgAddress = '';
        var info = [], infos = '';
        @foreach ($sthot as $items)

            info.push({"id": "{{$items->id}}", "img": "{{$items->img}}", 'url': "{{$items->url}}"});

        @endforeach


        for (let i = 8; i < 15; i++) {


            for (let j in info) {

                if (info[j].id == i) {

                    $('#stti' + i).val(`${info[j].url}`);
                    infos = `<img class='file-preview-frame' data-fileindex='0' data-template='image' src='${info[j].img}'/>`;
                    break;

                }
                infos = '';
            }

            var objs = $("#stuploadFileImg" + i);

            data1 = {
                language: 'zh', //设置语言
                uploadUrl: "/hot/imgHandle", //上传的地址
                allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
                initialPreview: [ //预览图片的设置
//                infos
                ],
                uploadAsync: true, //默认异步上传
                showUpload: true, //是否显示上传按钮
                showRemove: true, //显示移除按钮
                showPreview: true, //是否显示预览+
                showCaption: false,//是否显示标题
                browseClass: "btn btn-primary", //按钮样式
                dropZoneEnabled: false,//是否显示拖拽区域
                //minImageWidth: 50, //图片的最小宽度
                //minImageHeight: 50,//图片的最小高度
                maxImageWidth: objs.attr('data-width'),//图片的最大宽度
                maxImageHeight: objs.attr('data-height'),//图片的最大高度
                //maxFileSize: 0,//单位为kb，如果为0表示不限制文件大小
                //minFileCount: 0,
                maxFileCount: 1, //表示允许同时上传的最大文件个数
                enctype: 'multipart/form-data',
                validateInitialCount: true,
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
                msgFilesTooMany: "选择上传的文件数量{n} 超过允许的最大数值{m}！",
                //传递参数
                uploadExtraData: function (previewId, index, objs) {   //额外参数的关键点

                    var data = {
                        'id': i,
                        'status':2,
                        '_token': '{{csrf_token()}}'
                    };
                    return data;
                }
            };
            if (infos.length > 0)
                data1['initialPreview'] = [infos];

            objs.fileinput('refresh', data1);
            //异步上传返回结果处理
            objs.on("fileuploaded", function (event, data) {
                var obj = data.response;

                if (obj.errno == 1) {
                    alertify.alert(obj.data[0]);
                    return;
                } else {
                    sthotImgAddress = obj.data;
                    alertify.alert('上传成功');
                }
            });

        }
        sttijiao = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'status':2,
                'url': $('#stti' + $(event).attr('data-id')).val()
            };
            $.get('/hot/url', datas, function (res) {
                if (res.status) {
                    alertify.success('提交成功');
//                    setTimeout(function () {
//                        location.reload();
//                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>
    <script>
        tijiao = function (event) {

            var datas = {
                'id': $(event).attr('data-id'),
                'url': $('#ti' + $(event).attr('data-id')).val()
            };
            $.get('/hot/url', datas, function (res) {
                if (res.status) {
                    alertify.success('提交成功');
//                    setTimeout(function () {
//                        location.reload();
//                    }, 1500);
                } else {
                    alertify.alert(res.message);
                }
            })
        }
    </script>

    <script>
        $('#productCheckBox3').click(function () {

            if ($(this).is(':checked')) {
                //选中
                $('#hotRecommend').show();
            } else {
                $('#hotRecommend').hide();
            }
        })

        //        alert($('#productCheckBox3').is(':checked'));
        //        if ($('#productCheckBox3').is(':checked')) {
        //
        //            $('#hotRecommend').show();
        //        } else {
        //            $('#hotRecommend').hide();
        //        }


    </script>

@endsection