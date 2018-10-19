<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common;
use App\Rules\RegisterRule;
use App\Rules\SignRule;
use App\Rules\EmailRule;
use App\Rules\AddressRule;
use App\Exceptions\ParamsException;
use App\Http\Model\UsersModel;
use App\Http\Model\MessageModel;
use App\Http\Model\OrderModel;
use App\Http\Model\UsersAddressModel;
use App\Http\Model\UsersInvoiceModel;
use Mail;
use App\Rules\IdRule;

class UserController extends Controller
{

    /**
     * 注册新用户接口
     * url  : api/user/newcomer
     * http : post
     */
    public function userRegister (Request $request)
    {


        //验证参数
        //$data = (new RegisterRule)->goCheck(200, true);

        //if (!empty($data)) return $data;

        $params = $_GET['id'];
        //dd($params);
        //email唯一
        $email = htmlspecialchars(strip_tags(trim($params['email'])));

        if (UsersModel::emailunique($email)) {

            $result = [
                'status' => false,
                'code' => 200,
                'data' => '邮箱已存在'
            ];
            $json = json_encode($result);

            return "my({$json})";

        }

        $token = Common::genrateToken();
        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'sex' => $params['sex'],
            'password' => bcrypt(htmlspecialchars(strip_tags(trim($params['password'])))),
            'email' => $email,
            'email_token' => $token
        ];

        //头像
        !empty($params['avatar']) ? $data['avatar'] = $params['avatar'] : '';


        //添加用户
        $res = UsersModel::getUserAdd($data);


        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '服务器内部错误'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }


        $this->sendEmail($res->id, $res->name, $res->email, $token);

        return Common::successData([], true);


    }


    /**
     * 用户登录接口
     * url  : api/user/newcomer
     * http : post
     */
    public function userSign (Request $request)
    {

        $data = (new SignRule)->goCheck(200, true);

        if (!empty($data)) return $data;


        $params = $request->all();

        $res = UsersModel::emailunique(htmlspecialchars(strip_tags(trim($params['email']))));

        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '账号不存在或密码不正确'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }
        //验证密码
        $user = \Hash::check(htmlspecialchars(strip_tags(trim($params['password']))), $res->password);

        if (!$user) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '账号不存在或密码不正确'
            ];
            $json = json_encode($result);

            return "my({$json})";

        }

        if ($res->status != 1) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '账号没有激活'
            ];
            $json = json_encode($result);

            return "my({$json})";

        }

        return Common::successData([
            'id' => $res->id,
            'name' => $res->name,
            'avatar' => $res->avatar,
            'integral' => $res->integral,
            'role' => $res->role
        ], true);
    }

    /**
     * 重新发送邮件接口
     * url  : api/user/newcomer
     * http : post
     */
    public function againSendEmail (Request $request)
    {
        $data = (new EmailRule)->goCheck(200, true);

        if (!empty($data)) return $data;

        $email = htmlspecialchars(strip_tags(trim($request->input('email'))));

        $res = UsersModel::emailunique($email);

        if (!$res) {

            $result = [
                'status' => false,
                'code' => 200,
                'data' => '账号不存在'
            ];
            $json = json_encode($result);

            return "my({$json})";


        }
        if ($res->status == 1) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '账号已经激活'
            ];
            $json = json_encode($result);

            return "my({$json})";

        }

        $token = str_replace("/", "1", Common::genrateToken());
        $data = UsersModel::updateUserInfo($res->id, ['email_token' => $token]);

        $this->sendEmail($res->id, $res->name, $res->email, $token);

        return Common::successData([], true);


    }

    //发送邮箱
    public function sendEmail ($id, $name, $email, $token)
    {

        // Mail::send()的返回值为空，所以可以其他方法进行判断
        //模板 变量 参数绑定Mail类的一个实例
        $token = config('custom.img_url')."/api/email/deal/$token";

        Mail::send('layouts.email', ['name' => $name, 'url' => $token, 'expire' => (config('custom.email_time') / 3600)], function ($message) use ($email) {

            $message->to($email)->subject('激活账号');
        });
        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) > 1) {
            UsersModel::delUser($id);
            Log::info("发送" . $email . "邮件失败");

        }
    }

    //点击邮箱回调
    public function emailDeal ($token)
    {


        //点击链接处理
        $find = UsersModel::getUser($token);

        if (!$find) {
            dd('token不存在');
        }
        $find = $find->toArray();

        //是否超时间
        if (time() > strtotime($find['updated_at']) + config('custom.email_time')) {

            dd('距离注册超过' . config('custom.email_time') . '秒');
        } else {
            //改变状态
            $res = UsersModel::updateUserInfo($find['id'], [
                'status' => 1
            ]);
            if (!$res) {
                $result = [
                    'status' => false,
                    'code' => 200,
                    'data' => '服务器内部错误'
                ];
                $json = json_encode($result);

                return "my({$json})";

            }

            dd('邮箱激活成功');
        }

    }


    /**
     * 上传用户地址信息接口
     * url  : api/user/address
     * http : post
     */
    public function aadAddress (Request $request)
    {


        $data = (new AddressRule)->goCheck(200, true);

        if (!empty($data)) return $data;

        $params = $request->all();

        if (empty($params['id'])) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '用户id不存在'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }

        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'mobile' => htmlspecialchars(strip_tags(trim($params['mobile']))),
            'province' => htmlspecialchars(strip_tags(trim($params['province']))),
            'city' => htmlspecialchars(strip_tags(trim($params['city']))),
            'default' => htmlspecialchars(strip_tags(trim($params['default']))),
            'country' => htmlspecialchars(strip_tags(trim($params['country']))),
            'detail' => htmlspecialchars(strip_tags(trim($params['detail']))),
            'zip' => htmlspecialchars(strip_tags(trim($params['zip']))),
            'users_id' => $params['id']
        ];

        //第一次添加 默认选中地址
        if(UsersAddressModel::where('users_id','=',$params['id'])->get()->isEmpty()) {

            $data['default'] = 1;

        } else {
            //名字不唯一
            $unquie = UsersAddressModel::unqiueName($params['id'], $params['name']);

            if ($unquie) {
                $result = [
                    'status' => false,
                    'code' => 200,
                    'data' => '收货人名字已经存在'
                ];
                $json = json_encode($result);

                return "my({$json})";
            }
            if ($data['default'] == 1) {
                UsersAddressModel::where('users_id', '=', $params['id'])->update(['default' => 2]);
            }

        }
        $res = UsersAddressModel::insertData($data);
        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '服务器内部错误'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }

        return Common::successData([], true);

    }

    /**
     * 获取用户地址信息接口
     * @param Request $request
     * @return mixed
     */
    public function addressList (Request $request)
    {


        $data = (new IdRule)->goCheck(200, true);

        if (!empty($data)) return $data;

        $id = $request->input('id');

        $res = UsersModel::getUserAddress($id);


        if (empty($res[0]['manys'])) {

            $result = [
                'status' => false,
                'code' => 200,
                'data' => '用户没有填写收货地址'
            ];
            $json = json_encode($result);

            return "my({$json})";

        }

        return Common::successData($res[0]['manys'], true);
    }

