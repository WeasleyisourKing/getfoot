<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\PalletProductModel;
use App\Http\model\Product;
use App\Http\Model\ProductShelvesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\ProductModel;
use App\Http\Model\ShelvesModel;
use App\Http\Model\PurchaseOrderModel;
use App\Http\Model\StockOrderModel;
use App\Http\Model\OrderProductModel;
use App\Http\Model\StockOrderProductModel;
use App\Http\Model\PrivilegeRoleModel;
use App\Http\Model\PalletModel;
use App\Http\Model\SupplierModel;
use App\Http\Controllers\Common;
use App\Rules\StockRule;
use App\Rules\ShelveRule;
use App\Rules\IdRule;
use App\Rules\PurchaseRule;
use App\Rules\OrderRule;
use App\Rules\EnterRule;
use App\Exceptions\ParamsException;
use Illuminate\Support\Facades\Auth;

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
    public function addLibrary($limit)
    {

        $res = ProductModel::getStockProduct($limit);

        return view('admin.stock.stock-add', [
            'data' => $res,
            'limit' => '显示' . $limit . '条'
        ]);
    }


    /**
     * 货架管理页面
     * @param Request $request
     * @return null
     */
    public function stockShelves($limit)
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
    public function productStock(Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->input('data');


        //修改信息
        ProductModel::updateStock($data);

        return Common::successData();
    }

    /**
     * 修改商品减少库存信息接口
     * @param Request $request
     * @return null
     */
    public function productStockSub(Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->input('data');

        //修改信息
        ProductModel::updateStockSub($data);

        return Common::successData();
    }

    /**
     * 搜索商品库存接口
     * @param Request $request
     * @return null
     */
    public function searchStock(Request $request)
    {
        $data = str_replace(' ', '', $request->input('value'));

        $data = htmlspecialchars(strip_tags(trim($data)));

        if (empty($data)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索内容不能为空'
            ]);
        }
        //名称
        if (preg_match('/^[\x7f-\xff]+$/', $data)) {

            $res = ProductModel::searchName($data);

        } else if (preg_match('/^[0-9]*$/', $data)) {

            $res = ProductModel::searchSKU($data);

        } else {
//            'shelves'
            $res = ProductModel::with('distributor')
                ->select('id', 'product_image', 'sku', 'en_name','frozen_stock', 'zn_name', 'stock', 'price', 'innersku', 'number')
                ->where('en_name', 'like', '%' . $data . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }


        return Common::successData($res);

    }

    //货架管理
    public function Stock1()
    {
//        if (!empty($request->input('search'))) {
//            $search = htmlspecialchars(strip_tags(trim($request->input('search'))));
//
//            $res = ShelvesModel::where('name', 'like', '%' . $search . '%')
//                ->with(['goods' => function ($q) {
//
//                    $q->select('en_name', 'zn_name', 'product_image', 'id', 'sku')->limit(3);
//                }])
//
//                ->get()
//                ->toArray();
//        } else {
//            $res = ShelvesModel::with(['goods' => function ($q) {
//
//                $q->select('en_name', 'zn_name', 'product_image', 'id', 'sku');
//
//            }])
//                ->get();
//
//        }
        $res = ShelvesModel::with(['goods' => function ($q) {

            $q->select('en_name', 'zn_name', 'product_image', 'id', 'sku');

        }])
            ->get();
        $shelves = ShelvesModel::get();

        return view('admin.inventory.shelves',
            [
                'res' => $res,
                'shelves' => $shelves
            ]
        );
    }


    //搜索货架接口
    public function shelfSearch(Request $request)
    {

        $search = htmlspecialchars(strip_tags(trim($request->input('search'))));

        $shelves = ShelvesModel::get();

        //中文
        if (preg_match('/^[\x7f-\xff]+$/', $search)) {

            $res = ShelvesModel::with(['goods' => function ($q) use ($search) {

                $q->select('en_name', 'zn_name', 'product_image', 'id', 'sku')
                    ->where('zn_name', 'like', '%' . $search . '%')
                    ->limit(3);

            }])->get()
                ->toArray();

            //去除空数据
            foreach ($res as $k => $items) {

                if (empty($items['goods'])) {
                    unset($res[$k]);
                }
            }

        } else {
//            $res = ShelvesModel::where('number', 'like', '%' . $search . '%')
//            ->with(['goods' => function ($q) {
//
//                $q->select('en_name', 'zn_name', 'product_image', 'id', 'sku')->limit(3);
//            }])
//
//                ->get()
//                ->toArray();
//            dd($res);
            $res = ShelvesModel::where('number', 'like', '%' . $search . '%')
                ->with(['shelve' => function($q) {
                    $q->with(['prod' =>function($qu) {
                        $qu->select('en_name', 'zn_name', 'product_image', 'id', 'sku')->limit(3);
                    }]);
                }])

                ->get()
                ->toArray();
        }

//        foreach ($res as &$items) {
//            $items['goods'] = [];
//            foreach ($items['shelve'] as &$v) {
//                $arr = $v['products'];
//                unset($v['products']);
//                $arr['info'] = $v;
//                $items['goods'][] = $arr;
//
//            }
////            unset($items['shelve']);
//        }
dd($res);
        return view('admin.inventory.shelves',
            [
                'res' => $res,
                'shelves' => $shelves
            ]
        );
    }

    //货架商品接口
    public function shelfGood(Request $request)
    {

        $id = $request->get('id');
        $res = ShelvesModel::with(['goods' => function ($q) {

            $q->select('en_name', 'zn_name', 'product_image', 'id', 'sku');

        }])->where('id', '=', $id)->first();
//        $res = ShelvesModel::with(['goods' => function ($q) {
//            $q->with(['overdue' => function ($qe) {
//                $qe->select('product_id', 'overdue')
//                    ->where('status', '=', 1)
//                    ->orderBy('created_at', 'desc');
//            }, 'shelves'])->select('en_name', 'zn_name', 'stock', 'id', 'sku');
//        }])->where('id', '=', $id)->first();

//        dd($res);
        return Common::successData($res);

    }

    //调拨货架接口
    public function shelfAllocation(Request $request)
    {

        (new ShelveRule)->goCheck(200);

        $params = $request->all();

//        shelve_id : 12 product
//         [{"product_id":146,"total_count":4,"allot":[{"overdue":"2018-01-22","count":2,"shelves_id":12},{"overdue":"2018-01-22","count":2,"shelves_id":22}]},
//         {"product_id":236,"total_count":6,"allot":[{"overdue":"2018-01-21","count":2,"shelves_id":12},{"overdue":"2018-01-21","count":2,"shelves_id":22},{"overdue":"2018-01-21","count":2,"shelves_id":32}]}]

        $name = htmlspecialchars(strip_tags(trim($params['name'])));
//        //验证唯一性
        if (ShelvesModel::unique($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '货架名称已存在'
            ]);
        }
        $datas = [
            'name' => $name,
            'number' => htmlspecialchars(strip_tags(trim($params['number']))),
            'remark' => $params['remark'],
            'status' => $params['status']
        ];

        $product = json_decode($params['product'], true);

