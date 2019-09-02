<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/7/22
 * Time: 16:44
 */

namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\common\controller\Base;
use app\admin\model\Adminrole;
use think\Db;
use think\db\Where;
use think\Exception;
use think\facade\Request;
use think\facade\Session;

class Admin extends Base
{
    public function initialize()
    {

        $this->isLogin();
    }

    public function adminlist()
    {
        $data =Request::param();
        $maps = [];
        $num = 10;
        if (!empty($data['keyword'])) {
            $maps['account|realname'] = ["like", '%' . $data['keyword'] . '%'];
        }else{
            $data['keyword']='';
        }
        if (!empty($data['rolegroup'])&&$data['rolegroup']>0) $maps['roleid'] = $data['rolegroup']; else $data['rolegroup']=-1 ;
        if (isset($data['dateend'])&&!empty($data['datestart']) ) {
            if (!empty($data['dateend'])&& $data['dateend']!='0') {
                $maps['create_time'] = ['between time', [$data['datestart'], date('Y-m-d',strtotime($data['dateend'].'  +1 day'))]];
            } else {
                $maps['create_time'] = ['between time', [$data['datestart'], date('Y-m-d H:i:s')]];
                $data['dateend']=date('Y-m-d');
            }
        }else{
            $data['datestart']='';
            if(isset($data['dateend'])&&!empty($data['dateend']))
            {
                $maps['create_time'] = ['<=', strtotime( $data['dateend'])];
            }else{
                $maps['create_time'] = ['<=',  strtotime(date('Y-m-d H:i:s'))];
                $data['dateend']='';
            }
        }

        dump($data);
        if (!empty($data['pagenum'])) $num = $data["pagenum"]; else $data['pagenum']=10;
        $this->assign('param',$data);
        $count=AdminModel::count();
        $admin = Db::name('admin')->where(new Where($maps))->fetchSql(false)->paginate($num,false,['query'=>Request::param()]);
        $this->assign("users", $admin);
        $this->assign('usercount',$count);
        $this->assign('pages',$admin->render());
        $this->assign("empty", '<span class="btn btn-danger">暂无相关数据，请及时添加</span>');
        $adminrole = Adminrole::all(function ($query) {
            $query->order("sort")->select();
        });
        $this->assign("roles", $adminrole);
        return $this->fetch();
    }


    public function add()
    {
        if (Request::isAjax()) {
            $data = Request::post();

            $rule = [
                'account|登陆账号' => 'require|length:3,20|alphaDash|unique:admin',
                'password|登陆密码' => 'require|length:4,20|alphaNum|confirm',
                'email|邮箱地址' => 'email|max:60|unique:admin',
                'mobile|手机号' => 'mobile|require',
            ];
            $message = [
                'account.unique' => "登陆账号在系统中已经存在或者禁止使用",
                'account.length' => '登陆账号长度必须在 3~20位 之间',
                'password.confirm' => '两次输入的密码不一致'
            ];
            $res = $this->validate($data, $rule, $message);
            if (true === $res) {
                try {
                    $data['pwd_mix'] = rand(9999, 99999);
                    $data["password"] = sha1($data["password"] . $data["pwd_mix"]);
                    $data["add_user"] = Session::get("admin_id");
                    $resdata = AdminModel::create($data);
                    if (!is_null($resdata)) {
                        return ["status" => "success", "msg" => "恭喜您，成功添加管理员"];
                    } else {
                        return ["status" => "fail", "msg" => "非常抱歉失败了ε=(´ο｀*)))唉~~"];
                    }
                } catch (Exception $e) {
                    return ["status" => "error", "msg" => "添加用户失败：" . $e];
                }
            } else {
                return ["status" => "fail", "msg" => $res];
            }
            //return ["status"=>"success","msg"=>"恭喜您，成功添加管理员"];
        }
        $adminrole = Adminrole::all(function ($query) {
            $query->order("sort")->select();
        });
        $this->assign("roles", $adminrole);
        return $this->fetch();
    }
public function batchadd(){
        for($i=1;$i<71;$i++){
            $data['id']=$i;
            $data['account']='admin'.$i;
            $data['pwd_mix']=rand(9999,99999);
            $data['password']=sha1('123456'.$data['pwd_mix']);
            $data['mobile']='180325725'.($i<10?'0'.$i:$i);
            $data['roleid']=rand(1,2);
            $data['realname']='wenlei-'.$i;
            $data['email']='32793206'.($i<10?'0'.$i:$i).'@qq.com';
            $data['status']=rand(0,1);
            $data['create_time']=time();
            $data['regip']='127.0.0.1';
            $data['sex']='男';
            $data['remark']=null;
            $resdata = AdminModel::create($data);
            echo $i.'插入成功<br />';
        }
}
    /**
     * @return 修改管理员启用/禁用状态
     */
    public function modstatus()
    {
        if (Request::isPost()) {
            $postdata = Request::post();
            if ($postdata['status'] == 1) {
                $postdata['status'] = 0;//状态改为禁用
                $res = AdminModel::update($postdata);
                return ["status" => 'success', 'msg' => '用户状态改为：【禁用】'];
            } else {
                $postdata['status'] = 1;//状态改为启用
                $res = AdminModel::update($postdata);
                return ["status" => 'success2', 'msg' => '用户状态改为：【已启用】'];
            }
        }
    }

