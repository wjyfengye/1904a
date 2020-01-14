<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class WechatUserModel extends Model
{
    public  $primaryKey="wechat_user_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'wechat_user';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['wechat_user_id','openid','nickname','sex','city','channel_number','is_del'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
