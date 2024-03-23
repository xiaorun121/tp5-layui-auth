<?php

namespace app\admin\logic;

use app\admin\model\Menu;
use think\Db;
use think\Request;

class GetViewMenuPermission{

    public function getViewMeun(){
        $request        = Request::instance();
        $moduleName     = $request->module();
        $controllerName = $request->controller();
        $actionName     = $request->action();

        $menu = new Menu();
        $menu = $menu->where('module_name',$moduleName)->where('controller_name',$controllerName)->field('id')->where('view_name',$actionName)->find();

        $res = $menu->where('parent_id',$menu['id'])->select();


        $menu_ids = array();
        for ($i = 0;$i < count($res);$i++){
            $menu_ids[$i] = $res[$i]->id;
        }

        $role_id   = session('user.role_id');
        $info = Db::view('Permission p','id')
                    ->view('Menu m','name','p.menu_id = m.id')
                    ->where('p.role_id','=',$role_id)
                    ->where('p.menu_id','in',$menu_ids)
                    ->select();

        if(!empty($info)){
            foreach ($info as $key => $value) {
                $menu_names[$key] = $value['name'];
            }

            $menu_names = implode(',',$menu_names);

            return $menu_names;
        }
        // $info = Db::query("SELECT m.name FROM shwap_permission p INNER JOIN shwap_menu m ON p.menu_id=m.id WHERE  p.role_id = '.$role_id.'  AND p.menu_id IN '.$menu_ids.'");

    }


}
