<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\ProductModel;
use App\Http\Model\ShelvesModel;
use App\Http\Model\PurchaseOrderModel;
use App\Http\Model\StockOrderModel;
use App\Http\Model\OrderProductModel;
use App\Http\Controllers\Common;
use App\Rules\StockRule;
use App\Rules\ShelveRule;
use App\Rules\PurchaseRule;
use App\Rules\OrderRule;
use App\Rules\EnterRule;
use App\Exceptions\ParamsException;

/**
 * 库存管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class StockController extends Controller
{
    /**
     * 入库页面
     * @param Request $request
     * @return null
     */
    public function addLibrary ($limit)
    {

        $res = ProductModel::getStockProduct($limit);

        return view('admin.stock.stock-add', [
            'data' => $res,
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 出库页面
     * @param Request $request
     * @return null
     */
//    public function stockOut ($limit)
//    {
//
//        $res = ProductModel::getStockProduct($limit);
//
//        return view('admin.stock.stock-out', [
//            'data' => $res,
//            'limit' => '显示' . $limit . '条'
//        ]);
//
//    }

    /**
     * 货架管理页面
     * @param Request $request
     * @return null
     */
    public function stockShelves ($limit)
    {

        $res = ProductModel::getStockProduct($limit);

        return view('admin.stock.stock-shelves', [
            'data' => $res,
            'limit' => '显示' . $limit . '条'
        ]);
    }


    /**
     * 修改商品添加库存信息接口
     * @param Request $request
     * @return null
     */
    public function productStock (Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->input('data');

//        $shelve = $request->input('shelve');

        //修改信息
        ProductModel::updateStock($data);

        return Common::successData();
    }

    /**
     * 修改商品减少库存信息接口
     * @param Request $request
     * @return null
     */
    public function productStockSub (Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->input('data');

        //修改信息
        ProductModel::updateStockSub($data);

        return Common::successData();
    }

    /**
     * 修改商品货架接口
     * @param Request $request
     * @return null
     */
//    public function editShelves (Request $request)
//    {
//
//        (new ShelveRule)->goCheck(200);
//
//        $params = $request->all();
//
//        $name = htmlspecialchars(strip_tags(trim($params['shelves'])));
//        //验证唯一性
//        if (ProductModel::uniqueShelves($params['id'], $name)) {
//
//            throw new ParamsException([
//                'code' => 200,
//                'message' => '商品货架名已经存在'
//            ]);
//        }
//        //拼接数据
//        $data = [
//            'shelves' => $name
//        ];
//
//        $res = ProductModel::updateShelves($params['id'], $data);
//
//        if (!$res) {
//            throw new \Exception('服务器内部错误');
//        }
//
//
//        return Common::successData();
//    }
    /**
     * 搜索商品库存接口
     * @param Request $request
     * @return null
     */
    public function searchStock (Request $request)
    {

        $data = htmlspecialchars(strip_tags(trim($request->input('value'))));

        if (empty($data)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索内容不能为空'
            ]);
        }
        //名称
        if (preg_match('/^[\x7f-\xff]+$/', $data)) {

            $res = ProductModel::searchName($data);
        } else {

            //sku
            $res = ProductModel::searchSKU($data);
        }


        return Common::successData($res);

    }

    //货架管理
    public function Stock1 ()
    {
        $res = ShelvesModel::get();

        return view('admin.inventory.shelves', ['res' => $res]);
    }

    //库存列表
    public function Stock2 ()
    {
        $res = StockOrderModel::get();
        return view('admin.inventory.inventories', ['res' => $res]);
    }

    //入库
    public function Stock3 ()
    {
        $res = StockOrderModel::where('status', '=', 1)->get();

//        dd($res);
        return view('admin.inventory.instock', ['res' => $res]);
    }

    //出库
    public function Stock4 ()
    {
        $res = StockOrderModel::where('status', '=', 2)->get();

        return view('admin.inventory.outstock', ['res' => $res]);
    }

    //采购
    public function Stock5 ()
    {
        $res = PurchaseOrderModel::get();

        return view('admin.inventory.purchase', ['res' => $res]);
    }

    /**
     * //修改库存接口
     * @param Request $request
     * @return mixed
     */
    public function shelveEditor (Request $request)
    {

        (new ShelveRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['name'])));
        //验证唯一性
        if (ShelvesModel::unique($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '货架名称已存在'
            ]);
        }
        $data = [
            'name' => $name,
            'number' => htmlspecialchars(strip_tags(trim($params['number']))),
            'status' => $params['status']
        ];

        $res = ShelvesModel::updateBrandInfo($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 创建库存接口*
     * @param Request $request
     * @return mixed
     */
    public function shelveInsert (Request $request)
    {

        (new ShelveRule)->goCheck(200);
        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['name'])));
        //验证唯一性
        if (ShelvesModel::uniqueBrand($name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '货架名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'name' => $name,
            'number' => htmlspecialchars(strip_tags(trim($params['number']))),
            'status' => $params['status'],
        ];


        $res = ShelvesModel::insertBrand($data);


        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //删除库存接口
     * @param Request $request
     * @return mixed
     */
    public function shelveDel (Request $request)
    {

        $id = $request->input('id');

        $res = ShelvesModel::delBrand($id);

        return Common::successData();
    }


    //创建订单接口
    public function placeOrder (Request $request)
    {

        (new OrderRule)->goCheck(200);
        (new PurchaseRule)->goCheck(200);

        $params = $request->all();

        return $this->createOrder($params, $params['products']);
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function createOrder ($orderSnap, $uProducts)
    {

        $num = PurchaseOrderModel::orderBy('created_at', 'desc')->first(['order_no']);


        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'P' . substr($orderNo, 1),
            'name' => htmlspecialchars(strip_tags(trim($orderSnap['name']))),
            'total_price' => $orderSnap['price'],
            'total_count' => $orderSnap['num'],
            'supplier' => htmlspecialchars(strip_tags(trim($orderSnap['supplier']))),
            'remark' => htmlspecialchars(strip_tags(trim($orderSnap['remark']))),
        ];

        $res = PurchaseOrderModel::insertOrder($data, $uProducts);


        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderDel (Request $request)
    {

        $id = $request->input('id');

        $res = PurchaseOrderModel::delOrder($id);

        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderBatchDel (Request $request)
    {
        $arr = $request->input('arr');


        $res = PurchaseOrderModel::delSow($arr);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //获取某订单详情接口
     * @param Request $request
     * @return mixed
     */
    public function orderDeal (Request $request)
    {

        $id = $request->input('id');

        $res = PurchaseOrderModel::with(['purchase' => function ($query) {

            $query->with(['products' => function ($querys) {
                $querys->select('id', 'product_image', 'sku', 'zn_name', 'en_name', 'stock', 'price');
            }]);
        }])
            ->where('id', $id)
            ->first();

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
    }

    /**
     * //获取某订单详情接口
     * @param Request $request
     * @return mixed
     */
    public function stockPut (Request $request)
    {

        $params = $request->all();

        if (PurchaseOrderModel::where('id', $params['id'])->first(['status'])->status != 1) {
            throw new ParamsException([
                'code' => 200,
                'message' => '此订单已经处理 不能重复处理'
            ]);
        }
        if ($params['status'] != 1) {
            $purchase = PurchaseOrderModel::updateStatus($params['id'], ['status' => 3]);

            if (!$purchase) {
                throw new \Exception('服务器内部错误');
            }
        } else {

            $purchase = PurchaseOrderModel::with(['purchase' => function ($query) {

                $query->with(['products' => function ($querys) {
                    $querys->select('id', 'sku', 'zn_name', 'en_name', 'stock');
                }]);
            }])
                ->where('id', $params['id'])
                ->first();

            $Products = [];
            foreach ($purchase->purchase as $items) {

                $data = [
                    'product_id' => $items['product_id'],
                    'origin_stock' => $items['products']['stock'],
                    'count' => $items['count'],
                ];
                array_push($Products, $data);

            }
            $this->createStockOrder($params['id'], $purchase->order_no, $Products);


        }

        return Common::successData();
    }

    //写入数据库
    private function createStockOrder ($id, $orderId, $uProducts)
    {

        $num = StockOrderModel::where('status', '=', 1)->orderBy('created_at', 'desc')->first(['order_no']);


        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);

        //构造数据
        $data = [];
        $data = [
            'order_no' => 'I' . substr($orderNo, 1),
            'operator' => '系统自动',
            'pruchase_order_no' => $orderId,
            'remark' => '自动入库',
            'status' => 1,
            'create' => date('Y-m-d')
        ];

        $res = StockOrderModel::insertOrder($id, $data, $uProducts);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

    }

    //创建订单接口
    public function enterPlaceOrder (Request $request)
    {

        (new OrderRule)->goCheck(200);
        (new EnterRule)->goCheck(200);

        $params = $request->all();

        return $this->entercreateOrder($params, $params['uproducts']);
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function entercreateOrder ($orderSnap, $uProducts)
    {

        $num = StockOrderModel::where('status', '=', 1)->orderBy('created_at', 'desc')->first(['order_no']);

        $Product = ProductModel::whereIn('id', array_column($uProducts, 'product_id'))->get(['id', 'stock'])->toArray();
        foreach ($Product as $val) {
            foreach ($uProducts as &$items) {
                if ($val['id'] == $items['product_id']) {
//                 dd($val['id']);
                    $items['origin_stock'] = $val['stock'];

                }
            }
        }

        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'I' . substr($orderNo, 1),
            'operator' => htmlspecialchars(strip_tags(trim($orderSnap['operator']))),
            'total_count' => $orderSnap['num'],
            'pruchase_order_no' => htmlspecialchars(strip_tags(trim($orderSnap['orderId']))),
            'remark' => htmlspecialchars(strip_tags(trim($orderSnap['remark']))),
            'status' => 1,
            'type' => 2,
            'create' => date('Y-m-d')
        ];

        $res = StockOrderModel::insertOrder(null, $data, $uProducts);


        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function enterOrderDel (Request $request)
    {

        $id = $request->input('id');

        $res = StockOrderModel::delOrder($id);

        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function enterOrderBatchDel (Request $request)
    {
        $arr = $request->input('arr');


        $res = StockOrderModel::delSow($arr);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //获取某订单详情接口
     * @param Request $request
     * @return mixed
     */
    public function enterOrderDeal (Request $request)
    {

        $id = $request->input('id');

        $res = StockOrderModel::with(['purchase' => function ($query) {

            $query->with(['products' => function ($querys) {
                $querys->select('id', 'product_image', 'sku', 'zn_name', 'en_name', 'stock', 'price');
            }]);
        }])
            ->where('id', $id)
            ->first();

//        dd($res->toArray());
        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
    }

    //创建订单接口
    public function outPlaceOrder (Request $request)
    {

        (new OrderRule)->goCheck(200);
        (new EnterRule)->goCheck(200);

        $params = $request->all();

        return $this->outcreateOrder($params, $params['uproducts']);
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function outcreateOrder ($orderSnap, $uProducts)
    {

        $num = StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $Product = ProductModel::whereIn('id', array_column($uProducts, 'product_id'))->get(['id', 'stock'])->toArray();
        foreach ($Product as $val) {
            foreach ($uProducts as &$items) {
                if ($val['id'] == $items['product_id']) {

                    $items['origin_stock'] = $val['stock'];

                }
            }
        }

        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'O' . substr($orderNo, 1),
            'operator' => htmlspecialchars(strip_tags(trim($orderSnap['operator']))),
            'total_count' => $orderSnap['num'],
            'pruchase_order_no' => htmlspecialchars(strip_tags(trim($orderSnap['orderId']))),
            'remark' => htmlspecialchars(strip_tags(trim($orderSnap['remark']))),
            'status' => 2,
            'type' => 2,
            'create' => date('Y-m-d')
        ];

        $res = StockOrderModel::reduceOrder(null, $data, $uProducts);


        return Common::successData();
    }


    /**
     * //获取某订单详情接口
     * @param Request $request
     * @return mixed
     */
    public function outOrderDeal (Request $request)
    {

        $id = $request->input('id');

        $res = StockOrderModel::with(['purchase' => function ($query) {

            $query->with(['products' => function ($querys) {
                $querys->select('id', 'product_image', 'sku', 'zn_name', 'en_name', 'stock', 'price');
            }]);
        }])
            ->where('id', $id)
            ->first();

//        dd($res->toArray());
        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
    }

    //自动出库
    public static function stockOut ($id, $orderID, $totalCount)
    {

        $productId = OrderProductModel::where('order_id', '=', $id)->get(['product_id', 'count'])->toArray();

        $num = StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $Product = ProductModel::whereIn('id', array_column($productId, 'product_id'))->get(['id', 'stock'])->toArray();
        foreach ($Product as $val) {
            foreach ($productId as &$items) {
                if ($val['id'] == $items['product_id']) {

                    $items['origin_stock'] = $val['stock'];

                }
            }
        }

        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);

        //构造数据
        $data = [];
        $data = [
            'order_no' => 'O' . substr($orderNo, 1),
            'operator' => '系统',
            'total_count' => $totalCount,
            'pruchase_order_no' => $orderID,
            'remark' => '此出库记录由系统根据用户订单正常生成',
            'status' => 2,
            'type' => 2,
            'create' => date('Y-m-d')
        ];

        $res = StockOrderModel::automaticOrder($data, $productId);

    }
}

