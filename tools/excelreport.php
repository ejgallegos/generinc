<?php
require_once "common/libs/PHPExcel.php";


class ExcelReport extends View {
  public $estilo_titulo = "";
  public $estilo_titulo_reporte = "";
  public $estilo_titulo_columnas = "";
  public $estilo_informacion = "";
  public $abecedario = array("C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

  function extraer_informe_conjunto($subtitulo, $array_exportacion) {
    date_default_timezone_set('America/Mexico_City');
    if (PHP_SAPI == 'cli') die('Este archivo solo se puede ver desde un navegador web');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("EDELAR S.A.") 
                                 ->setLastModifiedBy("EDELAR S.A.") 
                                 ->setTitle("Informes TonKa")
                                 ->setSubject("Informes TonKa")
                                 ->setDescription("Informes TonKa")
                                 ->setKeywords("informes TonKa")
                                 ->setCategory("Informes TonKa");
    
    $tituloReporte = "TonKa - EDELAR S.A.";
    $tituloWeb = $tituloReporte;
    $titulosColumnas = array_shift($array_exportacion);
    $cantidadColumnas = count($titulosColumnas);
    $cantidadColumnas = $cantidadColumnas - 1;
    $ultimaLetraPosicion = "";
    $this->estilo();

    foreach ($this->abecedario as $clave=>$valor) {
      if ($clave <= $cantidadColumnas) {
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("{$valor}4",  $titulosColumnas[$clave]);
        $ultimaLetraPosicion = $valor;
      }
    }

    $objPHPExcel->setActiveSheetIndex(0)
                ->setShowGridlines(false)
                ->mergeCells("B1:{$ultimaLetraPosicion}1")
                ->setCellValue("B1", $tituloReporte)
                ->mergeCells("B2:{$ultimaLetraPosicion}2")
                ->setCellValue("B2", $subtitulo);

    $l = 5;
    $breack_row_temp = '';
    $breack_row_ant = '';
    $color_temp = 'second_info_style';  
    foreach ($array_exportacion as $registro) {
      foreach ($registro as $clave=>$valor) {
        $color = $registro[1];
        $breack_row_temp = ($registro[0] != '') ? $registro[0] : $breack_row_temp; 
        $posicion = $this->abecedario[$clave].$l; 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($posicion, $registro[$clave]);
        if ($breack_row_temp == $breack_row_ant) {
          $objPHPExcel->getActiveSheet()->setSharedStyle($this->$color_temp, "C{$l}:{$ultimaLetraPosicion}{$l}");
        } else {
          $color_temp = ($color_temp == 'second_info_style') ? "first_info_style" : "second_info_style";
          $objPHPExcel->getActiveSheet()->setSharedStyle($this->$color_temp, "C{$l}:{$ultimaLetraPosicion}{$l}");
          $breack_row_ant = $breack_row_temp;
        }
        
      }
      $l++;
    }

    //print_r($array_exportacion);exit;
    $celdas_titulos = "C4:{$ultimaLetraPosicion}4";
    $celdas_informacion = "C5:{$ultimaLetraPosicion}".($l-1);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($this->estilo_titulo);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($this->estilo_titulo);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($this->estilo_subtitulo);

    //ALTOS Y ANCHOS
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(2);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(300);
    
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(32);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(53);
    
    foreach ($this->abecedario as $clave=>$valor) {
      if ($clave <= $cantidadColumnas) $objPHPExcel->getActiveSheet()->getStyle("{$valor}4")->applyFromArray($this->estilo_titulo_columnas);
    }

    //$objPHPExcel->getActiveSheet()->setSharedStyle($this->estilo_informacion, "{$celdas_informacion}");
    $objPHPExcel->getActiveSheet()->setTitle("Informes TonKa");
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,5);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="informes_TonKa.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
  }

  /* ESTILO DE EXCEL */
  function estilo() {
    
    $this->estilo_titulo = array(
                            'font'=>array(
                                'name'=>'Bookman Old Style',
                                'bold'=>true,
                                'size'=>17,
                                'color'=>array('rgb'=>'FFFFFF')),
                            'fill'=>array(
                                'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                'color'=>array('rgb' => '635C50')),
                            'alignment'=>array(
                                'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER) );
    
    $this->estilo_subtitulo = array(
                                    'font'=>array(
                                        'name'=>'Bookman Old Style',
                                        'size'=>28,
                                        'color'=>array('rgb' => 'A69E91')),
                                    'fill'=>array(
                                        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                        'color'=>array('rgb' => 'FFFFFF')), 
                                    'alignment'=>array(
                                        'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                        'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER) );

    $this->estilo_titulo_legajo = array(
                                    'font'=>array(
                                        'name'=>'Arial',
                                        'size'=>9,
                                        'bold'=>false,
                                        'color'=>array('rgb' => '635C50')),
                                    'fill'=>array(
                                        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                        'color'=>array('rgb' => 'FFFFFF')), 
                                    'alignment'=>array(
                                        'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                        'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER));

    $this->estilo_legajo = array(
                                    'font'=>array(
                                        'name'=>'Arial',
                                        'size'=>10,
                                        'bold'=>true,
                                        'color'=>array('rgb' => '808080')),
                                    'fill'=>array(
                                        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                        'color'=>array('rgb' => 'FFFFFF')), 
                                    'alignment'=>array(
                                        'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                        'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER));
    
    $this->estilo_titulo_columnas = array(
                                      'font'=>array(
                                          'name'=>'Arial',
                                          'size'=>8,
                                          'bold'=>false,                          
                                          'color'=>array('rgb'=>'FFFFFF')),
                                      'fill'=>array(
                                          'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                          'rotation'=>90,
                                          'color'=>array('rgb' => '635C50')),
                                      'borders'=>array(
                                          'top'=>array(
                                              'style'=>PHPExcel_Style_Border::BORDER_MEDIUM,
                                              'color'=>array('rgb' => 'FFFFFF')),
                                          'bottom'=>array(
                                              'style'=>PHPExcel_Style_Border::BORDER_MEDIUM,
                                              'color'=>array('rgb' => 'FFFFFF'))),
                                      'alignment' =>  array(
                                          'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                          'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER) );

    $this->first_info_style = new PHPExcel_Style();
    $this->first_info_style->applyFromArray(
                            array(
                              'font'=>array(
                                  'name'=>'Arial',               
                                  'size'=>9,               
                                  'color'=>array('rgb'=>'635C50')),
                              'fill'=>array(
                                  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                  'color'=>array('rgb'=>'E8E7EF')),
                              'borders'=>array(
                                  'allborders'=>array(
                                      'style'=>PHPExcel_Style_Border::BORDER_THIN,
                                      'color'=>array('rgb' => 'FFFFFF')))) );

    $this->second_info_style = new PHPExcel_Style();
    $this->second_info_style->applyFromArray(
                            array(
                              'font'=>array(
                                  'name'=>'Arial',               
                                  'size'=>9,               
                                  'color'=>array('rgb'=>'635C50')),
                              'fill'=>array(
                                  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                                  'color'=>array('rgb'=>'D9D9D9')),
                              'borders'=>array(
                                  'allborders'=>array(
                                      'style'=>PHPExcel_Style_Border::BORDER_THIN,
                                      'color'=>array('rgb' => 'FFFFFF')))) );
  }
}

function ExcelReport() { return new ExcelReport(); }
?>