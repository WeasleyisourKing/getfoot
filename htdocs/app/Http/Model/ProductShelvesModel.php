<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductShelvesModel extends Model
{
    protected $table = 'product_shelves';

    protected $guarded = [];

    public $timestamps = false;

    //关联商品和分类关系 一对一
    public function product()
    {
        return $this->belongsTo('App\Http\Model\StockOrderProductModel', 'id', 'product_id');
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

                $flight->stock = $flight->stock + $p['count'];
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

    //调拨商品
    public static function allocation($shelveId, $arr)
    {

        DB::beginTransaction();
//dump($shelveId);
        try {
            foreach ($arr as &$ite) {
//dump($ite['shelves_id']);
                $nu = self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                    ->where('overdue', '=', $ite['overdue'])->first()->count;

                $mid = $nu - $ite['count'];
                if ($mid != 0) {

                    //调拨一部分
                    self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                        ->update(['count' => $mid]);

                    $col = self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                        ->where('overdue', '=', $ite['overdue'])->first();

                    if (!is_null($col)) {

                        //转入货架有此商品 相加  从新添加
                        $ite['count'] += $col->count;

                        self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->delete();
                        self::insert($ite);

                    } else {
                        //转入货架没此商品 直接添加
                        self::insert($ite);

                    }
                } else {
                    //调拨全部
                    $col = self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                        ->where('overdue', '=', $ite['overdue'])->first();

                    if (!is_null($col)) {

                        //转入货架有此商品 相加 并删除转入货架和原货架 从新添加
                        $ite['count'] += $col->count;

                        self::where('shelves_id', '=', $ite['shelves_id'])->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->delete();
                        self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->delete();

                        self::insert($ite);

                    } else {

                        //转入货架没此商品 直接添加 转入货架减少数量
//
                        self::where('shelves_id', '=', $shelveId)->where('product_id', '=', $ite['product_id'])
                            ->where('overdue', '=', $ite['overdue'])->delete();
                        self::insert($ite);

                    }
                }
                //状态改变
                if (is_null(self::where('shelves_id', '=', $ite['shelves_id'])->first())) {

                    ShelvesModel::where('id', '=', $ite['shelves_id'])->update(['status' => 2]);
                }
            }

            if (is_null(self::where('shelves_id', '=', $shelveId)->first())) {

                ShelvesModel::where('id', '=', $shelveId)->update(['status' => 2]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }



}
