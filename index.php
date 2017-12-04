<?php
/**
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

//设定日期
date_default_timezone_set('PRC'); //设置中国时区

//定义当前的目录
define('YUBROTHER', dirname(__FILE__));

//定义核心文件的目录
define('CORE', YUBROTHER . '/core');

//定义应用的目录
define("APP", YUBROTHER . '/App');

//定义是否开启debug
define("DEBUG", true);

//是否开启最优雅的错误调试方式
define("DEBUG_GOODS", true);

//设置seaslog的目录
SeasLog::setBasePath(YUBROTHER . '/log');

//加载第三方的php类库
require(YUBROTHER.'/vendor/autoload.php');

if (DEBUG) {

    if(DEBUG_GOODS){
        //处理错误最优雅的方式
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    //打开错误日志
    ini_set('display_errors', 'On');
} else {
    //关闭错误日志
    ini_set('display_errors', 'Off');
}

//加载公共函数库
require_once CORE . '/common/' . 'function.php';

//加载核心文件
require_once CORE . '/yuBrother.php';

//new类不存在的情况下，调用自动加载的类方法
spl_autoload_register("\core\yuBrother::load");

//启动框架
\core\yuBrother::run();


