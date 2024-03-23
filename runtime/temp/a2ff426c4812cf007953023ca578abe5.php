<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\logs\logslist.html";i:1700111166;}*/ ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 项目</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="__ADMIN__/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__ADMIN__/css/font-awesome.min93e3.css" rel="stylesheet">

    <link href="__ADMIN__/css/animate.min.css" rel="stylesheet">
    <link href="__ADMIN__/css/style.min.css?v=4.1.0" rel="stylesheet">
    <style>
        
    </style>

</head>

<body class="gray-bg">

    <div class="wrapper wrapper-content animated fadeInUp">
        <div class="row">
            <div class="col-sm-12">

                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            <form action="<?php echo url('logsList'); ?>" method="get" >
                            <div class="col-md-11">
                                <div class="input-group">
                                    <!-- <input type="text" placeholder="请输入用户名" class="input-sm form-control" name="username"> -->
                                    <div class="col-sm-3" style="float: right;">
                                        <select class="form-control m-b" name="user_id">
                                            <option>请选择用户</option>
                                            <?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo $v['id']; ?>"><?php echo $v['nickname']; ?></option>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div>
                                    <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                            </form>
                        </div>

                        <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                    <?php if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                        <tr>
                                            <td class="project-status">
                                                <?php echo getUserRoleInfo($v['user_id'])[0]['nickname']; ?>
                                            </td>
                                            <td class="project-title">
                                                <span  class='btn 
                                                    <?php switch($v['title']): case "更新状态":case "更新HTTPS 启用状态":case "更新域名验证":case "更新类型": ?>btn-warning<?php break; case "切换跳转开关": ?>btn-success<?php break; case "删除数据":case "删除图片": ?>btn-danger<?php break; default: ?>
                                                        btn-primary
                                                    <?php endswitch; ?>
                                                '><?php echo $v['title']; ?></span>
                                                <br/>
                                                <br/>
                                                <small><i class="fa fa-clock-o"></i> <?php echo $v['create_time']; ?></small>
                                            </td>
             
                                            <td class="project-completion" style="width: 70%;">
                                                <?php switch($v['title']): case "新增数据":case "更新数据": ?><pre style=""><code><?php echo htmlspecialchars($v['content']); ?></code></pre><?php break; default: ?>
                                                    <?php echo $v['content']; endswitch; ?>
                                                   
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                    
                                    </tbody>
                                    
                                </table>
                                
                            </div>
                            <div class="row">

                                <div class="col-sm-6">
                                  <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                    <?php echo $result->render(); ?>
                                  </div>
                                </div>
                              </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    <!-- 全局js -->
    <script src="__ADMIN__/js/jquery.min.js?v=2.1.4"></script>
    <script src="__ADMIN__/js/bootstrap.min.js?v=3.3.6"></script>


    <!-- 自定义js -->
    <script src="__ADMIN__/js/content.js?v=1.0.0"></script>


    <script>
        $(document).ready(function(){

            $('#loading-example-btn').click(function () {
                btn = $(this);
                simpleLoad(btn, true)

                // Ajax example
//                $.ajax().always(function () {
//                    simpleLoad($(this), false)
//                });

                simpleLoad(btn, false)
            });
        });

        function simpleLoad(btn, state) {
            if (state) {
                btn.children().addClass('fa-spin');
                btn.contents().last().replaceWith(" Loading");

                location.href = "<?php echo url('logsList'); ?>";
            } else {
                setTimeout(function () {
                    btn.children().removeClass('fa-spin');
                    btn.contents().last().replaceWith(" Refresh");
                }, 2000);
            }
        }
    </script>

    

    </body>
</html>
