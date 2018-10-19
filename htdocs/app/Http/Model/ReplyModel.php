<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReplyModel extends Model
{
    protected $table = 'reply';

    protected $hidden = [];

    protected $guarded = [];


    public static function getAdminReply ($arr)
    {
        return self::select('message_id', 'content', 'create_time')
            ->whereIn('reply_id', $arr)
            ->orderBy('create_time', 'asc')
            ->get()
            ->toArray();
    }

    //插入用户留言
    public static function insertUserMessage ($data, $id)
    {
        DB::beginTransaction();

        try {

            (new self($data))->save();

            (new MessageModel)->where('id', '=', $id)->update(['status' => 1]);
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }


}
