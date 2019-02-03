<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Exceptions\ParamsException;
use Illuminate\Support\Facades\Log;

class ProductModel extends Model
{
    protected $table = 'product';

    //黑名单
    protected $guarded = [];

    protected $hidden = ['pivot'];


    //关联主题区和图片关系 一对一
    public function hot()
    {

        return $this->belongsTo('App\Http\Model\FineProductModel', 'id', 'product_id');
    }

    //关联主题区和图片关系 一对一
//    public function shelves()
//    {
//
//        return $this->belongsTo('App\Http\Model\ShelvesModel', 'shelves', 'id');
//    }

    //关联商品和分类关系 一对一
    public function category()
    {

        return $this->belongsTo('App\Http\Model\CategoryModel', 'category_id', 'id');
    }

    //关联商品和分类关系 一对一
    public function info()
    {
        return $this->belongsTo('App\Http\Model\StockOrderProductModel', 'id', 'product_id');
    }

    //关联商品和分类关系 一对多
    public function image()
    {

        return $this->hasMany('App\Http\Model\ImageProductModel', 'product_id', 'id');
    }

    //关联商品和品牌关系 一对一
    public function brand()
    {

        return $this->belongsTo('App\Http\Model\BrandModel', 'brand_id', 'id');
    }

    //关联商品和分销商关系 一对一
    public function distributor()
    {

        return $this->belongsTo('App\Http\Model\DistributorModel', 'id', 'product_id');
    }

    //关联主题和商品关系 多对多
    public function products()
    {

        return $this->belongsToMany('App\Http\Model\ThemeModel', 'theme_product',
            'product_id', 'theme_id');

    }

    //关联主题和商品关系 多对多
    public function shelves()
    {
        return $this->belongsToMany('App\Http\Model\ShelvesModel', 'product_shelves',
            'product_id', 'shelves_id');

    }

    //关联商品和属性关系 一对多
    public function attr()
    {

        return $this->hasMany('App\Http\Model\AttrProductModel', 'product_id', 'id');
    }

    //评论回复 一对多
    public function message()
    {
        return $this->hasMany('App\Http\Model\MessageModel', 'product_id', 'id');
    }

    // 一对多
    public function date()
    {

        return $this->hasMany('App\Http\Model\StockOrderProductModel', 'product_id', 'id');
    }

    //商品过期日期 一对一
    public function overdue()
    {
        return $this->belongsTo('App\Http\Model\StockOrderProductModel', 'id', 'product_id');
    }
//
    //实际库存
    public function getStockAttribute($value)
    {
        if (!empty($this->attributes['frozen_stock'])) {

            $nus = $this->attributes['stock'] - $this->attributes['frozen_stock'];
            return $nus < 0 ? 0 : $nus;
        } else {
            return $value;
        }
    }

    //实际库存
    public function getznNameAttribute($value)
    {
        if (!empty($this->attributes['frozen_stock'])) {

            $nus = $this->attributes['stock'] - $this->attributes['frozen_stock'];
            return $nus > 0 ? $value : '【已售罄】' . $value;
        } else {
            return $value;
        }
    }

    //实际库存
    public function getenNameAttribute($value)
    {
        if (!empty($this->attributes['frozen_stock'])) {

            $nus = $this->attributes['stock'] - $this->attributes['frozen_stock'];
            return $nus > 0 ? $value : '【Sold out】' . $value;

        } else {
            return $value;
        }
    }

    //获取商品列表
    public static function getCategoryProductList($id)
    {

        return self::with(['distributor', 'category'])
            ->select('id', 'zn_name', 'en_name', 'category_id', 'product_image')
            ->where('status', '=', 1)
            ->where('category_id', '=', $id)
            ->orderBy('created_at', 'desc')
            ->get();

    }

    //获取某商品全部信息
    public static function getShopById($id)
    {

        return self::with(['attr' => function ($query) {
            $query->with('attrValue');
        }, 'category' => function ($query) {
            $query->where('id', '!=', 1);
        }, 'products', 'brand' => function ($query) {
            $query->where('id', '!=', 1);
        }, 'distributor', 'image', 'message' => function ($query) {
            $query->select('product_id');
        }])
            ->select('zn_name', 'en_name', 'id', 'product_image', 'stock', 'sku', 'price', 'status', 'summary', 'category_id', 'brand_id', 'en_describe',
                'zn_describe', 'number', 'zn_weight', 'en_weight', 'zn_number', 'en_number', 'weight', 'shelves', 'term', 'net_weight', 'zn_net_weight',
                'en_net_weight', 'frozen_stock')
            ->where('id', '=', $id)
            ->where('status', '=', 1)
            ->first();
    }

