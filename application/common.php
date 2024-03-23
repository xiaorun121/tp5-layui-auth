<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\admin\model\Menu;
use app\admin\model\KpiAssessment;
// 应用公共文件
error_reporting(0);

use think\Db;

function get_tree($data, $parent_id = 0, $level = 0) {
    static $arr = array();
    foreach ($data as $d) {
        if ($d['parent_id'] == $parent_id) {
            $d['level'] = $level;
            $arr[] = $d;
            get_tree($data, $d['id'], $level + 1);
        }
    }

    return $arr;
}

function get_tree_left($data, $parent_id = 0) {
    static $arr = array();
    foreach ($data as $d) {

        if ($d['parent_id'] == $parent_id) {

            $role_id = session('user.role_id');
            $role = Db::name('role')->where('id',$role_id)->find();
            $role_name = $role['name'];

            // 根据角色查询对应的权限 
            $menu_id = Db::name('permission')->where('role_id',$role_id)->field('menu_id')->select();
            foreach ($menu_id as $key => $value) {
                $menu_id[$key] = $value['menu_id'];
            }

            // 所有的权限id 以逗号隔开
            $menu_id = implode(',',$menu_id);

            // 根据权限id查询出对应的权限菜单
            $menu =  (new Menu)->where('parent_id',$d['id'])->where('id','in',$menu_id)->where('is_menu',1)->order('sort asc')->select();

            $d['children'] = array();
            foreach ($menu as $key => $value) {
                $menu[$key] = $value->toArray();
            }
            $d['children'] = $menu;    // 二级菜单

            // 三级菜单
            foreach($menu as $key => $val){
                $menu_child =  (new Menu)->where('parent_id',$val['id'])->where('id','in',$menu_id)->where('is_menu',1)->select();
                foreach ($menu_child as $k => $v) {
                    $d['children'][$key]['child'][] = $v->toArray();
                }
            }


            $arr[] = $d;
            get_tree($data, $d['id']);
        }
    }
    return $arr;
}

function success($msg = '成功', $url = ''){
    $data['status'] = 200;
    $data['msg']    = $msg;
    $data['url']    = $url;
    return json($data);
}


function error($msg = '失败', $url = ''){
    $data['status'] = 202;
    $data['msg']    = $msg;
    $data['url']    = $url;
    return json($data);
}

// 状态显示
function showOpen($open){
    if($open == 'on'){
          $data = '启用';
    }else{
          $data = '禁用';
    }
    return $data;
}

// 角色显示
function showRole($role_id = 0){
    $res = Db::name('role')->where('id',$role_id)->where('delete_time is  null')->field('name')->value('name');

    if(!empty($res)){
        return $res;
    }else{
        return '<font style="color:red">角色已删除，请重新分配角色</font>';
    }

}


// 状态
function showStatus($id){
    if($id == 1){
        return '启用';
    }else{
        return '关闭';
    }
}

// 用户状态显示
function display($status = 0){
    if($status == 1){
        $data = '是';
    }else{
        $data = '否';
    }
    return $data;
}

function Images($img = 0){
    if($img){
        $data = __UPLOADS__.'/'.$img;
    }else{
        $data = '';
    }
    return $data;
}

function getOrganization($id,$name){
    $firstname = Db::name('organization')->where('id',1)->value('name');
    if($id != 1){
        $oneData = Db::name('organization')->where('id',$id)->field('parent_id,name')->find();
        if($oneData['parent_id'] == 1){
            $data = $firstname.'/'.$oneData['name'];
        }else{
            $twoData = Db::name('organization')->where('id',$oneData['parent_id'])->field('parent_id,name')->find();
            if($twoData['parent_id'] == 1){
                $data = $firstname.'/'.$twoData['name'].'/'.$oneData['name'];
            }else{
                $threeData = Db::name('organization')->where('id',$twoData['parent_id'])->value(name);
                $data = $firstname.'/'.$threeData['name'].'/'.$twoData['name'].'/'.$oneData['name'];
            }
        }
    }else{
        $data = $name;
    }
    return $data;
}

