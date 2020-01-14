<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $adminInfo=session('adminInfo');
        $admin_id=$adminInfo['admin_id'];
        // dd($adminInfo);
        if(empty($adminInfo)){
            
            return redirect('login/login');
        }
        // else{
        //     $sql="SELECT * FROM power WHERE power_id 
        //     in(SELECT power_id From power_role WHERE role_id 
        //     in(SELECT role_id FROM admin_role WHERE admin_id=$admin_id))";
        //     // echo $sql;exit;
        //     $powerData= \DB::select($sql);
        //     // dd($powerData);
        //     $powerData=json_encode($powerData);
        //     $powerData=json_decode($powerData,true);
        //     // dd($powerData);
          
        //     $res=$request->url();
        //     // dd($res);
        //     foreach ($powerData as $key => $value) {
        //         if($value['power_url']==$res){
        //             return $next($request);
        //         }
        //     }
        //     echo '<script>alert("没有权限访问");location.href="/admin/index"</script>';
        // }
        return $next($request);
        
    }
}
