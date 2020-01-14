<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '素材列表')


<!-- 声明内容开始 -->
@section('content')
    <form>
        <input type="submit" name="media_format" value="全部" class="btn btn-success">
        <input type="submit" name="media_format" value="图片" class="btn btn-primary">
        <input type="submit" name="media_format" value="音乐" class="btn btn-warning">
        <input type="submit" name="media_format" value="视频" class="btn btn-danger">
    </form>
        <table class="table table-bordered">
            <tr>
                <td>素材名称</td>
                <td>素材格式</td>
                <td>素材类型</td>
                <td>文件</td>
            </tr>
        @foreach($mediaInfo as $v)
            <tr>
                <td>{{$v->media_name}}</td>
                <td>{{$v->media_format}}</td>
                <td>{{$v->media_type==1?'临时素材':'永久素材'}}</td>
                <td>
                    @if($v->media_format=='image')
                    <img src="/{{$v->media_file}}" width="150px">
                    @elseif($v->media_format=='video')
                    <embed src="/{{$v->media_file}}" type="" width="150px"></embed>
                    @else
                    <embed src="/{{$v->media_file}}" type="" width="150px"></embed>
                    @endif
                </td>
            </tr>
        @endforeach
        </table>
    {{$mediaInfo->appends($search)->links()}}

 <!-- 内容结束 -->
 @endsection