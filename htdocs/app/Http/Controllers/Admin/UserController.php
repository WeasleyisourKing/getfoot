<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\UsersModel;
use App\Http\Model\AdminModel;
use App\Http\Model\UsersRoleModel;
use App\Http\Model\AdminRoleModel;
use App\Http\Controllers\Common;
use App\Rules\IdRule;
use App\Rules\UserInfoRule;
use App\Rules\IdAndRoleRule;
use App\Rules\ManagerInfoRule;
use App\Exceptions\ParamsException;

/**
 * 用户管理类
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{

    /**
     * 用户列表页面
     * @param Request $request
     * @return mixed
     */
    public function userList ($status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];


        $res = UsersModel::getUserList($statusData, $limit);


        $arr = UsersRoleModel::get();
        return view('admin.user.user-user', [
            'arr' => $arr,
            'data' => $res,
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '激活' : '不激活'),
            'limit' => '显示' . $limit . '条'
        ]);

    }

    /**
     * 管理员列表页面
     * @param Request $request
     * @return null
     */
    public function managerList ($type,$status, $limit)
    {

        $statusData = ($status != -1) ? [$status] : [1, 2];

        //取全部数据
        if ($type == -1 ) {

            $res = AdminModel::getList($statusData, $limit);
        } else {
            $res = AdminModel::getLists($type,$statusData, $limit);
        }

        $role = AdminRoleModel::get();

        //数据 类型  标题 状态
        return view('admin.user.user-admin', [
            'data' => $res,
            'type' => $type == -1 ? '全部角色' : ($type == 1 ? '供货商' : '仓库管理员'),
            'status' => $status == -1 ? '全部状态' : ($status == 1 ? '可用' : '禁用'),
            'role' => $role,
            'limit' => '显示' . $limit . '条'
        ]);

    }



//    /**
//     * 添加用户页面
//     * @param Request $request
//     * @return mixed
//     */
//    public function userInsert ()
//    {
//
//        $res = UsersRoleModel::getRole();
//        //数据 类型 标题 状态
//        return view('admin.user.foundUser', ['arr' => $res]);
//    }

    /**
     * 用户角色列表页面
     * @param Request $request
     * @return mixed
     */
    public function userRole ($limit)
    {

        $res = UsersRoleModel::getRole($limit);
        //数据 类型 标题 状态
        return view('admin.user.user-role', ['data' => $res, 'limit' => '显示' . $limit . '条']);
    }

    /**
     * 管理员角色列表页面
     * @param Request $request
     * @return mixed
     */
    public function managerRole ($limit)
    {

        $res = AdminRoleModel::getRole($limit);
        //数据 类型 标题 状态
        return view('admin.user.user-admin-role', ['data' => $res, 'limit' => '显示' . $limit . '条']);
    }
//    /**
//     * 添加用户页面
//     * @param Request $request
//     * @return mixed
//     */
//    public function userAppend ()
//    {
//
//        $res = UsersRoleModel::getRole();
//        //数据 类型 标题 状态
//        return view('admin.user.foundRole', ['arr' => $res]);
//    }


    /**
     * 获取用户地址信息接口
     * @param Request $request
     * @return mixed
     */
    public function addressList (Request $request)
    {

        (new IdRule)->goCheck(200);

        $id = $request->input('id');

        $res = UsersModel::getUserAddress($id);


        if (empty($res[0]['manys'])) {

            throw new ParamsException([
                'code' => 200,
                'message' => '用户没有填写收货地址'
            ]);
        }

        return Common::successData($res[0]['manys']);
    }


    /**
     * 获取用户订单接口
     * @param Request $request
     * @return mixed
     */
    public function orderList (Request $request)
    {
        (new IdRule)->goCheck(200);

        $id = $request->input('id');

        $res = UsersModel::getUserOrder($id);


        return Common::successData(
            Common::screen($res[0]['oreder_manys'], ['order_no', 'total_price', 'status', 'total_count', 'created_at'])
        );
    }

    /**
     * //创建用户接口
     * @param Request $request
     * @return mixed
     */
    public function userAdd (Request $request)
    {

        (new UserInfoRule)->goCheck(200);

        $params = $request->all();

        $email = htmlspecialchars(strip_tags(trim($params['email'])));

        if (UsersModel::emailunique($email)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '邮箱已存在'
            ]);
        }

        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'email' => $email,
