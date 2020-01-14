<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wechat\ProposanlModel;
use App\Wechat\MediaModel;
use App\Wechat\ChannelModel;
use App\Wechat\WechatUserModel;
use App\Tools\Wechat; //引入调用的封装类
use App\Tools\Curl;
use App\Wechat\WechatModel;

class IndexController extends Controller
{
    public $sgarray=[
        '张飞','吕布','关羽','诸葛亮','黄忠','赵云','辣根'
    ];

    public function index(Request $request){  
   
        echo $str=$request->echostr;exit;
        if($this->checkSignature($request)){//云服务器绑定微信服务器接口url
            echo $request->echostr;
        }else{
            echo 'error';
        }
    }

   
    /**
     * 验签
     */
    private function checkSignature($request){
        $signature = $request->signature;
        $timestamp = $request->timestamp;
        $nonce = $request->nonce;
        $token = env('WEITOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);  //字典排序
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );   //加密
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 回复微信信息
     */
    public function reponseMsg(){
      
        //接受从微信服务器POST过来的xml数据
        //php版本 >= 7.0
        $postStr=file_get_contents("php://input");
        //echo $postStr;exit;
        //将接到的数据写入文件
        file_put_contents('wxlog.txt',$postStr);
        //处理xml格式的数据， 将xml格式的数据 转换xml格式的对象
        $postObj=simplexml_load_string($postStr,"SimpleXMLELement",LIBXML_NOCDATA);
        //谁给我发的
        $FromUserName=$postObj->FromUserName;
        //我是谁
        $ToUserName=$postObj->ToUserName;
        // dd($ToUserName);
        //发送时间
        $Time=time();
        /**
         *  判断推送事件，不是消息
         */  
        if($postObj->MsgType =='event'){
            //判断是关注事件
            if($postObj->Event =='subscribe'){
                //当用户关注后  如果是渠道关注，统计关注数量  先得到渠道标识
                $channel_number=$postObj->EventKey;
                // dd($channel_number);
                $channel_number=ltrim($channel_number,'qrscene_');
                // dd($channel_number);
                //获取用户基本信息 调用UnionID机制接口
                $userInfo=Wechat::getUserInfo($postObj->FromUserName);
                // dd($userInfo);
                $nickname=$userInfo['nickname'];
                // dd($nickname);
                if(!empty($channel_number)){//如果渠道号不为空 ,表示曾经关注过  
                    //执行用户状态修改
                    WechatUserModel::where(['openid'=>$postObj->FromUserName])->update(['is_del'=>1]);
                }else{
                    $channel_number='100';
                    WechatUserModel::create([
                        'nickname'=>$nickname,
                        'openid'=>$userInfo['openid'],
                        'sex'=>$userInfo['sex'],
                        'city'=>$userInfo['city'],
                        'channel_number'=>$channel_number
                    ]);   
        
                };

                //将数据库关注数量自增
                ChannelModel::where(['channel_number'=>$channel_number])->increment('people',1);
        
                $res=WechatModel::where('is_show',1)->first()->toArray();
                if($res['wechat_type']=='text'){
                    //回复文本
                    if($userInfo['sex']==1){
                        $msg="欢迎".$nickname."帅哥,".$res['wechat_cont'];
                    }else if($userInfo['sex']==2){
                        $msg="欢迎".$nickname."美女,".$res['wechat_cont'];
                    }else{
                        $msg="欢迎".$nickname.",".$res['wechat_cont'];
                    }
                    Wechat::responseText($msg,$postObj);exit;
                }else{
                    //回复图片
                    Wechat::responseImg($postObj,$res['media_id']);exit;
                }
            }
            
        }

        /**
         * 取消关注事件，做关注数量自减
         */
        if($postObj->MsgType =='event' && $postObj->Event =='unsubscribe'){
            //$postObj->FromUserName	用户OpenID
            //取关 能根据openid 获取渠道号  数据库中取
            $userInfo=WechatUserModel::where(['openid'=>$postObj->FromUserName])->first()->toArray();
            $channel_number=$userInfo['channel_number'];
            ChannelModel::where(['channel_number'=>$channel_number])->decrement('people');
            WechatUserModel::where(['openid'=>$postObj->FromUserName])->update(['is_del'=>2]);exit;
        };

        // 判断用户发送消息
        if($postObj->MsgType=='text'){
            $Content=$postObj->Content;
            if($Content=='1'){
                $msg=implode(',',$this->sgarray);
                Wechat::responseText($msg,$postObj);exit;//Tools类封装了发送方法
            }else if($Content=='2'){   
                $n=array_rand($this->sgarray);
                $msg=$this->sgarray[$n];
                Wechat::responseText($msg,$postObj);exit;//Tools类封装了发送方法
            }else if(mb_strpos($Content,'天气')!==false){
                $city=rtrim($Content,'天气');
                if(empty($city)){
                    $city='北京';
                }
                //调用K780天气接口
                $msg=Wechat::getWeather($city);
                Wechat::responseText($msg,$postObj);exit;
            }else if(mb_strpos($Content,"建议+")!==false){

                $str=ltrim($Content,"建议+");
                //将建议内容入库
                ProposanlModel::create(['proposanl_desc'=>$str]);
                 $msg="建议已收到";
                Wechat::responseText($msg,$postObj);exit;
            }
        }
        //RpRP19rnDNBRExcRvBHeVvuU7WzDgNfkkp3CyhGBWRZdgb0fr029zf_aRpiiJH9c
        //用户发送图片
        if($postObj->MsgType=='image'){
            $mediaData=MediaModel::where('media_format','image')->inRandomOrder()->first();
            // dd($mediaData);
            $MediaId=$mediaData['wechat_media_id'];
            Wechat::responseImg($postObj,$MediaId);exit;
        }

    }

    /** 
     * 测试
     */
    public function test(){
        //调用接口地址
        // $url="http://api.k780.com/?app=weather.future&weaid=1&&appkey=46450&sign=af74aeea77b69fe71f80eda34f717d28&format=json";
        // $data=file_get_contents($url);//读取文件  也可读取地址
        // // dd($data);
        // $data=json_decode($data,true);  //读取的是json格式，将json转成数组
        // // dd($data);
        // $msg="";
        // foreach($data['result'] as $k=>$v){
        //     $msg .=$v['days'].$v['week'].$v['citynm'].$v['weather'].$v['temperature']."\n";
        // }
        // var_dump($msg);
        $Content="天气";
        if(mb_strpos($Content,'天气')!==false){//mb_strpos 检测中文字符串在另一个字符出现的次数
            $city=rtrim($Content,'天气');
            if(empty($city)){
                $city='北京';
            }
            echo $city;exit;
        }else{
            echo "没有天气";exit;
        }
    } 

    /**
     * 素材接口  上传图片
     */
    public function sucai(){
        //获取token
       $access_token= Wechat::getToken();
        //调用上传临时素材接口地址
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
        //上传图片
        $img="/data/wwwroot/default/1904a/storage/download/meinv.jpg";
        $postData['media']=new \CURLFile($img);
        // var_dump($postData);
        //post方式提交
        $res=Curl::curlPost($url,$postData);
        var_dump($res);
    }
}
  