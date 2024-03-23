<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Center extends Common{

    // 中心列表
    public function clist(){
        $name = input('get.name');
        if(!empty($name)){   // 根据 name select
            $info = Db::name('center')
                    ->where('name','like','%'.$name.'%')
                    ->order('sort asc')
                    ->order('id asc')
                    ->paginate(20,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

            $this->assign('info',$info);
            $this->assign('name',$name);

        }else{    // 获取当前数据
            $info = Db::name('center')
                    ->order('sort asc')
                    ->order('id asc')
                    ->paginate(20,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

            $this->assign('info',$info);
        }

        return view();
    }

    public function public(){
        if(request()->isPost()){

        }else{
            $info = Db::name('center_assessment_type')->order('sort asc')->select();

            $this->assign('info',$info);
            return view();
        }
    }

    // 中心考核
    public function ctype(){
        $name = input('get.name');
        if(!empty($name)){   // 根据 name select
            $info = Db::name('center_assessment_type')
                    ->where('name','like','%'.$name.'%')
                    ->order('sort asc')
                    ->order('id asc')
                    ->paginate(20,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

            $this->assign('info',$info);
            $this->assign('name',$name);

        }else{    // 获取当前数据
            $info = Db::name('center_assessment_type')
                    ->order('sort asc')
                    ->order('id asc')
                    ->paginate(20,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

            $this->assign('info',$info);
        }
        return view();
    }

    // add / save center
    public function saveCenter(){
        if(request()->isPost()){
            $id   = input('post.id');
            $name = input('post.cname');
            $desc = input('post.cdesc');
            $sort = input('post.sort');
            if(!empty($id)){    // edit
                $data['name']         = $name;
                $data['description']  = $desc;
                $data['sort']         = $sort;
                $data['update_date']  = date('Y-m-d H:i:s',time());
                $res = Db::name('center')->where('id',$id)->update($data);
                if($res == 1){
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'修改成功']);
                }else{
                    echo json_encode(['status'=>'error','code'=>201,'msg'=>'修改失败']);
                }

            }else{    // add
                $data['name']         = $name;
                $data['description']  = $desc;
                $data['sort']         = $sort;
                $data['create_date']  = date('Y-m-d H:i:s',time());
                $res = Db::name('center')->insert($data);
                if($res == 1){
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'添加成功']);
                }else{
                    echo json_encode(['status'=>'error','code'=>201,'msg'=>'添加失败']);
                }
            }
        }

    }

    // add / save center_assessment_type
    public function saveCenterAssessmentType(){
        if(request()->isPost()){
            $id   = input('post.id');
            $name = input('post.cname');
            $desc = input('post.cdesc');
            $sort = input('post.sort');
            if(!empty($id)){    // edit
                $data['name']         = $name;
                $data['description']  = $desc;
                $data['sort']         = $sort;
                $data['update_date']  = date('Y-m-d H:i:s',time());
                $res = Db::name('center_assessment_type')->where('id',$id)->update($data);
                if($res == 1){
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'修改成功']);
                }else{
                    echo json_encode(['status'=>'error','code'=>201,'msg'=>'修改失败']);
                }

            }else{    // add
                $data['name']         = $name;
                $data['description']  = $desc;
                $data['sort']         = $sort;
                $data['create_date']  = date('Y-m-d H:i:s',time());
                $res = Db::name('center_assessment_type')->insert($data);
                if($res == 1){
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'添加成功']);
                }else{
                    echo json_encode(['status'=>'error','code'=>201,'msg'=>'添加失败']);
                }
            }
        }

    }

    // del center
    public function delCenter(){
        $id = input('post.id');
        $res = Db::name('center')->where('id',$id)->delete();
        if($res == 1){
            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);
        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }

    // del center_assessment_type
    public function delCenterAssessmentType(){
        $id = input('post.id');
        $res = Db::name('center_assessment_type')->where('id',$id)->delete();
        if($res == 1){
            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);
        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }
}
