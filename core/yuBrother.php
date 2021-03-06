<?php

namespace core;

use \Exception;

/**
 * Class yuBrother
 * 核心类
 * @package core
 * @author  wensong.yu
 * @date 2017-12-28
 * @contact QQ 719629214
 */
class yuBrother
{
    static public $classMap = array();  //用来装加载了那些类
    public $assign = array();   //用来存储变量的数组
    static public $module;

    /**
     * 框架方法
     */
    static public function run()
    {
        $route = new \core\lib\route();

        self::$module = $route->module; //设置所走的模块

        $controllerFile = APP . '/' . $route->module . '/controller/' . $route->controller . 'Controller.php';
        if (!is_file($controllerFile)) {
            //抛出异常
            throw new Exception("没找到该类文件：" . $controllerFile);
        }
        require_once $controllerFile;
        $className = "\app\\" . $route->module . "\\controller\\" . $route->controller . "Controller";

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
        //文件的绝对路径
        $filePath = APP . DS . self::$module . DS . 'view' . DS;
        $realFile = $filePath . $file; //文件的全部路径包括文件
        if (is_file($realFile)) {

            //调用的是twig模版引擎
            $loader = new \Twig_Loader_Filesystem($filePath);
            $twig = new \Twig_Environment($loader, array(
                'cache' => YUBROTHER . '/log/twig',
                'debug' => DEBUG
            ));
            $template = $twig->loadTemplate($file);
            $template->display($this->assign ? $this->assign : '');
        }
    }
}
