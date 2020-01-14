
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '群发消息')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form"  method="post" action="{{url('fans/groupDo')}}">
     <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div class="form-group">
        群发内容 <input type="text" class="form-control" name="group_cont" >
        </div>
        <div class="form-group">
        标签名称<select name="id" class="form-control">
                @foreach($tag as $v)
                    <option value="{{$v['id']}}">{{$v['name']}}</option>
                @endforeach
                </select>
        </div>
        <button type="submit" class="btn btn-primary">发  送</button>
    </div>
</form>
 <!-- 内容结束 -->
 @endsection