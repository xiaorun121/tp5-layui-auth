<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"E:\phpstudy_pro\WWW\www.tp5.com\public/../application/admin\view\admin\website.html";i:1710394808;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>网站设置</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="__LAYUI__/css/layui.css" media="all">
  <style>
    .layui-fluid{padding:15px}
  </style>
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <form class="layui-form" action="" lay-filter="component-form-group" method="post" data-type="ajax">
        <div class="layui-card">
          <div class="layui-card-header">网站设置</div>
          <div class="layui-card-body" pad15>

            <div class="layui-form" wid100 lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">网站名称</label>
                <div class="layui-input-block">
                  <input type="text" name="name" value="<?php echo $info['name']; ?>" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">网站域名</label>
                <div class="layui-input-block">
                  <input type="text" name="url" lay-verify="url" value="<?php echo $info['url']; ?>" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">首页标题</label>
                <div class="layui-input-block">
                  <textarea name="title" class="layui-textarea"><?php echo $info['title']; ?></textarea>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">META关键词</label>
                <div class="layui-input-block">
                  <textarea name="keywords" class="layui-textarea" placeholder="多个关键词用英文状态 , 号分割"><?php echo $info['keywords']; ?></textarea>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">META描述</label>
                <div class="layui-input-block">
                  <textarea name="description" class="layui-textarea"><?php echo $info['description']; ?></textarea>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">版权信息</label>
                <div class="layui-input-block">
                  <textarea name="copyright" class="layui-textarea"><?php echo $info['copyright']; ?></textarea>
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" type="submit" lay-submit lay-filter="set_website">确认保存</button>
                </div>
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
</body>
</html>
