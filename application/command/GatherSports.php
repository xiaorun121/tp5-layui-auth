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
class GatherSports extends Command
{       

    protected function configure()
    {
        $this->setName('GatherSports')->setDescription('定时计划测试：每天1hours准时采集数据 --------------------GatherSports');
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
        Log::info("定时计划测试：每天1hours准时采集数据 ------- GatherSports");

        // url https://www.skysports.com/

        $gather  = new Gather();
        $backend  = new Backend();

        $counts = $backend->where(['keywords'=>'sports'])->count();

        $rand = mt_rand(0,$counts-1);

        $backendInfo = $backend->where(['keywords'=>'sports'])->select()->toArray();

        $link = $backendInfo[$rand]['url'];
        
        echo $link.PHP_EOL;
        
        $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        // $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        // 待采集的页面地址
        // 采集规则
        $rules = [
            // 文章标题
            'title' => ['h4','text'],
            'url'   => ['a:eq(0)','href'],
            'image' => ['img:eq(0)','data-src'],
            'introduction' => ['.news-list__snippet','text']
        ];
        $type = ".news-list__item";
        $data = QueryList::Query($link,$rules,$type)->data;

        Log::info('------------------------------------------------------------------------------------'.$link);
        Log::write('------------------------------------------------------------------------------------'.$data);

        if(empty($data) === false){

            // 剔除空余的数据
            foreach($data as $key => $value){
                if(empty($value['title'])){
                    unset($data[$key]);
                }else{
                    $data[$key]['title'] = trim($value['title']);
                }
                
            }
            $newArray = array_values(array_splice($data, 0));

            Log::write('1------------------------------------------------------------------------------------'.$newArray);
            
            $rules = [
                // 文章标题
                // 'title' => [".{$title_class}",'text'],
                // 'image' => [".sc-epkw7d-0>img",'src'],
                // 文章内容
                'content' => [".sdc-article-body",'html', 'a -div -ul']
            ];

            // 获取列表数据
            // $article_data = array();
            foreach($newArray as $k => $v){
                // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                $newArray[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
            } 
            
            // dump($newArray);

            Log::write('2------------------------------------------------------------------------------------'.$newArray);

            foreach($newArray as $re => $va){
                if(empty($va['content'])){
                    unset($newArray[$re]);
                }else{
                    $isEmpty = $gather->where(['title'=>$va['title']])->find();
                    if(!empty($isEmpty)){
                        unset($newArray[$re]);
                    }else{
                        $newArray[$re]['type'] = 'sports';
                        $newArray[$re]['column'] = $typelink;
                        $newArray[$re]['content'] = mb_convert_encoding($va['content'], 'UTF-8', 'auto');
                    }
                }
            }

            Log::write('3------------------------------------------------------------------------------------'.$newArray);


            if(count($newArray) == 20){
                
                $newResult = $newArray;
            }else{
                $newResult = array_values(array_splice($newArray, 0));
            }

            Log::write('newResult'.$newResult);
           

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
            Log::info('数据为空');
            echo '数据为空'.PHP_EOL;
            
        }


    }

}