<?php

namespace App\Rbac;

use Illuminate\Database\Eloquent\Model;

class AdminRoleModel extends Model
{
    
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'admin_role';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['admin_id','role_id'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
