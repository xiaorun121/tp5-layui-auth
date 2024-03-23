<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"E:\phpstudy_pro\WWW\www.tp5.com/application/admin\view\trace\projectgather.html";i:1708323714;}*/ ?>
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

</head>

<body class="gray-bg">

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
                                        <form action="" method="get">
                                            <div class="columns columns-right btn-group pull-right">
                                                <button class="btn btn-default btn-outline" type="submit" title="搜索"
                                                    style="margin-right: 5px;"><i class="fa fa-search"></i></button>
                                                <button class="btn btn-default btn-outline" type="reset" title="重置"
                                                    onclick="onReset()"><i
                                                        class="glyphicon glyphicon-refresh"></i></button>
                                            </div>

                                            <div class="pull-right search layui-form" style="margin-left: 5px;">
                                                <input type="radio" name="time" value="week" title="周" <?php if($time == 'week'): ?>checked<?php endif; ?>>
                                                <input type="radio" name="time" value="month" title="月" <?php if($time == 'month'): ?>checked<?php endif; ?>>
                                                <input type="radio" name="time" value="year" title="年" <?php if($time == 'year'): ?>checked<?php endif; ?>>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="bootstrap-table">

                                        <?php if(!empty($result)): if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                                        <table class="layui-table" lay-size="sm">
                                            <thead>
                                                <tr>
                                                    <th>名称</th>
                                                    <th>已上架</th>
                                                    <th>审核中</th>
                                                    <th>待审核</th>
                                                    <th>账号禁用</th>
                                                    <th>分配中</th>
                                                    <th>已暂停</th>
                                                    <th>待验证</th>
                                                    <th>已下架</th>
                                                    <th>账号关联</th>
                                                    <th>更新中</th>
                                                    <th>其他</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th><?php echo $v['b_project']; ?></th>
                                                    <th <?php if($v["已上架"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",1)'
                                                        <?php endif; ?>><?php echo $v['已上架']; ?></th>
                                                    <th <?php if($v["审核中"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",2)'
                                                        <?php endif; ?>><?php echo $v['审核中']; ?></th>
                                                    <th <?php if($v["待审核"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",3)'
                                                        <?php endif; ?>><?php echo $v['待审核']; ?></th>
                                                    <th <?php if($v["账号禁用"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",4)'
                                                        <?php endif; ?>><?php echo $v['账号禁用']; ?></th>
                                                    <th <?php if($v["分配中"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",5)'
                                                        <?php endif; ?>><?php echo $v['分配中']; ?></th>
                                                    <th <?php if($v["已暂停"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",6)'
                                                        <?php endif; ?>><?php echo $v['已暂停']; ?></th>
                                                    <th <?php if($v["待验证"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",7)'
                                                        <?php endif; ?>><?php echo $v['待验证']; ?></th>
                                                    <th <?php if($v["已下架"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",8)'
                                                        <?php endif; ?>><?php echo $v['已下架']; ?></th>
                                                    <th <?php if($v["账号关联"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",9)'
                                                        <?php endif; ?>><?php echo $v['账号关联']; ?></th>
                                                    <th <?php if($v["更新中"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",10)'
                                                        <?php endif; ?>><?php echo $v['更新中']; ?></th>
                                                    <th <?php if($v["其他"]> 0): ?> onclick='read("<?php echo $v['b_project']; ?>",11)'
                                                        <?php endif; ?>><?php echo $v['其他']; ?></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                        <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                        <table class="layui-table" lay-size="sm">
                                            <thead>
                                                <tr>
                                                    <th>名称</th>
                                                    <th>已上架</th>
                                                    <th>审核中</th>
                                                    <th>待审核</th>
                                                    <th>账号禁用</th>
                                                    <th>分配中</th>
                                                    <th>已暂停</th>
                                                    <th>待验证</th>
                                                    <th>已下架</th>
                                                    <th>账号关联</th>
                                                    <th>更新中</th>
                                                    <th>其他</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="12" style="text-align: center;">no data</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php endif; ?>
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

            <!-- Bootstrap table -->
            <script src="__ADMIN__/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
            <script src="__ADMIN__/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>

            <script src="__LAYUI__/layui.js" charset="utf-8"></script>

            <script type="text/javascript">

                function read(project,status) {

                    layer.load(2);

                    $.ajax({
                        url: "<?php echo url('showProject'); ?>",
                        data: { b_project: project,status: status },
                        type: 'post',
                        dataType: 'json',
                        success: function (data) {
                            if (data.code == 200) {
                                var index = layer.load(2);
                                layer.close(index);

                                console.log(data.data)

                                var html = '';
                                html += '<table class="table table-striped table-bordered table-hover dataTables-example" id="table">';
                                html += '<tbody>';

                                for (var i = 0; i < data.data.length; i++) {
                                    html += '<tr style="background-color: #fff;">' +
                                        '<td class="project-title" width="10%" style="font-weight: bold;text-align:center;">' + data.data[i]["id"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["app_name"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["package_name"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["main_name"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["class_name"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["k3"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["k4"] + '</td>' +
                                        '<td style="font-weight: bold;font-size: 20px;">' + data.data[i]["b_project"] + '</td>' +
                                        '</tr>';
                                }


                                html += '</tbody>';
                                html += '</table>';

                                layer.open({
                                    type: 1,
                                    title: '数据组数据',
                                    // area: ['80%', '80%'],
                                    area: '80%',
                                    content: html
                                });

                            } else {
                                var index = layer.load(2);
                                layer.close(index);
                                layer.msg('' + data.msg + '', { icon: 5 });
                                return false;
                            }
                        },
                        error: function (err) {
                            var index = layer.load(2);
                            layer.close(index);
                            layer.msg('网络异常', { icon: 5 });
                            return false;
                        }
                    })
                }

                // 重置
                function onReset() {
                    layer.load(2);
                    location.href = "<?php echo url('projectgather'); ?>";
                }

                layui.use(['form', 'layer', 'layedit', 'laydate'], function () {
                    //得到各种内置组件
                    var layer = layui.layer //弹层
                        , form = layui.form
                        , laydate = layui.laydate
                        , element = layui.element; //元素操作;

                });
            </script>
</body>

</html>