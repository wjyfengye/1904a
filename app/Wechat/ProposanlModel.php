<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class ProposanlModel extends Model
{
    public  $primaryKey="proposanl_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'proposanl';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['proposanl_id','proposanl_desc'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;

}
