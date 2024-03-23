<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"E:\phpstudy_pro\WWW\www.tp5.com\public/../application/admin\view\menu\mlist.html";i:1710394840;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>中心考核类型</title>
    <link href="__HOME__/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="__HOME__/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="__HOME__/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">

    <link href="__HOME__/css/animate.min.css" rel="stylesheet">
    <link href="__HOME__/css/layer.css" rel="stylesheet">
    <link href="__HOME__/css/global.css" rel="stylesheet">
    <link href="__HOME__/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <!-- <link href="__HOME__/css/awesome-bootstrap-checkbox.css" rel="stylesheet"> -->

<style>
  html{background-color:#E3E3E3; font-size:14px; color:#000; font-family:Helvetica Neue,Helvetica,PingFang SC,Tahoma,Arial,sans-serif}
  a,a:hover{ text-decoration:none;}
  pre{font-family:Helvetica Neue,Helvetica,PingFang SC,Tahoma,Arial,sans-serif}
  .box{padding:20px; background-color:#fff; margin:50px 100px; border-radius:5px;}
  .box a{padding-right:15px;}
  #about_hide{display:none}
  .layer_text{background-color:#fff; padding:20px;}
  .layer_text p{margin-bottom: 10px; text-indent: 2em; line-height: 23px;}
  .button{display:inline-block; *display:inline; *zoom:1; line-height:30px; padding:0 20px; background-color:#56B4DC; color:#fff; font-size:14px; border-radius:3px; cursor:pointer; font-weight:normal;}
  .photos-demo img{width:200px;}
  thead tr th{text-align: center;}
  tbody tr td{text-align: center;}
  tbody tr #menu{text-align: left;}
  .table>thead>tr>th{line-height: 30px;}
  </style>

</head>
<body class="gray-bg" onload="opener.location.reload()">

<div class="wrapper wrapper-content animated fadeInUp" style="font-size: 13px;padding:15px">
   <div class="ibox float-e-margins">
     <div class="ibox-content">
        <div class="row row-lg">
           <div class="col-sm-12">
                        <!-- Example Events -->
                        <div class="example-wrap">
                            <div class="example">

                                <div class="bootstrap-table">
                                  <div class="fixed-table-toolbar">
                                    <div class="bars pull-left">
                                      <?php if(in_array((菜单新增), is_array($viewMenu)?$viewMenu:explode(',',$viewMenu))): ?>
                                      <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                          <a href='<?php echo url("publicsavemenu"); ?>' class="layui-btn J_menuItem" id="add"><i class="layui-icon">&#xe608;</i> 添加</a>
                                      </div>
                                      <?php endif; ?>
                                    </div>
                                  </div>

                                  <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover  dataTable" id="editable" aria-describedby="editable_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="名称">名称</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="是否菜单">是否菜单</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="模块名称">模块名称</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="控制器名称">控制器名称</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="方法名称">方法名称</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="创建时间">创建时间</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="修改时间">修改时间</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="排序">排序</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="editable" rowspan="1" colspan="1" aria-label="操作" width="9%">操作</th>
                                            </tr>
                                      </thead>
                                      <tbody>
                                          <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                              <tr class="gradeA odd" id="d<?php echo $v['id']; ?>">
                                                <!-- <i class="fa fa-space-shuttle" style="color:#00fbe4"></i> -->
                                                  <td class=" " id="menu"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ',$v["level"]);?><?php echo $v['name']; ?></td>
                                                  <td class=" "><?php echo display($v['is_menu']); ?></td>
                                                  <td class=" "><?php echo $v['module_name']; ?></td>
                                                  <td class=" "><?php echo $v['controller_name']; ?></td>
                                                  <td class=" "><?php echo $v['view_name']; ?></td>
                                                  <td class=" "><?php echo $v['create_time']; ?></td>
                                                  <td class=" "><?php echo $v['update_time']; ?></td>
                                                  <td class=" "><?php echo $v['sort']; ?></td>

                                                  <td class="center " style="height: 20px;">
                                                      <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                                                          <?php if(in_array((菜单修改), is_array($viewMenu)?$viewMenu:explode(',',$viewMenu))): ?>
                                                          <a type="button" class="layui-btn" href="<?php echo url('publicsavemenu'); ?>?id=<?php echo $v['id']; ?>&name=<?php echo $v['name']; ?>&is_menu=<?php echo $v['is_menu']; ?>&module_name=<?php echo $v['module_name']; ?>&controller_name=<?php echo $v['controller_name']; ?>&view_name=<?php echo $v['view_name']; ?>&sort=<?php echo $v['sort']; ?>&parent_id=<?php echo $v['parent_id']; ?>" title="修改" style="height: 24px;line-height: 24px;padding: 0px 8px;"><i class="layui-icon">&#xe642;</i></a>
                                                          <?php endif; if(in_array((菜单删除), is_array($viewMenu)?$viewMenu:explode(',',$viewMenu))): ?>
                                                          <button type="button" class="layui-btn layui-btn-danger" onclick="buttonDel(<?php echo $v['id']; ?>);" title="删除" style="height: 24px;line-height: 24px;padding: 0px 8px;"><i class="layui-icon">&#xe640;</i></button>
                                                          <?php endif; ?>
                                                      </div>
                                                  </td>
                                              </tr>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                      </tbody>
                                 </table>
                                 <div class="row">

                                     <div class="col-sm-6">
                                       <div class="dataTables_paginate paging_simple_numbers" id="editable_paginate">
                                       </div>
                                     </div>
                                 </div>
                               </div>
                          </div>
                          <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- End Example Events -->
                    </div>
        </div>
      </div>
    </div>

</div>
<script src="__HOME__/js/jquery.min.js"></script>
<script src="__JS__/layer.js"></script>
<script src="__HOME__/js/laydate.js"></script>


<script type="text/javascript">
      // 删除
      function buttonDel(id){
        layer.msg('您确定要删除吗？', {
            time: 0 //不自动关闭
            ,btn: ['确认', '取消']
            ,yes: function(index){
                layer.close(index);
                $.ajax({
                    url:'<?php echo url("delMenu"); ?>',
                    data:{id:id},
                    type:'POST',
                    dataType:'json',
                    success:function(data){
                        if(data.status == 'success'){
                            if(data.type == 'array'){
                                layer.msg(data.msg,{icon: 1},function(){
                                  setTimeout(function(){
                                      for(var i=0; i < data.data.length; i++){
                                        $('#d'+data.data[i]).html('');
                                      } 
                                  }, 100);
                                });
                                
                            }else{
                              layer.msg(data.msg,{icon: 1},function(){
                                  setTimeout(function(){
                                      $('#d'+id).html('');
                                  }, 100);
                                });
                            }
                            
                        }else{
                            layer.msg(data.msg,{icon: 2});
                        }

                    },
                    error:function(){
                        layer.msg("请求失败");
                    }
                })
            }
        });
      }
</script>
</body>
</html>
