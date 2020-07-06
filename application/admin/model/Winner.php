<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/27
 * Time: 11:40
 */

namespace app\admin\model;



use think\Model;

class Winner extends Model
{

    /**
     * 搜索器
     * @param $query
     * @param $value
     */
    public function searchNameAttr($query, $value)
    {
        if ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        }
    }

    public function comments()
    {
        return $this->hasMany('ClassGroup','class_id');
    }

    /**
     * 获取用户所属组
     * @param $value
     * @param $data
     * @return string
     */
    public function getClassUserAttr($value, $data)
    {
        $titles = Winner::where('Winner.class_id', '=', $data['class_id'])
            ->alias('Winner')
            ->join('class_user ClassUser', 'Winner.class_id = ClassUser.class_id')
            ->select();

        return json_decode($titles);
    }
}