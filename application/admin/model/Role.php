<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Role extends Model{

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // public function permission(){
    //     return $this->belongsToMany('meun','permission');
    // }
}
