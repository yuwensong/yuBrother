<?php
namespace app\admin\controller;

class userController extends baseController
{
    public function index(){
        $this->display("user/index.html");
    }
}