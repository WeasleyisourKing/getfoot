<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Http\Request as re;
use Mail;

/**
 * 公共类
 * Class Common
 * @package App\Http\Controllers
 */
class Common
{

    /**
     * @param $url 路由
     * @param null $data 传递数据
     * @param int $header 头信息
     * @param int $timeout 超时设定
     * @return mixed|string
     */
    public static function curlInfo ($url, $data = null, $header = 0, $timeout = 100)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//访问的url
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);// 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//输出为数组形式，默认原样输出
        curl_setopt($ch, CURLOPT_HEADER, $header);//不输出头
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);//设置时间
        if (!empty($data)) {

            curl_setopt($ch, CURLOPT_POST, 1);//开启post传参数
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//传递的参数
        }
        $output = curl_exec($ch);
        if ($error = curl_error($ch)) {
            return ($error);
        }

        curl_close($ch);

//        dump($ch);
        return json_decode($output, true);
    }

    public static function successData ($data = [], $status = false)
    {
        $result = [];
        $result = [
            'status' => true,
            'code' => 200,
            'data' => $data
        ];
        if ($status) {
            $json = json_encode($result);
            return "my({$json})";
        }

        return response()->json($result, 200);

    }

    /**
     * 生成$length长的随机字符串
     * @param int $length 一个整数
     * @return string
     */
    public static function getRandChar ($length)
    {

        $str = '';
        $strBase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz`!@#$%^&*()-+|';
        $max = strlen($strBase) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $strBase[mt_rand(0, $max)];
        }
        return $str;
    }

    /**
     * 生成$length长的随机字符串
     * @param int $length 一个整数
     * @return string
     */
    public static function getRandCharAndNumber ($length)
    {

        $str = '';
        $strBase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($strBase) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $strBase[mt_rand(0, $max)];
        }
        return $str;
    }

    //生成token
    //32位随机字符串
    public static function genrateToken ()
    {

        $randChars = str_random(32);

        return $token = substr(bcrypt($randChars . time() . config('custom.token_prefix')), 7);

    }

    //递归
    public static function getTree ($data, $pId, $level = 0, $html = '---')
    {

        $tree = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pId) {
                $v['level'] = $level;
                $v['html'] = str_repeat($html, $level);
                $v['pid'] = self::getTree($data, $v['id'], $level + 1);
                $tree[] = $v;
                unset($data[$k]);

            }
        }
        return $tree;
    }

    /**
     * 根据header-token判断用户是否存在
     * @param Request $request
     * @return mixed
     */
    public static function getUserTokenVar ()
    {

        $token = Request::header('token');

        if (!$token) {
            throw new \App\Exceptions\TokenException();
        }

        $user = new \App\Http\Model\UserModel();
        $info = $user->where('api_token', '=', $token)->first();

        if (!$info) {
            throw new \App\Exceptions\UserException([
                'message' => '用户不存在'
            ]);
        }

        return $info->id;
    }


    /**
     * 筛选数据
     * @param array $array 数据
     * @param array $hit 允许的数据
     * @return array $data 筛选后的数据
     */
    public static function screen ($array, $hit)
    {

        if ((!is_array($array) || empty($array)) || (!is_array($hit) || empty($hit))) return;

        $data = [];
        if (count($array) == count($array, 1)) {
            foreach ($hit as $k => $v) {

                if (array_key_exists($v, $array)) {

                    $data[$v] = $array[$v];
                }
            }
        } else {
            foreach ($array as $ko => $vo) {
                foreach ($hit as $k => $v) {
                    if (array_key_exists($v, $vo)) {
                        $data[$ko][$v] = $vo[$v];
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 分页数据整理
     * @param $res 分页数据对象
     * @param $arr 允许的数据数组
     * @return array
     */
    public static function paging ($res, $arr)
    {

        $info = [];
        //总页数
        $info['total'] = $res['last_page'];
        //当前页
        $info['currentPage'] = $res['current_page'];
        //数据
        $info['items'] = $res['data'];

        $info['items'] = self::screen($info['items'], $arr);

        return $info;
    }


    /**
     * 图片处理
     * @param Request $request
     * @return \think\response\Json
     */
    public function imgHandle (re $request)
    {


        $img = $request->file('img');

        //对象是否存在
        if (empty($img)) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '文件已经上传'
                ]
            ]);
        }
        // 文件是否上传成功
        if (!$img->isValid()) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '文件上传失败'
                ]
            ]);
        }
        //后缀名
        $ext = $img->getClientOriginalExtension();
        $fileTypes = ['png', 'jpg', 'gif', 'jpeg'];

        if (!in_array($ext, $fileTypes)) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '图片格式只允许png,jpg,gif,jpeg'
                ]
            ]);
        }
        // 上传文件名称
        $imgName = $img->getClientOriginalName();

        //文件目录
        $filePath = config('custom.file_path');

//        dump($imgName);
//        dd($filePath . config('custom.DIRECTORY_SEPARATOR'));
        // 移动到框架应用根目录/uploads/目录下 文件名不变 同名覆盖
        $img->move($filePath . config('custom.DIRECTORY_SEPARATOR'), $imgName);

        $res = [
            'errno' => 0,
            'data' => [
                config('custom.img_url') . config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . $imgName
            ]
        ];

        //涉及banner多表 添加轮播图
        if ($request->input('status') == 1 || $request->input('status') == 2) {

            (new \App\Http\Model\BannerItemModel)->insertBannerItem(['url' => config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . $imgName], $request->input('status'));
        } else {

            $obj = (new \App\Http\Model\ImageModel)->insertImage(['url' => config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . $imgName]);

            $res['img_id'] = $obj->id;
        }


        return response()->json($res);
    }

    //生成下单ID
    public static function makeOrderNo ($num)
    {
//        $num = 'A2018091711118';
//        dump($num);
        $yCode = array('A', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

        if (($date = date('Ymd')) != substr($num, 1, 8)) {
            //不是同一天 重新计算
            $orderSn = $yCode[intval(date('Y')) - 2018] . date('Ymd') . '00001';

        } else {
            $nums = substr($num, -(mb_strlen($num) - 9)) + 1;
//            dump($nums);
//            dump(substr($num, -(mb_strlen($num) - 9)));
//            dump(mb_strlen(substr($num, -(mb_strlen($num) - 9)) + 1));
//
//            dump(str_repeat('0', 5 - (mb_strlen(substr($num, -(mb_strlen($num) - 9)) + 1))));
            $orderSn = $yCode[intval(date('Y')) - 2018] . date('Ymd') .  str_repeat('0', 5 - (mb_strlen(substr($num, -(mb_strlen($num) - 9)) + 1))) . $nums;
        }

//        dd($orderSn);

//        $t = str_repeat('0', 5 - (mb_strlen(substr($num, -(mb_strlen($num) - 9)) + 1))) . $num;

//        $orderSn =
//            $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date(
//                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
//                '%02d', rand(0, 99));
        return $orderSn;
    }

    //付款成功发送邮箱
    public static function sendEmail ($email, $name,  $orderName, $orderMobile, $number, $snapName, &$snapshootOrder)
    {

        //表格显示商品列表
        $productList = '
        <table style="border-collapse:collapse;"  style="font-size: 40px;">
        <thead>
    <tr style="background: #999;color: white;">
        <th  height="40" width="400">产品</th>
        <th  height="40" width="100">单价</th>
        <th  height="40" width="100">数量</th>
    </tr>
    </thead>
     <tbody style="border: 1px solid #000;">
        %s
       </tbody>
</table> ';


        $content = '';
        $url = config('custom.img_url');

        foreach ($snapshootOrder['pStatus'] as $itms) {

            $content .= "<tr style='border:1px solid #eee;color: #333;' height='40px' width='40px'>
        <td style='text-align:center;border-right:1px solid #eee;'><img height='40px' width='40px' src='{$url}{$itms["image"]}' />{$itms['name']}</td>
        <td style='text-align:center;border-right:1px solid #eee;'>\${$itms['singlePrice']}</td>
        <td style='text-align:center;'>{$itms['count']}</td>
         </tr>";

        }

        $productList = sprintf($productList, $content);
        $address = json_decode($snapshootOrder['snapshootAddress'], true);


        // Mail::send()的返回值为空，所以可以其他方法进行判断
        //模板 变量 参数绑定Mail类的一个实例
        Mail::send('layouts.downOrder', [
            'name' => $name,
            'number' => $number,
            'snapName' => $snapName,
            'product_list' => $productList,
            'product_totalprice' => $snapshootOrder['orderPrice'] - $snapshootOrder['freight'],
            'product_count' => $snapshootOrder['allCount'],
            'freight' => $snapshootOrder['freight'],
            'addressee' => $orderName,
            'mobile' => $orderMobile,
            'express_address' => $address['detail'] . $address['country'] . $address['city'] . $address['province'],
            'order_totalprice' => $snapshootOrder['orderPrice']

        ], function ($message) use ($email) {

            $message->to($email)->subject('下单提醒');
        });
        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) > 1) {
            Log::info("下单提醒给用户" . $email . "邮件失败");

        }

        Mail::send('layouts.ownOrder',
            [
                'name' => $name,
                'number' => $number,
                'snapName' => $snapName,
                'product_list' => $productList,
                'product_totalprice' => $snapshootOrder['orderPrice'] - $snapshootOrder['freight'],
                'product_count' => $snapshootOrder['allCount'],
                'freight' => $snapshootOrder['freight'],
                'addressee' => $orderName,
                'mobile' => $orderMobile,
                'express_address' => $address['detail'] . $address['country'] . $address['city'] . $address['province'],
                'order_totalprice' => $snapshootOrder['orderPrice']

            ]
            , function ($message) {

                $message->to(config('custom.send_eamil'))->subject('用户下单提醒');
            });
        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) > 1) {
            Log::info("用户下单" . $email . "邮件失败");

        }

    }
}
