<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\gather\savegatheradmin.html";i:1704943593;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>采集列表</title>
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
                <form class="layui-form" action="<?php echo url('saveGatherAdmin'); ?>" method="post" data-type="ajax">
                <div class="layui-form-item" >

                    <div class="layui-inline" id="url">
                        <label class="layui-form-label"> 链接</label>
                        <div class="layui-input-inline">
                            <input type="text" name="url" value="<?php echo $getInfo['url']; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline"></div>
                    <div class="layui-inline"></div>

                    <div class="layui-inline" id="keywords">
                        <label class="layui-form-label"> 关键字</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keywords" value="<?php echo $getInfo['keywords']; ?>" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline"></div>
                    <div class="layui-inline"></div>


                    <div class="layui-input-block">
                        <input type="hidden" name="id" value="<?php if($getInfo['id'] != 0): ?><?php echo $getInfo['id']; endif; ?>">
                        <div class="layui-footer" style="left: 75px;background:#fff;box-shadow: none;margin-top: 30px;">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="component-form-demo1">保存</button>
                        <a  class="layui-btn layui-btn-normal layui-btn-radius" onclick="javascript:history.go(-1);">返回</a>
                        </div>
                    </div>
                    </div>
                </div>

              </form>
            </div>
          </div>
        </div>

        <script src="__HOME__/js/jquery.min.js"></script>
        <script src="__ADMIN__/js/plugins/layer/layer.min.js"></script>
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

    

    });

    </script>

</body>
</html>