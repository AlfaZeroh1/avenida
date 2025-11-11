<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../em/houses/Houses_class.php';

$houseid=$_GET['houseid'];
$paymenttermid = $_GET['paymenttermid'];

//connect to db
$db=new DB();

//when both paymentterm and house are provided
if((!empty($paymenttermid) and !empty($houseid))){
	//for rent or rent deposit
	
		$houses = new Houses();
		$fields=" em_houses.amount ";
		
		$where=" where em_houses.id='$houseid' ";
		$join="  ";
		$having="";
		$orderby="";
		$groupby="";
		$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$houses = $houses->fetchObject;
		
	}	

echo $houses->amount;
?>