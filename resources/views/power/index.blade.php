<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '权限展示')
<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <table class="table table-bordered">
        <tr>
            <td>权限ID</td>
            <td>权限名称</td>
            <td>上级</td>
            <td>操作</td>
        </tr>
        @foreach($powerInfo as $v)
        <tr>
            <td>{{$v->power_id}}</td>
            <td>{{str_repeat('|—',$v['level']*3)}}{{$v->power_name}}</td>
            <td></td>
            <td>
                <a href="">编辑</a>
                <a href="">删除</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
 <!-- 内容结束 -->
@endsection