//地址修改页面获取数据
    public function updateAddress (Request $request)
    {
        $data = (new IdRule)->goCheck(200, true);

        $id = $request->input('id');

        $res = UsersAddressModel::where('id', '=', $id)->first();

        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '服务器内部错误'
            ];

            $json = json_encode($result);

            return "my({$json})";
        }

        return Common::successData($res, true);
    }

    /**
     * 获取某用户地址信息接口
     * @param Request $request
     * @return mixed
     */
    public function addressDetails (Request $request)
    {


        $data = (new IdRule)->goCheck(200, true);

        if (!empty($data)) return $data;

        $id = $request->input('id');

        $res = UsersAddressModel::where('users_id', '=', $id)->get();


        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '查询不到用户地址'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }
//dd($res);
        return Common::successData($res, true);
    }


    /**
     * 修改用户地址接口
     * @param Request $request
     * @return mixed
     */
    public function editAddress (Request $request)
    {

        $data = (new AddressRule)->goCheck(200, true);
        if (!empty($data)) return $data;

        $data = (new IdRule)->goCheck(200, true);
        if (!empty($data)) return $data;

        $params = $request->all();


        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'mobile' => htmlspecialchars(strip_tags(trim($params['mobile']))),
            'province' => htmlspecialchars(strip_tags(trim($params['province']))),
            'city' => htmlspecialchars(strip_tags(trim($params['city']))),
            'country' => htmlspecialchars(strip_tags(trim($params['country']))),
            'detail' => htmlspecialchars(strip_tags(trim($params['detail']))),
            'zip' => htmlspecialchars(strip_tags(trim($params['zip']))),

        ];

        //默认地址 其他地址修改成默认
        if (!empty($params['default'])) {
            $data['default'] = 1;
            $res = UsersAddressModel::updateData($params['id'], $data);
        } else {
            $res = UsersAddressModel::updateDataAddress($params['id'], $data);
        }

        return Common::successData($res, true);
    }

    /**
     * 删除用户地址接口
     * @param Request $request
     * @return mixed
     */
    public function delAddress (Request $request)
    {


        $data = (new IdRule)->goCheck(200, true);

        $id = $request->input('id');


        $res = UsersAddressModel::delAddress($id);

        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '服务器内部错误'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }

        return Common::successData($res, true);
    }

    /**
     *获取用户评论管理接口
     */
    public function showUserComment (Request $request)
    {

        $id = $request->input('id');

        $res = MessageModel::getreplyList($id);

        dd($res->toArray());
    }

    //pc我的评论
    public function message (Request $request)
    {
        $param = $request->all();
        $edit = ['see' => 1];
        $xx = MessageModel::where('user_id', $param['id'])->update($edit);
        $res = MessageModel::getMessages($param['id'])->toArray();
        if (!$res) {
            $result = [
                'status' => false,
                'code' => 200,
                'data' => '服务器内部错误'
            ];
            $json = json_encode($result);

            return "my({$json})";
        }
        // dd($res);
        return Common::successData($res, true);
    }

    //获取待评论产品
    public function toComments (Request $request)
    {

        (new IdRule)->goCheck(200);

        $id = $request->input('id');

        $data = OrderModel::getProducts($id);

        if (!$data) {
            throw new ParamsException([
                'message' => '订单已评论',
                'errorCode' => 7001
            ]);
        }

        return Common::successData($data);
    }

    //pc 获取用户全部评论接口
    public function personalComment (Request $request)
    {

        (new IdRule)->goCheck(200);

        $id = $request->input('id');

        $data = MessageModel::with(['reply', 'messageImg' => function ($query) {
            $query->select('id', 'product_image', 'en_name', 'zn_name')->with(['distributor']);
        }])->where('user_id', '=', $id)->get(['id', 'name', 'user_id', 'content', 'created_at', 'product_id']);

        return Common::successData($data);


    }

    /**
     *修改用户密码接口
     */
    public function check (Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');
        $check = Cache::get($email);
        //dd($check);
        if ($code != '') {
            if ($check == $code) {
                $passwd = bcrypt('123456');
                //dd($passwd);
                $data = ['password' => $passwd];
                $res = UsersModel::where('email', '=', $email)->update($data);
                //dd($res);
                if ($res) {
                    return '已重置密码,密码为123456';
                } else {
                    return '该用户不存在';
                }
                return '修改失败,请重试';
            } else {
                return '验证码错误,请重试';
            }
        } else {
            return '验证码不能为空';
        }
    }

    /**
     * 获取用户发票地址接口
     * @param  string $uid 用户ID
     * @param  string $uProducts 数据库商品信息
     * @return $order 订单号
     */
    public function billAddress (Request $request)
    {
        (new IdRule)->goCheck(200);
        $id = $request->input('id');

        $data = UsersInvoiceModel::where('users_id', '=', $id)->first();

        return Common::successData($data);


    }


    /**
     * 修改用户发票地址接口
     * @param Request $request
     * @return mixed
     */
    public function editBillAddress (Request $request)
    {

        (new IdRule)->goCheck(200);
        (new AddressRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'mobile' => htmlspecialchars(strip_tags(trim($params['mobile']))),
            'province' => htmlspecialchars(strip_tags(trim($params['province']))),
            'city' => htmlspecialchars(strip_tags(trim($params['city']))),
            'country' => htmlspecialchars(strip_tags(trim($params['country']))),
            'detail' => htmlspecialchars(strip_tags(trim($params['detail']))),
            'zip' => htmlspecialchars(strip_tags(trim($params['zip']))),

        ];

        $res = UsersInvoiceModel::updateDataAddress($params['id'], $data);

        if (!$res) {

            throw new ParamsException([
                'message' => '服务器内部错误',
                'errorCode' => 7001
            ]);
        }
        return Common::successData();
    }

    /**
     * 上传用户地址信息接口
     * url  : api/user/address
     * http : post
     */
    public function insertAddress (Request $request)
    {
        (new IdRule)->goCheck(200);
        (new AddressRule)->goCheck(200);

        $params = $request->all();

        //拼接数据
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['name']))),
            'mobile' => htmlspecialchars(strip_tags(trim($params['mobile']))),
            'province' => htmlspecialchars(strip_tags(trim($params['province']))),
            'city' => htmlspecialchars(strip_tags(trim($params['city']))),
            'country' => htmlspecialchars(strip_tags(trim($params['country']))),
            'detail' => htmlspecialchars(strip_tags(trim($params['detail']))),
            'zip' => htmlspecialchars(strip_tags(trim($params['zip']))),
            'users_id' => $params['id']
        ];

        $res = UsersInvoiceModel::insertData($data);

        if (!$res) {

            throw new ParamsException([
                'message' => '服务器内部错误',
                'errorCode' => 7001
            ]);
        }

        return Common::successData();

    }

}
