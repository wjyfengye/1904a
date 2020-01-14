<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class PowerModel extends Model
{
    public  $primaryKey="power_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'power';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['power_id','power_name','parent_id','power_url'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
