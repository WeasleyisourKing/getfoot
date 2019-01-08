<?php

namespace App\Http\Controllers\Web;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\CategoryModel;
use App\Http\Model\ProductModel;
use App\Http\Model\ThemeModel;
use App\Http\Model\BannerModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Model\GeneralModel;
use App\Http\Model\ThemeImageModel;
use App\Http\Model\ArticleModel;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use Illuminate\Support\Facades\DB;

/**
 * 前台登录验证类
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class ProductController extends Controller
{

    /**
     * 首页
     * @param Request $request
     * @return null
     */
    public function homePage ()
    {

        //获取商品分类数据
//        $categorys = array_slice(Common::getTree(CategoryModel::getHomePage()->toArray(), 0),0,5);
//        dd(CategoryModel::getHomePage()->toArray());
        $categorys = Common::getTree(CategoryModel::getHomePage()->toArray(), 0);
        //获取热销和秒杀
//        $res = ThemeModel::getPcHomePage()->toArray();
        $res = ThemeModel::with(['products' => function ($query) {

            $query->select(
                DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
                'id', 'product_image', 'stock')
                ->where('status', '=', 1)
                ->with('distributor');
        }])
            ->whereIn('id', [8, 7])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        //获取轮播图
        $banner = BannerModel::getbannerById(4);
        //获取热销
        $hotImg = ThemeImageModel::where('type',2)->get()->toArray();

//  dump($banner->toArray());
//        dump($hotImg);
//        dump($categorys);
//        dd($banner->toArray());
//        dump($categorys);
//        dd($res);
//        CONCAT('【无库存】',zn_name)

//        dd(Auth()->guard('pc')->user());

        return view('web.index', ['categorys' => $categorys,
            'modular' => $res,
            'banner' => $banner->items,
            'hotImg' => $hotImg
        ]);

    }

    /**
     * 购物车页面
     * @param Request $request
     * @return null
     */
    public function shoppingCart ($id = -1)
    {

        if (($id == -1) || (Auth()->guard('pc')->user()->id != $id)) {
            return redirect('/');
        }

        $res = GeneralModel::select('threshold', 'freight')->where('id', '=', 1)
            ->first();

        return view('web.shoppingcart', ['postage' => $res]);
    }

    /**
     * 显示分类页面
     * @param int $id 商品id
     * @return mixed
     */
    public function showCategory ()
    {

        //获取二级分类及下面商品
        $categorys = Common::getTree(CategoryModel::getTwoCategory(), 0);


        //热门推荐
        $hot = ThemeModel::with(['products' => function ($query) {
            $query->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
                'id', 'product_image', 'stock')
                ->with('distributor')
                ->select('id', 'en_name', 'zn_name', 'product_image')
                ->limit(5);
        }])->where('id', '=', 4)->first();


        return view('web.category', ['category' => $categorys, 'hot' => $hot]);
    }


    /**
     * 商品聚合页页面
     * @param int $id 分类id
     * @return mixed
     */
    public function CategoryShop ($id)
    {

        //获取所有一级分类下二级分类
        $categorys = Common::getTree(CategoryModel::where('id', '!=', 1)->orderBy('created_at', 'desc')->where('status', '=', 1)->get()->toArray(), 0);

        //不能等于1
        if ($id == 1) {
            return view('web.product', ['category' => $categorys, 'product' => []]);
        }

        $category = CategoryModel::getCategoryId($id);

        if ($category->pid != 0) {
            //二级分类
            $data = CategoryModel::getTwoLevel($id);
        } else {

            $category = CategoryModel::where('pid', '=', $category->id)->first();

            //一级分类下没有
            if (!$category) {
                return view('web.product', ['category' => $categorys, 'product' => []]);
            }
            //一级分类 显示时间最近的二级分类
            $data = CategoryModel::getTwoLevel($category->id);
        }

//        dd($categorys);
        //精品推荐

        $fine = CategoryModel::with(['hot' => function ($query) {

            $query->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
                'id', 'product_image', 'stock', 'brand_id')
                ->with(['distributor', 'brand'])
                ->limit(5);
        }])->where('id', '=', $id)
            ->where('status', '=', 1)
            ->first();

//        dump($fine->toArray());
//        dd($categorys[0]['product'][0]['price']);
        return view('web.product', ['category' => $categorys, 'product' => $data, 'fine' => $fine]);
    }


    /**
     * 商品详情页面
     * @param int $id 商品id
     * @return mixed
     */
    public function details ($id)
    {


        //获取所有一级分类下二级分类
        $categorys = Common::getTree(CategoryModel::where('id', '!=', 1)->orderBy('created_at', 'desc')->where('status', '=', 1)->get()->toArray(), 0);
        //获取某商品详细信息
        $product = ProductModel::getShopById($id);


        //相关产品 随机
        $arr = ProductModel::where('category_id', '=', $product->category->id)
            ->where('status', '=', 1)
            ->where('id', '!=', $product->id)
            ->get(['id'])->toArray();

        $count = count($arr);

        if ($count > 3) {
            shuffle($arr);
            $arr = array_slice($arr,0,3);
        }

        $theme = ProductModel::select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
            'id', 'product_image', 'stock')
            ->with('distributor')
            ->whereIn('id', $arr)
            ->get();
