<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/7/22
 * Time: 13:26
 */

namespace app\admin\common\controller;


use think\Controller;
use think\facade\Request;
use think\facade\Session;

class Base extends Controller
{
    public function initialize()
    {

    }

    /**
     * 管理员已经登陆，则不需要重复登陆
     */
    public function isLogind()
    {
        if (Session::has("admin_id") && Session::has("admin_name")) {
            $this->error("管理员大人，您已经登陆啦~~",'main/index');
        }
        return true;
    }

    /**
     * 管理员尚未登陆，则进行提醒
     */
    public function isLogin()
    {
        if (!(Session::has("admin_id") && Session::has("admin_name"))) {
            $this->error("管理员大人，您是不是忘记登陆啦(#^.^#)");
        }
        return true;
    }
}