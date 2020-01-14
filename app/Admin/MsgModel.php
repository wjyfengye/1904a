<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class MsgModel extends Model
{
    public  $primaryKey="msg_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'msg';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['msg_id','admin_id','code','expire_time'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;

}
