<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="{{asset('hadmin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('hadmin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('hadmin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('hadmin/css/style.css?v=4.1.0')}}" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">h</h1>

            </div>
            <h3>欢迎使用 hAdmin</h3>

            <form class="m-t" role="form" method="post" action="{{url('login/loginDo')}}">
                <div class="form-group">
                    <input type="text" class="form-control" name="admin_name" placeholder="用户名" >
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="admin_pwd" placeholder="密码">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="code" style="width:65%;float:left" placeholder="验证码">
                    <input type="button" class="btn btn-warning" id="send" value="发送验证码">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
                <p class="text-muted text-center"> 
                    <a href="login.html#"><small>忘记密码了？</small></a> | 
                    <a href="register.html">注册一个新账号</a>
                </p>
                <h3 style="color:blueviolet;">扫描二维码关注公众号</h3>
                <img src="/wjy.jfif" width="150px">
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
</body>

</html>
<script>
    $(function(){
        $(document).on("click","#send",function(){
            var admin_name=$("[name='admin_name']" ).val();
            var admin_pwd=$("[name='admin_pwd']").val();
            $.ajax({
                method: "GET",
                url: "{{url('login/send')}}",
                data: { admin_name:admin_name,admin_pwd:admin_pwd },
                dataType:'json',
                success:function(res){
                    alert(res.font);
                }
                })
            });

        });
</script>
