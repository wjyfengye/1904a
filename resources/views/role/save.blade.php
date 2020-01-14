
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '角色添加')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form" method="post" action="{{url('role/saveDo')}}">
        <div class="form-group">
            角色名称<input type="text"  name="role_name" placeholder="角色">
        </div>
        
        <button type="submit" class="btn btn-primary block">添加</button>
</form>

 <!-- 内容结束 -->
 @endsection