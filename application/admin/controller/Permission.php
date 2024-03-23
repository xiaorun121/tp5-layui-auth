<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Menu;
use app\admin\model\Role;
use app\admin\model\Permission as PermissionModel;
use think\Db;

// 权限
class Permission extends Common{

    public function rolePermissionSetting(){

        if(request()->isPost()){
            $permission = new PermissionModel();
            $role_id = input('post.role_id');

            $res = $permission->where('role_id',$role_id)->select();
            if(!empty($res)){

                $info = Db::name('permission')->where('role_id',$role_id)->delete();

                if($info > 0){

                    $menu_id = input('post.')['menu_id'];
                    $count = count($menu_id);
                    for($i=0;$i<$count;$i++){
                        $arr[$i]['role_id'] = $role_id;
                        $arr[$i]['menu_id'] = $menu_id[$i];
                    }

                    if($permission->saveAll($arr)){
                        return success('保存成功',url('role/rlist'));
                    }else{
                        return error('保存失败');
                    }
                }

            }else{
                $menu_id = input('post.')['menu_id'];
                $count = count($menu_id);
                for($i=0;$i<$count;$i++){
                    $arr[$i]['role_id'] = $role_id;
                    $arr[$i]['menu_id'] = $menu_id[$i];
                }

                if($permission->saveAll($arr)){
                    return success('保存成功',url('role/rlist'));
                }else{
                    return error('保存失败');
                }
            }

        }else{

            $menu = new Menu();
            $menu = $menu::all(function($query){
                $query->order('sort asc');
            });

            $treeArr = get_tree($menu);

            $this->assign('info',$treeArr);

            $id = input('get.role_id');
            $this->assign('id',$id);

            $role_id   = input('get.role_id');

            if($role_id == 1){
                $menu_id = Db::name('menu')->order('id asc')->field('id')->select();
                foreach ($menu_id as $key => $value) {
                    $menu_id[$key] = $value['id'];
                }
                $menu_id = implode(',',$menu_id);
            }else{
                $permission = new PermissionModel();
                $menu_id = Db::name('permission')->where('role_id',$id)->field('menu_id')->select();
                // dump($menu_id);
                foreach ($menu_id as $key => $value) {
                    $menu_id[$key] = $value['menu_id'];
                }
                $menu_id = implode(',',$menu_id);
            }

            $this->assign('menu_id',$menu_id);

            return view();
        }

    }

}
