<?php

namespace app\admin\controller;

use app\admin\logic\GetViewMenuPermission;

use think\Controller;

use think\Request;
use think\Db;

use app\admin\model\AppTrace;
use app\admin\model\Logs;
use app\admin\model\AppTraceUpdate;
use app\admin\model\Chats;
use app\admin\model\User;

use think\Validate;

// APP 数据跟踪
class Trace extends Common{

    // 状态
    protected $status_arr = [1=>'已上架',2=>'审核中',3=>'待审核',4=>'账号禁用',5=>'分配中',6=>'已暂停',7=>'待验证',8=>'已下架',9=>'账号关联',10=>'更新中',11=>'其他'];

    // GOOGLE SEARCH 状态
    protected $google_sharch_status = [1=>'已验证',0=>'未验证'];

    // HTTPS 启用状态
    protected $https_status = [1=>'已启用',0=>'未启用'];

    // 类型: 1：H5 2：原生 3:UNIAPP 4:H5+TP 5:其他 6: Unity 7:Cocos
    protected $appType = [1=>'H5',2=>'原生',3=>'UNIAPP',4=>'H5+TP',5=>'IOS',6=>'Unity',7=>'Cocos'];

    // 年月日数据
    public function traceListymd(){
        $trace = new AppTrace();

        $bag_time = input('get.bag_time');
        $b_project = input('get.b_project');
        $publish_id = input('get.publish_id');
        $down_reason = input('get.down_reason');
        $down_time = input('get.down_time');
        $up_time = input('get.up_time');

        $yearInput = input('get.yearInput');
        $monthInput = input('get.monthInput');


        // 获取当前的年月日
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        $logsData  = '搜索条件：<br>';

        if(!empty($yearInput) && empty($monthInput)){
            $map['create_time'] = ['like',$yearInput.'%'];
            $this->assign('yearInput',$yearInput);
            $logsData .= "按年查询为：".$yearInput." <br>";
        }

        if(!empty($yearInput) && !empty($monthInput)){
            $map['create_time'] = ['like',$yearInput.'-'.$monthInput.'%'];
            $this->assign('yearInput',$yearInput);
            $this->assign('monthInput',$monthInput);
            $logsData .= "按年月查询为：".$yearInput."-".$monthInput." <br>";
        }



        /**
         * 提包日期
         * 1 周
         * 2 月
         * 3 年 
         */ 
        if($bag_time == 1){
            
            $week_start = strtotime("$year/$month/$day");
            $week_end = strtotime("-1 week", $week_start);
            $week_start = date('Y/m/d', $week_start);
            $week_end = date('Y/m/d', $week_end);

            $map['bag_time'] = ['between',[$week_end,$week_start]];

            $this->assign('bag_time',$bag_time);
            $logsData .= "提包日期为：周 <br>";

        }else if($bag_time == 2){

            // 计算一个月后的年月日
            $month_start = strtotime("$year/$month/$day");
            $month_end = strtotime("-1 month", $month_start);
            $month_start = date('Y/m/d', $month_start);
            $month_end = date('Y/m/d', $month_end);

            $map['bag_time'] = ['between',[$month_end,$month_start]];

            $this->assign('bag_time',$bag_time);
            $logsData .= "提包日期为：月 <br>";

        }else if($bag_time == 3){
            // 计算一年后的年月日
            $year_start = strtotime("$year/$month/$day");
            $year_end = strtotime("-1 year", $year_start);
            $year_start = date('Y/m/d', $year_start);
            $year_end = date('Y/m/d', $year_end);

            $map['bag_time'] = ['between',[$year_end,$year_start]];

            $this->assign('bag_time',$bag_time);
            $logsData .= "提包日期为：年 <br>";
        }

        /**
         * 上架日期
         * 1 周
         * 2 月
         * 3 年 
         */ 
        if($up_time == 1){
            
            $week_start = strtotime("$year/$month/$day");
            $week_end = strtotime("-1 week", $week_start);
            $week_start = date('Y/m/d', $week_start);
            $week_end = date('Y/m/d', $week_end);

            $map['up_time'] = ['between',[$week_end,$week_start]];

            $this->assign('up_time',$up_time);
            $logsData .= "上架日期为：周 <br>";

        }else if($up_time == 2){

            // 计算一个月后的年月日
            $month_start = strtotime("$year/$month/$day");
            $month_end = strtotime("-1 month", $month_start);
            $month_start = date('Y/m/d', $month_start);
            $month_end = date('Y/m/d', $month_end);

            $map['up_time'] = ['between',[$month_end,$month_start]];

            $this->assign('up_time',$up_time);
            $logsData .= "上架日期为：月 <br>";

        }else if($up_time == 3){
            // 计算一年后的年月日
            $year_start = strtotime("$year/$month/$day");
            $year_end = strtotime("-1 year", $year_start);
            $year_start = date('Y/m/d', $year_start);
            $year_end = date('Y/m/d', $year_end);

            $map['up_time'] = ['between',[$year_end,$year_start]];

            $this->assign('up_time',$up_time);
            $logsData .= "上架日期为：年 <br>";
        }

        /**
         * 下架日期
         * 1 周
         * 2 月
         * 3 年 
         */ 
        if($down_time == 1){
            
            $week_start = strtotime("$year/$month/$day");
            $week_end = strtotime("-1 week", $week_start);
            $week_start = date('Y/m/d', $week_start);
            $week_end = date('Y/m/d', $week_end);

            $map['down_time'] = ['between',[$week_end,$week_start]];

            $this->assign('down_time',$down_time);
            $logsData .= "下架日期为：周 <br>";

        }else if($down_time == 2){

            // 计算一个月后的年月日
            $month_start = strtotime("$year/$month/$day");
            $month_end = strtotime("-1 month", $month_start);
            $month_start = date('Y/m/d', $month_start);
            $month_end = date('Y/m/d', $month_end);

            $map['down_time'] = ['between',[$month_end,$month_start]];

            $this->assign('down_time',$down_time);
            $logsData .= "下架日期为：月 <br>";

        }else if($down_time == 3){
            // 计算一年后的年月日
            $year_start = strtotime("$year/$month/$day");
            $year_end = strtotime("-1 year", $year_start);
            $year_start = date('Y/m/d', $year_start);
            $year_end = date('Y/m/d', $year_end);

            $map['down_time'] = ['between',[$year_end,$year_start]];

            $this->assign('down_time',$down_time);
            $logsData .= "下架日期为：年 <br>";
        }

        if(!empty($b_project)){
            $map['b_project'] = $b_project;
            $this->assign('b_project',$b_project);
            $logsData .= "跳转项目组为：".$b_project." <br>";
        }

        if(!empty($publish_id)){
            $map['publish_id'] = $publish_id;
            $this->assign('publish_id',$publish_id);
            $logsData .= "提包人为：".getUserNameToId($publish_id)." <br>";
        }

        if(!empty($down_reason)){
            $map['down_reason'] = $down_reason;
            $this->assign('down_reason',$down_reason);
            $logsData .= "下架原因为：".$down_reason." <br>";
        }


        if(empty($b_project) && empty($publish_id) && empty($down_reason) && empty($bag_time) && empty($up_time) && empty($down_time) && empty($yearInput) && empty($monthInput)){

            $info = $trace->where($map)->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

        }else{

            $info = $trace->where($map)
                        ->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
                        'query'    => request()->param()
            ]);

