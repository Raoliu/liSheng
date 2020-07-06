<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/27
 * Time: 11:42
 */

namespace app\admin\model;


use think\Model;

class ClassGroup extends Model
{

    public function article()
    {
        return $this->belongsTo('Winner');
    }


}