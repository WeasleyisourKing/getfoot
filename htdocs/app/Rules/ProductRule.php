<?php

namespace App\Rules;


/**
 * 商品验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class ProductRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'zn_name' => 'required|max:50',
        'en_name' => 'required|max:100',
        'summary' => 'required|max:100',
        'price' => 'required|price_value',
        'one_price' => 'required|price_value',
        'two_price' => 'required|price_value',
        'three_price' => 'required|price_value',
        'four_price' => 'required|price_value',
        'zn_editor' => 'required',
        'en_editor' => 'required',
        'category' => 'required',
        'brand' => 'required',
        'weight' => 'required|price_value',
        'number' => 'required|positive_integer',
//        'net_weight' => 'required|price_value',
        'numberUnit' => 'required',
        'weightUnit' => 'required',
//        'net_weightUnit' => 'required',
        'term' => 'required|positive_integer|max:6'

    ];
    //失败信息
    protected $message = [
        'id.required' => '商品id不能为空',
        'id.positive_integer' => '用户id不是正整数',
        'zn_name.required' => '商品中文名称不能为空',
        'zn_name.max' => '商品中文名称最大值50',
        'en_name.required' => '商品英文名称不能为空',
        'en_name.max' => '商品英文名称最大值100',
        'summary.required' => '商品关键词不能为空',
        'summary.max' => '商品摘要最大值100',
        'price.required' => '用户价格不能为空',
        'price.price_value' => '用户价格金额格式不对或者超过百万',
        'one_price.required' => '一级分销商价格不能为空',
        'one_price.price_value' => '一级分销商价格金额格式不对或者超过百万',
        'two_price.required' => '二级分销商价格不能为空',
        'two_price.price_value' => '二级分销商价格金额格式不对或者超过百万',
        'three_price.required' => '三级分销商价格不能为空',
        'three_price.price_value' => '三级分销商价格金额格式不对或者超过百万',
        'four_price.required' => '四级分销商价格不能为空',
        'four_price.price_value' => '四级分销商价格金额格式不对或者超过百万',
        'zn_editor.required' => '商品中文详细描述不能为空',
        'en_editor.required' => '商品英文详细描述不能为空',
        'category.required' => '分类不能为空',
        'brand.required' => '品牌不能为空',
        'weight.required' => '单品重量不能为空',
        'weight.price_value' => '重量格式不对',
        'number.required' => '单品规格不能为空',
        'number.positive_integer' => '单品规格不是正整数',
        'numberUnit.required' => '单品单位不能为空',
//        'net_weight.required' => '净重量不能为空',
//        'net_weight.price_value' => '净重量格式不对',
//        'net_weightUnit.required' => '净重量不能为空',
        'weightUnit.required' => '净重量单位不能为空',
        'term.required' => '商品保质期不能为空',
        'term.positive_integer' => '商品保质期不是正整数',
        'term.max' => '商品保质期不是不能超过6位数',

    ];


}
