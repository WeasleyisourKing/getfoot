<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\CategoryModel;
use App\Http\Model\BusinessOrderProductModel;
use App\Http\Model\BusinessOrderModel;
use App\Http\Model\ProductModel;
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

            if ($params['date']['front'] == $params['date']['after']) {
                $params['date']['front'] = $params['date']['front'] . ' 00:00:00';
                $params['date']['after'] = $params['date']['after'] . ' 23:59:59';
            }
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

            if ($params['front'] == $params['after']) {
                $params['front'] = $params['front'] . ' 00:00:00';
                $params['after'] = $params['after'] . ' 23:59:59';
            }

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

        $sql = new BusinessOrderModel;

        $other = BusinessOrderProductModel::with(['products' => function ($q) {
            $q->select('id', 'zn_name', 'category_id');
        }]);

        //结束有
        if (is_null($params['front']) && !is_null($params['after'])) {
            $sql = $sql->where('created_at', '<', $params['after']);
            $other = $sql->where('created_at', '<', $params['after']);

        } //开始有
        else if (!is_null($params['front']) && is_null($params['after'])) {
            $sql = $sql->where('created_at', '>', $params['front']);
            $other = $sql->where('created_at', '>', $params['front']);

        } //都有
        else if (!is_null($params['front']) && !is_null($params['after'])) {

            if ($params['front'] == $params['after']) {
                $params['front'] = $params['front'] . ' 00:00:00';
                $params['after'] = $params['after'] . ' 23:59:59';
            }

            $sql = $sql->whereBetween('created_at', [$params['front'], $params['after']]);
            $other = $sql->whereBetween('created_at', [$params['front'], $params['after']]);

        }

        $dataArr = $this->dataGroup1($sql->get(['id', 'snap_address', 'total_count'])->toArray());

        array_multisort(array_column($dataArr, 'count'), SORT_DESC, $dataArr);
        $dataArr = array_slice($dataArr, 0, 5);
        $ar = $name = [];
        foreach ($dataArr as $k => $v) {
            $ar[] = [
                'value' => $v['count'],
                'name' => $k
            ];
            $name[] = $k;
        }

        $categorys = CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->get();
        $categorys = $this->getTree($categorys->toArray(), 0);
        $one = $other->get()->toArray();

        foreach ($one as $v) {
            foreach ($categorys as &$k) {

                $coll = array_column($k['pid'], 'id');
                if (in_array($v['products']['category_id'], $coll)) {
                    $k['son'][] = $v['order_id'];
                    $k['level'] += $v['count'];
                }
            }
        }
//        dump($categorys);
        array_multisort(array_column($categorys, 'level'), SORT_DESC, $categorys);

        $ones = $names = [];
        foreach ($categorys as $vv) {
            $ones[] = [
                'value' => $vv['level'],
                'name' => $vv['zn_name']
            ];
            $names[] = $vv['zn_name'];
        }

        return view('admin.count.count-order', [
            'data' => json_encode($ar),
            'name' => json_encode($name),
            'ones' => json_encode($ones),
            'names' => json_encode($names)
        ]);
    }

    protected function dataGroup1($dataArr)
    {
        $newArr = [];
        foreach ($dataArr as $k => $val) {
            $newArr[$val['snap_address']['user']][] = $val;
        }

        foreach ($newArr as &$it) {
            $it['count'] = array_sum(array_column($it, 'total_count'));
        }
        return $newArr;
    }

    //财务统计
    public function finance()
    {

        return view('admin.count.count-product');
    }

    //用户统计
    public function user()
    {

        return view('admin.count.count-product');
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

