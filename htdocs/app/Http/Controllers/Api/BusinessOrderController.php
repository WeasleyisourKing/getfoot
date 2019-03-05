<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use App\Rules\OrderRule;
use App\Http\Model\ProductModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Model\ProductShelvesModel;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\UsersModel;
use App\Http\Model\ShelvesModel;
use App\Rules\IdRule;
use Mail;

class BusinessOrderController extends Controller
{

    //用户订单商品列表
    protected $uProducts;

    //数据库商品信息
    protected $products;

    //用户ID
    protected $uid;

    //用户code
    protected $code;

    //税金
    protected $zax;

    //用户Email
    protected $email;

    //用户name
    protected $name;

    //用户角色
    protected $role;

    protected $Plevel;
    //收件人name
    protected $addressee;

    //收件人电话
    protected $mobile;

    //状态
//    protected $status;
    //订单
    //用户选择商品后提交到api
    //检测商品库存量
    //有库存 订单数据存入数据库 返回客户端消息 可以支付
    //调用支付接口 进行支付 在进行库存量检测
    //小程序根据服务器结果拉起支付
    //服务器调用微信支付接口支付（异步）
    //微信返回支付结果 小程序和服务器都返回 成功：（检测库存量）库存量扣除


    //snack下商业订单
    public function placeOrder(Request $request)
    {

        //验证参数 传递商品id 数量 [[],[],[]]
        (new OrderRule)->goCheck(200);

        $params = $request->all();

        $uProducts = json_decode($params['products'], true);

        //用户id
        $uid = $params['userId'];

        return $this->place($uid, $uProducts);

    }

    /**
     * 用户下单 比对数据库 存入数据
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @param  string $code 折扣码
     * @return $order 订单号
     */
    public function place($uid, $uProducts)
    {

        //属性赋值
        $this->uProducts = $uProducts;
        $this->uid = $uid;
        $this->products = $this->getProductsByOrder($uProducts);


        //数据库比对调用
        //某商品库存不够
        $status = $this->getOrderStatus();

        foreach ($status['pStatusArray'] as $k => $item) {
            if ($item['haveStock'] != true) {

                throw new ParamsException([
                    'code' => 200,
                    'message' => "LanguageHtml(`{$item['znName']} 库存不足`, `{$item['enName']} Lack of stock`)"

                ]);
            }
            unset($status['pStatusArray'][$k]['haveStock']);
            unset($status['pStatusArray'][$k]['znName']);
            unset($status['pStatusArray'][$k]['enName']);
        }


        //有存货 创建订单
        $snapshootOrder = $this->snapshootOrder($status);

        //写入数据库 订单号 购买商品
        //订单和商品关系 多对多

        $order = self::createOrder($snapshootOrder);

        return Common::successData($order);

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

            $pStatus = $this->getProductStatus($uProduct['product_id'], $uProduct['count'], $this->products);

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


        //判断用户是否注册
        $userIfo = UsersModel::getUserInfo($this->uid);

//        dd($userIfo->toArray());
        if (!$userIfo) {
            throw new ParamsException([
                'message' => 'LanguageHtml(`用户不存在或者没有注册激活`, `The user does not exist or is not registered activated`)',
            ]);
        }

        //获取用户地址
        $userAddress = UsersAddressModel::getUserAddress($this->uid);

//        dd($userAddress);
        if (!$userAddress) {
            throw new ParamsException([
                'code' => 200,
                'message' => 'LanguageHtml(`用户收货地址不存在或没设置默认地址`, `The user address does not exist or the default address is not set`)',
                'errorCode' => 6001
            ]);
        }

        //获取税金
//        $this->getZax($userAddress['zip'], $userAddress['city']);

        //添加邮箱
        $this->email = $userAddress['email'] = $userIfo->email;

        //添加收件人
        $this->addressee = $userAddress->name;

        //添加收件人电话
        $this->mobile = $userAddress->mobile;
        //添加名字
        $this->name = $userIfo->name;
        //添加下单
        $userAddress['user'] = $userIfo->name;
        return $userAddress;
    }


