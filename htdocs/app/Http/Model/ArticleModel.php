<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleModel extends Model
{
    protected $table = 'article';

    protected $hidden = [];

    protected $guarded = [];


    //获取列表
    public static function list ($cid)
    {

        return self::select('id','zn_name','en_name','created_at','updated_at')
            ->where('c_id', '=', $cid)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    //获取某id信息
    public static function getInfoById ($id)
    {
        return self::select('id','zn_name','en_name','zn_content','en_content')
            ->where('id', '=', $id)
            ->first();
    }

    //修改文章
    public static function updateArticle ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }



    //根据输入搜索案例
    public static function getSearch ($value)
    {
        return self::select('id', 'title', 'summary', 'status', 'create_time')
            ->whereBetween('c_id', [1, 3])
            ->where('title', 'like', $value . '%')
            ->orderBy('create_time', 'desc')
            ->get();
    }

    //添加文章
    public static function insertArticleInfo ($data)
    {
        return (new self($data))->save();
    }

    //文章是否唯一
    public static function ArticleUnique ($id, $title)
    {
        return self::where('c_id', '=', $id)
            ->where('zn_name', '=', $title)
            ->first();
    }



    //删除文章
    public static function delArticle ($id)
    {
        return self::where('id', '=', $id)
            ->delete();

    }

}
