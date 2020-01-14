<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;//验证器
use Illuminate\Http\Request;
use App\Wechat\MenuModel;
use App\Tools\Wechat;
use App\Tools\Curl;
class MenuController extends Controller
{
    /**
     * 菜单视图
     */
   public function add(){
       $data=MenuModel::get()->toArray();
        // dd($data);
       return view('menu/add',['data'=>$data]);
   }
   /**
    * 菜单添加
    */
   public function addDo(Request $request){
    $validator = Validator::make($request->all(), [
        'menu_name' => 'required|unique:menu',
        'url' => 'required|unique:menu',
    ],
        [
        'menu_name.required'=>'菜单名称不能为空',
        'menu_name.unique'=>'菜单名称已存在',
        'url.required'=>'菜单标识不能为空',
        'url.unique'=>'菜单标识已存在',
        ]    
    );
        if ($validator->fails()) {
        return redirect('menu/add')
        ->withErrors($validator)
        ->withInput();
        }
       $data=request()->all();
       
       $reg='/^(http|https):\/\/([\w.]+\/?)\S*$/'; //验证网址
       if($data['menu_type']=='view'){
           if(!preg_match($reg,$data['url'])){
            echo "请填写正确菜单标识https://";exit;
           } 
       }
    //    dd($data);
       MenuModel::create($data);
       return redirect('menu/index');
   }
   /**
    *  菜单列表
    */
    public function index(){
        $menuData=MenuModel::where(['parent_id'=>0])->get()->toArray();
        // dd($menuData);
        $access_Token=Wechat::getToken();//获取access_token
        //调用 创建菜单接口  生成菜单
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_Token;
             
        $postData=[];
        $typeArr=['click'=>'key','view'=>'url'];
        foreach ($menuData as $k => $v) {
            if($v['menu_type']){//menu_type没值，表示没子菜单
                //没有子菜单
                $postData['button'][]=[
                    'type'=>$v['menu_type'],
                    'name'=>$v['menu_name'],
                    $typeArr[$v['menu_type']]=>$v['url']
                ];
               
            }else{
                //有子菜单
                $postData['button'][$k]=[
                    'name'=>$v['menu_name'],
                    'sub_button'=>[],
                ];
                 
                //根据1级菜单,查询该1级下的子菜单
                $childData=MenuModel::where(['parent_id'=>$v['menu_id']])->get()->toArray();
                // dd($childData);//查出的结果是一条数  循环放入一级下的sub_button中
                foreach ($childData as $key => $value) {
                    $postData['button'][$k]['sub_button'][]=[
                        'type'=>$value['menu_type'],
                        'name'=>$value['menu_name'],
                        $typeArr[$value['menu_type']]=>$value['url']
                    ];
                }
            }
        }
        // dd($postData);
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        // dd($postData);
        $res=Curl::curlPost($url,$postData);
        // dd($res);
        return view('menu/index',['menuData'=>$menuData]);
    }

}