<?php

namespace controllers;

use application\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Impressao
 *
 * @author sam
 */
class Impressao extends Controller {

    //put your code here
    private $impressao;

    public function __construct() {
        $this->impressao = $this->LoadModelo('Destino');
    }

    public function index() {
        
    }

    public function impressao() {

        $objPHPExcel = new \PHPExcel();

        $results = $this->impressao->listagem();
//        print"<pre>" .var_dump($results); "<br /><pre>";
//        exit;
        $objPHPExcel->getProperties()->setCreator('iStyle')
                ->setTitle('Relatorio');
        $i = 2;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Inventory. ' )
                ->setCellValue('G1', 'RELATORIO DATA CENTER')
                ->mergeCells('A3:H3')
                ->setCellValue('A' . $i, 'Rack.')
                ->setCellValue('B' . $i, 'Patchpanel')
                ->setCellValue('C' . $i, 'Equipamento')
                ->setCellValue('D' . $i, 'Cabo')
                ->setCellValue('E' . $i, 'Dimensions')
                ->setCellValue('F' . $i, 'Qty Available');



        $i = 3;
                for ($d = 0; $d < count($results); $d++) {

            $objPHPExcel->getActiveSheet()
                    ->setCellValue('A' . $i, $results[$d]['cabos']['cor'])
                    ->setCellValue('B' . $i, $results[$d]['tipo'])
                    ->setCellValue('C' . $i, $results[$d]['descricao'])
                    ->setCellValue('D' . $i, $results[$d]['patchpanel']['nome']);
            $i++;
        }

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        exit;
    }

}
