<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use App\Rules\OrderRule;
use App\Http\Model\ProductModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Model\OrderProductModel;
use App\Http\Model\UsersInvoiceModel;
use App\Http\Model\UsersDiscountModel;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\UsersModel;
use Illuminate\Support\Facades\Log;
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


    public function placeOrder (Request $request)
    {


        //验证参数 传递商品id 数量 [[],[],[]]
        (new OrderRule)->goCheck(200);

        $params = $request->all();

        $uProducts = json_decode($params['products'], true);

        //用户id
        $uid = $params['userId'];

        //code
//        $code = !empty($params['code']) ? $params['code'] : null;

//        $this->status = !empty($params['status']) ? $params['status'] : null;


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
     * @param  string $code 折扣码
     * @return $order 订单号
     */
    public function place ($uid, $uProducts)
    {

        //属性赋值
        $this->uProducts = $uProducts;
        $this->uid = $uid;
        $this->products = $this->getProductsByOrder($uProducts);
//        $this->code = is_null($code) ? null : $this->getDiscount($code);

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
//                'message' => json_encode($status['pStatusArray'])
            ]);
        }

        //有存货 创建订单
        $snapshootOrder = $this->snapshootOrder($status);

//        $freight = GeneralModel::select('threshold', 'freight')->where('id', '=', 1)->first()->toarray();

//        //运费在订单价格之前算 折扣码只对价格有效
//        $snapshootOrder['freight'] = ($snapshootOrder['orderPrice'] <= $freight['threshold']) ? $freight['freight'] : 0;

        //折扣码计算
//        if (!is_null($this->code)) {
//
//            if ($this->code['type'] != 1) {
//                //off
//                $snapshootOrder['orderPrice'] = round($snapshootOrder['orderPrice'] - ($snapshootOrder['orderPrice'] * ((int)strstr($this->code['rcent'], '%', true) / 100)), 2);
//            } else {
//                //固定
//                $snapshootOrder['orderPrice'] = ($snapshootOrder['orderPrice'] - $this->code['rcent']) < 0 ? 0 : ($snapshootOrder['orderPrice'] - $this->code['rcent']);
//            }
//        }
//        $backup = $snapshootOrder['orderPrice'];
        //运费在订单价格之前算 折扣码只对价格有效
//        $snapshootOrder['freight'] = ($snapshootOrder['orderPrice'] <= $freight['threshold']) ? $freight['freight'] : 0;

//        $snapshootOrder['orderPrice'] = $snapshootOrder['freight'] != 0 ? $snapshootOrder['orderPrice'] + $freight['freight'] : $snapshootOrder['orderPrice'];

        //加上税金
//        $snapshootOrder['orderPrice'] += $backup * $this->zax;

        //写入数据库 订单号 购买商品
        //订单和商品关系 多对多
        $order = self::createOrder($snapshootOrder);

        //发送下单邮件
//        $this->sendEmail($this->email, $this->name, $order['order_no'], $order['snap_name'], $snapshootOrder);

        return Common::successData($order);

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
//        $snapshoot['pStatus'] = $status['pStatusArray'];
        $snapshoot['snapshootAddress'] = json_encode($this->getUserAddress());
//        if (!is_null($this->status))
//        $snapshoot['snapshootInvoice'] = json_encode($this->getUserInvoice());
        //商品大于1显示第一件商品加等
//        ['zn' => $this->products[0]['zn_name'] , 'en' => $this->products[0]['en_name']]
        $snapshoot['snapshootName'] = count($this->products) > 1 ?
            json_encode(['zn' => $this->products[0]['zn_name'] . '等', 'en' => $this->products[0]['en_name'] . ', etc']) :
            json_encode(['zn' => $this->products[0]['zn_name'], 'en' => $this->products[0]['en_name']]);
//            $this->products[0]['zn_name'] . '等' : $this->products[0]['zn_name'];
        //快照显示第一件商品
        $snapshoot['snapImg'] = $this->products[0]['product_image'];

        return $snapshoot;
    }

    //查询用户地址
    private function getUserAddress ()
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
        //添加收件人电话
        $this->mobile = $userAddress->mobile;
        //添加名字
        $this->name = $userIfo->name;
        //添加下单
        $userAddress['user'] = $userIfo->name;
        return $userAddress;
    }

    //查询用户发票地址
//    private function getUserInvoice ()
//    {
//
//        $info = UsersInvoiceModel::where('users_id', '=', $this->uid)->get();
//
//
//        if ($info->isEmpty()) {
//            throw new ParamsException([
//                'code' => 200,
//                'message' => 'LanguageHtml(`用户发票地址不存在`, `User invoice address does not exist`)',
//                'errorCode' => 6001
//            ]);
//        }
//
//        return $info;
//
//    }

