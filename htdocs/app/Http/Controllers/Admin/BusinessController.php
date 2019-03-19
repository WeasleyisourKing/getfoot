<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\ProductShelvesModel;
use App\Http\Model\ShelvesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\ProductModel;
use App\Http\Controllers\Common;
use App\Rules\AddressRule;
use App\Rules\OrderRule;
use App\Exceptions\ParamsException;
use Illuminate\Support\Facades\Auth;

/**
 * 订单管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class BusinessController extends Controller
{

    //用户订单商品列表
    protected $uProducts;

    //数据库商品信息
    protected $products;

    //数据库商品信息
    protected $addressInfo;

    protected $Plevel;

    /**
     * 订单列表页面
     * @param Request $request
     * @return null
     */
    public function businessList($status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];
        //默认显示已完成
        switch ($status) {
            case 1 :
                $title = '已完成';
                break;
            default :
                $title = ' 已下单';
        }

        $res = BusinessOrderModel::getOrderList($statusData, $limit);

//        dump($res->toArray());
        return view('admin.business.business-order', [
            'data' => $res,
            'title' => $title,
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 商业订单详情页面
     * @param Request $request
     * @return null
     */
    public function orderDetail($id, $status)
    {


        $ress = BusinessOrderModel::with(['purchase' => function ($query) {

            $query->with(['products' => function ($querys) {
                $querys->select('id', 'product_image', 'sku', 'innersku', 'number', 'zn_name', 'en_name', 'stock', 'price');
            }]);
        }])
            ->where('id', $id)
            ->first()
            ->toArray();

        //数据太大 防止内存溢出
        $address = json_decode($ress['snap_address'], true);

        $shelves = json_decode($ress['shelve_position'], true);
        unset($ress['shelve_position']);

        foreach ($ress['purchase'] as &$items) {
            foreach ($shelves as $key => $v) {

                if ($key == $items['product_id']) {
                    $items['shelves'] = $v;
                }
            }
        }

//        dump($ress);
        return view('admin.business.order-detail',
            [
                'data' => $ress,
                'address' => $address,
                'status' => $status
            ]);
    }


    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderDel(Request $request)
    {

        $id = $request->input('id');
        //已完成不能删除
        $object = BusinessOrderModel::find($id);
        if ($object->status != 2) {
            throw new ParamsException([
                'code' => 200,
                'message' => '状态为已完成不能删除'
            ]);
        }

        $res = BusinessOrderModel::delOrder($id, $object->order_no);

        return Common::successData();
    }


    //后台创建商业订单接口
    public function placeOrder(Request $request)
    {


        (new OrderRule)->goCheck(200);
        (new AddressRule)->goCheck(200);

        $params = $request->all();
        $uProducts = $params['uproducts'];

        //删除其他剩下地址
        unset($params['uproducts']);
        unset($params['products']);
        unset($params['_token']);

        switch ($params['pstatus']) {

            case 1 :
                $this->Plevel = 'price';
                break;
            case 2 :
                $this->Plevel = 'level_two_price';
                break;
            case 3 :
                $this->Plevel = 'level_one_price';
                break;
            case 4 :
                $this->Plevel = 'level_three_price';
                break;
            default :
                $this->Plevel = 'level_four_price';
        }

        return $this->place($params, $uProducts);
    }

    /**
     * 用户下单 比对数据库 存入数据
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function place($addressInfo, $uProducts)
    {

        //属性赋值
        $this->uProducts = $uProducts;
        $this->products = $this->getProductsByOrder($uProducts);
        $this->addressInfo = $addressInfo;

        //数据库比对调用
        //某商品库存不够
        $status = $this->getOrderStatus();

        foreach ($status['pStatusArray'] as $k => $item) {
            if ($item['haveStock'] != true) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品' . $item['znName'] . '库存不足；'
                ]);

            }

            unset($status['pStatusArray'][$k]['haveStock']);
            unset($status['pStatusArray'][$k]['znName']);

        }

        //有存货 创建订单
        $snapshootOrder = $this->snapshootOrder($status);

        //写入数据库 订单号 购买商品
        //订单和商品关系 多对多
        $order = self::createOrder($snapshootOrder);

        return Common::successData($order);

    }


    //根据用户订单查找数据库商品信息
    private function getProductsByOrder($uProducts)
    {

        $opIds = [];
        foreach ($uProducts as $item) {
            $opIds[] = $item['product_id'];
        }

        //查询商品信息
        $Products = ProductModel::getProduct($opIds);

        //可能下架
        foreach ($Products as $item) {
            if ($item['status'] != 1) {
                throw new ParamsException([
                    'message' => $item['zn_name'] . '商品已经下架',
                    'errorCode' => 7001,
                    'code' => 200
                ]);
            }
        }

        return $Products;
    }

    //与数据库比较库存量结果
    private function getOrderStatus()
    {

        //用户一次下订单属性
        $status = [
            //是否通过
            'status' => true,
            //总价格
            'orderPrice' => 0,
            //总数量
            'totalCount' => 0,
            //商品详细信息
            'pStatusArray' => []
        ];

        //库存商品和用户所需比较
        foreach ($this->uProducts as $uProduct) {

            $pStatus = $this->getProductStatus($uProduct['product_id'], $uProduct['count'], $uProduct['overdue'], $this->products);

            //一件商品没货
            if (!$pStatus['haveStock']) {
                $status['status'] = false;
            }

            $status['orderPrice'] += $pStatus['total_price'];
            $status['totalCount'] += $pStatus['count'];
            $status['pStatusArray'][] = $pStatus;

        }

        return $status;

    }

    //判断某一件商品是否有货及各项属性
    //用户某件商品id 用户某件商品总数 数据库数据
    private function getProductStatus($uPID, $uCount, $overdue, $products)
    {

        //某商品详细信息
        $pStatus = [
            'product_id' => '',
            //是否有商品
            'haveStock' => '',
            'count' => 0,
            //全部价格
            'total_price' => 0
        ];
        $pIdex = -1;
        //对比数据库是否有数据
        for ($i = 0; $i < count($products); $i++) {

            if ($uPID == $products[$i]['id']) {
                $pIdex = $i;
            }
        }
        if ($pIdex == -1) {
            throw new ParamsException([
                'message' => 'id为' . $uPID . '商品不存在'
            ]);
        } else {


            $product = $products[$pIdex];
            $pStatus['product_id'] = $product['id'];
            $pStatus['znName'] = $product['zn_name'];
            $pStatus['overdue'] = $overdue;
//            $pStatus['enName'] = $product['en_name'];
//            $pStatus['sku'] = $product['sku'];
            $pStatus['count'] = $uCount;
            $pStatus['single_price'] = $this->Plevel != 'price' ? $product['distributor'][$this->Plevel] : $product[$this->Plevel];
//            $pStatus['image'] = $product['product_image'];
            $pStatus['total_price'] = $this->Plevel != 'price' ? $uCount * $product['distributor'][$this->Plevel] : $uCount * $product[$this->Plevel];
//            $pStatus['innersku'] = $product['innersku'];
//            $pStatus['shelves'] = $product['shelves'];
//            $pStatus['shelves'] = $product['shelves'][0]['name'];
//            $pStatus['number'] = $product['number'];
            $pStatus['haveStock'] = $product['stock'] >= $uCount ? true : false;
        }

        return $pStatus;
    }

    //订单其他信息快照
    private function snapshootOrder($status)
    {

        $snapshoot = [
            //订单总价格
            'orderPrice' => 0,
            //订单总数
            'allCount' => 0,
            //订单详细信息
            'pStatus' => [],
            //收货地址
            'snapshootAddress' => null,
            //订单商品名
            'snapshootName' => '',
            //订单缩略图
            'snapImg' => ''
        ];

        $snapshoot['orderPrice'] = $status['orderPrice'];
        $snapshoot['allCount'] = $status['totalCount'];
        $snapshoot['pStatus'] = $status['pStatusArray'];

        $snapshoot['snapshootAddress'] = json_encode($this->getUserAddress());

        //商品大于1显示第一件商品加等
        $snapshoot['snapshootName'] = count($this->products) > 1 ?
            json_encode(['zn' => $this->products[0]['zn_name'] . '等', 'en' => $this->products[0]['en_name'] . ', etc']) :
            json_encode(['zn' => $this->products[0]['zn_name'], 'en' => $this->products[0]['en_name']]);
        //快照显示第一件商品
        $snapshoot['snapImg'] = $this->products[0]['product_image'];

        return $snapshoot;
    }

    //查询用户地址
    private function getUserAddress()
    {

        //添加邮箱
//        $this->addressInfo['email'] = '暂未填写';
        //添加下单
        $this->addressInfo['user'] = Auth::user()->username;

        return $this->addressInfo;
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function createOrder($orderSnap)
    {

        $num = BusinessOrderModel::orderBy('created_at', 'desc')->first(['order_no']);

        $orderNo = Common::makeOrderNo(is_null($num) ? 'ST2018101800001' : $num->order_no);
        //构造数据
        $data = [];
        $data = [
            'order_no' => 'ST' . $orderNo,
            'users_id' => 0,
            'total_price' => $orderSnap['orderPrice'],
            'total_count' => $orderSnap['allCount'],
            'snap_img' => $orderSnap['snapImg'],
            'snap_name' => $orderSnap['snapshootName'],
            'snap_address' => $orderSnap['snapshootAddress'],
            'shelve_position' => json_encode($this->shelvePosition($orderSnap['pStatus']))
        ];
        $num = \App\Http\Model\StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $orderNos = Common::makeOrderNo(is_null($num) ? 'O2018101800001' : $num->order_no);
        //构造数据
        $datas = [];
        $datas = [
            'order_no' => 'O' . $orderNos,
//            'operator' => 'admin',
            'total_count' => $orderSnap['allCount'],
            'total_price' => $orderSnap['orderPrice'],
            'pruchase_order_no' => 'ST' . $orderNo,
            'remark' => '后台手动生成商户订单',
            'status' => 2,
            'type' => 2
        ];

        //插入
        $res = BusinessOrderModel::insertOrder($data, $datas, $orderSnap['pStatus']);

        return [
            //订单号
            'order_no' => $orderNo,
            //订单id
            'order_id' => $res['id'],
            //生成时间
            'create_time' => $res['created_at']
        ];

    }
//    public function shelvePosition($param)
//    {
//        $res = $postion = [];
//
//        foreach ($param as &$items) {
//
//            $datas = ProductShelvesModel::with(['name' => function ($q) {
//                $q->select('id', 'name');
//            }])->where('product_id', '=', $items['product_id'])
//                ->orderBy('overdue', 'asc')
////                ->orderBy('count', 'asc')
//                ->get();
//
//            $data = $datas->toArray();
//
//            if (empty($data)) {
//                throw new ParamsException([
//                    'code' => 200,
//                    'message' => '商品' . ProductModel::where('id', '=', $items['product_id'])->first(['zn_name'])->zn_name . '在货架上查询不到库存;'
//                ]);
//            }
//
//
//            $info = ShelvesModel::whereIn('id', array_column($data, 'shelves_id'))->get(['id', 'name'])->toArray();
//
//            if (($sum = array_sum(array_column($data, 'count'))) < $items['count']) {
//
//                throw new ParamsException([
//                    'code' => 200,
//                    'message' => '商品' . ProductModel::where('id', '=', $items['product_id'])->first(['zn_name'])->zn_name . '在货架
//                    ' . implode(",", array_column($info, 'name')) .
//                        '共计' . "\"$sum\"" . '件,库存不足;'
//                ]);
//            }
//
//            //已货架分组 判断每个分组的总数能否完成抓货 能就选择此货架进行 不能按照日期从小到大分组进行抓货
//            $res[$items['product_id']] = [];
//            $nus = $items['count'];
//            $postion = [3,1];
//            //第一件抓取了货
//            if (!empty($postion)) {
//                foreach ($postion as $vs) {
//
//                    $arr = $this->group($data,$vs);
//
//                    foreach ($arr as $k => $vo) {
//                        array_push($postion,$vo['shelves_id']);
////                        dd($arr);
//                        if ($items['count'] - $vo['count'] > 0) {
////                            $vo['name'] =  $vo['name']['name'];
//                            $res[$items['product_id']][] = $vo;
//                            $items['count'] -= $vo['count'];
//                            unset($arr[$k]);
//                        } else {
//                            //商品大于需要的数量
////                            $vo['name'] =  $vo['name']['name'];
//                            $vo['count'] = $items['count'];
//                            $items['count'] -= $vo['count'];
//                            $res[$items['product_id']][] = $vo;
//                            break;
//                        }
//                    }
//                }
//            }
//
//            $hg = $this->array_group_by($data,'shelves_id');
//
//            foreach ($hg as $vv) {
//                if ($items['count'] <= 0)
//                    break;
//
//                if (array_sum(array_column($vv,'count')) >= $items['count']) {
//
//                    array_push($postion,$vv[0]['shelves_id']);
//
//                    foreach ($vv as $vo) {
//                        if ($items['count'] - $vo['count'] > 0) {
//                            $vo['name'] =  $vo['name']['name'];
//                            $res[$items['product_id']][] = $vo;
//                            $items['count'] -= $vo['count'];
//
//                        } else {
//                            //商品大于需要的数量
//                            $vo['name'] =  $vo['name']['name'];
//                            $vo['count'] = $items['count'];
//                            $items['count'] -= $vo['count'];
//                            $res[$items['product_id']][] = $vo;
//                            break;
//                        }
//                    }
//                }
//            }
//
//            if (empty($res[$items['product_id']])) {
//                foreach ($data as $k => &$item) {
//
//                    //转化了name
//                    $arr = $this->group($data,$item['shelves_id']);
//                    if ($items['count'] <= 0)
//                        break;
//                    foreach ($arr as $vo) {
//                        array_push($postion,$vo['shelves_id']);
////                        dd($arr);
//                        if ($items['count'] - $vo['count'] > 0) {
////                            $vo['name'] =  $vo['name']['name'];
//                            $res[$items['product_id']][] = $vo;
//                            $items['count'] -= $vo['count'];
//
//                        } else {
//                            //商品大于需要的数量
////                            $vo['name'] =  $vo['name']['name'];
//                            $vo['count'] = $items['count'];
//                            $items['count'] -= $vo['count'];
//                            $res[$items['product_id']][] = $vo;
//                            break;
//                        }
//                    }
//                }
//            }
//            $postion = array_unique($postion);
//
////            //写入冻结库存
//            foreach ($res[$items['product_id']] as $ii) {
//                ProductShelvesModel::where('product_id', '=', $ii['product_id'])
//                    ->where('shelves_id', '=', $ii['shelves_id'])
//                    ->where('overdue', '=', $ii['overdue'])
//                    ->increment('frozen_count', $ii['count']);
//            }
//        }
//
//        return $res;
//    }
    //获取货架位置
    public function shelvePosition($param)
    {
        $res = $postion = [];

        foreach ($param as &$items) {

            $datas = ProductShelvesModel::with(['name' => function ($q) {
                $q->select('id', 'name');
            }])->where('product_id', '=', $items['product_id'])
                ->orderBy('overdue', 'asc')
                ->orderBy('count', 'asc')
                ->get();

            $data = $datas->toArray();

            if (empty($data)) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品' . ProductModel::where('id', '=', $items['product_id'])->first(['zn_name'])->zn_name . '在货架上查询不到库存;'
                ]);
            }


            $info = ShelvesModel::whereIn('id', array_column($data, 'shelves_id'))->get(['id', 'name'])->toArray();

            if (($sum = array_sum(array_column($data, 'count'))) < $items['count']) {

                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品' . ProductModel::where('id', '=', $items['product_id'])->first(['zn_name'])->zn_name . '在货架
                    ' . implode(",", array_column($info, 'name')) .
                        '共计' . "\"$sum\"" . '件,库存不足;'
                ]);
            }

            $res[$items['product_id']] = [];

            foreach ($data as &$vo) {

                if ($items['count'] <= 0) break;

                if ($vo['count'] == 0) continue;

                if ($items['count'] - $vo['count'] > 0) {
                    $vo['name'] = $vo['name']['name'];
                    $res[$items['product_id']][] = $vo;
                    $items['count'] -= $vo['count'];

                } else {
                    //商品大于需要的数量
                    $vo['name'] = $vo['name']['name'];
                    $vo['count'] = $items['count'];
                    $items['count'] -= $vo['count'];
                    $res[$items['product_id']][] = $vo;
                    break;
                }
            }

//            //写入冻结库存
//            foreach ($res[$items['product_id']] as $ii) {
//                ProductShelvesModel::where('product_id', '=', $ii['product_id'])
//                    ->where('shelves_id', '=', $ii['shelves_id'])
//                    ->where('overdue', '=', $ii['overdue'])
//                    ->increment('frozen_count', $ii['count']);
//            }
        }
//        dd($res);
        return $res;
    }

    public static function array_group_by($arr, $key)
    {
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }
        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }
        return $grouped;
    }

    public static function group(&$arr, $key)
    {
        $grouped = [];
        foreach ($arr as $k => $value) {
            if ($value['shelves_id'] == $key) {
                $value['name'] = $value['name']['name'];
                array_push($grouped, $value);
                unset($arr[$k]);
            }
        }
        return $grouped;
    }

    public function users(Request $request)
    {

        $data = str_replace(' ', '', $request->input('value'));

        $data = htmlspecialchars(strip_tags(trim($data)));

        if (empty($data)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索内容不能为空'
            ]);
        }

        $res = \App\Http\Model\UsersModel::with(['manys' => function ($q) {
            $q->where('default', '=', 1);
        }])
            ->select('id', 'name', 'email', 'role')
            ->where('name', 'like', '%' . $data . '%')
            ->where('status', '=', 1)
            ->whereIn('role', [2, 3, 4])
            ->orderBy('created_at', 'desc')
            ->get();


        return Common::successData($res);
    }


}



