<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class User extends Model{

    // 设置返回数据集的对象名
	protected $resultSetType = '\think\model\Collection';

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected $insert = ['ip'];

    protected function setIpAttr()
    {
        return request()->ip();
    }

    public function getNickname($id){
        
        return  self::where(['id'=>$id])->value('nickname');

    }
}