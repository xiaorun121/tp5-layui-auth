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
class GatherMovies extends Command{
    protected function configure()
    {
        $this->setName('GatherMovies')->setDescription('定时计划测试：每天1hours准时采集数据 --------------------GatherMovies');
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
        Log::info("定时计划测试：每天1hours准时采集数据 ------- GatherMovies");
        
        if(Cache::get('startIndexMoviesOne')){
            $startIndex = Cache::get('startIndexMoviesOne');
        }else{
            Cache::set('startIndexMoviesOne',1);
            $startIndex = Cache::get('startIndexMoviesOne');
        }
        
        $gather  = new Gather();
        $backend  = new Backend();

        $counts = $backend->where(['keywords'=>'movies'])->count();

        $rand = mt_rand(0,$counts-1);

        $backendInfo = $backend->where(['keywords'=>'movies'])->select()->toArray();
        

        if(Cache::get('randLinkMoviesOne')){
            $link = Cache::get('randLinkMoviesOne');
        }else{
            $link = $backendInfo[$rand]['url'];
            Cache::set('randLinkMoviesOne',$link);
        }
        
        echo $link.PHP_EOL;
        
        $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

        // 待采集的页面地址
        $url = $link.$startIndex;
        Log::info('One-------------------------------------------------------------------------------'.$url.'-------------------------------------------------------------One');
        // 采集规则
		$rule = [
			// 文章标题
			'title' => ['span:eq(0)','text'],
			'url'   => ['a:eq(0)','href'],
            'image' => ['.cardImage_image-container__3tS6b>img','src'],
            'introduction' => ['.card_description__eYw0c','text']
		];
        $type = ".card_card__wu3u5";
        
        $data = QueryList::Query($url,$rule,$type, 'ASCII', 'UTF-8')->data;
        
        if(empty($data) === false){

            // 剔除空余的数据
            foreach($data as $key => $value){
                if(empty($value['title']) || empty($value['introduction']) || strstr($value['introduction'], 'By')){
                    unset($data[$key]);
                }else{
                    $data[$key]['title'] = trim($value['title']);
                }
                
            }
            $newArray = array_values(array_splice($data, 0));
            
            $rules = [
                // 文章内容
                'content' => [".article_article-content__3auQJ",'html']
            ];

            foreach($newArray as $k => $v){
                $newArray[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
            }
        
            foreach($newArray as $re => $va){
                if(empty($va['content'])){
                    unset($newArray[$re]);
                }else{
                    $isEmpty = $gather->where(['title'=>$va['title']])->find();
                    if(!empty($isEmpty)){
                        unset($newArray[$re]);
                    }else{
                        $newArray[$re]['type'] = 'movies';
                        $newArray[$re]['column'] = $typelink;
                        $newArray[$re]['content'] = mb_convert_encoding($va['content'], 'UTF-8', 'auto');
                    }
                }
                
            }
            
            if(empty($newArray)){
                Cache::inc('startIndexMoviesOne',1);
                $this->tasks();
            }else{
                // 采集的条数
                $count = count($newArray);
                
                $info = $gather->saveAll($newArray);

                if($info){
                    log::info('采集成功'.$count.'条数据');
                    echo '采集成功'.$count.'条数据'.PHP_EOL;
                }else{
                    log::info('采集失败');
                    echo '采集失败'.PHP_EOL;
                }
            }
            
        }else{

            log::info('数据为空');
            Cache::rm('startIndexMoviesOne'); 
            Cache::rm('randLinkMoviesOne'); 
            
            echo '数据为空'.PHP_EOL;
        }
        
    }
}