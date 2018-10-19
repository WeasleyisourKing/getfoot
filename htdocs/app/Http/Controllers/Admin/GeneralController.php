<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\GeneralModel;
use App\Http\Controllers\Common;
use App\Rules\GeneralRule;
use App\Exceptions\ParamsException;

/**
 * 网站设置类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class GeneralController extends Controller
{

    /**
     * 订单列表页面
     * @param Request $request
     * @return null
     */
    public function general ()
    {

        $res = GeneralModel::getGeneral(1);

        $res->logo = !empty($res->logo) ? '/' . $res->logo : '';

        //数据 类型 标题
        return view('admin.general.general-general', ['data' => $res]);

    }

    /**
     * 邮件页面
     * @param Request $request
     * @return null
     */
    public function mail ($status)
    {
        //1 注册 2 下单 3 发货 4 到货


        $data = [];

        switch ((int)$status) {
            case 1 :
                $modular = 'email.blade.php';
                array_push($data, [
                    'zn' => '用户名字',
                    'val' => '{{$name}}'
                ]);
                array_push($data, [
                    'zn' => '有效时间',
                    'val' => '{{$expire}}'
                ]);
                array_push($data, [
                    'zn' => '回调URL',
                    'val' => '{{$url}}'
                ]);
                break;
            case 2 :
                $modular = 'downOrder.blade.php';
                array_push($data, [
                    'zn' => '用户名字',
                    'val' => '{{$name}}'
                ]);
                array_push($data, [
                    'zn' => '订单号',
                    'val' => '{{$number}}'
                ]);
                array_push($data, [
                    'zn' => '订单快照名称',
                    'val' => '{{$snapName}}'
                ]);
                array_push($data, [
                    'zn' => '产品列表',
                    'val' => '{!! $product_list !!} '
                ]);
                array_push($data, [
                    'zn' => '产品总价',
                    'val' => '{{$product_totalprice}}'
                ]);
                array_push($data, [
                    'zn' => '订单总数量',
                    'val' => '{{$product_count}}'
                ]);
                array_push($data, [
                    'zn' => '运费',
                    'val' => '{{$freight}}'
                ]);
                array_push($data, [
                    'zn' => '收件人',
                    'val' => '{{$addressee}}'
                ]);
                array_push($data, [
                    'zn' => '收件人手机号码',
                    'val' => '{{$mobile}}'
                ]);
                array_push($data, [
                    'zn' => '收件人地址',
                    'val' => '{{$express_address}}'
                ]);
                array_push($data, [
                    'zn' => '订单总价格',
                    'val' => '{{$order_totalprice}}'
                ]);
                break;
            case 3 :
                $modular = 'remind.blade.php';
                array_push($data, [
                    'zn' => '用户名字',
                    'val' => '{{$name}}'
                ]);
                array_push($data, [
                    'zn' => '订单号',
                    'val' => '{{$number}}'
                ]);
                array_push($data, [
                    'zn' => '订单快照名称',
                    'val' => '{{$snapName}}'
                ]);
                break;
            case 5 :
                $modular = 'ownOrder.blade.php';
                array_push($data, [
                    'zn' => '用户名字',
                    'val' => '{{$name}}'
                ]);
                array_push($data, [
                    'zn' => '用户邮件',
                    'val' => '{{$email}}'
                ]);
                array_push($data, [
                    'zn' => '订单号',
                    'val' => '{{$number}}'
                ]);
                array_push($data, [
                    'zn' => '订单快照名称',
                    'val' => '{{$snapName}}'
                ]);
                array_push($data, [
                    'zn' => '产品列表',
                    'val' => '{!! $product_list !!}'
                ]);
                array_push($data, [
                    'zn' => '产品总价',
                    'val' => '{{$product_totalprice}}'
                ]);
                array_push($data, [
                    'zn' => '订单总数量',
                    'val' => '{{$product_count}}'
                ]);
                array_push($data, [
                    'zn' => '运费',
                    'val' => '{{$freight}}'
                ]);
                array_push($data, [
                    'zn' => '收件人',
                    'val' => '{{$addressee}}'
                ]);
                array_push($data, [
                    'zn' => '收件人手机号码',
                    'val' => '{{$mobile}}'
                ]);
                array_push($data, [
                    'zn' => '收件人地址',
                    'val' => '{{$express_address}}'
                ]);
                array_push($data, [
                    'zn' => '订单总价格',
                    'val' => '{{$order_totalprice}}'
                ]);
                break;
            default :
                $modular = 'arrival.blade.php';
                array_push($data, [
                    'zn' => '用户名字',
                    'val' => '{{$name}}'
                ]);
        }


        $str = file_get_contents(resource_path() . config('custom.DIRECTORY_SEPARATOR') . 'views' . config('custom.DIRECTORY_SEPARATOR') . 'layouts' . config('custom.DIRECTORY_SEPARATOR') . $modular);

        $str = str_replace("\n", "<br/>", $str);

//        dump($data);
        //数据 类型 标题
        return view('admin.general.general-mail', ['status' => $status, 'data' => $str, 'params' => $data]);

    }

    /**
     * 邮件页面
     * @param Request $request
     * @return null
     */
    public function deliver ()
    {

        //数据 类型 标题
        return view('admin.general.general-deliver');

    }


    /**
     * 保存通用设置接口
     * @param Request $request
     * @return null
     */
    public function generalEditor (Request $request)
    {

        (new GeneralRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [];
        $data = [
            'title' => htmlspecialchars(strip_tags(trim($params['title']))),
            'keywords' => htmlspecialchars(strip_tags(trim($params['keywords']))),
            'description' => htmlspecialchars(strip_tags(trim($params['description'])))
        ];

        //判断图片
        if (!empty($params['imgAddress'])) {
            $data['logo'] = is_array($params['imgAddress']) ? strstr($params['imgAddress'][0], 'uploads') : strstr($params['imgAddress'], 'uploads');
        }

        //添加用户
        $res = GeneralModel::updateGeneralInfo($request['id'], $data);

        if (!$res) {
            throw new ParamsException([
                'code' => 200,
                'message' => '内容没有修改'
            ]);
        }
        return Common::successData();
    }

    /**
     * 邮件内容修改接口
     * @param Request $request
     * @return null
     */
    public function generalMailModify (Request $request)
    {
        //1 注册 2 商品下单（用户接收） 3 发货 4 到货 5 商品下单（商家接收）
        $params = $request->all();
        $data = [];

        switch ((int)$params['id']) {
            case 1 :
                $modular = 'email.blade.php';
                break;
            case 2 :
                $modular = 'downOrder.blade.php';
                break;
            case 3 :
                $modular = 'remind.blade.php';
                break;
            case 5 :
                $modular = 'ownOrder.blade.php';
                break;
            default :
                $modular = 'arrival.blade.php';
        }


        $path = resource_path() . config('custom.DIRECTORY_SEPARATOR') . 'views' . config('custom.DIRECTORY_SEPARATOR') . 'layouts' . config('custom.DIRECTORY_SEPARATOR') . $modular;

        $res = file_put_contents($path, $params['text']);

        if (!$res) {
            throw new ParamsException([
                'code' => 200,
                'message' => '修改失败'
            ]);
        }
        return Common::successData();

    }


}

