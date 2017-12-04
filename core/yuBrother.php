<?php

namespace core;

use think\Exception;

class yuBrother
{
    static public $classMap = array();  //用来装加载了那些类
    public $assign = array();

    /**
     * 框架方法
     */
    static public function run()
    {
        $route = new \core\lib\route();

        $controllerFile = APP . '/controller/' . $route->controller . 'Controller.php';
        if (!is_file($controllerFile)) {
            //抛出异常
            throw new Exception("没找到该类文件：" . $controllerFile);
        }

        require_once $controllerFile;
        $className = "\app\\controller\\" . $route->controller . "Controller";

        $controllObj = new $className();
        $action = $route->action;
        $controllObj->$action();
    }

    /**
     * 加载类的方法
     */
    static public function load($class)
    {
        //如果已经加载类该类，就直接返回true
        if (isset(self::$classMap[$class])) {
            return true;
        }

        $class = str_replace('\\', '/', $class);

        $classFile = YUBROTHER . '/' . $class . '.php';

        if (!is_file($classFile)) {
            return false;
        }

        require_once $classFile;
        self::$classMap[$class] = $class;

        return true;
    }

    /**
     * 分配变量
     */
    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    /**
     * 分配模版
     */
    public function display($file)
    {
        extract($this->assign);
        $realFile = APP . '/view/' . $file;
        if (is_file($realFile)) {

            //调用的是twig模版引擎
            $loader = new \Twig_Loader_Filesystem(APP . "/view");
            $twig = new \Twig_Environment($loader, array(
                'cache' => YUBROTHER . '/log/twig',
                'debug' => DEBUG
            ));
            $template = $twig->loadTemplate('index.html');
            $template->display($this->assign ? $this->assign : '');
        }
    }
}
