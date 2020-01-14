@extends('layouts.admin')


@section('title', '分配展示')


@section('content')
	<h3>给用户选择角色</h3>
	<br>
	<h4>用户:&nbsp;&nbsp;<span style="color:darkorange">{{$adminInfo['admin_name']}}</span></h4>
    <form action="{{url('role/index')}}" method="POST">
    	<input type="hidden" value="{{$adminInfo['admin_id']}}" name="admin_id">
		  <table class='table table-bordered'>
		  		@foreach($roleInfo as $v)
	  	  		<tr>
			  		<td width="18%" valign="top" class="first-cell">
			    		<input type="checkbox" name="role_id[]" value="{{$v['role_id']}}" <?php if(in_array($v['role_id'],$adminRoleData)) echo "checked" ?> class="checkbox" title=""  >
			    		{{$v['role_name']}}  
			    	</td>
			   	</tr>
			   	@endForeach
	 	 </table>

	 	 <button type="submit" class="btn btn-default">添加</button>
	</form>
@endsection