//        dd($product);
        $data = [];
        //验证 调拨数量不和总数相同 某一件商品的货架不能重复出现
        foreach ($product as &$items) {
            $total = 0;
            $arr = [];
            if (!empty($items['allot'])) {
                foreach ($items['allot'] as &$v) {
                    if ($v['shelves_id'] == $params['shelve_id']) {

                        throw new ParamsException([
                            'code' => 200,
                            'message' => '调拨不能选择自身货架'
                        ]);
                    }
                    $v['product_id'] = $items['product_id'];
                    $total += $v['count'];
                    array_push($arr, $v['shelves_id']);

                }

                if ($items['total_count'] < $total) {

                    throw new ParamsException([
                        'code' => 200,
                        'message' => '调拨总数不能大于商品数'
                    ]);
                }
                if (count($items['allot']) != count(array_unique($arr))) {

                    throw new ParamsException([
                        'code' => 200,
                        'message' => '同一商品下出现相同货架'
                    ]);
                }

                $data = array_merge($data, $items['allot']);
            } else {
                continue;
            }

        }
        ShelvesModel::updateBrandInfo($params['shelve_id'], $datas);
//        dump($data);
        if (!empty($data)) {
            //调拨了货架
            ProductShelvesModel::allocation($params['shelve_id'], $data);

        }

        return Common::successData();
    }


    //库存列表
    public function Stock2()
    {
        $res = ProductModel::with('info')
            ->select('id', 'product_image', 'sku', 'en_name', 'zn_name', 'stock')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.inventory.inventories', ['res' => $res]);
    }

    //入库
    public function Stock3()
    {
        $res = StockOrderModel::where('status', '=', 1)->get();
        $shelves = ShelvesModel::get();

        $auth = array_column(PrivilegeRoleModel::where('privilege_id', '=', 34)
            ->get(['role_id'])
            ->toArray(), 'role_id');

        return view('admin.inventory.instock', ['res' => $res, 'auth' => $auth, 'shelves' => $shelves]);
    }

    //出库页面
    public function Stock4()
    {
        //获取全部数据
        $res = StockOrderModel::where('status', '=', 2)->get();

//        dump($res->toArray());
        $arr = [];
        foreach ($res as $k => $val) {
            $value = substr($val->pruchase_order_no, 0, 2);
            if (!empty($value) && $value == 'ST') {
                array_push($arr, $val);
                unset($res[$k]);
            }
        }

        $auth = array_column(PrivilegeRoleModel::where('privilege_id', '=', 35)
            ->get(['role_id'])
            ->toArray(), 'role_id');
//        dump($auth);
        return view('admin.inventory.outstock', [
            'res' => $res,
            'pruchase' => $arr,
            'auth' => $auth
        ]);
    }

    //采购
    public function Stock5()
    {
        $res = PurchaseOrderModel::orderBy('order_no', 'desc')->get();
        $shelves = ShelvesModel::get();
        $supplier = SupplierModel::get();
//        dd($res->toArray());
        $auth = array_column(PrivilegeRoleModel::where('privilege_id', '=', 36)
            ->get(['role_id'])
            ->toArray(), 'role_id');

        return view('admin.inventory.purchase', ['res' => $res, 'auth' => $auth, 'shelves' => $shelves, 'supplier' => $supplier]);
    }

    //上架页面
    public function upper()
    {
        return view('admin.inventory.upper');
    }

    public function getUpper()
    {
        $pallet = PurchaseOrderModel::with(['pallet' => function ($q) {
            $q->with(['name' => function ($qu) {
                $qu->select('id', 'number', 'status');
//                    ->where('status', '=', 2);
            }, 'product' => function ($que) {
                $que->select('id', 'en_name', 'zn_name', 'product_image');
            }])
                ->select('product_id', 'pallet_id', 'overdue', 'count', 'order_id');
        }])
            ->select('order_no', 'id', 'total_count', 'status')
            ->where('status', '=', 2)
            ->orderBy('created_at', 'desc')
//            ->whereIn('id', [ 107,110])
            ->get()->toArray();
//dd($pallet);
        $pallet = $this->halder(array_column($pallet, 'pallet'));
//        dump($pallet);
        $shelves = ShelvesModel::where('status', '=', 2)->get();
//dd($pallet);
        return Common::successData(['pallet' => $pallet, 'shelves' => $shelves]);
    }

    //分组
    public function halder($arr)
    {

        $arrays = $array = [];

        foreach ($arr as $v) {
            foreach ($v as $vo) {

                if ($vo['name']['status'] != 2) {
                    //处理过
                    continue;
                }
                $arrays[$vo['name']['number']][] = $vo;

            }
        }

        return $arrays;
    }

    //托盘货架选择接口
    public function palletSelect(Request $request)
    {
        $params = $request->all();

//        $pas = {"pallet_id":22,"shelves":12,
//       "product":[{"product_id":146,"count":1,"overdue":"2018-01-22"},{"product_id":236,"count":2,"overdue":"2018-01-21"}]};
        $params['product'] = json_decode($params['product'], true);

        //验证相应采购订单状态为审核过
        $in = array_column(PalletProductModel::where('pallet_id', '=', $params['pallet_id'])->get(['order_id'])->toArray(), 'order_id');
        $collect = PurchaseOrderModel::whereIn('id', $in)->get(['order_no', 'status'])->toArray();

        foreach ($collect as $it) {
            if ($it['status'] != 2) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => $it['order_no'] . '未审核确认，不能入货架'
                ]);
            }
        }
