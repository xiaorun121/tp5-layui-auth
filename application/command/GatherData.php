<?php
namespace app\command;
 
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Db;
use app\admin\model\Gather;
use think\Log;


// 采集数据
class GatherData extends Command
{		
    /**
     * admin 后台账号
     * api_url 接口后缀地址
     * domain_url 采集网站
     * mt_rand 随机整数
     * week 星期 0表示星期天，1~6表示星期一到星期六。
     * per_page 返回的记录数 指定为1到100之间的整数
     * */ 
    private $admin;
    private $api_url;
    private $domain_url;
    private $mt_rand;
    private $week;
    private $per_page;


    protected function configure()
    {
        $this->setName('GatherData')->setDescription('定时计划测试：每天1点准时采集数据');
    }
 
    protected function execute(Input $input, Output $output)
    {		  
        $this->admin   = 'admin'; 
        $this->api_url = 'wp-json/wp/v2/posts';
        $this->per_page = 20;
        $this->domain_url = ['https://www.westriverfca.org/','https://philadelphiaalternativemedicin.com/','https://fireextinguishersnottingham.com/','https://www.igoexchange.com/','https://oasesnetwork.com/'];
        $this->mt_rand = mt_rand(0,4);
        $this->week = date("w"); 

		$output->writeln("start....");
        
        $this->gather();
        
        $output->writeln("end....");
    }

		//定时任务代码
	public function gather(){
		    //更新数据代码
        Log::info('定时计划测试：每天1点准时采集数据');

        // 1、采集数据到数据库
        if($this->week > 4){
            $domain_url_check = $this->domain_url[$this->mt_rand];
        }else{
            $domain_url_check = $this->domain_url[$this->week];
        }



        $url = $domain_url_check.$this->api_url.'?per_page='.$this->per_page;

        Log::info($url);

        $result = curl_get($url);

        $resultInfo = json_decode($result,true);

        // Log::info($resultInfo);

        $gather = new Gather();

        if(is_array($resultInfo)){
            foreach($resultInfo as $key => $val){

                $sql = $gather->where(['title'=>$val['title']['rendered']])->find();
                if($sql){
                    $msg = "更新数据";
                }else{
                    $msg = "新增数据";
                    $resArr[$key]['title']   = $val['title']['rendered'];
                    $resArr[$key]['content'] = $val['content']['rendered'];
                    $resArr[$key]['status']  = $val['status'];
                }
                
            }
        }else{
            Log::info("error array");
        }

        

        if(!empty($resArr)){
            $info = $gather->saveAll($resArr);

            if($info){
                Log::info("{$msg}");
            }else{
                Log::info('数据更新失败');
            }
        }else{
            Log::info('采集失败');
        }
    }


    
 
}