<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductShelvesModel extends Model
{
    protected $table = 'product_shelves';

    protected $guarded = [];

    protected $appends = ['origin_count'];

    public $timestamps = false;

    //实际库存
    public function getoriginCountAttribute()
    {
        if (isset($this->attributes['count'])) {
            return $this->attributes['count'];
        }

    }

    //可用库存
    public function getCountAttribute($value)
    {
        if (isset($this->attributes['frozen_count'])) {

            $nus = $this->attributes['count'] - $this->attributes['frozen_count'];
            return $nus < 0 ? 0 : $nus;
        } else {
            return $value;
        }
    }

    //关联商品和分类关系 一对一
    public function product()
    {
        return $this->belongsTo('App\Http\Model\StockOrderProductModel', 'id', 'product_id');
    }

    //
    public function prod()
    {
        return $this->hasOne('App\Http\Model\ProductModel', 'id', 'product_id');
    }

    //一对一 获取货架名称
    public function name()
    {
        return $this->belongsTo('App\Http\Model\ShelvesModel', 'shelves_id', 'id');
    }


    public static function insertStockShelve($Stock, $data, $palletID, $shelvesID)
    {
        DB::beginTransaction();

        try {
            //商品货架表
            self::insert($data);

            //入库表写入
            $obj = new StockOrderModel($Stock);
            $obj->save();
            //商品表修改
            foreach ($data as &$p) {

                $p['order_id'] = $obj->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
                $p['status'] = $obj->status;
                unset($p['shelves_id']);

                $flight = ProductModel::find($p['product_id']);

                $flight->stock = $flight->origin_stock + $p['count'];
                $flight->save();
            }
            (new StockOrderProductModel)->insert($data);

            //修改采购状态
//            $coll = PalletProductModel::where('pallet_id','=',$palletID)->get();
//            PurchaseOrderModel::whereIn('id',$coll)->update(['status' => 2]);
            //托盘状态
            PalletModel::where('id', '=', $palletID)->update(['status' => 1]);
            //货架状态已满
            ShelvesModel::where('id', '=', $shelvesID)->update(['status' => 1]);

            DB::commit();


        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //调拨商品 原货架
    public static function allocation($shelveId, $arr)
    {

        DB::beginTransaction();
//dump($shelveId);
        try {
            foreach ($arr as &$ite) {
//dump($ite['shelves_id']);
                //原货架
                $nu = self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                    ->where('overdue', '=', $ite['overdue'])->first();

                $mid = $nu->origin_count - $ite['count'];
                if ($mid != 0) {

                    //调拨一部分
                    self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                        ->where('overdue', '=', $ite['overdue'])->update(['count' => $mid]);

                    //目标货架
                    $col = self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                        ->where('overdue', '=', $ite['overdue'])->first();

                    //目标货架存在
                    if (!is_null($col)) {
                        //转入货架有此商品 相加 修改
                        self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->update(['count' => ($col->origin_count + $ite['count'])]);
                    } else {
                        //转入货架没此商品 直接添加
                        self::insert($ite);

                    }
                } else {
                    //调拨全部

                    if ($nu->frozen_count <= 0) {
                        //没有冻结库存 可以删除
                        self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->delete();
                    } else {
                        //有冻结库存 修改数量
                        self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->update(['count' => ($nu->origin_count - $ite['count'])]);
                    }

                    //目标货架
                    $col = self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                        ->where('overdue', '=', $ite['overdue'])->first();

                    //目标货架存在
                    if (!is_null($col)) {

                        //转入货架有此商品 相加 修改
                        self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->update(['count' => ($col->origin_count + $ite['count'])]);

                    } else {

                        //转入货架没此商品 直接添加 转入货架减少数量
                        self::insert($ite);

                    }
                }
                //状态改变
                if (is_null(self::where('shelves_id', '=', $ite['shelves_id'])->first())) {

                    ShelvesModel::where('id', '=', $ite['shelves_id'])->update(['status' => 2]);
                } else {
                    ShelvesModel::where('id', '=', $ite['shelves_id'])->update(['status' => 1]);
                }
            }

            if (is_null(self::where('shelves_id', '=', $shelveId)->first())) {

                ShelvesModel::where('id', '=', $shelveId)->update(['status' => 2]);
            } else {
                ShelvesModel::where('id', '=', $shelveId)->update(['status' => 1]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }


}
