<?php
namespace app\controller;

use app\model\yuBrothersModel;
use core\lib\model;
use core\yuBrother;
use core\lib\conf;

class indexController extends yuBrother
{
    public function index(){

//        \core\lib\log::init('file');
//        \core\lib\log::log(array("name" => "yuwensong", 'age' => 29));
//        \core\lib\log::log(array("name" => "yuwensong", 'age' => 39));

//        $temp = \core\lib\conf::get('CONTROLLER', 'route');
//        $temp1 = \core\lib\conf::get('ACTION', 'route');
//        p($temp);
//        p($temp1);
        //p("this is index method!");

//        $database = conf::all('database');
//        $db = new model();
//        $res = $db->select("yu_brothers", "*");
//        var_dump($res);

//        $brothers = new yuBrothersModel();
//        $res = $brothers->lists();
//        echo 11;
//        p($res);

        $data = "hello world";

        $this->assign("data", $data);
        $this->display("index.html");
    }
}