//    public function orderAddress (Request $request)
//    {
//        $id = $request->input('id');
//        return UsersAddressModel::where('users_id', '=', $id)->get();
//    }


    //修改订单地址快照
    public function editAddress (Request $request)
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


    //根据code获取折扣信息
//    private function getDiscount ($code)
//    {
//
//        $res = UsersDiscountModel::with(['discount' => function ($query) {
//            $query->select('id', 'type', 'rcent')->where('status', '=', 1);
//        }])->where('code', '=', $code)
//            ->where('status', '=', 1)
//            ->first();
//
////dd($res->toArray());
//        if (!$res) {
//            throw new ParamsException([
//                'code' => 200,
//                'message' => 'LanguageHtml(`折扣码无效或者已使用或者被禁用`, `The discount code is invalid or has been used or disabled`)',
//                'errorCode' => 7001
//            ]);
//        }
//
//        return ['id' => $res->id, 'type' => $res->discount->type, 'rcent' => $res->discount->rcent];
//
//    }

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
                throw new ParamsException([
                    'code' => 200,
                    'message' => "LanguageHtml(` {$item['zn_name']} 商品已经下架`, `{$item['en_name']} The goods have already gone off shelves`)",
                    'errorCode' => 7001
                ]);
            }
        }

        return $Products;
    }

    //获取用户某订单详情
