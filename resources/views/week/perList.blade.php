
@extends('layouts.admin')


@section('title', '分配展示')


@section('content')
    <h4>用户:&nbsp;&nbsp;<span style="color:darkorange">{{$userInfo['nickname']}}</span></h4>
    <h4>头像:&nbsp;&nbsp;<span style="color:darkorange"><img src="{{$userInfo['headimgurl']}}" alt=""></span></h4>
    <h4>性别:&nbsp;&nbsp;<span style="color:darkorange">{{$userInfo['sex']=='1'?'男':'女'}}</span></h4>
@endsection