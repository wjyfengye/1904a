<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            /* css 代码  */
        </style>
        <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
        <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/themes/grid-light.js"></script>
        <script src="/hadmin/js/jquery.min.js"></script>
    </head>
    <body>
        城市
        <input type="text" name="city" id="city">
        <input type="button" value="搜索" id="search">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">
        </div>
        <script>
$(function(){
    //一进页面，默认查北京天气
    $.ajax({
            url:"{{url('admin/getweather')}}",
            type:"get",
            data:{city:'北京'},
            dataType:"json",
            success:function(res){
                //展示图表
                weather(res.result);
            }
        })
    $(document).on("click",'#search',function(){
        var city=$('#city').val();
        if(city==''){
            alert('请输入城市名称');
            return;
        }
        $.ajax({
            url:"{{url('admin/getweather')}}",
            type:"get",
            data:{city:city},
            dataType:"json",
            success:function(res){
                //展示图表
                weather(res.result);
            }
        })
    });

    function weather(weatherData){
       // JS 代码 
       // console.log(weatherData);return;
       var day=[];
       var temperature=[];//温度
       $.each(weatherData,function(k,v){
            day.push(v['days']);//数组追加push
            //最高气温、最低气温  结构[1,10]    将字符串转数字类型 parseInt()
            temperature.push([parseInt(v.temp_low),parseInt(v.temp_high)]);
       })
       
        var chart = Highcharts.chart('container', {
        chart: {
            type: 'columnrange', // columnrange 依赖 highcharts-more.js
            inverted: true
        },
        title: {
            text: '一周温度变化'
        },
        subtitle: {
            text: weatherData[0]['citynm']
        },
        xAxis: {
            categories:day
        },
        yAxis: {
            title: {
                text: '温度 ( °C )'
            }
        },
        tooltip: {
            valueSuffix: '°C'
        },
        plotOptions: {
            columnrange: {
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return this.y + '°C';
                    }
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '温度',
            data: temperature
        }]
        });
    }
    
})
        </script>
    </body>
</html>