<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wechat\ChannelModel;
use App\Wechat\WechatUserModel;
use App\Tools\Wechat;
use App\Tools\Curl;
use PHP_Token_FOREACH;

class FansController extends Controller
{
    /**
     *  粉丝列表
     */
    public function list(){
        $data=WechatUserModel::get();
        return view('fans/list',['data'=>$data]);
    }

    /**
     *  标签添加
     */
    public function add(){
        return view('fans/add');
    }

    public function addDo(Request $request){
        $data=$request->all();
        // dd($data);
        $access_token=Wechat::getToken();
        // dd($access_token);
        //调用 创建标签接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token={$access_token}";
        
        $data=[
            'tag'=>['name'=>$data['label_name']]
        ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $data=Curl::curlPost($url,$data);
        return redirect('fans/show');
    }

    /**
     *  标签列表
     */
    public function show(){
        //获取token
        $access_token=Wechat::getToken();
        // dd($access_token);
        //调用  获取标签接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token={$access_token}";
        // get获取标签
        $data=Curl::curlGet($url);
        // dd($data);
        $data=json_decode($data,true);
        
        $tag=[];
        foreach ($data as $key => $value) {
            $tag=$value;
        }
        // dd($tag);
        return view('fans/show',['tag'=>$tag]);
    }

    /**
     *  标签修改
     */
    public function edit($id){
        return view('fans/edit',['id'=>$id]);
    }
    /**
     *  执行修改
     */
    public function update(){
        $data=request()->all();
    
        //获取token
        $access_token=Wechat::getToken();

        //调用  编辑标签接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/update?access_token={$access_token}";
        
        $data=[
            'tag'=>['id'=>$data['id'],'name'=>$data['label_name']]
        ];
        
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $data=Curl::curlPost($url,$data);
        return redirect('fans/show');
    }

    /**
     *  删除标签
     */
    public function del($id){
        //获取token
        $access_token=Wechat::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/tags/delete?access_token={$access_token}";
        $data=[
            'tag'=>['id'=>$id]
        ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $data=Curl::curlPost($url,$data);
        return redirect('fans/show');
    }

    /**
     * ajax 查询粉丝
     */
    public function getFans(){
        $data=WechatUserModel::get();
        $data=json_encode($data);
        return $data;
    }

    /**
     *  ajax 给用户打标签
     */
    public function saveFans(){
        $data=request()->all();
        // dd($data);
        $openid=$data['openid'];
        $labelId=$data['labelId'];
        // dd($data['openid']);
        //获取token
        $access_token=Wechat::getToken();
        //批量为用户打标签
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token={$access_token}";
        
        $labelName=[
            "openid_list"=>[$openid],
            "tagid"=>$labelId
        ];
        $postData=json_encode($labelName,JSON_UNESCAPED_UNICODE);
        $postData=Curl::curlPost($url,$postData);
        return $postData;
    }

    /**
     *  群发消息视图
     */
    public function group(){
        //获取token
        $access_token=Wechat::getToken();
        // dd($access_token);
        //调用  获取标签接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token={$access_token}";
        // get获取标签
        $data=Curl::curlGet($url);
        // dd($data);
        $data=json_decode($data,true);
        
        $tag=[];
        foreach ($data as $key => $value) {
            $tag=$value;
        }
        // dd($tag);
        return view('fans/group',['tag'=>$tag]);
    }
    /**
     *  执行标签群发
     */
    public function groupDo(){
        $data=request()->all();
        $content=$data['group_cont'];
        $tag_id=$data['id'];

        //获取token
        $access_token=Wechat::getToken();
        //根据标签进行群发
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token={$access_token}";
        //图文消息
        $postData=[
            "filter"=>[
                "is_to_all"=>false,
                "tag_id"=>$tag_id
            ],
            "text"=>[
                "content"=>$content
            ],
            "msgtype"=>
                "text",
        ];
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        $postData=Curl::curlPost($url,$postData);
        dd($postData);
    }
    
}


