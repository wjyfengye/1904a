<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '菜单列表')


<!-- 声明内容开始 -->
@section('content')
        <table class="table table-bordered">
            <tr>
                <td>菜单名称</td>
                <td>菜单类型</td>
                <td>菜单标识</td>
            </tr>
        @foreach($menuData as $v)
            <tr>
                <td>{{$v['menu_name']}}</td>
                <td>{{$v['menu_type']}}</td>
                <td>{{$v['url']}}</td>
            </tr>
        @endforeach
        </table>
        <div style="float:left">
        <button class="btn btn-info"><a href="{{url('menu/index')}}" >一键同步微信菜单</a></button>
        </div>
    <div style="float:right">
        <button class="btn btn-warning"><a href="{{url('menu/add')}}" >添加微信菜单</a></button>
    </div>
 <!-- 内容结束 -->
 @endsection