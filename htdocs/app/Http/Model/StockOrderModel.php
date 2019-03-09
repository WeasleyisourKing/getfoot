<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockOrderModel extends Model
{
    protected $table = 'stock_order';

    protected $guarded = [];

    //多对多 从表 中间表 主表外键 从表外键
    //订单和商品
    public function manys()
    {
        return $this->belongsToMany('App\Http\Model\ProductModel', 'purchase_order_product', 'order_id', 'product_id');
    }

    //关联商品和分销商关系 一对一
    public function distributor()
    {

        return $this->belongsTo('App\Http\Model\DistributorModel', 'product_id', 'product_id');
    }

    //关联商品和分销商关系 一对一
    public function discounts()
    {

        return $this->belongsTo('App\Http\Model\UsersDiscountModel', 'discount_id', 'id');
    }

    //关联商品和分类关系 一对多
    public function purchase()
    {

        return $this->hasMany('App\Http\Model\StockOrderProductModel', 'order_id', 'id');
    }

    //获取订单产品
    public static function getProducts($id)
    {
        return self::with(['manys' => function ($query) {
            $query->with('distributor')
                ->select('zn_name',
                    'id', 'en_name', 'product_image', 'stock', 'count','frozen_stock')
//                ->select('id', 'zn_name', 'product_image','count')
                ->wherePivot('status', '=', 2);
        }])
            ->where('id', '=', $id)
            ->select('id', 'order_no')
            ->first();

    }

    //生成预定单
    public static function newOrder($arr)
    {
        $obj = new self($arr);
        $obj->save();
        return $obj;

    }

    //获取订单列表
    public static function getOrderList($status, $limit)
    {
        return self::select('id', 'order_no', 'total_price', 'snap_img', 'total_count', 'created_at', 'snap_name',
            DB::raw("(CASE status WHEN '1' THEN '待处理' WHEN '2' THEN '未支付' WHEN '3' THEN '已发货' WHEN '4' THEN '待支付' WHEN '5' THEN '退货' END) as status"))
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }

    //获取订单商品
    public static function getOrderProduct($id)
    {

        return self::with(['discounts' => function ($query) {
            $query->with('discount');
        }])->where('id', '=', $id)
            ->first()
            ->toArray();

    }

    //写入订单和相关商品信息
    public static function insertOrder($id, $data, $arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            //插入order表
            $orderId = self::newOrder($data);
            if (!is_null($id))
                PurchaseOrderModel::where('id', '=', $id)->update(['status' => 2]);

            //插入order_product表
            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $orderId->status;

                $flight = ProductModel::find($p['product_id']);
                $flight->stock = $flight->stock + $p['count'];
                $flight->save();
            }

            (new StockOrderProductModel)->insert($arr);

            DB::commit();

            //返回订单数据
            return $orderId->toArray();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }


    }

