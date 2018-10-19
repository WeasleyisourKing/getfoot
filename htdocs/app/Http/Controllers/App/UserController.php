<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\MessageModel;
use App\Http\Model\OrderModel;
use App\Http\Model\OrderProductModel;


class UserController extends Controller
{
	//我的评论
	public function message ()
	{
		$id = Auth()->guard('pc')->user()->id;
		$edit = ['see'=>1];
		$xx = MessageModel::where('user_id',$id)->update($edit);
		$data = MessageModel::getMessages($id);
		// dd($data);
		return view('app.message',['data'=>$data]);
	}

	//获取某产品全部评论
	public function productMessage ($id)
	{
		$data = MessageModel::getProduct($id);
		//dd($data);
		return view('app.productMessage',['data'=>$data]);
	}

	//获取待评论产品
	public function toComments ($id)
	{
		$data = OrderModel::getProducts($id);
		// dd($data);
		return view('app.toComment',['data'=>$data]);
	}
	//新增评论
	public function addComment (Request $request)
	{
		$param = $request->all();
		$user_id = Auth()->guard('pc')->user()->id;
		$name = Auth()->guard('pc')->user()->name;
		$data = ['product_id'=>$param['product_id'],'order_id'=>$param['order_id'],'content'=>$param['content'],'user_id'=>$user_id,'name'=>$name,'score'=>$param['score']];
		$res = MessageModel::addMessage($data);
		$status = ['status'=>1];
		OrderProductModel::where('order_id','=',$param['order_id'])->where('product_id','=',$param['product_id'])->update($status);
		//dd($param);
		return $res;

	}

	public function delOrder (Request $request)
	{
		$order_id = $request->input('id');
		$res = OrderModel::delOrder($order_id);
		if($res){
			return '删除成功';
		}else{
			return '删除失败';
		}
	}
}