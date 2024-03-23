<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\login\index.html";i:1710394834;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 登录</title>
    <meta name="keywords" content="登录">
    <meta name="description" content="登录>

    <link rel="shortcut icon" href="favicon.ico">
    <link href="__ADMIN__/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="__ADMIN__/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

    <link href="__ADMIN__/css/animate.min.css" rel="stylesheet">
    <link href="__ADMIN__/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown" style="margin: 100px auto !important;">
        <div>
           
            <h3>欢迎登录畅恒互娱管理后台<?php echo session('user.name'); ?></h3>

            <form class="m-t layui-form" action="<?php echo url('index'); ?>" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="用户名" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="密码" required>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>

            </form>
        </div>
    </div>
    <script src="__ADMIN__/js/jquery.min.js?v=2.1.4"></script>
    <script src="__ADMIN__/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="__ADMIN__/js/layer_hplus.js"></script>
    <script src="__ADMIN__/plugins/layui/layui.js"></script>
    <script type="text/javascript">
        layui.use('form', function(){
            var form = layui.form(),layer = layui.layer;

            //自定义验证规则
            form.verify({
                username: function(value){
                    if(value.length == 0){
                        return '用户名不能为空';
                    }
                },
                password: [
                    /^[\S]{6,}$/,
                    '密码必须大于6位'
                ]
            });

            form.on('submit', function(data){
                //先获取数据
                var url = $('form').attr('action');
                var data = $('form').serializeArray(); //序列化表单元素
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: data,
                    success: function(obj){
                        if(obj.status == 200){
                            location.href = obj.url;
                        }else{
                            layer.alert(obj.msg);
                        }
                    },
                    error: function(data){
                        layer.alert('登录失败');
                    }
                });
                return false;
            })
        });
    </script>
</body>

</html>
