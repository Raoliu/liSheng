<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/23
 * Time: 12:03
 */

namespace app\admin\controller;


class Flie extends Common
{
    /**
     * Notes:普通图片上传
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/28
     * Time: 11:54
     */
    public function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '../public/uploads');
        if($info){
            // 成功上传后 获取上传信息

            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            return show($info->getSaveName(), 0, '');
        }else{
            // 上传失败获取错误信息
            return show($file->getError(), 1, '上传失败');
        }
    }

    /**
     * Notes:富文本框图片上传
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/28
     * Time: 11:55
     */
    public function textUpload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '../public/uploads');
        if($info){
            // 成功上传后 获取上传信息

            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            return show($_SERVER['HTTP_HOST'].'/uploads/'.$info->getSaveName(), 0, '');
        }else{
            // 上传失败获取错误信息
            return show($file->getError(), 1, '上传失败');
        }
    }
}