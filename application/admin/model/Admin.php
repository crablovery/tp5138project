<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/7/22
 * Time: 20:06
 */

namespace app\admin\model;


use think\facade\Request;
use think\facade\Session;
use think\Model;

class Admin extends Model
{
    protected $pk="id";
    protected $autoWriteTimestamp = true;
    protected $createTime="create_time";
    protected $updateTime='update_time';
    protected $dateFormat='Y年m月d日 H:i:s';
    protected $auto = ['ip'];
    protected $insert = ['create_time'];
    protected $update = [];

    protected function setRegipAttr(){
       return Request::ip();
    }
    protected function setStatusAttr($value){
        $status=['1'=>true,'0'=>false];
        return $status[$value];
    }
    protected function setAddUserAttr(){
        if(Session::has("admin_id")){
            return Session::get("admin_id");
        }else{
            return "未知";
        }
    }
    protected function getCreateTimeAttr($val){
        return $val;
    }


}