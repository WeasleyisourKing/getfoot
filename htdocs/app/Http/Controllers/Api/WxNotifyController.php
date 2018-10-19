<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2017/11/7
 * Time: 10:40
 */

namespace App\Http\Controllers\Api;

use App\Http\Model\OrderModel;
use App\Http\Model\MessageModel;
use App\Http\Model\UsersModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

require_once(app_path() . DIRECTORY_SEPARATOR . 'WeChatPay' . DIRECTORY_SEPARATOR . 'WxPay.Notify.php');

class WxNotifyController extends \WxPayNotify
{


    //用于接收微信传来消息
    //高并发可能重复修改订单状态 运行时间超过微信发送消息时间 解决方法 事务
    public function NotifyProcess ($data, &$msg)
    {

        //支付成功
        if ($data['result_code'] == 'SUCCESS') {

            $orderNO = $data['out_trade_no'];
            DB::beginTransaction();
            try {
                //根据订单号查询
                $order = OrderModel::where('order_no', '=', $orderNO)->first();
                //未支付 修改相关表状态
                if ($order->status == 2) {

                    $this->updateOrderStatus($order->id, $order->user_id);
                }
                DB::commit();
                return true;
            } catch (\Exception $ex) {
                DB::rollback();

                $err = [
                    'message' => $ex->getMessage(),
                    'file' => $ex->getFile(),
                    'line' => $ex->getLine(),
                    'code' => $ex->getCode(),
                ];
                Log::error('回调处理失败', $err);
                return false;
            }
        } else {
            return true;
        }

    }

    //更新支付状态
    private function updateOrderStatus ($orderId, $userId)
    {
        OrderModel::where('id', '=', $orderId)->update(['status' => 1]);
        MessageModel::where('user_id', '=', $userId)->update(['role' => 1]);
        UsersModel::where('id', '=', $userId)->update(['role' => 1]);

    }

}