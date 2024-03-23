<?php
namespace app\api\controller\v1;

use think\Controller;
use app\admin\model\Gather;
use think\Log;
use app\admin\model\GameInformation;

// 资讯api
class Infomation extends Controller{

    protected $gather;
    protected $gatherInformation;

    public function __construct()
    {
        parent::__construct();
        
        // 在构造函数中实例化 User 模型
        $this->gather = new Gather();
        $this->gatherInformation = new GameInformation();
    }
    
    // 获取采集游戏资讯 
    public function getGatherInformation($title = '',$order = 'asc',$list_rows = 10,$page = 1 ){
        $map = [];

        if(!empty($title)){
            $map['title'] = ['like','%'.$title.'%'];
        }

        if(!empty($type)){
            $map['type'] = $type;
            
        }


        $result = $this->gatherInformation->where($map)->field('id,title,url,image,create_time')->order(['id'=>$order])->paginate($list_rows,false,[
            'page' => $page
        ]);

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }

    // 获取游戏资讯类型
    public function getGamesType(){
        $result = $this->gather->distinct(true)->where("type <> 'sports'")->where("type <> 'movies'")->field('type')->select()->toArray();
        foreach($result as $key => $value){
            $result[$key] = $value['type'];
        }

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data'  => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }


    // 获取游戏资讯
    public function getGamesList($title = '',$type = '', $order = 'desc',$list_rows = 10,$page = 1 ){

        $map = [];

        if(!empty($title)){
            $map['title'] = ['like','%'.$title.'%'];
        }

        if(!empty($type)){
            $map['type'] = $type;
            
        }


        $result = $this->gather->where($map)->where("type <> 'sports'")->where("type <> 'movies'")->field('id,title,type,image,introduction,create_time,content')->order(['id'=>$order])->paginate($list_rows,false,[
            'page' => $page
        ]);

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
        
    }

    // 获取游戏资讯的轮播图
    public function getGamesCarousel(){
        
        $result = $this->gather->where('url is not null')->where("image <> ''")->where("type <> 'sports'")->where("type <> 'movies'")->field('id,type,image,create_time')->order(['id'=>'desc'])->select()->toArray();

        if($result){
            shuffle($result);
            $datas = array_slice($result,0,5);
            
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $datas
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }

    // 获取游戏资讯的推荐
    public function getGamesRecommend(){

        $result = $this->gather->where('url is not null')->where("image <> ''")->where("type <> 'sports'")->where("type <> 'movies'")->field('id,title,type,image,create_time')->order(['id'=>'desc'])->select()->toArray();

        if($result){
            shuffle($result);
            $datas = array_slice($result,0,5);
            
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $datas
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }
    
    // 获取游戏资讯详情
    public function getGamesArticleToId($id = 0){
        if($id > 0){
            $result = $this->gather->where(['id'=>$id])->where("type <> 'sports'")->where("type <> 'movies'")->field('id,title,type,image,create_time')->find();
            
            if($result){
                $data = [
                    'code'  => 200,
                    'msg'   => 'query success',
                    'data' => $result
                ];
            }else{
                $data = [
                    'code'  => 0,
                    'msg'   => 'query error'
                ];
            }
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'id is must request' 
            ];
        }
        
        return json($data);
    }
    
    // 获取体育资讯类型
    public function getSportsType(){
        $result = $this->gather->distinct(true)->where("type = 'sports'")->field('column')->select()->toArray();
        foreach($result as $key => $value){
            $result[$key] = $value['column'];
        }

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data'  => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }


    // 获取体育资讯
    public function getSportsList($title = '',$column = '', $order = 'desc',$list_rows = 10,$page = 1 ){

        $map = [];

        if(!empty($title)){
            $map['title'] = ['like','%'.$title.'%'];
        }

        if(!empty($column)){
            $map['column'] = $column;
            
        }


        $result = $this->gather->where($map)->where("type = 'sports'")->field('id,title,type,column,image,introduction,create_time,content')->order(['id'=>$order])->paginate($list_rows,false,[
            'page' => $page
        ]);

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
        
    }

    // 获取体育资讯的轮播图
    public function getSportsCarousel(){
        
        $result = $this->gather->where('url is not null')->where("image <> ''")->where("type = 'sports'")->field('id,type,column,image,create_time')->order(['id'=>'desc'])->select()->toArray();
        

        if($result){
            shuffle($result);
            $datas = array_slice($result,0,5);
            
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $datas
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }

    // 获取体育资讯的推荐
    public function getSportsRecommend(){

        $result = $this->gather->where('url is not null')->where("image <> ''")->where("type = 'sports'")->field('id,title,type,column,image,create_time')->order(['id'=>'desc'])->select()->toArray();

        if($result){
            shuffle($result);
            $datas = array_slice($result,0,5);
            
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $datas
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }
    
    // 获取体育资讯详情
    public function getSportsArticleToId($id = 0){
        if($id > 0){
            $result = $this->gather->where(['id'=>$id])->where("type = 'sports'")->field('id,title,type,column,image,create_time')->find();
            
            if($result){
                $data = [
                    'code'  => 200,
                    'msg'   => 'query success',
                    'data' => $result
                ];
            }else{
                $data = [
                    'code'  => 0,
                    'msg'   => 'query error'
                ];
            }
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'id is must request' 
            ];
        }
        
        return json($data);
    }

    // 获取游戏资讯类型
    public function getMoviesType(){
        $result = $this->gather->distinct(true)->where("type = 'movies'")->field('column')->select()->toArray();
        foreach($result as $key => $value){
            $result[$key] = $value['column'];
        }

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data'  => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }


    // 获取游戏资讯
    public function getMoviesList($title = '',$column = '', $order = 'desc',$list_rows = 10,$page = 1 ){

        $map = [];

        if(!empty($title)){
            $map['title'] = ['like','%'.$title.'%'];
        }

        if(!empty($column)){
            $map['column'] = $column;
            
        }


        $result = $this->gather->where($map)->where("type = 'movies'")->field('id,title,type,column,image,introduction,create_time,content')->order(['id'=>$order])->paginate($list_rows,false,[
            'page' => $page
        ]);

        if($result){
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $result
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
        
    }

    // 获取游戏资讯的轮播图
    public function getMoviesCarousel(){
        $result = $this->gather->where('url is not null')->where("image <> ''")->where("type = 'movies'")->field('id,type,column,image,create_time')->order(['id'=>'desc'])->select()->toArray();

        if($result){
            shuffle($result);
            $datas = array_slice($result,0,5);
            
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $datas
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }

    // 获取游戏资讯的推荐
    public function getMoviesRecommend(){

        $result = $this->gather->where('url is not null')->where("image <> ''")->where("type = 'movies'")->field('id,title,type,column,image,create_time')->order(['id'=>'desc'])->select()->toArray();

        if($result){
            shuffle($result);
            $datas = array_slice($result,0,5);
            
            $data = [
                'code'  => 200,
                'msg'   => 'query success',
                'data' => $datas
            ];
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'query error'
            ];
        }
        

        return json($data);
    }
    
    // 获取游戏资讯详情
    public function getMoviesArticleToId($id = 0){
        if($id > 0){
            $result = $this->gather->where(['id'=>$id])->where("type = 'movies'")->field('id,title,type,column,image,create_time')->find();
            
            if($result){
                $data = [
                    'code'  => 200,
                    'msg'   => 'query success',
                    'data' => $result
                ];
            }else{
                $data = [
                    'code'  => 0,
                    'msg'   => 'query error'
                ];
            }
        }else{
            $data = [
                'code'  => 0,
                'msg'   => 'id is must request' 
            ];
        }
        
        return json($data);
    }
}