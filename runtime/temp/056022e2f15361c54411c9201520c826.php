<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\trace\tracelistymd.html";i:1706943724;}*/ ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>APP 数据跟踪</title>
  <link rel="stylesheet" href="__LAYUI__/css/layui.css" media="all">
  <link rel="stylesheet" href="__LAYUI__/tab/layui.css?t=1619028572570" media="all">
  <link href="__HOME__/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
  <link href="__HOME__/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
  <link href="__HOME__/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">

  <link href="__HOME__/css/animate.min.css" rel="stylesheet">
  <link href="__HOME__/css/layer.css" rel="stylesheet">
  <link href="__HOME__/css/global.css" rel="stylesheet">
  <link href="__HOME__/css/style.min862f.css?v=4.1.0" rel="stylesheet">



  <!-- <link href="__HOME__/css/awesome-bootstrap-checkbox.css" rel="stylesheet"> -->

  <style>
    
    .bootstrap-table .table>thead>tr>th{
      vertical-align: middle;
    }
    .layui-input{
      height: 35px;
    }
    .th-inner {
      text-align: center;
    }
    .layui-anim{
      z-index: 999 !important;
    }
  </style>

</head>

<body class="gray-bg" onload="opener.location.reload()">

  <div class="wrapper wrapper-content animated fadeInUp" style="font-size: 13px;padding:15px">
    <div class="ibox float-e-margins">
      <div class="ibox-content">
        <div class="row row-lg">
          <div class="col-sm-12">
            <!-- Example Events -->
            <div class="example-wrap" >
              <div class="example">

                <div class="bootstrap-table">
                  <div class="fixed-table-toolbar">
                    <form action="<?php echo url('traceListYmd'); ?>" method="get">
                      <div class="columns columns-right btn-group pull-right">
                        <button class="btn btn-default btn-outline" type="submit" title="搜索" style="margin-right: 5px;"><i
                            class="fa fa-search"></i></button>
                        <button class="btn btn-default btn-outline" type="reset" title="重置" onclick="onReset()"><i
                              class="glyphicon glyphicon-refresh"></i></button>
                      </div>
                      
                      <div class="pull-right  layui-form">
                        <div class="layui-inline" >
                          <div class="layui-input-block">
                              <div class="layui-inline" style="width: 100px;margin-top: 10px;">
                                  <select name="down_reason" id="down_reason" >
                                      <option value="0" aria-readonly="true" disabled="disabled" <?php if(!$down_reason): ?>selected<?php endif; ?>>下架原因</option>
                                      <option value="高危代码" <?php if($down_reason == '高危代码'): ?>selected<?php endif; ?>>高危代码</option>
                                      <option value="账号关联" <?php if($down_reason == '账号关联'): ?>selected<?php endif; ?>>账号关联</option>
                                      <option value="仿冒侵权" <?php if($down_reason == '仿冒侵权'): ?>selected<?php endif; ?>>仿冒侵权</option>
                                  </select>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="pull-right layui-form"  style="margin-right: -106px;">
                        <div class="layui-inline" >
                          <div class="layui-input-block">
                              <div class="layui-inline" style="width: 100px;margin-top: 10px;">
                                  <select name="publish_id" id="publish_id" >
                                      <option value="0" aria-readonly="true" disabled="disabled" <?php if(!$publish_id): ?>selected<?php endif; ?>>提包人</option>
                                      <?php if(is_array($userInfo) || $userInfo instanceof \think\Collection || $userInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>" <?php if($vo['id'] == $publish_id): ?>selected<?php else: endif; ?>><?php echo $vo['nickname']; ?></option>
                                      <?php endforeach; endif; else: echo "" ;endif; ?>
                                  </select>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="pull-right  layui-form" style="margin-right: -106px;">
                        <div class="layui-inline" >
                          <div class="layui-input-block">
                              <div class="layui-inline" style="width: 100px;margin-top: 10px;">
                                  <select name="down_time" id="down_time" >
                                      <option value="0" aria-readonly="true" disabled="disabled" <?php if(!$down_time): ?>selected<?php endif; ?>>下架日期</option>
                                      <option value="1" <?php if($down_time == 1): ?>selected<?php endif; ?>>周</option>
                                      <option value="2" <?php if($down_time == 2): ?>selected<?php endif; ?>>月</option>
                                      <option value="3" <?php if($down_time == 3): ?>selected<?php endif; ?>>年</option>
                                  </select>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="pull-right  layui-form" style="margin-right: -106px;">
                        <div class="layui-inline" >
                          <div class="layui-input-block">
                              <div class="layui-inline" style="width: 100px;margin-top: 10px;">
                                  <select name="up_time" id="up_time" >
                                      <option value="0" aria-readonly="true" disabled="disabled" <?php if(!$up_time): ?>selected<?php endif; ?>>上架日期</option>
                                      <option value="1" <?php if($up_time == 1): ?>selected<?php endif; ?>>周</option>
                                      <option value="2" <?php if($up_time == 2): ?>selected<?php endif; ?>>月</option>
                                      <option value="3" <?php if($up_time == 3): ?>selected<?php endif; ?>>年</option>
                                  </select>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="pull-right  layui-form" style="margin-right: -106px;">
                        <div class="layui-inline" >
                          <div class="layui-input-block">
                              <div class="layui-inline" style="width: 100px;margin-top: 10px;">
                                  <select name="bag_time" id="bag_time" >
                                      <option value="0" aria-readonly="true" disabled="disabled" <?php if(!$bag_time): ?>selected<?php endif; ?>>提包日期</option>
                                      <option value="1" <?php if($bag_time == 1): ?>selected<?php endif; ?>>周</option>
                                      <option value="2" <?php if($bag_time == 2): ?>selected<?php endif; ?>>月</option>
                                      <option value="3" <?php if($bag_time == 3): ?>selected<?php endif; ?>>年</option>
                                  </select>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="pull-right  layui-form" style="margin-right: -106px;margin-top: 10px">
                        <div class="layui-inline" >
                          <div class="layui-input-block">
                              <div class="layui-inline" style="width: 120px;">
                                  <select name="b_project" id="b_project">
                                      <option value="" aria-readonly="true" disabled="disabled" <?php if(!$bProject): ?>selected<?php endif; ?>>跳转项目组</option>
                                      <?php if(is_array($bProject) || $bProject instanceof \think\Collection || $bProject instanceof \think\Paginator): $i = 0; $__LIST__ = $bProject;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['b_project']; ?>" <?php if($b_project == $vo['b_project']): ?>selected <?php endif; ?> ><?php echo $vo['b_project']; ?></option>
                                      <?php endforeach; endif; else: echo "" ;endif; ?>
                                      
                                  </select>
                              </div>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="pull-right search" style="margin-right: -106px;width: 120px;">
                        <input class="form-control input-outline" type="text" name="monthInput"
                          value="<?php if($monthInput): ?><?php echo $monthInput; endif; ?>" placeholder="月" id="month">
                      </div>

                      <div class="pull-right search" style="margin-right: 4px;width: 120px;">
                        <input class="form-control input-outline" type="text" name="yearInput"
                          value="<?php if($yearInput): ?><?php echo $yearInput; endif; ?>" placeholder="年" id="year">
                          
                      </div> -->

                      <div class="pull-left layui-form" style="margin-left: 10px;width: 150px;margin-top: 10px">
                        <a type="button" class="layui-btn layui-btn-danger" style="height: 24px;line-height: 24px;padding: 0px 8px;">总数： <?php echo $count; ?>条</a>
                      </div>
                    </form>
                  </div>

                <div class="bootstrap-table" style="height: 90%;
                width: 100%;
                position: relative;
                overflow: auto;">
                  <div class="fixed-table-toolbar" style="width:max-content;height: 100%;">
                    <div class="fixed-table-container" style="height: 100%; padding-bottom: 37px;">

                      <!-- <div class="fixed-table-body"> -->
                      <table id="exampleTableLargeColumns" data-show-columns="true" data-height="400"
                          data-mobile-responsive="true" class="table table-hover">
                          <thead>
                              <tr>
                                  <th style="width: 1%;position: sticky;top: 0;left: 0;z-index: 999999999;background: #f5f5f5;" data-field="序号" tabindex="0">
                                      <div class="th-inner ">序号</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="position: sticky;left: 150px;top: 0;z-index: 999999999;background: #f5f5f5;width: 7%;" data-field="应用名" tabindex="0">
                                      <div class="th-inner ">应用名</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="状态" tabindex="0">
                                      <div class="th-inner ">状态</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="包名" tabindex="0">
                                    <div class="th-inner ">包名</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="域名地址" tabindex="0">
                                    <div class="th-inner ">域名地址</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="跳转开关" tabindex="0">
                                    <div class="th-inner ">跳转开关</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <?php if($role_id == 1): ?>
                                <th style="" data-field="跳转地址" tabindex="0">
                                  <div class="th-inner ">跳转地址</div>
                                  <div class="fht-cell"></div>
                                </th>
                                <?php endif; ?> 
                                <th style="" data-field="跳转项目组" tabindex="0">
                                  <div class="th-inner ">跳转项目组</div>
                                  <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="跳转次数" tabindex="0">
                                  <div class="th-inner ">跳转次数</div>
                                  <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="提包服务器" tabindex="0">
                                    <div class="th-inner ">提包服务器</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="Sha1" tabindex="0">
                                    <div class="th-inner ">Sha1</div>
                                    <div class="fht-cell"></div>
                                  </th>                   
                                  <th style="" data-field="功能" tabindex="0">
                                      <div class="th-inner ">功能</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="类型" tabindex="0">
                                      <div class="th-inner ">类型</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="GOOGLE SEARCH 状态" tabindex="0">
                                    <div class="th-inner ">域名验证</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="HTTPS 启用状态" tabindex="0">
                                    <div class="th-inner ">HTTPS 启用状态</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="图片" tabindex="0">
                                    <div class="th-inner ">图片</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="讨论组id" tabindex="0">
                                    <div class="th-inner ">讨论组id</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="热更新开关" tabindex="0">
                                    <div class="th-inner ">热更新开关</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="热更新地址" tabindex="0">
                                    <div class="th-inner ">热更新地址</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="包" tabindex="0">
                                      <div class="th-inner ">包</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="谷歌邮箱" tabindex="0">
                                      <div class="th-inner ">谷歌邮箱</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="谷歌邮箱密码" tabindex="0">
                                    <div class="th-inner ">谷歌邮箱密码</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="谷歌辅助邮箱" tabindex="0">
                                    <div class="th-inner ">谷歌辅助邮箱</div>
                                    <div class="fht-cell"></div>
                                  </th>

                                  <th style="" data-field="接口服务器" tabindex="0">
                                    <div class="th-inner ">接口服务器</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="服务器用户名" tabindex="0">
                                    <div class="th-inner ">服务器用户名</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="服务器密码" tabindex="0">
                                      <div class="th-inner ">服务器密码</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="AFdev" tabindex="0">
                                    <div class="th-inner ">AFdev</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="AF账号" tabindex="0">
                                    <div class="th-inner ">AF账号</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="身份验证" tabindex="0">
                                      <div class="th-inner ">身份验证</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="提包日期" tabindex="0">
                                      <div class="th-inner ">提包日期</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="被封原因" tabindex="0">
                                      <div class="th-inner ">被封原因</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="Google Play链接" tabindex="0">
                                      <div class="th-inner ">Google Play链接</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="IP查询TOKEN" tabindex="0">
                                    <div class="th-inner ">IP查询TOKEN</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="k3/Adtoken" tabindex="0">
                                    <div class="th-inner ">k3/Adtoken</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="K4/AdRegToken" tabindex="0">
                                    <div class="th-inner ">K4/AdRegToken</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="数字签名" tabindex="0">
                                      <div class="th-inner ">数字签名</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="主类名" tabindex="0">
                                      <div class="th-inner ">主类名</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="隐私协议地址" tabindex="0">
                                      <div class="th-inner ">隐私协议地址</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="上架日期" tabindex="0">
                                      <div class="th-inner ">上架日期</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <!-- <th style="" data-field="更新原因" tabindex="0">
                                    <div class="th-inner ">更新原因</div>
                                    <div class="fht-cell"></div>
                                  </th> -->
                                  <th style="" data-field="更新批次" tabindex="0">
                                    <div class="th-inner ">更新批次</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="下架日期" tabindex="0">
                                    <div class="th-inner ">下架日期</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="下架原因" tabindex="0">
                                    <div class="th-inner ">下架原因</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="录入时间" tabindex="0">
                                    <div class="th-inner ">录入时间</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="发布时间" tabindex="0">
                                      <div class="th-inner ">发布时间</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="更新时间" tabindex="0">
                                      <div class="th-inner ">更新时间</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="发布人员" tabindex="0">
                                    <div class="th-inner ">发布人员</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="测试人员" tabindex="0">
                                    <div class="th-inner ">测试人员</div>
                                    <div class="fht-cell"></div>
                                  </th>
                                  <th style="" data-field="测试时间" tabindex="0">
                                      <div class="th-inner ">测试时间</div>
                                      <div class="fht-cell"></div>
                                  </th>
                                  
                              </tr>
                          </thead>						  
                          <tbody>
                              <?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $k = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                              <tr data-index="<?php echo $v['id']; ?>" id="d<?php echo $v['id']; ?>">
                                <td class=" " id="menu" title="<?php echo $v['id']; ?>" style="width: 3%;text-align: center;position: sticky;left: 0;z-index: 999999999;background: #f5f5f5;" ><?php echo $v['id']; ?></td>
                                <td class=" " title="<?php echo $v['app_name']; ?>" style="position: sticky;left: 150px;top: 0;z-index: 999999999;background: #f5f5f5;"><?php echo $v['app_name']; ?></td>
                                <td class="layui-form ">
                                  <div class="layui-input-block" style="margin-left: 0px !important;">
                                    <div class="layui-inline" style="width:100px;">
                                      <select name="status" lay-filter="status" id="<?php echo $v['id']; ?>">
                                        <option value="1" <?php if($v['status'] == 1): ?>selected<?php endif; ?>>已上架</option>
                                        <option value="2" <?php if($v['status'] == 2): ?>selected<?php endif; ?>>审核中</option>
                                        <option value="3" <?php if($v['status'] == 3): ?>selected<?php endif; ?>>待审核</option>
                                        <option value="4" <?php if($v['status'] == 4): ?>selected<?php endif; ?>>账号禁用</option>
                                        <option value="5" <?php if($v['status'] == 5): ?>selected<?php endif; ?>>分配中</option>
                                        <option value="6" <?php if($v['status'] == 6): ?>selected<?php endif; ?>>已暂停</option>
                                        <option value="7" <?php if($v['status'] == 7): ?>selected<?php endif; ?>>待验证</option>
                                        <option value="8" <?php if($v['status'] == 8): ?>selected<?php endif; ?>>已下架</option>
                                        <option value="9" <?php if($v['status'] == 9): ?>selected<?php endif; ?>>账号关联</option>
                                        <option value="10" <?php if($v['status'] == 10): ?>selected<?php endif; ?>>更新中</option>
                                        <option value="11" <?php if($v['status'] == 11): ?>selected<?php endif; ?>>其他</option>
                                      </select>
                                    </div>
                                  </div>
                                </td>
                                <td class=" " title="<?php echo $v['package_name']; ?>" style="width: max-content;"><?php echo $v['package_name']; ?></td>
                                <td class=" " title="<?php echo $v['domain_url']; ?>"><?php echo $v['domain_url']; ?></td>
                                <td class="layui-form ">
                                  <div class="layui-inline">
                                    <div class="layui-input-block" style="margin-left: 0px !important;">
                                      <input type="checkbox" <?php if($v['jump_switch'] == 'on'): ?>checked<?php endif; ?> id="<?php echo $v['id']; ?>"
                                        name="jump_switch" lay-skin="switch" lay-filter="jump_switch" lay-text="ON|OFF">
                                    </div>
                                  </div>
                                </td>
                                <?php if($role_id == 1): ?>
                                <td class=" " title="<?php echo $v['jump_url']; ?>"><?php echo $v['jump_url']; ?></td>
                                <?php endif; ?> 
                                <td class=" " title="<?php echo $v['b_project']; ?>"><?php echo $v['b_project']; ?></td>    
                                <td class=" " title="<?php echo $v['jump_url']; ?>"><?php echo $v['jump_count']; ?></td>
                                <td class=" " title="<?php echo $v['bag_vps']; ?>"><?php echo $v['bag_vps']; ?></td>                
                                <td class=" " title="<?php echo $v['sha1']; ?>"><?php echo $v['sha1']; ?></td>                
                                <td class=" " title="<?php echo $v['app_function']; ?>"><?php echo $v['app_function']; ?></td>
                                <td class="layui-form ">
                                  <div class="layui-input-block" style="margin-left: 0px !important;">
                                    <div class="layui-inline" style="width:95px;">
                                      <select name="app_type" lay-filter="app_type" id="<?php echo $v['id']; ?>">
                                        <option value="1" <?php if($v['app_type'] == 1): ?>selected<?php endif; ?>>H5</option>
                                        <option value="2" <?php if($v['app_type'] == 2): ?>selected<?php endif; ?>>原生</option>
                                        <option value="3" <?php if($v['app_type'] == 3): ?>selected<?php endif; ?>>UNIAPP</option>
                                        <option value="4" <?php if($v['app_type'] == 4): ?>selected<?php endif; ?>>H5+TP</option>
                                        <option value="6" <?php if($v['app_type'] == 6): ?>selected<?php endif; ?>>Unity</option>
                                        <option value="7" <?php if($v['app_type'] == 7): ?>selected<?php endif; ?>>Cocos</option>
                                        <option value="5" <?php if($v['app_type'] == 5): ?>selected<?php endif; ?>>IOS</option>
                                      </select>
                                    </div>
                                  </div>
                                </td>
                                <td class="layui-form ">
                                  <div class="layui-input-block" style="margin-left: 0px !important;">
                                    <div class="layui-inline" style="width:120px;">
                                      <select name="google_sharch_status" lay-filter="google_sharch_status" id="<?php echo $v['id']; ?>">
                                        <option value="1" <?php if($v['google_sharch_status'] == 1): ?>selected<?php endif; ?>>已验证</option>
                                        <option value="0" <?php if($v['google_sharch_status'] == 0): ?>selected<?php endif; ?>>未验证</option>
                                      </select>
                                    </div>
                                  </div>
                                </td>
                                <td class="layui-form ">
                                  <div class="layui-input-block" style="margin-left: 0px !important;">
                                    <div class="layui-inline" style="width:95px;">
                                      <select name="https_status" lay-filter="https_status" id="<?php echo $v['id']; ?>">
                                        <option value="1" <?php if($v['https_status'] == 1): ?>selected<?php endif; ?>>已启用</option>
                                        <option value="0" <?php if($v['https_status'] == 0): ?>selected<?php endif; ?>>未启用</option>
                                      </select>
                                    </div>
                                  </div>
                                </td>
                                <td class=" " title="<?php echo $v['image']; ?>" id="image<?php echo $v['id']; ?>"><?php if($v['image']): ?><img src="__UPLOADS__/<?php echo $v['image']; ?>" style="width: 200px;height: 100px;"  onclick='image("<?php echo $v['image']; ?>")'/><?php endif; if($v['image']): ?><span style="position: absolute;margin-left: -16px;color: #ea6504;font-size: 20px;line-height: 12px;border-radius: 20px;" onclick="delImage(<?php echo $v['id']; ?>,'<?php echo $v['image']; ?>')"><i class="fa fa-remove"></i></span><?php endif; ?></td>
                                <td class=" " title="<?php echo $v['tele_chatid']; ?>"><?php echo $v['tele_chatid']; ?></td>
                                <td class="layui-form ">
                                  <div class="layui-inline">
                                    <div class="layui-input-block" style="margin-left: 0px !important;">
                                      <input type="checkbox" <?php if($v['update_switch'] == 'on'): ?>checked<?php endif; ?> id="<?php echo $v['id']; ?>"
                                        name="update_switch" lay-skin="switch" lay-filter="update_switch" lay-text="ON|OFF">
                                    </div>
                                  </div>
                                </td>
                                <td class=" " title="<?php echo $v['app_package']; ?>"><?php echo $v['update_url']; ?></td>
                                <td class=" " title="<?php echo $v['app_package']; ?>"><?php echo $v['app_package']; ?></td>
                                <td class=" " title="<?php echo $v['app_gmail']; ?>"><?php echo $v['app_gmail']; ?></td>
                                <td class=" " title="<?php echo $v['google_email_password']; ?>"><?php echo $v['google_email_password']; ?></td>
                                <td class=" " title="<?php echo $v['google_assist_email']; ?>"><?php echo $v['google_assist_email']; ?></td>
                                <td class=" " title="<?php echo $v['api_vps']; ?>"><?php echo $v['api_vps']; ?></td>
                                <td class=" " title="<?php echo $v['vps_username']; ?>"><?php echo $v['vps_username']; ?></td>
                                <td class=" " title="<?php echo $v['vps_password']; ?>"><?php echo $v['vps_password']; ?></td>
                                <td class=" " title="<?php echo $v['afdev']; ?>"><?php echo $v['afdev']; ?></td>
                                <td class=" " title="<?php echo $v['afaccount']; ?>"><?php echo $v['afaccount']; ?></td>
                                <td class=" " title="<?php echo $v['google_auth']; ?>"><?php echo $v['google_auth']; ?></td>
                                <td class=" " title="<?php echo $v['bag_time']; ?>"><?php echo $v['bag_time']; ?></td>
                                <td class=" " title="<?php echo $v['blocked_cause']; ?>"><?php echo $v['blocked_cause']; ?></td>
                                <td class=" " title="<?php echo $v['google_play_link']; ?>"><?php echo $v['google_play_link']; ?></td>
                                <td class=" " title="<?php echo $v['spare_code']; ?>"><?php echo $v['spare_code']; ?></td>
                                <td class=" " title="<?php echo $v['k3']; ?>"><?php echo $v['k3']; ?></td>
                                <td class=" " title="<?php echo $v['k4']; ?>"><?php echo $v['k4']; ?></td>
                                <td class=" " title="<?php echo $v['signature']; ?>"><?php echo $v['signature']; ?></td>
                                <td class=" " title="<?php echo $v['main_name']; ?>" style="width: max-content;"><?php echo $v['main_name']; ?></td>
                                <td class=" " title="<?php echo $v['privacy_agreement_url']; ?>"><?php echo $v['privacy_agreement_url']; ?></td>
                                <td class=" " title="<?php echo $v['up_time']; ?>"><?php echo $v['up_time']; ?></td>
                                <!-- <td class=" " title="<?php echo $v['update_reason']; ?>"><?php echo $v['update_reason']; ?></td> -->
                                <td class=" " title="<?php echo $v['update_batch']; ?>" style="text-align: center;" onclick="read(<?php echo $v['id']; ?>)"><?php if(getAppTraceUpdate($v['id']) > 0): ?><a href="#" style="color: #5FB878;font-weight: 800;font-size: 18px;"><?php endif; ?><?php echo getAppTraceUpdate($v['id']); ?></td>
                                <td class=" " title="<?php echo $v['down_time']; ?>"><?php echo $v['down_time']; ?></td>
                                <td class=" " title="<?php echo $v['down_reason']; ?>"><?php echo $v['down_reason']; ?></td>
                                <td class=" " title=""><?php echo $v['enter_time']; ?></td>
                                <td class=" " title=""><?php echo $v['create_time']; ?></td>
                                <td class=" " title=""><?php echo $v['update_time']; ?></td>
                                <td class="layui-form " title="">
                                <div class="layui-input-block" style="margin-left: 0px !important;">
                                    <div class="layui-inline" style="width:95px;">
                                      <select name="publish_id" lay-filter="publish_id" id="<?php echo $v['id']; ?>">
                                        <?php if(!$v['publish_id']): ?>
                                          <option value="0" selected>请选择</option>
                                        <?php endif; if(is_array($userInfo) || $userInfo instanceof \think\Collection || $userInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                          <option value="<?php echo $vo['id']; ?>" <?php if($vo['id'] == $v['publish_id']): ?>selected<?php else: endif; ?>><?php echo $vo['nickname']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                      </select>
                                    </div>
                                  </div>
                                </td>
                                <td class=" " title=""><?php echo getUserRoleInfo($v['test_id'])[0]['nickname']; ?></td>
                                <td class=" " title=""><?php echo $v['test_time']; ?></td>
      
                                
                              </tr>
                              <?php endforeach; endif; else: echo "" ;endif; ?>
                          </tbody>
                      </table>
                      
                  </div>
              </div>
                <div class="clearfix"></div>
              </div>
              <div class="row">

                <div class="col-sm-6">
                  <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                    <?php echo $info->render(); ?>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Example Events -->
          </div>
        </div>
      </div>
    </div>

  </div>
  <script src="__HOME__/js/jquery.min.js"></script>
  <!-- 全局js -->
  <script src="__ADMIN__/js/bootstrap.min.js?v=3.3.6"></script>

  <!-- 自定义js -->


  <!-- Bootstrap table -->
  <script src="__ADMIN__/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
  <script src="__ADMIN__/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>

  <!-- Peity -->
  <!-- <script src="__ADMIN__/js/demo/bootstrap-table-demo.min_copy.js"></script> -->


  <script src="__JS__/layer.js"></script>

  <script src="__LAYUI__/layui.js" charset="utf-8"></script>
  <script src="__LAYUI__/layer_hplus.js" charset="utf-8"></script>


  <script type="text/javascript">

    function image(url){

      layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                area: '716px',
                skin: 'layui-layer-nobg',
                shadeClose: true,
                content: '<img style="display: inline-block; width: 100%; height: 100%;" src="__UPLOADS__/' + url + '">'
            });
    }

    function read(id){

      layer.load(2);

      $.ajax({
          url:"<?php echo url('showAppTraceUpdate'); ?>",
          data:{id:id},
          type:'post',
          dataType:'json',
          success:function(data){
              if(data.code == 200){
                  var index = layer.load(2);
                  layer.close(index);

                  console.log(data.data)

                  var html = '';
                  html += '<table class="table table-striped table-bordered table-hover dataTables-example" id="table">';
                  html += '<tbody>';

                  for(var i = 0; i < data.data.length; i++){
                    html += '<tr style="background-color: #fff;">'+
                          '<td class="project-title" width="10%" style="font-weight: bold;text-align:center;">'+data.data[i]["update_batch"]+'</td>'+
                          '<td style="font-weight: bold;font-size: 20px;">'+data.data[i]["update_reason"]+'</td>'+
                      '</tr>';
                  }


                  html += '</tbody>';
                  html += '</table>';

                  layer.open({
                          type: 1, 
                          title: '更新原因',
                          // area: ['80%', '80%'],
                          area: '40%',
                          content: html 
                    }); 
                      
              }else{
                  var index = layer.load(2);
                  layer.close(index);
                  layer.msg(''+data.msg+'',{icon: 5});
                  return false;
              }
          },
          error:function(err){
              var index = layer.load(2);
              layer.close(index);
              layer.msg('网络异常',{icon: 5});
              return false;
          }
      })
    }

    // 重置
    function onReset(){
      layer.load(2);
      location.href = "<?php echo url('traceListYmd'); ?>";
    }

    layui.use(['form', 'layer', 'layedit', 'laydate'], function () {
      //得到各种内置组件
      var layer = layui.layer //弹层
        , form = layui.form
        , laydate = layui.laydate
        , element = layui.element; //元素操作;

      // 提包日期
      laydate.render({
        elem: '#year'
        , format:'yyyy'
        ,type: 'year'
      });


      // 提包日期
      laydate.render({
        elem: '#month'
        , format:'MM'
        ,type: 'month'
      });
      

    });
  </script>
</body>

</html>