            Logs::create([
                'title'   => '查询数据',
                'content' => $logsData,
            ]);
        }

        $count = $trace->where($map)->count();

         // 发布人员
        $user = new User();
        $userInfo = $user->where(['open'=>'on'])->order('id asc')->field('id,username,nickname')->select()->toArray();

        // 跳转项目组
        $bProject = Db::table('b_project')->select();


        
        
        $this->assign('bProject',$bProject);
        $this->assign('count',$count);
        $this->assign('userInfo',$userInfo);

        $this->assign('role_id',$this->roleId);
        $this->assign('info',$info);
        return view();
    }


    // ALL
    public function traceList(){

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);

        $trace = new AppTrace();

        $app_name = input('get.app_name');
        $package_name = input('get.package_name');
        // $bag_vps = input('get.bag_vps');
        $api_vps = input('get.api_vps');
        $bag_time = input('get.bag_time');
        $status = input('get.status');
        $domain_url = input('get.domain_url');
        $app_password = input('get.app_password');
        $b_project = input('get.b_project');
        $app_type = input('get.app_type');

        $logsData  = '搜索条件：<br>';

        if(!empty($status)){
            $map['status'] = $status;
            $logsData .= "状态为：".$this->status_arr[$status]." <br>";
        }

        if(!empty($app_type)){
            $map['app_type'] = $app_type;
            $logsData .= "类型为：".$this->appType[$app_type]." <br>";
        }

        if(!empty($b_project)){
            $map['b_project'] = $b_project;
            $logsData .= "跳转项目组为：".$b_project." <br>";
        }

        if(!empty($app_name)){
            $map['app_name'] = ['like','%'.$app_name.'%'];
            $logsData .= "应用名为：".$app_name."<br> ";
        }else{
            $map['app_name'] = ['<>',' '];
        }

        if(!empty($package_name)){
            $map['package_name'] = $package_name;
            $logsData .= "包名为：".$package_name."<br> ";
        }

        // if(!empty($bag_vps)){
        //     $map['bag_vps'] = $bag_vps;
        //     $logsData .= "bag_vps为: ".$bag_vps."<br> ";
        // }

        if(!empty($api_vps)){
            $map['api_vps'] = $api_vps;
            $logsData .= "api_vps为: ".$api_vps."<br> ";
        }

        if(!empty($bag_time)){
            $map['bag_time'] = $bag_time;
            $logsData .= "提包日期为：".$bag_time."<br> ";
        }

        if(!empty($domain_url)){
            $map['domain_url'] = $domain_url;
            $logsData .= "域名地址为：".$domain_url."<br> ";
        }

        if(!empty($app_password)){
            $map['app_password'] = $app_password;
            $logsData .= "密码为：".$app_password."<br> ";
        }


        if(empty($app_name) && empty($status) && empty($package_name)  && empty($api_vps) && empty($bag_time) && empty($domain_url) && empty($app_password) && empty($b_project) && empty($app_type)){

            $info = $trace->where($map)->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

        }else{

            $info = $trace->where($map)
                        ->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
                        'query'    => request()->param()
            ]);

            Logs::create([
                'title'   => '查询数据',
                'content' => $logsData,
            ]);
        }

        $count = $trace->where($map)->count();

         // 发布人员
        $user = new User();
        $userInfo = $user->where(['open'=>'on'])->order('id asc')->field('id,username,nickname')->select()->toArray();

        // 跳转项目组
        $bProject = Db::table('b_project')->select();


        $this->assign('b_project',$b_project);
        $this->assign('bProject',$bProject);
        $this->assign('count',$count);
        $this->assign('userInfo',$userInfo);

        $this->assign('app_type',$app_type);
        $this->assign('app_name',$app_name);
        $this->assign('status',$status);
        $this->assign('package_name',$package_name);
        // $this->assign('bag_vps',$bag_vps);
        $this->assign('api_vps',$api_vps);
        $this->assign('bag_time',$bag_time);
        $this->assign('domain_url',$domain_url);
        $this->assign('app_password',$app_password);
        $this->assign('info',$info);
        $this->assign('role_id',$this->roleId);

        return view();
    }

    // 已上架
    public function toStatusOneList(){

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);

        $trace = new AppTrace();

        $app_name = input('get.app_name');
        $package_name = input('get.package_name');
        $bag_vps = input('get.bag_vps');
        // $api_vps = input('get.api_vps');
        $bag_time = input('get.bag_time');
        $status = input('get.status');
        $domain_url = input('get.domain_url');
        $app_password = input('get.app_password');
        $b_project = input('get.b_project');
        $app_type = input('get.app_type');
        

        $logsData  = '搜索条件：<br>';

        $map['status'] = 1;

        if(!empty($app_name)){
            $map['app_name'] = ['like','%'.$app_name.'%'];
            $logsData .= "应用名为：".$app_name."<br> ";
        }else{
            $map['app_name'] = ['<>',' '];
        }

        if(!empty($app_type)){
            $map['app_type'] = $app_type;
            $logsData .= "类型为：".$this->appType[$app_type]." <br>";
        }

        if(!empty($b_project)){
            $map['b_project'] = $b_project;
            $logsData .= "跳转项目组为：".$b_project." <br>";
        }

        if(!empty($package_name)){
            $map['package_name'] = $package_name;
            $logsData .= "包名为：".$package_name."<br> ";
        }

        // if(!empty($bag_vps)){
        //     $map['bag_vps'] = $bag_vps;
        //     $logsData .= "bag_vps为: ".$bag_vps."<br> ";
        // }

        if(!empty($api_vps)){
            $map['api_vps'] = $api_vps;
            $logsData .= "api_vps为: ".$api_vps."<br> ";
        }

        if(!empty($bag_time)){
            $map['bag_time'] = $bag_time;
            $logsData .= "提包日期为：".$bag_time."<br> ";
        }

        if(!empty($domain_url)){
            $map['domain_url'] = $domain_url;
            $logsData .= "域名地址为：".$domain_url."<br> ";
        }

        if(!empty($app_password)){
            $map['app_password'] = $app_password;
            $logsData .= "密码为：".$app_password."<br> ";
        }


        if(empty($app_name) && empty($status) && empty($package_name)  && empty($api_vps) && empty($bag_time) && empty($domain_url) && empty($app_password) && empty($b_project) && empty($app_type)){

            $info = $trace->where($map)->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

        }else{

            $info = $trace->where($map)
                        ->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
                        'query'    => request()->param()
            ]);

            Logs::create([
                'title'   => '查询已上架数据',
                'content' => $logsData,
            ]);
        }

        $count = $trace->where($map)->count();
        $this->assign('count',$count);

        // 发布人员
        $user = new User();
        $userInfo = $user->where(['open'=>'on'])->order('id asc')->field('id,username,nickname')->select()->toArray();


        $this->assign('userInfo',$userInfo);

        // 跳转项目组
        $bProject = Db::table('b_project')->select();


        $this->assign('b_project',$b_project);
        $this->assign('bProject',$bProject);


        $this->assign('app_type',$app_type);
        $this->assign('app_name',$app_name);
        $this->assign('status',$status);
        $this->assign('package_name',$package_name);
        $this->assign('bag_vps',$bag_vps);
        // $this->assign('api_vps',$api_vps);
        $this->assign('bag_time',$bag_time);
        $this->assign('domain_url',$domain_url);
        $this->assign('app_password',$app_password);
        $this->assign('info',$info);
        $this->assign('role_id',$this->roleId);

        return view();
    }

    // 审核中
    public function toStatusInProcess(){

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);

        $trace = new AppTrace();

        $app_name = input('get.app_name');
        $package_name = input('get.package_name');
        // $bag_vps = input('get.bag_vps');
        $api_vps = input('get.api_vps');
        $bag_time = input('get.bag_time');
        $domain_url = input('get.domain_url');
        $app_password = input('get.app_password');
        $b_project = input('get.b_project');
        $app_type = input('get.app_type');

        $logsData  = '搜索条件：<br>';

        $map['status'] = 2;

        if(!empty($app_name)){
            $map['app_name'] = ['like','%'.$app_name.'%'];
            $logsData .= "应用名为：".$app_name."<br> ";
        }else{
            $map['app_name'] = ['<>',' '];
        }

        if(!empty($app_type)){
            $map['app_type'] = $app_type;
            $logsData .= "类型为：".$this->appType[$app_type]." <br>";
        }

        if(!empty($b_project)){
            $map['b_project'] = $b_project;
            $logsData .= "跳转项目组为：".$b_project." <br>";
        }

        if(!empty($package_name)){
            $map['package_name'] = $package_name;
            $logsData .= "包名为：".$package_name."<br> ";
        }

        // if(!empty($bag_vps)){
        //     $map['bag_vps'] = $bag_vps;
        //     $logsData .= "bag_vps为: ".$bag_vps."<br> ";
        // }

        if(!empty($api_vps)){
            $map['api_vps'] = $api_vps;
            $logsData .= "api_vps为: ".$api_vps."<br> ";
        }

        if(!empty($bag_time)){
            $map['bag_time'] = $bag_time;
            $logsData .= "提包日期为：".$bag_time."<br> ";
        }

        if(!empty($domain_url)){
            $map['domain_url'] = $domain_url;
            $logsData .= "域名地址为：".$domain_url."<br> ";
        }

        if(!empty($app_password)){
            $map['app_password'] = $app_password;
            $logsData .= "密码为：".$app_password."<br> ";
        }




        if(empty($app_name)  && empty($package_name) && empty($api_vps) && empty($bag_time) && empty($domain_url) && empty($app_password) && empty($b_project) && empty($app_type)){

            $info = $trace->where($map)->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',  
                        'var_page' => 'page',
            ]);

        }else{

            $info = $trace->where($map)
                        ->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
                        'query'    => request()->param()
            ]);

            Logs::create([
                'title'   => '查询审核中数据',
                'content' => $logsData,
            ]);
        }

        $count = $trace->where($map)->count();
        $this->assign('count',$count);

        // 发布人员
        $user = new User();
        $userInfo = $user->where(['open'=>'on'])->order('id asc')->field('id,username,nickname')->select()->toArray();


        $this->assign('userInfo',$userInfo);

        // 跳转项目组
        $bProject = Db::table('b_project')->select();


        $this->assign('b_project',$b_project);
        $this->assign('bProject',$bProject);


        $this->assign('app_type',$app_type);
        $this->assign('app_name',$app_name);
        $this->assign('package_name',$package_name);
        // $this->assign('bag_vps',$bag_vps);
        $this->assign('api_vps',$api_vps);
        $this->assign('bag_time',$bag_time);
        $this->assign('domain_url',$domain_url);
        $this->assign('app_password',$app_password);
        $this->assign('info',$info);
        $this->assign('role_id',$this->roleId);

        return view();
    }

    // 新增 更新
    /*
    status ：状态：1: 上线  0: 离线
    app_name ：应用名
    app_function ：功能
    app_type ：类型
    app_package ：包
    app_gmail ： 谷歌邮箱
    app_password ： 密码
    google_auth ： 身份验证
    bag_vps : 提包服务器
    api_vps : 接口服务器
    bag_time : 提包日期
    blocked_cause ： 被封原因
    google_play_link ： Google Play链接
    signature ： 数字签名
    package_name ： 包名
    main_name ： 主类名
    domain_url ： 域名地址
    privacy_agreement_url ： 隐私协议地址
    jump_switch ：跳转开关 1：开启 0：关闭
    jump_url ： 跳转链接
    */
    public function publicSaveTrace($id = 0){

        $user_id = session('user.id');      // 用户id

        $role_name = getUserRoleInfo($user_id)[0]['name'];

        $trace = new AppTrace();

        if(request()->isPost()){

            if($role_name == '测试'){
                $data['test_id'] = $user_id;
                $data['test_time'] = date("Y-m-d H:i:s", time());
            }

            $data['status']                   = input('post.status');
            $data['app_name']                 = input('post.app_name');
            $data['app_function']             = input('post.app_function');
            $data['app_type']                 = input('post.app_type');
            $data['app_package']              = input('post.app_package');
            $data['app_gmail']                = input('post.app_gmail');
            $data['vps_password']             = input('post.vps_password');
            $data['google_auth']              = input('post.google_auth');
            $data['bag_vps']                  = input('post.bag_vps');
            $data['api_vps']                  = input('post.api_vps');
            $data['bag_time']                 = input('post.bag_time');
            $data['blocked_cause']            = input('post.blocked_cause');
            $data['google_play_link']         = input('post.google_play_link');
            $data['signature']                = input('post.signature');
            $data['package_name']             = input('post.package_name');
            $data['main_name']                = input('post.main_name');
            $data['domain_url']               = input('post.domain_url');
            $data['privacy_agreement_url']    = input('post.privacy_agreement_url');
            $data['jump_switch']              = input('post.jump_switch');
            $data['jump_url']                 = input('post.jump_url');
            $data['google_sharch_status']     = input('post.google_sharch_status');
            $data['https_status']             = input('post.https_status');
            $data['up_time']                  = input('post.up_time');
            $data['down_time']                = input('post.down_time');
            // $data['update_batch']             = input('post.update_batch');
            // $data['update_reason']            = input('post.update_reason');
            $data['down_reason']              = input('post.down_reason');
            $data['enter_time']               = date('Y-m-d H:i:s',time());

            $data['google_email_password']    = input('post.google_email_password');
            $data['google_assist_email']      = input('post.google_assist_email');
            $data['spare_code']               = input('post.spare_code');
            $data['vps_username']             = input('post.vps_username');
            $data['afdev']                    = input('post.afdev');
            $data['afaccount']                = input('post.afaccount');
            $data['sha1']                     = input('post.sha1');
            $data['tele_chatid']              = input('post.tele_chatid');
            $data['update_switch']            = input('post.update_switch');
            $data['update_url']               = input('post.update_url');
            $data['publish_id']               = input('post.publish_id');
            $data['k3']                       = input('post.k3');
            $data['k4']                       = input('post.k4');
            $data['b_project']                = input('post.b_project');

            if(!empty(input('post.image'))){
                $data['image'] = input('post.image');
            }

            if($id != 0){
                $trace = $trace::get($id);

                $title = '更新数据';
                $logsData = "更新id： ".$id." 的数据为：".json_encode($data,JSON_UNESCAPED_UNICODE);
            }else{
                $data['user_id'] = $user_id;
                
                $title = '新增数据';
                $logsData = "新增数据:".json_encode($data,JSON_UNESCAPED_UNICODE);

                $rules = [
                    'domain_url'   => 'unique:app_trace',
                    'package_name' => 'unique:app_trace'
                ];

                $message = [
                    'domain_url.unique'    => '域名地址已存在',
                    'package_name.unique'  => '包名已存在' 
                ];

                $validate = new Validate($rules,$message);

                $result = $validate->check($data);

                if(!$result){
                    return error($validate->getError());
                }
            }

            // 启动事务
            Db::startTrans();
            try {

                if($trace->save($data) == 1){

                    $update_reason = input('post.update_reason');

                    Logs::create([
                        'title'   => $title,
                        'content' => $logsData.json_encode([
                            '更新批次为：' => getAppTraceUpdate($trace->id) + 1,
                            '更新原因为：' => $update_reason
                        ],JSON_UNESCAPED_UNICODE),
                    ]);
    
                    AppTraceUpdate::create([
                        'app_id' => $trace->id,
                        'update_batch' => getAppTraceUpdate($trace->id) + 1,
                        'update_reason' => $update_reason
                    ]);

                    // 提交事务
                    Db::commit(); 
      
                    return success('保存成功',url('tracelist'));
                }else{
                    return error('请更新数据！');
                }

                
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
            
            

        }else{

            $getInfo = $trace->find($id);

            $this->assign('getInfo',$getInfo);

            // tele_chatid
            $tele_chatid = $getInfo->tele_chatid;

            // chats
            $chat = new Chats();
            $chats = $chat->order('id asc')->field('chat_id,id')->select()->toArray();

            foreach($chats as $key => $value){
                $chats[$key]['name'] = $value['chat_id'];
                $chats[$key]['value'] = $value['id'];
                if(strpos($tele_chatid,$chats[$key]['name']) !== false){
                    $chats[$key][selected] = true;
                }
                unset($chats[$key]['chat_id']);
                unset($chats[$key]['id']);
            }

            $chats =  json_encode($chats);

            // 发布人员
            $user = new User();
            $userInfo = $user->where(['open'=>'on'])->order('id asc')->field('id,username,nickname')->select()->toArray();
            
            $this->assign('userInfo',$userInfo);

            $this->assign('chats',$chats);
            $this->assign('tele_chatid',$tele_chatid);
            return view();
        }
    }

    // 更新已上架数据
    public function publicSaveTraceOne($id = 0){

        $user_id = session('user.id');      // 用户id

        $role_name = getUserRoleInfo($user_id)[0]['name'];

        $trace = new AppTrace();

        if(request()->isPost()){

            if($role_name == '测试'){
                $data['test_id'] = $user_id;
                $data['test_time'] = date("Y-m-d H:i:s", time());
            }

            $data['app_name']                 = input('post.app_name');
            $data['package_name']             = input('post.package_name');
            $data['main_name']                = input('post.main_name');
            $data['vps_password']             = input('post.vps_password');
            $data['bag_vps']                  = input('post.bag_vps');
            $data['api_vps']                  = input('post.api_vps');
            $data['google_play_link']         = input('post.google_play_link');
            $data['privacy_agreement_url']    = input('post.privacy_agreement_url');
            $data['signature']                = input('post.signature');
            $data['up_time']                  = input('post.up_time');
            $data['enter_time']               = date('Y-m-d H:i:s',time());

            $trace = $trace::get($id);

            $title = '更新已上架数据';
            $logsData = "更新id： ".$id." 的数据为：".json_encode($data,JSON_UNESCAPED_UNICODE);


            // 启动事务
            Db::startTrans();
            try {

                if($trace->save($data) == 1){

                    $update_reason = input('post.update_reason');

                    Logs::create([
                        'title'   => $title,
                        'content' => $logsData.json_encode([
                            '更新批次为：' => getAppTraceUpdate($trace->id) + 1,
                            '更新原因为：' => $update_reason
                        ],JSON_UNESCAPED_UNICODE),
                    ]);
    
                    AppTraceUpdate::create([
                        'app_id' => $trace->id,
                        'update_batch' => getAppTraceUpdate($trace->id) + 1,
                        'update_reason' => $update_reason
                    ]);

                    // 提交事务
                    Db::commit(); 
      
                    return success('保存成功',url('toStatusOneList'));
                }else{
                    return error('请更新数据！');
                }

                
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
            
            

        }else{

            $getInfo = $trace->find($id);

            $this->assign('getInfo',$getInfo);

            return view();
        }
    }


    // 删除
    public function delTrace(){
        $id = input('post.id');

        $trace = new AppTrace();
        $res = $trace::destroy($id);
        if($res == 1){

            $logsData = "删除数据【id： ".$id."】 的数据";

            Logs::create([
                'title'   => '删除数据',
                'content' => $logsData,
            ]);

            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);

        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }  
    
    // 更新类型
    public function saveAppType(){

        if(request()->isPost()){

            $id = input('post.id');
            $app_type = input('post.app_type');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'app_type'=>$app_type]);


            if($result){

                $logsData = "更新数据【id： ".$id."】 的类型修改为：<strong>".$this->appType[$app_type]."</strong>";

                Logs::create([
                    'title'   => '更新类型',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>$this->appType[$app_type]]);

            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'error']);
            }
        }
    }

    // 更新发布人员 
    public function savePublish(){

        if(request()->isPost()){

            $id = input('post.id');
            $publish_id = input('post.publish_id');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'publish_id'=>$publish_id]);

            $user = new User();

            if($result){

                $logsData = "更新数据【id： ".$id."】 的发布人员修改为：<strong>".$user->getNickname($publish_id)."</strong>";

                Logs::create([
                    'title'   => '更新类型',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>$user->getNickname($publish_id)]);

            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'error']);
            }
        }
    }

    // 更新域名验证
    public function saveGoogleSharchStatus(){

        if(request()->isPost()){

            $id = input('post.id');
            $google_sharch_status = input('post.google_sharch_status');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'google_sharch_status'=>$google_sharch_status]);

            if($result){

                $logsData = "更新数据【id： ".$id."】 的域名验证为：<strong>".$this->google_sharch_status[$google_sharch_status]."</strong>";

                Logs::create([
                    'title'   => '更新域名验证',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>$this->google_sharch_status[$google_sharch_status]]);

            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'error']);
            }
        }
    }

    // 更新HTTPS 启用状态
    public function saveHttpsStatus(){

        if(request()->isPost()){

            $id = input('post.id');
            $https_status = input('post.https_status');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'https_status'=>$https_status]);

            if($result){

                $logsData = "更新数据【id： ".$id."】 的HTTPS 启用状态为：<strong>".$this->https_status[$https_status]."</strong>";

                Logs::create([
                    'title'   => '更新HTTPS 启用状态',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>$this->https_status[$https_status]]);

            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'error']);
            }
        }
    }

    // 更新状态
    public function saveStatus(){

        if(request()->isPost()){

            $id = input('post.id');
            $status = input('post.status');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'status'=>$status]);

            if($result){

                $logsData = "更新数据【id： ".$id."】 的状态为：<strong>".$this->status_arr[$status]."</strong>";

                Logs::create([
                    'title'   => '更新状态',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>$this->status_arr[$status]]);

            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'error']);
            }
        }
    }

    // 切换跳转开关
    public function switchTrace(){

        if(request()->isPost()){

            $id = input('post.id');
            $jump_switch = input('post.jump_switch');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'jump_switch'=>$jump_switch]);

            if($result){

                if($jump_switch == 'on'){

                        $logsData = "切换跳转开关【id： ".$id."】 的状态为：<strong>开启</strong>";

                        Logs::create([
                            'title'   => '切换跳转开关',
                            'content' => $logsData,
                        ]);

                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'开启']);
                }else{
                    $logsData = "切换跳转开关【id： ".$id."】 的状态为：<strong>关闭</strong>";

                    Logs::create([
                        'title'   => '切换跳转开关',
                        'content' => $logsData,
                    ]);
                    
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'关闭']);
                }

                
            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'切换跳转开关失败']);
            }
        }

    }

    // 热更新开关
    public function updateSwitchTrace(){
        
        if(request()->isPost()){

            $id = input('post.id');
            $update_switch = input('post.update_switch');

            $trace = new AppTrace();

            $result = $trace->isUpdate(true)->save(['id'=>$id,'update_switch'=>$update_switch]);

            if($result){

                if($update_switch == 'on'){

                        $logsData = "切换热更新开关【id： ".$id."】 的状态为：<strong>开启</strong>";

                        Logs::create([
                            'title'   => '切换热更新开关',
                            'content' => $logsData,
                        ]);

                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'开启']);
                }else{
                    $logsData = "切换热更新开关【id： ".$id."】 的状态为：<strong>关闭</strong>";

                    Logs::create([
                        'title'   => '切换热更新开关',
                        'content' => $logsData,
                    ]);
                    
                    echo json_encode(['status'=>'success','code'=>200,'msg'=>'关闭']);
                }

                
            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'切换热更新开关失败']);
            }
        }
    }

    // 显示更新原因数据信息
    public function showAppTraceUpdate(){

        if(request()->isPost()){

            $id = input('post.id');
            $result = AppTraceUpdate::where('app_id',$id)->order('update_batch asc')->select();

            if($result){

                $logsData = "显示更新原因数据 【id为： ".$id."】";

                Logs::create([
                    'title'   => '显示更新原因数据',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>'查询成功','data'=>$result]);
            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'无数据']);
            }
        }

        
    }

    // 上传图片
    public function uploads(){
        $file = request()->file('file');

        $id = input('post.id');

        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');

        if($info){
            // 成功上传后 输出 20231115/42a79759f284b767dfcb2a0197904287.jpg
            $saveName = str_replace('\\','/',$info->getSaveName());

            if($id > 0){

                $title = '更新图片';
                $logsData = "更新数据【id： ".$id."】 的图片信息：<img src='/public/uploads/".$saveName."'>";

            }else{

                $title = '上传图片';
                $logsData = "<img src='/public/uploads/".$saveName."'>";

            }

            Logs::create([
                'title'   => $title,
                'content' => $logsData,
            ]);

            echo json_encode([
                'status'   => 'success',
                'code'     => 200,
                'msg'      => '上传成功',
                'data'     => [
                    'saveName' => $saveName
                ]
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'code'   => 0,
                'msg'    => $file->getError()
            ]);
        }
    }

    // 删除图片
    public function delImage(){

        if(request()->isPost()){

            $id = input('post.id');

            $image = input('post.image');

            $filename  = ROOT_PATH .'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$image;        

            $trace = new AppTrace();

            $result = $trace->where('id',$id)->update(['image'=>'']);

            if($result){

                if(file_exists($filename)){
                    @unlink($filename);
                }

                $logsData = "删除图片 【id为： ".$id."】";

                Logs::create([
                    'title'   => '删除图片',
                    'content' => $logsData,
                ]);

                echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除图片成功']);
            }else{
                echo json_encode(['status'=>'error','code'=>0,'msg'=>'删除图片失败']);
            }

        }
    }

    // 一键复制
    public function copyTrace(){
        $id = input('post.id');

        $trace = new AppTrace();

        $data = $trace::where(['id'=>$id])->find()->toArray();

        unset($data['id']);

        $result = $trace->create($data);

        if($result){
            echo json_encode(['status'=>'success','code'=>200,'msg'=>'一键复制成功']);
        }else{
            echo json_encode(['status'=>'error','code'=>0,'msg'=>'一键复制失败']);
        }

    }


    // 项目组汇总
    public function projectgather(){

        $time = input('get.time','year');
        // 第一步查询 b_project 字段的 distinct 值
        $bProjectValues = Db::name('app_trace')->where('b_project <> "" ')->distinct(true)->column('b_project');

        // 第二步根据第一步结果查询 status 中已上架、已下架和审核中的数据条数
        // 1=>'已上架',2=>'审核中',3=>'待审核',4=>'账号禁用',5=>'分配中',6=>'已暂停',7=>'待验证',8=>'已下架',9=>'账号关联',10=>'更新中',11=>'其他'
        $result = Db::name('app_trace')
            ->field('b_project, 
                SUM(CASE WHEN status = "1" THEN 1 ELSE 0 END) AS 已上架,
                SUM(CASE WHEN status = "2" THEN 1 ELSE 0 END) AS 审核中,
                SUM(CASE WHEN status = "3" THEN 1 ELSE 0 END) AS 待审核,
                SUM(CASE WHEN status = "4" THEN 1 ELSE 0 END) AS 账号禁用,
                SUM(CASE WHEN status = "5" THEN 1 ELSE 0 END) AS 分配中,
                SUM(CASE WHEN status = "6" THEN 1 ELSE 0 END) AS 已暂停,
                SUM(CASE WHEN status = "7" THEN 1 ELSE 0 END) AS 待验证,
                SUM(CASE WHEN status = "8" THEN 1 ELSE 0 END) AS 已下架,
                SUM(CASE WHEN status = "9" THEN 1 ELSE 0 END) AS 账号关联,
                SUM(CASE WHEN status = "10" THEN 1 ELSE 0 END) AS 更新中,
                SUM(CASE WHEN status = "11" THEN 1 ELSE 0 END) AS 其他
            ')
            ->whereIn('b_project', $bProjectValues)
            ->whereTime('update_time', $time)
            ->group('b_project')
            ->select();

        $this->assign('time',$time);
        $this->assign('result',$result);

        return view();
    }

    // 显示项目组数据列表数据
    public function showProject(){
        $data = input('post.');

        $trace = new AppTrace();

        $result = $trace->where($data)->select();

        if($result){
            echo json_encode(['status'=>'success','code'=>200,'msg'=>'查询成功','data'=>$result]);
        }else{
            echo json_encode(['status'=>'error','code'=>0,'msg'=>'无数据']);
        }
    }

}