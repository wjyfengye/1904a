<?php

namespace App\Rbac;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    public  $primaryKey="role_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'role';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['role_id','role_name'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
