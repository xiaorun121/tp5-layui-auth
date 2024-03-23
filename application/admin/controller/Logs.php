<?php

namespace app\admin\controller;


use think\Controller;
use app\admin\model\User;
use app\admin\model\Logs as LogsModel;

// APP 数据跟踪
class Logs extends Common{

    // 数据跟踪日志 
    public function logsList(){


        $user_id = input('get.user_id');

        if(!empty($user_id)){

            $result = LogsModel::where('user_id',$user_id)->order('id desc')
                ->paginate(10,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page',
                'query'    => request()->param()
            ]);
        }else{
            $result = LogsModel::order('id desc')
                ->paginate(10,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page',
                'query'    => request()->param()
            ]);
        }

        $user = User::order("id desc")->field("id,username,nickname,open,role_id")->select();

        $this->assign('user',$user);
        $this->assign('result',$result);

        return view();
    }

    // 
    public function liveUpdateLogsList(){

        $result = LogsModel::where('status',2)->order('id desc')
            ->paginate(10,false,[
            'type'     => 'bootstrap',
            'var_page' => 'page',
            'query'    => request()->param()
        ]);

        $this->assign('result',$result);
        return view();
    }

}