    public function edit()
    {
        $adminid = Request::param("id");
        if (Request::isAjax()) {
            $data = Request::post();
            $rule = [
                'account|登陆账号' => 'require|length:3,20|alphaDash|unique:admin',
                'password|登陆密码' => 'length:4,20|alphaNum|confirm',
                'email|邮箱地址' => 'email|max:60|unique:admin',
                'mobile|手机号' => 'mobile|require',
            ];
            $message = [
                'account.unique' => "登陆账号在系统中已经存在或者禁止使用",
                'account.length' => '登陆账号长度必须在 3~20位 之间',
                'password.confirm' => '两次输入的密码不一致'
            ];
            $res = $this->validate($data, $rule, $message);
            if (true === $res) {
                try {
                    if ($data['password'] != '') {
                        $data['pwd_mix'] = rand(9999, 99999);
                        $data["password"] = sha1($data["password"] . $data["pwd_mix"]);
                    } else {
                        unset($data['password']);
                    }
                    $data["add_user"] = Session::get("admin_id");
                    $resdata = AdminModel::update($data);
                    if (!is_null($resdata)) {
                        return ["status" => "success", "msg" => "恭喜您，管理员更新成功"];
                    } else {
                        return ["status" => "fail", "msg" => "非常抱歉失败了ε=(´ο｀*)))唉~~"];
                    }
                } catch (Exception $e) {
                    return ["status" => "error", "msg" => "更新用户失败：" . $e];
                }
            } else {
                return ["status" => "fail", "msg" => $res];
            }
        }
        $adminrole = Adminrole::all(function ($query) {
            $query->order("sort")->select();
        });
        $this->assign("roles", $adminrole);
        $admin = AdminModel::get($adminid);
        $this->assign("user", $admin);
        return $this->fetch();
    }

    public function del()
    {
        if (Request::isAjax()) {
            $id = Request::post("id");
            $user = AdminModel::get($id);
            if (!is_null($user)) {
                if ($user->delete()) {
                    return ["status" => "success", "msg" => "删除管理员成功"];
                } else {
                    return ["status" => "fail", "msg" => "删除失败！！！"];
                }
            } else {
                return ["status" => "fail", "msg" => "管理员信息不存在"];
            }

        }
    }

    /**
     * 批量删除数据
     */
    public function clear()
    {
        if (Request::isPost()) {
            $ids = Request::param('data');
            if (count($ids) > 0) {
                $res = AdminModel::destroy($ids);
                if ($res) {
                    return ["status" => "success", "msg" => "删除管理员成功"];
                } else {
                    return ["status" => "fail", "msg" => "删除失败！！！"];
                }
            } else {
                return ["status" => "fail", "msg" => "未选择任何有效的信息"];
            }
        }
    }
    /**
     * 数据检索
     */
}