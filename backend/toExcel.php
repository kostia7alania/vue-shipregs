<?php

// redirect output to client browser 
require '../Classes/composer_kostia/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

$FIELDS = ["N пп","Название судна, длина","IMO", "Тип судна","Флаг", "Осадка","Надводный\nгабарит","Время\nначала\nдвиж.","Маршрут","Причал/якорная стоянка","Агентская компания","Лоцм. обеспечение","Груз","Примечание"];
$count_cols = count($FIELDS);//скок столбцов

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

 




/*
[ header: "1. ЗАХОД С МОРЯ", show: 0 },
{ header: "2. ВЫХОД В МОРЕ", show: 0 },
{ header: "3. ВНУТРИПОРТОВЫЕ ПЕРЕМЕЩЕНИЯ", show: 0 },
{ header: "4. ВЫХОД НА ВВП", show: 0 },
{ header: "5. ТРАНЗИТ НА ВВП", show: 0 },
{ header: "6. ЗАХОД С ВВП", show: 0 }*/

$arr = [
    '1. ЗАХОД С МОРЯ'               =>$response['first'],
    '2. ВЫХОД В МОРЕ'               =>$response['second'],
    '3. ВНУТРИПОРТОВЫЕ ПЕРЕМЕЩЕНИЯ' =>$response['third'],
    '4. ВЫХОД НА ВВП'               =>$response['fourth'],
    '5. ТРАНЗИТ НА ВВП'             =>$response['fifth'],
    '6. ЗАХОД С ВВП'                =>$response['sixth']
];
 

if( isset($_GET['port']) && strlen($_GET['port'])>0 ){$qr = <<<QUERY
    SELECT PortNameRus FROM [testDB].[dbo].[DictionaryPorts] where PortCode = '{$_GET['port']}'
QUERY;
    $stmt = goSql ($qr);
    $PortNameRus = iconv('windows-1251', 'UTF-8', odbc_fetch_array($stmt)['PortNameRus']); 
} else {  $PortNameRus = '_все_'; } //без названия порта пока пусть)) 


function addZero($n){
    return (int)$n<10 ? '0'.(int)$n : $n;
}



$reg = '/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/';  
$dt_from = $_GET['ed_DateFrom'];

$dt_from = new DateTime($dt_from);
$date    = new DateTime($dt_from);

$dt_from = $dt_from->format('d.m.Y'); 

$date->add(new DateInterval('P0Y1D'));//+ 1 day ! 
$data_zavtra =  $date->format('d.m.Y');
$dates = '   c '.addZero($_GET['HoursFrom']).':' . addZero($_GET['MinsFrom']) .' '. $dt_from . ' по '.$_GET['HoursTo'].':'.$_GET['MinsTo'] .' '. $data_zavtra;
$sheet->setCellValue('A1', "ГРАФИК\nрасстановки и движения судов в Морском порту $PortNameRus\n$dates"); 

$count_sections = 2; // разделы ---- >> N ROW!


$sheet->fromArray($FIELDS, NULL, "A$count_sections");//заголовки столбцов 
$sheet -> getStyle("A$count_sections:AA$count_sections") -> applyFromArray(['font' => ['bold'=>true]]); // выделяем жирным до АА+номер строки

$count_sections++;