//        dd($params['product']);
        $number = 0;
        foreach ($params['product'] as &$items) {

            $items['shelves_id'] = $params['shelves'];
            $number += $items['count'];

        }


        $num = StockOrderModel::where('status', '=', 1)->orderBy('created_at', 'desc')->first(['order_no']);

        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);

        //构造数据
        $data = [];
        $data = [
            'order_no' => 'I' . $orderNo,
            'operator' => '系统自动',
            'pruchase_order_no' => -2,
            'remark' => '自动入库',
            'total_count' => $number,
            'snapshot' => json_encode($params['product']),
            'status' => 1,
            'state' => 2
        ];
//        dd($params['product']);
        ProductShelvesModel::insertStockShelve($data, $params['product'], $params['pallet_id'], $params['shelves']);


        return Common::successData();
    }

    //写入数据库
    private function createStockOrder($id, $uProducts, $number, $state = null)
    {

        $num = StockOrderModel::where('status', '=', 1)->orderBy('created_at', 'desc')->first(['order_no']);


        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);

        //构造数据
        $data = [];
        $data = [
            'order_no' => 'I' . $orderNo,
            'operator' => '系统自动',
//            'pruchase_order_no' => $orderId,
            'remark' => '自动入库',
            'total_count' => $number,
            'status' => 1,
            'state' => 2
        ];

//        if (!is_null($state)) {
//            $data['remark'] = '非直接入库确认，入库数量与订单数量存在误差';
//        }
        $res = StockOrderModel::insertOrder($id, $data, $uProducts);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

    }

    /**
     * //修改库存接口
     * @param Request $request
     * @return mixed
     */
    public function shelveEditor(Request $request)
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
            'remark' => $params['remark'],
            'status' => $params['status']
        ];