//写入订单和相关商品信息
    public static function reduceOrder($id, $data, $arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            //插入order表
            $orderId = self::newOrder($data);
            if (!is_null($id))
                PurchaseOrderModel::where('id', '=', $id)->update(['status' => 2]);


            $st = BusinessOrderModel::where('order_no', '=', $orderId->pruchase_order_no);
            //插入order_product表
            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $orderId->status;

                $flight = ProductModel::find($p['product_id']);
                $flight->stock = $flight->stock - $p['count'];
                $flight->save();
            }


            (new StockOrderProductModel)->insert($arr);

            DB::commit();

            //返回订单数据
            return $orderId->toArray();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }


    }

    //写入订单和相关商品信息
    public static function automaticOrder($data, $arr)
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
                $p['status'] = $orderId->status;
            }


            (new StockOrderProductModel)->insert($arr);

            DB::commit();

            //返回订单数据
            return $orderId->toArray();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }


    }

    //删除入库订单
    public static function delInOrder($id)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            (new StockOrderProductModel)->where('order_id', '=', $id)->delete();

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //删除出库订单
    public static function delOrder($id, $businessID = null,$shelve = null)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            $data = (new StockOrderProductModel)->where('order_id', '=', $id)->get();
            (new StockOrderProductModel)->where('order_id', '=', $id)->delete();

            //删除冻结库存
            foreach ($data as $p) {
                $flight = ProductModel::find($p['product_id']);
                $flight->frozen_stock = $flight->frozen_stock - $p['count'];
                $flight->save();
            }
            if (!is_null($businessID)) {
                $datas = json_decode(BusinessOrderModel::find($businessID)->shelve_position,true);

                BusinessOrderModel::where('id', '=', $businessID)->delete();
                BusinessOrderProductModel::where('order_id', '=', $businessID)->delete();
            } else {
                $datas = $shelve;
            }

            //删除冻结库存
            foreach ($datas as $item) {
                foreach ($item as $ii) {
                    ProductShelvesModel::where('product_id', '=', $ii['product_id'])
                        ->where('shelves_id', '=', $ii['shelves_id'])
                        ->where('overdue', '=', $ii['overdue'])
                        ->decrement('frozen_count', $ii['count']);
                }
            }
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }


    //删除订单
    public static function delSow($arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::whereIn('id', $arr)
                ->delete();

            (new StockOrderProductModel)->whereIn('order_id', $arr)->delete();

            DB::commit();
            return true;

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }


    //获取订单数据
    public static function catchOrder()
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
    public static function updateStatus($id, $data)
    {

        return self::where('id', '=', $id)
            ->update($data);
    }

    //生成预定单
    public static function getOrderInfo($id)
    {
        return self::select('id', 'total_price', 'status')
            ->where('order_no', '=', $id)
            ->first();

    }

    //手动订单确认
    public static function check($id, $arr, $status, $num = null)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            if ($status == 1) {
                self::where('id', '=', $id)->update(['state' => 2]);
                foreach ($arr as &$p) {

                    $flight = ProductModel::find($p['product_id']);
                    $flight->stock = $flight->stock + $p['count'];
                    $flight->save();

                    StockOrderProductModel::where('order_id', '=', $id)
                        ->where('product_id', '=', $p['product_id'])
                        ->update([
                            'origin_stock' => $p['origin_stock'],
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
                }

            } else {
                $info = self::find($id);
                $info->total_count = $num;
                $info->remark = '非直接入库确认，入库数量与订单数量存在误差';
                $info->state = 2;
                $info->save();
                foreach ($arr as &$p) {

                    $flight = ProductModel::find($p['product_id']);
                    $flight->stock = $flight->stock + $p['count'];
                    $flight->save();

                    StockOrderProductModel::where('order_id', '=', $id)
                        ->where('product_id', '=', $p['product_id'])
                        ->update([
                            'count' => $p['count'],
                            'origin_stock' => $p['origin_stock'],
                            'overdue' => $p['overdue'],
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
                }

            }

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //创建手动订单
    public static function createHandOrder($data, $arr)
    {
        DB::beginTransaction();
        try {

            $orderId = self::newOrder($data);
            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $orderId->status;
                unset($p['shelves_id']);

            }
            (new StockOrderProductModel)->insert($arr);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //入库
    public static function insertInOrder($data, $arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            //入库记录写入
            $orderId = self::newOrder($data);

            //入库增加相应商品
            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $orderId->status;

                $flight = ProductModel::find($p['product_id']);
                $flight->stock = $flight->stock + $p['count'];
                $flight->save();
            }

            //入库详情表写入
            (new StockOrderProductModel)->insert($arr);

            DB::commit();

            //返回订单数据
            return $orderId->toArray();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }


    //创建手动出库记录
    public static function handOutOrder($data, $arr,$info)
    {
        DB::beginTransaction();
        try {
            //手动出库记录写入
            $orderId = self::newOrder($data);

            //手动出库减少相应商品
            foreach ($arr as &$p) {

                $p['order_id'] = $orderId->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $orderId->status;
                unset($p['postion']);

                //写入冻结库存
                $flight = ProductModel::find($p['product_id']);
                $flight->frozen_stock = $flight->frozen_stock + $p['count'];
                $flight->save();
            }
            //手动出库详情表写入
            (new StockOrderProductModel)->insert($arr);

            //写入冻结库存
            foreach ($info as $item) {
                foreach ($item as $ii) {
                    ProductShelvesModel::where('product_id', '=', $ii['product_id'])
                        ->where('shelves_id', '=', $ii['shelves_id'])
                        ->where('overdue', '=', $ii['overdue'])
                        ->increment('frozen_count', $ii['count']);
                }
            }
            DB::commit();


        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //出库手动确认
    public static function updatestate($id, $arr, $num, $status)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            $info = self::find($id);
            //修改出库表总量和状态
            self::where('id', '=', $id)->update([
                'state' => 2,
                'total_count' => $num
            ]);
            //如果是商业订单 修改数量 状态 相应货架减少
            if ($status == 2 && substr($info->pruchase_order_no, 0, 2) == 'ST') {

                $business = BusinessOrderModel::where('order_no', '=', $info->pruchase_order_no)->first(['id', 'shelve_position']);

                $businessID = $business->id;
                $businessPosition = json_decode($business->shelve_position, true);
//                dump($businessPosition);
//                $price = 0;
                foreach ($arr as &$p) {

                    //减少对应的商品库存
                    $flight = ProductModel::find($p['product_id']);
                    $flight->stock = $flight->origin_stock - $p['count'];
                    $flight->frozen_stock = $flight->frozen_stock - $p['count'];
                    $flight->save();

                    //修改详细库存量
                    StockOrderProductModel::where('order_id', '=', $id)
                        ->where('product_id', '=', $p['product_id'])
                        ->update([
//                            'count' => $p['count'],
                            'origin_stock' => $p['origin_stock']
                        ]);
//                    BusinessOrderProductModel::where('order_id', '=', $businessID)
//                        ->where('product_id', '=', $p['product_id'])
//                        ->update([
//                            'count' => $p['count']
//                        ]);
                    //从新计算金额
//                    foreach ($businessInfo as $it) {
//                        if ($it['id'] == $p['product_id']) {
//
//                            $price += $it['totalPrice'] * $p['count'];
//                        }
//                    }

                }
                BusinessOrderModel::where('id', '=', $businessID)->update([
                    'status' => 1
//                    'total_count' => $num,
//                    'total_price' => $price
                ]);

            } else {
                //不是商业订单
                $businessPosition = json_decode($info->shelve_position, true);

                foreach ($arr as &$p) {

                    $count = array_column($arr,'count');
                    //减少对应的商品库存
                    $flight = ProductModel::find($p['product_id']);
                    $flight->stock = $flight->origin_stock - $p['count'];
                    $flight->frozen_stock = $flight->frozen_stock - $p['count'];
                    $flight->save();

                    //修改详细库存量
                    StockOrderProductModel::where('order_id', '=', $id)
                        ->where('product_id', '=', $p['product_id'])
                        ->update([
                            'count' => $p['count'],
                            'origin_stock' => $p['origin_stock']
                        ]);
                }
            }
            //减少相应货架


            foreach ($businessPosition as $val) {
                foreach ($val as $v) {
                    $object = ProductShelvesModel::where('product_id', '=', $v['product_id'])
                        ->where('shelves_id', '=', $v['shelves_id'])
                        ->where('overdue', '=', $v['overdue'])
                        ->first();
                    if (is_null($object)) {
                        DB::rollBack();
                        throw new \App\Exceptions\ParamsException([
                            'code' => 200,
                            'message' => '货架名为' . $v['name']
                                . '且日期是' . $v['overdue'] . '的货架没有' . ProductModel::where('id', '=', $v['product_id'])->first(['zn_name'])->zn_name . '商品'
                        ]);
                    }
                    $numc = $object->origin_count - $v['count'];
                    if ($numc > 0) {
                        ProductShelvesModel::where('product_id', '=', $v['product_id'])
                            ->where('shelves_id', '=', $v['shelves_id'])
                            ->where('overdue', '=', $v['overdue'])
                            ->where('count', '=', $object->origin_count)
                            ->update([
                                'count' => $numc,
                                'frozen_count' => $object->frozen_count - $v['count']
                            ]);
                    } elseif ($numc == 0) {
                        ProductShelvesModel::where('product_id', '=', $v['product_id'])
                            ->where('shelves_id', '=', $v['shelves_id'])
                            ->where('overdue', '=', $v['overdue'])
                            ->where('count', '=', $object->origin_count)
                            ->delete();

                    }

                    //状态改变
                    if (is_null(ProductShelvesModel::where('shelves_id', '=', $v['shelves_id'])->first())) {

                        ShelvesModel::where('id', '=', $v['shelves_id'])->update(['status' => 2]);
                    } else {
                        ShelvesModel::where('id', '=', $v['shelves_id'])->update(['status' => 1]);
                    }
                }

            }
            dd(34);
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //入库手动确认
    public static function updateInState($id, $arr)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {
            $info = self::find($id);
            //修改出库表总量和状态
            self::where('id', '=', $id)->update([
                'state' => 2
            ]);

                //不是商业订单
                $businessPosition = json_decode($info->shelve_position, true);

                foreach ($arr as &$p) {

//                    $count = array_column($arr,'count');
                    //减少对应的商品库存
                    $flight = ProductModel::find($p['product_id']);
                    $flight->stock = $flight->origin_stock + $p['count'];
                    $flight->save();

                    //修改详细库存量
                    StockOrderProductModel::where('order_id', '=', $id)
                        ->where('product_id', '=', $p['product_id'])
                        ->update([
                            'count' => $p['count'],
                            'origin_stock' => $p['origin_stock']
                        ]);
                }

            //减少相应货架
//            dd($businessPosition);

            foreach ($businessPosition as $v) {
//                foreach ($val as $v) {
                    $object = ProductShelvesModel::where('product_id', '=', $v['product_id'])
                        ->where('shelves_id', '=', $v['shelves_id'])
                        ->where('overdue', '=', $v['overdue'])
                        ->first();

                    if (is_null($object)) {
                        //不存在
                        ProductShelvesModel::insert([
                            'product_id' =>  $v['product_id'],
                            'shelves_id' =>  $v['shelves_id'],
                            'count' =>  $v['count'],
                            'overdue' =>  $v['overdue']
                        ]);
                    } else {
                        //存在相加
                        ProductShelvesModel::where('product_id', '=', $v['product_id'])
                            ->where('shelves_id', '=', $v['shelves_id'])
                            ->where('overdue', '=', $v['overdue'])
                            ->where('count', '=', $object->origin_count)
                            ->update([
                                'count' => $object->origin_count + $v['count']
                            ]);
                    }

                    //状态改变
                ShelvesModel::where('id', '=', $v['shelves_id'])->update(['status' => 2]);
//                    if (is_null(ProductShelvesModel::where('shelves_id', '=', $v['shelves_id'])->first())) {
//
//                        ShelvesModel::where('id', '=', $v['shelves_id'])->update(['status' => 2]);
//                    } else {
//                        ShelvesModel::where('id', '=', $v['shelves_id'])->update(['status' => 1]);
//                    }
//                }

            }

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }
}
