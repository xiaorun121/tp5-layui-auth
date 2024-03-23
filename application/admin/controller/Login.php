<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Login extends Controller{

		public function index(){
			if(request()->isPost()){

				$username = trim(input('post.username/s')); //强制转换为字符串类型
	            $password = md5(trim(input('post.password/s')));

	            $user = Db::name('user')->where('username', $username)->where('delete_time is null')->find();

	            if(!$user){
		            	//返回错误信息
	            	$data['status'] = 202;
	            	$data['msg']    = '管理员不存在';
	            	return json($data);
	            }else{
					//密码校验
					if($password != $user['password']){
							//返回错误信息
							$data['status'] = 202;
							$data['msg']    = '管理员密码错误';
							return json($data);
					}else{
						if($user['open'] == 'off'){
								$data['status'] = 202;
							$data['msg']    = '该用户已被禁用，请联系管理员！';
							return json($data);
						}else{
							$userInfo['name']      = $username;
							$userInfo['nickname']  = $user['nickname'];
							$userInfo['id']        = $user['id'];
							$userInfo['role_id']   = $user['role_id'];
							session('user', $userInfo);

							$data = array(
								'login_time' => date('Y-m-d H:i:s',time())
							);

							Db::name('user')->where('id',$user['id'])->update($data);
							Db::name('user')->where('id',$user['id'])->setInc('login_num',1);

							//返回成功信息
							$data['status'] = 200;
							$data['url'] = url('/admin/index/index');
							return json($data);
						}
					}
	          	}

			}else{
				if(session('user.name') == null){
					session(null);
	         		return view();
				}else{
					$this->redirect('index/index');
				}
			}
		}

		public function updPassword(){
			if(request()->isPost()){

					$id = input('post.id');
					$data = [
							'username'   => input('post.username'),
							'password'   => md5(input('post.password'))
					];
					$info = Db::name('user')->where(['username'=>input('post.username'),'password'=>md5(input('post.password')),'id'=>$id])->find();
					// dump($info);exit;
					if($info == NULL){

							$res = Db::name('user')->where('id',$id)->update($data);

							if($res == 1){
									return success('修改成功');
							}

					}else{

							return error('请更新密码');
					}

			}else{
					$id   = session('user.id');
					$name = session('user.name');

					$data = [
							'id'   => $id,
							'name' => $name
					];

					$this->assign('info',$data);
					return view();
			}
		}


		public function logout(){
				session(null);
				$this->redirect('login/index');
		}


}
