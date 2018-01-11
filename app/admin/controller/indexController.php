<?php
namespace app\admin\controller;

use core\yuBrother;

class indexController extends yuBrother
{
    public function index(){
        $data = "admin hello world";

        $this->assign("data", $data);
        $this->display("index/index.html");
    }
}