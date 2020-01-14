<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '粉丝展示页')


<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <table class="table table-bordered">
        <tr>
            <td>选择</td>
            <td>编号</td>
            <td>用户昵称</td>
            <td>openId</td>
            <td>用户城市</td>
            <td>操作</td>
        </tr>
       @foreach($data as $v)
        <tr openid="{{$v->openid}}">
            <td><input type="checkbox"></td>
            <td>{{$v->wechat_user_id}}</td>
            <td>{{$v->nickname}}</td>
            <td>{{$v->openid}}</td>
            <td>{{$v->city}}</td>
            <td>
                <a href="">编辑</a>|
                <a href="">删除</a>
            </td>
        </tr>
       @endforeach
    </table>
    <input type="button" id="sub" value="分配用户到标签">
<script>
    $(function(){
       
        //点击添加标签
        $(document).on('click',"#sub",function(){
            var openid="";
            var _box=$("input:checked");
            // console.log(_box);return;
            $.each(_box,function(res){
                // console.log(res);return;
                openid+=$(this).parents('tr').attr('openid')+',';
            //    wechat_user_id.push(_box.val())
            });
            openid=openid.substr(0,openid.length-1);
            console.log(openid);
             
            return;
        });
    });
</script>
 <!-- 内容结束 -->
@endsection