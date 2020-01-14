<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Curl;
use App\Tools\Wechat;
use App\Wechat\WechatModel;
use App\Wechat\MediaModel;
use Illuminate\Support\Facades\Cache;
class WechatController extends Controller
{
    /**
     *  回复页
     */
    public function index(){
        return view('wechat.index');
    }

    /**
     *  添加
     */
    public function save(){
        return view('wechat.save');
    }
     /**
     *  回复添加
     */
    public function savedo(){
        $data=request()->all();
        // dd($data);
        if(empty($data['media_id'])){//如果素材库为空，执行添加
            if($data['wechat_type']=='image'){
                $wechat_image=request()->file('wechat_image');//添加的图片
                //如果上传文件不为空，将文件存入文件夹
                $ext=$wechat_image->getClientOriginalExtension();//获取后缀名
                $filename=md5(uniqid()).".".$ext;//随机生成文件名拼接后缀名
                // dd($filename);
                //将文件存入images文件夹中  文件的保存路径
                $data['wechat_image']=request()->wechat_image->storeAs("images",$filename);
                //调微信素材接口，传递素材到微信
                Wechat::uploadMidea($data['wechat_type'],$data['wechat_image']);
            }
        }
        //不为空，直接入库
        WechatModel::create($data);
        return redirect('wechat/list');
    }
    
    /**
     *  回复展示 
     */
    public function list(){
        $data=WechatModel::get();
        return view('wechat.list',['data'=>$data]);
    }

    /**
     * 修改
     */
    public function update($id){
        $data=WechatModel::where('is_show',1)->first();
        if(!$data){
            WechatModel::where('wechat_id',$id)->update(['is_show'=>1]);
        }else{
            WechatModel::where('is_show',1)->update(['is_show'=>2]);
            WechatModel::where('wechat_id',$id)->update(['is_show'=>1]);
        }
        return redirect('wechat/list');
    }

    /**
     *  ajax提交查询素材库
     */
    public function getMedia(){
        $data=MediaModel::where(['media_format'=>'image'])->get()->toArray();
        $data=json_encode($data);
        return $data;
    }
}
