<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\logic\GetViewMenuPermission;

use app\admin\model\Menu as MenuModel;
use app\admin\model\Role;
use app\admin\model\Permission;

use think\Db;

// 菜单管理
class Menu extends Common{

    public function mList(){
        $menu = new MenuModel();
        $menu = $menu::all(function($query){
            $query->order('sort asc');
        });

        $treeArr = get_tree($menu);

        $this->assign('menu',$treeArr);


        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();


        $this->assign('viewMenu',$viewMenu);
        return view();
    }

    // 更新菜单
    public function publicSaveMenu($id = 0,$name = '',$is_menu = '',$module_name = '',$controller_name = '',$view_name = '',$sort = 0,$parent_id = 0){
        $menu = new MenuModel();
        $role = new Role();
        $permission = new Permission();
        if(request()->isPost()){

            $role_id   = session('user.role_id');
            $user_id   = session('user.id');

            if($id != 0){
                $menu = $menu::get($id);
            }

            $data['name']              = input('post.name');
            $data['module_name']       = input('post.module_name');
            $data['controller_name']   = input('post.controller_name');
            $data['view_name']         = input('post.view_name');
            $data['is_menu']           = input('post.is_menu');
            $data['parent_id']         = input('post.parent_id');
            $data['sort']              = input('post.sort');
            $data['user_id']           = $user_id;

            if($menu->save($data) == 1){
                if($role_id == 1){
                    $res = $permission->where(['role_id'=>$role_id,'menu_id'=>$id])->find();
                    if($res <> 1){
                        $menu_id   = $menu->id;
                        $permission->role_id = $role_id;
                        $permission->menu_id = $menu_id;
                        $permission->save();
                    }
                }

                return success('保存成功',url('mlist'));
            }else{
                return error('请更新数据！');
            }
            
        }else{
            $data = [
                'id'               => $id,
                'name'             => $name,
                'is_menu'          => $is_menu,
                'module_name'      => $module_name,
                'controller_name'  => $controller_name,
                'view_name'        => $view_name,
                'sort'             => $sort,
                'parent_id'        => $parent_id,
            ];
            $this->assign('getInfo',$data);
            $menu = $menu::all(function($query){
                $query->where('is_menu',1)->order('sort asc');
            });

            $treeArr = get_tree($menu);

            $this->assign('menuinfo',$treeArr);
            return view();
        }

    }

    // 删除menu
    public function delMenu(){
        $id = input('post.id');

        // 软删除
        $menu = new MenuModel();

        // 启动事务
        Db::startTrans();

        try{    
            $res = $menu::destroy($id);

            if($res == 1){

                // 查询当前删除的菜单下面是否有子菜单
                $query_is_child_data = $menu->where('parent_id',$id)->column('id');


                if(!empty($query_is_child_data)){

                    $str_child_data =  implode(',',$query_is_child_data);

                    $ids = $id.','.implode(',',$query_is_child_data);

                    // 删除子菜单
                    $menu::destroy(['parent_id'=>$id]);

                    // 删除权限表冗余数据
                    $permission = new Permission();
                    // $role_id    = session('user.role_id');
                    // $permission->where(['role_id'=>$role_id,'menu_id'=>$id])->delete();
                    $permission::where('menu_id','exp','IN ('.$ids.')')->delete();


                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功','type'=>'array','data'=>explode(',',$ids)]);
        
                }else{
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功','type'=>'string','data'=>$id]);
                }


            }else{
                echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
            }

            // 提交事务
            Db::commit();  

        }catch (\Exception $e){
            // 回滚事务
            Db::rollback();
        }

    }
}
