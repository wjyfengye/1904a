
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '素材添加')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form"  method="post" action="{{url('channel/savedo')}}" enctype="multipart/form-data">
     <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div class="form-group">
        渠道名称 <input type="text" class="form-control" name="channel_name" >
        </div>
        <div class="form-group">
        渠道号 <select name="channel_number" class="form-control">
                    <option value="111">111</option>
                    <option value="112">112</option>
                    <option value="113">113</option>
               </select>
        </div>
    
        <button type="submit" class="btn btn-primary">添  加</button>
    </div>
</form>
 <!-- 内容结束 -->
 @endsection