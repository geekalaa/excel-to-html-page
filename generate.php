<?php
require_once dirname(__FILE__) . '/phpexcel/Classes/PHPExcel/IOFactory.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('session.cache_limiter', 'nocache');

clearstatcache();
function ExceltoArray($file) {
    $sheet = PHPExcel_IOFactory::load($file)->getActiveSheet();
    $highestRow = $sheet->getHighestRow();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
    $excelData = array();
    $column_names = array();

    for ($col = 0; $col < $highestColumnIndex; ++$col) {
       array_push($column_names, $sheet->getCellByColumnAndRow($col, 1)->getValue());
    }
    // convert to key value pair array 
    for ($row = 2; $row <= $highestRow; ++$row) {
        $row_array = array();
        for($col = 0; $col < $highestColumnIndex; ++$col) {
            $row_array[$column_names[$col]] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
        }
        array_push($excelData, $row_array);
    }
    
    return $excelData;
}

clearstatcache();
      // display all files in directory 
      clearstatcache();
        $files = scandir(dirname(__FILE__) . '/excel/');
        clearstatcache();
        $files = array_diff($files, array('.', '..'));
        $files = array_values($files);
        $number =0;
        for($i = 0; $i < count($files); $i++) {
            $json = json_encode(ExceltoArray('excel/' . $files[$i]), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            //get file name without extension
            $File_name = pathinfo($files[$i], PATHINFO_FILENAME);
            // read the content of a file into a string and replace substring and save it to a new file 
            $content = file_get_contents("template.html");
            $content = str_replace('"############################"', $json, $content);
            file_put_contents('data-web/'.$File_name.'.html', $content, FILE_APPEND);
            $number++;
        }
        echo 'converted ' . $number . ' files / generated php files';
        echo '<meta http-equiv="refresh" content="3; url=index.php">';