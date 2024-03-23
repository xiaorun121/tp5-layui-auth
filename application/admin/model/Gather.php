<?php
namespace app\admin\model;

use think\Model;

class Gather extends Model{

    //或者使用字符串定义
    protected $connection = 'mysql://changhengapi:changhengapi123@127.0.0.1:3306/changhengapi#utf8';

    protected $table = 'ch_gather';

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $auto = [];
    protected $insert = ['user_id']; 

    protected function setUserIdAttr()
    {
        return session('user.id');
    }

    protected $resultSetType = 'collection';


    // public function publishs(){
    //     return $this->hasManyThrough('Backend','Publish','gather_id','backend_id','gather_id');
    // }
}
