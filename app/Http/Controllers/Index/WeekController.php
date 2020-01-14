<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;  //引入封装类中的方法
use App\Wechat\MediaModel;
use App\Wechat\ProposanlModel;
class WeekController extends Controller
{
    //
    public function index(Request $request){
        // echo "1111";
        // $str=$request->echostr;
        //接受xml数据
        $xmlStr=file_get_contents("php://input");
        file_put_contents('wechat.txt',$xmlStr);
        // echo $xmlStr;
        //
        $xmlObj=simplexml_load_string($xmlStr,"SimpleXMLELement");
        // dd($xmlObj);
        //判读是否是关注事件
        if($xmlObj->MsgType=='event'&&$xmlObj->Event=='subscribe'){
            $getToken= Wechat::getToken();
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$getToken."&openid=".$xmlObj->FromUserName."&lang=zh_CN";
            $userInfo=file_get_contents($url);
            // dd($userInfo);
            $userInfo=json_decode($userInfo,true);
            // dump($userInfo);
            $nickname=$userInfo['nickname'];
            if($userInfo['sex']=='1'){
                $msg="欢迎 ".$nickname."帅哥,  关注公众测试号!";
            }else{
                $msg="欢迎 ".$nickname."美女,  关注公众测试号!";
            }
            Wechat::responseText($msg,$xmlObj);
        }
        
        //判断用户发送的消息
        if($xmlObj->MsgType=='text'){
            $Content=$xmlObj->Content;
            if($Content==1){
                $msg="你好";
                Wechat::responseText($msg,$xmlObj);
            }elseif(mb_strpos($Content,"建议+")!==false){

                $str=ltrim($Content,"建议+");
                //将建议内容入库
                ProposanlModel::create(['proposanl_desc'=>$str]);
                 $msg="建议已收到";
                Wechat::responseText($msg,$xmlObj);
            }
        }
        
    }

    public function curl(){
        $url="https://www.baidu.com/";
        //初始化: curl_init
        // $ch=curl_init();
        // //设置: curl_setopt
        // curl_setopt($ch,CURLOPT_URL,$url);//请求地址
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回数据格式
        // //RETURN 返回   TRANSFER格式   1是以数据的方式返回  不设置1，就会将数据直接抛给浏览器输出
        
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);//对认证证书来源的检查   如果是https网站 时设置
        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//从证书中检测SLL加密算法是否存在  如果是https网站 时设置
       
