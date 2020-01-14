@extends('layouts.admin')


@section('title', '分配展示')


@section('content')
	
    <form action="" method="">
    	
		  <table class='table table-bordered'>
			  	<tr>
					<td>ID</td>
					<td>角色名</td>
					<td>编辑</td>
				</tr>
		  		@foreach($roleInfo as $v)
	  	  		<tr>
					<td>{{$v['role_id']}}</td>
					<td>{{$v['role_name']}}</td>
			  		<td>
					  <a href="{{url('power/list/'.$v['role_id'])}}">分配权限</a>
					</td>
			   	</tr>
			   	@endForeach
	 	 </table>
	</form>
@endsection