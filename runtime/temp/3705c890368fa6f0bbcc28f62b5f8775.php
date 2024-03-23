<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\user\publicsaveuser.html";i:1615534666;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>用户维护</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="__LAYUI__/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>

<form class="layui-form" action="<?php echo url('publicsaveuser'); ?>" method="post" data-type="ajax">

  <div class="layui-form-item">

  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">用户名：</label>
    <div class="layui-input-inline">
      <!-- <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input"> -->
      <input type="text" name="username" lay-verify="required" lay-reqtext="用户名是必填项，岂能为空？" value="<?php if($getInfo['username']): ?><?php echo $getInfo['username']; endif; ?>" placeholder="请输入用户名" autocomplete="off" class="layui-input" style="width: 270px;">
    </div>
    <!-- <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div> -->
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">昵称：</label>
    <div class="layui-input-inline">
      <input type="text" name="nickname" placeholder="请输入昵称" autocomplete="off" value="<?php if($getInfo['nickname']): ?><?php echo $getInfo['nickname']; endif; ?>" class="layui-input" style="width: 270px;">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">电子邮箱：</label>
    <div class="layui-input-inline">
      <input type="text" name="email" placeholder="请输入邮箱" value="<?php if($getInfo['email']): ?><?php echo $getInfo['email']; endif; ?>" autocomplete="off" class="layui-input" style="width: 270px;">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">性别：</label>
    <div class="layui-input-block">
      <?php if($getInfo[sex]): if($getInfo[sex] == '男'): ?>
              <input type="radio" name="sex" value="男" title="男" checked="">
              <input type="radio" name="sex" value="女" title="女">
          <?php else: ?>
              <input type="radio" name="sex" value="男" title="男">
              <input type="radio" name="sex" value="女" title="女" checked="">
          <?php endif; else: ?>
        <input type="radio" name="sex" value="男" title="男" checked="">
        <input type="radio" name="sex" value="女" title="女">
      <?php endif; ?>

      <!-- <input type="radio" name="sex" value="禁" title="禁用" disabled=""> -->
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">出生日期：</label>
      <div class="layui-input-block">
        <input type="text" name="birth" id="date1" autocomplete="off" value="<?php if($getInfo['birth']): ?><?php echo $getInfo['birth']; endif; ?>" class="layui-input" style="width: 270px;">
      </div>
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">地址：</label>
    <div class="layui-input-inline">
      <textarea placeholder="请输入内容" name="address" class="layui-textarea" style="width: 270px;"><?php if($getInfo['address']): ?><?php echo $getInfo['address']; endif; ?></textarea>
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">角色：</label>
    <div class="layui-input-inline">
      <select name="role_id">
        <option value="">请选择</option>
        <?php if(is_array($roleInfo) || $roleInfo instanceof \think\Collection || $roleInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $roleInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $v['id']; ?>" <?php if($getInfo['role_id']): if($getInfo['role_id'] == $v['id']): ?>selected<?php endif; endif; ?>><?php echo $v['name']; ?></option>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
    </div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">状态：</label>
    <div class="layui-input-block">
      <input type="checkbox" <?php if($getInfo['open'] == 'on'): ?>checked=""<?php endif; if($getInfo[id] == '0'): ?>checked<?php endif; ?> name="open" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF" >
    </div>
  </div>

  <?php if($getInfo[id] == '0'): ?>
  <div class="layui-form-item">
    <label class="layui-form-label">密码：</label>
    <div class="layui-input-inline">
      <input type="password" name="password" lay-verify="required" placeholder="请输入密码" lay-reqtext="密码是必填项，岂能为空？" autocomplete="off" class="layui-input" style="width: 270px;">
    </div>
  </div>
  <?php endif; ?>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <input type="hidden" name="id" value="<?php if($getInfo['id'] != 0): ?><?php echo $getInfo['id']; endif; ?>">
      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
      <a  class="layui-btn layui-btn-normal layui-btn-radius" onclick="javascript:history.go(-1);">返回</a>
    </div>
  </div>
</form>

<script src="__HOME__/js/jquery.min.js"></script>
<script src="__ADMIN__/js/plugins/layer/layer.min.js"></script>
<script src="__LAYUI__/layui.js" charset="utf-8"></script>
<script src="__LAYUI__/layer_hplus.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form
  ,laydate = layui.laydate;

  //日期
  laydate.render({
    elem: '#date1'
  });


  //监听指定开关
  form.on('switch(switchTest)', function(data){
    layer.msg('用户状态：'+ (this.checked ? '开启' : '禁用'), {
      offset: '6px'
    });
    //layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
  });

});
</script>

</body>
</html>
