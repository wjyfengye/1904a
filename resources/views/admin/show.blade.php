<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '后台展示页')


<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>用户名</td>
            <td>操作</td>
        </tr>
        @foreach($adminInfo as $v)
        <tr>
            <td>{{$v->admin_id}}</td>
            <td>{{$v->admin_name}}</td>
            <td>
                <a href="">编辑</a>|
                <a href="">删除</a>
                <a href="{{url('role/index/'.$v['admin_id'])}}">分配角色</a>
            </td>
        </tr>
        @endforeach
    </table>
 <!-- 内容结束 -->
@endsection