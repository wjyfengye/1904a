<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wechat\MediaModel;
use App\Tools\Wechat;
use App\Tools\Curl;
class MediaController extends Controller
{
    /**
     * 素材添加视图
     */
    public function save(){
        return view('media/save');
    }

    /**
     *  执行添加
     */
    public function saveDo(){
        //文件
        $postData=request()->input();
        // dd($postData);
        //文件上传 
        $media_file=request()->file('media_file');
        if(!request()->hasFile('media_file')){
            echo "没有文件被上传";exit;
        } 
        // reuqest()->file->store('images');//后缀名laravel自己猜测，有时与文件不符
        $ext=$media_file->getClientOriginalExtension();//获取后缀名
        $filename=md5(uniqid()).".".$ext;//随机生成文件名拼接后缀名
        //将文件存入images文件夹中  文件的保存路径
        $img=request()->media_file->storeAs("images",$filename);
        
        //调微信素材接口，传递素材到微信
        $wechat_media_id=Wechat::uploadMidea($postData['media_format'],$img);
        //入库
        MediaModel::create([
            "media_name"=>$postData['media_name'],
            "media_format"=>$postData['media_format'],
            "media_type"=>$postData['media_type'],
            "wechat_media_id"=>$wechat_media_id,
            "media_file"=>$img
        ]);
        return redirect('media/list');
    }
    /**
     * 素材展示
     */
    public function list(){
        $search=request()->all();
        $where=[];
        if(!empty($search)){
            if($search['media_format']=='图片'){
                $where[]=['media_format','image'];
            }
            if($search['media_format']=='音乐'){
                $where[]=['media_format','voice']; 
            }
            if($search['media_format']=='视频'){
                $where[]=['media_format','video'];
            }
           
        }
            $mediaInfo=MediaModel::where($where)->paginate(3);
            // dd($mediaInfo);
        return view('media/list',['mediaInfo'=>$mediaInfo,'search'=>$search]);
    }
    
}
