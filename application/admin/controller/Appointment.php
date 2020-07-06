<?php
/**
 * Created by PhpStorm.
 * User: 北辰兰绪
 * Email: Ming.Zhou@connext.com.cn
 * Date: 2020/5/28
 * Time: 12:12
 */

namespace app\admin\controller;

use app\admin\model\Appointment as AppointmentModel;
use PHPExcel;

class Appointment extends Common
{
    /**
     * Notes:首页
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/28
     * Time: 12:39
     * @return mixed|void
     * @throws \think\exception\DbException
     */
    public function index(){
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = AppointmentModel::withSearch(['name'], ['name' => $data['key']])
                ->paginate($data['limit'], false, ['query' => $data]);

            $appointment_date = [];
            foreach ($list as $key => $val) {
                $appointment_date[$key] = $val;
            }

            return show($appointment_date, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }

    /**
     * Notes:导出
     * User: 北辰兰绪
     * Email: Ming.Zhou@connext.com.cn
     * Date: 2020/5/28
     * Time: 12:37
     * @param $id
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function expload()
    {
        $data = [
            'key' => $this->request->get('key', '', 'trim'),
            'limit' => $this->request->get('limit', 10, 'intval'),
        ];
        $list = AppointmentModel::withSearch(['name'], ['name' => $data['key']])->select();

        foreach ($list as $key =>$item){
            switch ($item['type']){
                case 1:
                    $list[$key]['type_name'] = '上门勘察';
                    break;
                case 2:
                    $list[$key]['type_name'] = '方案设计';
                    break;
                case 3:
                    $list[$key]['type_name'] = '水路定位';
                    break;
                case 4:
                    $list[$key]['type_name'] = '安装调试';
                    break;
                case 5:
                    $list[$key]['type_name'] = '维护保养';
                    break;
                default:
                    $list[$key]['type_name'] = '上门勘察';
            }
        }
        //这里引入PHPExcel文件注意路径修改

        $objExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F,G,H");
        $arrHeader = array('ID','类型','用户昵称','用户openid','用户头像','手机号','用户邮箱','用户地址');
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        };
        foreach($list as $k=>$v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k, $v['id']);
            $objActSheet->setCellValue('B'.$k, $v['type_name']);
            $objActSheet->setCellValue('C'.$k, $v['nick_name']);
            $objActSheet->setCellValue('D'.$k, $v['openid']);
            $objActSheet->setCellValue('E'.$k, $v['head_image']);
            $objActSheet->setCellValue('F'.$k, $v['tel']);
            $objActSheet->setCellValue('G'.$k, $v['email']);
            $objActSheet->setCellValue('H'.$k, $v['address']);
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
        $objActSheet->getColumnDimension('H')->setWidth($width[5]);

        $outfile = "预约用户表.xls";
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