<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\CategoryModel;
use App\Http\Model\BrandModel;
use App\Http\Model\MessageModel;
use App\Http\Model\ReplyModel;
use App\Http\Model\AttributeModel;
use App\Http\Model\ProductModel;
use App\Http\Model\ImageProductModel;
use App\Http\Model\DistributorModel;
use App\Http\Model\AttrProductModel;
use App\Http\Model\DiscountModel;
use App\Http\Model\UsersDiscountModel;
use App\Http\Model\ShelvesModel;
use App\Http\Controllers\Common;
use App\Rules\CategoryRule;
use App\Rules\BrandRule;
use App\Rules\ReplyRule;
use App\Rules\ProductRule;
use App\Rules\DiscountRule;
use App\Exceptions\ParamsException;
use Illuminate\Support\Facades\DB;

/**
 * 商品管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class ProductController extends Controller
{

    /**
     * 分类一级页面
     * @param Request $request
     * @return mixed
     */
    public function productCategory($status, $limit)
    {


        //获取分类列表
        $res = CategoryModel::getCategoryList($limit);

        $categorys = CategoryModel::where('id', '!=', 1)->get();

        $categorys = $this->getTree($categorys->toArray(), 0);

        foreach ($categorys as $key => $item) {
            if (!empty($item['pid'])) {
                $categorys[$key]['sign'] = 1;
            } else {
                $categorys[$key]['sign'] = 0;
            }
        }

        return view('admin.product.product-category', [
            'data' => $res,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '显示' : '不显示'),
            'categorys' => $categorys,
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 分类二级页面
     * @param Request $request
     * @return mixed
     */
    public function categoryLevel($id, $status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];

        //获取分类列表
        $res = CategoryModel::getCategoryLevel($id, $statusData, $limit);

        return view('admin.product.product-level-category', [
            'data' => $res,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '显示' : '不显示'),
            'limit' => '显示' . $limit . '条'
        ]);
    }

    /**
     * 优惠活动页面
     * @param Request $request
     * @return null
     */
    public function discount($status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];

        $data = DiscountModel::with(['info' => function ($query) {
            $query->select('discount_id')->where('status', '=', 1);
        }])->whereIn('status', $statusData)->orderBy('created_at', 'desc')->paginate($limit);

//        ->select('discount.id,discount.zn_name,discount.stock,discount.status,discount.type,discount.rcent')
//        select(DB::raw('count(users_discount.discount_id) as count'))

