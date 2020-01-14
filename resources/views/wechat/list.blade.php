<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '回复展示')
<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <table class="table table-bordered">
        <tr>
            <td>回复类型</td>
            <td>回复内容</td>
            <td>回复图片</td>
            <td>选择回复</td>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->wechat_type}}</td>
            <td>{{$v->wechat_cont}}</td>
            <td class="case_info">
               <img src="/{{$v->wechat_image}}" width="150px">
            </td>
            <td>
                @if($v->is_show==1)
                    <button class="btn btn-info">
                        <a href="{{url('wechat/update',['wechat_id'=>$v->wechat_id])}}" >默认</a>
                    </button>
                @else
                    <button class="btn btn-warning">
                        <a href="{{url('wechat/update',['wechat_id'=>$v->wechat_id])}}" >设为默认</a>
                    </button>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</body>
 <!-- 内容结束 -->
@endsection