function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? config('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    $str = sprintf('%010d', $expire ? $expire + time():0);
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? config('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);
    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}


// 获取当前登录的用户 角色信息
function getUserRoleInfo($user_id){

    if(!empty($user_id)){
        $result = Db::query("select a.id,a.username,a.nickname,a.role_id,a.open,b.id as user_role_id,b.name from ch_user as  a left join ch_role as b on a.role_id = b.id where a.id=".$user_id." and a.open = 'on'");
    }else{

        $result = '';
    }

    return $result;
}


// 获取更新的批次数据
function getAppTraceUpdate($app_id){

    $count = Db::name("app_trace_update")->where('app_id',$app_id)->count();

    if($count == 0){

        return 0;
    }else{

        return $count;
    }
}

// 获取后台地址
function getBackendUrl($id){
    $url = Db::name('backend')->where('id',$id)->where('delete_time is  null')->field('url')->value('url');


    if($url){
        return $url;
    }
}

// 获取采集数据标题
function getGatherUrl($id){
    $title = Db::name('gather')->where('id',$id)->where('delete_time is  null')->field('title')->value('title');


    if($title){
        return $title;
    }
}

// curl get 
function curl_get($url){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); // 从证书中检查SSL加密算法是否存在

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    curl_close($ch);
    // $decoded = json_decode($response,true);

    return $response;
}

// 获取用户名
function getUserNameToId($id){
    $username = Db::name('user')->where('id',$id)->where('delete_time is  null')->value('username');
    if($username){
        return $username;
    }
}


//HTTP状态码
function getHttpCode() {
    $httpCode = array(
        100 => "100 Continue",
        101 => "101 Switching Protocols",
        102 => "102 Processing",

        200 => "200 OK",
        201 => "201 Created",
        202 => "202 Accepted",
        203 => "203 Non-Authoritative Information",
        204 => "204 No Content",
        205 => "205 Reset Content",
        206 => "206 Partial Content",
        207 => "207 Multi-Status",

        300 => "300 Multiple Choices",
        301 => "301 Moved Permanently",
        302 => "302 Found",
        303 => "303 See Other",
        304 => "304 Not Modified",
        305 => "305 Use Proxy",
        306 => "306 Switch Proxy",
        307 => "307 Temporary Redirect",

        400 => "400 Bad Request",
        401 => "401 Authorization Required",
        402 => "402 Payment Required",
        403 => "403 Forbidden",
        404 => "404 Not Found",
        405 => "405 Method Not Allowed",
        406 => "406 Not Acceptable",
        407 => "407 Proxy Authentication Required",
        408 => "408 Request Time-out",
        409 => "409 Conflict",
        410 => "410 Gone",
        411 => "411 Length Required",
        412 => "412 Precondition Failed",
        413 => "413 Request Entity Too Large",
        414 => "414 Request-URI Too Large",
        415 => "415 Unsupported Media Type",
        416 => "416 Requested Range Not Satisfiable",
        417 => "417 Expectation Failed",
        418 => "418 I'm a teapot",
        421 => "421 Misdirected Request",
        422 => "422 Unprocessable Entity",
        423 => "423 Locked",
        424 => "424 Failed Dependency",
        425 => "425 Too Early",
        426 => "426 Upgrade Required",
        449 => "449 Retry With",
        451 => "451 Unavailable For Legal Reasons",

        500 => "500 Internal Server Error",
        501 => "501 Not Implemented",
        502 => "502 Bad Gateway",
        503 => "503 Service Unavailable",
        504 => "504 Gateway Timeout",
        505 => "505 HTTP Version Not Supported",
        506 => "506 Variant Also Negotiates",
        507 => "507 Insufficient Storage",
        509 => "509 Bandwidth Limit Exceeded",
        510 => "510 Not Extended",
        600 => "600 Unparseable Response Headers",
    );

    return $httpCode;
}
?>
