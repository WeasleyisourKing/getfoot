<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use App\Rules\PagesRule;
use App\Http\Model\ProductModel;
use App\Http\Model\ProductShelvesModel;
use Illuminate\Support\Facades\DB;

use App\Http\Model\QaqModel;
class ThirdController extends Controller
{

    /**
     * 商品第三方接口
     * url  : api/user/order
     * http : post
     */
    public function product(Request $request)
    {

        (new PagesRule)->goCheck(200);
        $params = $request->all();

        //默认显示
        $params['limit'] = !empty($params['limit']) ? $params['limit'] : 5;
        $params['page'] = !empty($params['page']) ? $params['page'] : 1;

        $result = ProductModel::with(['distributor' => function ($q) {
            $q->select('product_id', DB::raw('level_one_price as agent,level_four_price as retail'));
        }, 'category' => function ($qu) {
            $qu->select('id', 'zn_name');
        }])
            ->select('id', 'en_name', 'zn_name', 'sku', DB::raw('innersku as inner_sku'), 'product_image',
                'stock', 'summary', 'zn_number', 'number', 'weight', 'zn_weight', 'category_id', 'zn_describe')
            ->where('status', '=', 1)
            ->paginate($params['limit'], ['*'], '', $params['page']);

        $result = $result->toArray();
        $url = config('custom.img_url');

        foreach ($result['data'] as &$items) {
            $items['product_image'] = $url . $items['product_image'];
            $items['category_name'] = $items['category']['zn_name'];
            unset($items['category_id']);
            unset($items['category']);
            unset($items['origin_stock']);
            unset($items['distributor']['product_id']);
        }

        return Common::successData(Common::paging($result));

    }

    public function check(Request $request)
    {

//        $data = ProductModel::whereBetween('id', [87, 187])
//            ->get(['id', 'en_describe', 'zn_describe'])->toArray();
//        $data = json_encode($data);
//        $r = QaqModel::where('id',1)->update(['qaq' => $data]);
//
//      dd($r);


        $data = QaqModel::where('id',1)->first(['qaq'])->qaq;
        dd(json_decode($data,true));
        $ee = ProductModel::where('status', '=', 1)->get()->toArray();
        DB::transaction(function () use ($data) {
            foreach (json_decode($data, true) as $v) {

                foreach ($ee as $items) {
                    if ($v['id'] == $items['id']) {
                        ProductModel::where('id', $v['id'])->update([
                            'en_describe' => $v['en_describe'],
                            'zn_describe' => $v['zn_describe']
                        ]);
                    }
                }
            }
        });
      dd(234);
        $ee = ProductModel::where('status', '=', 1)->get();
        foreach ($ee as $items) {
            $data = ProductShelvesModel::where('product_id', '=', $items->id)->get()->toarray();

//                dump('商品id：'.$items->id);
//                dump('商品库存：'.$items->stock);
//                dump('商品货架库存：'.array_sum(array_column($data,'count')));
            if ($items->stock != array_sum(array_column($data, 'count'))) {
                dd('商品库存与货架对应情况：NO');
//                dump('商品库存与货架对应情况：NO');
            } else {
//                dump('商品库存与货架对应情况：OK');
            }

        }
    }

}