<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\trace\publicsavetrace.html";i:1706236661;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户维护</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="__LAYUI__/css/layui.css"  media="all">
   <link rel="stylesheet" href="__LAYUI__/tab/layui.css?t=1619028572570" media="all">
   <link href="__HOME__/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
   <link href="__HOME__/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
  <link href="__HOME__/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
  <link href="__ADMIN__/css/style.min.css" rel="stylesheet">
   <style>
    body{margin: 10px;}
  </style>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
  <style media="screen">
      .layui-inline{width: 30%;}
      .layui-form-label{width: 110px;}
      .layui-fluid{padding:5px}
      .layui-tab-item{margin-top: -10px;}
  </style>
</head>
<body class="gray-bg">
    
      <div class="layui-fluid">
          <div class="layui-card">
            <div class="layui-card-body" style="padding: 15px;">
                <form class="layui-form" action="<?php echo url('publicsavetrace'); ?>" method="post" data-type="ajax">
                <div class="layui-form-item" style="height: 1000px">
                    <div class="layui-inline">
                        <label class="layui-form-label"> 应用名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="app_name" value="<?php if($getInfo['app_name']): ?><?php echo $getInfo['app_name']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 包</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="app_package" value="<?php if($getInfo['app_package']): ?><?php echo $getInfo['app_package']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 包名</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="package_name" value="<?php if($getInfo['package_name']): ?><?php echo $getInfo['package_name']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 主类名</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="main_name" value="<?php if($getInfo['main_name']): ?><?php echo $getInfo['main_name']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    
                    <div class="layui-inline">
                        <label class="layui-form-label">功能</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="app_function" value="<?php if($getInfo['app_function']): ?><?php echo $getInfo['app_function']; endif; ?>" autocomplete="off" class="layui-input" id="full">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 类型</label>
                        <div class="layui-input-block">
                            <div class="layui-inline" style="width:190px;">
                                <select name="app_type" >
                                    <option value="" disabled>请选择</option>
                                    <option value="1" <?php if($getInfo['app_type'] == 1): ?>selected<?php endif; ?>>H5</option>
                                    <option value="2" <?php if($getInfo['app_type'] == 2): ?>selected<?php endif; ?>>原生</option>
                                    <option value="3" <?php if($getInfo['app_type'] == 3): ?>selected<?php endif; ?>>UNIAPP</option>
                                    <option value="4" <?php if($getInfo['app_type'] == 4): ?>selected<?php endif; ?>>H5+TP</option>
                                    <option value="6" <?php if($getInfo['app_type'] == 6): ?>selected<?php endif; ?>>Unity</option>
                                    <option value="7" <?php if($getInfo['app_type'] == 7): ?>selected<?php endif; ?>>Cocos</option>
                                    <option value="5" <?php if($getInfo['app_type'] == 5): ?>selected<?php endif; ?>>IOS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 提包服务器</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="bag_vps" value="<?php if($getInfo['bag_vps']): ?><?php echo $getInfo['bag_vps']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 接口服务器</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="api_vps" value="<?php if($getInfo['api_vps']): ?><?php echo $getInfo['api_vps']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 服务器用户名</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="vps_username" value="<?php if($getInfo['vps_username']): ?><?php echo $getInfo['vps_username']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 服务器密码</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="vps_password" value="<?php if($getInfo['vps_password']): ?><?php echo $getInfo['vps_password']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> AFdev</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="afdev" value="<?php if($getInfo['afdev']): ?><?php echo $getInfo['afdev']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> AF账号</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="afaccount" value="<?php if($getInfo['afaccount']): ?><?php echo $getInfo['afaccount']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 谷歌邮箱</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="app_gmail" value="<?php if($getInfo['app_gmail']): ?><?php echo $getInfo['app_gmail']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 谷歌邮箱密码</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="google_email_password" value="<?php if($getInfo['google_email_password']): ?><?php echo $getInfo['google_email_password']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 谷歌辅助邮箱</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="google_assist_email" value="<?php if($getInfo['google_assist_email']): ?><?php echo $getInfo['google_assist_email']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> Google Play链接</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="google_play_link" value="<?php if($getInfo['google_play_link']): ?><?php echo $getInfo['google_play_link']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> IP查询TOKEN</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="spare_code" value="<?php if($getInfo['spare_code']): ?><?php echo $getInfo['spare_code']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 身份验证</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="google_auth" value="<?php if($getInfo['google_auth']): ?><?php echo $getInfo['google_auth']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 数字签名</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="signature" value="<?php if($getInfo['signature']): ?><?php echo $getInfo['signature']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>


                    <div class="layui-inline">
                        <label class="layui-form-label"> 提包日期</label>
                        <div class="layui-input-inline">
                            <input type="text" name="bag_time" value="<?php if($getInfo['bag_time']): ?><?php echo $getInfo['bag_time']; endif; ?>" autocomplete="off" class="layui-input" id="bag_time">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 被封原因</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="blocked_cause" value="<?php if($getInfo['blocked_cause']): ?><?php echo $getInfo['blocked_cause']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    
                    <div class="layui-inline">
                        <label class="layui-form-label"> 域名地址</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="domain_url" value="<?php if($getInfo['domain_url']): ?><?php echo $getInfo['domain_url']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 隐私协议地址</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="privacy_agreement_url" value="<?php if($getInfo['privacy_agreement_url']): ?><?php echo $getInfo['privacy_agreement_url']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 跳转链接</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="jump_url" value="<?php if($getInfo['jump_url']): ?><?php echo $getInfo['jump_url']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 跳转项目组</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="b_project" value="<?php if($getInfo['b_project']): ?><?php echo $getInfo['b_project']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 跳转开关 </label>
                        <div class="layui-input-block">
                            <input type="checkbox" <?php if($getInfo['jump_switch'] == 'on'): ?>checked=""<?php endif; if($getInfo[id] == '0'): ?>checked<?php endif; ?> name="jump_switch" lay-skin="switch" lay-filter="jump_switch" lay-text="ON|OFF" >
                          </div>
                    </div>

                    

                    <div class="layui-inline">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <div class="layui-inline" style="width:190px;">
                                <select name="status" >
                                    <option value="" disabled>请选择</option>
                                    <option value="1" <?php if($getInfo['status'] == 1): ?>selected<?php endif; ?>>已上架</option>
                                    <option value="2" <?php if($getInfo['status'] == 2): ?>selected<?php endif; ?>>审核中</option>
                                    <option value="3" <?php if($getInfo['status'] == 3): ?>selected<?php endif; ?>>待审核</option>
                                    <option value="4" <?php if($getInfo['status'] == 4): ?>selected<?php endif; ?>>账号禁用</option>
                                    <option value="5" <?php if($getInfo['status'] == 5): ?>selected<?php endif; ?>>分配中</option>
                                    <option value="6" <?php if($getInfo['status'] == 6): ?>selected<?php endif; ?>>已暂停</option>
                                    <option value="7" <?php if($getInfo['status'] == 7): ?>selected<?php endif; ?>>待验证</option>
                                    <option value="8" <?php if($getInfo['status'] == 8): ?>selected<?php endif; ?>>已下架</option>
                                    <option value="9" <?php if($getInfo['status'] == 9): ?>selected<?php endif; ?>>账号关联</option>
                                    <option value="10" <?php if($getInfo['status'] == 10): ?>selected<?php endif; ?>>更新中</option>
                                    <option value="11" <?php if($getInfo['status'] == 11): ?>selected<?php endif; ?>>其他</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label">域名验证</label>
                        <div class="layui-input-block">
                            <div class="layui-inline" style="width:190px;">
                                <select name="google_sharch_status" >
                                    <option value="" disabled>请选择</option>
                                    <option value="1" <?php if($getInfo['google_sharch_status'] == 1): ?>selected<?php endif; ?>>已验证</option>
                                    <option value="0" <?php if($getInfo['google_sharch_status'] == 0): ?>selected<?php endif; ?>>未验证</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label">HTTPS 启用状态</label>
                        <div class="layui-input-block">
                            <div class="layui-inline" style="width:190px;">
                                <select name="https_status" >
                                    <option value="" disabled>请选择</option>
                                    <option value="1" <?php if($getInfo['https_status'] == 1): ?>selected<?php endif; ?>>已启用</option>
                                    <option value="0" <?php if($getInfo['https_status'] == 0): ?>selected<?php endif; ?>>未启用</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> k3/Adtoken</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="k3" value="<?php if($getInfo['k3']): ?><?php echo $getInfo['k3']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> K4/AdRegToken</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="k4" value="<?php if($getInfo['k4']): ?><?php echo $getInfo['k4']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> Sha1</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="sha1" value="<?php if($getInfo['sha1']): ?><?php echo $getInfo['sha1']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 上架日期</label>
                        <div class="layui-input-inline">
                            <input type="text" name="up_time" value="<?php if($getInfo['up_time']): ?><?php echo $getInfo['up_time']; endif; ?>" autocomplete="off" class="layui-input" id="up_time">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 更新原因</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="update_reason" value="<?php if($getInfo['update_reason']): ?><?php echo $getInfo['update_reason']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <!-- <div class="layui-inline">
                        <label class="layui-form-label"> 更新批次</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="update_batch" value="<?php if($getInfo['update_batch']): ?><?php echo $getInfo['update_batch']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div> -->

                    <div class="layui-inline">
                        <label class="layui-form-label"> 下架日期</label>
                        <div class="layui-input-inline">
                            <input type="text" name="down_time" value="<?php if($getInfo['down_time']): ?><?php echo $getInfo['down_time']; endif; ?>" autocomplete="off" class="layui-input" id="down_time">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 下架原因</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="down_reason" value="<?php if($getInfo['down_reason']): ?><?php echo $getInfo['down_reason']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    
                    <div class="layui-inline">
                        <label class="layui-form-label"> 讨论组id</label>
                        <div class="layui-input-block" id="demo1" style="width:280px">
                            
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 热更新开关</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" <?php if($getInfo['update_switch'] == 'on'): ?>checked=""<?php endif; if($getInfo[id] == '0'): ?>checked<?php endif; ?> name="update_switch" lay-skin="switch" lay-filter="update_switch" lay-text="ON|OFF" >
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 热更新地址</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="update_url" value="<?php if($getInfo['update_url']): ?><?php echo $getInfo['update_url']; endif; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <label class="layui-form-label"> 发布人员</label>
                        <div class="layui-input-block">
                            <div class="layui-inline" style="width:190px;">
                                <select name="publish_id">
                                    <option value="" disabled>请选择</option>
                                    <?php if(is_array($userInfo) || $userInfo instanceof \think\Collection || $userInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>" <?php if($getInfo['publish_id'] == $vo['id']): ?>selected<?php endif; ?>><?php echo $vo['nickname']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                     

                    <div class="layui-inline">
                        <label class="layui-form-label"> 图片上传</label>
                        <div class="layui-input-inline">
                            <button type="button" class="layui-btn" id="test1">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                            <input name="image" type="hidden" id="image">
                            <span style="float: right;width: 40%;"><img id="settingImage"  style="width: 100%;"/></span>
                        </div>
                    </div>

                    <div class="layui-inline" style="display:none">
                        <label class="layui-form-label"> 多选下拉框控件</label>
                        <div class="layui-input-block" id="demo1" style="width:280px">
                            
                        </div>
                    </div>
                    

                    <div class="layui-input-block">
                        <input type="hidden" name="tele_chatid" value="<?php echo $tele_chatid; ?>" id="test">
                        <input type="hidden" name="id" value="<?php if($getInfo['id'] != 0): ?><?php echo $getInfo['id']; endif; ?>">
                        <div class="layui-footer" style="left: 75px;background:#fff;box-shadow: none;margin-top: 30px;">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="component-form-demo1">保存</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        <a  class="layui-btn layui-btn-normal layui-btn-radius" onclick="javascript:history.go(-1);">返回</a>
                      </div>
                    </div>
                </div>

              </form>
            </div>
          </div>
        </div>

        <script src="__HOME__/js/jquery.min.js"></script>
        <script src="__ADMIN__/js/plugins/layer/layer.min.js"></script>
        <script src="__ADMIN__/js/xm-select/xm-select.js"></script>
        <script src="__LAYUI__/layui.js" charset="utf-8"></script>
        <script src="__LAYUI__/layer_hplus.js" charset="utf-8"></script>

        
        <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
        <script>

            layui.use(['form', 'layer', 'layedit', 'laydate','upload'], function(){
            //得到各种内置组件
            var layer = layui.layer //弹层
            ,form = layui.form
            ,laydate = layui.laydate
            ,upload = layui.upload
            ,element = layui.element; //元素操作;

                //执行实例
                var uploadInst = upload.render({
                    elem: '#test1' //绑定元素
                    ,url: '<?php echo url("uploads"); ?>' //上传接口
                    ,data: {id:<?php if($getInfo['id'] >0): ?><?php echo $getInfo['id']; else: ?>0<?php endif; ?>}
                    ,done: function(res){
                    //上传完毕回调
                        if(res.code == 200){
                            $('#image').val(res.data.saveName);
                            $('#settingImage').attr("src","__UPLOADS__/"+res.data.saveName);
                            layer.msg(''+res.msg+'',{icon: 6});
                        }else{
                            layer.msg(''+res.msg+'',{icon: 5});
                        }
                    }
                    ,error: function(){
                        layer.msg(''+res.msg+'',{icon: 5});
                    }
                });

                // 提包日期
                laydate.render({
                    elem:'#bag_time',
                    format:'yyyy/MM/dd'
                    , trigger: 'click'
                });

                // 上架日期
                laydate.render({
                    elem:'#up_time',
                    format:'yyyy/MM/dd'
                    , trigger: 'click'
                });
                
                // 下架日期 
                laydate.render({
                    elem:'#down_time',
                    format:'yyyy/MM/dd'
                    , trigger: 'click'
                });


                //跳转开关
                form.on('switch(jump_switch)', function(data){
                    layer.msg('跳转开关'+ (this.checked ? '开启' : '禁用'), {
                    offset: '6px'
                    });
                    //layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
                });

                // 热更新开关 update_switch
                form.on('switch(update_switch)', function(data){
                    layer.msg('热更新开关'+ (this.checked ? '开启' : '禁用'), {
                    offset: '6px'
                    });
                    //layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
                });

                // 状态
                form.on('switch(status)', function(data){
                    layer.msg('状态：'+ (this.checked ? '开启' : '禁用'), {
                    offset: '6px'
                    });
                    //layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
                });

            });

            var demo1 = xmSelect.render({
                el: '#demo1',
                language: 'zn',
                autoRow: true,
                height: '500px',
                theme: {
                    color: '#8dc63f',
                },
                filterable: true,
                toolbar: {
                    show: true,
                },
                data: <?php echo $chats; ?>,
                on: function(data){
                    //arr:  当前多选已选中的数据
                    var arr = data.arr;
                    let arr1 = [];
                    for (let j in arr) {
                        arr1.push(arr[j]['name']);
                    }

                    $('#test').val(arr1);

                    
                },
            })


        </script>

</body>
</html>