//            'integral' => htmlspecialchars(strip_tags(trim($params['integral']))),
            'sex' => $params['sex'],
            'role' => $params['role'],
            'password' => bcrypt($params['password']),
            'status' => 1
        ];

        //添加用户
        $res = UsersModel::getUserAdd($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //修改用户接口
     * @param Request $request
     * @return mixed
     */
    public function userUpdate (Request $request)
    {

        (new UserInfoRule)->goCheck(200);

        $params = $request->all();


        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'email' => htmlspecialchars(strip_tags(trim($params['email']))),
            'integral' => htmlspecialchars(strip_tags(trim($params['integral']))),
            'sex' => $params['sex'],
            'role' => $params['role'],
            'status' => 1
        ];

        if (!empty($params['password'])) {
            $data['password'] = bcrypt($params['password']);
        }
        if (!empty($params['img_id'])) {
            $data['avatar'] = is_array($params['img_id']) ? $params['img_id'][0][0] : $params['img_id'];
        }

        //添加用户
        $res = UsersModel::updateUserInfo($params['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //删除用户接口
     * @param Request $request
     * @return mixed
     */
    public function userDel (Request $request)
    {

        $id = $request->input('id');

        $res = UsersModel::delUser($id);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }


    /**
     * //修改用户角色接口
     * @param Request $request
     * @return mixed
     */
    public function userRoleUpdate (Request $request)
    {

        (new IdAndRoleRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name'])))
        ];

        //添加用户
        $res = UsersRoleModel::updateUsersRole($request['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }


    /**
     * 添加用户角色接口
     * @param Request $request
     * @return mixed
     */
    public function userRoleAppend (Request $request)
    {

        (new IdAndRoleRule)->goCheck(200);

        $name = $request->input('name');

        //角色应该唯一
        if (UsersRoleModel::roleIsExist($name)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '用户角色已经存在'
            ]);
        }
        $res = UsersRoleModel::insertRole(['name' => $name]);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }
        return Common::successData();
    }

    /**
     * //删除用户角色接口
     * @param Request $request
     * @return mixed
     */
    public function userRoleDel (Request $request)
    {

        $id = $request->input('id');

        $res = UsersRoleModel::delRole($id);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //获取用户角色接口
     * @param Request $request
     * @return mixed
     */
    public function role ()
    {
        $res = UsersRoleModel::get();

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
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
        if (!empty($password = htmlspecialchars(strip_tags(trim($params['passwd']))))) {
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
     * //删除管理员接口
     * @param Request $request
     * @return mixed
     */
    public function managerDel (Request $request)
    {

        $id = $request->input('id');

        $res = AdminModel::delAdmin($id);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * 添加管理员角色接口
     * @param Request $request
     * @return null
     */
    public function managerAdd (Request $request)
    {

        (new IdAndRoleRule)->goCheck(200);

        $name = $request->input('name');

        //角色应该唯一
        if (AdminRoleModel::roleIsExist($name)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '管理员角色已经存在'
            ]);
        }
        $res = AdminRoleModel::insertRole(['name' => $name]);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }
        return Common::successData();
    }

    /**
     * //修改管理员角色接口
     * @param Request $request
     * @return mixed
     */
    public function managerRoleUpdate (Request $request)
    {

        (new IdAndRoleRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name'])))
        ];

        //添加用户
        $res = AdminRoleModel::updateUsersRole($request['id'], $data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //删除管理员角色接口
     * @param Request $request
     * @return mixed
     */
    public function managerRoleDel (Request $request)
    {

        $id = $request->input('id');

        $res = AdminRoleModel::delRole($id);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();
    }

    /**
     * //获取用户角色接口
     * @param Request $request
     * @return mixed
     */
    public function Administrators ()
    {

        $res = AdminRoleModel::get();

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData($res);
    }


}
