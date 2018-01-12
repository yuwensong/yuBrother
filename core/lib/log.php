<?php
namespace core\lib;

/**
 * 日志
 */
class log
{
    static public $class;

    /**
     * 确定日志存储方式
     */
    static public function init($drive){
        $driveConf = conf::get('DRIVE', 'log');

        $class = '\core\lib\drive\log\\'.$drive;
        self::$class = new $class();
    }

    static public function log($name, $file = 'log'){
        self::$class->log($name, $file);
    }
}