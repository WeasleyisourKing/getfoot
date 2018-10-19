<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\OrderModel;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\GeneralModel;
use App\Http\Model\ProductModel;
use App\Http\Controllers\Common;
use App\Rules\FreightRule;
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


    /**
     * 订单列表页面
     * @param Request $request
     * @return null
     */
    public function businessList ($status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2, 3, 4, 5];
        //默认显示已完成
        switch ($status) {
            case 1 :
                $title = '待处理';
                break;
            case 2 :
                $title = '未支付';
                break;
            case 3 :
                $title = '已发货';
                break;
            case 4 :
                $title = '已完成';
                break;
            case 5 :
                $title = '退货';
                break;
            default :
                $title = ' 全部状态';
        }

        $res = BusinessOrderModel::getOrderList($statusData, $limit);

        return view('admin.business.business-order', [
            'data' => $res,
            'title' => $title,
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 某订单详情页面
     * @param Request $request
     * @return null
     */
    public function orderDetail ($id)
    {

        $res = BusinessOrderModel::getOrderProduct($id);

        //数据太大 防止内存溢出
        $product = json_decode($res['snap_items'], true);

        $address = json_decode($res['snap_address'], true);

        unset($res['snap_items']);
        unset($res['snap_address']);

        $originPrice = round(($res['total_price'] - $res['freight']) / (1 + $res['tax']), 2) * $res['tax'];


        return view('admin.business.order-detail', ['data' => $res,  'product' => $product, 'address' => $address]);
    }


    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderDel (Request $request)
    {

        $id = $request->input('id');

        $res = BusinessOrderModel::delOrder($id);

        return Common::successData();
    }


    //创建订单接口
    public function placeOrder (Request $request)
    {


        (new OrderRule)->goCheck(200);
        (new AddressRule)->goCheck(200);

        $params = $request->all();
        $uProducts = $params['products'];
        unset($params['products']);
        unset($params['_token']);

        return $this->place($params, $uProducts);
    }

    /**
     * 用户下单 比对数据库 存入数据
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function place ($addressInfo, $uProducts)
    {

        //属性赋值
        $this->uProducts = $uProducts;
        $this->products = $this->getProductsByOrder($uProducts);
        $this->addressInfo = $addressInfo;

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
            throw new ParamsException([
                'code' => 200,
                'message' => $text
            ]);
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

        return Common::successData($order);

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
                throw new ParamsException([
                    'message' => $item['name'] . '商品已经下架',
                    'errorCode' => 7001
                ]);
            }
        }

        return $Products;
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
            throw new ParamsException([
                'message' => 'id为' . $uPID . '商品不存在'
            ]);
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

        //添加邮箱
        $this->addressInfo['email'] = '暂未填写';
        //添加下单
        $this->addressInfo['user'] = Auth::user()->username;
        return $this->addressInfo;
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
            'users_id' => 0,
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


    /**
     * 导出xlsx xls文件
     * @param string $data 需要导出数据
     * @param array $colName 表格列头
     * @param string $tableName 表名字
     * @param string $excelName excel文件名
     *
     */
    public function exportExcel (&$data, $colName, $tableName, $excelName)
    {

        //表标题
        $tableName = "<tr style='height:50px;border-style:none;'>
                        <th border=\"0\" style='height:60px;width:270px;font-size:40px;' colspan='11'>
                            {$tableName}
                        </th>
                    </tr>";

        //表格列头
        $titleName = '';
        foreach ($colName as $item) {
            $titleName .= "<th style='width:100px;font-size:20px;'>{$item}</th>";
        }

        //excel文件名
        $excelName = $excelName . ".xls";
        $this->pushExcel($data, $titleName, $tableName, $excelName);
    }


    /*
    * 处理Excel导出
    */
    private function pushExcel (&$datas, &$titleName, &$title, $filename)
    {
        //日期时间函数的默认时区
        date_default_timezone_set('Asia/Shanghai');
        $str = "<html xmlns:o=\"urn:schemas-microsoft-com:
                office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:
                excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>
                \r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">
                \r\n</head>\r\n<body>";

        $str .= '<div style="font-size:30px; text-align: center;">'.$title;
        $str .= "<table border=1><head>" . $titleName . "</head>";

        foreach ($datas as $key => $rt) {
            $str .= "<tr style='text-align: center;font-size:25px; width: 100px; '>";
            foreach ($rt as $k => $v) {
                $str .= "<td>{$v}</td>";
            }
            $str .= "</tr>";
        }

        $str .= "</table></body></html>";
        header("Content-Type: application/vnd.ms-excel; name='excel'");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Expires: 0");
        exit($str);
    }


}



