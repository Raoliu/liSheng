<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/23
 * Time: 23:48
 */

namespace app\admin\model;


use think\Model;
use think\model\concern\SoftDelete;

class Active extends Model
{
    use SoftDelete;
    protected $pk = 'id';
    protected $deleteTime = 'delete_time';
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
}