    //获取某些商品信息
    public static function getProduct($arr)
    {
        return self::with('distributor', 'shelves')
            ->select(['id', 'sku', 'price', 'stock', 'zn_name', 'en_name', 'product_image', 'status', 'innersku', 'number'])
            ->whereIn('id', $arr)
            ->get()
            ->toArray();
    }

    //获取库存商品列表
    public static function getStockProduct($limit)
    {

        return self::select('id', 'product_image', 'sku', 'en_name', 'zn_name', 'stock', 'shelves')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }


    //获取商品列表
    public static function getProductList($status, $arr, $limit)
    {
        return self::with(['category', 'brand', 'distributor', 'date' => function ($q) {
            $q->with(['info' => function ($qu) {
                $qu->select('id', 'order_no');
            }])->select('product_id', 'order_id', 'overdue')
                ->where('status', '=', 1)
                ->orderBy('created_at', 'desc');
        }])
            ->select('id', 'sku', 'zn_name', 'price', 'en_name', 'product_image', 'stock',
                'innersku', 'status', 'summary', 'number', 'zn_number', 'en_number', 'weight', 'zn_weight', 'en_weight', 'net_weight', 'zn_net_weight', 'en_net_weight', 'created_at', 'category_id', 'brand_id', 'term', 'created_at')->where($arr)
            ->where('status', '=', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }

    //获取全部商品列表
    public static function getProductAll($arr, $limit)
    {
        return self::with(['category', 'brand', 'distributor', 'date' => function ($q) {
            $q->with(['info' => function ($qu) {
                $qu->select('id', 'order_no');
            }])->select('product_id', 'order_id', 'overdue')
                ->where('status', '=', 1)
                ->orderBy('created_at', 'desc');

        }])
            ->select('id', 'sku', 'zn_name', 'price', 'en_name', 'product_image', 'stock',
                'innersku', 'status', 'summary', 'number', 'zn_number', 'en_number', 'weight', 'zn_weight', 'en_weight', 'net_weight', 'zn_net_weight', 'en_net_weight', 'created_at', 'category_id', 'brand_id', 'term', 'created_at')
            ->where($arr)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }

    //获取商品列表
    public static function getProductListTheme($status, $arr, $limit)
    {
        return self::with(['category', 'brand', 'products'])
            ->select('id', 'sku', 'zn_name', 'price', 'en_name', 'product_image', 'stock',
                'status', 'summary', 'number', 'zn_number', 'en_number', 'weight', 'zn_weight', 'en_weight', 'created_at', 'category_id', 'brand_id', 'term', 'created_at')
            ->where($arr)
            ->where('status', '=', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }

    //获取全部商品列表
    public static function getProductAllTheme($arr, $limit)
    {
        return self::with(['category', 'brand', 'products'])
            ->select('id', 'sku', 'zn_name', 'price', 'en_name', 'product_image', 'stock',
                'status', 'summary', 'number', 'zn_number', 'en_number', 'weight', 'zn_weight', 'en_weight', 'created_at', 'category_id', 'brand_id', 'term', 'created_at')
            ->where($arr)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }

    //获取某些商品信息
    public static function getProductById($id)
    {
        return self::with(['shelves', 'attr' => function ($query) {
            $query->with('attrValue');
        }])
            ->where('id', '=', $id)
            ->first();
    }

    //商品名唯一
    public static function uniqueProduct($name)
    {
        return self::where('zn_name', '=', $name)->first();

    }

    //商品名唯一
    public static function uniqueSKU($sku)
    {
        return self::where('sku', '=', $sku)->first();

    }

    //商品名唯一
    public static function uniqueP($id, $name)
    {
        return self::where('zn_name', '=', $name)
            ->where('id', '!=', $id)
            ->first();

    }

    //商品名唯一
    public static function uniqueS($id, $sku)
    {
        return self::where('sku', '=', $sku)
            ->where('id', '!=', $id)
            ->first();

    }

    //插入新的商品
    public static function insertProduct($data, $arr, $res, $shelves)
    {
        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            //插入product表
            $obj = new self($data);
            $obj->save();

            //插入image_product表

            foreach ($arr as &$p) {

                $p['product_id'] = $obj->id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
            }
            (new ImageProductModel)->insert($arr);

            if (!is_null($shelves)) {
                $she = [];
                foreach ($shelves as $ps) {
                    array_push($she, ['product_id' => $obj->id, 'shelves_id' => $ps]);

                }
                (new ProductShelvesModel)->insert($she);
            }


            //插入distributor表
            $res['product_id'] = $obj->id;

            (new DistributorModel($res))->save();

            DB::commit();

            return $obj->id;
        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //修改商品
    public static function updateProductInfo($id, $data, $distributor, $shelves)
    {
        DB::beginTransaction();
        try {
            $res = (new DistributorModel)->where('product_id', '=', $id)->update($distributor);

            self::where('id', '=', $id)->update($data);


            if (!is_null($shelves)) {
                ProductShelvesModel::where('product_id', '=', $id)->delete();
                $she = [];
                foreach ($shelves as $ps) {
                    array_push($she, ['product_id' => $id, 'shelves_id' => $ps]);

                }
                (new ProductShelvesModel)->insert($she);
            }
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //修改商品
    public static function updateProductAndImgInfo($id, $data, $arr, $distributor, $shelves)
    {
        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            //插入product表
            self::where('id', '=', $id)->update($data);

            //插入image_product表

            $obj = new ImageProductModel;
            $obj->where('product_id', '=', $id)
                ->delete();

            foreach ($arr as &$p) {

                $p['product_id'] = $id;
                $p['created_at'] = date('Y-m-d H:i:s', time());
                $p['updated_at'] = date('Y-m-d H:i:s', time());
            }
            $obj->insert($arr);

            if (!is_null($shelves)) {
                ProductShelvesModel::where('product_id', '=', $id)->delete();
                $she = [];
                foreach ($shelves as $ps) {
                    array_push($she, ['product_id' => $id, 'shelves_id' => $ps]);

                }
                (new ProductShelvesModel)->insert($she);
            }

            (new DistributorModel)->where('product_id', '=', $id)->update($distributor);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //批量上下架商品
    public static function batchProduct($arr, $data)
    {

        return self::whereIn('id', $arr)
            ->update($data);
    }

    //删除商品
    public static function delProduct($id)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            (new ImageProductModel)->where('product_id', '=', $id)->delete();

            $ids = (new AttrProductModel)->select('id')->where('product_id', '=', $id)->get()->toArray();
            (new AttrProductModel)->where('product_id', '=', $id)
                ->delete();

            $arr = [];
            foreach ($ids as $item) {
                array_push($arr, $item['id']);
            }

            (new AttrValueModel)->whereIn('attr_id', $arr)->delete();

            (new DistributorModel)->where('product_id', $id)->delete();
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //修改商品库存
    public static function updateStock($data)
    {

        DB::beginTransaction();
        try {
            if (!empty($data)) {

                foreach ($data as $k => $v) {

                    $flight = self::find($v['id']);
                    $flight->stock = $flight->stock + $v['stock'];
                    $flight->save();

                }
            }
//            if (!empty($shelve)) {
//
//                foreach ($shelve as $k => $v) {
//
//                    $flig = self::find($v['id']);
//                    $flig->shelves = $v['shelve'];
//                    $flig->save();
//
//                }
//            }
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //修改商品库存
    public static function updateStockSub($data)
    {

        DB::beginTransaction();
        try {

            foreach ($data as $k => $v) {

                $flight = self::find($v['id']);
                $flight->stock = $flight->stock - $v['stock'];
                $flight->save();

            }

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //查询商品
    public static function searchName($data)
    {
        return self::with('distributor')
            ->select('id', 'product_image', 'sku', 'en_name', 'zn_name', 'stock', 'price', 'innersku', 'number')
            ->where('zn_name', 'like', '%' . $data . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    //查询商品
    public static function searchSKU($data)
    {
        return self::with('distributor')
            ->select('id', 'product_image', 'sku', 'en_name', 'zn_name', 'stock', 'price', 'innersku', 'number')
            ->where('sku', 'like', '%' . $data . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    }


    //修改货架
    public static function updateShelves($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //商品货架唯一
    public static function uniqueShelves($id, $shelves)
    {
        return self::where('shelves', '=', $shelves)
            ->where('id', '!=', $id)
            ->first();

    }

    //修改商品库存
    public static function updateProductStock($orderId)
    {

        DB::beginTransaction();

        try {

            $data = OrderProductModel::where('order_id', '=', $orderId)->get(['product_id', 'count']);

            foreach ($data as $items) {

                $id = $items['product_id'];

                self::where('id', '=', $id)->decrement('stock', (int)$items['count']);

            }

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            if ($ex instanceof QueryException) {

                //库存不足
                $name = self::where('id', '=', $id)->first(['zn_name']);

                Log::info('商品' . $name['zn_name'] . '库存不足');
            } else {
                //记录日志
                throw $ex;
            }
        }
    }

}
