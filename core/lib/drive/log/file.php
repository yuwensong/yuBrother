<?php

namespace core\lib\drive\log;

use core\lib\conf;

class file
{
    public $path = '';   //存储路径

    public function __construct()
    {
        $option = conf::get('OPTION', 'log');
        if (isset($option['PATH'])) {
            $this->path = $option['PATH'];
        }
    }

    /**
     * 写入日志
     * @param $message
     * @param string $file
     */
    public function log($message, $file = 'log')
    {
        $realPath = $this->path . date('YmdH') . '/';
        //判断路径是不是一个目录,就创建目录
        if (!is_dir($realPath)) {
            mkdir($realPath, 0777, true);
            chmod($realPath, 0777); //避免第一步没给到权限
        }

        $file = $file . date('YmdHis') . '.php';
        return file_put_contents($realPath . $file, json_encode($message) . PHP_EOL, FILE_APPEND);
    }
}