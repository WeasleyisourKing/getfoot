<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\UsersModel;
use App\Http\Model\ArticleModel;
use App\Http\Model\ExpertsModel;
use App\Http\Model\CalendarModel;
use App\Http\Model\MessageModel;
use App\Http\Model\ReplyModel;
use App\Http\Model\AdminModel;
use App\Http\Controllers\Common;
use App\Exceptions\ParamsException;
use App\Rules\addCaseRule;
use App\Rules\addExpertRule;
use App\Rules\updateCalendarRule;
use App\Rules\PasswordRule;
use App\Rules\ReplyRule;

class MyController extends Controller
{

    /**
     * 登录验证
     * @param Request $request
     * @return
     */
    public function postLogin (Request $request)
    {

        $name = $request->input('username');
        $password = $request->input('password');

        //验证不通过
        if (!Auth()->attempt(['username' => $name, 'password' => $password])) {

            //跳转 获取旧数据（除了密码）
            return redirect('login')->withInput($request->except('password'))->with('msg', '用户名或密码错误');
        } else {

            //跳转用户管理
            return redirect('/users/status/2');

        }

    }


    /**
     * 用户管理
     * @param $status
     * @return
     */
    public function userList ($status)
    {

        if (!empty($status) && (int)$status == 1) {
            //显示会员
            $start = $end = 1;
            $status = 1;
        } else {
            $start = $status = 2;
            $end = 3;

        }
        $res = UsersModel::getUserList($start, $end);
        return view('admin/users', ['data' => $res, 'status' => $status]);

    }

    /**
     * 获取用户详细信息
     */
    public function userdetaile (Request $request)
    {
        $id = $request->input('id');
        $res = UsersModel::getUserdetaile($id);

        return Common::successData($res);

    }

