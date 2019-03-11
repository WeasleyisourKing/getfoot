<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\CategoryModel;
use App\Http\Model\ProductModel;
use App\Http\Model\ThemeModel;
use App\Http\Model\MessageModel;
use App\Http\Model\GeneralModel;
use App\Rules\IdRule;
use App\Exceptions\ParamsException;
use App\Rules\CodeInfoRule;
use App\Http\Model\UsersDiscountModel;
use App\Http\Controllers\Common;

/**
 * 商品接口类
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class ShopController extends Controller
{

    /**
     * 分类列表接口
     * @param Request $request
     * @return null
     */
    public function categoryList()
    {

        //获取商品分类列表
        $categorys = CategoryModel::select('id', 'zn_name', 'en_name', 'pid')
            ->where('id', '!=', 1)
            ->where('status', '=', 1)
            ->get();

        $categorys = $this->getTree($categorys->toArray(), 0);


        return Common::successData($categorys, true);

    }

    //递归
    public function getTree($data, $pId, $level = 0)
    {

        $tree = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pId) {
                $v['level'] = $level;
                $v['pid'] = $this->getTree($data, $v['id'], $level + 1);
                $tree[] = $v;
                unset($data[$k]);

            }
        }
        return $tree;
    }

    /**
     * 获取某分类商品列表接口
     * @param Request $request
     * @return null
     */
    public function categoryProductList(Request $request)
    {

        (new IdRule)->goCheck();

        $id = $request->input('id');

        //获取商品分类列表
        $res = ProductModel::getCategoryProductList($id);

        if (!$res) {
            throw new ParamsException([
                'message' => '分类下没商品或者分类id不正确',
                'errorCode' => 7001
            ]);
        }

        return Common::successData($res, true);

    }

    /**
     * 获取商品列表接口
     * @param Request $request
     * @return null
     */
    public function shopList(Request $request)
    {

        (new IdRule)->goCheck();

        $id = $request->input('id');

        //获取商品
        $res = ProductModel::getShopById($id);

        if (!$res) {
            throw new ParamsException([
                'message' => '商品已经下架或者不存在',
                'errorCode' => 7001
            ]);
        }

        return Common::successData($res, true);

    }

    /**
     * 获取首页列表接口
     * @param Request $request
     * @return null
     */
    public function homePage()
    {

        //获取商品分类列表
        $categorys = CategoryModel::select('id', 'zn_name', 'en_name', 'pid')
            ->where('pid', '!=', 0)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        //获取商品
        $res = ThemeModel::getHomePageList();

        return Common::successData(['categorys' => $categorys, 'items' => $res]);

    }


    /**
     * 获取某商品评论接口
     * @param Request $request
     * @return null
     */
    public function shopMessage(Request $request)
    {

        (new IdRule)->goCheck();

        $id = $request->input('id');

        $data = MessageModel::with(['messageImg' => function ($query) {
            $query->select('id', 'zn_name');
        }, 'users' => function ($query) {
            $query->select('id', 'name', 'avatar');
        }, 'reply' => function ($query) {
            $query->select('reply_id', 'content', 'name', 'message_name', 'created_at')->get();
        }])
            ->where('product_id', '=', $id)
            ->get(['user_id', 'name', 'content', 'message_name', 'created_at', 'score', 'id', 'product_id']);
//        dd($data->toArray());
        return Common::successData($data);


    }

    //获取login图标接口
    public function login()
    {

        $logo = GeneralModel::select('logo', 'title', 'keywords', 'description')->first();

        return Common::successData($logo);

    }


    //查看折扣码接口
    public function discountUse(Request $request)
    {

        (new CodeInfoRule)->goCheck(200);

        $code = $request->input('code');

        $res = UsersDiscountModel::with(['discount' => function ($query) {
            $query->where('status', '=', 1);
        }])->where('code', '=', $code)->first();

        if (!$res || !$res->discount) {
            throw new ParamsException([
                'code' => 200,
                'message' => '折扣码不正确或者折扣码被禁用',
                'errorCode' => 7001
            ]);
        }

        return Common::successData(['name' => $res->discount->zn_name, 'rcent' => $res->discount->rcent, 'type' => $res->discount->type]);

    }

    /**
     * 搜索商品接口
     * @param int $id 用户id
     * @return mixed
     */
    public function productSearch(Request $request)
    {
        $search = htmlspecialchars(strip_tags(trim($request->input('search'))));


        $data = ProductModel::with(['distributor', 'category', 'brand', 'shelve' => function ($q) {
            $q->select('shelves_id', 'product_id')->with('name');
        }])
            ->where('zn_name', 'like', '%' . $search . '%')
//            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return Common::successData($data);

    }

    //税金接口
    public function tax($zip, $city)
    {

        if (empty(htmlspecialchars(strip_tags(trim($zip))))) {

            throw new ParamsException([
                'code' => 200,
                'message' => '邮编格式不对'
            ]);
        }
        $city = str_replace(' ', '', $city);
        if (empty(htmlspecialchars(strip_tags(trim($city))))) {

            throw new ParamsException([
                'code' => 200,
                'message' => '城市格式不对'
            ]);
        }

        $url = sprintf(config('custom.tax_url'),
            config('custom.tax_key'),
            $zip, $city
        );

        $res = Common::curlInfo($url);

        if ($res['rCode'] == 100) {

            return Common::successData(['tax' => $res['results'][0]['taxSales']]);

        } else if ($res['rCode'] == 104) {

            throw new ParamsException([
                'code' => 200,
                'message' => '邮政编码格式无效'
            ]);
        } else {
            throw new ParamsException([
                'code' => 200,
                'message' => '接口未知错误'
            ]);
        }

    }

}