    //修改订单地址快照
    public function editAddress(Request $request)
    {


        //判断用户是否注册
        $params = $request->all();
        // dd($params);
        $userIfo = UsersModel::getUserInfo($params['id']);
        //dd($userIfo);
        $snapAddress = UsersAddressModel::where('id', '=', $params['address_id'])->first();
        //添加邮箱
        $snapAddress['email'] = $userIfo->email;
        //添加下单
        $snapAddress['user'] = $userIfo->name;

        $order = BusinessOrderModel::where('id', '=', $params['order_id'])->first(['tax', 'total_price', 'freight']);

        //去除税金 得到原价
        $originPrice = round(($order->total_price - $order->freight) / (1 + $order->tax), 2);

        $url = sprintf(config('custom.tax_url'),
            config('custom.tax_key'),
            $snapAddress->zip, $snapAddress->city
        );

        $res = Common::curlInfo($url);

        if ($res['rCode'] == 100) {

            $data = [
                'snap_address' => $snapAddress,
                'tax' => $res['results'][0]['taxSales'],
                'total_price' => round($originPrice * $res['results'][0]['taxSales'] + $originPrice + $order->freight, 2)
            ];

        } else if ($res['rCode'] == 104) {

            throw new ParamsException([
                'code' => 200,
                'message' => 'LanguageHtml(`邮政编码格式无效`, `Invalid postal code format`)',
            ]);
        } else {
            throw new ParamsException([
                'code' => 200,
                'message' => 'LanguageHtml(`获取税金接口失败`, `Failure to get tax interface`)',
            ]);
        }

        $res = BusinessOrderModel::where('id', '=', $params['order_id'])->update($data);
        if ($res) {
            return 1;
        } else {
            return 0;
        }
    }