//        $data = DiscountModel::selectRaw('count(users_discount.discount_id) as count')
//            ->select('discount.id','discount.zn_name','discount.type')
//            ->join('users_discount','discount.id','=','users_discount.discount_id')
//            ->whereIn('discount.status', $statusData)
//            ->orderBy('created_at', 'desc')
//            ->paginate($limit);
//        dd($data->toArray());
        //数据 类型 标题
        return view('admin.product.product-discount', [
            'data' => $data,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '启用' : '禁用'),
            'limit' => '显示' . $limit . '条'
        ]);

    }

    /**
     * 品牌列表页面
     * @param Request $request
     * @return mixed
     */
    public function productBrand($status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];

        //获取品牌列表
        $res = BrandModel::getBrandList($statusData, $limit);

        return view('admin.product.product-brand', [
            'data' => $res,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '显示' : '不显示'),
            'limit' => '显示' . $limit . '条'
        ]);


        return view('admin.product.brand', ['data' => $res, 'status' => $status]);
    }

    /**
     * 商品评论页面
     * @param Request $request
     * @return mixed
     */
    public function productMessage($status, $limit)
    {

//        dd(23);
        $statusData = ($status != -1) ? [$status] : [1, 2];
        //获取品牌列表
        $res = MessageModel::getMessage($statusData, $limit);


//        dump($res->toArray());
        return view('admin.product.product-comment', [
            'data' => $res,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '回复' : '没回复'),
            'limit' => '显示' . $limit . '条',
        ]);
    }

    /**
     * 商品列表页面
     * @param Request $request
     * @return mixed
     */
    public function productList($status, $category, $brand, $limit)
    {
dd(2);
        $arr = [
            'category_id' => $category,
            'brand_id' => $brand
        ];

        //筛选数据
        foreach ($arr as $key => $item) {

            if (empty($item) || $item == -1) {
                unset($arr[$key]);
            }
        }

        if ($status != -1) {
            $res = ProductModel::getProductList($status, $arr, $limit);
        } else {
            //获取全部数据
            $res = ProductModel::getProductAll($arr, $limit);
        }
//dd($res->toArray());
        //获取商品列表
        //获取商品分类列表
        $categorys = CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->get();
        //获取品牌列表
        $brands = BrandModel::where('id', '!=', 1)->get();

        $categoryVal = $brandVal = '';

        //获取单品个数下拉框列表
        $number = AttributeModel::getAttr(1);
        //获取单品重量下拉框列表
        $weight = AttributeModel::getAttr(2);

        $categorys = $this->getTree($categorys->toArray(), 0);

//        dd($categorys);

        //获取商品分类名称
        if ($category != -1 && !empty($category)) {
            $data = CategoryModel::select('zn_name', 'en_name')->where('id', '=', $category)->first();
            $categoryVal = $data['zn_name'] . '（' . $data['en_name'] . '）';
        }

        //获取品牌名称
        foreach ($brands->toArray() as $item) {

            if (!empty($item['id']) && $item['id'] == $brand) {
                $brandVal = $item['zn_name'] . '（' . $item['en_name'] . '）';
            }
        }
        //获取货架名称
        $shelves = ShelvesModel::get();
//dd($category);
        return view('admin.product.product-item', [
            'data' => $res,
            'shelves' => $shelves,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '上架' : '下架'),
            'statusId' => $status,
            'categoryId' => $category,
            'brandId' => $brand,
            'category' => $categorys,
            'brand' => $brands,
            'limit' => '显示' . $limit . '条',
            'limitId' => $limit,
            'number' => $number,
            'weight' => $weight,
            'categoryVal' => empty($categoryVal) ? '全部分类' : $categoryVal,
            'brandVal' => empty($brandVal) ? '全部品牌' : $brandVal
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

    /**
     * 获取商品接口
     * @param Request $request
     * @return mixed
     */
    public function productModify(Request $request)
    {

        $id = $request->input('id');
        //获取商品列表
        $res = ProductModel::getProductById($id);

        //获取商品分类列表
        $categorys = CategoryModel::where('id', '!=', 1)->get();

        $categorys = $this->getTree($categorys->toArray(), 0);

        //获取品牌列表
        $brands = BrandModel::get();

        //获取单品个数下拉框列表
        $number = AttributeModel::getAttr(1);
        //获取单品重量下拉框列表
        $weight = AttributeModel::getAttr(2);

        $distributor = DistributorModel::select('level_one_price as one_price', 'level_two_price as two_price', 'level_three_price as three_price', 'level_four_price as four_price')->where('product_id', '=', $id)->first();

        $image = ImageProductModel::getProductImage($id);

        $shelves = ShelvesModel::get();

        return Common::successData([
            'res' => $res,
            'category' => $categorys,
            'brand' => $brands,
            'number' => $number,
            'weight' => $weight,
            'shelves' => $shelves,
            'distributor' => $distributor,
            'image' => $image
        ]);

    }

    /**
     * //修改分类接口*
     * @param Request $request
     * @return mixed
     */
    public function categoryEditor(Request $request)
    {

        (new CategoryRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (CategoryModel::unique($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '一级分类中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'icon' => htmlspecialchars(strip_tags(trim($params['icon']))),
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name'])))
        ];

        $res = CategoryModel::updateCategoryInfo($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 创建一级分类接口*
     * @param Request $request
     * @return mixed
     */
    public function categoryInsert(Request $request)
    {

        (new CategoryRule)->goCheck(200);
        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (CategoryModel::uniqueCategory($name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '一级分类中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'icon' => htmlspecialchars(strip_tags(trim($params['icon']))),
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name'])))

        ];

        $res = CategoryModel::insertCategory($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //删除分类接口
     * @param Request $request
     * @return mixed
     */
    public function categoryDel(Request $request)
    {

        $id = $request->input('id');

        $res = CategoryModel::delCategory($id);

        return Common::successData();
    }


    /**
     * //修改品牌接口
     * @param Request $request
     * @return mixed
     */
    public function brandEditor(Request $request)
    {

        (new BrandRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (BrandModel::unique($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '品牌中文名称已存在'
            ]);
        }
        $data = [
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name'])))
        ];

        $res = BrandModel::updateBrandInfo($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 创建品牌接口*
     * @param Request $request
     * @return mixed
     */
    public function brandInsert(Request $request)
    {

        (new BrandRule)->goCheck(200);
        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (BrandModel::uniqueBrand($name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '品牌中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name'])))
        ];


        $res = BrandModel::insertBrand($data);


        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //删除品牌接口
     * @param Request $request
     * @return mixed
     */
    public function brandDel(Request $request)
    {

        $id = $request->input('id');

        $res = BrandModel::delBrand($id);

        return Common::successData();
    }

    /**
     * 回复用户留言
     */
    public function replyMessage(Request $request)
    {

        (new ReplyRule)->goCheck(200);

        $params = $request->all();

        $data = [];

        $data['reply_id'] = htmlspecialchars(strip_tags(trim($params['id'])));
        $data['content'] = htmlspecialchars(strip_tags(trim($params['news'])));
        $data['message_name'] = htmlspecialchars(strip_tags(trim($params['name'])));


        ReplyModel::insertUserMessage($data, $params['id']);

        return Common::successData();

    }

    /**
     * 获取用户全部留言
     */
    public function replyList(Request $request)
    {

        $params = $request->all();


        $res = MessageModel::getreplyList($params['userId'], $params['productId'], $params['orderId']);


        return Common::successData($res);

    }


    /**
     * 删除留言接口
     */
    public function messageDel(Request $request)
    {

        $params = $request->all();

        if ($params['status'] != 1) {
            //单条
            if ($params['user_id'] != 0) {
                //留言
                MessageModel::where('id', '=', $params['id'])->delete();
            } else {
                //回复
                $r = ReplyModel::where('id', '=', $params['id'])->delete();
            }
        } else {

            //全部
            $arr = MessageModel::where('id', '=', $params['id'])->first(['order_id', 'user_id', 'product_id']);

            $id = MessageModel::where('order_id', '=', $arr['order_id'])
                ->where('user_id', '=', $arr['user_id'])
                ->where('product_id', '=', $arr['product_id'])
                ->pluck('id');

            ReplyModel::whereIn('reply_id', $id)->delete();
            MessageModel::whereIn('id', $id)->delete();
        }

        return Common::successData();

    }

    //获取留言未读条数
    public function unread()
    {
        $res = MessageModel::unread();

        return Common::successData($res);
    }

    /**
     * //修改商品基本接口
     * @param Request $request
     * @return mixed
     */
    public function productRevise(Request $request)
    {

        (new ProductRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        $sku = htmlspecialchars(strip_tags(trim($params['sku'])));
        $innerSku = htmlspecialchars(strip_tags(trim($params['inner_sku'])));

        if (ProductModel::uniqueP($params['id'], $name) || ProductModel::uniqueS($params['id'], $sku)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '商品中文名称或SKU已存在'
            ]);
        }
        if (ProductModel::where('innersku', '=', $innerSku)->where('id', '!=', $params['id'])->first()) {

            throw new ParamsException([
                'code' => 200,
                'message' => '商品内部SKU已存在'
            ]);
        }
        //拼接数据
        $data = [
            'sku' => $sku,
            'innersku' => $innerSku,
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'term' => $params['term'],
            'en_describe' => $params['en_editor'],
            'zn_describe' => $params['zn_editor'],
            'summary' => htmlspecialchars(strip_tags(trim($params['summary']))),
            'price' => $params['price'],
            'category_id' => $params['category'],
            'brand_id' => $params['brand'],
            'number' => $params['number'],
            'weight' => $params['weight'],
            'status' => $params['status'],
//            'shelves' => $params['shelves'],
//            'net_weight' => $params['net_weight'],
//            'zn_net_weight' => '克',
//            'en_net_weight' => 'g',
            'zn_weight' => strstr($params['weightUnit'], '|', true),
            'en_weight' => ltrim(strstr($params['weightUnit'], '|'), '|'),
            'zn_number' => strstr($params['numberUnit'], '|', true),
            'en_number' => ltrim(strstr($params['numberUnit'], '|'), '|')

        ];

        $distributor = [
            'level_one_price' => $params['one_price'],
            'level_two_price' => $params['two_price'],
            'level_three_price' => $params['three_price'],
            'level_four_price' => $params['four_price']
        ];

        //判断图片
        if (!empty($params['imgId'])) {

            $data['product_image'] = is_array($params['imgId']) ? '/' . strstr($params['imgId'][0][0], 'uploads') : '/' . strstr($params['imgId'], 'uploads');

            $arr = [];
            foreach ($params['imgId'] as $items) {
                $arr[]['link'] = $items[0];
            }

                $shelves = !empty($params['shelves']) ? array_column($params['shelves'], 'shelves_id') : null;


                ProductModel::updateProductAndImgInfo($params['id'], $data,$arr, $distributor, $shelves);


        } else {

            $shelves = !empty($params['shelves']) ? array_column($params['shelves'], 'shelves_id') : null;
            ProductModel::updateProductInfo($params['id'], $data, $distributor, $shelves);

        }


        //商品属性
        if (!empty($params['attribute'])) {

            $attribute = $this->dataFilter($params['attribute']);

            AttrProductModel::updateAttr($params['id'], $attribute);
        } else {
            AttrProductModel::updateAttrTo($params['id']);
        }

        return Common::successData();
    }

    /**
     * //添加商品基本接口
     * @param Request $request
     * @return mixed
     */
    public function productEstablish(Request $request)
    {


        (new ProductRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        $sku = htmlspecialchars(strip_tags(trim($params['sku'])));
        $innerSku = htmlspecialchars(strip_tags(trim($params['inner_sku'])));

        //验证唯一性
        if (ProductModel::uniqueProduct($name) || ProductModel::uniqueSKU($sku)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '商品中文名称或SKU已存在'
            ]);
        }
        if (ProductModel::where('innersku', '=', $innerSku)->first()) {

            throw new ParamsException([
                'code' => 200,
                'message' => '商品内部SKU已存在'
            ]);
        }

        //拼接数据
        $data = [
            'sku' => $sku,
            'innersku' => $innerSku,
            'zn_name' => $name,
            'term' => $params['term'],
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'en_describe' => $params['en_editor'],
            'zn_describe' => $params['zn_editor'],
            'summary' => htmlspecialchars(strip_tags(trim($params['summary']))),
            'price' => $params['price'],
            'category_id' => $params['category'],
            'brand_id' => $params['brand'],
            'number' => $params['number'],
            'weight' => $params['weight'],
            'status' => $params['status'],
//            'shelves' => $params['shelves'],
//            'net_weight' => $params['net_weight'],
//            'zn_net_weight' => '克',
//            'en_net_weight' => 'g',
            'zn_weight' => strstr($params['weightUnit'], '|', true),
            'en_weight' => ltrim(strstr($params['weightUnit'], '|'), '|'),
            'zn_number' => strstr($params['numberUnit'], '|', true),
            'en_number' => ltrim(strstr($params['numberUnit'], '|'), '|')

        ];

//        if (!empty($params['shelves'])) {
//            $data['shelves'] =  $params['shelves'];
//        }

//        dd($data);
        //判断图片
        if (!empty($params['imgId'])) {
            $data['product_image'] = is_array($params['imgId']) ? '/' . strstr($params['imgId'][0][0], 'uploads') : '/' . strstr($params['imgId'], 'uploads');
        }

        $arr = [];
        foreach ($params['imgId'] as $items) {
            $arr[]['link'] = $items[0];
        }


        $distributor = [
            'level_one_price' => $params['one_price'],
            'level_two_price' => $params['two_price'],
            'level_three_price' => $params['three_price'],
            'level_four_price' => $params['four_price']
        ];
        if (!empty($params['shelves'])) {

            $pId = ProductModel::insertProduct($data, $arr, $distributor, array_column($params['shelves'], 'shelves_id'));
        } else {
            $pId = ProductModel::insertProduct($data, $arr, $distributor, $shelves = null);
        }
        //商品属性
        if (!empty($params['attribute'])) {

            $attribute = $this->dataFilter($params['attribute']);
            AttrProductModel::insertAttr($pId, $attribute);
        }

        return Common::successData();
    }

    //递归过滤xss
    public function dataFilter($arr)
    {
        if (!is_array($arr))
            return '';
        foreach ($arr as $key => $items) {

            if (is_array($items)) {
                $arr[$key] = $this->dataFilter($items);
            } else {
                $arr[$key] = htmlspecialchars(strip_tags(trim($items)));
            }
        }

        return $arr;
    }

    /**
     * //上架商品接口
     * @param Request $request
     * @return mixed
     */
    public function productUp(Request $request)
    {

        $arr = $request->input('arr');


        $res = ProductModel::batchProduct($arr, ['status' => 1]);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //下架商品接口
     * @param Request $request
     * @return mixed
     */
    public function productDown(Request $request)
    {

        $arr = $request->input('arr');


        $res = ProductModel::batchProduct($arr, ['status' => 2]);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //删除商品接口
     * @param Request $request
     * @return mixed
     */
    public function productDel(Request $request)
    {

        $id = $request->input('id');

        $res = ProductModel::delProduct($id);

        return Common::successData();
    }

    /**
     * 创建二级分类接口*
     * @param Request $request
     * @return mixed
     */
    public function categoryLevelInsert(Request $request)
    {

        (new CategoryRule)->goCheck(200);
        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));


        //验证唯一性
        if (CategoryModel::uniqueCategoryLevel($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '二级分类中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'icon' => htmlspecialchars(strip_tags(trim($params['icon']))),
            'status' => $params['status'],
            'pid' => $params['id']

        ];

        $res = CategoryModel::insertCategory($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //修改二级分类接口*
     * @param Request $request
     * @return mixed
     */
    public function categoryLevelEditor(Request $request)
    {

        (new CategoryRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (CategoryModel::uniqueLevel($params['pid'], $params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '二级分类中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'status' => $params['status'],
            'icon' => htmlspecialchars(strip_tags(trim($params['icon']))),
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name'])))
        ];

        $res = CategoryModel::updateCategoryInfo($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 创建折扣码接口*
     * @param Request $request
     * @return mixed
     */
    public function discountInsert(Request $request)
    {


        (new DiscountRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (DiscountModel::unique($name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '折扣码中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'stock' => htmlspecialchars(strip_tags(trim($params['number']))),
            'type' => $params['type'],
            'code' => htmlspecialchars(strip_tags(trim($params['code']))),
            'status' => $params['status']
        ];

        if ($params['type'] != 1) {

            $data['rcent'] = htmlspecialchars(strip_tags(trim($params['rcent'])));
        } else {
            $data['threshold'] = htmlspecialchars(strip_tags(trim($params['threshold'])));
            $data['rcent'] = htmlspecialchars(strip_tags(trim($params['price'])));

        }

        DiscountModel::insertDiscount($data, $data['stock']);


        return Common::successData();
    }

    /**
     * //修改折扣码接口*
     * @param Request $request
     * @return mixed
     */
    public function discountEditor(Request $request)
    {

        (new DiscountRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (DiscountModel::uniqueDiscount($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '折扣码中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'stock' => htmlspecialchars(strip_tags(trim($params['number']))),
            'type' => $params['type'],
            'status' => $params['status']
        ];

        if ($params['type'] != 1) {

            $data['rcent'] = htmlspecialchars(strip_tags(trim($params['rcent'])));
            $data['threshold'] = 0;
        } else {
            $data['threshold'] = htmlspecialchars(strip_tags(trim($params['threshold'])));
            $data['rcent'] = htmlspecialchars(strip_tags(trim($params['price'])));

        }

        $res = DiscountModel::updateDiscount($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //查看折扣码接口*
     * @param Request $request
     * @return mixed
     */
    public function discountSee(Request $request)
    {

        $id = $request->input('id');

        $data = UsersDiscountModel::with(['order' => function ($query) {
            $query->select('discount_id', 'order_no');
        }])->where('discount_id', '=', $id)->get();

//        dd($data->toArray());
        return Common::successData($data);
    }

    /**
     * //删除折扣码接口
     * @param Request $request
     * @return mixed
     */
    public function discountDel(Request $request)
    {

        $id = $request->input('id');

        $res = DiscountModel::delDiscount($id);

        return Common::successData();
    }

    /**
     * //修改二级分类顺序接口
     * @param Request $request
     * @return mixed
     */
    public function scoreCategory(Request $request)
    {

        $data = $request->input('data');


        foreach ($data as $items) {
//            dump(!is_numeric($items['score']));
//            dump(!$items['score'] >= 1);
//            dump(!$items['score'] <= 100);

            if (!is_numeric($items['score']) || !($items['score'] >= 1) || !($items['score'] <= 100)) {

                throw new ParamsException([
                    'code' => 200,
                    'message' => '顺序不是1-100的数字'
                ]);
            }
        }
        CategoryModel::updateScoreCategory($data);

        return Common::successData();
    }


}

