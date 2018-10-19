<?php

namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\AdminModel;
use App\Http\Model\UsersModel;
use App\Http\Model\MessageModel;
use App\Rules\PasswordRule;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use App\Rules\RegisterRule;
use App\Http\Controllers\Api\UserController;
use App\Rules\EmailRule;
use Hash;
use Mail;
use Cache;

/**
 * 前台登录验证类
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
        $email = htmlspecialchars(strip_tags(trim($request->input('email'))));
        $password = htmlspecialchars(strip_tags(trim($request->input('password'))));

        //查询不到
        if (!Auth()->guard("pc")->attempt(['email' => $email, 'password' => $password])) {
            //跳转 获取旧数据（除了密码）
            Auth()->guard("pc")->logout();
            return redirect('/apps/login')->withInput($request->except('password'))->with('msg', '用户名或者密码错误');

        }

        if (Auth()->guard('pc')->user()->status != 1) {
            Auth()->guard("pc")->logout();
            return redirect('/apps/login')->withInput($request->except('password'))->with('email', $email);
        } else {
            //跳转后台仪表盘
            return redirect('/apps');

        }

    }

    /**
     * 注册验证
     * @param Request $request
     * @return null
     */
    public function Register (Request $request)
    {

        //验证参数
        (new RegisterRule)->goCheck(200);

        $params = $request->all();

        //email唯一
        $email = htmlspecialchars(strip_tags(trim($params['email'])));

        if (UsersModel::emailunique($email)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '邮箱已经注册过'
            ]);

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
            throw new \Exception('服务器内部错误');
        }

        (new UserController)->sendEmail($res->id, $res->name, $res->email, $token);

        return Common::successData();


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

    /**
     * 修改账户信息
     */
    public function userUpdate (Request $request)
    {
        $id = Auth()->guard("pc")->user()->id;
        $res = UsersModel::getUserInfo($id);

        return view('app.account', ['data' => $res->toArray()]);
    }

    /**
     * 修改个人信息
     */
    public function UpdatePersonal (Request $request)
    {

        $img = $request->file('img');
        if (empty($img)) {

            if (!is_null($request['name']) && mb_strlen($request['name'], 'UTF-8') < 9) {
                $id = Auth()->guard("pc")->user()->id;
                $data = ['name' => $request['name']];
                MessageModel::where('user_id', $id)->update($data);
                $res = UsersModel::where('id', $id)->update($data);
                if ($res) {
                    return redirect('/apps/user/' . $id)->with('msg', '修改成功');
                } else {
                    return redirect('/apps/user/' . $id)->with('msg', '修改失败');
                }

            } else {

                return redirect('apps/account')->with('msg', '您没有输入任何信息或者名字长度超过8个字符');
            }

        }

        // 文件是否上传成功
        if (!$img->isValid()) {
            return response()->json([
                'errno' => 1,
                'data' => [
                    '文件上传失败'
                ]
            ]);
        }


        //图片上传大小不能超1m
//        if (  $img->getClientSize() > 563200) {
//            return redirect('apps/account')->with('msg', '图片不能超过500KB');
//
//        }

        //后缀名
        $ext = $img->getClientOriginalExtension();
        $fileTypes = ['png', 'jpg', 'gif', 'jpeg', 'heif', 'HEIF'];

        if (!in_array($ext, $fileTypes)) {
            return redirect('apps/account')->with('msg', '文件格式不正确');
        } else {
            // 上传文件名称
            $imgName = $img->getClientOriginalName();

            //文件目录
            $filePath = config('custom.file_path');

            // 移动到框架应用根目录/uploads/目录下 文件名不变 同名覆盖
            $img->move($filePath . config('custom.DIRECTORY_SEPARATOR'), $imgName);
            $url = '/uploads/' . $imgName;
            $name = $request['name'] == null ? Auth()->guard("pc")->user()->name : $request['name'];
            $id = Auth()->guard("pc")->user()->id;
            $data = ['avatar' => $url, 'name' => $name];
            $res = UsersModel::where('id', $id)->update($data);
            if ($res) {
                return redirect('apps/account')->with('msg', '修改成功');
            } else {
                return redirect('apps/account')->with('msg', '修改失败');
            }
        }

    }


    /**
     * 修改user密码
     */
    public function userPasswd (Request $request)
    {
        return view('app.password');
    }

    public function euserPasswd (Request $request)
    {
        $param = $request->all();
        //dd($param);
        if (Hash::check($param['oldPasswd'], Auth()->guard("pc")->user()->password)) {
            if ($param['newPasswd'] == $param['newPasswd2']) {
                $id = Auth()->guard("pc")->user()->id;
                $newpasswd = bcrypt($param['newPasswd']);
                $data = ['password' => $newpasswd];
                $res = UsersModel::where('id', $id)->update($data);
                return redirect('/apps/password')->with('msg', '修改成功');
            } else {
                return redirect('/apps/password')->with('msg', '新密码不匹配,请重输');
            }
        } else {
            return redirect('/apps/password')->with('msg', '原密码不正确,请重输入');
        }
    }


    //user表忘记密码
    public function usendEmail ($email)
    {

        // Mail::send()的返回值为空，所以可以其他方法进行判断
        //模板 变量 参数绑定Mail类的一个实例
        //dd($token);  
        $number = '';
        for ($i = 0; $i < 5; $i++) {
            $number .= mt_rand(0, 9);
        }

        Mail::send('layouts.forget', ['number' => $number], function ($message) use ($email) {

            $message->to($email)->subject('忘记密码');
        });


        // 返回的一个错误数组，利用此可以判断是否发送成功
        if (count(Mail::failures()) > 1) {

            Log::info("重置密码" . $email . "邮件失败");

            throw new ParamsException([
                'code' => 200,
                'message' => '发送邮件失败，请重试'
            ]);
        } else {

            //写入缓存 min
            Cache::put($email, $number, 31);

        }
    }

    public function rebuild (Request $request)
    {

        $email = $request->input('email');

        if (!UsersModel::where('email', '=', $email)->first()) {
            throw new ParamsException([
                'code' => 200,
                'message' => '用户不存在'
            ]);
        }
        if (Cache::has($email)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '已经发送邮件'
            ]);
        }
        $this->usendEmail($email);

        return Common::successData();
    }

//验证码
    public function check (Request $request)
    {
        $email = $request->input('email');
//        dd($email);
        $code = $request->input('code');
        if (is_null($email) || is_null($code)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '邮件不能为空或者验证码不能为空'
            ]);
        }

        if (!UsersModel::where('email', '=', $email)->first()) {
            throw new ParamsException([
                'code' => 200,
                'message' => '用户不存在'
            ]);
        }

        if (!Cache::has($email)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '验证码时间已过30分钟或者失效，请重新发送'
            ]);
        }


        if (Cache::get($email) != $code) {
            throw new ParamsException([
                'code' => 200,
                'message' => '验证码错误'
            ]);
        } else {
            $res = UsersModel::where('email', '=', $email)->update(['password' => bcrypt('123456')]);
            if (!$res) {
                throw new ParamsException([
                    'message' => '服务器内部错误',
                    'errorCode' => 7001
                ]);
            } else {
                Cache::forget($email);
                return Common::successData('已重置密码,密码为123456');
            }

        }

    }

}

