<?php
namespace app\api\controller\v1;

use think\Controller;
use QL\QueryList;
use app\admin\model\GameInformation;

// 采集数据
class Gather extends Controller{

    protected $gameInformation;

    public function __construct()
    {
        parent::__construct();
        
        // 在构造函数中实例化 User 模型
        $this->gameInformation = new GameInformation();
    }

    /**
     * 采集游戏资讯
     * link https://readtheworkshop.com/
     * title
     * url
     * image
     */ 
    public function gatherGameInformation(){
        $url = "https://readtheworkshop.com/";
        $rules = [
            // 文章标题
            'title' => ['.games-name','text'],
            'url'   => ['a:eq(0)','href'],
            'image' => ['amp-img','src']
        ];
        $type = ".card";
        $data = QueryList::Query($url,$rules,$type)->data;

        $result = $this->gameInformation->saveAll($data);

        if($result){
            $data = [
                'code'   => 200,
                'msg'    => 'save data success',
                'data'   => $data,
                'result' => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }

        return json($data);
    }

}