        // //执行  curl_exec
        // $result=curl_exec($ch);
        // //关闭释放  curl_close
        // curl_close($ch);
        // var_dump($result);
        // $data=Crul::curlPost($url,'aaa');//调用类中封装的Post请求
        $data=$this->curlPost($url,'aa');
        var_dump($data);exit;
    }
    /**
     * curlGet请求方法
     */
    public function curlGet($url){
        //初始化: curl_init
        $ch=curl_init();
        //设置: curl_setopt
        curl_setopt($ch,CURLOPT_URL,$url);//请求地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回数据格式
        //RETURN 返回   TRANSFER格式   1是以数据的方式返回  不设置1，就会将数据直接抛给浏览器输出
        
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);//对认证证书来源的检查   如果是https网站 时设置
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//从证书中检测SLL加密算法是否存在  如果是https网站 时设置
       
        //执行  curl_exec
        $result=curl_exec($ch);
        //关闭释放  curl_close
        curl_close($ch);
        return $result;
    }
    /**
     * curlPost请求方法
     */
    public function curlPost($url,$postData){
        //初始化: curl_init
        $ch=curl_init();
        //设置: curl_setopt
        curl_setopt($ch,CURLOPT_URL,$url);//请求地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回数据格式
        //RETURN 返回   TRANSFER格式   1是以数据的方式返回  不设置1，就会将数据直接抛给浏览器输出
        
        curl_setopt($ch, CURLOPT_POST, 1);//提交post方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);//post提交数据
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //设置自动重定向  POST请求报302重定向
        //访问https网站时，关闭ssl验证
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);//对认证证书来源的检查   如果是https网站 时设置
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//从证书中检测SLL加密算法是否存在  如果是https网站 时设置
    
        //执行  curl_exec
        $result=curl_exec($ch);
        //关闭释放  curl_close
        curl_close($ch);
        return $result;
    }

    /**
     *  第三次周考
     *  查询天气
     */
    public function threeWeeks(){
        // $str=request()->echostr;
        //接受xml格式数据
        $xmlStr=file_get_contents("php://input");
        // echo $xmlStr;exit;
        // dd($xmlStr);
        file_put_contents('three.txt',$xmlStr);
        // 将xml数据转换成xml对象
        $postObj=simplexml_load_string($xmlStr,"SimpleXMLELement",LIBXML_NOCDATA);
        // dd($postObj);
        $openid=$postObj->FromUserName;
        
        //判断类型并且是关注事件
        if($postObj->MsgType=='event'&&$postObj->Event=='subscribe'){
            //调用接口，获取token
            $access_token= Wechat::getToken();
            //根据token获取用户信息
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            //发送请求
            $url=$this->curlGet($url);
            $userInfo=json_decode($url,true);
            //  调用封装方法回复文本信息
            $nickname=$userInfo['nickname'];
            if($userInfo['sex']=='1'){
                $msg="欢迎 ".$nickname."帅哥,  关注公众测试号!";
            }else{
                $msg="欢迎 ".$nickname."美女,  关注公众测试号!";
            }
            Wechat::responseText($msg,$postObj);
        }

        //判断用户发消息时
        if($postObj->MsgType=='text'){
            $Content=$postObj->Content;
            if($Content=='1'){
                $msg="王亚濛";
            }else if($Content=='2'){
                $MediaId="XCGt_yMyEJ1gzewIalAr6l8oxsuGZoAvq0b0-KVQREyxRVvgirHLYm4ZmeBDjXvB";
                //调用回复图片接口   封装方法
                Wechat::responseImg($postObj,$MediaId);exit;
            }
            Wechat::responseText($msg,$postObj);
        }
        
        //判断用户是点击事件
        if($postObj->MsgType=='event'&&$postObj->Event=='CLICK'){
            //如果点击天气
            if($postObj->EventKey=='weather'){
                //调用天气接口，，get提交
                $url="http://api.k780.com/?app=weather.today&weaid=1&appkey=46450&sign=af74aeea77b69fe71f80eda34f717d28&format=json";
                $data=$this->curlGet($url);
                $data=json_decode($data,true);//json对象格式转换成数组
                //将查到的实时数据，传给微信模板
                //获取token
                $access_token=Wechat::getToken();
                $openid=(string)$postObj->FromUserName;
                //发送模板消息
                $modelUrl="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
                // dd($modelUrl);
                $modelData=[
                        "touser"=>$openid,
                        'template_id'=>'iy1QJ5AZ_bpbAHZf0hxrLBaQeguVp-Gf1mbG7wTEj9E',//微信模板id
                        "data"=>[
                                "citynm"=>[
                                    "value"=>$data['result']['citynm'],
                                    "color"=>"#173177"
                                    ],
                                "days"=>[
                                    "value"=>$data['result']['days'],
                                    "color"=>"#173177"
                                    ],
                                "week"=>[
                                    "value"=>$data['result']['week'],
                                    "color"=>"#173177"
                                    ],
                                "temperature"=>[
                                    "value"=>$data['result']['temperature'],
                                    "color"=>"#173177"
                                     ],
                                "weather"=>[
                                    "value"=>$data['result']['weather'],
                                    "color"=>"#173177"
                                    ]
                                ]
                    ];
                //将数据转成json格式，
                $modelData=json_encode($modelData,JSON_UNESCAPED_UNICODE);
                // dd($data);//传给微信
                $res=$this->curlPost($modelUrl,$modelData);
            }
        }
    }

    //个人中心
    public function personal(){
       
        //网页授权，获取openid
        $openid=Wechat::getOpenid();
        //调用接口，获取token
        $access_token= Wechat::getToken();
        //根据token获取用户信息
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        //发送请求
        $url=$this->curlGet($url);
        $userInfo=json_decode($url,true);
        // dd($userInfo);
        return view('week/perList',['userInfo'=>$userInfo]);
    }

    
    
}
