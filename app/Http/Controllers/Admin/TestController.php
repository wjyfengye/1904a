<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wechat\MediaModel;
use App\Tools\Wechat;
use App\Tools\Curl;
class TestController extends Controller
{
    /**
     * 渠道测试
     */
    public function index(){
        $access_token=Wechat::getToken();
        $postData='{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "视频推广"}}}';
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
        // dd($postData);
        $res=Curl::curlPost($url,$postData);
        $res=json_decode($res,true);
        dd($res['ticket']);
    }

    /**
     * 自定义菜单测试
     */
    public function test(){
        $access_token=Wechat::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $postData=[
            'button'=>[
                [
                    'type'=>'click',
                    'name'=>'今日歌曲',
                    'key'=>'男人海洋'           
                ],
                [
                    'name'=>'二级菜单',
                    'sub_button'=>[
                        [
                        'type'=>'view',
                        'name'=>'京东',
                        'url'=>'http://www.jd.com/'
                        ],
                        [
                        'type'=>'view',
                        'name'=>'后台首页',
                        'url'=>'http://49.235.152.169/admin/index'
                        ]
                    ]
                ],
                [
                    'name'=>'搜索菜单',
                    'sub_button'=>[
                        [
                        'type'=>'view',
                        'name'=>'百度搜索',
                        'url'=>'http://www.baidu.com/'
                        ],
                        [
                        'type'=>'view',
                        'name'=>'天气查询',
                        'url'=>'http://49.235.152.169/admin/weather'
                        ]
                    ]
                ],
            ]
        ];
        //将数据转成json格式, 参数二 不转义unicode格式  微信
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        $data=Curl::curlPost($url,$postData);
        
    }

    /**
     *  登录验证码
     */
    public function login(){
        $access_token=Wechat::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
        $data=[
                "touser"=>'oQmvfv1Y_HAL8ZcWQqM5v9v3lxsY',
                'template_id'=>'6_hGMLechC7i-xos0VvCRniCdou2-XDXMLtryRF2EZg',
                "data"=>[
                        "name"=>[
                            "value"=>"傻灯儿",
                            "color"=>"#173177"
                            ],
                        "code"=>[
                            "value"=>"250250",
                            "color"=>"#173177"
                            ]
                        ]
              ];
          
        
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $res=Curl::curlPost($url,$data);
        dd($res);
    }

    /**
     *  网页授权
     */
    public function authTest(){
        //发起微信授权，获取用户信息
        //第一步  用户同意授权，获取code
        $redirect_uri=urlEncode('http://wjy.maikk.top/test/auth');//回调地址
        //调用 授权接口   静默授权不需要用户确认  使用scope=snsapi_base  非静默使用scope=snsapi_userinfo 
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc2b62abdef4c789b&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    //    dd($url);
        header("location:".$url);//header 函数，跳转
    }

    /**
     * 授权回调
     */
    public function auth(){
        //第二步  根据code换取access_token
        $code=request()->code;//授权后接受code， 根据code换取access_token，这里的token不是封装的token
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxc2b62abdef4c789b&secret=da95073579f6918d1bec41c2ac3966d9&code={$code}&grant_type=authorization_code";
        $data=Curl::curlGet($url);//获取的json数据
        $data=json_decode($data,true);//将json数据转换为数组格式
        $access_token=$data['access_token'];//提取token
        $openid=$data['openid'];//提取openid
        // dd($data);
        
        //非静默授权   就是用户点击确认授权   非静态需要在第一步授权时配置  scope =snsapi_userinfo
        $SilencecUrl="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $info=Curl::curlGet($SilencecUrl);
        $info=json_decode($info,true);
        dd($info);
    }
}