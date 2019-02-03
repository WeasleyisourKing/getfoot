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
        return $this->belongsToMany('App\Http\Model\ProductModel', 'business_order_product', 'order_id', 'product_id')->withPivot('count', 'status');
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

    //关联商品和分类关系 一对多
    public function purchase ()
    {

        return $this->hasMany('App\Http\Model\BusinessOrderProductModel', 'order_id', 'id');
    }

    //获取订单产品
    public static function getProducts ($id)
    {
        return self::with(['manys' => function ($query) {
            $query->with('distributor')
                ->select('zn_name',
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
        return self::select('id', 'order_no', 'total_price', 'snap_img', 'total_count', 'created_at', 'snap_name','status',
            DB::raw("(CASE status WHEN '1' THEN '已完成' WHEN '2' THEN '已下单' END) as state"))
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

    //商业订单后台手动写入
    public static function insertOrder ($data, $datas,$arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            //插入商业订单总表
            $orderIds = self::newOrder($data);

            //插入插入商业订单详情表

            foreach ($arr as &$p) {

                $p['order_id'] = $orderIds->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());

                //写入冻结库存
                $flight = ProductModel::find($p['product_id']);
                $flight->frozen_stock = $flight->frozen_stock + $p['count'];
                $flight->save();
            }
            (new BusinessOrderProductModel)->insert($arr);

           //写入出库记录
            $orderId = new StockOrderModel($datas);
                $orderId->save();

            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $orderId->status;

            }
            (new StockOrderProductModel)->insert($arr);


            DB::commit();

            //返回订单数据
            return $orderIds->toArray();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }


    }

    //删除商业订单
    public static function delOrder ($id,$order)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)->delete();
             BusinessOrderProductModel::where('order_id', '=', $id)->delete();

            //删除手动出库订单
            $StockID = StockOrderModel::where('pruchase_order_no',$order)->first(['id'])->id;
            StockOrderModel::where('id', '=', $StockID)->delete();
            StockOrderProductModel::where('order_id', '=', $StockID)->delete();

            DB::commit();

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