//        dd($params['shelves']);
//        $shelves = !empty($params['shelves']) ? array_column($params['shelves'], 'id') : null;

        //修改货架下商品
        if (!empty($params['shelves'])) {
            $shelves = array_column($params['shelves'], 'id');
            ShelvesModel::updateBrandInfo($params['id'], $data, $params['shelves'], $shelves);
        } else {
            //未修改
            ShelvesModel::updateBrandInfo($params['id'], $data, null, null);
        }


        return Common::successData();
    }

    /**
     * 创建库存接口*
     * @param Request $request
     * @return mixed
     */
    public function shelveInsert(Request $request)
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
            'remark' => $params['remark'],
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
    public function shelveDel(Request $request)
    {

        $id = $request->input('id');
        $res = ProductShelvesModel::where('shelves_id', '=', $id)->get();

        if (!$res->isEmpty()) {
            throw new ParamsException([
                'code' => 200,
                'message' => '货架下存在商品，不能删除'
            ]);

        }
        $res = ShelvesModel::delBrand($id);

        return Common::successData();
    }


    //创建订单接口
    public function placeOrder(Request $request)
    {

        (new OrderRule)->goCheck(200);
        (new PurchaseRule)->goCheck(200);


        $params = $request->all();


//        [{"count":2,"need_count":2, "pallet":[{"pallet_id":"001","overdue":"2018-01-21","count":1},{"pallet_id":"002","overdue":"2018-01-21","count":1}], "product_id":236},
//        {"count":4,"need_count":3,"pallet":[{"pallet_id":"002","overdue":"2018-01-22","count":1},{"pallet_id":"003","overdue":"2018-01-22","count":3}],  "product_id":146}]

        $params['products'] = json_decode($params['products'], true);
//        dd($params['uproducts']);

        //如果金额空 自动计算
        if (empty($params['price'])) {

            $price = 0;
            $set = ProductModel::whereIn('id', array_column($params['products'], 'product_id'))->get(['id', 'price'])->toArray();

            foreach ($set as $item) {
                foreach ($params['products'] as &$val) {
                    if ($item['id'] == $val['product_id']) {
                        $val['single_price'] = $item['price'];
                        $val['total_price'] = $val['count'] * $item['price'];
                        $price += $val['count'] * $item['price'];
                    }
                }
            }
            $params['price'] = $price;
        }

        return $this->createOrder($params);
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function createOrder($orderSnap)
    {

        $num = PurchaseOrderModel::orderBy('created_at', 'desc')->first(['order_no']);

        $orderNo = Common::makeOrderNo(is_null($num) ? 'PO2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'PO' . $orderNo,
            'name' => htmlspecialchars(strip_tags(trim($orderSnap['name']))),
            'total_price' => $orderSnap['price'],
            'total_count' => $orderSnap['num'],
            'supplier' => htmlspecialchars(strip_tags(trim($orderSnap['supplier']))),
            'remark' => htmlspecialchars(strip_tags(trim($orderSnap['remark']))),
        ];


        $res = PurchaseOrderModel::insertOrder($data, $orderSnap['products']);


        return Common::successData();
    }

    public function getPalletID($arr)
    {

        $array = [];
//dd($arr);
        foreach ($arr as &$v) {
            foreach ($v['pallet'] as &$val) {

                //一个pallet只允许存在一个订单下的商品
                if (!in_array($val['pallet_id'], array_keys($array))) {
                    $state = PalletModel::where('status', '=', 2)->where('number', '=', $val['pallet_id'])->first();

                    //不存在插入 存在获取id
                    if (is_null($state)) {
                        $midd = $val['pallet_id'];
                        $val['pallet_id'] = palletModel::insertGetId(['number' => $val['pallet_id']]);
                        $array[$midd] = $val['pallet_id'];


                    } else {

                        palletModel::whereIn('number', array_keys($array))->delete();

                        throw new ParamsException([
                            'code' => 200,
                            'message' => 'pallet编号为' . $state->number . '已经存在商品，请先上架或者重命名'
                        ]);

                    }
                } else {
                    foreach ($array as $k => $items) {
                        if ($k == $val['pallet_id']) {
                            $val['pallet_id'] = $items;
                        }
                    }
                }
            }
        }

        return $arr;

    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderDel(Request $request)
    {

        $id = $request->input('id');

        PurchaseOrderModel::delOrder($id);

        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderBatchDel(Request $request)
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
    public function orderDeal(Request $request)
    {

        $id = $request->input('id');

        $res = PurchaseOrderModel::with(['purchase' => function ($query) {

            $query->with(['products' => function ($querys) {

                $querys->select('id', 'product_image', 'sku', 'innersku', 'number', 'zn_name', 'en_name', 'stock', 'price');
            }, 'pallets' => function ($q) {
                $q->with('name');
            }]);

        }])
            ->where('id', $id)
            ->first()
            ->toArray();

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        $res = $this->filterPallets($res);
        if ($res['status'] != 1) {
            $index1 = $index2 = $arr1 = $arr2 = $arr3 = [];
            foreach ($res['purchase'] as &$item) {
                $ar = explode('|', $item['differ_count']);

                if ($ar[0] == 1) {
                    if ($ar[1] != 0) {
                        $index1[] = $item['sort'] = $ar[1];

                        array_push($arr1, $item);
                    } else {
                        array_push($arr2, $item);
                    }
                } else {
                    $index2[] = $item['sort'] = $ar[1];
                    array_push($arr3, $item);
                }

            }
            array_multisort($index1, SORT_DESC, $arr1);
            array_multisort($index2, SORT_DESC, $arr3);
            $res['purchase'] = array_merge($arr1, $arr2, $arr3);
        }

        return Common::successData($res);
    }

    public function filterPallets($data)
    {
        foreach ($data['purchase'] as &$itemns) {
            foreach ($itemns['pallets'] as $k => $v) {

                if ($itemns['product_id'] != $v['product_id']) {

                    unset($itemns['pallets'][$k]);

                }
            }
            sort($itemns['pallets']);

        }

        return $data;
    }

    /**
     * //采购订单修改接口
     * @param Request $request
     * @return mixed
     */
    public function stockPut(Request $request)
    {


        $params = $request->all();

        if (PurchaseOrderModel::where('id', $params['id'])->first(['status'])->status != 1) {

            throw new ParamsException([
                'code' => 200,
                'message' => '此订单已经处理 不能重复处理'
            ]);
        }

//  [{"count":5,"need_count":5, "pallet":[{"pallet_id":"001","overdue":"2018-01-21","count":2},{"pallet_id":"002","overdue":"2018-01-21","count":3}], "product_id":236},
//  {"count":3, "need_count":4,"pallet":[{"pallet_id":"002","overdue":"2018-01-22","count":1},{"pallet_id":"003","overdue":"2018-01-22","count":1},{"pallet_id":"004","overdue":"2018-01-22","count":1}],"product_id":146}]

        $params['uproducts'] = json_decode($params['uproducts'], true);

        //验证
        foreach ($params['uproducts'] as $k => &$items) {
            $arr = [];
            $num = 0;

            $items['differ_count'] = $items['count'] - $items['need_count'];

            //计算差异量
            if ($items['differ_count'] < 0) {
                $items['differ_count'] = '2|' . abs($items['differ_count']);
            } else {
                $items['differ_count'] = '1|' . $items['differ_count'];
            }

            foreach ($items['pallet'] as $v) {

                $num += $v['count'];
                array_push($arr, $v['pallet_id']);
                if (empty($v['overdue']))
                    throw new ParamsException([
                        'code' => 200,
                        'message' => '商品过期时间未填写'
                    ]);
            }

            if (empty($arr) || (count(array_unique($arr)) != count($items['pallet'])))
                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品未选择pallet或者pallet重复'
                ]);

            unset($items['need_count']);

            //替换实际数量
            $items['count'] = $num;
        }


        //过滤pallet
        $params['uproducts'] = $this->getPalletID($params['uproducts']);


        $price = 0;
        $set = ProductModel::whereIn('id', array_column($params['uproducts'], 'product_id'))->get(['id', 'price'])->toArray();

        foreach ($set as $k => $item) {
            foreach ($params['uproducts'] as &$val) {

                if ($item['id'] == $val['product_id']) {
                    $val['total_price'] = $val['count'] * $item['price'];
                    $val['single_price'] = $item['price'];
                    $price += $val['count'] * $item['price'];
                }
            }
        }

//        dump($set);
//    dd($params['uproducts']);
//dd($params['uproducts']);
        PurchaseOrderModel::updateOrder($params['id'], $params['uproducts'], $price, array_sum(array_column($params['uproducts'], 'count')));

        return Common::successData();

    }


    //创建订单接口
    public function enterPlaceOrder(Request $request)
    {

        (new OrderRule)->goCheck(200);
        (new EnterRule)->goCheck(200);

        $params = $request->all();

//        [{"count":2,"shelve":[{"shelve_id":"13","overdue":"2018-01-21","count":1},{"shelve_id":"12","overdue":"2018-01-21","count":1}], "product_id":236},
//        {"count":4,"shelve":[{"shelve_id":"14","overdue":"2018-01-22","count":1},{"shelve_id":"13","overdue":"2018-01-22","count":3}],  "product_id":146}]
//        $params['uproducts'] = json_decode($params['uproducts'], true);

//dd($params['uproducts']);
        $num = StockOrderModel::where('status', '=', 1)->orderBy('created_at', 'desc')->first(['order_no']);

        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'I' . $orderNo,
            'operator' => htmlspecialchars(strip_tags(trim($params['operator']))),
            'total_count' => $params['num'],
            'pruchase_order_no' => htmlspecialchars(strip_tags(trim($params['orderId']))),
            'remark' => htmlspecialchars(strip_tags(trim($params['remark']))),
//            'snapshot' => json_encode($params['uproducts']),
            'status' => 1,
            'type' => 2,
            'return' => $params['inStock']
        ];

        //创建手动订单
        $res = StockOrderModel::createHandOrder($data, $params['uproducts']);

        return Common::successData();


    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function entercreateOrder($orderSnap, $uProducts)
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
            'order_no' => 'I' . $orderNo,
            'operator' => htmlspecialchars(strip_tags(trim($orderSnap['operator']))),
            'total_count' => $orderSnap['num'],
            'pruchase_order_no' => htmlspecialchars(strip_tags(trim($orderSnap['orderId']))),
            'remark' => htmlspecialchars(strip_tags(trim($orderSnap['remark']))),
            'status' => 1,
            'type' => 1
        ];

        $res = StockOrderModel::insertOrder(null, $data, $uProducts);


        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function enterOrderDel(Request $request)
    {

        $id = $request->input('id');

        $object = StockOrderModel::find($id);
        $status = -1;

        if ($object->state != 1) {
            throw new ParamsException([
                'code' => 200,
                'message' => '出库状态为已完成，不能删除'
            ]);
        }

        //关系到商业订单
        if (!is_null($object->pruchase_order_no) && substr($object->pruchase_order_no, 0, 2) == 'ST') {
            $obj = \App\Http\Model\BusinessOrderModel::where('order_no', '=', $object->pruchase_order_no)->first();
            //已完成
            if ($obj->status != 2) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '出库状态为不一致，关联的商业订单状态为已完成'
                ]);
            }
            $status = 1;
        }

        if ($status != -1) {

            //关联商业订单
            StockOrderModel::delOrder($id, $obj->id);
        } else {

            StockOrderModel::delOrder($id);
        }


        return Common::successData();
    }

    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function enterOrderBatchDel(Request $request)
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
    public function enterOrderDeal(Request $request)
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
    public function outPlaceOrder(Request $request)
    {

        (new OrderRule)->goCheck(200);
        (new EnterRule)->goCheck(200);

        $params = $request->all();

//        [{"count":"2","product_id":"146","overdue":"2018-0-01",
//        "postion":[{"product_id":"146","shelves_id":"1","count":"1","overdue":"2019-01-03"},
//        {"product_id":"146","shelves_id":"2","count":"2","overdue":"2019-01-02"}]},
//        {"count":"1","product_id":"236","overdue":"2018-0-01",
//            "postion":[{"product_id":"236","shelves_id":"1","count":"2","overdue":"2019-01-08"},
//            {"product_id":"236","shelves_id":"2","count":"3","overdue":"2019-01-03"}]}]

        $params['uproducts'] = json_decode($params['uproducts'], true);
        $info = [];

//        dump($params['uproducts']);
        //验证
        foreach ($params['uproducts'] as &$item) {

            $nums = ProductShelvesModel::with('name')->whereIn('product_id', array_column($item['postion'], 'product_id'))->get()->toArray();

            //数量是否超过货架存储数量
            foreach ($item['postion'] as &$v) {
                foreach ($nums as $vo) {

                    if ($vo['overdue'] == $v['overdue'] && $vo['shelves_id'] == $v['shelves_id']) {
                        $v['name'] = $vo['name']['name'];
                        if ($vo['count'] < $v['count']) {
                            throw new ParamsException([
                                'code' => 200,
                                'message' => '商品' . ProductModel::where('id', '=', $vo['product_id'])->first(['zn_name'])->zn_name . '货架为' . $vo['name']['name']
                                    . '过期日期是' . $vo['overdue'] . '库存为' . $vo['count'] . '，填写数量超过货架数量'
                            ]);
                        }
                    }
                }

            }

            //检测总数是否超过
            if ($item['count'] != array_sum(array_column($item['postion'], 'count'))) {

                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品数量和选择货架数量不一致'
                ]);
            }

            $info[] = $item['postion'];

        }

        $num = StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $Product = ProductModel::whereIn('id', array_column($params['uproducts'], 'product_id'))->get(['id', 'zn_name', 'stock','frozen_stock'])->toArray();
        foreach ($Product as $val) {
            foreach ($params['uproducts'] as &$items) {

                if ($val['id'] == $items['product_id']) {

                    if ($val['stock'] == 0 || $val['stock'] - $items['count'] < 0) {
                        throw new ParamsException([
                            'code' => 200,
                            'message' => '商品' . $val['zn_name'] . '实际库存'.$val['origin_stock'] .'冻结库存'.$val['frozen_stock'].'，库存不足'
                        ]);
                    }
//                    $items['origin_stock'] = $val['stock'];

                }
            }
        }


        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'O' . $orderNo,
            'operator' => htmlspecialchars(strip_tags(trim($params['operator']))),
            'total_count' => $params['num'],
