<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '标签展示页')


<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <table class="table table-bordered">
        <tr>
            <td>编号</td>
            <td>星标组</td>
            <td>标签人数</td>
            <td>操作</td>
        </tr>
       @foreach($tag as $v)
        <tr labelId="{{$v['id']}}" class="aa">
            <td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <td></td>
            <td>
                <a href="{{url('fans/edit',['id'=>$v['id']])}}">编辑</a>|
                <a href="{{url('fans/del',['id'=>$v['id']])}}">删除</a>
                <input type="button" id="sub" class="btn btn-warning" value="添加粉丝">
            </td>
        </tr>
       @endforeach
    </table>
    <table border="1" class="table table-bordered" id="table">
         
    </table>
<script>
    $(function(){
        //点击添加标签
        $(document).on('click',"#sub",function(){
            labelId=$(this).parents('.aa').attr('labelId');
            $.ajax({
            url:"{{url('fans/getFans')}}",
            method:"get",
            dataType:"json",
            success:function(res){
                    //循环构建table表格
                    $("#table").append("<tr><td>请选择</td><td>编号</td><td>昵称</td><td>OpenID</td><td>性别</td></tr>");
                    $("#table").append("<input type='button' class='btn btn-success' id='but' value='分配用户到标签'>");
                    $.each(res,function(i,v){
                        var tr=$("<tr></tr>");
                        tr.append("<td><input type='checkbox' name='openid' value='"+v.openid+"'></td>")
                        tr.append("<td>"+v.wechat_user_id+"</td>");
                        tr.append("<td>"+v.nickname+"</td>");
                        tr.append("<td>"+v.openid+"</td>");
                        tr.append("<td>"+v.sex+"</td>");
                        
                        //tr放到table表里
                        $("#table").append(tr);
                    });
                }
            })
        });

        /**选择粉丝，分配 */
        $(document).on("click","#but",function(){
            var openid=[];
            var _box=$("input:checked");
            $.each(_box,function(k,v){
                // console.log(v);return;
                openid.push(v.value);
                
            });
            // console.log(wechat_user_id);return;
            $.ajax({
                url:"{{url('fans/saveFans')}}",
                method:"GET",
                data:{openid:openid,labelId:labelId},
                dataType:"json",
                success:function(res){
                    if(res.errcode=='0'){
                        alert('标签添加成功');
                    }
                   
                }
            });
           
        });

        // var wechat_user_id = [];//定义一个空数组 
        //     $("input[name='open_id']:checked").each(function(i){//把所有被选中的复选框的值存入数组
        //         wechat_user_id[i] =$(this).val();
        //     }); 
        //     console.log(wechat_user_id);


      
    });
</script>

 <!-- 内容结束 -->
@endsection