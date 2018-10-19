<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table = 'banner';


    //关联Banner_item模型 一对多
    public function items () {

        return $this->hasMany('App\Http\Model\BannerItemModel','banner_id','id');
    }

    //根据bannerID 获取bannner信息
    public static function getbannerById ($id) {

        return self::with(['items' => function ($query) {
            $query->with('img');
        }])
            ->where('id','=',$id)
            ->first();
    }


    //删除轮播图
    public static function delSow ($arr)
    {
        return (new BannerItemModel)
            ->whereIn('id', $arr)
            ->delete();

    }



}
