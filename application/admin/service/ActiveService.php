<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/23
 * Time: 11:53
 */

namespace app\admin\service;


use app\admin\model\Active;
use app\admin\traits\Result;
use think\facade\Request;

class ActiveService
{

    /**
     * Notes:添加活动
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
        $active = new Active();

        $active->name = $data['name'];
        $active->image = $data['image_url'];
        $active->type = $data['type'];
        $active->product_id = $data['product_id'];
        $active->product_name = $data['product_name'];
        $active->start_time = $data['start_time'];
        $active->end_time = $data['end_time'];
        $active->probability = $data['probability'];
        $active->create_at = date('Y-m-d H:i:s',time());
        $res = $active->save();
            if ($res) {
                $msg = Result::success('添加成功', url('/admin/activeList'));
            } else {
                $msg = Result::error('添加失败', null, ['token' => Request::token()]);
            }
        return $msg;
    }

    /**
     * Notes:编辑活动
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/24
     * Time: 10:58
     * @param $data
     * @return array|string
     */
    public static function edit($data)
    {
        $userdata = [
            'name' => $data['name'],
            'image' => $data['image_url'],
            'type' => $data['type'],
            'product_id'=>$data['product_id'],
            'product_name'=>$data['product_name'],
            'start_time'=>$data['start_time'],
            'end_time'=>$data['end_time'],
            'probability'=>$data['probability']
        ];
        $res = Active::update($userdata, ['id' => $data['id']]);
            if ($res) {
                $msg = Result::success('编辑成功', url('/admin/activeList'));
            } else {
                $msg = Result::error('编辑失败');
            }

        return $msg;
    }

    /**
     * Notes:删除活动
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

        $res = Active::destroy($id);
        if ($res) {
            $msg = Result::success('删除成功');
        } else {
            $msg = Result::error('删除失败');
        }
        return $msg;
    }
}