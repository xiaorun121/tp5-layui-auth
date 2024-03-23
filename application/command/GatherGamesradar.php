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
class GatherGamesradar extends Command
{       

    protected function configure()
    {
        $this->setName('GatherGamesradar')->setDescription('定时计划测试：每天1hours准时采集数据 --------------------GatherGameinformer');
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

        $counts = $backend->where(['keywords'=>'gamesradar'])->count();

        $rand = mt_rand(0,$counts-1);

        $backendInfo = $backend->where(['keywords'=>'gamesradar'])->select()->toArray();

        $link = $backendInfo[$rand]['url'];
        
        $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        if(Cache::get('link')){
            if($link != Cache::get('link')){
                Cache::set('link',$link);
                Cache::set('typelink',substr(strrchr(rtrim($link, '/'), '/'), 1));
            }

            $link = Cache::get('link');
            
        }else{
            Cache::set('page',1);
            Cache::set('link',$link);
            $link = Cache::get('link');
            $page = Cache::get('page');
            Cache::set('typelink',substr(strrchr(rtrim($link, '/'), '/'), 1));
        }
    
        echo $link.PHP_EOL;
        Log::info('-------------------------------------------------------------------------------'.Cache::get('link'));
        Log::info('------------------------------------------------------------------------------------'.Cache::get('page'));

        $typelink = Cache::get('typelink');
        // $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        // 待采集的页面地址
        $url = $link.'page/'.$page;
        // $url = $link.'page/9';
        // 采集规则
        $rules = [
            // 文章标题
            'title' => ['h3','text'],
            'url'   => ['a:eq(0)','href'],
            'image' => ['.article-lead-image-wrap','data-original']
        ];
        $type = ".listingResult";
        $data = QueryList::Query($url,$rules,$type)->data;

        Log::info('------------------------------------------------------------------------------------'.$url);
        Log::info('------------------------------------------------------------------------------------'.$data);

        if(empty($data) === false){

            Cache::inc('page');

            // 剔除空余的数据
            foreach($data as $key => $value){
                if(empty($value['title']) && empty($value['title']) && empty($value['title'])){
                    unset($data[$key]);
                }
            }
            $newArray = array_values(array_splice($data, 0));

            Log::info('1------------------------------------------------------------------------------------'.$newArray);
            
            $rules = [
                // 文章标题
                // 'title' => [".{$title_class}",'text'],
                // 'image' => [".sc-epkw7d-0>img",'src'],
                // 文章内容
                'content' => ["#article-body",'html', '-blockquote -script a div']
            ];

            // 获取列表数据
            // $article_data = array();
            foreach($newArray as $k => $v){
                // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                $newArray[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
            } 

            Log::info('2------------------------------------------------------------------------------------'.$newArray);

            $gather = new Gather();    

            foreach($newArray as $re => $va){
                $isEmpty = $gather->where(['title'=>$va['title']])->find();
                if(!empty($isEmpty)){
                    unset($newArray[$re]);
                }else{
                    $newArray[$re]['type'] = $typelink;
                    $newArray[$re]['introduction'] = mb_substr(strip_tags(mb_convert_encoding($va['content'], 'UTF-8', 'auto')),0,80).'...';
                    $newArray[$re]['content'] = mb_convert_encoding($va['content'], 'UTF-8', 'auto');
                }
            }

            Log::info('3------------------------------------------------------------------------------------'.$newArray);


            if(count($newArray) == 20){
                
                $newResult = $newArray;
            }else{
                $newResult = array_values(array_splice($newArray, 0));
            }

            Log::info('newResult'.$newResult);
           

            $count = count($newResult);
            
            $info = $gather->saveAll($newResult);

            if($info){
                Log::info('采集成功'.$count.'条数据');
                echo '采集成功'.$count.'条数据'.PHP_EOL;
            }else{
                Log::info('采集失败');
                echo '采集失败'.PHP_EOL;
            }

        }else{
            Cache::rm('page');
            Cache::rm('link');
            Log::info('数据为空');
            echo '数据为空'.PHP_EOL;
            
        }


    }

}