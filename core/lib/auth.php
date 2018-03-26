<?php
namespace core\lib;


/**
 * Class Auth
 * @package core\lib
 * 权限认证类
 */

class auth{
    //默认配置
    protected $_config = array();
    public function __construct() {
        //获取权限认证类
        $authConfig = conf::all('auth');
        if (!empty($authConfig) && is_array($authConfig)) {
            //可设置配置项 AUTH_CONFIG, 此配置项为数组。
            $this->_config = $authConfig;
        }
    }

    /**
     * 获得权限$name 可以是字符串或数组或逗号分割，
     * uid为 认证的用户id， $or 是否为or关系，为true是，
     * name为数组，只要数组中有一个条件通过则通过，如果为false需要全部条件通过。
     * @param $name
     * @param $uid
     * @param string $relation
     * @return bool
     */
    public function check($name, $uid, $relation='or') {
        if (!$this->_config['AUTH_ON'])
            return true;
        $authList = $this->getAuthList($uid);
        if (is_string($name)) {
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //有权限的name
        foreach ($authList as $val) {
            if (in_array($val, $name))
                $list[] = $val;
        }
        if ($relation=='or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation=='and' and empty($diff)) {
            return true;
        }
        return false;
    }


    /**
     * //获得用户组，外部也可以调用
     * @param $uid
     * @return mixed
     */
    public function getGroups($uid) {
        static $groups = array();
        if (isset($groups[$uid]))
            return $groups[$uid];
        $user_groups = M()->table($this->_config['AUTH_GROUP_ACCESS'] . ' a')
            ->where("a.uid='$uid' and g.status='1'")
            ->join($this->_config['AUTH_GROUP']." g on a.group_id=g.id")
            ->select();
        $groups[$uid]=$user_groups?$user_groups:array();
        return $groups[$uid];
    }


    //获得权限列表
    protected function getAuthList($uid) {
        static $_authList = array();
        if (isset($_authList[$uid])) {
            return $_authList[$uid];
        }
        if(isset($_SESSION['_AUTH_LIST_'.$uid])){
            return $_SESSION['_AUTH_LIST_'.$uid];
        }
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = array();
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid] = array();
            return array();
        }
        //读取用户组所有权限规则
        $map=array(
            'id'=>array('in',$ids),
            'status'=>1
        );
        $rules = M()->table($this->_config['AUTH_RULE'])->where($map)->select();
        //循环规则，判断结果。
        $authList = array();
        foreach ($rules as $r) {
            if (!empty($r['condition'])) {
                //条件验证
                $user = $this->getUserInfo($uid);
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $r['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $authList[] = $r['name'];
                }
            } else {
                //存在就通过
                $authList[] = $r['name'];
            }
        }
        $_authList[$uid] = $authList;
        if($this->_config['AUTH_TYPE']==2){
            //session结果
            $_SESSION['_AUTH_LIST_'.$uid]=$authList;
        }
        return $authList;
    }
    //获得用户资料,根据自己的情况读取数据库
    protected function getUserInfo($uid) {
        static $userinfo=array();
        if(!isset($userinfo[$uid])){
            $userinfo[$uid]=M()->table($this->_config['AUTH_USER'])->find($uid);
        }
        return $userinfo[$uid];
    }
}