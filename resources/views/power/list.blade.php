<!-- 继承layout -->
@extends('layouts.admin')
<!-- 声明头部 -->
@section('title', '权限展示')
<!-- 声明内容开始 -->
@section('content')
    <!-- <p>这里是主体内容，完善中...</p> -->

    <h3>给角色分配权限</h3>
	<br>
	<h4>角色:&nbsp;&nbsp;<span style="color:darkorange">{{$roleInfo->role_name}}</span></h4>
    <form action="{{url('power/list')}}" method="POST">
    <input type="hidden" value="{{$roleInfo['role_id']}}" name="role_id">
		  <table class='table table-bordered'>
		  		@foreach($powerInfo as $v)
	  	  		<tr>
			  		<td width="18%" valign="top" class="first-cell">
			    		<input type="checkbox" class="checkbox" name="power_id[]" value="{{$v['power_id']}}" <?php if(in_array($v['power_id'],$rolePowerData)) echo 'checked'; ?> >
			    		{{$v['power_name']}}  
                    </td>
                    @if(!empty($v['son']))
                        <td>
                            @foreach($v['son'] as $val)
                                <div style="width:200px;float:left">
                                        <input type="checkbox" class="checkbox" name="power_id[]" value="{{$val['power_id']}}" <?php if(in_array($val['power_id'],$rolePowerData)) echo 'checked'; ?>>
                                        {{$val['power_name']}}  
                                </div>
                            @endforeach
                        </td>
                    @endif
			   	</tr>
			   	@endForeach
	 	 </table>

	 	 <button type="submit" class="btn btn-default">添加</button>
    </form>
    <script>
        $(function(){
            $(document).on("click",".checkbox",function(){
               //如果是点击状态    全选、反选
               var status =$(this).prop('checked');
               var td =$(this).parent();
               var select =td.next("td").find("input[type='checkbox']").prop('checked',status);
            })
        })
    </script>
 <!-- 内容结束 -->
@endsection