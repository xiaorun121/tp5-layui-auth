<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"E:\phpstudy_pro\WWW\www.tp5.com\public/../application/admin\view\index\content.html";i:1710394830;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--360浏览器优先以webkit内核解析-->
    <title>武汉畅恒互娱</title>
    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="__ADMIN__/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="__ADMIN__/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="__ADMIN__/css/animate.min.css" rel="stylesheet">
    <link href="__ADMIN__/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <script src="__ADMIN__/echarts/echarts.min.js" ></script>
</head>

<body class="gray-bg" style="background-color: #fff;">

    <div class="row  border-bottom white-bg dashboard-header">
        
        <div class="col-sm-6">
            <div id="main"  style="height: 50%;width:100%;min-height:400px;"></div>
        </div>
        <div class="col-sm-6">
            <div id="main1"  style="height: 50%;width:100%;min-height:400px;"></div>
        </div>
    </div>
    <div class="row  border-bottom white-bg dashboard-header">
        
        <div class="col-sm-12">
            <div id="mains"  style="height: 100%;width:100%;min-height:400px;"></div>
        </div>
    </div>

    <!-- 当年数据 -->
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('mains'));
 
        // 指定图表的配置项和数据
        var option = {
            color: ['#ff0000','#00ff00', '#0000ff', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
            title: {
                // text: '当天数据'
            },
            tooltip: {},
            legend: {
                data:['当年']
            },
            xAxis: {
                data: [<?php echo $arrField; ?>]
            },
            yAxis: {},
            series: [{
                name: '当年',
                type: 'bar',
                data: [<?php echo $arrY; ?>]
            }],
        };
 
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
    <!-- 当天数据 -->
    <script type="text/javascript">
        var res = <?php echo $yearMouthDayResult; ?>;
        // 基于准备好的dom，初始化ECharts实例
        var myCharts = echarts.init(document.getElementById('main'));
        var apps = {};
        options = null;
        // 指定图表的配置项和数据
        var options = {
            title : {
                text: '当天',
                x: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x:'right',
                y:'center',
                textStyle: {
                    color: 'yello'          // 图例文字颜色
                }
            },
            series : [
                {
                    name: '数据状态',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:res,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        apps.currentIndex = -1;

        setInterval(function () {
            var dataLen = options.series[0].data.length;
            // 取消之前高亮的图形
            myCharts.dispatchAction({
                type: 'downplay',
                seriesIndex: 0,
                dataIndex: apps.currentIndex
            });
            apps.currentIndex = (apps.currentIndex + 1) % dataLen;
            // 高亮当前图形
            myCharts.dispatchAction({
                type: 'highlight',
                seriesIndex: 0,
                dataIndex: apps.currentIndex
            });
            // 显示 tooltip
            myCharts.dispatchAction({
                type: 'showTip',
                seriesIndex: 0,
                dataIndex: apps.currentIndex
            });
        }, 1000);
        if (options && typeof options === "object") {
            myCharts.setOption(options, true);
        }
    </script>
    <!-- 当月数据 -->
    <script type="text/javascript">
        var res1 = <?php echo $yearMouthResult; ?>;
        // 基于准备好的dom，初始化ECharts实例
        var myCharts1 = echarts.init(document.getElementById('main1'));
        var apps1 = {};
        options1 = null;
        // 指定图表的配置项和数据
        var options1 = {
            title : {
                text: '当月',
                x: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                // data:['当月数据']
                x:'right',
                y:'center',
                textStyle: {
                    color: 'yello'          // 图例文字颜色
                }
            },
            series : [
                {
                    name: '数据状态',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:res1,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        apps1.currentIndex = -1;

        setInterval(function () {
            var dataLen = options1.series[0].data.length;
            // 取消之前高亮的图形
            myCharts1.dispatchAction({
                type: 'downplay',
                seriesIndex: 0,
                dataIndex: apps1.currentIndex
            });
            apps1.currentIndex = (apps1.currentIndex + 1) % dataLen;
            // 高亮当前图形
            myCharts1.dispatchAction({
                type: 'highlight',
                seriesIndex: 0,
                dataIndex: apps1.currentIndex
            });
            // 显示 tooltip
            myCharts1.dispatchAction({
                type: 'showTip',
                seriesIndex: 0,
                dataIndex: apps1.currentIndex
            });
        }, 1000);
        if (options1 && typeof options1 === "object") {
            myCharts1.setOption(options1, true);
        }
    </script>
    
    
    <script src="__ADMIN__/js/jquery.min.js?v=2.1.4"></script>
    <script src="__ADMIN__/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="__ADMIN__/js/plugins/layer/layer.min.js"></script>
    <script src="__ADMIN__/js/content.min.js"></script>
    <script src="__ADMIN__/js/welcome.min.js"></script>
</body>

</html>
