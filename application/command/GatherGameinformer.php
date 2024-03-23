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

// 将采集最新的数据直接发布到站群网站中
class GatherGameinformer extends Command
{       

    protected function configure()
    {
        $this->setName('GatherGameinformer')->setDescription('定时计划测试：每天1hours准时采集数据 --------------------GatherGameinformer');
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
        Log::info("定时计划测试：每天1hours准时采集数据 ------- GatherGameinformer");

        // url https://www.gameinformer.com/

        $gather  = new Gather();
        $backend  = new Backend();

        $counts = $backend->where(['keywords'=>'gameinformer'])->count();

        $rand = mt_rand(0,$counts-1);


        $backendInfo = $backend->where(['keywords'=>'gameinformer'])->select()->toArray();

        $link = $backendInfo[$rand]['url'];
        
        echo $link.PHP_EOL;
        
        $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        // 待采集的页面地址
        Log::info('GatherGameinformer-------------------------------------------------------------------------------'.$url.'-------------------------------------------------------------GatherGameinformer');
        // 采集规则

        // 待采集的页面地址
        $url = $link;
        // 采集规则
        $rules = [
            // 文章标题
            'title' => ['.page-title>a','text'],
            'url'   => ['a:eq(0)','href'],
            'image' => ['img','src'],
            'introduction' => ['.field--name-field-promo-summary','text']
        ];
        $type = ".views-infinite-scroll-content-wrapper>.views-row";
        $data = QueryList::Query($url,$rules,$type)->data;

        $host = parse_url($url, PHP_URL_HOST);
        $protocol = strtolower(parse_url($url, PHP_URL_SCHEME));
        $fullUrl = $protocol . '://' . $host;


        if(empty($data) === false){

            foreach($data as $key => $value){
                $data[$key]['url'] = $fullUrl.$value['url'];
                $data[$key]['image'] = $fullUrl.$value['image'];
            }

            
            $content_class = "field--name-body";

            $rules = [
                // 文章标题
                // 'title' => [".{$title_class}",'text'],
                // 'image' => [".sc-epkw7d-0>img",'src'],
                // 文章内容
                'content' => [".{$content_class}",'html','div a -blockquote -script']
            ];

            // 获取列表数据
            // $article_data = array();
            foreach($data as $k => $v){
                // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                $data[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
            } 


            $gather = new Gather();

            foreach($data as $re => $va){
                $isEmpty = $gather->where(['title'=>$data[$re]['title']])->find();
                if(!empty($isEmpty)){
                    unset($data[$re]);
                }else{
                    $data[$re]['content'] = mb_convert_encoding($va['content'], 'UTF-8', 'auto');
                    $data[$re]['type'] = $typelink;
                }
            }

            if(!empty($data)){

                $count = count($data);
            
                $info = $gather->saveAll($data);

                if($info){
                    log::info('采集成功'.$count.'条数据');
                    echo '采集成功'.$count.'条数据'.PHP_EOL;
                }else{
                    log::info('采集失败');
                    echo '采集失败'.PHP_EOL;
                }

            }else{
                log::info('数据为空');
                echo '数据为空'.PHP_EOL;
            }

        }else{

            log::info('数据为空');
            echo '数据为空'.PHP_EOL;
        }


    }

}