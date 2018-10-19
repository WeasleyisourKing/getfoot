<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\AdminModel;
use App\Rules\PasswordRule;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;

/**
 * 后台登录验证类
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class LoginController extends Controller
{

    /**
     * 登录验证
     * @param Request $request
     * @return null
     */
    public function postLogin (Request $request)
    {

        //输入过滤 防止xss和sql注入
        $name = htmlspecialchars(strip_tags(trim($request->input('username'))));
        $password = htmlspecialchars(strip_tags(trim($request->input('password'))));


        //验证不通过
        if (!Auth()->attempt(['username' => $name, 'password' => $password, 'status' => 1])) {

            //跳转 获取旧数据（除了密码）
            return redirect('login')->withInput($request->except('password'))->with('msg', '用户名或者密码错误');
        } else {

            //写入信息
            $this->RecordInformation();
            //跳转后台仪表盘
            return redirect('/dashboard');

        }

    }

    //写入最后登录ip 登录时间
    public function RecordInformation ()
    {
        $data = [];
        if (getenv('HTTP_CLIENT_IP')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR')) {
            $onlineip = getenv('REMOTE_ADDR');
        } else {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        $data = [
            'last_ip' => $onlineip,
            'login_time' => date('Y-m-d H:i:s',time())
        ];

        AdminModel::updateIpAndLoginTime(Auth()->id(),$data);
    }

    /**
     * 修改admin密码
     */
    public function adminUpdate (Request $request)
    {
        (new PasswordRule)->goCheck(200);

        $param = $request->all();

        //验证不通过
        $checkUserId = Auth()->attempt(['username' => 'admin', 'password' => $param['oldPasswd']]);

        if (!$checkUserId) {
            throw new ParamsException([
                'code' => 200,
                'message' => '原始密码不正确'
            ]);
        }

        $res = AdminModel::modifyAdmin(bcrypt($param['newPasswd']));

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();

    }

}

