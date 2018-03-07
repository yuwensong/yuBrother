<?php
namespace app\admin\controller;

class userController extends baseController
{
    public function index(){
       /* $new = new \app\admin\model\yuBrothersModel();
        var_dump($new->lists());*/

        $new = new \app\admin\model\authModel();
        //var_dump($new->getGroups(100));
        //var_dump($new->getAuthList(100));
        $this->display("user/index.html");
    }
}