//foreach($arr as $section_header=>$arr_arr) {foreach( $arr_arr as $date_row=>$v) {foreach($v as $k2=>$v2) {$count_cols = count($v2);break;}}$count_cols--;} // просто счетчик БЫЛ!!; ->чеб объединять столбцы разделов 
foreach($arr as $section_header=>$arr_arr) {
    
    $sheet->mergeCellsByColumnAndRow (1, $count_sections, $count_cols, $count_sections);//объединяем  1.Заход с моря и т.п. секции
    $sheet->setCellValue('A'.$count_sections, $section_header); //ставим данные типа 1.Заход с моря и т.п. секции
    $sheet -> getStyle('A'.$count_sections) -> applyFromArray(['font' => ['bold'=>true]]); //стилизация 1.Заход с моря и т.п. секции
    $sheet -> getStyle('A'.$count_sections) -> getAlignment()->setHorizontal('center');

    $count_sections++;//след строка

    foreach( $arr_arr as $arr_justDate=>$arr_date_arr) {// $arr_date_arr ===> Array ( [0] => Array ( [rShipName] => "sadads" [Length] => 148 [ShipTypeNameRus] => "asd"..
        //	24.12.2018 
        $sheet->mergeCellsByColumnAndRow( 1, $count_sections, $count_cols, $count_sections);
        $sheet->setCellValue('A'.$count_sections, $arr_justDate);
        $sheet -> getStyle('A'.$count_sections) -> applyFromArray(['font' => ['bold'=>true]]); //стили разделов дат - жирными
        $count_sections++;  
        $date_section_counter=1;
        
        
        foreach($arr_date_arr as $date_arr_val) { // $date_arr_val ===> Array ( [rShipName] => "значение", [Length] => 100.85, [ShipTypeNameRus] => "знач", ...)
            //print_r($date_arr_val); die;    //$date_arr_val ===>> Array ( [rShipName] =>  [Length] =>   [ShipTypeNameRus] =>  [CountryNameRus] => [HourMinute] =>   [DepositStern] => 6.12  =>    [Note] => [EntID] =>   [Draft] => 0 [DateEnter] => 10.01.2019 [CompanyName] =>  [Route] =>  [Terminal] =>   [NeedForEmerg] => --- [Enter_Cargo] => ) - 8200; [Enter_Cargo_Danger] => [FlagStatus] => 1 )
        

            $sheet->setCellValue( 'A'.$count_sections, $date_section_counter++);//поставили, увеличили;
            $sheet->setCellValue( 'B'.$count_sections, $date_arr_val['rShipName'].' ('.$date_arr_val['Length'].')' );
            $sheet->setCellValue( 'C'.$count_sections, $date_arr_val['IMO'] );
            $sheet->setCellValue( 'D'.$count_sections, $date_arr_val['ShipTypeNameRus'] );
            $sheet->setCellValue( 'E'.$count_sections, $date_arr_val['CountryNameRus'] );
            $sheet->setCellValue( 'F'.$count_sections, $date_arr_val['DepositStern'] );
            $sheet->setCellValue( 'G'.$count_sections, $date_arr_val['SurfaceDimension'] );
            $sheet->setCellValue( 'H'.$count_sections, $date_arr_val['HourMinute'] );
            $sheet->setCellValue( 'I'.$count_sections, $date_arr_val['Route'] );
            $sheet->setCellValue( 'J'.$count_sections, $date_arr_val['Terminal'] );
            $sheet->setCellValue( 'K'.$count_sections, $date_arr_val['CompanyName'] );
            $sheet->setCellValue( 'L'.$count_sections, $date_arr_val['NeedForEmerg'] ); 
            $sheet->setCellValue( 'M'.$count_sections, $date_arr_val['Enter_Cargo'] ); 
            $sheet->setCellValue( 'N'.$count_sections, $date_arr_val['Note'] ); 
            //$sheet->fromArray($v2, NULL, 'A'.$count_sections);
            
            if($count_sections%2==0){
            $sheet -> getStyle("A$count_sections:".getLastCoord($sheet, $count_cols, $count_sections) ) -> getFill()
                    -> setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    -> getStartColor()->setARGB('fafafa');
            }else{
                $sheet -> getStyle("A$count_sections:".getLastCoord($sheet, $count_cols, $count_sections) ) -> getFill()
                        -> setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        -> getStartColor()->setARGB('f5f5f5');                
            }
            $sheet -> getStyle("A$count_sections:".getLastCoord($sheet, $count_cols, $count_sections) ) -> applyFromArray([ //здесь - чтоб пропускать заголовки разделов! (не лефтировать"" их)  ));
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ]
            ]);
         
            $count_sections++;//увеличили строку;
        }
    }
}
 

//$sheet->getColumnDimensionByColumn(0)->setAutoSize(true);
$sheet->getColumnDimension('A')->setAutoSize(3);
/*$sheet->getColumnDimension('B')->setWidth(25); //ширина 1 столбца
$sheet->getColumnDimension('C')->setWidth(20); //ширина 1 столбца
$sheet->getColumnDimension('D')->setWidth(22);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(8); //ширина 1 столбца
$sheet->getColumnDimension('H')->setAutoSize(9); //ширина 1 столбца
$sheet->getColumnDimension('I')->setWidth(50); //ширина 1 столбца
$sheet->getColumnDimension('J')->setWidth(50); //ширина 1 столбца
$sheet->getColumnDimension('K')->setWidth(30); //ширина 1 столбца
$sheet->getColumnDimension('L')->setWidth(40); //ширина 1 столбца
$sheet->getColumnDimension('M')->setWidth(22); //ширина 1 столбца
*/


