<?php

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

class Product extends Model
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
