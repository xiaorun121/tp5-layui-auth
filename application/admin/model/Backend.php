<?php
namespace app\admin\model;

use think\Model;

use traits\model\SoftDelete;

class Backend extends Model{

    use SoftDelete;

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $deleteTime = 'delete_time';

    protected $auto = [];
    protected $insert = ['user_id']; 

    protected $resultSetType = 'collection';

    protected function setUserIdAttr()
    {
        return session('user.id');
    }
}
