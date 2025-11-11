<?php
 
   require_once 'Image/Barcode.php';
   /* Data that will be encoded in the bar code */
   $bar_code_data = $_GET['bctext'];
   $barcodetext = $_GET['text'];
   
   $ob = (object)$_GET;
   
   if(empty($ob->font))
    $ob->font=7;
 
   /* The third parameter can accept any from the following,
    * jpg, png and gif.
    */
   Image_Barcode2::draw($ob->font,$bar_code_data,$barcodetext, 'code128', 'png',true,60,1);
 
 ?>