//        dump($theme->toArray());
//        $theme = ThemeModel::with(['products' => function ($query) {
//            $query->with('distributor')
//                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
//                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
//                    'id', 'product_image', 'stock')
//                ->limit(3);
//        }])->where('i
        //buy推荐d', '=', 6)->first();

        $hot = ThemeModel::with(['products' => function ($query) {
            $query->with(['distributor', 'brand'])
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
                    'id', 'product_image', 'stock', 'brand_id')
                ->limit(4);
        }])->where('id', '=', 5)
            ->first();

        $relevant = ThemeModel::where('id', '=', 6)->first(['zn_name', 'en_name']);
//        dump($relevant->toArray());
//        dump($hot->toArray());
//        dump($theme->toArray());
//        dump($product->toArray());
        return view('web.details', ['category' => $categorys, 'product' => $product, 'relevant' => $relevant, 'theme' => $theme, 'hot' => $hot]);
    }

    /**
     * PC订单确定页面
     * @param Request $request
     * @return null
     */
    public function orderConfirm ($id = -1)
    {

        //是否非法进入
        if (($id == -1) || (Auth()->guard('pc')->user()->id != $id)) {
            return redirect('/');
        }

        $res = UsersAddressModel::where('users_id', '=', $id)
            ->where('default', '=', 1)
            ->first();

        !empty($res) ? '' : $res = '';

//        dd($res);
        return view('web.orderaffirm', ['data' => $res]);


    }

    public function payPaypal ()
    {

        return view('web.settlement');
    }

    /**
     *  PC搜索结果页面
     * @param int $id 用户id
     * @return mixed
     */
    public function productList (Request $request)
    {
        $search = htmlspecialchars(strip_tags(trim($request->input('search'))));

        if (!preg_match('/^[\x7f-\xff]+$/', $search)) {
            // 1 英文
            $data = ProductModel::with(['distributor', 'category'])
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                    'id','en_name','product_image','stock','category_id','status')
                ->where('en_name', 'like', '%' . $search . '%')
                ->where('status', '=', 1)
                ->orderBy('stock', 'desc')
                ->get();
        } else {
            // 0 中文
            $data = ProductModel::with(['distributor', 'category'])
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                    'id','en_name','product_image','stock','category_id','status')
                ->where('zn_name', 'like', '%' . $search . '%')
                ->where('status', '=', 1)
                ->orderBy('stock', 'desc')
                ->get();
        }
//        dd($data->toArray());

        return view('web.together', ['product' => $data]);

//        dd($data->toArray());
    }

    public function companyinformation ($id)
    {

        $res = ArticleModel::where('id', '=', $id)->first();

//        dump($res->toArray());
//        dump($res->toArray()['zn_name']);
//        dd($res);
        if (is_null($res)) {
            return view('web.companyinformation', ['res' => ['zn_content' => '<p>查询不到数据</p>', 'en_content' => '<p>Unable to query data</p>']]);
        }
//        dump($res->toArray());
        return view('web.companyinformation', ['res' => $res->toArray()]);
    }

    // PC二级各类聚合页面
    public function twoLevel ($id)
    {
        //获取所有一级分类下二级分类

        $categorys = Common::getTree(CategoryModel::getTwoCategory(), 0);

        //不能等于1
        if ($id == 1) {
            return view('web.twoLevelCategory', ['category' => $categorys, 'product' => []]);
        }

        $category = CategoryModel::getCategoryId($id);

        $data = CategoryModel::with(['product' => function ($query) {

            $query->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
                'id', 'product_image', 'stock', 'category_id', 'brand_id')
                ->where('status', '=', 1)
                ->orderBy('stock', 'desc')
                ->with(['brand', 'distributor']);
        }])
            ->where('pid', '=', $category->id)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();

//        if ($category->pid != 0) {
//            //二级分类
//        $data = CategoryModel::getTwoLevel($id);
//        } else {
//
//            $category = CategoryModel::where('pid', '=', $category->id)->first();
//
//            //一级分类下没有
//            if (!$category) {
//                return view('web.product', ['category' => $categorys, 'product' => []]);
//            }
//            //一级分类 显示时间最近的二级分类
//            $data = CategoryModel::getTwoLevel($category->id);
//        }
        return view('web.twoLevelCategory', ['category' => $categorys, 'product' => $data]);

    }
}

