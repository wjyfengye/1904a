<?php 

		if(file_exists('access_token')&&(time()-filemtime('access_token')<7200)){
			//file_exists  检测文件是否存在     filemtime检测文件创建时间    7200秒数
			$access_token=file_get_contents('access_token.txt');
		}else{
			$appID="wxc2b62abdef4c789b";
			$appsecret="da95073579f6918d1bec41c2ac3966d9";
			//调用接口
	        $data="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appID}&secret={$appsecret}";
	        //获取用户信息
	        $data=file_get_contents($data);//得到的是json串
	        $data=json_decode($data,true);//将json串转成数组
	        // var_dump($data);exit;
	        $access_token=$data['access_token'];
	        file_put_contents('access_token.txt', $access_token);//将获取的token 写入文件
		}
		 echo $access_token;

		 	// $userInfo="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid=OPENID&lang=zh_CN";

  
 ?>