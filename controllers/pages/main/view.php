<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 02/03/2015
 * Time: 9:27 PM
 */
echo 'Page Main works!';
//$record = new QdImage();
//$obj = $record->GETMAX('order');
//$record->order= 5;
//echo $record->GETMAX('order', true);

//$obj = QdProduct::GET(75);
//var_dump($obj->getImages()->GETLIST()[0]->path);//OK

$record = new QdImage();
$record->SETRANGE('model', 'QdProduct');
$record->SETRANGE('model_id', 75);
$list = $record->GETLIST();

var_dump($list);
?>