    //根据用户订单查找数据库商品信息
    private function getProductsByOrder($uProducts)
    {

        $opIds = [];
        foreach ($uProducts as $item) {
            $opIds[] = $item['product_id'];
        }

        //查询商品信息
        $Products = ProductModel::with('distributor')
            ->select(['id', 'sku', 'price', 'stock','frozen_stock','zn_name', 'en_name', 'product_image', 'status', 'innersku', 'number'])
            ->whereIn('id', $opIds)
            ->get()
            ->toArray();

        //可能下架
        foreach ($Products as $item) {
            if ($item['status'] != 1) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => "LanguageHtml(` {$item['zn_name']} 商品已经下架`, `{$item['en_name']} The goods have already gone off shelves`)",
                    'errorCode' => 7001
                ]);
            }
        }


        //判断用户是否注册
        $userIfo = UsersModel::getUserInfo($this->uid);

        //添加角色
        $this->role = $userIfo->role;

        switch ($this->role) {
            case 1 :
                $this->Plevel = 'level_four_price';
                break;
            case 2 :
                $this->Plevel = 'level_two_price';
                break;
            case 3 :
                $this->Plevel = 'level_one_price';
                break;
            default :
                $this->Plevel = 'level_three_price';
        }

        return $Products;

    }


    //判断某一件商品是否有货及各项属性
    //用户某件商品id 用户某件商品总数 数据库数据
    private function getProductStatus($uPID, $uCount, $products)
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
                'code' => 200,
                'message' => "LanguageHtml(`id为  {$uPID}  商品不存在`, `id for  {$uPID}  Commodities do not exist.`)",
            ]);
        } else {
            $product = $products[$pIdex];
            $pStatus['product_id'] = $product['id'];
            $pStatus['znName'] = $product['zn_name'];
            $pStatus['enName'] = $product['en_name'];
//            $pStatus['sku'] = $product['sku'];
            $pStatus['count'] = $uCount;
            $pStatus['single_price'] = $product['distributor'][$this->Plevel];
//            $pStatus['image'] = $product['product_image'];
            $pStatus['total_price'] = $uCount * $product['distributor'][$this->Plevel];
//            $pStatus['innersku'] = $product['innersku'];
//            $pStatus['shelves'] = $product['shelves'];
//            $pStatus['number'] = $product['number'];
            $pStatus['haveStock'] = $product['stock'] >= $uCount ? true : false;

        }

        return $pStatus;
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
            'users_id' => $this->uid,
            'total_price' => $orderSnap['orderPrice'],
            'total_count' => $orderSnap['allCount'],
            'snap_img' => $orderSnap['snapImg'],
            'snap_name' => $orderSnap['snapshootName'],
            'snap_address' => $orderSnap['snapshootAddress'],
            'shelve_position' => json_encode($this->shelvePosition($orderSnap['pStatus']))
        ];


        $num = \App\Http\Model\StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);
        $orderNos = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);
        //构造数据
        $datas = [];
        $datas = [
            'order_no' => 'O' . $orderNos,
            'operator' => 'Admin',
            'total_count' => $orderSnap['allCount'],
            'total_price' => $orderSnap['orderPrice'],
            'pruchase_order_no' => 'ST' . $orderNo,
            'remark' => '商业商户下订单',
            'status' => 2,
            'type' => 2
        ];


        $res = BusinessOrderModel::insertOrder($data, $datas, $orderSnap['pStatus']);

        return [
            //订单号
            'order_no' => $orderNo,
            //订单id
            'order_id' => $res['id'],
            //订单快照
            'snap_name' => $data['snap_name'],
            //生成时间
            'create_time' => $res['created_at']
        ];

    }


    /**
     * 效验商品库存接口
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function checkProductStock(Request $request)
    {
        //验证参数 传递商品id 数量 [[],[],[]]
        (new OrderRule)->goCheck();

        //[{"count":2, "product_id":1},{"count":2, "product_id":2}]
        $uProducts = json_decode($request->input('products'), true);


        //属性赋值
        $this->uProducts = $uProducts;
        $this->products = $this->getProductsByOrder($uProducts);

        //数据库比对调用
        //某商品库存不够
        $status = $this->getOrderStatus();

        if (!$status['status']) {

            $enText = $znText = '';
            foreach ($status['pStatusArray'] as $item) {
                if ($item['haveStock'] != true) {
                    $znText .= $item['znName'];
                    $enText .= $item['enName'];
//                    $text .= '商品' . $item['name'] . '库存不足；';
                }
                $text = "LanguageHtml(`{$znText} 库存不足`, `{$enText} Lack of stock`)";
            }
            throw new ParamsException([
                'code' => 200,
                'message' => $text

            ]);
        } else {
            return Common::successData();
        }
    }


    //paypal回调接口
//    public function palNotify (Request $request)
//    {
//
//
//        $params = $request->all();
//
//        //检测商户号
//        if (config('custom.palpay_business') != $params['receiver_email']) {
//
//            $this->RecordLog('支付商户号错误', $params);
//            return;
//        }
//
//        $order = BusinessOrderModel::getOrderInfo($params['item_number']);
//
//        if (!$order) {
//
//            $this->RecordLog('订单号不存在', $params);
//            return;
//        }
//
//        //订单金额检测
//        if ((int)$params['payment_gross'] != (int)$order->total_price) {
//
//            $this->RecordLog('支付金额有错', $params);
//            return;
//
//        }
//        //未支付 修改相关表状态
//        if ($order->status == 2) {
//
//            ProductModel::updateProductStock($order->id);
//            BusinessOrderModel::updateStatus($order->id, ['status' => 1]);
//
//            $userAddress = UsersAddressModel::getUserAddress($order->users_id);
//            $userIfo = UsersModel::getUserInfo($order->users_id);
//
//            $snapshootOrder = [
//                'pStatus' => json_decode($order->snap_items, true),
//                'snapshootAddress' => $order->snap_address,
//                'orderPrice' => $order->total_price,
//                'freight' => $order->freight,
//                'allCount' => $order->total_count
//            ];
//            Common::sendEmail($userIfo->email, $userIfo->name, $userAddress->name, $userAddress->mobile, $order->order_no, $order->snap_name, $snapshootOrder);
//
//        }
//
//    }


//    public function RecordLog ($str, $params)
//    {
//        Log::info($str);
//        Log::info($params);
//
//    }


    /**
     * 获取订单状态接口
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function orderState(Request $request)
    {


        $data = (new IdRule)->goCheck(200, true);

        if (!empty($data)) return $data;
        $id = $request->input('id');
        //$status=$request->input('status');
        $status = $request->input('status');
        //dd($id);

        if (!empty($status)) {

            $res = UsersModel::getUserOrder($id, $status);
        } else {
            $res = UsersModel::getUserOrder($id);
        }
        //dd($res);

        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '用户查询不到'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }

        if (!$res[0]['oreder_manys']) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '用户没有下订单'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }


        $data = Common::screen($res[0]['oreder_manys'], ['snap_name', 'order_no', 'total_price', 'status', 'total_count', 'created_at', 'snap_img', 'id']);
//        return $data;

        return Common::successData($data, true);


    }

    //获取货架位置
    public function shelvePosition($param)
    {
        $res = $postion = [];

        foreach ($param as &$items) {

            $datas = ProductShelvesModel::with(['name' => function ($q) {
                $q->select('id', 'name');
            }])->where('product_id', '=', $items['product_id'])
                ->orderBy('overdue', 'asc')
//                ->orderBy('count', 'asc')
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

            //已货架分组 判断每个分组的总数能否完成抓货 能就选择此货架进行 不能按照日期从小到大分组进行抓货
            $res[$items['product_id']] = [];
            $nus = $items['count'];
            $postion = [3,1];
            //第一件抓取了货
            if (!empty($postion)) {
                foreach ($postion as $vs) {

                    $arr = $this->group($data,$vs);

                    foreach ($arr as $k => $vo) {
                        array_push($postion,$vo['shelves_id']);
//                        dd($arr);
                        if ($items['count'] - $vo['count'] > 0) {
//                            $vo['name'] =  $vo['name']['name'];
                            $res[$items['product_id']][] = $vo;
                            $items['count'] -= $vo['count'];
                            unset($arr[$k]);
                        } else {
                            //商品大于需要的数量
//                            $vo['name'] =  $vo['name']['name'];
                            $vo['count'] = $items['count'];
                            $items['count'] -= $vo['count'];
                            $res[$items['product_id']][] = $vo;
                            break;
                        }
                    }
                }
            }

            $hg = $this->array_group_by($data,'shelves_id');

            foreach ($hg as $vv) {
                if ($items['count'] <= 0)
                    break;

                if (array_sum(array_column($vv,'count')) >= $items['count']) {

                    array_push($postion,$vv[0]['shelves_id']);

                    foreach ($vv as $vo) {
                        if ($items['count'] - $vo['count'] > 0) {
                            $vo['name'] =  $vo['name']['name'];
                            $res[$items['product_id']][] = $vo;
                            $items['count'] -= $vo['count'];

                        } else {
                            //商品大于需要的数量
                            $vo['name'] =  $vo['name']['name'];
                            $vo['count'] = $items['count'];
                            $items['count'] -= $vo['count'];
                            $res[$items['product_id']][] = $vo;
                            break;
                        }
                    }
                }
            }

            if (empty($res[$items['product_id']])) {
                foreach ($data as $k => &$item) {

                    //转化了name
                    $arr = $this->group($data,$item['shelves_id']);
                    if ($items['count'] <= 0)
                        break;
                    foreach ($arr as $vo) {
                        array_push($postion,$vo['shelves_id']);
//                        dd($arr);
                        if ($items['count'] - $vo['count'] > 0) {
//                            $vo['name'] =  $vo['name']['name'];
                            $res[$items['product_id']][] = $vo;
                            $items['count'] -= $vo['count'];

                        } else {
                            //商品大于需要的数量
//                            $vo['name'] =  $vo['name']['name'];
                            $vo['count'] = $items['count'];
                            $items['count'] -= $vo['count'];
                            $res[$items['product_id']][] = $vo;
                            break;
                        }
                    }
                }
            }
            $postion = array_unique($postion);

//            //写入冻结库存
            foreach ($res[$items['product_id']] as $ii) {
                ProductShelvesModel::where('product_id', '=', $ii['product_id'])
                    ->where('shelves_id', '=', $ii['shelves_id'])
                    ->where('overdue', '=', $ii['overdue'])
                    ->increment('frozen_count', $ii['count']);
            }
        }

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
                array_push($grouped,$value);
                unset($arr[$k]);
            }
        }
        return $grouped;
    }

}
