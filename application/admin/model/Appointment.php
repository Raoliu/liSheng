<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/28
 * Time: 12:17
 */

namespace app\admin\model;


use think\Model;

class Appointment extends Model
{
    /**
     * 搜索器
     * @param $query
     * @param $value
     */
    public function searchNameAttr($query, $value)
    {
        if ($value) {
            $query->where('nick_name', 'like', '%' . $value . '%');
        }
    }
}