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
use think\Log;
use QL\QueryList;
use think\Cache;

// 将采集最新的数据直接发布到站群网站中
class GatherOne extends Command
{       
    private $admin;
    private $api_url;

    protected function configure()
    {
        $this->setName('GatherOne')->setDescription('定时计划测试：每天1hours准时采集数据');
    }
 
    protected function execute(Input $input, Output $output)
    {       
         
        $output->writeln("start....");
        $this->tasks();
        $output->writeln("end....");
    }
        
    //定时任务代码
    public function tasks(){
        //更新数据代码
        Log::info("定时计划测试：每天1hours准时采集数据");

        // switch type
        // startIndex 查询的条数 每页20条 以此往后递增
        // https://kotaku.com/reviews/switch?startIndex=60
        // 列表class dYIPCV

        // 文章
        // title class sc-89ec4v-4
        // content class sc-r43lxo-1
        // image class sc-89ec4v-1>img srcset

        // 文章 1
        // title class sc-1efpnfq-1
        // content class sc-r43lxo-1
        // image class sc-epkw7d-0>img src

        if(Cache::get('startIndexOne')){
            $startIndex = Cache::get('startIndexOne');
        }else{
            Cache::set('startIndexOne',1);
            $startIndex = Cache::get('startIndexOne');
        }

        $gather  = new Gather();
        $backend  = new Backend();

        $counts = $backend->where('keywords is null')->count();

        $rand = mt_rand(0,$counts-1);


        $backendInfo = $backend->where('keywords is null')->select()->toArray();

        $title_class = "sc-1efpnfq-1";
        $content_class = "sc-r43lxo-1";

        if(Cache::get('randLinkOne')){
            $link = Cache::get('randLinkOne');
        }else{
            $link = $backendInfo[$rand]['url'];
            Cache::set('randLinkOne',$link);
        }
        
        // Log::info('One-------------------------------------------------------------------------------'.$link.'-------------------------------------------------------------One');
        
        
        $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        // 待采集的页面地址
        $url = $link.'?startIndex='.$startIndex;
        
        echo $link.PHP_EOL;
        Log::info('One-------------------------------------------------------------------------------'.$url.'-------------------------------------------------------------One');
        // 采集规则
        $rules = [
            // 文章标题
            'title' => ['h2','text'],
            'url'   => ['a:eq(0)','href'],
            'image' => ['.sc-1xh12qx-2>.sc-epkw7d-0>img','data-src']
        ];
        $type = ".sc-cw4lnv-13";
        $range = "{$type}";
        $data = QueryList::Query($url,$rules,$range)->data;

        if(empty($data) === false){

            $startIndex = $startIndex+20;

            // 剔除空余的数据
            foreach($data as $key => $value){
                if($value['title'] == ''){
                    unset($data[$key]);
                }

            }

            // 剔除重复的数据
            $A = Array();
            $arrNew = Array();
            foreach($data AS $val){
                if( isset($A[$val['title']]) ){
                    continue;
                }else{
                    $A[$val['title']] = true;
                    $arrNew[] = $val;
                }
            }
            
            $content_class = "sc-r43lxo-1";

            $rules = [
                // 文章标题
                // 'title' => [".{$title_class}",'text'],
                // 'image' => [".sc-epkw7d-0>img",'src'],
                // 文章内容
                'content' => [".{$content_class}",'html','-div']
            ];

            // 获取列表数据
            // $article_data = array();
            foreach($arrNew as $k => $v){
                // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                $arrNew[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
            } 

            // array_merge函数会把相同字符串键名的数组覆盖合并，所以必须先用array_value取出值后再合并。
            // $result= array_reduce($article_data, 'array_merge', array());


            foreach($arrNew as $kk => $vv){
                if($vv['content'] === NULL){
                    unset($arrNew[$kk]);
                }
            }

            array_values($arrNew);

            $gather = new Gather();

            foreach($arrNew as $re => $va){
                $isEmpty = $gather->where(['title'=>$arrNew[$re]['title']])->find();
                if(!empty($isEmpty)){
                    unset($arrNew[$re]);
                }else{
                    $arrNew[$re]['content'] = "<img src='".$va['image']."' />".mb_convert_encoding($va['content'], 'UTF-8', 'auto');
                    $arrNew[$re]['type'] = $typelink;
                    $arrNew[$re]['introduction'] = mb_substr(strip_tags(mb_convert_encoding($va['content'], 'UTF-8', 'auto')),0,80).'...';
                }
            }

            if(empty($arrNew)){
                Cache::inc('startIndexOne',20);
                $this->tasks();
            }else{
                // 采集的条数
                $count = count($arrNew);
                
                $info = $gather->saveAll($arrNew);

                if($info){
                    // echo json_encode(['code'=>200,'status'=>'success','msg'=>'采集成功'.$count.'条数据'],JSON_UNESCAPED_UNICODE);
                    log::info('采集成功'.$count.'条数据');
                    echo '采集成功'.$count.'条数据'.PHP_EOL;
                }else{
                    // echo json_encode(['code'=>0,'status'=>'error','msg'=>'采集失败'],JSON_UNESCAPED_UNICODE);
                    log::info('采集失败');
                    echo '采集失败'.PHP_EOL;
                }
            }

        }else{

            // echo json_encode(['code'=>0,'status'=>'error','msg'=>'数据为空'],JSON_UNESCAPED_UNICODE);
            log::info('数据为空');
            Cache::rm('startIndexOne'); 
            Cache::rm('randLinkOne'); 
            echo '数据为空'.PHP_EOL;
        }

       
    }

}