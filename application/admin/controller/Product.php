<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/23
 * Time: 9:52
 */

namespace app\admin\controller;

use app\admin\model\Product as ProductModel;
use app\admin\service\ProductService;

class Product extends Common
{
    /**
     * Notes:商品列表页
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/23
     * Time: 11:49
     * @return mixed|void
     * @throws \think\exception\DbException
     */
    public function productList(){
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = ProductModel::withSearch(['name'], ['name' => $data['key']])
                ->paginate($data['limit'], false, ['query' => $data]);

            $product_date = [];
            foreach ($list as $key => $val) {
                $product_date[$key] = $val;
            }

            return show($product_date, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }

    /**
     * Notes:添加/编辑商品
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/23
     * Time: 16:44
     * @return array|mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function productEdit(){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($data['id']) {
                //编辑
                $res = ProductService::edit($data);
                return $res;
            } else {
                //添加
                $data = ProductService::add($data);
                return $data;
            }
        } else {
            $id = $this->request->get('id', 0, 'intval');
            if ($id) {
                $list = ProductModel::where('id', '=', $id)->find();
                $this->assign('list', $list);
            }

            return $this->fetch();
        }
    }

    /**
     * Notes:删除产品
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/23
     * Time: 17:11
     * @return array|string
     */
    public function productDelete(){
        $id = $this->request->param('id', 0, 'intval');
        if ($id) {

                $res = ProductService::delete($id);
                return $res;
        } else {
            $this->error('参数错误');
        }
    }
}