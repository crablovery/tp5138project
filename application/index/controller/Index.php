<?php
namespace app\index\controller;

use think\Controller;
use think\facade\App;
use think\facade\Request;

class Index extends Controller
{
    public function initialize()
    {
        echo "当前控制前：".Request::action()."<br />";
    }

    public function index()
    {

      return  $this->hello();
    }

    public function hello($name = 'ThinkPHP5')
    {
//        halt(config());
        return 'hello,' . $name.'<br />当前版本：'.App::VERSION();
    }

}
