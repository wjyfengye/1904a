<?php

namespace App\Wechat;

use Illuminate\Database\Eloquent\Model;

class MediaModel extends Model
{
    public  $primaryKey="media_id";
    /**
     * 关联到模型的数据表@var string
     */
    protected $table = 'media';
    /**
     * 可以被批量赋值的属性. @var array
     */
    protected $fillable = ['media_id','media_name','wechat_media_id','media_file','media_format','media_type'];
    /**
     * 表明模型是否应该被打上时间戳 @var bool
     */
    public $timestamps = false;
}
