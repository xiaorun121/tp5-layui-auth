<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\Menu;
use app\admin\model\Website;
use QL\QueryList;
use app\admin\model\Gather;
use app\admin\model\Backend;
use app\admin\model\Publish;
use think\Log;

class Index extends Common{
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


		protected $menu_icon = array('fa-align-left','fa-bars','fa-align-right','fa-dedent','fa-indent','fa-leaf','fa-legal','fa-pagelines','fa-paw','fa-pied-piper-alt','fa-pied-piper','fa-reddit','fa-ship','fa-tree','fa-yelp');

		// public function _initialize(){
		// 	$this->admin   = 'admin'; 
		// 	$this->api_url = 'wp-json/wp/v2/posts';
		// 	$this->per_page = 20;
		// 	$this->domain_url = ['https://www.westriverfca.org/','https://philadelphiaalternativemedicin.com/','https://fireextinguishersnottingham.com/','https://www.igoexchange.com/','https://oasesnetwork.com/'];
		// 	$this->mt_rand = mt_rand(0,4);
		// 	$this->week = date("w");   
		// }
		
		
		public function index(){
			$website = new Website();
			$website = $website->where('id',1)->find();

			$role_id   = session('user.role_id');

			$menu = Db::view('Permission p','role_id,menu_id')
									->view('Menu m','id,name,module_name,controller_name,view_name,parent_id,is_menu,sort','p.menu_id = m.id')
									->where('p.role_id','=',$role_id)
									->where('m.is_menu','=',1)
								->order('m.sort asc')
								->select();

			$treeArr = get_tree_left($menu);

			shuffle($this->menu_icon);

			$this->assign('menu_icon',$this->menu_icon);
			$this->assign('menu',$treeArr);
			$this->assign('website',$website);

			return view();
		}

		public function content(){

			// 查询当前年的数据数量
			$Year = date('Y', time());   // 当前的年
			$resultYear = Db::query('select count(a.id) as value from ch_app_trace a where a.update_time like "'.$Year.'%" and a.delete_time is NULL group by a.status ORDER BY a.STATUS asc');

			$arrY = '';
			foreach($resultYear as $resY){
				$arrY .=  $resY['value'].',';
			}

			// 查询当前月的数据
			$YearMouth = date('Y-m', time());   // 当前的年月
			$resultYearMouth = Db::query('select count(a.id) as value from ch_app_trace a where a.update_time like "'.$YearMouth.'%" and a.delete_time is NULL group by a.status ORDER BY a.STATUS asc');

			// $yearMouthResult = json_encode($resultYearMouth);

			$arrYm = '';
			foreach($resultYearMouth as $resYm){
				$arrYm .=  $resYm['value'].',';
			}

			// 查询当天的数据
			$yearMouthDay = date('Y-m-d', time());   // 当前的年月日
			$resultYearMouthDay = Db::query('select count(a.id) as value from ch_app_trace a where a.update_time like "'.$yearMouthDay.'%" and a.delete_time is NULL group by a.status ORDER BY a.STATUS asc');

			$arrYmd = '';
			foreach($resultYearMouthDay as $res){
				$arrYmd .=  $res['value'].',';
			}

			// $yearMouthDayResult = json_encode($resultYearMouthDay);

			// protected $status_arr = [1=>'已上架',2=>'审核中',3=>'待审核',4=>'已拒绝',5=>'账号禁用',6=>'分配中',7=>'已暂停',8=>'待验证',9=>'已下架',10=>'账号关联',11=>'更新中',12=>'其他'];

			// 当天的数据
			$resultYearDayMouths = Db::query('select  count(a.id) as value,(case a.status when 1  then "已上架" when 2 then "审核中" when 3 then "待审核" when 4 then "账号禁用" when 5 then "分配中" when 6 then "已暂停" when 7 then "待验证" when 8 then "已下架" when 9 then "账号关联" when 10 then "更新中" when 11 then "其他" end) as name from ch_app_trace a where a.update_time like "'.$yearMouthDay.'%" and a.delete_time is NULL group by a.status ORDER BY a.STATUS asc');

			$yearMouthDayResult = json_encode($resultYearDayMouths);

			// 当月的数据
			$resultYearMouths = Db::query('select  count(a.id) as value,(case a.status when 1  then "已上架" when 2 then "审核中" when 3 then "待审核" when 4 then "账号禁用" when 5 then "分配中" when 6 then "已暂停" when 7 then "待验证" when 8 then "已下架" when 9 then "账号关联" when 10 then "更新中" when 11 then "其他" end) as name from ch_app_trace a where a.update_time like "'.$YearMouth.'%" and a.delete_time is NULL group by a.status ORDER BY a.STATUS asc');

			$yearMouthResult = json_encode($resultYearMouths);


			// 查询当前年的数据字段
			$YearField = Db::query('select case a.status when 1  then "已上架" when 2 then "审核中" when 3 then "待审核" when 4 then "账号禁用" when 5 then "分配中" when 6 then "已暂停" when 7 then "待验证" when 8 then "已下架" when 9 then "账号关联" when 10 then "更新中" when 11 then "其他" end as name from ch_app_trace a where a.update_time like "'.$year.'%" and a.delete_time is NULL group by a.status ORDER BY a.STATUS asc');

			$arrField = '';
			foreach($YearField as $resField){
				$arrField .=  "'".$resField['name']."'".',';
			}

			$this->assign('arrField',$arrField);
			$this->assign('yearMouthResult',$yearMouthResult);
			$this->assign('yearMouthDayResult',$yearMouthDayResult);
			$this->assign('arrY',substr($arrY,0,-1));
			$this->assign('arrYm',substr($arrYm,0,-1));
			$this->assign('arrYmd',substr($arrYmd,0,-1));

			return view();
		}

