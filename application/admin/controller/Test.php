<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/7/23
 * Time: 20:10
 */

namespace app\admin\controller;


use app\admin\common\controller\Base;
use think\captcha\Captcha;


class Test extends Base
{
    public function index(){
       return \captcha("login",['length'   => 8,'fontSize' => 100,'codeSet'=>'123456HMKJ']);
    }
}