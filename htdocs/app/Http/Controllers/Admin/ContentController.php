<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\BannerModel;
use App\Http\Model\ArticleModel;
use App\Http\Model\ProductModel;
use App\Http\Model\CategoryModel;
use App\Http\Model\BrandModel;
use App\Http\Model\BannerItemModel;
use App\Http\Model\ThemeModel;
use App\Http\Model\ThemeImageModel;
use App\Rules\ActivityRule;
use App\Http\Controllers\Common;
use App\Exceptions\ParamsException;
use App\Rules\ArticleRule;

/**
 * 内容管理类
 * Class ContentController
 * @package App\Http\Controllers\Admin
 */
class ContentController extends Controller
{

    /**
     * 首页横幅页面
     * @param Request $request
     * @return mixed
     */
    public function index ()
    {

        //根据bannerID 获取bannner信息 默认选择首页
        $res = BannerModel::getbannerById(1);

        return view('admin.content.index', ['data' => ($res->toArray())['items']]);
    }

    /**
     * 页面管理页面
     * @param Request $request
     * @return mixed
     */
    public function contentList ()
    {

        //联系我们
        $contact = ArticleModel::getInfoById(1);
        //关于我们
        $about = ArticleModel::list(2);

        //使用条款
        $terms = ArticleModel::list(3);

        //客户服务
        $customer = ArticleModel::list(4);

        //app用户条款
        $userTerms = ArticleModel::getInfoById(13);

        return view('admin.content.content-list', [
            'contact' => $contact,
            'about' => $about,
            'terms' => $terms,
            'customer' => $customer,
            'userTerms' => $userTerms
        ]);

    }

    /**
     * 首页内容页面
     * @param Request $request
     * @return mixed
     */
    public function contentHome ($status, $category, $brand, $limit)
    {

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
            $datas = ProductModel::getProductListTheme($status, $arr, $limit);
        } else {
            //获取全部数据
            $datas = ProductModel::getProductAllTheme($arr, $limit);
        }

        //获取商品分类列表
//        $categorys = CategoryModel::where('id', '!=', 1)->get();
        $categorys = CategoryModel::where('id', '!=', 1)->where('status', '=', 1)->get();
        $categorys = $this->getTree($categorys->toArray(), 0);
        //获取品牌列表
        $brands = BrandModel::where('id', '!=', 1)->get();

        //获取商品分类名称
        if ($category != -1 && !empty($category)) {
            $data = CategoryModel::select('zn_name', 'en_name')->where('id', '=', $category)->first();
            $categoryVal = $data['zn_name'] . '（' . $data['en_name'] . '）';

        }


//        //获取商品分类名称
//        foreach ($categorys->toArray() as $item) {
//
//            if (!empty($item['id']) && $item['id'] == $category) {
//                $categoryVal = $item['zn_name'] . '（' . $item['en_name'] . '）';
//            }
//        }
        //获取品牌名称
        foreach ($brands->toArray() as $item) {

            if (!empty($item['id']) && $item['id'] == $brand) {
                $brandVal = $item['zn_name'] . '（' . $item['en_name'] . '）';
            }
        }
        //根据bannerID 获取bannner信息 默认选择首页
//        $res = BannerModel::getbannerById(1);

        $res = BannerItemModel::with('img')->get()->toArray();

        $arr1 = $arr2 = $arr3 = $arr4 = [];
        foreach ($res as $items) {
            if ($items['banner_id'] == 1) {
                array_push($arr1, $items);

            } elseif ($items['banner_id'] == 2) {
                array_push($arr2, $items);

            } elseif ($items['banner_id'] == 3) {
                array_push($arr3, $items);

            } elseif ($items['banner_id'] == 4) {
                array_push($arr4, $items);

            }
        }

        //获取活动列表
        $themeData = ThemeModel::get();
        $theme = ThemeModel::getThemeList(1);
        //获取ST活动列表
        $STtheme = ThemeModel::getThemeList(2);

//        dump($theme->toArray());

