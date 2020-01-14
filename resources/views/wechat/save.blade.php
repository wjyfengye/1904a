
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '设置微信回复')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form"  method="post" action="{{url('wechat/savedo')}}" enctype="multipart/form-data">
     <div class="middle-box text-center loginscreen  animated fadeInDown">
              
        <div class="form-group">
        回复类型  <select name="wechat_type" class="form-control" id="sele" >
                        <option value="text">文本</option>
                        <option value="image">图片</option>
                    </select>
        </div>

        <div class="form-group" id="text">
         文本内容<textarea name="wechat_cont" cols="30" rows="10"></textarea>
        </div>
        
        <div class="form-group" style="display:none;" id="img">
         图片 <input type="file" name="wechat_image">
        </div>
        <div class="form-group" style="display:none;" id="media">
             <input type="button" id="mediaImg" value="从素材库选择">
        </div>
        <div>
            <table border="1" class="table table-bordered" id="table">
                <!-- <tr>
                    <td>123123</td>
                    <td>123123</td>
                </tr>
                <tr>
                    <td>asd</td>
                    <td>asd</td>
                </tr> -->
            </table>
        </div>
              
        <button type="submit" class="btn btn-primary">添  加</button>
    </div>
</form>
<script>
$(function(){
    $(document).on("change","#sele",function(){
        var _val=$(this).val();
        if(_val=='text'){
             $('#img').hide();
             $('#text').show();
        }else if(_val=='image'){
            $('#text').hide();
            $('#img').show();
            $('#media').show();
        }
    });
    /**
     *  查询素材库
     */
   $(document).on("click","#mediaImg",function(){
        $.ajax({
            url:"{{url('wechat/getMedia')}}",
            method:"get",
            dataType:"json",
            success:function(res){
                //循环构建table表格
                $("#table").append("<tr><td>前选择</td><td>编号</td><td>名称</td><td>图片</td></tr>");
                $.each(res,function(i,v){
                    var tr=$("<tr></tr>");
                    tr.append("<td><input type='radio' name='media_id' value='"+v.wechat_media_id+"'></td>")
                    tr.append("<td>"+v.media_id+"</td>");
                    tr.append("<td>"+v.media_name+"</td>");
                    tr.append("<td><img src='/"+v.media_file+"' width='100px'></td>");
                    //tr放到table表里
                    $("#table").append(tr);
                });
               

            }
        })
   });
});
</script>

 <!-- 内容结束 -->
 @endsection