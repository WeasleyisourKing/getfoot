<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\ProductShelvesModel;
use App\Http\Model\ShelvesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\ProductModel;
use App\Http\Controllers\Common;
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

    protected $Plevel;

    /**
     * 订单列表页面
     * @param Request $request
     * @return null
     */
    public function businessList($status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];
        //默认显示已完成
        switch ($status) {
            case 1 :
                $title = '已完成';
                break;
            default :
                $title = ' 已下单';
        }

        $res = BusinessOrderModel::getOrderList($statusData, $limit);

//        dump($res->toArray());
        return view('admin.business.business-order', [
            'data' => $res,
            'title' => $title,
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 商业订单详情页面
     * @param Request $request
     * @return null
     */
    public function orderDetail($id, $status)
    {


        $ress = BusinessOrderModel::with(['purchase' => function ($query) {

            $query->with(['products' => function ($querys) {
                $querys->select('id', 'product_image', 'sku', 'innersku', 'number', 'zn_name', 'en_name', 'stock', 'price');
            }]);
        }])
            ->where('id', $id)
            ->first()
            ->toArray();

        //数据太大 防止内存溢出
        $address = json_decode($ress['snap_address'], true);

        $shelves = json_decode($ress['shelve_position'], true);
        unset($ress['shelve_position']);

        foreach ($ress['purchase'] as &$items) {
            foreach ($shelves as $key => $v) {

                if ($key == $items['product_id']) {
                    $items['shelves'] =  $v;
                }
            }
        }

//        dd($ress);
        return view('admin.business.order-detail',
            [
                'data' => $ress,
                'address' => $address,
                'status' => $status
            ]);
    }


    /**
     * //删除订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderDel(Request $request)
    {

        $id = $request->input('id');
        //已完成不能删除
        $object = BusinessOrderModel::find($id);
        if ($object->status != 2) {
            throw new ParamsException([
                'code' => 200,
                'message' => '状态为已完成不能删除'
            ]);
        }

        $res = BusinessOrderModel::delOrder($id, $object->order_no);

        return Common::successData();
    }


    //后台创建商业订单接口
    public function placeOrder(Request $request)
    {


        (new OrderRule)->goCheck(200);
        (new AddressRule)->goCheck(200);

        $params = $request->all();
        $uProducts = $params['uproducts'];

        //删除其他剩下地址
        unset($params['uproducts']);
        unset($params['products']);
        unset($params['_token']);

        switch ($params['pstatus']) {

            case 1 :
                $this->Plevel = 'price';
                break;
            case 2 :
                $this->Plevel = 'level_two_price';
                break;
            case 3 :
                $this->Plevel = 'level_one_price';
                break;
            case 4 :
                $this->Plevel = 'level_three_price';
                break;
            default :
                $this->Plevel = 'level_four_price';
        }

        return $this->place($params, $uProducts);
    }

    /**
     * 用户下单 比对数据库 存入数据
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function place($addressInfo, $uProducts)
    {

        //属性赋值
        $this->uProducts = $uProducts;
        $this->products = $this->getProductsByOrder($uProducts);
        $this->addressInfo = $addressInfo;

        //数据库比对调用
        //某商品库存不够
        $status = $this->getOrderStatus();

        foreach ($status['pStatusArray'] as $k => $item) {
            if ($item['haveStock'] != true) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品' . $item['znName'] . '库存不足；'
                ]);

            }

            unset($status['pStatusArray'][$k]['haveStock']);
            unset($status['pStatusArray'][$k]['znName']);

        }

        //有存货 创建订单
        $snapshootOrder = $this->snapshootOrder($status);

        //写入数据库 订单号 购买商品
        //订单和商品关系 多对多
        $order = self::createOrder($snapshootOrder);

        return Common::successData($order);

    }


    //根据用户订单查找数据库商品信息
    private function getProductsByOrder($uProducts)
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
                    'message' => $item['zn_name'] . '商品已经下架',
                    'errorCode' => 7001
                ]);
            }
        }

        return $Products;
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

            $pStatus = $this->getProductStatus($uProduct['product_id'], $uProduct['count'], $uProduct['overdue'], $this->products);

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

    //判断某一件商品是否有货及各项属性
    //用户某件商品id 用户某件商品总数 数据库数据
    private function getProductStatus($uPID, $uCount, $overdue, $products)
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
                'message' => 'id为' . $uPID . '商品不存在'
            ]);
        } else {


            $product = $products[$pIdex];
            $pStatus['product_id'] = $product['id'];
            $pStatus['znName'] = $product['zn_name'];
            $pStatus['overdue'] = $overdue;
//            $pStatus['enName'] = $product['en_name'];
//            $pStatus['sku'] = $product['sku'];
            $pStatus['count'] = $uCount;
            $pStatus['single_price'] = $this->Plevel != 'price' ? $product['distributor'][$this->Plevel] : $product[$this->Plevel];
//            $pStatus['image'] = $product['product_image'];
            $pStatus['total_price'] = $this->Plevel != 'price' ? $uCount * $product['distributor'][$this->Plevel] : $uCount * $product[$this->Plevel];
//            $pStatus['innersku'] = $product['innersku'];
//            $pStatus['shelves'] = $product['shelves'];
//            $pStatus['shelves'] = $product['shelves'][0]['name'];
//            $pStatus['number'] = $product['number'];
            $pStatus['haveStock'] = $product['stock'] >= $uCount ? true : false;
        }

        return $pStatus;
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

        //添加邮箱
//        $this->addressInfo['email'] = '暂未填写';
        //添加下单
        $this->addressInfo['user'] = Auth::user()->username;

        return $this->addressInfo;
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
            'users_id' => 0,
            'total_price' => $orderSnap['orderPrice'],
            'total_count' => $orderSnap['allCount'],
            'snap_img' => $orderSnap['snapImg'],
            'snap_name' => $orderSnap['snapshootName'],
            'snap_address' => $orderSnap['snapshootAddress'],
            'shelve_position' => json_encode($this->shelvePosition($orderSnap['pStatus']))
        ];
        $num = \App\Http\Model\StockOrderModel::where('status', '=', 2)->orderBy('created_at', 'desc')->first(['order_no']);

        $orderNos = Common::makeOrderNo(is_null($num) ? 'O2018101800001' : $num->order_no);
        //构造数据
        $datas = [];
        $datas = [
            'order_no' => 'O' . $orderNos,
            'operator' => 'admin',
            'total_count' => $orderSnap['allCount'],
            'total_price' => $orderSnap['orderPrice'],
            'pruchase_order_no' => 'ST' . $orderNo,
            'remark' => '后台手动生成商户订单',
            'status' => 2,
            'type' => 2
        ];

        //插入
        $res = BusinessOrderModel::insertOrder($data, $datas, $orderSnap['pStatus']);

        return [
            //订单号
            'order_no' => $orderNo,
            //订单id
            'order_id' => $res['id'],
            //生成时间
            'create_time' => $res['created_at']
        ];

    }

    //获取货架位置
    public function shelvePosition($param)
    {
        $arr = [];
//dd($param);
        foreach ($param as &$items) {
            $data = ProductShelvesModel::where('product_id', '=', $items['product_id'])
                ->orderBy('overdue', 'asc')
                ->orderBy('count', 'asc')
                ->get()
                ->toArray();

            if (empty($data)) {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品'.ProductModel::where('id','=',$items['product_id'])->first(['zn_name'])->zn_name.'在货架上查询不到库存;'
                ]);
            }

            $arr[$items['product_id']] = [];
            $info = ShelvesModel::whereIn('id',array_column($data,'shelves_id'))->get(['id','name'])->toArray();

            if (($sum = array_sum(array_column($data,'count'))) < $items['count']) {

                throw new ParamsException([
                    'code' => 200,
                    'message' => '商品'.ProductModel::where('id','=',$items['product_id'])->first(['zn_name'])->zn_name.'在货架
                    '.implode(",",array_column($info,'name')).
                        '共计'."\"$sum\"" .'件,库存不足;'
                ]);
            }


            foreach ($data as &$v) {
                //获取货架位置
                foreach ($info as $va) {
                    if ($va['id'] == $v['shelves_id']) {
                        $v['name'] = $va['name'];
                    }
                }
                //最近的商品满足不了需要的数量
                if ( $items['count'] - $v['count'] > 0 ) {

                    $arr[$items['product_id']][] = $v;
                    $items['count'] -= $v['count'];

                } else {
                    //商品大于需要的数量
                    $v['count'] = $items['count'];
                    $arr[$items['product_id']][] = $v;
                    break;
                }

            }

        }

      return $arr;
    }

    public function users(Request $request)
    {

        $data = str_replace(' ', '', $request->input('value'));

        $data = htmlspecialchars(strip_tags(trim($data)));

        if (empty($data)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索内容不能为空'
            ]);
        }

        $res = \App\Http\Model\UsersModel::with(['manys' => function ($q) {
            $q->where('default', '=', 1);
        }])
            ->select('id', 'name', 'email', 'role')
            ->where('name', 'like', '%' . $data . '%')
            ->where('status', '=', 1)
            ->whereIn('role', [2, 3, 4])
            ->orderBy('created_at', 'desc')
            ->get();


        return Common::successData($res);
    }

//    public function exportExcel ()
//    {
//        $data = Db::name('use')->select();
//        $col = ['id', 'test', 'qq', 'name', 'sex', 'age', 'number'];
//        $tableName = '用户表';
//        $excelName = '用户记录';
//        return (new Excel())->exportExcel($data, $col, $tableName, $excelName);
//    }

    /**
     * 导出xlsx xls文件
     * @param string $data 需要导出数据
     * @param array $colName 表格列头
     * @param string $tableName 表名字
     * @param string $excelName excel文件名
     *
     */
//    public function exportExcel (&$data, $colName, $tableName, $excelName)
//    {
//
//        //表标题
//        $tableName = "<tr style='height:50px;border-style:none;'>
//                        <th border=\"0\" style='height:60px;width:270px;font-size:40px;' colspan='11'>
//                            {$tableName}
//                        </th>
//                    </tr>";
//
//        //表格列头
//        $titleName = '';
//        foreach ($colName as $item) {
//            $titleName .= "<th style='width:100px;font-size:20px;'>{$item}</th>";
//        }
//
//        //excel文件名
//        $excelName = $excelName . ".xls";
//        $this->pushExcel($data, $titleName, $tableName, $excelName);
//    }


    /*
    * 处理Excel导出
    */
//    private function pushExcel (&$datas, &$titleName, &$title, $filename)
//    {
//        //日期时间函数的默认时区
//        date_default_timezone_set('Asia/Shanghai');
//        $str = "<html xmlns:o=\"urn:schemas-microsoft-com:
//                office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:
//                excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>
//                \r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">
//                \r\n</head>\r\n<body>";
//
//        $str .= '<div style="font-size:30px; text-align: center;">'.$title;
//        $str .= "<table border=1><head>" . $titleName . "</head>";
//
//        foreach ($datas as $key => $rt) {
//            $str .= "<tr style='text-align: center;font-size:25px; width: 100px; '>";
//            foreach ($rt as $k => $v) {
//                $str .= "<td>{$v}</td>";
//            }
//            $str .= "</tr>";
//        }
//
//        $str .= "</table></body></html>";
//        header("Content-Type: application/vnd.ms-excel; name='excel'");
//        header("Content-type: application/octet-stream");
//        header("Content-Disposition: attachment; filename=" . $filename);
//        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//        header("Pragma: no-cache");
//        header("Expires: 0");
//        exit($str);
//    }


}



