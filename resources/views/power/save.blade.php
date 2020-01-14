
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '权限')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form" method="post" action="{{url('power/saveDo')}}">
        <div class="form-group">
            权限名称<input type="text"  name="power_name">
        </div>
        <div class="form-group">
            上级权限<select name="parent_id" >
                        <option value="0">顶级权限</option>
                    @foreach($data as $v)
                        <option value="{{$v['power_id']}}">{{str_repeat('|—',$v['level']*3)}}{{$v['power_name']}}</option>
                    @endforeach
                    </select>
        </div>
        <div class="form-group">
            权限地址<input type="text"  name="power_url" >
        </div>
        <button type="submit" class="btn btn-primary block">添加</button>
</form>

 <!-- 内容结束 -->
 @endsection