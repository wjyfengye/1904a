<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '渠道展示')
<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <table class="table table-bordered">
        <tr>
            <td>渠道名</td>
            <td>渠道号</td>
            <td>渠道码</td>
            <td>关注量</td>
        </tr>
        @foreach($channelInfo as $v)
        <tr>
            <td>{{$v->channel_name}}</td>
            <td>{{$v->channel_number}}</td>
            <td class="case_info">
               <img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" width="100px">
            </td>
            <td>{{$v->people}}</td>
        </tr>
        @endforeach
    </table>

    <body>
    <!-- 图表容器 DOM -->
    <div id="container" style="width: 600px;height:400px;"></div>
    <!-- 引入 highcharts.js -->
    <script src="http://cdn.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script>
        // 图表配置
        var options = {
            chart: {
                type: 'bar'                          //指定图表的类型，默认是折线图（line）
            },
            title: {
                text: '渠道图表'                 // 标题
            },
            xAxis: {
                categories: [<?php echo $channelName ?>]   // x 轴分类
            },
            yAxis: {
                title: {
                    text: '各渠道关注量'                // y 轴标题
                }
            },
            series: [{                              // 数据列
                name: '关注人数',                        // 数据列名
                data: [<?php echo $channelSum ?>]                     // 数据
            }]
        };
        // 图表初始化函数
        var chart = Highcharts.chart('container', options);
    </script>
</body>
 <!-- 内容结束 -->
@endsection