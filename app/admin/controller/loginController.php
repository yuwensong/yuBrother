<?php
namespace app\admin\controller;

class loginController extends baseController
{
    public function index(){

        $this->display("login/index.html");
    }
}