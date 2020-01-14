<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;//验证器
use Illuminate\Http\Request;
use App\Wechat\PowerModel;
use App\Rbac\RoleModel;
use App\Rbac\PowerRoleModel;
use App\Tools\Wechat;
use App\Tools\Common;
class PowerController extends Controller
{
    /**
     *  权限添加视图
     */
    public function save(){
        $data=PowerModel::get()->toArray();
        //调用的封装，无限极分类
        $data=Common::getPower($data);
        return view('power/save',['data'=>$data]);
    }

    /**
     *   执行权限添加
     */
    public function saveDo(){
        $data=request()->all();
        // dd($data);
        $res=PowerModel::create($data);
        return redirect('power/index');
    }

    /**
     *   权限列表
     */
    public function index(){
        $powerInfo=PowerModel::get();
        //权限展示，采用递归排序
        $powerInfo=Common::getPower($powerInfo);
        // dd($powerInfo);
        return view('power/index',['powerInfo'=>$powerInfo]);
    }

    /**
     *  权限分配
     */
    public function list($role_id=''){
        if(request()->isMethod('post')){
            $postData=request()->all();
            //根据角色，先删除角色、权限关系表数据，重新添加
            PowerRoleModel::where(['role_id'=>$postData['role_id']])->delete();
            // dd($postData);
            foreach ($postData['power_id'] as $key => $value) {
                $res=PowerRoleModel::create([
                    'role_id'=>$postData['role_id'],
                    'power_id'=>$value
                    ]);
            }
            echo "权限分配成功";exit;
        }
        //查询角色表，展示角色
        $roleInfo=RoleModel::where('role_id',$role_id)->first();
        //获取权限数据
        $powerInfo=PowerModel::get();
        //权限展示，采用递归排序
        $powerInfo=Common::createTreeBySon($powerInfo);
        //获取当前角色对应权限有哪些   查询角色、权限关系
        $rolePowerData=PowerRoleModel::where(['role_id'=>$role_id])->get()->toArray();
        $rolePowerData=array_column($rolePowerData,'power_id');
        // dd($roleInfo);
        return view('power/list',['powerInfo'=>$powerInfo,'roleInfo'=>$roleInfo,'rolePowerData'=>$rolePowerData]);
    }


}