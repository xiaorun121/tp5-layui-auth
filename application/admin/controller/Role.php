<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Role as RoleModel;
use app\admin\logic\GetViewMenuPermission;

// 角色管理
class Role extends Common{

    public function rList(){
        $role = new RoleModel();
        $info = $role->order('sort asc')
                ->order('id asc')
                ->paginate(20,false,[
                    'type'     => 'bootstrap',
                    'var_page' => 'page',
        ]);
        $this->assign('info',$info);

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);
        return view();
    }




    // 更新角色信息
    public function publicSaveRole($id = 0,$name = '',$description = '',$sort = 0){
        if(request()->isPost()){
            $role = new RoleModel();

            if($id != 0){
                $role = $role::get($id);
            }else{
                $info = $role->where('name',$name)->find();
                if(!empty($info)){
                    return error('该角色已存在');
                }
            }

            $role->name        = input('post.name');
            $role->description = input('post.description');
            $role->sort        = input('post.sort');

            if($role->save() == 1){
                return success('保存成功',url('rlist'));
            }else{
                return error('请更新数据！');
            }
            
        }else{
            $data = [
                'id'   => $id,
                'name' => $name,
                'desc' => $description,
                'sort' => $sort
            ];
            $this->assign('getInfo',$data);
            return view();
        }

    }

    // 删除role
    public function delRole(){
        $id = input('post.id');

        // 软删除
        $role = new RoleModel();
        $res = $role::destroy($id);
        if($res == 1){
            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);
        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }

}
