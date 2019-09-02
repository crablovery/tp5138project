<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/7/22
 * Time: 15:34
 */

namespace app\admin\controller;


use app\admin\common\controller\Base;

class Main extends Base
{
    public function index(){
        $this->isLogin();
        return $this->fetch();
    }
    public function welcome(){
        return $this->fetch();
    }
}