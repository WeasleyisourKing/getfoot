<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\CategoryModel;
use App\Http\Model\ProductModel;
use App\Http\Model\ThemeModel;
use App\Http\Model\BannerModel;
use App\Http\Model\GeneralModel;
use App\Http\Model\MessageModel;
use App\Http\Model\BrandModel;
use App\Http\Controllers\Common;
use App\Http\Model\OrderModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


/**
 * 前台登录验证类
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class ProductController extends Controller
{

//    public function __call ($name, $arguments)
//    {
//        dump($arguments);
//        foreach ($arguments[0] as $items) {
//            if ($items instanceof \Illuminate\Support\Collection) {
////                dump($items->toArray());
////                dd($items);
//            } else if (is_array($items)) {
//
//                foreach ($items as $key) {
//dump($key);
//                    if (is_array($key)) {
//
//                        if (in_array('zn_name', $key)) {
//                            dd(234);
//                            $key['zn_name'] = $key['en_name'];
//                        }
//                    }
//                }
//                if (in_array('zn_name', $items)) {
//
//                    $items['zn_name'] = $items['en_name'];
//                }
//            }
////            if (!is_array($items)) {
////                dd($items);
////                $items = $items->toArray();
////            }
////            $collection->get('name');
//        }
//        dump(234);
//        dd($arguments);
//
//    }

    /**
     * App首页页面
     * @param Request $request
     * @return null
     */
    public function homePage ($order = '')
    {

        !empty($order) ? $this->NotifyProcess($order) : '';

        //获取商品分类数据
        $categorys = Common::getTree(CategoryModel::getHomePage()->toArray(), 0);

        //获取轮播图
        $banner = BannerModel::getbannerById(1);

        //获取logo
        $logo = GeneralModel::select('logo')->first();
        //dd($logo['logo']);

//        dd($banner->items->toArray());
        //获取热销和秒杀
        $res = ThemeModel::getPcHomePage()->toArray();

//        dd($res);
//        dd($res);
//        $this->lang(['categorys' => $categorys, 'modular' => $res, 'banner' => $banner->items, 'logo' => $logo['logo']]);
//        dump($categorys);
//        dd($res);
        return view('app.welcome', ['categorys' => $categorys, 'modular' => $res, 'banner' => $banner->items, 'logo' => $logo['logo']]);

    }

    /**
     * 购物车页面
     * @param Request $request
     * @return null
     */
    public function shoppingCart ($id = -1)
    {

//        return view('app.cart');

        if (($id == -1) || (Auth()->guard('pc')->user()->id != $id)) {
            return redirect('/apps');
        }
        $res = GeneralModel::select('threshold', 'freight')->where('id', '=', 1)
            ->first();


        return view('app.cart', ['postage' => $res]);
    }

    /**
     * 显示分类页面
     * @param int $id 商品id
     * @return mixed
     */
    public function showCategory ()
    {

        //获取二级分类及下面商品
        $categorys = Common::getTree((CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->orderBy('created_at', 'desc')->get()->toArray()), 0);

//        dd($categorys);

        return view('app.category', ['category' => $categorys]);
    }


    /**
     * 商品聚合页页面
     * @param int $id 分类id
     * @return mixed
     */
    public function CategoryShop ($id)
    {

        //不能等于1
        if ($id == 1) {
            return view('app.categoryList', ['product' => []]);
        }

        $category = CategoryModel::getCategoryId($id);

//        dd($category->toArray());
        if ($category->pid != 0) {
            //二级分类
            $data = CategoryModel::getTwoLevel($id);
        } else {

            $category = CategoryModel::where('pid', '=', $category->id)->first();

            //一级分类下没有
            if (!$category) {
                return view('app.categoryList', ['product' => []]);
            }
            //一级分类 显示时间最近的二级分类
            $data = CategoryModel::getTwoLevel($category->id);
        }

        return view('app.categoryList', ['product' => $data[0]->product, 'category' => $category]);
    }


    /**
     * App品牌聚合页面
     * @param int $id 分类id
     * @return mixed
     */
    public function brandShop ($id)
    {

        //不能等于1
        if ($id == 1) {
            return view('app.categoryList', ['product' => []]);
        }

        $brand = BrandModel::with(['product' => function ($query) {
            $query->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                'id','en_name','product_image','stock','category_id', 'brand_id')
                ->where('status', '=', 1)
                ->with('distributor');
        }])
            ->where('id', '=', $id)
            ->where('status', '=', 1)
            ->first();

        return view('app.brandList', ['product' => $brand->product, 'brand' => ['zn_name' => $brand->zn_name,'en_name' => $brand->en_name]]);
    }

    /**
     * App活动聚合页面
     * @param int $id 分类id
     * @return mixed
     */
    public function ActivieShop ($id)
    {

        $data = ThemeModel::with(['products' => function ($query) {
            $query->with('distributor')
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                    'id','en_name','product_image','stock')
                ->where('status', '=', 1);
        }])->where('id', '=', $id)
            ->first();


//        dd($data->toArray());

        return view('app.activie', ['product' => $data]);
    }

    /**
     * 商品详情页面
     * @param int $id 商品id
     * @return mixed
     */
    public function details ($id)
    {

        //获取某商品详细信息
        $product = ProductModel::getShopById($id);

//         dd($product->toArray());

        //dd(count($product['message']));
        return view('app.detail', ['product' => $product]);
    }


    /**
     * 用户页面
     * @param int $id 用户id
     * @return mixed
     */
    public function user ($id)
    {
        $xx = 1;
        $data = MessageModel::where('user_id', '=', $id)->where('see', '=', 2)->first();
        if ($data == null) {
            $xx = 0;
        }
        return view('app.profile', ['data' => $xx]);
    }

    /**
     * 退出登录页面
     * @param int $id 用户id
     * @return mixed
     */
    public function quit ()
    {

        Auth()->guard("pc")->logout();

        return redirect('/apps');

    }


    /**
     * 搜索页面
     * @param int $id 用户id
     * @return mixed
     */
    public function productList (Request $request)
    {

        $search = htmlspecialchars(strip_tags(trim($request->input('search'))));


        if (empty($search)) {
            return view('app.productList', ['product' => '']);
        }

        if (preg_match('/^[0-9a-zA_Z]+$/', $search)) {
            // 1 英文
            $data = ProductModel::with(['distributor', 'category'])
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                    'id','en_name','product_image','stock','category_id','status')
                ->where('en_name', 'like', '%' . $search . '%')
                ->where('status', '=', 1)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // 0 中文
            $data = ProductModel::with(['distributor', 'category'])
                ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
                    'id','en_name','product_image','stock','category_id','status')
                ->where('zn_name', 'like', '%' . $search . '%')
                ->where('status', '=', 1)
                ->orderBy('created_at', 'desc')
                ->get();
        }


        if ($data->isEmpty()) {
            return view('app.productList', ['product' => '']);
        }
        return view('app.productList', ['product' => $data]);

//        dd($data->toArray());
    }

    public function NotifyProcess ($orderNo)
    {


        $order = OrderModel::where('order_no', '=', $orderNo)->first();
        if (!$order) return;

        //未支付 修改相关表状态
        if ($order->status == 2) {

            $res = OrderModel::where('id', '=', $order->id)->update(['status' => 1]);

            if (!$res) {

                Log::error('authorize订单状态修改失败', $params);

            }
        }


    }

}

