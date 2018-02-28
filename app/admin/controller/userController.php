<?php
namespace app\admin\controller;

class userController extends baseController
{
    public function index(){
        $new = new \app\admin\model\yuBrothersModel();
        var_dump($new->lists());
        $this->display("user/index.html");
    }
}