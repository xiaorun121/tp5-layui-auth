<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;
use app\admin\model\User;
use app\admin\model\Menu;
use app\admin\model\Permission as PermissionModel;

class Permission extends Model{

    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat = 'Y-m-d H:i:s';

    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function get_login_user_permissions($id)
    {

        $user = new User();
        $users = $user->where('id', $id)->find();

        //角色ID
        $user_role_id = $users['role_id'];

        //权限
        $permission = new PermissionModel();
        $permissioninfo = $permission->where('role_id', '=', $user_role_id)->select();
        if (count($permissioninfo) < 1) {
            return array('ok'=>'2');
        }
        $permission_menu_ids = array();

        for ($i = 0; $i < count($permissioninfo); $i++) {
            $permission_menu_ids[$i] = $permissioninfo[$i]->menu_id;
        }

        $menu = new Menu();
        $menus = $menu->where('id', 'in', $permission_menu_ids)->select();
        for ($i = 0; $i < count($menus); $i++) {
            $permissions[$i] = '/'.$menus[$i]->module_name.'/'.$menus[$i]->controller_name.'/'.$menus[$i]->view_name;
        }

        session('loginUserPermissions',$permissions);
        return $permissions;
    }

}
