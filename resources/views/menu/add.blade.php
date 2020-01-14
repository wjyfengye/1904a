
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '菜单添加')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form"  method="post" action="{{url('menu/addDo')}}" enctype="multipart/form-data">
     <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div class="form-group">
        菜单名称 <input type="text" class="form-control" name="menu_name" >
        @if ($errors->has('menu_name'))
             <span style="color:red">{{$errors->first('menu_name')}}</span>
        @endif
        </div>
        <div class="form-group">
        菜单类型  <select name="menu_type" class="form-control" >
                        <option value="">请选择</option>
                        <option value="click">点击</option>
                        <option value="view">搜索</option>
                    </select>
        </div>
        <div class="form-group">
        上级菜单  <select name="parent_id" class="form-control" >
                        <option value="0">请选择</option>
                  @foreach($data as $v)
                        <option value="{{$v['menu_id']}}">{{$v['menu_name']}}</option>
                  @endforeach
                    </select>
        </div>

        <div class="form-group">
        菜单标识  <input type="text" name="url" class="form-control">
        @if($errors->has('url'))
            <span style="color:red">{{$errors->first('url')}}</span>
        @endif
        </div>
    
        <button type="submit" class="btn btn-primary">添  加</button>
    </div>
</form>
 <!-- 内容结束 -->
 @endsection