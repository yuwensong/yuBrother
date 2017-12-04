<?php
namespace core\lib;

/**
 * Class conf
 * @package core\lib
 * @author wensong.yu
 */
class conf
{
    //配置文件数组
    static public $conf;

    /**
     * 获取配置文件中某个变量的值
     * @param $name
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    static public function get($name, $file){
        $path = CORE.'/conf/'.$file.".php";

        //如果存在该文件，说明已经加载过了，直接返回文件中的值
        if(isset(self::$conf[$file])){
            return self::$conf[$file][$name];
        }

        //判断配置文件是否存在
        if(!is_file($path)){
            throw new \Exception("找不到配置文件:".$file);
        }

        $conf = require_once $path;

        //判断文件是否已经缓存
        if(!isset($conf[$name])){
            throw new \Exception("文件中没有此变量的值");
        }

        self::$conf[$file] = $conf;

        return $conf[$name];
    }

    /**
     * 获取配置文件中的整个数组
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    static public function all($file){
        $path = CORE.'/conf/'.$file.".php";

        //如果存在该文件，说明已经加载过了，直接返回文件中的值
        if(isset(self::$conf[$file])){
            return self::$conf[$file];
        }

        //判断配置文件是否存在
        if(!is_file($path)){
            throw new \Exception("找不到配置文件:".$file);
        }
        self::$conf[$file] = require_once $path;

        return self::$conf[$file];
    }
}