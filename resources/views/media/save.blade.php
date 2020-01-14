
<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '素材添加')


<!-- 声明内容开始 -->
@section('content')
<form class="m-t" role="form"  method="post" action="{{url('media/savedo')}}" enctype="multipart/form-data">
     <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div class="form-group">
        素材名称 <input type="text" class="form-control" name="media_name" >
        </div>
        
        <div class="form-group">
        媒体格式  <select name="media_format" class="form-control" >
                        <option value="image">图片</option>
                        <option value="voice">语音</option>
                        <option value="video">视频</option>
                    </select>
        </div>
        <div class="form-group">
        媒体类型  <select name="media_type" class="form-control" >
                        <option value="1">临时素材</option>
                        <option value="2">永久素材</option>
                    </select>
        </div>

        <div class="form-group">
        素材文件  <input type="file" name="media_file">
        </div>
    
        <button type="submit" class="btn btn-primary">添  加</button>
    </div>
</form>
 <!-- 内容结束 -->
 @endsection