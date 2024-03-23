<?php
namespace app\admin\model;

use think\Model;
use think\Request;

class Logs extends Model{

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $insert = ['user_id','ip']; 

    protected function setUserIdAttr()
    {
        return session('user.id');
    }

    protected function setIpAttr()
    {
        return Request::instance()->ip();
    }
}
