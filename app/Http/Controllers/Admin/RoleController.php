<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;//验证器
use Illuminate\Http\Request;
use App\Rbac\RoleModel;
use App\Rbac\AdminRoleModel;
use App\Admin\admin;

class RoleController extends Controller
{
    /**
     *  角色添加视图
     */
    public function save(){
        return view('role/save');
    }
    /**
     *  执行角色添加
     */
    public function saveDo(){
        $data=request()->all();
        $res=RoleModel::create($data);
        return redirect('role/index');
    }
    /**
     * 分配角色列表
     */
    public function index($admin_id=''){
        // dd($admin_id);
        if(request()->isMethod('post')){
            //添加数据入库
            $data=request()->all();
            AdminRoleModel::where("admin_id",$data['admin_id'])->delete();
            // dd($data);
            //入库 角色、用户关系表
            foreach ($data['role_id'] as $key => $value) {
                 AdminRoleModel::create([
                     "admin_id"=>$data['admin_id'],
                     "role_id"=>$value,
                 ]);
            }
            echo "角色分配成功";exit;
        }
        
        // //获取用户，展示用户信息
        $adminInfo=admin::where("admin_id",$admin_id)->first();
        //查询角色表，展示角色
        $roleInfo=RoleModel::get();
        //  查询用户、角色关系表，根据用户id查询
        $adminRoleData=AdminRoleModel::where("admin_id",$admin_id)->get()->toArray();
        //  只获取roled_id一列返回视图，进行判断   pluck()  获取数据库一列
        // $adminRoleData=AdminRoleModel::where("admin_id",$admin_id)->pluck('role_id')->toArray();
        $adminRoleData=array_column($adminRoleData,'role_id');
        
        // dd($adminRoleData);
        return view('role/index',['roleInfo'=>$roleInfo,"adminInfo"=>$adminInfo,"adminRoleData"=>$adminRoleData]);
    }

    /**
     *  角色列表
     */
    public function list(){
        //查询角色表，展示角色
        $roleInfo=RoleModel::get()->toArray();
        // dd($roleInfo);
        return view('role/list',['roleInfo'=>$roleInfo]);
    }
}