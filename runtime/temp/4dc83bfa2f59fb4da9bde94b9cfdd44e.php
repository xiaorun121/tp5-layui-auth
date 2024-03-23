<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\gather\gatherarticle.html";i:1700808269;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>采集文章</title>
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
                <div class="layui-form-item" style="height: 900px">

                    <div class="layui-inline" style="width: 600px;">
                        <label class="layui-form-label"> 文章标题类名（class）</label>
                        
                        <div class="layui-input-inline">
                            <input type="text" name="title_class" id="title_class" value=""  class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline" ></div>
                    <div class="layui-inline" ></div>

                    <div class="layui-inline" >
                        <label class="layui-form-label"> 文章详情类名（class）</label>
                        <div class="layui-input-inline">
                            <input type="text" name="content_class" id="content_class" value=""  class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline" ></div>
                    <div class="layui-inline" ></div>

                    <div class="layui-inline" style="width: 500px;">
                        <label class="layui-form-label"> 链接</label>
                        <div class="layui-input-inline" style="width: 250px;">
                            <input type="text" name="link" id="link" value="" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-inline" ></div>
                    <div class="layui-inline" ></div>
                    
                    <div class="layui-inline" id="title" style="display: none;">
                        <label class="layui-form-label"> 列表标题</label>
                        <div class="layui-input-inline">
                            <input type="text" name="app_name" value="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline"></div>
                    <div class="layui-inline"></div>

                    <div class="layui-inline" id="content" style="display: none;">
                        <label class="layui-form-label"> 内容</label>
                        <div class="layui-input-inline" >
                            <textarea id="container"  name="content" style="width: 1200px;height: 500px;"></textarea>
                        </div>
                    </div>

                    <div class="layui-input-block">
                        <div class="layui-btn-container">
                            <button type="button" onclick="onGather()" class="layui-btn layui-btn-danger">采集</button>
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
        <script src="__ADMIN__/ueditor/ueditor.config.js"></script>
        <script src="__ADMIN__/ueditor/ueditor.all.min.js"></script>
        
        <script>
            //id=container是编辑器的选择器
            UE.getEditor("container");

            function onGather(){

                var index = layer.load();

                var title_class = $("#title_class").val();
                var content_class = $("#content_class").val();
                var link = $("#link").val();

                if(title_class == ''){
                    layer.msg("文章标题类名必须填写",{offset: '6px'});
                    return;
                }
                if(content_class == ''){
                    layer.msg("文章详情类名必须填写",{offset: '6px'});
                    return;
                }
                if(link == ''){
                    layer.msg("链接必须填写",{offset: '6px'});
                    return;
                }

                $.ajax({
                    url:'<?php echo url("gatherArticle"); ?>',
                    data:{title_class:title_class,content_class:content_class,link:link},
                    type:"post",
                    dataType:'json',
                    success:function(data){
                        layer.close(index);

                        if(data.code == 200){
                            
                            layer.msg(data.msg,{
                                offset: '6px'
                            });
                        }else{
                            layer.msg(data.msg,{
                                offset: '6px'
                            });
                        }
                    },
                    error:function(err){
                        layer.close(index);
                        layer.msg("网络异常",{
                            offset: '6px'
                        });
                    }
                })
            }
      </script>
        
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
