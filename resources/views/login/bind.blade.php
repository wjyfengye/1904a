
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '绑定页面')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form" method="post" action="{{url('login/bindDo')}}">
  
    <div class="col-xs-4">
        <input type="text" class="form-control" name="admin_name" placeholder="用户名" >

        <!-- @if($errors->has('admin_name'))<span style="color:red">{{$errors->first('admin_name')}}</span>@endif -->
    </div>
    
    <div class="col-xs-4">
        <input type="password" class="form-control" name="admin_pwd" placeholder="密码">
        <!-- @if($errors->has('admin_pwd'))<span style="color:red">{{$errors->first('admin_pwd')}}</span>@endif -->
    </div>
   
    <button type="submit" class="btn btn-primary">添加绑定</button>
   
</form>
 <!-- 内容结束 -->
 @endsection