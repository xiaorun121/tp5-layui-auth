<?php
namespace app\admin\model;

use think\Model;

use traits\model\SoftDelete;

class AppTrace extends Model{

    use SoftDelete;

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    
    protected $deleteTime = 'delete_time';

    protected $insert = ['user_id']; 

    protected function setUserIdAttr()
    {
        return session('user.id');
    }

    
}
