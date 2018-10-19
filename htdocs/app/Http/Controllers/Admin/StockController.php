<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\ProductModel;
use App\Http\Controllers\Common;
use App\Rules\StockRule;
use App\Rules\ShelveRule;
use App\Exceptions\ParamsException;

/**
 * 库存管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class StockController extends Controller
{
    /**
     * 入库页面
     * @param Request $request
     * @return null
     */
    public function addLibrary ($limit)
    {

        $res = ProductModel::getStockProduct($limit);

        return view('admin.stock.stock-add', [
            'data' => $res,
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 出库页面
     * @param Request $request
     * @return null
     */
    public function stockOut ($limit)
    {

        $res = ProductModel::getStockProduct($limit);

        return view('admin.stock.stock-out', [
            'data' => $res,
            'limit' => '显示' . $limit . '条'
        ]);

    }

    /**
     * 货架管理页面
     * @param Request $request
     * @return null
     */
    public function stockShelves ($limit)
    {

        $res = ProductModel::getStockProduct($limit);

        return view('admin.stock.stock-shelves', [
            'data' => $res,
            'limit' => '显示' . $limit . '条'
        ]);
    }


    /**
     * 修改商品添加库存信息接口
     * @param Request $request
     * @return null
     */
    public function productStock (Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->input('data');

//        $shelve = $request->input('shelve');

        //修改信息
        ProductModel::updateStock($data);

        return Common::successData();
    }

    /**
     * 修改商品减少库存信息接口
     * @param Request $request
     * @return null
     */
    public function productStockSub (Request $request)
    {

        (new StockRule)->goCheck(200);

        $data = $request->input('data');

        //修改信息
        ProductModel::updateStockSub($data);

        return Common::successData();
    }

    /**
     * 修改商品货架接口
     * @param Request $request
     * @return null
     */
    public function editShelves (Request $request)
    {

        (new ShelveRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['shelves'])));
        //验证唯一性
        if (ProductModel::uniqueShelves($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '商品货架名已经存在'
            ]);
        }
        //拼接数据
        $data = [
            'shelves' => $name
        ];

        $res = ProductModel::updateShelves($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }


        return Common::successData();
    }
    /**
     * 搜索商品库存接口
     * @param Request $request
     * @return null
     */
    public function searchStock (Request $request)
    {

        $data = htmlspecialchars(strip_tags(trim($request->input('value'))));

        if (empty($data)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索内容不能为空'
            ]);
        }
            //名称
            if (preg_match('/^[\x7f-\xff]+$/', $data)) {

                $res = ProductModel::searchName($data);
            } else {

                //sku
                $res = ProductModel::searchSKU($data);
            }


        return Common::successData($res);

        }


}

