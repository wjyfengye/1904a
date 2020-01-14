<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    public  $primaryKey="admin_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'admin';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['admin_name','admin_pwd','admin_id','openid'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;

}
