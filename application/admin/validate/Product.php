<?php
/**
 * Created by PhpStorm.
 * User: yuandian
 * Date: 2016/9/9
 * Time: 15:39
 */

namespace app\admin\validate;

use think\Validate;

class Product extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',

    ];

    protected $message = [
        'name.require' => '产品名称不能为空',
        'name.length' => '产品名称长度2-25位',
    ];

}