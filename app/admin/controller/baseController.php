<?php
namespace app\admin\controller;

use core\yuBrother;

/**
 * 后台基类控制器,其他控制器基础他
 * @author wensong.yu
 * @datetime 2018-01-12 10:45 23
 */
class baseController extends yuBrother
{
    public function __construct()
    {
        //公共变量设置
        $this->setCommonParams();
    }

    /**
     * 后台公共变量的设置
     */
    public function setCommonParams()
    {
        //主题目录路径
        $this->assign('yu_borther_admin_theme', ADMIN_THEME );
    }
}