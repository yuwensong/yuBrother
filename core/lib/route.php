<?php
namespace core\lib;
use core\lib\conf;

class route
{
    public $controller;
    public $action;

    public function __construct()
    {
        //1.隐藏index.php
        //2.获取url参数 $_SERVER
        //3.返回控制器和方法

        //不存或者只有'/'的时候
        if(!isset($_SERVER['REQUEST_URI'])
            || (isset($_SERVER['REQUEST_URI'])
                && $_SERVER['REQUEST_URI'] == '/')){
            $this->controller = conf::get("CONTROLLER", 'route');
            $this->action = conf::get("ACTION", 'route');

        } else {
            //存在的情况下
            $pathArr = explode("/", trim($_SERVER['REQUEST_URI'], '/'));

            if (isset($pathArr[0])) {
                $this->controller = $pathArr[0];
                unset($pathArr[0]);
            } else {
                $this->controller = conf::get("CONTROLLER", 'route');
            }

            if (isset($pathArr[1])) {
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            } else {
                $this->action = conf::get("ACTION", 'route');
            }

            //将多个参数进行处理成数组
            $countParams = count($pathArr);
            if ($countParams > 2) {
                $i = 2;
                while ($i < $countParams + 2) {
                    if (isset($pathArr[$i]) && isset($pathArr[$i + 1])) {
                        $_GET[$pathArr[$i]] = $pathArr[$i + 1];
                    }
                    $i += 2;
                }
            }
        }
    }
}