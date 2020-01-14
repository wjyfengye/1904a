<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    public  $primaryKey="menu_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'menu';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['menu_id','menu_name','menu_type','url','parent_id'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
