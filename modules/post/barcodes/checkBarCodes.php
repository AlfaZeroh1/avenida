<?php
session_start();
require_once "../../../lib.php";
require_once "../../../DB.php";
require_once "Barcodes_class.php";

$db = new DB();

$obj = (object)$_GET;

$barcodes = new Barcodes();

$barcode = explode("=",$obj->barcode);
// // // // // // // // // // $obj->barcode =substr($barcode[0],0,-1);

$shps=$_SESSION['shpgraded'];
echo $barcodes->checkBarcodes($obj,"",$shps);

?>