<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/23
 * Time: 18:23
 */

namespace app\admin\controller;
use app\admin\model\Active as ActiveModel;
use app\admin\model\ClassGroup;
use app\admin\model\ClassUser as ClassUserModel;
use app\admin\model\Winner as WinnerModel;
use app\admin\service\ActiveService;
use app\admin\model\Product as ProductModel;
use PHPExcel;
class Active extends Common
{

    /**
     * Notes:活动列表
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/24
     * Time: 10:47
     * @return mixed|void
     * @throws \think\exception\DbException
     */
    public function activeList(){
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = ActiveModel::withSearch(['name'], ['name' => $data['key']])
                ->paginate($data['limit'], false, ['query' => $data]);

            $active_date = [];
            foreach ($list as $key => $val) {
                $active_date[$key] = $val;
            }

            return show($active_date, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }

    /**
     * Notes:编辑
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/27
     * Time: 11:35
     * @return array|mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function activeEdit(){
        if ($this->request->isPost()) {
            $data = $this->request->post();

            if ($data['id']) {
                //编辑
                $res = ActiveService::edit($data);
                return $res;
            } else {
                //添加
                $data = ActiveService::add($data);
                return $data;
            }
        } else {
            $id = $this->request->get('id', 0, 'intval');
            if ($id) {
                $list = ActiveModel::where('id', '=', $id)->find();
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
    public function activeDelete(){
        $id = $this->request->param('id', 0, 'intval');
        if ($id) {

            $res = ActiveService::delete($id);
            return $res;
        } else {
            $this->error('参数错误');
        }
    }

    /**
     * Notes:产品页展示
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/26
     * Time: 11:12
     * @return mixed
     */
    public function product(){
        return $this->fetch();
    }

    /**
     * Notes:选择产品
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/26
     * Time: 11:13
     * @throws \think\exception\DbException
     */
    public function selectJson(){

        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = ProductModel::withSearch(['name'], ['name' => $data['key']])
                ->paginate($data['limit'], false, ['query' => $data]);

            $active_date = [];
            foreach ($list as $key => $val) {
                $active_date[$key] = $val;
            }

            return show($active_date, 0, '', ['count' => $list->total()]);
        }
    }

    public function winner(){
        $this->assign('id',$this->request->get('id'));
        return $this->fetch();
    }

    public function winnerList(){

        $data = [
            'key' => $this->request->get('key', '', 'trim'),
            'limit' => $this->request->get('limit', 10, 'intval'),
        ];

        $where = [
            'active_id'=>$this->request->get('id'),
            'is_winning'=>1
        ];
        $winner = WinnerModel::where($where)->select();

        $winner_ids = array_column(json_decode($winner),'class_id');

        $user = ClassUserModel::withSearch(['name'], ['nick_name' => $data['key']])
            ->whereIn('class_id',$winner_ids)
            ->paginate($data['limit'], false, ['query' => $data]);

        $user_date = [];
        foreach ($user as $key => $val) {
            $user_date[$key] = $val;
        }

        return show($user_date, 0, '', ['count' => $user->total()]);
    }


    /**
     * Notes:导出
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/28
     * Time: 12:38
     * @param $id
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function expload($id)
    {
        $data = [
            'key' => $this->request->get('key', '', 'trim'),
        ];

        $where = [
            'active_id'=>$id,
            'is_winning'=>1
        ];
        $winner = WinnerModel::where($where)->select();

        $winner_ids = array_column(json_decode($winner),'class_id');

        $user = ClassUserModel::withSearch(['name'], ['nick_name' => $data['key']])
            ->whereIn('class_id',$winner_ids)
            ->select();

        //这里引入PHPExcel文件注意路径修改

        $objExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F,G");
        $arrHeader = array('ID','用户昵称','用户openid','用户头像','手机号','用户邮箱','用户地址');
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        };
        foreach($user as $k=>$v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['id']);
            $objActSheet->setCellValue('B'.$k, $v['nick_name']);
            $objActSheet->setCellValue('C'.$k, $v['openid']);
            $objActSheet->setCellValue('D'.$k, $v['head_image']);
            $objActSheet->setCellValue('E'.$k, $v['tel']);
            $objActSheet->setCellValue('F'.$k, $v['email']);
            $objActSheet->setCellValue('G'.$k, $v['address']);
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
        $width = array(20,20,15,10,10,30,10,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth($width[3]);
        $objActSheet->getColumnDimension('B')->setWidth($width[1]);
        $objActSheet->getColumnDimension('C')->setWidth($width[0]);
        $objActSheet->getColumnDimension('D')->setWidth($width[5]);
        $objActSheet->getColumnDimension('E')->setWidth($width[5]);
        $objActSheet->getColumnDimension('F')->setWidth($width[5]);
        $objActSheet->getColumnDimension('G')->setWidth($width[5]);

        $outfile = "用户表.xls";
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');    //这里直接导出文件

    }


}