<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;
use app\admin\model\User;
use app\admin\model\Permission;

class Menu extends Model{

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    // use SoftDelete;
    // protected $deleteTime = 'delete_time';

    public static function toUserGetMenu(){
        //获取登录用户相应菜单
        // $user_id = session('loginUserId');
        $user_id = 2;
        $users = User::where('id',$user_id)->select();
        // dump($users[0]->role_id);
        if(count($users) != 1){
            return null;
        }

        $role_id = $users[0]->role_id;
        $permissions = Permission::where('role_id',$role_id)->select();
        // dump($permissions);
        $menu_ids = array();
        for ($i = 0;$i < count($permissions);$i++){
            $menu_ids[$i] = $permissions[$i]->menu_id;
        }
        // dump($menu_ids);
        return self::where('is_menu','=','1')
            ->where('id','in',$menu_ids)
            ->order('sort','asc')->select();
    }
}
