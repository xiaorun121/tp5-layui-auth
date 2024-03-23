<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\index\index.html";i:1703489623;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>畅恒互娱</title>
    <meta name="keywords" content="畅恒互娱">
    <meta name="description" content="畅恒互娱">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico">
    <link href="__ADMIN__/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="__ADMIN__/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="__ADMIN__/css/animate.min.css" rel="stylesheet">
    <link href="__ADMIN__/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="__ADMIN__/img/img.gif" style="border-radius: 0%;width:35px"/></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"> <strong class="font-bold"><?php echo session('user.nickname'); ?></strong></span>
                            </a>
                        </div>
                    </li>



                    <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $k = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                        <li class="menu">
                            <a href="#">
                                <i class="fa <?php echo $menu_icon[$k]; ?>"></i>
                                <span class="nav-label"><?php echo $v['name']; ?> </span>
                                <span class="fa arrow"></span>
                            </a>
                            <?php if(is_array($v['children']) || $v['children'] instanceof \think\Collection || $v['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['child']): ?>
                                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                        <li class="">
                                            <a href="#"><?php echo $vo['name']; ?> <span class="fa arrow"></span></a>
                                            <ul class="nav nav-third-level collapse" aria-expanded="false" style="height: 0px;">
                                                <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?>
                                                    <li><a class="J_menuItem" href="/<?php echo $vv['module_name']; ?>/<?php echo $vv['controller_name']; ?>/<?php echo $vv['view_name']; ?>" data-index="<?php echo $vv['id']; ?>"><?php echo $vv['name']; ?></a></li>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </ul>
                                      </li>
                                    </ul>
                                  <?php else: ?>
                                  <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                      <li><a class="J_menuItem" href="/<?php echo $vo['module_name']; ?>/<?php echo $vo['controller_name']; ?>/<?php echo $vo['view_name']; ?>" data-index="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></a></li>
                                  </ul>
                                  <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown hidden-xs">
                            <a class="right-sidebar-toggle J_menuItem" href="<?php echo url('login/updpassword'); ?>" data-index="0">
                                <i class="fa fa-expeditedssl"></i> 修改密码
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row content-tabs">
                <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                    </button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="J_tabShowActive"><a>定位当前选项卡</a>
                        </li>
                        <li class="divider"></li>
                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                        </li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                        </li>
                    </ul>
                </div>
                <a href="<?php echo url('login/logout'); ?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
            </div>
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php echo url('content'); ?>" frameborder="0" data-id="index_v1.html" seamless></iframe>
            </div>
            <div class="footer">
                <div class="pull-right">
                    <?php echo $website['copyright']; ?>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
    </div>
    <script src="__ADMIN__/js/jquery.min.js?v=2.1.4"></script>
    <script src="__ADMIN__/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="__ADMIN__/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="__ADMIN__/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="__ADMIN__/js/plugins/layer/layer.min.js"></script>
    <script src="__ADMIN__/js/hplus.min.js?v=4.1.0"></script>
    <script src="__ADMIN__/js/contabs.min.js" type="text/javascript"></script>
    <script src="__ADMIN__/js/plugins/pace/pace.min.js"></script>
</body>

</html>
