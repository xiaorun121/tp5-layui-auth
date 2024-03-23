<?php
namespace app\admin\model;

use think\Model;

class Publish extends Model{

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $resultSetType = 'collection';
    
    public function gathers(){
        return $this->hasManyThrough('Gather','Backend','id','id','id');
    }

    // SELECT `gather`.* FROM `ch_gather` `gather` INNER JOIN `ch_backend` `ch_backend` ON `ch_backend`.`id`=`gather`.`id` INNER JOIN `ch_publish` `ch_publish` ON `ch_publish`.`id`=`ch_backend`.`id` WHERE  `gather`.`delete_time` IS NULL  AND `ch_backend`.`id` = 1

}
