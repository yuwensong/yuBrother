<?php
namespace app\admin\model;

use core\lib\model;

class yuBrothersModel extends model
{
    public $table = "yu_brothers";

    public function lists()
    {
        return $this->select($this->table, '*');
    }
}