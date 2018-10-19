<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use App\Rules\PayRule;
use App\Http\Model\OrderModel;
use App\Http\Model\UsersModel;
use App\Http\Model\CalendarUsersModel;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    //分单位
    protected $membershipPrice;

    protected $body;

    /**
     * 用户入会支付
     * url  : api/user/order
     * http : post
     */
    public function placeOrder (Request $request)
    {
        //用户id
        $id = $request->get('userId');

        $this->body = '黑马会入会费用';
        $this->membershipPrice = 3000;

        //创建订单
        $data = $this->createOrder($id, $this->membershipPrice, 1, 1);

        //openid
        $openid = UsersModel::getUserByID($id)->openid;

        $res = $this->makeWxPreOrder($data, $openid, config('custom.pay_back_url'));

        return Common::successData($res);

    }

    /**
     * 活动报名支付
     * url  : api/activite/order
     * http : post
     */
    public function payment (Request $request)
    {

        (new PayRule)->goCheck();
        $params = $request->all();

        //用户id
        $id = $request->get('userId');

        $this->body = '活动报名费';
        $this->membershipPrice = $request['price'];
        $type = $request['type'] != 1 ? 3 : 2;

        //创建订单
        $data = $this->createOrder($id, $this->membershipPrice, $type, 2, $params['id']);

        //关系表关系应该唯一
        $res = CalendarUsersModel::where('u_id', '=', $id)->where('c_id', '=', $params['id'])->where('type', '=', $params['type'])->first();

        if (!$res) {
            //插入 calendar_users
            $result = CalendarUsersModel::insert(['c_id' => $params['id'], 'u_id' => $id, 'type' => $params['type']]);

            if (!$result) {
                throw new \Exception('服务器内部错误');
            }
        }

        //openid
        $openid = UsersModel::getUserByID($id)->openid;

        $res = $this->makeWxPreOrder($data, $openid, config('custom.activite_pay_back_url'));

        return Common::successData($res);

    }

    //创建订单 向数据写入数据
    //获取openid 订单号
    private function createOrder ($id, $price, $type, $status, $belong = null)
    {
        //生成订单号
        $orderNo = $this->makeOrderNo();
        $time = time();
        $arr = [];
        //活动订单
        $arr = [
            'user_id' => $id,
            'order_no' => $orderNo,
            'total_price' => $price,
            'type' => $type,
            'create_time' => $time
        ];
        //活动订单
        if ($status != 1) {
            $arr['c_id'] = $belong;
        }

        $res = OrderModel::newOrder($arr);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return [
            //订单号
            'order_no' => $orderNo,
            //订单id
            'order_id' => $res,
            //生成时间
            'create_time' => $time
        ];

    }


    //构建微信支付订单信息
    private function makeWxPreOrder ($data, $openid, $url)
    {

        require_once(app_path() . DIRECTORY_SEPARATOR . 'WeChatPay' . DIRECTORY_SEPARATOR . 'WxPay.Api.php');

        //引入微信支付API
        $wxOrderData = new \WxPayUnifiedOrder();

        //支付订单号
        $wxOrderData->SetOut_trade_no($data['order_no']);

        $wxOrderData->SetTrade_type('JSAPI');
        //支付总金额 微信分做单位
        $wxOrderData->SetTotal_fee($this->membershipPrice * 100);
        //商品描述
        $wxOrderData->SetBody($this->body);
        //用户的openid
        $wxOrderData->SetOpenid($openid);
        //支付成功回调
        $wxOrderData->SetNotify_url($url);

        //发送到微信预订单 微信返回一个签名
        return $this->getPaySignatrue($data['order_id'], $wxOrderData);
    }

    //调微信预订单接口
    private function getPaySignatrue ($OrderId, $wxOrderData)
    {

        //调微信统一下单接口
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);

        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            //记录日志
            Log::error('获取预支付订单失败', $wxOrder);
            throw new ParamsException([
                'message' => '获取预支付订单失败'
            ]);
        }


        //prepay_id 存入数据库
        $this->recordPreOrder($OrderId, $wxOrder);

        //返回给客户端支付参数
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    //插入微信的预订单
    private function recordPreOrder ($OrderId, $wxOrder)
    {
        $res = OrderModel::where('id', '=', $OrderId)->update([
            'prepay_id' => $wxOrder['prepay_id']
        ]);

        if (!$res) {
            throw new \Exception('数据库插入预定单失败');
        }
    }


    //生成签名 拼接微信支付数据
    private function sign ($wxOrder)
    {

        $jsApiPayData = new \wxPayJsApiPay();
        //应用app
        $jsApiPayData->SetAppid(config('custom.appid'));
        //当前时间戳
        $jsApiPayData->SetTimeStamp((string)time());

        //随机字符串
        $rand = md5(uniqid());
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->Setpackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        //签名
        $sign = $jsApiPayData->MakeSign();
        //转化数组
        $array = $jsApiPayData->GetValues();
        $array['paySign'] = $sign;

        unset($array['appId']);
        return $array;
    }

    /**
     * 支付回调 成功支付后微信调用 post xml格式 url不能携带参数
     * 通知频率为15/15/30/180/1800/1800/1800/1800/3600，单位：秒
     * url  : api/pay/handleWx
     * http : post
     */
    public function handleWxReturn ()
    {
        return (new WxNotifyController())->Handle();
    }

    /**
     * 支付回调 成功支付后微信调用 post xml格式 url不能携带参数
     * 通知频率为15/15/30/180/1800/1800/1800/1800/3600，单位：秒
     * url  : api/pay/activite
     * http : post
     */
    public function handleWxActivite ()
    {

        return (new WxActiviteNotifyController())->Handle();
    }

    //生成下单ID
    public static function makeOrderNo ()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }


}
