<?php
namespace app\command;
 
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Db;
use app\admin\model\Gather;
use app\admin\model\Backend;
use app\admin\model\Publish;
use think\Log;

// 将采集最新的数据直接发布到站群网站中
class Task extends Command
{       
    /**
     * admin 后台账号
     * api_url 接口后缀地址
     * */ 
    private $admin;
    private $api_url;

    protected function configure()
    {
        $this->setName('Task')->setDescription('定时计划测试：每天2点准时发布到站群网站中');
    }
 
    protected function execute(Input $input, Output $output)
    {       
        $this->admin   = 'admin'; 
        $this->api_url = 'wp-json/wp/v2/posts';
         
        $output->writeln("start....");
        $this->tasks();
        $output->writeln("end....");
    }
        
    //定时任务代码
    public function tasks(){
        //更新数据代码
        Log::info("定时计划测试：每天2点准时发布到站群网站中");

        $gather  = new Gather();
        $backend = new Backend();

        // $gatherData = $gather->whereTime('create_time','today')->field('id,title,content,status')->order('id desc')->select()->toArray();

        // // 查询后台数据
        $backendData = $backend->select()->toArray();

        // 将采集数据 和 后台数据 进行整合
        $con = 0;

        $gatherCount = 0;

        foreach($backendData as $key => $value){

            $gatherData = $gather->whereTime('create_time','today')->order("rand()")->field('id,title,content,status')->limit(mt_rand(5,10))->order('id desc')->select()->toArray();

            // 循环后台数据的同时 记录 每次查询采集的数量 求和
            $gatherCount += count($gatherData);

            foreach($gatherData as $k => $v){

                if($gatherCount > $con){
                    $publishArr[$con]['title']                 = $v['title'];
                    $publishArr[$con]['content']               = $v['content'];
                    $publishArr[$con]['application_password']  = $value['application_password'];
                    $publishArr[$con]['b_title']               = $value['title'];
                    $publishArr[$con]['gather_id']             = $v['id'];
                    $publishArr[$con]['backend_id']            = $value['id'];
                }

                $con++;
            }
        }

        // 判断整合的数据发布表中是否存在，存在的话就不执行，不存在的话就更新

        $publish = new Publish();

        foreach($publishArr as $key => $val){
            $sql = $publish->where(['backend_id'=>$val['backend_id'],'gather_id'=>$val['gather_id']])->find();
            // 存在
            if($sql){
                $msg = "更新发布数据";
                $resArr = array();
            }else{    // 不存在
                $msg = "新增发布数据";
                $resArr[$key]['backend_id']   = $val['backend_id'];
                $resArr[$key]['gather_id']    = $val['gather_id'];
            }
        }

        if(!empty($resArr)){

            $info = $publish->saveAll($resArr);

             if($info){

                Log::info($msg);

                $publishData = $this->publish();

                $publishResult = $this->curlPostPublish($publishData);

                if($publishResult){

                    Log::info("数据发布成功");

                }else{
                    Log::info("数据发布失败");
                }
            }else{
                Log::info("发布数据更新失败");
            }
        }else{
           Log::info("数据不存在");
        }
    }

    // 执行发布操作
    public function publish(){

        $sqlResult = Db::table('ch_publish')
                ->alias('p')
                ->join('ch_gather g','p.gather_id = g.id')
                ->join('ch_backend b','p.backend_id = b.id')
                ->whereTime('p.create_time','today')
                ->field('p.gather_id,p.backend_id,g.title,g.content,b.title b_title,b.url,b.application_password')
                ->select();

        return $sqlResult;

    }

    // curl post 发布数据到wp后台
    public function curlPostPublish($publishData){

        $wait_usec = 0;
        $mh        = curl_multi_init();
        $data      = array();
        $handle    = array();
        $running   = 0;
        $mh        = curl_multi_init(); // multi curl handler
        $i         = 0;

        foreach($publishData as $val){

            $username = $this->admin;
            $application_password = "{$val['application_password']}";
            
            $url = "{$val['b_title']}/{$this->api_url}";
            
            $json = json_encode([
                'title' => "{$val['title']}",
                'content' => "{$val['content']}",
                'status' => 'publish',
            ]);

  
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
            curl_setopt($ch, CURLOPT_MAXREDIRS, 7);
            curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$application_password);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_multi_add_handle($mh, $ch); // 把 curl resource 放进 multi curl handler 里
            $handle[$i++] = $ch;

        }
        /* 执行 */
        do {
            curl_multi_exec($mh, $running);
            if ($wait_usec > 0) /* 每个 connect 要间隔多久 */
                usleep($wait_usec); // 250000 = 0.25 sec
        } while ($running > 0);
        /* 读取资料 */
        foreach($handle as $i => $ch) {
            $content  = curl_multi_getcontent($ch);
            $data[$i] = (curl_errno($ch) == 0) ? $content : false;
        }
        /* 移除 handle*/
        foreach($handle as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        Log::info($data);
        return $data;

    } 
 
}