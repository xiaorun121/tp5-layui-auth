<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\permission\rolepermissionsetting.html";i:1615534413;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="__LAYUI__/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<form class="layui-form" action="<?php echo url('rolePermissionSetting'); ?>" method="post" data-type="ajax">
<div id="test5" class="demo-tree"></div>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
  <legend>权限配置</legend>
</fieldset>
<div id="test7" class="demo-tree">
    <div class="layui-tree layui-form layui-tree-line" lay-filter="LAY-tree-7">
        <?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>

        <div data-id="<?php echo $v['id']; ?>" class="layui-tree-set layui-tree-setHide layui-tree-spread">
          <?php if($v['level'] == 0): ?>
            <div class="layui-tree-entry">
                <div class="layui-tree-main">
                    <span class="layui-tree-iconClick layui-tree-icon">
                        <i class="layui-icon layui-icon-subtraction" ></i>
                    </span>
                    <input type="checkbox" name="menu_id[]" same="layuiTreeCheck" lay-skin="primary" value="<?php echo $v['id']; ?>" id="check<?php echo $v['id']; ?>" <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>checked="checked"<?php endif; ?>>
                    <div class="layui-unselect layui-form-checkbox <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>layui-form-checked<?php endif; ?>" lay-skin="primary" id="checked<?php echo $v['id']; ?>" onclick="addClass(<?php echo $v['id']; ?>)">
                        <i class="layui-icon layui-icon-ok" ></i>
                    </div>
                    <span class="layui-tree-txt"><?php echo $v['name']; ?></span>
                </div>
            </div>
            <?php endif; ?>
            <div class="layui-tree-pack layui-tree-lineExtend layui-tree-showLine" style="display: block;">
                <?php if($v['level'] == 1): ?>
                <div data-id="<?php echo $v['id']; ?>" class="layui-tree-set">
                    <div class="layui-tree-entry">
                        <div class="layui-tree-main">
                            <span class="layui-tree-iconClick">
                                <i class="layui-icon layui-icon-file"></i>
                            </span>
                            <input type="checkbox" name="menu_id[]" same="layuiTreeCheck" lay-skin="primary" value="<?php echo $v['id']; ?>" id="check<?php echo $v['id']; ?>" <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>checked="checked"<?php endif; ?>>
                            <div class="layui-unselect layui-form-checkbox <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>layui-form-checked<?php endif; ?>" lay-skin="primary"  id="checked<?php echo $v['id']; ?>" onclick="addClass(<?php echo $v['id']; ?>)">
                                <i class="layui-icon layui-icon-ok"></i>
                            </div>
                            <span class="layui-tree-txt"><?php echo $v['name']; ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="layui-tree-pack layui-tree-lineExtend layui-tree-showLine" style="display: block;">
                    <?php if($v['level'] == 2): ?>
                    <div data-id="<?php echo $v['id']; ?>" class="layui-tree-set">
                        <div class="layui-tree-entry">
                            <div class="layui-tree-main">
                                <span class="layui-tree-iconClick">
                                    <i class="layui-icon layui-icon-file"></i>
                                </span>
                                <input type="checkbox" name="menu_id[]" same="layuiTreeCheck" lay-skin="primary" value="<?php echo $v['id']; ?>" id="check<?php echo $v['id']; ?>" <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>checked="checked"<?php endif; ?>>
                                <div class="layui-unselect layui-form-checkbox <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>layui-form-checked<?php endif; ?>" lay-skin="primary" id="checked<?php echo $v['id']; ?>" onclick="addClass(<?php echo $v['id']; ?>)">
                                    <i class="layui-icon layui-icon-ok"></i>
                                </div>
                                <span class="layui-tree-txt"><?php echo $v['name']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="layui-tree-pack layui-tree-lineExtend layui-tree-showLine" style="display: block;">
                        <?php if($v['level'] == 3): ?>
                        <div data-id="<?php echo $v['id']; ?>" class="layui-tree-set">
                            <div class="layui-tree-entry">
                                <div class="layui-tree-main">
                                    <span class="layui-tree-iconClick">
                                        <i class="layui-icon layui-icon-file"></i>
                                    </span>
                                    <input type="checkbox" name="menu_id[]" same="layuiTreeCheck" lay-skin="primary" value="<?php echo $v['id']; ?>" id="check<?php echo $v['id']; ?>" <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>checked="checked"<?php endif; ?>>
                                    <div class="layui-unselect layui-form-checkbox <?php if(in_array(($v['id']), is_array($menu_id)?$menu_id:explode(',',$menu_id))): ?>layui-form-checked<?php endif; ?>" lay-skin="primary" id="checked<?php echo $v['id']; ?>" onclick="addClass(<?php echo $v['id']; ?>)">
                                        <i class="layui-icon layui-icon-ok"></i>
                                    </div>
                                    <span class="layui-tree-txt"><?php echo $v['name']; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>

      </div>
  </div>
</div>
<div class="layui-form-item">
</div>
<div class="layui-form-item">
  <div class="layui-input-block">
    <input type="hidden" name="role_id" value="<?php echo $id; ?>">
    <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    <a  class="layui-btn layui-btn-normal layui-btn-radius" onclick="javascript:history.go(-1);">返回</a>
  </div>
</div>
</form>

<!-- <script src="__LAYUI__/layui.js" charset="utf-8"></script> -->
<script src="__HOME__/js/jquery.min.js"></script>
<script src="__ADMIN__/js/plugins/layer/layer.min.js"></script>
<script src="__LAYUI__/layer_hplus.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    function addClass(id){
        var check = document.getElementById("check"+id);
        if($('#checked'+id).hasClass('layui-form-checked')){

            $('#checked'+id).removeClass('layui-form-checked');
            check.checked = false;
        }else{

            $('#checked'+id).addClass('layui-form-checked');
            check.checked = true;
        }
    }
</script>

</body>
</html>
