<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class ChannelModel extends Model
{
    public  $primaryKey="channel_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'channel';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['channel_id','create_time','channel_name','channel_number','ticket','people'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
