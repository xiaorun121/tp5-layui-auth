<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use app\admin\model\Permission;
use app\admin\model\Menu;
use app\admin\model\Website;

use PHPExcel_IOFactory;
use PHPExcel;


class Common extends Controller
{

    // 定义角色id
    protected $roleId;

	public function _initialize(){

        // 先假设存在session
        if(session('user.name')==null){
            session(null);
            $this->redirect('login/index');
        }

        // 得到角色id
        $this->roleId = session('user.role_id');

        //请求的URL
        $url = $this->request->baseUrl();

        //判断是否以.html结尾
        if (strrpos($url, '.html') > 0) {
            $url = substr($url, 0, strrpos($url, '.html'));
        }

		$id = session('user.id');
        $permission = new Permission();
        $permissions = $permission->get_login_user_permissions($id);

		array_push($permissions,'/admin','/admin/index/index','/admin/index/content','/admin/index/info');


        if (array_search($url, $permissions) === false) {

            if ($this->request->isAjax()) {
                
                json(array("code"=>"403","status"=>"false","msg"=>"没有权限访问该模块"))->send();

                exit();

            } else {

                $u = url('/admin/index/index');
                exit("<script type='text/javascript'>alert('没有权限访问该模块');history.go(-1);</script>");


            }
        }

        
        return view();

    }

		/* 生成二维码 */
    public function getQrcode(Request $request){
        if($request->isPost()){
            $xh = $request->param('xh');

            // $pathname = APP_PATH . '/../Public/upload/';
            // if(!is_dir($pathname)) { //若目录不存在则创建之
            //     mkdir($pathname);
            // }

            vendor('phpqrcode.phpqrcode');//引入类库
            $value = $this->loginurl.'?xh='.$xh;         //二维码内容
            $errorCorrectionLevel = 'L';  //容错级别
            $matrixPointSize = 10;      //生成图片大小
            //生成二维码图片

            //设置二维码文件名
            $filename = 'public/qrcode/'.date('YmdHis',time()).rand(10000,9999999).$xh.'.png';
            //生成二维码
            \QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);

            $request = Request::instance();
            $domain = $request->domain(); //根据自己的项目路径适当修改

            $img = $domain.'/'. $filename;
            echo json_encode(['img'=>$img,'code'=>200]);
        }
    }

    // 通过截取年、月、日来进行比较计算年龄
	public function getAgeByIdcard($idcard){
		$year = substr($idcard, 6, 4);
		$monthDay = substr($idcard, 10, 4);

		$age = date('Y') - $year;
		if ($monthDay > date('md')) {
			$age--;
		}
		return $age;
	}

    function curl_get($url){
 
        $header = array(
            'Accept: application/json',
        );
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 超时设置,以秒为单位
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        
        // 超时设置，以毫秒为单位
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
        
        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //执行命令
        $data = curl_exec($curl);
        
        // 显示错误信息
        if (curl_error($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // 打印返回的内容
            
            curl_close($curl);

            return $data;
        }
    }
		
}
?>
