<?php
/**
 * Created by PhpStorm.
 * User: 王文磊
 * Date: 2019/8/7
 * Time: 7:29
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;
use think\facade\Request;

class Article extends Base
{
    public  function initialize()
    {
//        halt();
        $this->isLogin();
        if (filemtime('artcates.json')<time()-10)
            file_put_contents('artcates.json',json_encode([['n'=>'1','s'=>[['n'=>"1.1"],['n'=>'1.2','s'=>[['n'=>'1.2.1'],['n'=>'1.2.2']]]]],['n'=>'2'],['n'=>time()]]));
    }

    public function artList(){
        $params=Request::param();
        $this->assign('pageTitle','文章管理');
        return $this->fetch();
    }

    public function artAdd(){
        $this->assign("pageTitle",'添加文章');
        return $this->fetch();
    }

    public function upload(){
        return $this->fetch();
    }

    public  function catelist(){
        if(Request::isPost()){
//            return [['n'=>'1','s'=>[['n'=>"1.1"],['n'=>'1.2']]]];
            return [["n"=>1],["n"=>3]];
        }

    }
}