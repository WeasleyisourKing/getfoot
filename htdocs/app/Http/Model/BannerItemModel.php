<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BannerItemModel extends Model
{
    protected $table = 'banner_item';

    protected $fillable = ['image_id', 'type', 'banner_id'];

    //嵌套关联image表 一对一 横幅和图片
    public function img ()
    {
        return $this->belongsTo('App\Http\Model\ImageModel', 'image_id', 'id');
    }

    //删除banner_item
    public static function deleteBannerItem ($arr)
    {
        return self::whereIn('id', $arr)->delete();
    }

    //插入上传图片并且建立关系
    public static function insertBannerItem ($imgData,$status)
    {
        DB::beginTransaction();

        try {
           $obj = (new ImageModel)->insertImage($imgData);

            (new self([
               'image_id' => $obj->id,
               'banner_id' => $status
           ]))->save();

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }
}
