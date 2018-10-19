<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\UsersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Model\OrderModel;
use App\Http\Model\ProductModel;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use Mail;

//require_once(app_path() . DIRECTORY_SEPARATOR . 'PayPal' . DIRECTORY_SEPARATOR .'Rest'.DIRECTORY_SEPARATOR . 'ApiContext.php');

/**
 * 抓货验证类
 * Class CatchController
 * @package App\Http\Controllers\Admin
 */
class CatchController extends Controller
{

    /**
     * 抓货订单页面
     * @param Request $request
     * @return null
     */
    public function catchList ()
    {

        $info = Auth::user();

        $number = OrderModel::countNUm();


        return view('admin.catch.catch-list',
            [
                'number' => $number,
                'name' => $info['username']
            ]);

    }

    /**
     * 随机获取订单接口
     * @param Request $request
     * @return null
     */
    public function catchOrder ()
    {
        $res = OrderModel::catchOrder();

        //数据太大 防止内存溢出
        $product = json_decode($res['snap_items'], true);

        unset($res['snap_items']);
        unset($res['snap_address']);

        return Common::successData([
            'product' => $product,
            'data' => $res
        ]);
    }

    /**
     * 订单完成或异常接口
     * @param Request $request
     * @return null
     */
    public function catchStatus (Request $request)
    {

        $params = $request->all();

        //避免重复点击
       $val = OrderModel::where('id', '=', $params['id'])->first(['handle_status','order_no']);

         if ($val->handle_status != 2 && $val->handle_status != 1) {

             throw new ParamsException([
                 'code' => 200,
                 'message' => '订单'.$val->order_no.'已完成抓货'
             ]);
         }

        $data = [];
        //抓单完成
        if ($params['status'] == 1) {
            $data = [
                'track_number' => $params['track'],
                'handle_status' => 4,
                'status' => 3
            ];

            //发送邮件
            $uid = OrderModel::where('id', '=', $params['id'])->first(['users_id', 'order_no', 'snap_name']);

            $model = UsersModel::where('id', '=', $uid->users_id)->first(['email', 'name']);

            $this->sendEmail($model->email, $model->name, $uid->order_no, $uid->snap_name);
        } else {
            $data = [
                'handle_status' => 3
            ];
        }

        $res = OrderModel::updateStatus($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }


    /**
     * 关闭或者刷新订单接口
     * @param Request $request
     * @return null
     */
    public function catchReduction (Request $request)
    {

        $params = $request->all();

        $data = OrderModel::where('id', '=', $params['id'])->first();

        if ($data->handle_status == 1) {

            $res = OrderModel::updateStatus($params['id'], ['handle_status' => 2]);

            if (!$res) {
                throw new \Exception('服务器内部错误');
            }

            return Common::successData();
        } else {
            return Common::successData();
        }

    }

    //支付测试页面
    public function payShow ()
    {
        return view('admin.catch.catch-pay');
    }

    //发送邮箱
    public function sendEmail ($email, $name, $number, $snapName)
    {

        // Mail::send()的返回值为空，所以可以其他方法进行判断
        //模板 变量 参数绑定Mail类的一个实例
        Mail::send('layouts.remind', ['name' => $name, 'number' => $number, 'snapName' => $snapName], function ($message) use ($email) {

            $message->to($email)->subject('发货提醒');
        });
        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) > 1) {
            Log::info("订单发货给用户" . $email . "邮件失败");

        }
    }

}

