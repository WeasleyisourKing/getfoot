<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttrProductModel extends Model
{
    protected $table = 'attr_product';

    protected $guarded = [];

    public $timestamps = false;

    //关联属性和值关系 一对多
    public function attrValue ()
    {

        return $this->hasMany('App\Http\Model\AttrValueModel', 'attr_id', 'id');
    }

    //插入属性
    public static function insertAttr ($pId, $attribute)
    {

        DB::beginTransaction();
        try {

            foreach ($attribute as $item) {

                $obj = new self(['product_id' => $pId, 'name' => $item['name']]);
                $obj->save();

                foreach ($item['attr'] as $v) {
                    (new AttrValueModel(['attr_id' => $obj->id, 'name' => $v]))->save();

                }
            }
            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //修改属性
    public static function updateAttr ($pId, $attribute)
    {

        DB::beginTransaction();
        try {

            $id = self::select('id')->where('product_id', '=', $pId)->get()->toArray();
            self::where('product_id', '=', $pId)
                ->delete();

            $arr = [];
            foreach ($id as $item) {
                array_push($arr, $item['id']);
            }

            (new AttrValueModel)->whereIn('attr_id', $arr)->delete();

            self::insertAttr($pId, $attribute);
            DB::commit();

        } catch (\Exception $ex) {

            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //修改属性
    public static function updateAttrTo ($pId)
    {

        DB::beginTransaction();
        try {

            $id = self::select('id')->where('product_id', '=', $pId)->get()->toArray();
            self::where('product_id', '=', $pId)
                ->delete();

            $arr = [];
            foreach ($id as $item) {
                array_push($arr, $item['id']);
            }

            (new AttrValueModel)->whereIn('attr_id', $arr)->delete();

            DB::commit();


        } catch (\Exception $ex) {

            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

}
