<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/23
 * Time: 11:53
 */

namespace app\admin\service;


use app\admin\model\Product;
use app\admin\traits\Result;
use think\facade\Request;

class ProductService
{

    /**
     * Notes:添加商品
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/23
     * Time: 17:11
     * @param $data
     * @return array|string
     */
    public static function add($data)
    {
        //验证数据合法性
        $validate = validate('product');
        if (!$validate->scene('add')->check($data)) {
            //令牌数据无效时重置令牌
            $validate->getError() != '令牌数据无效' ? $token = Request::token() : $token = '';
            $msg = Result::error($validate->getError(), null, ['token' => $token]);
            return $msg;
        }
        $product = new Product();

        $product->name = $data['name'];
        $product->image = $data['image_url'];
        $product->price = $data['price'];
        $product->new_price = $data['new_price'];
        $product->detail = $data['detail'];
        $product->create_at = date('Y-m-d H:i:s',time());
        $res = $product->save();
            if ($res) {
                $msg = Result::success('添加成功', url('/admin/productList'));
            } else {
                $msg = Result::error('添加失败', null, ['token' => Request::token()]);
            }
        return $msg;
    }

    /**
     * 编辑商品
     * @param $data
     * @return array|string
     * @author 原点 <467490186@qq.com>
     * @throws \Exception
     */
    public static function edit($data)
    {
        $userdata = [
            'name' => $data['name'],
            'image' => $data['image_url'],
            'price' => $data['price'],
            'new_price' => $data['new_price'],
            'detail' => $data['detail'],
        ];
        $res = Product::update($userdata, ['id' => $data['id']]);
            if ($res) {
                $msg = Result::success('编辑成功', url('/admin/productList'));
            } else {
                $msg = Result::error('编辑失败');
            }

        return $msg;
    }

    /**
     * Notes:删除商品
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/23
     * Time: 17:12
     * @param $id
     * @return array|string
     */
    public static function delete($id)
    {
        if (!$id) {
            return Result::error('参数错误');
        }

        $res = Product::destroy($id);
        if ($res) {
            $msg = Result::success('删除成功');
        } else {
            $msg = Result::error('删除失败');
        }
        return $msg;
    }
}