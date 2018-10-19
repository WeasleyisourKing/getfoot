<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2018/7/12
 * Time: 14:17
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Common;
use App\Rules\CitconRule;
use App\Exceptions\ParamsException;
use Illuminate\Support\Facades\Log;
use App\Http\Model\OrderModel;
use App\Http\Model\ProductModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Model\UsersModel;

//citcon支付
class CitconController
{

    public function pay (Request $request)
    {

        (new CitconRule)->goCheck(200);

        $params = $request->all();

        $order = OrderModel::where('order_no', '=', $params['reference'])->first(['total_price']);

//        $host = $params['vendor'] == 'alipay' ? config('custom.alipay_url') : config('custom.wxpay_url');
        $host = config('custom.citcon_status') != 'YES' ? config('custom.citcon_alipay_sandbox_url') : config('custom.citcon_alipay_accept_url');
//        config('custom.alipay_url');
        $url = sprintf($host,
            $order['total_price'] * 100,
            $params['vendor'],
            $params['reference'],
            urlencode(config('custom.img_url') . config('custom.callback_url')),
            urlencode($params['callback_url'])
        );


        $res = $this->curlInfo($url, null, ['Authorization:' . config('custom.citon_token')]);


        if (!strstr($res, 'https')) {

            Log::error('获取citcon支付数据失败', (array)$res);
            throw new ParamsException([
                'message' => '获取citcon支付数据失败'
            ]);
        }

        return Common::successData($res);
    }
   public function curlInfo ($url, $data = null, $header = 0, $timeout = 30)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//访问的url
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);// 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//输出为数组形式，默认原样输出
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_HEADER, true);//不输出头
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);//设置时间

        if (!empty($data)) {

            curl_setopt($ch, CURLOPT_POST, 1);//开启post传参数
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//传递的参数
        }
        $output = curl_exec($ch);

        if ($error = curl_error($ch)) {
            dd($error);
            return ($error);
        }

        curl_close($ch);

        return $output;

    }

    //citon 回调
    public function payCallback (Request $request)
    {


        $params = $request->all();

        if ($params['status'] == 'success') {
            $orderNO = $params['reference'];
            $order = OrderModel::where('order_no', '=', $orderNO)->first();
            //未支付 修改相关表状态
            if ($order->status == 2) {

                ProductModel::updateProductStock($order->id);
                $res = OrderModel::where('id', '=', $order->id)->update(['status' => 1]);

                if (!$res) {

                    Log::error('citcon订单状态修改失败', $params);

                    return;
                }

                $userAddress = UsersAddressModel::getUserAddress($order->users_id);
                $userIfo = UsersModel::getUserInfo($order->users_id);

                $snapshootOrder = [
                    'pStatus' => json_decode($order->snap_items, true),
                    'snapshootAddress' => $order->snap_address,
                    'orderPrice' => $order->total_price,
                    'freight' => $order->freight,
                    'allCount' => $order->total_count
                ];
                Common::sendEmail($userIfo->email, $userIfo->name, $userAddress->name, $userAddress->mobile, $order->order_no, $order->snap_name, $snapshootOrder);

            }

        }
    }
}