//            'pruchase_order_no' => htmlspecialchars(strip_tags(trim($params['orderId']))),
            'pruchase_order_no' => -1,
            'remark' => htmlspecialchars(strip_tags(trim($params['remark']))),
            'shelve_position' => json_encode($info),
            'status' => 2,
            'type' => 2
        ];


        StockOrderModel::handOutOrder($data, $params['uproducts']);

        return Common::successData();

    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function outcreateOrder($orderSnap, $uProducts)
    {

        $num = StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $Product = ProductModel::whereIn('id', array_column($uProducts, 'product_id'))->get(['id', 'zn_name', 'stock'])->toArray();
        foreach ($Product as $val) {
            foreach ($uProducts as &$items) {

                if ($val['id'] == $items['product_id']) {

                    if ($val['stock'] == 0 || $val['stock'] - $items['count'] < 0) {
                        throw new ParamsException([
                            'code' => 200,
                            'message' => '商品' . $val['zn_name'] . '库存不足'
                        ]);
                    }
                    $items['origin_stock'] = $val['stock'];

                }
            }
        }

        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'O' . $orderNo,
            'operator' => htmlspecialchars(strip_tags(trim($orderSnap['operator']))),
            'total_count' => $orderSnap['num'],
            'pruchase_order_no' => htmlspecialchars(strip_tags(trim($orderSnap['orderId']))),
            'remark' => htmlspecialchars(strip_tags(trim($orderSnap['remark']))),
            'status' => 2,
            'type' => 1
        ];

        $res = StockOrderModel::reduceOrder(null, $data, $uProducts);


        return Common::successData();
    }


    /**
     * //获取某订单详情接口
     * @param Request $request
     * @return mixed
     */
    public function outOrderDeal(Request $request)
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
    public static function stockOut($id, $orderID, $totalCount)
    {

        $productId = OrderProductModel::where('order_id', '=', $id)->get(['product_id', 'count'])->toArray();

        $num = StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $Product = ProductModel::whereIn('id', array_column($productId, 'product_id'))->get(['id', 'stock'])->toArray();
        foreach ($Product as $val) {
            foreach ($productId as &$items) {
                if ($val['id'] == $items['product_id']) {

                    //支付成功 已经减库存 现在加入
                    $items['origin_stock'] = $val['stock'] + $items['count'];


                }
            }
        }


        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);

        //构造数据
        $data = [];
        $data = [
            'order_no' => 'O' . $orderNo,
            'operator' => '系统',
            'total_count' => $totalCount,
            'pruchase_order_no' => $orderID,
            'remark' => '此出库记录由系统根据用户订单正常生成',
            'status' => 2,
            'type' => 1
        ];

        $res = StockOrderModel::automaticOrder($data, $productId);

    }

    /**
     * 修改商品添加库存信息接口
     * @param Request $request
     * @return null
     */
    public function productStockDeal(Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->all();


        if ($data['data'][0]['count'] > 0) {
            //入库
            $params = [
                'operator' => 'Admin',
                'num' => $data['count'],
                'orderId' => '无',
                'remark' => '库存清点',
                'status' => 1,
                'type' => 2
            ];

            $this->entercreateOrder($params, $data['data']);
        } else {
            //出库 修改信息

            foreach ($data['data'] as &$items) {
                $items['count'] = abs($items['count']);

            }

            $params = [
                'operator' => 'Admin',
                'num' => $data['count'],
                'orderId' => '无',
                'remark' => '库存清点',
                'status' => 2,
                'type' => 2
            ];
            $this->outcreateOrder($params, $data['data']);

        }

        return Common::successData();
    }

    /**
     * 确认订单接口
     * @param Request $request
     * @return null
     */
    public function stockCheck($id, $status, $num)
    {
        //入库确定
        $data = StockOrderProductModel::where('order_id', '=', $id)->get(['product_id', 'count'])->toArray();
        $Product = ProductModel::whereIn('id', array_column($data, 'product_id'))->get(['id', 'stock'])->toArray();
        if ($status == 1) {
            foreach ($Product as $val) {
                foreach ($data as &$items) {
                    if ($val['id'] == $items['product_id']) {

                        $items['origin_stock'] = $val['stock'];

                    }
                }
            }

            StockOrderModel::check($id, $data, 1);
        } else {

            //入库修改确定
            foreach ($Product as $val) {
                foreach ($uProducts as &$items) {

                    if ($val['id'] == $items['product_id']) {

                        if ($val['stock'] == 0 || $val['stock'] - $items['count'] < 0) {
                            throw new ParamsException([
                                'code' => 200,
                                'message' => '商品' . $val['zn_name'] . '库存不足'
                            ]);
                        }
                        $items['origin_stock'] = $val['stock'];

                    }
                }
            }

            StockOrderModel::check($id, $data, 2, $num);
        }
        return Common::successData();

    }

    /**
     * //获取某订单详情接口
     * @param Request $request
     * @return mixed
     */
    public function stockInConfirm(Request $request)
    {

        $params = $request->all();

        if (StockOrderModel::where('id', $params['id'])->first(['state'])->state != 1) {

            throw new ParamsException([
                'code' => 200,
                'message' => '此订单已经处理 不能重复处理'
            ]);
        }
        if ($params['status'] != 1) {
            //update in stock

            $set = ProductModel::whereIn('id', array_column($params['products'], 'product_id'))->get(['id', 'price', 'stock'])->toArray();


            foreach ($set as $items) {
                foreach ($params['uproducts'] as &$val) {
                    if ($items['id'] == $val['product_id']) {
                        $val['origin_stock'] = $items['stock'];
                    }
                }
            }

            StockOrderModel::check($params['id'], $params['uproducts'], 2, $params['num']);


        } else {

            //入库确定
            $data = StockOrderProductModel::where('order_id', '=', $params['id'])->get(['product_id', 'count'])->toArray();
            $Product = ProductModel::whereIn('id', array_column($data, 'product_id'))->get(['id', 'stock'])->toArray();

            foreach ($Product as $val) {
                foreach ($data as &$items) {
                    if ($val['id'] == $items['product_id']) {

                        $items['origin_stock'] = $val['stock'];

                    }
                }
            }
            StockOrderModel::check($params['id'], $data, 1);

        }
        return Common::successData();
    }

    //出库手动确认接口
    //不管有没有修改库存 直接验证库存是否足够 足够在执行减库存
    public function stockOutConfirm(Request $request)
    {

        $params = $request->all();

        //查找
        if (StockOrderModel::where('id', $params['id'])->first(['state'])->state != 1) {

            throw new ParamsException([
                'code' => 200,
                'message' => '此订单已经处理 不能重复处理'
            ]);
        }


        $set = ProductModel::whereIn('id', array_column($params['uproducts'], 'product_id'))->get(['id', 'price', 'stock', 'zn_name'])->toArray();

        //检测库存
        foreach ($set as $val) {
            foreach ($params['uproducts'] as &$items) {

                if ($val['id'] == $items['product_id']) {

                    if ($val['stock'] == 0 || $val['stock'] - $items['count'] < 0) {
                        throw new ParamsException([
                            'code' => 200,
                            'message' => '商品' . $val['zn_name'] . '库存不足'
                        ]);
                    }
                    $items['origin_stock'] = $val['stock'];
                }
            }
        }
//        dd($params['uproducts']);
        //status 1: 自建手动出库 2:：商业订单
        $info = StockOrderModel::find($params['id']);

        $shelve = $params['status'] != 2 ? json_decode($info->shelve_position, true) : json_decode(\App\Http\Model\BusinessOrderModel::where('order_no', '=', $info->pruchase_order_no)->first(['shelve_position'])->shelve_position, true);



        //验证
        foreach ($shelve as &$item) {

            $nums = ProductShelvesModel::whereIn('product_id', array_column($item, 'product_id'))->get()->toArray();

            //数量是否超过货架存储数量
            foreach ($item as $k => $v) {

                foreach ($nums as $vo) {
                    if ($vo['overdue'] == $v['overdue'] && $vo['shelves_id'] == $v['shelves_id']) {

                        unset($item[$k]);
                        if ($vo['count'] < $v['count']) {
                            throw new ParamsException([
                                'code' => 200,
                                'message' => '商品是' . ProductModel::where('id', '=', $vo['product_id'])->first(['zn_name'])->zn_name . '且货架为' . $v['name']
                                    . '且日期是' . $vo['overdue'] . '库存为' . $vo['count'] . '，出库数量超过货架数量'
                            ]);
                        }
                    }
                }

                if (!empty($item[$k])) {
                    throw new ParamsException([
                        'code' => 200,
                        'message' => '货架名为' . $v['name']
                            . '且日期是' . $v['overdue'] . '的货架没有' . ProductModel::where('id', '=', $v['product_id'])->first(['zn_name'])->zn_name . '商品'
                    ]);
                }
            }
        }

        StockOrderModel::updatestate($params['id'], $params['uproducts'], $params['num'], $params['status']);

        return Common::successData();
    }

    //添加商品货架选择接口
    public function selectShelves(Request $request)
    {

        $id = $request->input('id');

        $data = ProductShelvesModel::with(['name' => function ($q) {
            $q->select('id', 'name');
        }])->where('product_id', '=', $id)->orderBy('overdue', 'asc')
            ->orderBy('count', 'asc')
            ->get()
            ->toArray();

        foreach ($data as &$iems) {
            $iems['name'] = $iems['name']['name'];
        }
        return Common::successData($data);
    }
}

