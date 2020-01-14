<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wechat\MediaModel;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Wechat\WechatUserModel;
use App\Wechat\ProposanlModel;
use LibXMLError;
use SimpleXMLElement;

class WechatController extends Controller
{
    public $randArr=['1901班','1902班','1903班','1904班','1905班'];
    /**
     *  接入微信接口
     */
    public function wechat(Request $request){
        // $str=$request->echostr;
        $data=file_get_contents("php://input");
        //写入文件
        file_put_contents("29.txt",$data);
        $postObj=simplexml_load_string($data,"SimpleXMLElement",LIBXML_NOCDATA);
        //判断是否是关注事件
        if($postObj->MsgType=='event'&&$postObj->Event=='subscribe'){
            //获取token
            $access_token=Wechat::getToken();
            // 调用接口获取用户信息
            $userInfo=Wechat::getUserInfo($postObj->FromUserName);
            // dd($userInfo);//用户昵称
            $nickname=$userInfo['nickname'];
            $openid=$userInfo['openid'];
            //入库
            $userData=WechatUserModel::where('openid',$openid)->first();
            // dd($userData);
            if(empty($userData)){
                $res=WechatUserModel::create([
                    "openid"=>$openid,
                    "nickname"=>$nickname,
                    "sex"=>$userInfo['sex'],
                    "city"=>$userInfo['city'],
                    'is_del'=>1
                ]);
                $msg="你好欢迎  ".$nickname."  首次关注";
            }else{
                $msg="你好欢迎  ".$nickname."  回来";
            }
            Wechat::responseText($msg,$postObj);
        }

        /**
         *  发送文本
         */
        if($postObj->MsgType=='text'){
            $content=$postObj->Content;
            if($content=='1'){
                //回复消息
                $msg=implode(',',$this->randArr);
                //将发送的消息入库
                ProposanlModel::create(['proposanl_desc'=>$content]);
                Wechat::responseText($msg,$postObj);
            }
        }

        /**
         *  发送图片信息
         */
        if($postObj->MsgType=='image'){
            //获取token
            $access_token=Wechat::getToken();
            
            $mediaData=MediaModel::where('media_format','image')->orderBy('media_id','desc')->first()->toArray();
            // dd($mediaData);
            $madia_id=$mediaData['wechat_media_id'];
            // dd($madia_id);
            Wechat::responseImg($postObj,$madia_id);
        }
    }
}