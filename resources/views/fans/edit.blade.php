
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '标签编辑')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form"  method="post" action="{{url('fans/update')}}">
        <input type="hidden" name="id" value="{{$id}}">
     <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div class="form-group">
        标签名称 <input type="text" class="form-control" name="label_name">
        </div>
        <button type="submit" class="btn btn-primary">修改</button>
    </div>
</form>
 <!-- 内容结束 -->
 @endsection