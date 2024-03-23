<?php
namespace app\admin\controller;

use app\admin\logic\GetViewMenuPermission;

use think\Controller;
use think\Db;
use QL\QueryList;
use app\admin\model\Gather as GatherModel;
use app\admin\model\Backend;
use app\admin\model\Publish;

use think\Log;
use think\Cache;


// 采集数据  发布数据
class Gather extends Common{

    /**
     * application_password 后台生成的应用程序密码
     * api_url wp restApi 接口地址 上传文章 post
     */
    // protected $wp_admin_data = [
    //     ['application_password'=>'OVZl 6ATQ rgKL P4ZO zAlb T7VJ','api_url'=>'https://www.westriverfca.org/wp-json/wp/v2/posts'] 
    // ];

    /**
     * admin 后台账号
     * api_url 接口后缀地址
     * */ 

    private $admin;
    private $api_url;

    public function _initialize(){

        $this->admin   = 'admin';   
        $this->api_url = '/wp-json/wp/v2/posts';

    }

    // 采集数据
    public function gatherData(){

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);

        $gather = new GatherModel();

        $title = input('get.title');

        if(!empty($title)){
            $map['title'] = ['like','%'.$title.'%'];
        }

        if(empty($title)){

            $info = $gather->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

        }else{

            $info = $gather->where($map)
                        ->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
                        'query'    => request()->param()
            ]);

        }

        $this->assign('title',$title);
        $this->assign('info',$info);

        return view();
    }

    // 采集数据修改
    public function saveGather($id = 0){

        $gather = new GatherModel();

        $data = input('post.');

        if(request()->isPost()){
            
            if($gather->isUpdate(true)->save($data) == 1){

                return success('保存成功',url('gatherData'));

            }else{

                return error('请更新数据！');
            }

        }else{

            $getInfo = $gather->find($id);

            $this->assign('getInfo',$getInfo);

            return view();
        }
    }

    // 采集数据删除
    public function delGather(){

        $id = input('post.id');

        $gather = new GatherModel();
        $res = $gather::destroy($id);

        if($res == 1){

            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);

        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }

    // wp后台数据管理
    public function gatherAdmin(){

        $get = new GetViewMenuPermission();

        $viewMenu = $get->getViewMeun();

        $this->assign('viewMenu',$viewMenu);

        $backend = new Backend();

        $title = input('get.title');

        if(!empty($title)){
            $map['title'] = ['like','%'.$title.'%'];
        }

        if(empty($title)){

            $info = $backend->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
            ]);

        }else{

            $info = $backend->where($map)
                        ->order('id desc')
                        ->paginate(10,false,[
                        'type'     => 'bootstrap',
                        'var_page' => 'page',
                        'query'    => request()->param()
            ]);

        }

        $this->assign('title',$title);
        $this->assign('info',$info);

        return view();
    }

    // wp后台数据新增、更新操作
    public function saveGatherAdmin($id = 0){

        $backend = new Backend();

        $data = input('post.');

        if(request()->isPost()){

            if($id != 0){
                $backend = $backend::get($id);
            }
            
            if($backend->save($data) == 1){

                return success('保存成功',url('gatherAdmin'));

            }else{

                return error('请更新数据！');
            }

        }else{

            $getInfo = $backend->find($id);

            $this->assign('getInfo',$getInfo);

            return view();
        }
    }

    // wp后台数据删除操作
    public function delGatherAdmin(){

        $id = input('post.id');

        $backend = new Backend();
        $res = $backend::destroy($id);

        if($res == 1){

            echo json_encode(['status'=>'success','code'=>200,'msg'=>'删除成功']);

        }else{
            echo json_encode(['status'=>'error','code'=>201,'msg'=>'删除失败']);
        }
    }

    // 采集列表
    // public function gatherList(){

    //     if(request()->isPost()){

    //         // title class sc-89ec4v-4
    //         // content class sc-r43lxo-1
    //         // image class sc-89ec4v-1>img srcset

    //         // $type = input('post.type');
    //         // $title_class = input('post.title_class');
    //         // $content_class = input('post.content_class');
    //         // $link = input('post.link');

    //         $title_class = "sc-89ec4v-4";
    //         $content_class = "sc-r43lxo-1";
    //         $link = input('post.link');
            
    //         $r = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
    //         if(!preg_match($r,$link)){
    //             echo json_encode(['code'=>0,'msg'=>'请输入有效的正确链接地址（http/https）']);
    //         }

    //         $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

    //         Cache::set('startIndex',0);

    //         $startIndex = Cache::get('startIndex');

    //         // 待采集的页面地址
	// 		$url = $link.'?startIndex='.$startIndex;
	// 		// 采集规则
	// 		$rules = [
	// 			// 文章标题
	// 			'title' => ['h2','text'],
	// 			'url'   => ['a:eq(0)','href'],
    //             'image' => ['.sc-1xh12qx-2>.sc-epkw7d-0>img','data-src']
	// 		];
    //         $type = ".dYIPCV";
	// 		$range = "{$type}";
	// 		$data = QueryList::Query($url,$rules,$range)->data;

    //         dump($data);

    //         exit;

            
	// 		// print_r($data[15]['title']);

    //         // $hostInfo = parse_url($url);
    
    //         // $domainUrl  = $hostInfo['scheme'].'://'.$hostInfo['host'];
            

    //         // foreach($data as $key => $value){
    //         //     if(strpos($value['url'], "https") === false){
    //         //         $data[$key]['url'] = $domainUrl.$value['url'];
    //         //     }
                
    //         // }

    //         if(empty($data) === false){

    //             $startIndex = $startIndex+20;

    //             // 剔除空余的数据
    //             foreach($data as $key => $value){
    //                 if($value['title'] == ''){
    //                     unset($data[$key]);
    //                 }

    //             }

    //             // 剔除重复的数据
    //             $A = Array();
    //             $arrNew = Array();
    //             foreach($data AS $val){
    //                 if( isset($A[$val['title']]) ){
    //                     continue;
    //                 }else{
    //                     $A[$val['title']] = true;
    //                     $arrNew[] = $val;
    //                 }
    //             }

    //             $rules = [
    //                 // 文章标题
    //                 'title' => [".{$title_class}",'text'],
    //                 'image' => [".sc-89ec4v-1>img",'srcset'],
    //                 // 文章内容
    //                 'content' => [".{$content_class}",'html','-div']
    //             ];

    //             // 获取列表数据
    //             // $article_data = array();
    //             foreach($arrNew as $v){
    //                 $article_data[] = QueryList::Query($v['url'],$rules)->data;
    //             } 


    //             // array_merge函数会把相同字符串键名的数组覆盖合并，所以必须先用array_value取出值后再合并。
    //             $result= array_reduce($article_data, 'array_merge', array());

    //             foreach($result as $kk => $vv){
    //                 if(isset($vv['title']) === true && isset($vv['image']) === true && isset($vv['content']) === true){
                        
    //                 }else{
    //                     unset($result[$kk]);
    //                 }
    //             }

    //             array_values($result);

    //             $gather = new GatherModel();

    //             foreach($result as $re => $va){
    //                 $isEmpty = $gather->where(['title'=>$result[$re]['title']])->find();
    //                 if(!empty($isEmpty)){
    //                     unset($result[$re]);
    //                 }else{
    //                     $result[$re]['content'] = "<img src='".$va['image']."' />".mb_convert_encoding($va['content'], 'UTF-8', 'auto');
    //                     $result[$re]['type'] = $typelink;
    //                 }
    //             }

    //             if(empty($result)){
    //                 $this->gatherList();
    //             }else{
    //                 // 采集的条数
    //                 $count = count($result);
                    
    //                 $info = $gather->saveAll($result);

    //                 if($info){
    //                     echo json_encode(['code'=>200,'status'=>'success','msg'=>'采集成功'.$count.'条数据'],JSON_UNESCAPED_UNICODE);
    //                 }else{
    //                     echo json_encode(['code'=>0,'status'=>'error','msg'=>'采集失败'],JSON_UNESCAPED_UNICODE);
    //                 }
    //             }

    //         }else{

    //             echo json_encode(['code'=>0,'status'=>'error','msg'=>'数据为空'],JSON_UNESCAPED_UNICODE);
    //         }

    //     }else{
    //         return view();
    //     }
        
    // }

    public function gatherList($startIndex = 0){

        if(request()->isPost()){

            // $type = input('post.type');
            $title_class = input('post.title_class');
            $content_class = input('post.content_class');
            $link = input('post.link');
            
            $r = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
            if(!preg_match($r,$link)){
                echo json_encode(['code'=>0,'msg'=>'请输入有效的正确链接地址（http/https）']);
            }

            // Cache::clear(); 

            // if(Cache::get('link')){
            //     if($link != Cache::get('link')){
            //         Cache::set('link',$link);
            //         $link = Cache::get('link');
            //     }

            //     $link = Cache::get('link');
                
            // }else{
            //     Cache::set('page',1);
            //     Cache::set('link',$link);
            //     $link = Cache::get('link');
            // }


            // if(Cache::get('page')){
            //     $page = Cache::get('page');
            // }else{
            //     Cache::set('page',1);
            //     $page = Cache::get('page');
            //     Cache::set('typelink',substr(strrchr(rtrim($link, '/'), '/'), 1));
            // }

            // Log::info('-------------------------------------------------------------------------------'.Cache::get('link'));
            // Log::info('------------------------------------------------------------------------------------'.Cache::get('page'));

            // $typelink = Cache::get('typelink');
            // $typelink = substr(strrchr(rtrim($link, '/'), '/'), 1);

            // 待采集的页面地址
			// $url = $link.'page/'.$page;
			// $url = $link.'page/9';
            $url = "https://collider.com/tag/tron-3/";
            $typelink = substr(strrchr(rtrim($url, '/'), '/'), 1);
			// 采集规则
			$rules = [
				// 文章标题
				'title' => ['h5','text'],
				'url'   => ['a:eq(0)','href'],
                'image' => ['source:eq(0)','srcset'],
                'introduction' => ['.display-card-excerpt','text']
			];
            $type = ".display-card";
			$data = QueryList::Query($url,$rules,$type)->data;

            $host = parse_url($url, PHP_URL_HOST);
            $protocol = strtolower(parse_url($url, PHP_URL_SCHEME));
            $fullUrl = $protocol . '://' . $host;

           
            // foreach($data as $key => $value){
            //     $data[$key]['image'] = $url.$value['image'];
            // }

            dump($data);exit;


            Log::info('------------------------------------------------------------------------------------'.$url);
            Log::info('------------------------------------------------------------------------------------'.$data);

            // $host = parse_url($url, PHP_URL_HOST);
            // $protocol = strtolower(parse_url($url, PHP_URL_SCHEME));
            // $fullUrl = $protocol . '://' . $host;

            if(empty($data) === false){


                
                // Cache::inc('page');

                // 剔除空余的数据
                foreach($data as $key => $value){
                    if(empty($value['title'])){
                        unset($data[$key]);
                    }else{
                        $data[$key]['title'] = trim($value['title']);
                        $data[$key]['url'] = $fullUrl.$value['url'];
                    }
                    unset($data[0]);
                    
                }
                $newArray = array_values(array_splice($data, 0));

                
                // dump($newArray);exit;

                // Log::info('1------------------------------------------------------------------------------------'.$newArray);

                
                $rules = [
                    // 文章标题
                    // 'title' => [".{$title_class}",'text'],
                    // 'image' => [".sc-epkw7d-0>img",'src'],
                    // 文章内容
                    'content' => [".content-block-regular",'html', '-a -div -ul -script -section -!--']
                ];

                // $totalData = count($newArray);
                // $batchSize = 10;

                // for ($i = 0; $i < $totalData; $i += $batchSize) {
                //     $batchData = array_slice($newArray, $i, $batchSize);
                //     foreach($batchData as $k => $v){
                //         // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                //         $batchData[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
                //     } 
                // }
                foreach($newArray as $k => $v){
                    // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                    $newArray[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
                } 

                // 获取列表数据
                // $article_data = array();
                // foreach($newArray as $k => $v){
                //     // $article_data[] = QueryList::Query($v['url'],$rules)->data;
                //     $newArray[$k]['content'] = QueryList::Query($v['url'],$rules)->data[0]['content'];
                // } 

                Log::info('2------------------------------------------------------------------------------------'.$newArray);

                // dump($newArray);exit;

                $gather = new GatherModel();    

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
                            // $newArray[$re]['introduction'] = mb_substr(strip_tags(mb_convert_encoding($va['content'], 'UTF-8', 'auto')),0,80).'...';
                            $newArray[$re]['content'] = mb_convert_encoding($va['content'], 'UTF-8', 'auto');
                        }
                    }
                    
                }

                Log::info('3------------------------------------------------------------------------------------'.$newArray);
                $newArray = array_values(array_splice($newArray, 0));   
                dump($newArray);exit;

                // if($newArray.length){

                // }

                if(count($newArray) == 20){
                    
                    $newResult = $newArray;
                }else{
                    $newResult = array_values(array_splice($newArray, 0));
                }
                // Log::info('newResult'.$newResult);
               

                // if(empty($newResult)){
                //     Cache::inc('page');
                //     $this->gatherList();
                // }else{
                    // 采集的条数
                    $count = count($newResult);
                    
                    $info = $gather->saveAll($newResult);

                    if($info){
                        Log::info('采集成功'.$count.'条数据');
                        return json(['code'=>200,'status'=>'success','page'=>$page,'msg'=>'采集成功'.$count.'条数据']);
                    }else{
                        Log::info('采集失败');
                        return json(['code'=>0,'status'=>'error','page'=>$page,'msg'=>'采集失败'],JSON_UNESCAPED_UNICODE);
                    }
                // }

            }else{
                Cache::rm('page');
                Log::info('数据为空');
                return json(['code'=>0,'status'=>'error','msg'=>'数据为空'],JSON_UNESCAPED_UNICODE);
                
            }

        }else{
            return view();
        }
        
    }

    // 采集文章
    public function gatherArticle(){

        if(request()->isPost()){

            $title_class = input('post.title_class');
            $content_class = input('post.content_class');
            $link = input('post.link');
            
            $r = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
            if(!preg_match($r,$link)){
                echo json_encode(['code'=>0,'msg'=>'请输入有效的正确链接地址（http/https）']);
            }

            $rules = [
                // 文章标题
                'title' => [".{$title_class}",'text'],
                // 文章内容
                'content' => [".{$content_class}",'html','div']
            ];
            
            // 获取文章数据
            $result = QueryList::Query($link,$rules)->data;

            if($result){
                $gather = new GatherModel();

                $info = $gather->saveAll($result);

                if($info){
                    echo json_encode(['code'=>200,'status'=>'success','msg'=>'采集成功']);
                }else{
                    echo json_encode(['code'=>0,'status'=>'error','msg'=>'采集失败']);
                }
            }else{
                echo json_encode(['code'=>0,'status'=>'error','msg'=>'采集失败']);
            }

        }else{
            return view();
        }
        
    }

    // 发布
    public function publish(){

        if(request()->isPost()){

            $id = input('post.id');

            // 1、先查询wp后台数据信息
            $backend = new Backend();

            $gather = new GatherModel();

            $gather = $gather->get($id);

            // 获取后台数据总条数
            $count = $backend->count();

            // 随机整数
            $rand = mt_rand(1,$count);

            // 2、随机几条数据进行发布
            $info = $backend->order("rand()")->field('id,title,url,application_password')->limit($rand)->select()->toArray();

            $coun = 0;

            if($info){

                foreach($info as $key => $value){

                    $username = $this->admin;
                    $application_password = "{$value['application_password']}";
                    
                    $url = "{$value['url']}/{$this->api_url}";
                    
                    $json = json_encode([
                        'title' => "{$gather->title}",
                        'content' => "{$gather->content}",
                        'status' => 'publish',
                    ]);

                    // 发布
                    $publish = new Publish();
                    // 判断当前的记录是否存在发布数据
                    $if_publish = $publish->where(['gather_id'=>$id,'backend_id'=>$value['id']])->find();
                    // 不存在的情况
                    
                    if(!$if_publish){
                        try {
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$application_password);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                            $result = curl_exec($ch);
                            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            curl_close($ch);
    
                            Log::info("采集数据发布成功，对应链接：".$value['url']);
                            $publish->save(['gather_id'=>$id,'backend_id'=>$value['id']]);

                            $coun++;
                        } catch(Exception $e) {
                            echo $e->getMessage();
                        }
                    }
                    
                }

                if(!empty(json_decode($result))){
                    echo json_encode(['code'=>200,'status'=>'success','msg'=>'发布成功'.$coun.'条数据']);
                }else{
                    echo json_encode(['code'=>0,'status'=>'error','msg'=>'发布失败']);
                }

            }else{
                echo json_encode(['code'=>0,'status'=>'error','msg'=>'发布失败']);
            }

        }
        
    }

    // 发布数据
    public function publishData(){

        $publish = new Publish();

        $info = $publish->order('id desc')
                    ->paginate(10,false,[
                    'type'     => 'bootstrap',
                    'var_page' => 'page',
                    'query'    => request()->param()
        ]);

        $this->assign('info',$info);

        return view();
    }

    // 接口数据
    public function api(){
        return view('api',['url'=>'https://www.showdoc.com.cn/1891400990031267/10858338754961510']);
    }
}