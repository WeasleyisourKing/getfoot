<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MessageModel extends Model
{
    protected $table = 'message';

    //黑名单
    protected $guarded = [];

    //关联留言和商品关系 一对一
    public function messageImg ()
    {

        return $this->belongsTo('App\Http\Model\ProductModel', 'product_id', 'id');
    }

    //关联商品单价
    public function distributor ()
    {

        return $this->belongsTo('App\Http\Model\DistributorModel', 'product_id', 'product_id');
    }

    //关联用户信息 一对一
    public function users ()
    {
        return $this->belongsTo('App\Http\Model\UsersModel', 'user_id', 'id');
    }

    //评论回复 一对多
    public function reply ()
    {
        return $this->hasMany('App\Http\Model\ReplyModel', 'reply_id', 'id');
    }

    //获取某产品留言信息
    public static function getProduct ($id)
    {
        return self::with(['messageImg' => function ($query) {
            $query->select('zn_name',
                'id','en_name','product_image','stock');
        }, 'users' => function ($query) {
            $query->select('id', 'name', 'avatar');
        }, 'reply' => function ($query) {
            $query->get();
        }])
            ->where('product_id', '=', $id)
            ->get();
    }

    //插入上传图片
    public static function insertImage ($data)
    {

        $obj = new self($data);
        $obj->save();
        return $obj;
    }
//http://132.148.242.150:3000/coen/12buy.git
    //获取留言信息
    public static function getMessage ($status, $limit)
    {

        return self::with('messageImg')
//            ->select(DB::raw("CASE stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name'"),
//                'id', 'order_id', 'name', 'user_id', 'status', 'content', 'created_at', 'product_id')
            ->select('id', 'order_id', 'name', 'user_id', 'status', 'content', 'created_at', 'product_id')
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    //获取留言信息
    public static function getMessages ($id)
    {

        return self::with(['messageImg' => function ($query) {
            $query->select('zn_name',
                'id','en_name','product_image','stock');
        }, 'distributor', 'reply'])
            ->where('user_id', '=', $id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    //获取留言未读条数
    public static function unread ()
    {
        return self::where('status', '=', 2)->count();
    }

    //添加留言
    public static function addMessage ($data)
    {
        $obj = new self($data);
        $obj->save();
        return $obj;
    }

    //获取某用户全部留言
    public static function getreplyList ($userId, $productId, $orderId)
    {

        $arr = self::where('user_id', '=', $userId)
            ->where('product_id', '=', $productId)
            ->where('order_id', '=', $orderId)
            ->pluck('id');

        $first = DB::table('reply')
            ->select('id', 'name', 'message_name', 'content', 'created_at', 'message_id')
            ->whereIn('reply_id', $arr);

        return self::select('id', 'name', 'message_name', 'content', 'created_at', 'user_id')
            ->whereIn('id', $arr)
            ->union($first)
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

    }

}