$wd = 15;

$sheet -> getPageSetup() -> setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet -> getPageSetup() -> setScale(57);

$sheet->getPageSetup()->setHorizontalCentered(true);
$sheet->getPageSetup()->setVerticalCentered(true);

$sheet->getColumnDimension('B')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('C')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('D')->setWidth($wd);
$sheet->getColumnDimension('E')->setWidth($wd);
$sheet->getColumnDimension('F')->setWidth($wd);
$sheet->getColumnDimension('G')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('H')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('I')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('J')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('K')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('L')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('M')->setWidth($wd); //ширина 1 столбца
$sheet->getColumnDimension('N')->setWidth($wd); //ширина 1 столбца

function getLastCoord ($sheet, $x, $y) {    //$i=1;foreach ($FIELDS as $header) {$lastCellAddress = $sheet->getCellByColumnAndRow($i, 2)->getCoordinate();$i++;}//echo $lastCellAddress;die;
    return $sheet->getCellByColumnAndRow($x, $y)->getCoordinate();//=>M1;
} 

$sheet->getStyle('A2:' . getLastCoord($sheet, $count_cols, 2) )  -> getFill() 
                                            -> setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                            -> getStartColor()->setARGB('00000000');


$sheet -> getStyle('A1:'.getLastCoord($sheet, $count_cols, 2) ) -> applyFromArray([
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ]
]);

$sheet -> getStyle('A2:' . getLastCoord($sheet, $count_cols, --$count_sections) ) -> applyFromArray([
    'borders' => [
        'outline' => [
            'borderStyle' =>  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000']
        ],
        'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => ['argb' => 'FFA0A0A0',],
                'endColor' => ['argb' => 'FFFFFFFF',],
        ],    
    ]
]);


foreach($sheet->getRowDimensions() as $rd) { 
    $rd->setRowHeight(-1);//автоматическая высота для всех строк!!
}

$sheet -> getStyle('B1:'.getLastCoord($sheet, $count_cols, $count_sections)) -> getAlignment()->setWrapText(true); // типа переносы запиливаем;
$sheet -> getStyle('A3:'.getLastCoord($sheet, $count_cols, $count_sections)) -> applyFromArray(['font' => ['size'=>10]]);
$sheet -> getStyle('A3:'.getLastCoord($sheet, $count_cols, $count_sections)) -> getAlignment()->setIndent(1);


$sheet -> getStyle('A1:' . getLastCoord($sheet, $count_cols, 2)) -> getAlignment()->setWrapText(true);
$sheet -> getStyle('A2:' . getLastCoord($sheet, $count_cols, 2)) -> getAlignment()->setWrapText(true); //заголовки столбцов
$sheet -> getRowDimension('1') -> setRowHeight(120); 
$sheet -> mergeCellsByColumnAndRow (1, 1, $count_cols, 1); //объединение ячеек;
 

 
$sheet -> getStyle('A1') -> applyFromArray(['font' => ['size'=>25, 'bold'=>true ]]);
$sheet -> getStyle('A2:'.getLastCoord($sheet, $count_cols, 2)) -> applyFromArray(['font' => ['color' => ['rgb'=>'FFFFFF']]]);
$sheet -> getRowDimension('2')->setRowHeight(-1); //указвыается только номер строки, без буквы!


//print_r(  $response ); 
//$sheet->fromArray( , NULL, 'A2');
//$sheet->setCellValue('A2', 'Hello World !');

$writer = new Xlsx($spreadsheet);
//$writer->save('График движения судов.xlsx');
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

header('Content-Type', 'application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="file.xlsx"');
header('Cache-Control','max-age=0');
$writer->save("php://output", 'xlsx');

function dump ($val) { echo "<pre>".print_r($val,1).'</pre>'; }

//var_dump($response['first']['24.12.2018']);*/
die;
?>