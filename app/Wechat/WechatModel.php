<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class WechatModel extends Model
{
    public  $primaryKey="wechat_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'wechat';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['wechat_id','wechat_cont','wechat_image','wechat_type','media_id'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