        $hot = ThemeImageModel::where('type', 1)->get();
        $sthot = ThemeImageModel::where('type', 2)->get();
//        dump($hot);
//        foreach (ThemeImageModel::get()->toArray() as $items) {
//            array_push($hot,$items['img']);
//        }


//dd($datas->toArray());
        return view('admin.content.content-content',
            [
                'themeData' => $themeData,
                'theme' => $theme,
                'stapp' => $arr3,
                'stpc' => $arr4,
                'sttheme' => $STtheme,
                'product' => $datas,
                'data' => $arr1,
                'pc' => $arr2,
                'status' => $status == -1 ? '全部状态' : ($status == 1 ? '上架' : '下架'),
                'statusId' => $status,
                'categoryId' => $category,
                'brandId' => $brand,
                'category' => $categorys,
                'brand' => $brands,
                'limit' => '显示' . $limit . '条',
                'limitId' => $limit,
                'hot' => $hot,
                'sthot' => $sthot,
                'categoryVal' => empty($categoryVal) ? '全部分类' : $categoryVal,
//                'categoryVals' => empty($categoryVals) ? '全部分类' : $categoryVals,
                'brandVal' => empty($brandVal) ? '全部品牌' : $brandVal
            ]
        );

    }

    //递归
    public function getTree ($data, $pId, $level = 0, $html = '---')
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
     * 添加活动接口*
     * @param Request $request
     * @return mixed
     */
    public function articleAdd (Request $request)
    {

        (new ActivityRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (ThemeModel::ArticleUnique($name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '活动中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'status' => $params['status'],
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'head_image_id' => is_array($params['img']) ? '/' . strstr($params['img'][0], 'uploads') : '/' . strstr($params['img'], 'uploads')
        ];


        $res = ThemeModel::insertArticleInfo($data);


        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 添加商品活动接口*
     * @param Request $request
     * @return mixed
     */
    public function productArticleAdd (Request $request)
    {

        $params = $request->all();

        $data = [];
        foreach ($params['theme'] as $key => $item) {

            $data[$key]['product_id'] = $params['id'];
            $data[$key]['theme_id'] = $item;
        }

        $status = isset($params['hot']) ? $params['hot'] : -1;

        // 新增参数，$params['theme']，表明传递theme_id==0，
        ThemeModel::addArticleproduct($params['id'], $data, $params['theme'], $status);


        return Common::successData();
    }

    /**
     * //修改活动接口*
     * @param Request $request
     * @return mixed
     */
    public function activityEditor (Request $request)
    {

        (new ActivityRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [
            'zn_name' => htmlspecialchars(strip_tags(trim($params['zn_name']))),
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name'])))
        ];

        //判断图片
        if (!empty($params['img'])) {
            $data['head_image_id'] = is_array($params['img']) ? '/' . strstr($params['img'][0], 'uploads') : '/' . strstr($params['img'], 'uploads');
        }

        $res = ThemeModel::updateArticle($params['id'], $data);


        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }


    /**
     * //删除文章接口
     * @param Request $request
     * @return mixed
     */
    public function activityDel (Request $request)
    {

        $id = $request->input('id');

        $res = ThemeModel::delArticle($id);

        return Common::successData();
    }


    /**
     * //删除轮播图接口
     * @param Request $request
     * @return mixed
     */
    public function sowDel (Request $request)
    {

        $arr = $request->input('arr');

        $res = BannerModel::delSow($arr);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 添加文章接口*
     * @param Request $request
     * @return mixed
     */
    public function contentAdd (Request $request)
    {

        (new ArticleRule)->goCheck(200);

        $params = $request->all();

        $name = htmlspecialchars(strip_tags(trim($params['zn_name'])));
        //验证唯一性
        if (ArticleModel::ArticleUnique($params['id'], $name)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '中文名称已存在'
            ]);
        }
        //拼接数据
        $data = [
            'zn_name' => $name,
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'zn_content' => $params['zn_content'],
            'en_content' => $params['en_content'],
            'c_id' => $params['id']
        ];


        $res = ArticleModel::insertArticleInfo($data);


        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //修改文章接口*
     * @param Request $request
     * @return mixed
     */
    public function articleEditor (Request $request)
    {

        (new ArticleRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [
            'zn_name' => htmlspecialchars(strip_tags(trim($params['zn_name']))),
            'en_name' => htmlspecialchars(strip_tags(trim($params['en_name']))),
            'zn_content' => $params['zn_content'],
            'en_content' => $params['en_content']
        ];


        $res = ArticleModel::updateArticle($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }


    /**
     * //删除文章接口
     * @param Request $request
     * @return mixed
     */
    public function articleDel (Request $request)
    {

        $id = $request->input('id');

        $res = ArticleModel::delArticle($id);

        return Common::successData();
    }


    /**
     * 获取商品接口
     * @param Request $request
     * @return mixed
     */
    public function articleModify (Request $request)
    {
        $id = $request->input('id');

        $res = ArticleModel::getInfoById($id);

        return Common::successData($res);
    }

    /**
     * 首页活动页面
     * @param Request $request
     * @return mixed
     */
    public function contentActivite ($status)
    {

        //获取活动列表
        $res = ThemeModel::getThemeList($status);

        //传递活动图和活动列表
        $head_img = $theme_img = [];
        foreach ($res->items() as $item) {
            $head_img[] = $item->toArray()['head_img']['url'];

        }
        foreach ($res->items() as $item) {
            $theme_img[] = $item->toArray()['theme_img']['url'];

        }

        return view('admin.content.activite', ['data' => $res, 'status' => $status, 'head_img' => $head_img, 'theme_img' => $theme_img]);

    }

    /**
     * 添加banner URL接口
     * @param Request $request
     * @return mixed
     */
    public function contentUrl (Request $request)
    {
        $params = $request->all();

        $res = BannerItemModel::where('id', '=', $params['id'])->update(['url' => $params['url']]);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }


    /**
     * 获取各活动下商品接口
     * @param Request $request
     * @return mixed
     */
    public function seeActivie (Request $request)
    {
        $id = $request->input('id');

        $status = $request->input('status');

        if (is_null($status)) {
            $res = ThemeModel::with(['products' => function ($query) {
                $query->select('id','status', 'en_name', 'zn_name', 'product_image');
            }])->where('id', '=', $id)->first();
        } else {
            $res = ThemeModel::with(['products' => function ($query) {
                $query->with(['hot' => function ($query) {
                    $query->with('cat');
                }])
                    ->select('id','status','en_name', 'zn_name', 'product_image');
            }])->where('id', '=', $id)->first();


            $res = $res->toArray();
            $res['val'] = 1;

        }
//        dd($res->toArray());
        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
    }

    /**
     * 获取各活动下商品接口
     * @param Request $request
     * @return mixed
     */
    public function hotImgHandle (Request $request)
    {

        $img = $request->file('img');

        $id = $request->input('id');

        //对象是否存在
        if (empty($img)) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '文件已经上传'
                ]
            ]);
        }
        // 文件是否上传成功
        if (!$img->isValid()) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '文件上传失败'
                ]
            ]);
        }
        //后缀名
        $ext = $img->getClientOriginalExtension();
        $fileTypes = ['png', 'jpg', 'gif', 'jpeg'];

        if (!in_array($ext, $fileTypes)) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '图片格式只允许png,jpg,gif,jpeg'
                ]
            ]);
        }
        // 上传文件名称
        $imgName = $img->getClientOriginalName();

        //文件目录
        $filePath = config('custom.file_path');
        // 移动到框架应用根目录/uploads/目录下 文件名不变 同名覆盖
        $img->move($filePath . config('custom.DIRECTORY_SEPARATOR'), $imgName);


        if (is_null(ThemeImageModel::where('id', '=', $id)->first())) {
            //插入
            if ($request->input('status') == 2) {

                ThemeImageModel::insert([
                    'id' => $id,
                    'type' => 2,
                    'img' => config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . $imgName
                ]);
            } else {
                ThemeImageModel::insert([
                    'id' => $id,
                    'img' => config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . $imgName
                ]);
            }

        } else {
            //修改
            ThemeImageModel::where('id', '=', $id)->update([
                'img' => config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . $imgName
            ]);
        }

        return response()->json([
            'errno' => 0
        ]);
    }

    /**
     * 上传热销商品地址接口
     * @param Request $request
     * @return mixed
     */
    public function hotUrl (Request $request)
    {
        $params = $request->all();
        $res = ThemeImageModel::where('id', '=', $params['id'])
            ->update(['url' => htmlspecialchars(strip_tags(trim($params['url'])))]);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
    }


}

