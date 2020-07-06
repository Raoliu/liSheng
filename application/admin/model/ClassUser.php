<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/27
 * Time: 18:29
 */

namespace app\admin\model;


use think\Model;

class ClassUser extends Model
{

    public function searchNameAttr($query, $value)
    {
        if ($value) {
            $query->where('nick_name', 'like', '%' . $value . '%');
        }
    }

}