		public function gather(){
			// 1、采集数据到数据库
			if($this->week > 4){
				$domain_url_check = $this->domain_url[$this->mt_rand];
			}else{
				$domain_url_check = $this->domain_url[$this->week];
			}
	
			$url = $domain_url_check.$this->api_url.'?per_page='.$this->per_page;

	
			$result = curl_get($url);
	
			$resultInfo = json_decode($result,true);

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
				Log::info("error");
			}

			$gather = new Gather();

			if(!empty($resArr)){
				$info = $gather->saveAll($resArr);

				if($info){
					return json_encode(['code'=>201,'status'=>'success','msg'=>$msg]);
				}else{
					return json_encode(['code'=>0,'status'=>'error','msg'=>'数据更新失败']);
				}
			}else{
				return json_encode(['code'=>0,'status'=>'error','msg'=>'采集失败']);
			}
		}

		// 发布
		public function publishData(){
			// 2、将采集最新的数据直接发布到站群网站中

			$gather  = new Gather();
			$backend = new Backend();
			// // 查询后台数据
			$backendData = $backend->order('id asc')->select()->toArray();


			$con = 0;

			$gatherCount = 0;

			

			foreach($backendData as $key => $value){

				$gatherData = $gather->whereTime('create_time','today')->order("rand()")->field('id,title,content,status')->limit(mt_rand(5,10))->order('id desc')->select()->toArray();

				$gatherCount += count($gatherData);

				foreach($gatherData as $k => $v){

					if($gatherCount > $con){
						$publishArr[$con]['title'] = $v['title'];
						$publishArr[$con]['content']  = $v['content'];
						$publishArr[$con]['application_password']  = $value['application_password'];
						$publishArr[$con]['b_title']  = $value['title'];
						$publishArr[$con]['gather_id']  = $v['id'];
						$publishArr[$con]['backend_id']  = $value['id'];
					}
	
					$con++;
				}
			}

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

					// return json_encode(['code'=>200,'status'=>'success','msg'=>$msg]);

					$publishData = $this->publish();


					$publishResult = $this->curlPostPublish($publishData);

					if($publishResult){

						Log::info("数据发布成功");

						return json_encode(['code'=>200,'status'=>'success','msg'=>'数据发布成功']);

					}else{

						Log::info("数据发布失败");

						return json_encode(['code'=>0,'status'=>'error','msg'=>'数据发布失败']);

					}


				}else{

					Log::info("发布数据更新失败");
					return json_encode(['code'=>0,'status'=>'error','msg'=>'数据发布失败']);
				}

			}else{

				Log::info("数据不存在");

				return json_encode(['code'=>0,'status'=>'error','msg'=>'发布失败']);

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
			$mh = curl_multi_init();
			$data    = array();
			$handle  = array();
			$running = 0;
			$mh = curl_multi_init(); // multi curl handler
			$i = 0;

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


		public function publishOne(){

			// return base64_encode("admin:admin123520..");
			// return base64_encode("publishs:RB9t 5prc QEhW Xa4R udw6 0t6S");


			$username = $this->admin;
			$application_password = "I2kE oGC6 9rDS T9lI yai8 YZnZ";
			
			$url = "https://www.basissteel.com/{$this->api_url}";
			
			$json = json_encode([
				'title' => "123123",
				'content' => "12313",
				'status' => 'publish',
			]);

			try {
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$application_password);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				$result = curl_exec($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

				Log::info("采集数据发布成功，对应链接：".$url);

				Log::info($status_code);

				dump(json_decode($result,true));

				

			} catch(Exception $e) {
				echo $e->getMessage();
			}

		} 

}
