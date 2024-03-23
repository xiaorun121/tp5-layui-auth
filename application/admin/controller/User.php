<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Role;
use app\admin\model\User as UserModel;
use app\admin\model\Menu;
use app\admin\logic\GetViewMenuPermission;
use think\Db;

// 用户管理
class User extends Common{

    public function uList(){

        $user = new UserModel();

        $username = input('get.username');
        if($username){

            $info = $user->where('username','like','%'.$username.'%')
                        ->order('id asc')
                        ->paginate(20,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

        }else{

            $info = $user->order('id asc')
                        ->paginate(20,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);
        }


        $this->assign('username',$username);
        $this->assign('info',$info);

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);

        return view();
    }

    // 更新用户信息
    public function publicSaveUser($id = 0,$username = '',$nickname = '',$email = '',$sex= '',$birth = '',$address = '',$role_id = 0,$open = ''){
        if(request()->isPost()){
            $user = new UserModel();

            $str     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
            $randStr = str_shuffle($str);//打乱字符串
            $rands   = substr($randStr,0,32);

            if($id != 0){
                $user = $user::get($id);
            }else{
                $info = $user->where('username',$username)->find();
                if(!empty($info)){
                    return error('该用户已存在');
                }
                $data['client_id']   = rand(10000000,99999999);
                $data['secret']      = $rands;
            }

            $data['username']    = input('post.username');
            $data['nickname']    = input('post.nickname');
            $data['email']       = input('post.email');
            $data['sex']         = input('post.sex');
            $data['birth']       = input('post.birth');
            $data['address']     = input('post.address');
            $data['role_id']     = input('post.role_id');

            if(input('post.password')){
                $data['password']    = md5(input('post.password'));
            }

            if(input('post.open') == 'on'){
                $data['open']        = 'on';
            }else{
                $data['open']        = 'off';
            }
            
            if($user->save($data) == 1){
                return success('保存成功',url('ulist'));
            }else{
                return error('请更新数据！');
            }

        }else{
            $data = [
                'id'       => $id,
                'username' => $username,
                'nickname' => $nickname,
                'email'    => $email,
                'sex'      => $sex,
                'birth'    => $birth,
                'address'  => $address,
                'role_id'  => $role_id,
                'open'     => $open
            ];
            $this->assign('getInfo',$data);

            $role = new Role();
            $roleInfo = $role->order('sort asc')->select();
            $this->assign('roleInfo',$roleInfo);
            return view();
        }
    }

    // 删除user
    public function delUser(){
        $id = input('post.id');

        $user = new UserModel();
        $res = $user::destroy($id);
        if($res == 1){
            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);
        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }
}
