<?php
namespace app\admin\controller;

class indexController extends baseController
{
    public function index(){
        $data = "admin hello world";

        $this->assign("data", $data);
        $this->display("index/index.html");
    }
}