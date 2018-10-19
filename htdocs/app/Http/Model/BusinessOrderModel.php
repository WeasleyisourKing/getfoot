<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BusinessOrderModel extends Model
{
    protected $table = 'business_order';

    protected $guarded = [];


    //多对多 从表 中间表 主表外键 从表外键
    //订单和商品
    public function manys ()
    {
        return $this->belongsToMany('App\Http\Model\ProductModel', 'order_product', 'order_id', 'product_id')->withPivot('count', 'status');
    }

    //关联商品和分销商关系 一对一
    public function distributor ()
    {

        return $this->belongsTo('App\Http\Model\DistributorModel', 'product_id', 'product_id');
    }

    //关联商品和分销商关系 一对一
    public function discounts ()
    {

        return $this->belongsTo('App\Http\Model\UsersDiscountModel', 'discount_id', 'id');
    }

    //获取订单产品
    public static function getProducts ($id)
    {
        return self::with(['manys' => function ($query) {
            $query->with('distributor')
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                    'id','en_name','product_image','stock','count')
//                ->select('id', 'zn_name', 'product_image','count')
                ->wherePivot('status', '=', 2);
        }])
            ->where('id', '=', $id)
            ->select('id','order_no')
            ->first();

    }

    //生成预定单
    public static function newOrder ($arr)
    {
        $obj = new self($arr);
        $obj->save();
        return $obj;

    }

    //获取订单列表
    public static function getOrderList ($status, $limit)
    {
        return self::select('id', 'order_no', 'total_price', 'snap_img', 'total_count', 'created_at', 'snap_name',
            DB::raw("(CASE status WHEN '1' THEN '待处理' WHEN '2' THEN '未支付' WHEN '3' THEN '已发货' WHEN '4' THEN '待支付' WHEN '5' THEN '退货' END) as status"))
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }

    //获取订单商品
    public static function getOrderProduct ($id)
    {

        return self::with(['discounts' => function($query) {
            $query->with('discount');
        }])->where('id', '=', $id)
            ->first()
            ->toArray();

    }

    //写入订单和相关商品信息
    public static function insertOrder ($data, $arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            //插入order表
            $orderId = self::newOrder($data);

            //插入order_product表

            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
            }
            (new OrderProductModel)->insert($arr);

            DB::commit();

            //返回订单数据
            return $orderId->toArray();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }


    }

    //删除订单
    public static function delOrder ($id)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            (new BusinessOrderProductModel)->where('order_id', '=', $id)->delete();

            DB::commit();
            return true;

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //获取未处理订单
    public static function countNUm ()
    {
        return self::where('status', '=', 1)
            ->where('handle_status', '=', 2)
            ->count();
    }

    //获取订单数据
    public static function catchOrder ()
    {

//        return $obj = self::where('status', '=', 1)
//            ->where('handle_status', '=', 2)
//            ->first();
        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            $obj = self::where('status', '=', 1)
                ->where('handle_status', '=', 2)
                ->first();

            self::where('id', '=', $obj->id)->update(['handle_status' => 1]);

            DB::commit();

            return $obj;
        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //修改状态
    public static function updateStatus ($id, $data)
    {

        return self::where('id', '=', $id)
            ->update($data);
    }

    //生成预定单
    public static function getOrderInfo ($id)
    {
        return self::select('id', 'total_price', 'status')
            ->where('order_no', '=', $id)
            ->first();

    }

}
