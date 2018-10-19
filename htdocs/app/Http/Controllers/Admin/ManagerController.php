<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\AdminModel;
use App\Http\Controllers\Common;
use App\Rules\ManagerInfoRule;

/**
 * 管理员管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class ManagerController extends Controller
{

    /**
     * 管理员列表页面
     * @param Request $request
     * @return null
     */
    public function index ($type, $status)
    {

        //默认显示供货商
        switch ($type) {
            case 1 :
                $title = '供货商管理员';
                $res = AdminModel::getList($type, $status);
                break;
            case 2 :
                $title = '分销商管理员';
                $res = AdminModel::getList($type, $status);
                break;
            default :
                $title = '仓库管理员';
                $res = AdminModel::getList($type, $status);
        }

        //数据 类型 标题 状态
        return view('admin.manager.index', ['data' => $res, 'type' => $type, 'title' => $title, 'status' => $status]);

    }

    /**
     * 修改管理员信息接口
     * @param Request $request
     * @return null
     */
    public function managerModify (Request $request)
    {

        (new ManagerInfoRule)->goCheck(200);
        $params = $request->all();

        //拼接信息
        $data = [];
        $data = [
            'username' => htmlspecialchars(strip_tags(trim($params['name']))),
            'role' => $params['role'],
            'status' => $params['status']
        ];

        //修改了密码
        if (!Empty($password = htmlspecialchars(strip_tags(trim($params['passwd']))))) {
            $data['password'] = bcrypt($password);
        }

        //修改信息
        $res = AdminModel::updateAdminInfo($params['id'], $data);

        if (!$res) {
            throw new ParamsException([
                'code' => 200,
                'message' => '内容没有修改'
            ]);
        }
        return Common::successData();
    }

    /**
     * 添加管理员页面
     * @param Request $request
     * @return null
     */
    public function managerAdd ()
    {
        return view('admin.manager.add');
    }

    /**
     * 添加管理员接口
     * @param Request $request
     * @return null
     */
    public function managerInsert (Request $request)
    {

        (new ManagerInfoRule)->goCheck(200);
        $params = $request->all();

        //拼接信息
        $data = [];
        $data = [
            'username' => htmlspecialchars(strip_tags(trim($params['name']))),
            'role' => $params['role'],
            'status' => $params['status'],
            'password' => bcrypt($params['password'])
        ];
        //插入信息
        $res = AdminModel::insertAdminInfo($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }
        return Common::successData();

    }

    /**
     * 搜索用户留言
     * @param Request $request
     *  @return json
     */
    public function managerSearch (Request $request)
    {
        //过滤输入
        $value = htmlspecialchars(strip_tags(trim($request->input('value'))));


        if (empty($value)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索值不能为空'
            ]);
        }
        $res = AdminModel::getSearch($value);

        return Common::successData($res);
    }
}

