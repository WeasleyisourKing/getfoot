<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common;
use App\Rules\OrderRule;
use App\Http\Model\ProductModel;
use App\Http\Model\GeneralModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Model\OrderModel;
use App\Http\Model\UsersModel;
use App\Rules\IdRule;

class AppOrderController extends Controller
{

    //用户订单商品列表
    protected $uProducts;

    //数据库商品信息
    protected $products;

    //用户ID
    protected $uid;

    //订单
    //用户选择商品后提交到api
    //检测商品库存量
    //有库存 订单数据存入数据库 返回客户端消息 可以支付
    //调用支付接口 进行支付 在进行库存量检测
    //小程序根据服务器结果拉起支付
    //服务器调用微信支付接口支付（异步）
    //微信返回支付结果 小程序和服务器都返回 成功：（检测库存量）库存量扣除


    public function placeOrder (Request $request)
    {

        //验证参数 传递商品id 数量 [[],[],[]]
        $data =  (new OrderRule)->goCheck(200, true);
        if (!empty($data)) return $data;

        $data = (new IdRule)->goCheck(200, true);
        if (!empty($data)) return $data;

        $uProducts = json_decode($request->input('products'), true);

        //用户id
        $uid = $request->get('id');

//        [{"count":2, "product_id":1},{"count":2, "product_id":2}]

//        $arr = [];
//        $arr[] = ['product_id' => 1,'count' => 4];
//        $arr[] = ['product_id' => 2,'count' => 8];
//        $arr[] = ['product_id' => 3,'count' => 12];
//        $products = $arr;

        return $this->place($uid, $uProducts);

    }

    /**
     * 用户下单 比对数据库 存入数据
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function place ($uid, $uProducts)
    {

        //属性赋值
        $this->uProducts = $uProducts;
        $this->uid = $uid;
        $this->products = $this->getProductsByOrder($uProducts);

        //数据库比对调用
        //某商品库存不够
        $status = $this->getOrderStatus();

        if (!$status['status']) {

            $text = '';
            foreach ($status['pStatusArray'] as $item) {
                if ($item['haveStock'] != true) {
                    $text .= '商品' . $item['name'] . '库存不足；';
                }

            }

            $result = [
                'status' => false,
                'code' => 200,
                'data' => $text
            ];
            $json = json_encode($result);

            return "my({$json})";

//            throw new ParamsException([
//                'code' => 200,
//                'message' => $text
//            ]);
        }

        //有存货 创建订单
        $snapshootOrder = $this->snapshootOrder($status);

        $freight = GeneralModel::select('threshold', 'freight')->where('id', '=', 1)->first()->toarray();

        //运费
        if ($snapshootOrder['orderPrice'] <= $freight['threshold']) {
            $snapshootOrder['freight'] = $freight['freight'];
            $snapshootOrder['orderPrice'] = $snapshootOrder['orderPrice'] + $freight['freight'];
        } else {
            $snapshootOrder['freight'] = 0;
        }

        //写入数据库 订单号 购买商品
        //订单和商品关系 多对多
        $order = self::createOrder($snapshootOrder);

        return Common::successData($order,true);

    }

    //与数据库比较库存量结果
    private function getOrderStatus ()
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

            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            $status['pStatusArray'][] = $pStatus;

        }

        return $status;

    }

    //订单其他信息快照
    private function snapshootOrder ($status)
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
            $this->products[0]['zn_name'] . '等' : $this->products[0]['zn_name'];
        //快照显示第一件商品
        $snapshoot['snapImg'] = $this->products[0]['product_image'];

        return $snapshoot;
    }

    //查询用户地址
    private function getUserAddress ()
    {

        //判断用户是否注册
        $userIfo = UsersModel::getUserInfo($this->uid);

        if (!$userIfo) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '用户不存在或者没有注册激活'
            ];
            $json = json_encode($result);

            return "my({$json})";

//            throw new ParamsException([
//                'message' => '用户不存在或者没有注册激活',
//            ]);
        }

        //获取用户地址
        $userAddress = UsersAddressModel::getUserAddress($this->uid);

        if (!$userAddress) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '用户收货地址不存在或没设置默认地址'
            ];
            $json = json_encode($result);

            return "my({$json})";
//            throw new ParamsException([
//                'message' => '用户收货地址不存在或没设置默认地址',
//                'errorCode' => 6001
//            ]);
        }

        //添加邮箱
        $userAddress['email'] = $userIfo->email;
        //添加下单
        $userAddress['user'] = $userIfo->name;
        return $userAddress;
    }


    //根据用户订单查找数据库商品信息
    private function getProductsByOrder ($uProducts)
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
                $result = [
                    'status' => false,
                    'code' => 200,
                    'data' => $item['zn_name'] . '商品已经下架'
                ];
                $json = json_encode($result);

                return "my({$json})";

//                throw new ParamsException([
//                    'message' => $item['zn_name'] . '商品已经下架',
//                    'errorCode' => 7001
//                ]);
            }
        }

        return $Products;
    }

    //判断某一件商品是否有货及各项属性
    //用户某件商品id 用户某件商品总数 数据库数据
    private function getProductStatus ($uPID, $uCount, $products)
    {

        //某商品详细信息
        $pStatus = [
            'id' => '',
            //是否有商品
            'haveStock' => '',
            'count' => 0,
            'name' => '',
            //全部价格
            'totalPrice' => 0
        ];
        $pIdex = -1;
        //对比数据库是否有数据
        for ($i = 0; $i < count($products); $i++) {

            if ($uPID == $products[$i]['id']) {
                $pIdex = $i;
            }
        }
        if ($pIdex == -1) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' =>'id为' . $uPID . '商品不存在'
            ];
            $json = json_encode($result);

            return "my({$json})";

//            throw new ParamsException([
//                'message' => 'id为' . $uPID . '商品不存在'
//            ]);
        } else {

            $product = $products[$pIdex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['zn_name'];
            $pStatus['sku'] = $product['sku'];
            $pStatus['count'] = $uCount;
            $pStatus['singlePrice'] = $product['distributor']['level_four_price'];
            $pStatus['image'] = $product['product_image'];
            $pStatus['totalPrice'] = $uCount * $product['distributor']['level_four_price'];
            $pStatus['shelves'] = $product['shelves'];
            $pStatus['haveStock'] = $product['stock'] >= $uCount ? true : false;

        }

        return $pStatus;
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    //因为插入2张表 使用事务
    private function createOrder ($orderSnap)
    {
        $orderNo = Common::makeOrderNo();
        //构造数据
        $data = [];
        $data = [
            'order_no' => $orderNo,
            'users_id' => $this->uid,
            'total_price' => $orderSnap['orderPrice'],
            'total_count' => $orderSnap['allCount'],
            'snap_img' => $orderSnap['snapImg'],
            'snap_name' => $orderSnap['snapshootName'],
            'snap_address' => $orderSnap['snapshootAddress'],
            'freight' => $orderSnap['freight'],
            //一次下单的详细信息
            'snap_items' => json_encode($orderSnap['pStatus'])
        ];

        $res = OrderModel::insertOrder($data, $this->uProducts);

        return [
            //订单号
            'order_no' => $orderNo,
            //订单id
            'order_id' => $res['id'],
            //生成时间
            'create_time' => $res['created_at']
        ];

    }


}
