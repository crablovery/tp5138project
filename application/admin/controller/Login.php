<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/7/22
 * Time: 13:19
 */

namespace app\admin\controller;


use app\admin\common\controller\Base;
use think\captcha\Captcha;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use app\admin\model\Admin;
class Login extends Base
{
    /**
     * 进行登陆
     */
    public function login(){
        $this->isLogind();
       return $this->fetch();
    }

    /**
     * 校验登陆的相关参数
     * @return 校验结果
     */
    public function checklogin(){
        if(Request::isAjax()){
            $datas=Request::post("");
            $admin=Admin::where(['account'=>$datas["account"]])->find();
            if(!captcha_check($datas['verifycode'])){
                return ["status"=>"fail","msg"=>"验证码错误！"];
            }
            if(is_null($admin)){
                return ["status"=>"fail","msg"=>"无此用户"];
            }else{
                if($admin["status"]==true){
                    if($admin['password']==sha1($datas['password'].$admin['pwd_mix'])){
                        Session::set("admin_id",$admin['id']);
                        Session::set("admin_name",$admin['account']);
                        Session::set("admin_role",$admin['roleid']);
                        Db::name('adminlog')->insert([
                            'adminid'=>$admin['id'],
                            'adminname'=>$admin['account'],
                            'logtime'=>time(),
                            'logip'=>Request::ip(),
                            'ipport'=>Request::port()
                        ]);
                        return ["status"=>"success","toUrl"=>url("Main/index")];
                    }else{
                        return ["status"=>"fail","msg"=>"登陆账号或者密码错误，请重新登陆"];
                    }
                }else{
                    return ["status"=>"fail","msg"=>"改账户已经被禁止登陆，如有疑问请联系网站管理员"];
                }
            }

        }
    }

    public function verify(){
        $captcha=new Captcha(['imageH'=>'40','imageW'=>'200','fontSize'=>'20']);
        return $captcha->entry();

    }

    /**
     * 退出登陆
     */
    public function logout(){
        Session::clear();
        $this->success("退出成功！","/login");
    }


}