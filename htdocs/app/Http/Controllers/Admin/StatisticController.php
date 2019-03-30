<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\CategoryModel;
use App\Http\Model\BusinessOrderProductModel;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\ProductModel;
use App\Http\Model\UsersModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Controllers\Common;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ParamsException;

/**
 * 仪表盘管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class StatisticController extends Controller
{

    //商品销售统计
    public function product(Request $request)
    {

        $params = $request->all();

        $sql = BusinessOrderProductModel::with(['products' => function ($q) {
            $q->select('id', 'zn_name', 'en_name', 'product_image');
        }]);

        //结束有
        if (is_null($params['date']['front']) && !is_null($params['date']['after'])) {
            $sql = $sql->where('created_at', '<', $params['date']['after']);

        } //开始有
        else if (!is_null($params['date']['front']) && is_null($params['date']['after'])) {

            $sql = $sql->where('created_at', '>', $params['date']['front']);
        } //都有
        else if (!is_null($params['date']['front']) && !is_null($params['date']['after'])) {

            $params['date']['front'] = $params['date']['front'] . ' 00:00:00';
            $params['date']['after'] = $params['date']['after'] . ' 23:59:59';

            $sql = $sql->whereBetween('created_at', $params['date']);


        }

        //有搜索
        if (isset($params['search'])) {
            $pro_id = ProductModel::select('id', 'zn_name')
                ->where('zn_name', 'like', '%' . $params['search'] . '%')
                ->get()->toArray();

            if (!empty($pro_id)) {
                $data = $sql
                    ->select(DB::raw('sum(count) as count'), 'product_id')
                    ->whereIn('product_id', array_column($pro_id, 'id'))
                    ->groupBy('product_id')
                    ->orderBy('count', 'desc')
                    ->paginate(8);

            } else {
                $data = $sql->select(DB::raw('sum(count) as count'), 'product_id')
                    ->where('product_id', -1)
                    ->orderBy('count', 'desc')
                    ->paginate(8);

            }


        } else {
            //无搜索
            //分类不空
            if ($params['cat']['one'] != 0) {
                if ($params['cat']['two'] == 0) {
                    //一级有 二级没有
                    $cat = array_column(CategoryModel::where('id', '!=', 1)
                        ->where('status', '=', 1)
                        ->where('pid', $params['cat']['one'])
                        ->get()->toArray(), 'id');

                    $cat = array_column(ProductModel::select('id')
                        ->whereIn('category_id', $cat)
                        ->get()->toArray(), 'id');

                } else {
                    //一级有 二级有
                    $cat = array_column(ProductModel::select('id')
                        ->where('category_id', $params['cat']['two'])
                        ->get()->toArray(), 'id');
                }

                $data = $sql
                    ->select(DB::raw('sum(count) as count'), 'product_id')
                    ->whereIn('product_id', $cat)
                    ->groupBy('product_id')
                    ->orderBy('count', 'desc')
                    ->paginate(8);
            } else {
                //分类空
                $cat = [];
                $data = $sql
                    ->select(DB::raw('sum(count) as count'), 'product_id')
                    ->groupBy('product_id')
                    ->orderBy('count', 'desc')
                    ->paginate(8);
            }
        }

//        dump($data->toArray());
        //初始
        $categorys = CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->get();
        $categorys = $this->getTree($categorys->toArray(), 0);

        return view('admin.count.count-product', [
            'category' => $categorys,
            'page' => isset($params['page']) ? $params['page'] : 1,
            'data' => $data,
            'dateFront' => $params['date']['front'],
            'dateaFter' => $params['date']['after']

        ]);


    }

    //单商品销售统计
    public function singleProduct(Request $request)
    {

        $params = $request->all();
//dump($params);
        $sql = BusinessOrderProductModel::with(['products' => function ($q) {
            $q->select('id', 'zn_name', 'en_name', 'product_image');
        }]);

        //结束有
        if (is_null($params['front']) && !is_null($params['after'])) {
            $sql = $sql->where('created_at', '<', $params['after']);

        } //开始有
        else if (!is_null($params['front']) && is_null($params['after'])) {
            $sql = $sql->where('created_at', '>', $params['front']);

        } //都有
        else if (!is_null($params['front']) && !is_null($params['after'])) {

            $params['front'] = $params['front'] . ' 00:00:00';
            $params['after'] = $params['after'] . ' 23:59:59';


            $sql = $sql->whereBetween('created_at', [$params['front'], $params['after']]);

        }
        $newsql = clone $sql;
        //有搜索
        if (isset($params['search'])) {
            $pro_id = ProductModel::select('id', 'zn_name')
                ->where('zn_name', 'like', '%' . $params['search'] . '%')
                ->first();
            if (!empty($pro_id)) {
                $pro_id = $pro_id->id;
                $data = $sql
                    ->select(DB::raw('sum(count) as count'), 'product_id', 'order_id')
                    ->groupBy('product_id')
                    ->orderBy('count', 'desc')
                    ->get();

            } else {
                $pro_id = null;
                $data = $sql->select(DB::raw('sum(count) as count'), 'product_id', 'order_id')
                    ->where('product_id', -1)
                    ->orderBy('count', 'desc')
                    ->get();
            }

        } else {
            $pro_id = null;
            $data = $sql->select(DB::raw('sum(count) as count'), 'product_id', 'order_id')
                ->where('product_id', -1)
                ->orderBy('count', 'desc')
                ->get();
        }
        $data = $data->toArray();
        $info = '';

        foreach ($data as $key => &$item) {
            if ($item['product_id'] == $pro_id) {
                $item['rank'] = !is_null($pro_id) ? $key + 1 : null;
                $info = $item;
            }
        }

        if (!is_null($pro_id)) {

            $arr = $newsql->where('product_id', $pro_id)->get(['order_id', 'count'])->toArray();
            $dataArr = BusinessOrderModel::whereIn('id', array_column($arr, 'order_id'))->get(['snap_address', 'id'])->toArray();
            foreach ($arr as $item) {
                foreach ($dataArr as &$v) {
                    $v['name'] = $v['snap_address']['user'];
                    if ($item['order_id'] == $v['id']) {
                        $v['count'] = $item['count'];
                    }
                }
            }
            $newArr = $this->dataGroup($dataArr, 'name');
        }


        return view('admin.count.count-single-product', [
            'data' => !empty($info) ? $info : null,
            'arr' => !empty($newArr) ? $newArr : null,

        ]);
    }

    protected function dataGroup($dataArr, $keyStr)
    {

        $newArr = [];
        foreach ($dataArr as $k => $val) {
            $newArr[$val[$keyStr]][] = $val;
        }
        foreach ($newArr as &$it) {
            $it['count'] = array_sum(array_column($it, 'count'));
        }
        return $newArr;
    }


    //订单统计
    public function order(Request $request)
    {
        $params = $request->all();

        $sql = BusinessOrderModel::with(['purchase' => function ($q) {
            $q->with(['products' => function ($qq) {
                $qq->select('id', 'zn_name', 'category_id');
            }])->select('order_id', 'product_id', 'count');
        }, 'user']);


        $date = BusinessOrderModel::orderBy('created_at')->get(['created_at'])->toArray();

        //结束有
        if (is_null($params['front']) && !is_null($params['after'])) {
            $sql = $sql->where('created_at', '<', $params['after']);


            $day = ceil((strtotime($params['after']) - strtotime(date("Y-m-d", strtotime(reset($date)['created_at'])))) / 86400);

        } //开始有
        else if (!is_null($params['front']) && is_null($params['after'])) {
            $sql = $sql->where('created_at', '>', $params['front']);

            $day = ceil((strtotime(date("Y-m-d", strtotime(end($date)['created_at']))) - strtotime($params['front'])) / 86400);

        } //都有
        else if (!is_null($params['front']) && !is_null($params['after'])) {

            $params['front'] = $params['front'] . ' 00:00:00';
            $params['after'] = $params['after'] . ' 23:59:59';
            $day = ceil((strtotime($params['after']) - strtotime($params['front'])) / 86400);
            $sql = $sql->whereBetween('created_at', [$params['front'], $params['after']]);


        } else if (is_null($params['front']) && is_null($params['after'])) {
            $day = ceil((strtotime(date("Y-m-d", strtotime(end($date)['created_at']))) - strtotime(date("Y-m-d", strtotime(reset($date)['created_at'])))) / 86400);
        }

        $bin = $sql->select('id', 'snap_address', 'users_id', 'total_price')
            ->get()->groupBy('users_id')->toArray();
        $newArr = [];
        foreach ($bin as $k => $its) {
            $newArr[$k] = [
                'users_id' => $k,
                'count' => count($its),
                'total_price' => array_sum(array_column($its, 'total_price')),
                'user' => $its[0]['user']
            ];
            $mid = [];
            foreach ($its as $rf) {
                $mid = array_merge($mid, $rf['purchase']);
            }
            $newArr[$k]['purchase'] = $mid;
        }
        $bin = $newArr;

        $count = count($bin);

        $categorys = CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->get();
        $categorys = $this->getTree($categorys->toArray(), 0);


        $ar = $name = $cat = $ones = $names = $user = [];

        $total = [];
        foreach ($categorys as $kp) {
            $cat[$kp['zn_name']] = array_column($kp['pid'], 'id');
        }

        foreach ($bin as $k => &$v) {
            if ($v['users_id'] == 0) {
                $v['user']['name'] = '后台添加';
            }
            if (is_null($v['user'])) {
                $v['user']['name'] = '用户已删除';
            }

            $ar[] = [
                'value' => $v['count'],
                'name' => $v['user']['name']
            ];
            $name[] = $v['user']['name'];

            foreach ($v['purchase'] as $it) {

                foreach ($cat as $key => $kp) {
                    if (in_array($it['products']['category_id'], $kp)) {
                        $v['category'][] = ['name' => $key, 'count' => $it['count']];
                    }
                }

            }
            array_multisort(array_column($v['category'], 'count'), SORT_DESC, $v['category']);

            $total = array_merge($total, $v['category']);

            $user[] = [
                'id' => $k,
                'name' => $v['user']['name'],
                'count' => $v['count'],
                'price' => $v['total_price'],
                'avg_price' => round($v['total_price'] / $v['count'], 3),
                'avg_count' => round($v['count'] / $day, 3),
                'cat' => $v['category'][0]['name']
            ];
        }

        $users = UsersModel::where('role', '!=', 1)
            ->whereNotIn('id', array_keys($newArr))
            ->get(['id', 'name'])
            ->toArray();
        foreach ($users as &$rr) {
            $rr['count'] = 0;
            $rr['price'] = 0;
            $rr['avg_price'] = 0;
            $rr['avg_count'] = 0;
            $rr['cat'] = 'N/A';
        }
        $user = array_merge($user, $users);

        $total = $this->Group1($total);

        foreach ($total as $k => &$it) {
            $ones[] = [
                'value' => array_sum(array_column($it, 'count')),
                'name' => $k
            ];
            $names[] = $k;
        }

        return view('admin.count.count-order', [
            'category' => $categorys,
            'data' => json_encode($count > 5 ? array_slice($ar, 0, 5) : $ar),
            'name' => json_encode($count > 5 ? array_slice($name, 0, 5) : $name),
            'ones' => json_encode($ones),
            'names' => json_encode($names),
            'user' => $user,
            'bin' => UsersModel::where('role', '!=', 1)->get(['id', 'name'])->toArray()


        ]);
    }

    //订单列表
    public function orderList(Request $request)
    {

        $params = $request->all();

        $sql = new BusinessOrderModel;

        //结束有
        if (is_null($params['front']) && !is_null($params['after'])) {
            $sql = $sql->where('created_at', '<', $params['after']);

        } //开始有
        else if (!is_null($params['front']) && is_null($params['after'])) {
            $sql = $sql->where('created_at', '>', $params['front']);

        } //都有
        else if (!is_null($params['front']) && !is_null($params['after'])) {

            $params['front'] = $params['front'] . ' 00:00:00';
            $params['after'] = $params['after'] . ' 23:59:59';

            $sql = $sql->whereBetween('created_at', [$params['front'], $params['after']]);

        }

        $list = $sql->where('users_id', $params['id'])->orderBy('created_at', 'desc')->get();

        return view('admin.count.count-order-list', [

            'id' => $params['id'],
            'data' => $list
        ]);
    }

    //某订单详情
    public function orderListDetails(Request $request)
    {

        $params = $request->all();

        $sql = BusinessOrderProductModel::with(['products' => function ($q) {
            $q->select('id', 'zn_name', 'zn_name', 'sku', 'product_image');
        }]);

        //结束有
        if (is_null($params['front']) && !is_null($params['after'])) {
            $sql = $sql->where('created_at', '<', $params['after']);

        } //开始有
        else if (!is_null($params['front']) && is_null($params['after'])) {
            $sql = $sql->where('created_at', '>', $params['front']);

        } //都有
        else if (!is_null($params['front']) && !is_null($params['after'])) {

            $params['front'] = $params['front'] . ' 00:00:00';
            $params['after'] = $params['after'] . ' 23:59:59';

            $sql = $sql->whereBetween('created_at', [$params['front'], $params['after']]);

        }

        $list = $sql->where('order_id', $params['id'])->get();

        return view('admin.count.count-order-details', [

            'id' => $params['id'],
            'data' => $list
        ]);
    }

    protected function Group1($dataArr)
    {
        $newArr = [];
        foreach ($dataArr as $k => $val) {
            $newArr[$val['name']][] = $val;
        }

        return $newArr;
    }


    //财务统计
    public function finance(Request $request)
    {
        $params = $request->all();

        $sql = BusinessOrderModel::with(['purchase' => function ($q) {
            $q->with(['products' => function ($qq) {
                $qq->select('id', 'zn_name', 'price');
            }])->select('order_id', 'product_id', 'count');
        }]);

        //结束有
        if (is_null($params['front']) && !is_null($params['after'])) {
            $sql = $sql->where('created_at', '<', $params['after']);

        } //开始有
        else if (!is_null($params['front']) && is_null($params['after'])) {
            $sql = $sql->where('created_at', '>', $params['front']);

        } //都有
        else if (!is_null($params['front']) && !is_null($params['after'])) {

            $params['front'] = $params['front'] . ' 00:00:00';
            $params['after'] = $params['after'] . ' 23:59:59';

            $sql = $sql->whereBetween('created_at', [$params['front'], $params['after']]);
        }

        $data = $sql->select('id', 'total_price', 'created_at')
            ->get()
            ->toArray();

        $info = [
            'total_price' => 0,
            'total_cost' => 0,
            'total_discount' => 0
        ];

        foreach ($data as $item) {
            $info['total_price'] += $item['total_price'];
            foreach ($item['purchase'] as $ii) {
                $info['total_cost'] += $ii['count'] * $ii['products']['price'];
            }
        }
        $info['profit'] = $info['total_price'] - $info['total_cost'];

//        dump($info);
        $date = date('Y');
        $business = BusinessOrderModel::with(['purchase' => function ($q) {
            $q->with(['products' => function ($qq) {
                $qq->select('id', 'zn_name', 'price');
            }])->select('order_id', 'product_id', 'count');
        }])->select(DB::raw('DATE_FORMAT(created_at,"%Y-%m") as time,
        DATE_FORMAT(created_at,"%m") as sort'),
            'id', 'total_price', 'created_at')
            ->whereRaw('year(created_at) =' . $date)
            ->get()
            ->groupBy('time')
            ->toArray();

        //销售
        $datass = [];
        $cost = [];
        $nu = 0;

        foreach ($business as $k => $val) {
            $datass[] = [
                'time' => $k,
                'count' => round(array_sum(array_column($val, 'total_price')), 2),
                'sort' => $val[0]['sort']
            ];
            $num = 0;

            foreach ($val as $iiss) {
                foreach ($iiss['purchase'] as $iis) {
                    $num += $iis['count'] * $iis['products']['price'];
                }
            }

            $cost[] = [
                'time' => $k,
                'cost' => round($datass[$nu]['count'] - round($num, 2), 2),
                'sort' => $val[0]['sort']
            ];
            $nu++;
        }

        $date = [$date . '-01', $date . '-02', $date . '-03', $date . '-04', $date . '-05', $date . '-06',
            $date . '-07', $date . '-08', $date . '-09', $date . '-10', $date . '-11', $date . '-12'];
        $arr = array_column($datass, 'time');
        $arr1 = array_column($cost, 'time');
        $datas1 = $datas = [];

        foreach ($date as &$item) {
            if (!in_array($item, $arr)) {
                array_push($datas, [
                    'time' => $item,
                    'count' => 0,
                    'sort' => explode('-', $item)[1]
                ]);
            }
            if (!in_array($item, $arr1)) {
                array_push($datas1, [
                    'time' => $item,
                    'cost' => 0,
                    'sort' => explode('-', $item)[1]
                ]);
            }
        }

        $datas = array_merge($datass, $datas);
        $datas1 = array_merge($cost, $datas1);
        array_multisort(array_column($datas, 'sort'), SORT_ASC, $datas);
        array_multisort(array_column($datas1, 'sort'), SORT_ASC, $datas1);

        //初始
        $categorys = CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->get();
        $categorys = $this->getTree($categorys->toArray(), 0);
        return view('admin.count.count-price', [
            'category' => $categorys,
            'info' => $info,
            'count' => json_encode(array_column($datas, 'count')),
            'cost' => json_encode(array_column($datas1, 'cost'))
        ]);
    }

    ///获取二级下商品列表
    public function twoList($id)
    {

        $res = ProductModel::where('category_id', $id)
            ->where('status', 1)
            ->get(['id', 'zn_name']);

        return Common::successData($res);
    }

    //用户统计
    public function user()
    {

        $binUser = round((UsersModel::where('role', '!=', 1)
                    ->count() / UsersModel::count()) * 100, 2);

        $state = UsersModel::with('manys')->where('role', '!=', 1)
            ->get();

        $state = $state->pluck('manys')->collapse()->groupBy('province');

        $states = [];
        foreach ($state as $k => &$tt) {
            array_push($states, [
                'value' => count($tt),
                'name' => $k
            ]);
        }

        $date = date('Y');
        $line = UsersModel::select(DB::raw('DATE_FORMAT(created_at,"%Y-%m") as time,DATE_FORMAT(created_at,"%m") as sort, count(*) as count'))
            ->where('role', '!=', 1)
            ->whereRaw('year(created_at) =' . date('Y'))
            ->groupBy('time')
            ->get()
            ->toArray();
        $date = [$date . '-01', $date . '-02', $date . '-03', $date . '-04', $date . '-05', $date . '-06',
            $date . '-07', $date . '-08', $date . '-09', $date . '-10', $date . '-11', $date . '-12'];
        $arr = array_column($line, 'time');

        $datas = [];

        foreach ($date as &$item) {
            if (!in_array($item, $arr)) {
                array_push($datas, [
                    'time' => $item,
                    'count' => 0,
                    'sort' => explode('-', $item)[1]
                ]);
            }
        }

        $datas = array_merge($line, $datas);

        array_multisort(array_column($datas, 'sort'), SORT_ASC, $datas);

        return view('admin.count.count-user', [
            'percent' => $binUser,
            'ones' => json_encode($states),
            'names' => json_encode(array_column($states, 'name')),
            'count' => json_encode(array_column($datas, 'count'))
        ]);
    }

    //销售利润比
    public function proInfo($id)
    {

        $sql = BusinessOrderProductModel::with(['products' => function ($q) {
            $q->select('id', 'zn_name', 'en_name', 'product_image', 'price');
        }])->select(DB::raw('DATE_FORMAT(created_at,"%Y-%m") as time,
        DATE_FORMAT(created_at,"%m") as sort,
        sum(total_price) as total_price,
         sum(count) as count'),
            'product_id')
            ->where('product_id', $id)
            ->whereRaw('year(created_at) =' . date('Y'))
            ->groupBy('time')
            ->get()
            ->toArray();

        if (empty($sql)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '查询不到'
            ]);
        }
        foreach ($sql as &$item) {
            $item['cost'] = round($item['total_price'] - $item['count'] * $item['products']['price'], 2);
        }

        $date = date('Y');
        $date = [$date . '-01', $date . '-02', $date . '-03', $date . '-04', $date . '-05', $date . '-06',
            $date . '-07', $date . '-08', $date . '-09', $date . '-10', $date . '-11', $date . '-12'];
        $arr = array_column($sql, 'time');
        $datas = [];
        foreach ($date as &$item) {
            if (!in_array($item, $arr)) {
                array_push($datas, [
                    'time' => $item,
                    'cost' => 0,
                    'sort' => explode('-', $item)[1]
                ]);
            }

        }

        $datas = array_merge($sql, $datas);

        array_multisort(array_column($datas, 'sort'), SORT_ASC, $datas);

        return Common::successData(
            ['name' => $sql[0]['products']['zn_name'],
                'value' => json_encode(array_column($datas, 'cost'))
            ]);

    }

    //商品统计对比
    public function proTotal($bin, $cat)
    {

        if (empty($bin) || empty($cat)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '商家没有或者二级分类没有选择'
            ]);
        }

        $data = BusinessOrderModel::with(['purchase' => function ($q) use ($cat) {
            $q->with(['products' => function ($qq) use ($cat) {
                $qq->select('id', 'zn_name', 'price', 'category_id')
                    ->where('category_id', $cat);
            }])->select('order_id', 'product_id', 'count');
        }])->select(DB::raw('DATE_FORMAT(created_at,"%Y-%m") as time,
        DATE_FORMAT(created_at,"%m") as sort'), 'id', 'users_id')
            ->where('users_id', $bin)
            ->get();
//        dump($data->toArray());
        $arr = $arrs = [];
        $data = $data->groupBy('time');

        foreach ($data as $key => $item) {
            $arr[$key][] = $item->pluck('purchase')->collapse()->toArray();
        }

        foreach ($arr as $key => $item) {
            $coun = 0;
            foreach ($item[0] as $kk => $vv) {
//                dd($vv);
                if (!is_null($vv['products'])) {
                    $coun += $vv['count'];
                }
            }
            $arrs[] = [
                'time' => $key,
                'cost' => $coun,
                'sort' => substr($key, -2)
            ];
        }

        $date = date('Y');
        $date = [$date . '-01', $date . '-02', $date . '-03', $date . '-04', $date . '-05', $date . '-06',
            $date . '-07', $date . '-08', $date . '-09', $date . '-10', $date . '-11', $date . '-12'];
        $arr = array_column($arrs, 'time');
        $datas = [];
        foreach ($date as &$item) {
            if (!in_array($item, $arr)) {
                array_push($datas, [
                    'time' => $item,
                    'cost' => 0,
                    'sort' => explode('-', $item)[1]
                ]);
            }

        }

        $datas = array_merge($arrs, $datas);

        array_multisort(array_column($datas, 'sort'), SORT_ASC, $datas);

        return Common::successData(
            [
                'value' => json_encode(array_column($datas, 'cost'))
            ]);

    }

    //递归
    public function getTree($data, $pId, $level = 0, $html = '---')
    {

        $tree = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pId) {
                $v['level'] = $level;
                $v['html'] = str_repeat($html, $level);
                $v['pid'] = $this->getTree($data, $v['id'], $level + 1);
                $tree[] = $v;
                unset($data[$k]);

            }
        }
        return $tree;
    }
}

