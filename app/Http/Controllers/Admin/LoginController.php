<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\admin;
use App\Admin\MsgModel;
use App\Tools\Wechat;
use App\Tools\Curl;

class LoginController extends Controller
{
    /**
     * 登录视图
     */
    public function login(){
        return view('login.login');
    }
    /** 
     * 执行登录
     */
    public function loginDo(){
        $data=request()->all();
        if(!empty($data)){
            $adminInfo=admin::where(['admin_name'=>$data['admin_name']])->first();
            if($data['admin_pwd']==decrypt($adminInfo['admin_pwd'])){//解密
                //根据admin_id  查询数据库中的验证码
                $admin_id=$adminInfo['admin_id'];
                $codeData=MsgModel::where('admin_id',$admin_id)->orderBy('msg_id','DESC')->first()->toArray();
                //判断验证码是否正确以及验证码有效期
                if($data['code']!=$codeData['code']||time()>$codeData['expire_time']){
                    echo "验证码不正确或验证码已过期";exit;
                }
                // echo "登录成功";exit;
                session(['adminInfo'=>$adminInfo]);
                // dd(session('adminInfo'));
            }else{
                echo "登录失败";exit;
            }
        }
        return redirect('admin/index');
    }
    /**
     *  验证码
     */
    public function send(){
        $admin_name=request()->admin_name;
        $admin_pwd=request()->admin_pwd;
        if(!empty($admin_name)){
            $adminInfo=admin::where(['admin_name'=>$admin_name])->first();
            if($admin_pwd!=decrypt($adminInfo['admin_pwd'])){
                $arr=['font'=>'用户信息错误','code'=>2];
	            echo json_encode($arr);exit;
            }
        }
        $openid=$adminInfo['openid'];
        $code=rand(1000,9999);
        //入库，存储验证码
        $res=MsgModel::create([
            "admin_id"=>$adminInfo['admin_id'],
            "code"=>$code,
            "expire_time"=>time()+300  //5分钟后过期
        ]);
        // dd($res);
        $access_token=Wechat::getToken();
        //调用模板消息接口
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
        $data=[
                "touser"=>$openid,
                'template_id'=>'6_hGMLechC7i-xos0VvCRniCdou2-XDXMLtryRF2EZg',
                "data"=>[
                        "name"=>[
                            "value"=>$admin_name,
                            "color"=>"#173177"
                            ],
                        "code"=>[
                            "value"=>$code,
                            "color"=>"#173177"
                            ]
                        ]
              ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $res=Curl::curlPost($url,$data);
        $arr=['font'=>'发送成功','code'=>1];
        echo json_encode($arr);
    }

    /**
     *  绑定页面
     */
    public function bind(){
        //一点击绑定账号，调用封装的方法,先获取用户openid，
        $openid=Wechat::getOpenid();
        return view('login/bind');
        
    }
    /**
     * 
     */
    public function bindDo(){
        //得到openid
        $openid=Wechat::getOpenid();
        //接值
        $admin_name=request()->admin_name;
        $admin_pwd=request()->admin_pwd;
        
        if(!empty($admin_name)){
            $adminInfo=admin::where(['admin_name'=>$admin_name])->first();
            if($admin_pwd!=decrypt($adminInfo['admin_pwd'])){
	            echo "用户信息错误";exit;
            }
        }
        $adminInfo->openid=$openid;//对象指向openid
        $res=$adminInfo->save();//save有责修改，无责添加
        return redirect('admin/index');
    }
}
