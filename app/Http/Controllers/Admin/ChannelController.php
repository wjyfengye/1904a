<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wechat\ChannelModel;
use App\Tools\Wechat;
use App\Tools\Curl;
use PHP_Token_FOREACH;

class ChannelController extends Controller
{
    /**
     * 渠道添加视图
     */
    public function save(){
        return view('channel/save');
    }
    /**
     *  执行渠道添加
     */
    public function saveDo(){
        $channel_name=request()->channel_name;
        $channel_number=request()->channel_number;
        if(empty($channel_name)||empty($channel_number)){
            echo "渠道名和渠道号不能为空";exit;
        }
        $access_token=Wechat::getToken();
        $postData='{"expire_seconds": 2592000, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$channel_number.'"}}}';
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
        //echo $url;die;
        $res=Curl::curlPost($url,$postData);
        $res=json_decode($res,true);
        // dd($res);
        $ticket=$res['ticket'];
        // dd($ticket);
        ChannelModel::create([
            'channel_name'=>$channel_name,
            'channel_number'=>$channel_number,
            'ticket'=>$ticket,
            'people'=>0,
            'create_time'=>time()
        ]);
        return redirect('channel/list');
    }

    /**
     *  渠道展示
     */
    public function list(){
        $channelInfo=ChannelModel::get();
        $channelName="";
        $channelSum="";

        foreach ($channelInfo as $k => $v) {
            $channelName .="'".$v['channel_name']."'".',';
            $channelSum .=$v['people'].',';
        }
        $channelName=rtrim($channelName,',');
        $channelSum=rtrim($channelSum,',');
        return view('channel/list',['channelInfo'=>$channelInfo,'channelName'=>$channelName,'channelSum'=>$channelSum]);
    }
    
}