    /**
     * 搜索用户信息
     */
    public function search (Request $request)
    {
        //过滤输入
        $value = htmlspecialchars(strip_tags(trim($request->input('value'))));


        if (empty($value)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索值不能为空'
            ]);
        }
        $res = UsersModel::getSearch($value);

        return Common::successData($res);
    }

    /**
     * 搜索案例信息
     */
    public function searchCase (Request $request)
    {
        //过滤输入
        $value = htmlspecialchars(strip_tags(trim($request->input('value'))));

        if (empty($value)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索值不能为空'
            ]);
        }
        $res = ArticleModel::getSearch($value);

        return Common::successData($res);
    }

    /**
     * 案例列表
     */
    public function case ($type, $status)
    {
        //默认显示黑马速配
        switch ($type) {
            case 1 :
                $title = '黑马速配';
                $res = ArticleModel::getList($type, $status);
                break;
            case 2 :
                $title = '黑马智库';
                $res = ExpertsModel::getData($status);
                break;
            default :
                $title = '黑马游学';
                $res = ArticleModel::getList($type, $status);
        }

        //数据 类型 标题 状态
        return view('admin/case', ['data' => $res, 'type' => $type, 'title' => $title, 'status' => $status]);

    }

    /**
     * 获取速配、智库、游学案例信息
     */
    public function editorCase ($id)
    {
        $res = ArticleModel::getInfoById($id);
        $arr = [];
        $arr = [
            '1' => '黑马速配',
            '2' => '黑马智库',
            '3' => '黑马游学'
        ];

        return view('admin/caseInfo', ['data' => $res, 'arr' => $arr]);
    }

    /**
     * 保存速配案例案例
     */
    public function caseModify (Request $request)
    {
        (new addCaseRule)->goCheck(200);
        $params = $request->all();

        //pulse在福利中 不能修改

        if ($params['id'] == 1 && $params['category'] != 7) {

            throw new ParamsException([
                'code' => 200,
                'message' => 'pulse这篇文章必须在黑马福利中'
            ]);
        }
        //构造插入数据
        $data = [];
        $data = [
            'title' => htmlspecialchars(strip_tags(trim($params['title']))),
            'summary' => htmlspecialchars(strip_tags(trim($params['summary']))),
            'content_html' => $params['contentHtml'],
            'status' => htmlspecialchars(strip_tags(trim($params['show']))),
            'c_id' => htmlspecialchars(strip_tags(trim($params['category']))),
            'belong' => $params['id'] != 1 ? -1 : -2
        ];
        //智库
        if ($params['category'] == 2) {
            $data['belong'] = $params['expert'];
        }

        //游学
        if ($params['category'] == 3) {
            $data['type'] = $params['type'];
            $data['create_time'] = strtotime($params['date']);
            //付费
            if ($params['type'] == 1) {
                if (!empty($params['price'])  && ((is_numeric($params['price']) && ($params['price'] + 0) > 0)) && ((strstr($params['price'],'.')) == false || strlen(strstr($params['price'],'.')) <= 3 )) {
                   if ($params['price'] > 999999.99) {
                       throw new ParamsException([
                           'code' => 200,
                           'message' => '活动报名金额不能超过百万'
                       ]);
                   }
                    $data['price'] = $params['price'];
                } else {
                    throw new ParamsException([
                        'code' => 200,
                        'message' => '活动报名金额不正确'
                    ]);
                }
            } else {
                $data['price'] = 0;
            }
        }

        $res = ArticleModel::updateUserInfo($params['id'], $data);

        if (!$res) {
            throw new ParamsException([
                'code' => 200,
                'message' => '内容没有修改'
            ]);
        }
        return Common::successData();

    }

    /**
     * //获取某专家案例列表
     */
    public function expertList (Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        //默认显示发布的
        !empty($status) ? '' : $status = 1;
        $res = ArticleModel::expertCase($id, $status);
        return Common::successData($res);
    }

    /**
     * 获取智库专家某案例信息
     */
    public function expert ($id)
    {
        $res = ExpertsModel::getInfoById($id);
        $arr = [];
        $arr = [
            '1' => '黑马速配',
            '2' => '黑马智库',
            '3' => '黑马游学'
        ];

        return view('admin/expert', ['data' => $res, 'arr' => $arr]);
    }

    /**
     * 保存专家信息
     */
    public function expertModify (Request $request)
    {

        (new addExpertRule)->goCheck(200);
        $params = $request->all();
        $data = [];
        $data = [
            'name' =>  htmlspecialchars(strip_tags(trim($params['title']))),
            'summary' => htmlspecialchars(strip_tags(trim($params['summary']))),
            'status' => htmlspecialchars(strip_tags(trim($params['show']))),
            'head_url' => is_array($params['img']) ? $params['img'][0] : $params['img']
        ];

        $res = ExpertsModel::updateExpertInfo($params['id'], $data);

        if (!$res) {
            throw new ParamsException([
                'code' => 200,
                'message' => '内容没有修改'
            ]);
        }
        return Common::successData();

    }

    /**
     * 显示添加案例页面
     */
    public function addCase ()
    {
        return view('admin/add');
    }

    /**
     * 添加专家
     */
    public function addExpert ()
    {
        return view('admin/addExpert');
    }


    /**
     * 获取全部专家
     */
    public function getExpertAll ()
    {
        $res = ExpertsModel::getAllExpert();
        return Common::successData($res);
    }


    /**
     * 新建案例
     */
    public function insertCase (Request $request)
    {

        (new addCaseRule)->goCheck(200);
        $params = $request->all();

        //构造插入数据
        $data = [];
        $data = [
            'title' => htmlspecialchars(strip_tags(trim($params['title']))),
            'summary' => htmlspecialchars(strip_tags(trim($params['summary']))),
            'content_html' => $params['contentHtml'],
            'status' => htmlspecialchars(strip_tags(trim($params['show']))),
            'c_id' => htmlspecialchars(strip_tags(trim($params['category']))),
            'create_time' => time()
        ];
        //智库
        if ($params['category'] == 2) {
            $data['belong'] = $params['expert'];
        }
        //游学
        if ($params['category'] == 3) {
            $data['type'] = $params['type'];
            $data['create_time'] = strtotime($params['date']);
            //付费
            if ($params['type'] == 1) {
                if (!empty($params['price'])  && ((is_numeric($params['price']) && ($params['price'] + 0) > 0)) && ((strstr($params['price'],'.')) == false || strlen(strstr($params['price'],'.')) <= 3 )) {
                    if ($params['price'] > 999999.99) {
                        throw new ParamsException([
                            'code' => 200,
                            'message' => '活动报名金额不能超过百万'
                        ]);
                    }
                    $data['price'] = $params['price'];
                } else {
                    throw new ParamsException([
                        'code' => 200,
                        'message' => '活动报名金额不正确'
                    ]);
                }
            } else {
                $data['price'] = 0;
            }
        }

        //案例名称是否唯一
        $unique = ArticleModel::caseUnique($params['category'], $params['title']);

        if ($unique) {
            throw new ParamsException([
                'code' => 200,
                'message' => '案例标题已经存在'
            ]);
        }

        $res = ArticleModel::insertCaseInfo($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }
        return Common::successData();

    }


    /**
     * 新建专家
     */
    public function insertexpert (Request $request)
    {

        (new addExpertRule)->goCheck(200);
        $params = $request->all();
        $e = (new ExpertsModel)->where('name','=',$params['title'])->first();

        if ($e) {
            throw new ParamsException([
                'code' => 200,
                'message' => '专家已经存在，不能重复创建'
            ]);
        }
        $data = [];
        $data = [
            'name' => htmlspecialchars(strip_tags(trim($params['title']))),
            'summary' => htmlspecialchars(strip_tags(trim($params['summary']))),
            'status' => htmlspecialchars(strip_tags(trim($params['show']))),
            'head_url' => is_array($params['img']) ? $params['img'][0] : $params['img'],
            'create_time' => time()
        ];

        $res = ExpertsModel::insertExpertInfo($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }
        return Common::successData();

    }

    //TODO: 活动管理

    /**
     * 日历活动列表
     */
    public function calendarList ($type, $status)
    {
        //默认显示黑马速配
        switch ($type) {
            case 4 :
                $title = '黑马问道';
                break;
            case 5 :
                $title = '黑马工坊';
                break;
            default :
                $title = '三人必行';
        }
        $res = CalendarModel::getList($type, $status);

        return view('admin/calendarList', ['data' => $res, 'type' => $type, 'title' => $title, 'status' => $status]);
    }

    /**
     * 添加日历活动
     */
    public function calendarAdd ()
    {
        return view('admin/calendarAdd');
    }

    /**
     * 搜索日历活动
     */
    public function searchCalendar (Request $request)
    {
        //过滤输入
        $value = htmlspecialchars(strip_tags(trim($request->input('value'))));

        if (empty($value)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索值不能为空'
            ]);
        }
        $res = CalendarModel::getSearch($value);

        return Common::successData($res);
    }

    /**
     * 获取某日历活动信息
     */
    public function getCalendar ($id)
    {

        $res = CalendarModel::getInfoById($id);
        $arr = [];
        $arr = [
            '4' => '黑马问道',
            '5' => '黑马工坊',
            '6' => '三人必行'
        ];

        return view('admin/calendar', ['data' => $res, 'arr' => $arr]);
    }


    /**
     * 保存日历活动
     */
    public function modifyCalendar (Request $request)
    {
        (new updateCalendarRule)->goCheck(200);
        $params = $request->all();

        //构造插入数据
        $data = [];
        $data = [
            'type' => htmlspecialchars(strip_tags(trim($params['type']))),
            'date' => htmlspecialchars(strip_tags(trim($params['date']))),
            'event' => htmlspecialchars(strip_tags(trim($params['event']))),
            'place' => htmlspecialchars(strip_tags(trim($params['place']))),
            'time' => htmlspecialchars(strip_tags(trim($params['time']))),
            'price' => 0,
            'c_id' => htmlspecialchars(strip_tags(trim($params['category']))),
            'status' => htmlspecialchars(strip_tags(trim($params['show'])))

        ];

        //付费
        if ($params['type'] == 1) {
            if (!empty($params['price'])  && ((is_numeric($params['price']) && ($params['price'] + 0) > 0)) && ((strstr($params['price'],'.')) == false || strlen(strstr($params['price'],'.')) <= 3 )) {
                if ($params['price'] > 999999.99) {
                    throw new ParamsException([
                        'code' => 200,
                        'message' => '活动报名金额不能超过百万'
                    ]);
                }
                $data['price'] = $params['price'];
            } else {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '活动报名金额不正确'
                ]);
            }
        }

        $res = CalendarModel::updateUserInfo($params['id'], $data);
        if (!$res) {

            throw new ParamsException([
                'code' => 200,
                'message' => '内容没有修改'
            ]);
        }

        return Common::successData();

    }

    /**
     * 新建日历活动
     */
    public function insertCalendar (Request $request)
    {

        (new updateCalendarRule)->goCheck(200);
        $params = $request->all();

        //构造插入数据
        $data = [];
        $data = [
            'type' => htmlspecialchars(strip_tags(trim($params['type']))),
            'date' => htmlspecialchars(strip_tags(trim($params['date']))),
            'event' => htmlspecialchars(strip_tags(trim($params['event']))),
            'place' => htmlspecialchars(strip_tags(trim($params['place']))),
            'time' => htmlspecialchars(strip_tags(trim($params['time']))),
            'price' => 0,
            'c_id' => htmlspecialchars(strip_tags(trim($params['category']))),
            'status' => htmlspecialchars(strip_tags(trim($params['show']))),
            'create_time' => time()

        ];

        //付费
        if ($params['type'] == 1) {
            if (!empty($params['price'])  && ((is_numeric($params['price']) && ($params['price'] + 0) > 0)) && ((strstr($params['price'],'.')) == false || strlen(strstr($params['price'],'.')) <= 3 )) {
                if ($params['price'] > 999999.99) {
                    throw new ParamsException([
                        'code' => 200,
                        'message' => '活动报名金额不能超过百万'
                    ]);
                }
                $data['price'] = $params['price'];
            } else {
                throw new ParamsException([
                    'code' => 200,
                    'message' => '活动报名金额不正确'
                ]);
            }
        }

        $res = CalendarModel::insertCaseInfo($data);

        if (!$res) {
            throw new \Exception('服务器内部错误');
        }
        return Common::successData();

    }

    /**
     * 活动报名情况
     */
    public function calendarDetails (Request $request)
    {

        $id = $request->input('id');

        $res = CalendarModel::calendarDetails($id);

        return Common::successData($res[0]['manys']);
    }

    //TODO 互动管理

    /**
     * 获取福利、增值服务列表
     */

    public function WelfareList ($type, $status)
    {
        //默认显示黑马速配
        switch ($type) {
            case 7 :
                $title = '黑马福利';
                break;
            case 11 :
                $title = '增值服务1';
                break;
            case 13 :
                $title = '核心服务';
                break;
            default :
                $title = '增值服务2';
        }
        $res = ArticleModel::getList($type, $status);

        return view('admin/welfareList', ['data' => $res, 'type' => $type, 'title' => $title, 'status' => $status]);
    }

    /**
     * 搜索福利信息
     */
    public function searchWelfare (Request $request)
    {
        //过滤输入
        $value = htmlspecialchars(strip_tags(trim($request->input('value'))));

        if (empty($value)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索值不能为空'
            ]);
        }
        $res = ArticleModel::SearchInfo($value);

        return Common::successData($res);
    }

    /**
     * 获取福利、增值服务信息页面
     */
    public function editorWelfare ($id)
    {
        $res = ArticleModel::getInfoById($id);
        $arr = [];
        $arr = [
            '7' => '黑马福利',
            '11' => '增值服务1',
            '12' => '增值服务2',
            '13' => '核心服务'
        ];

        return view('admin/welfare', ['data' => $res, 'arr' => $arr]);
    }

    /**
     * 显示添加福利、增值服务页面
     */
    public function welfareAdd ()
    {
        return view('admin/welfareAdd');
    }

    //TODO 留言管理

    /**
     * 显示留言页面
     */
    public function messageList ($status)
    {

        if (!empty($status) && (int)$status == 1) {
            //显示会员
            $start = $end = 1;
            $status = 1;
        } else {
            $start = $status = 2;
            $end = 3;

        }

        $res = MessageModel::getMessageList($start, $end);

        return view('admin/message', ['data' => $res, 'status' => $status]);
    }

    /**
     * 获取用户全部留言
     */
    public function replyList (Request $request)
    {

        $userId = $request->input('userId');

        $res = MessageModel::getreplyList($userId);

        return Common::successData($res);

    }

    /**
     * 回复用户留言
     */
    public function getUserMessage (Request $request)
    {
        (new ReplyRule)->goCheck(200);

        $params = $request->all();

        $data = [];

        $data['reply_id'] = htmlspecialchars(strip_tags(trim($params['id'])));
        $data['content'] = htmlspecialchars(strip_tags(trim($params['news'])));
        $data['message_name'] = htmlspecialchars(strip_tags(trim($params['name'])));
        $data['create_time'] = time();

        ReplyModel::insertUserMessage($data, $params['id']);

        return Common::successData();

    }

    /**
     * 搜索用户留言
     */
    public function searchMessage (Request $request)
    {
        //过滤输入
        $value = htmlspecialchars(strip_tags(trim($request->input('value'))));


        if (empty($value)) {
            throw new ParamsException([
                'code' => 200,
                'message' => '搜索值不能为空'
            ]);
        }
        $res = MessageModel::getSearch($value);

        return Common::successData($res);
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
        $res = Adminmodel::modifyAdmin(bcrypt($param['newPasswd']));
        if (!$res) {
            throw new \Exception('服务器内部错误');
        }

        return Common::successData();

    }

    //获取留言未读条数
    public function unread ()
    {
        $res = MessageModel::unread();
        return Common::successData($res);
    }

    //错误页面
    public function error ()
    {
        return view('admin/error');
    }

    //错误页面
    public function notFound ()
    {
        return view('admin/404');
    }
}

