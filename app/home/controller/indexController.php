<?php
namespace app\home\controller;

use core\yuBrother;

class indexController extends yuBrother
{
    public function index(){

        $data = "hello world";

        $this->assign("data", $data);
        $this->display("index.html");
    }
}