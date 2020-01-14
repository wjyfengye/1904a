<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\admin;
use App\Tools\Curl;
use App\Tools\Common;
use DB;
use Illuminate\Support\Facades\Cache;
use Validator;
class AdminController extends Controller
{
    /**
     *  后台首页
     */
    public function index(){
        //查询用户菜单
        $adminInfo=session('adminInfo');//登录后session拿的
        $admin_id=$adminInfo['admin_id'];
        /**
         * 分3步查询 
         *   通过用户id  找到角色id
         *   SELECT role_id FROM admin_role WHERE admin_id = 1 /// 角色id  1 2
         *   通过角色id 找到权限
         *   SELECT power_id FROM role_power WHERE role_id in (1,2)  //权限id 1,2,3,4
         *   通过权限id 找到对应权限表数据
         *   SELECT * FROM power WHERE power_id in(1,2,3,4);
         */
        //  子查询方式 
        $sql="SELECT * FROM power WHERE power_id 
            in(SELECT power_id From power_role WHERE role_id 
            in(SELECT role_id FROM admin_role WHERE admin_id=$admin_id))";
        // echo $sql;exit;
        $powerData= \DB::select($sql);
        // dd($powerData);
        $powerData=json_encode($powerData);
        $powerData=json_decode($powerData,true);
        // dd($powerData);
        $powerData=Common::createTreeBySon($powerData);
        // dd($powerData);
        return view('admin.index',['powerData'=>$powerData]);
    }

    /**
     *  管理员添加
     */
    public function save(){
        return view('admin.save');
    }
     /**
     *  管理员添加
     */
    public function savedo(){
        //验证器，验证
        $validator = Validator::make(request()->all(), [
            'admin_name' => 'required|unique:admin|min:2|max:12',
            'admin_pwd' => 'required',
        ],
            [
            'admin_name.required'=>'管理员不能为空',
            'admin_name.unique'=>'管理员已存在',
            'admin_name.min'=>'管理员名最少2位',
            'admin_name.max'=>'管理员名最多12位',
            'admin_pwd.required'=>'密码不能为空',
            ]
        );
            if ($validator->fails()) {
            return redirect('admin/save')
            ->withErrors($validator)
            ->withInput();
        }
        $data=request()->all();         
        $data['admin_pwd']=encrypt($data['admin_pwd']);
        $res=admin::create($data);
        return redirect("admin/show");
    }
    /**
     * 管理员列表
     */
    public function show(){
        $adminInfo=admin::get();
        return view('admin/show',['adminInfo'=>$adminInfo]);
    }

    public function weather(){

        return view('admin/weather');
    }
    public function getWeather(){
        $city=request()->input('city');
        // Cache::flush();//清除缓存
        $weatherData=Cache::get("weather_".$city);
        if(empty($weatherData)){
            $url="http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=46450&sign=af74aeea77b69fe71f80eda34f717d28&format=json";
            $weatherData=Curl::curlGet($url);
            //strtotime将英文文本日期时间解析为 Unix 时间戳 
            //  日期类型实际存储的是那个日期到某个特定日期的秒数，所以直接echo是一个大的整数。
            // 许多语言都是这样处理的, 这样日期之间可以直接进行减法运算，日期也可以与整数进行加减运算。
            $time24=strtotime(date("Y-m-d"))+86400;
            $second=$time24-time();
            Cache::put("weather_".$city,$weatherData,$second);
        }
        return $weatherData;
    }

    
    
}
