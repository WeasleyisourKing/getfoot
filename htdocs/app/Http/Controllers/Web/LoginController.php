<?php

namespace App\Http\Controllers\Web;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\AdminModel;
use App\Http\Model\UsersModel;
use App\Http\Model\CategoryModel;
use App\Http\Model\MessageModel;
use App\Http\Model\UsersAddressModel;
use App\Rules\PasswordRule;
use App\Exceptions\ParamsException;
use App\Http\Controllers\Common;
use App\Rules\RegisterRule;
use App\Http\Controllers\Api\UserController;
use App\Rules\EmailRule;
use Hash;

/**
 * 前台登录验证类
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class LoginController extends Controller
{

    /**
     * 注册验证
     * @param Request $request
     * @return null
     */
    public function postLogin (Request $request)
    {

        //输入过滤 防止xss和sql注入
        $email = htmlspecialchars(strip_tags(trim($request->input('email'))));
        $password = htmlspecialchars(strip_tags(trim($request->input('password'))));


        //查询不到
        if (!Auth()->guard("pc")->attempt(['email' => $email, 'password' => $password ])) {
            //跳转 获取旧数据（除了密码）
            Auth()->guard("pc")->logout();
            return redirect('users')->withInput($request->except('password'))->with('msg', '用户名或者密码错误');
        }

        if (Auth()->guard('pc')->user()->role == 1) {
            Auth()->guard("pc")->logout();
            return redirect('users')->withInput($request->except('password'))->with('msg', '用户名或者密码错误');
        }

        if (Auth()->guard('pc')->user()->status != 1) {

            Auth()->guard("pc")->logout();
            return redirect('users')->withInput($request->except('password'))->with('email', $email);
        } else {
            //跳转后台仪表盘
            return redirect('/');

        }

    }

    /**
     * 登录验证
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

        $data = UsersModel::emailunique($email);


        //存在 已经注册
        if (UsersModel::emailunique($email)) {

            throw new ParamsException([
                'code' => 200,
                'message' => '邮箱已经注册过'
            ]);

        }


        $token = str_replace("/", "1", Common::genrateToken());
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
     * 重新发送邮件接口
     * url  : api/user/newcomer
     * http : post
     */
    public function againSendEmail (Request $request)
    {
        (new EmailRule)->goCheck(200);

        $email = htmlspecialchars(strip_tags(trim($request->input('email'))));

        $res = UsersModel::emailunique($email);

        if (!$res) {

            throw new ParamsException([
                'code' => 200,
                'message' => '账号不存在'
            ]);

        }
        if ($res->status == 1) {

            throw new ParamsException([
                'code' => 200,
                'message' => '账号已经激活'
            ]);

        }
        $token = str_replace("/", "1", Common::genrateToken());

        $data = UsersModel::updateUserInfo($res->id, ['email_token' => $token]);

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

    public function personal()
    {
  
        $id = Auth()->guard("pc")->user()->id;
        $user = UsersAddressModel::getUserAddress($id);
        // dd($user);
        $categorys = Common::getTree(CategoryModel::getTwoCategory(),0);

        return view('web.personal',['category'=>$categorys,'user'=>$user]);
    }

        /**
     * 修改个人信息
     */
    public function UpdatePersonal (Request $request)
    {

        $img = $request->file('img');
        // dd($img);
        if (empty($img)) {

            if (!is_null($request['name']) && mb_strlen($request['name'], 'UTF-8') < 9) {
                $id = Auth()->guard("pc")->user()->id;
                $data = ['name' => $request['name']];
                MessageModel::where('user_id', $id)->update($data);
                $res = UsersModel::where('id', $id)->update($data);
      
                if ($res) {
                    return redirect('/personal')->with('msg', '修改成功');
                    // ;
                } else {
                    return redirect('/personal')->with('msg', '修改失败');
                }

            } else {

                return redirect('/personal')->with('msg', '您没有输入任何信息或者名字长度超过8个字符');
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
            return redirect('personal')->with('msg', '文件格式不正确');
        } else {
            // 上传文件名称
            $imgName = $img->getClientOriginalName();

            //文件目录
            $filePath = config('custom.file_path');
            $houzhui = substr(strrchr($imgName, '.'),1);
            $result = bcrypt(basename($imgName,".".$houzhui));
            // dump($result);
            // 移动到框架应用根目录/uploads/目录下 文件名不变 同名覆盖
            $asd = $img->move($filePath . config('custom.DIRECTORY_SEPARATOR'),$result . "." . $houzhui);
            // dd($asd);
            $url = '/uploads/' . $result . "." . $houzhui;
            // dd($asd,$url);
            $name = $request['name'] == null ? Auth()->guard("pc")->user()->name : $request['name'];
            $id = Auth()->guard("pc")->user()->id;
            $data = ['avatar' => $url, 'name' => $name];
            $res = UsersModel::where('id', $id)->update($data);
            //dd($res);
            if ($res) {
                return redirect('/personal')->with('msg', '修改成功');
            } else {
                return redirect('/personal')->with('msg', '修改失败');
            }
        }

    }

    //pc 修改密码
    public function euserPasswd (Request $request)
    {
        $param = $request->all();
        if (Hash::check($param['oldPasswd'], Auth()->guard("pc")->user()->password)) {
            if ($param['newPasswd'] == $param['newPasswd2']) {
                $id = Auth()->guard("pc")->user()->id;
                $newpasswd = bcrypt($param['newPasswd']);
                $data = ['password' => $newpasswd];
                $res = UsersModel::where('id', $id)->update($data);
                return redirect('/personal')->with('msg', '修改成功');
            } else {
                return redirect('/personal')->with('msg', '新密码不匹配,请重输');
            }
        } else {
            return redirect('/personal')->with('msg', '原密码不正确,请重输入!');
        }
    }


}