//    public function getOrderDetails (Request $request)
//    {
//
//        $id = $request->input('id');
//        $data['products'] = OrderProductModel::orderProduct($id);
//        $data['details'] = BusinessOrderModel::select('order_no', 'tax', 'snap_address', 'freight', 'total_price', 'status')->where('id', '=', $id)->first();
//
//        return $data;
//
//    }

    //判断某一件商品是否有货及各项属性
    //用户某件商品id 用户某件商品总数 数据库数据
    private function getProductStatus ($uPID, $uCount, $products)
    {

        $middle = $this->Plevel;
        dump($middle);
        dd($this->Plevel);
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
            throw new ParamsException([
                'code' => 200,
                'message' => "LanguageHtml(`id为  {$uPID}  商品不存在`, `id for  {$uPID}  Commodities do not exist.`)",
            ]);
        } else {
            $product = $products[$pIdex];
            $pStatus['id'] = $product['id'];
            $pStatus['znName'] = $product['zn_name'];
            $pStatus['enName'] = $product['en_name'];
            $pStatus['sku'] = $product['sku'];
            $pStatus['count'] = $uCount;
            $pStatus['singlePrice'] = $product['distributor'][$middle];
            $pStatus['image'] = $product['product_image'];
            $pStatus['totalPrice'] = $uCount * $product['distributor'][$middle];
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
        $num = BusinessOrderModel::orderBy('created_at', 'desc')->first(['order_no']);
        $orderNo = Common::makeOrderNo(is_null($num) ? 'A2018101800001' : $num->order_no);

        //构造数据
        $data = [];
        $data = [
            'order_no' =>  'B' . substr($orderNo, 1),
            'users_id' => $this->uid,
            'total_price' => $orderSnap['orderPrice'],
            'total_count' => $orderSnap['allCount'],
            'snap_img' => $orderSnap['snapImg'],
            'snap_name' => $orderSnap['snapshootName'],
            'snap_address' => $orderSnap['snapshootAddress'],
//            'freight' => $orderSnap['freight'],
//            'tax' => $this->zax,
//            'invoice_address' => $orderSnap['snapshootInvoice'],
            //一次下单的详细信息
            'snap_items' => json_encode($orderSnap['pStatus'])
        ];
//        if (!is_null($this->status)) {
//            $data['invoice_address'] =  $orderSnap['snapshootInvoice'];
//        }

        //改变折扣码状态
//        if (!is_null($this->code)) {
//
//            $data['discount_id'] = $this->code['id'];
//            UsersDiscountModel::where('id', '=', $this->code['id'])->update(['status' => 2]);
//        }
        $res = BusinessOrderModel::insertOrder($data, $this->uProducts);

        return [
            //订单号
            'order_no' => $orderNo,
            //订单id
            'order_id' => $res['id'],
            //打折价格
//            'origin_price' => $backup,
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
    public function checkProductStock (Request $request)
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
    public function orderState (Request $request)
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

//    //发送邮箱
//    public function sendEmail ($email, $name, $number, $snapName, &$snapshootOrder)
//    {
//
//        //表格显示商品列表
//        $productList = '
//        <table style="border-collapse:collapse;"  style="font-size: 40px;">
//        <thead>
//    <tr style="background: #999;color: white;">
//        <th  height="40" width="400">产品</th>
//        <th  height="40" width="100">单价</th>
//        <th  height="40" width="100">数量</th>
//    </tr>
//    </thead>
//     <tbody style="border: 1px solid #000;">
//        %s
//       </tbody>
//</table> ';
//
//
//        $content = '';
//        $url = config('custom.img_url');
//        foreach ($snapshootOrder['pStatus'] as $itms) {
//
//            $content .= "<tr style='border:1px solid #eee;color: #333;' height='40px' width='40px'>
//        <td style='text-align:center;border-right:1px solid #eee;'><img height='40px' width='40px' src='{$url}{$itms["image"]}' />{$itms['name']}</td>
//        <td style='text-align:center;border-right:1px solid #eee;'>\${$itms['singlePrice']}</td>
//        <td style='text-align:center;'>{$itms['count']}</td>
//         </tr>";
//
//        }
//
//        $productList = sprintf($productList, $content);
//        $address = json_decode($snapshootOrder['snapshootAddress'], true);
//
//
//        // Mail::send()的返回值为空，所以可以其他方法进行判断
//        //模板 变量 参数绑定Mail类的一个实例
//        Mail::send('layouts.downOrder', [
//            'name' => $name,
//            'number' => $number,
//            'snapName' => $snapName,
//            'product_list' => $productList,
//            'product_totalprice' => $snapshootOrder['orderPrice'] - $snapshootOrder['freight'],
//            'product_count' => $snapshootOrder['allCount'],
//            'freight' => $snapshootOrder['freight'],
//            'addressee' => $this->addressee,
//            'mobile' => $this->mobile,
//            'express_address' => $address['detail'] . $address['country'] . $address['city'] . $address['province'],
//            'order_totalprice' => $snapshootOrder['orderPrice']
//
//        ], function ($message) use ($email) {
//
//            $message->to($email)->subject('下单提醒');
//        });
//        // 返回的一个错误数组，利用此可以判断是否发送成功
//        if (count(Mail::failures()) > 1) {
//            Log::info("下单提醒给用户" . $email . "邮件失败");
//
//        }
//
//        Mail::send('layouts.ownOrder',
//            [
//                'name' => $name,
//                'number' => $number,
//                'snapName' => $snapName,
//                'product_list' => $productList,
//                'product_totalprice' => $snapshootOrder['orderPrice'] - $snapshootOrder['freight'],
//                'product_count' => $snapshootOrder['allCount'],
//                'freight' => $snapshootOrder['freight'],
//                'addressee' => $this->addressee,
//                'mobile' => $this->mobile,
//                'express_address' => $address['detail'] . $address['country'] . $address['city'] . $address['province'],
//                'order_totalprice' => $snapshootOrder['orderPrice']
//
//            ]
//            , function ($message) {
//
//                $message->to(config('custom.send_eamil'))->subject('用户下单提醒');
//            });
//        // 返回的一个错误数组，利用此可以判断是否发送成功
//        if (count(Mail::failures()) > 1) {
//            Log::info("用户下单" . $email . "邮件失败");
//
//        }
//
//    }

    //获取用户订单计数接口
//    public function countOrderIndex (Request $request)
//    {
//
//        (new IdRule)->goCheck(200);
//
//        $id = $request->input('id');
//
//        $res = BusinessOrderModel::select(\Illuminate\Support\Facades\DB::raw('count(id) as count,status'))
//            ->where('users_id', '=', $id)
//            ->groupBy('status')
//            ->get();
//
//        return Common::successData($res);
//
//
//    }

    //获取税金
//    public function getZax ($zip, $city)
//    {
//        $city = str_replace(' ', '', $city);
//        $city = htmlspecialchars(strip_tags(trim($city)));
//        $url = sprintf(config('custom.tax_url'),
//            config('custom.tax_key'),
//            $zip, $city
//        );
//
//        $res = Common::curlInfo($url);
//
//        if ($res['rCode'] == 100) {
//
//            $this->zax = $res['results'][0]['taxSales'];
////            return Common::successData(['tax' => $res['results'][0]['taxSales']]);
//
//        } else if ($res['rCode'] == 104) {
//
//            throw new ParamsException([
//                'code' => 200,
//                'message' => '邮政编码格式无效'
//            ]);
//        } else {
//            throw new ParamsException([
//                'code' => 200,
//                'message' => '获取税金接口失败'
//            ]);
//        }
//    }

}
