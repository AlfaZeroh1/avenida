<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../em/houses/Houses_class.php';

$houseid=$_GET['houseid'];
$paymenttermid = $_GET['paymenttermid'];

//connect to db
$db=new DB();
$aaData=array();

//when both paymentterm and house are provided
if((!empty($paymenttermid) and !empty($houseid))){
	//for rent or rent deposit
	if($paymenttermid==1 or $paymenttermid==2){
		$houses = new Houses();
		if($paymenttermid==1)
			$fields=" em_plots.vatclasseid, em_plots.commission mgtfee, em_plots.mgtfeevatclasseid ";
		else 
			$fields=" em_plots.depositmgtfeeperc mgtfee, em_plots.depositmgtfeevatclasseid mgtfeevatclasseid ";
		
		$where=" where em_houses.id='$houseid' ";
		$join=" left join em_plots on em_houses.plotid=em_plots.id ";
		$having="";
		$orderby="";
		$groupby="";
		$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$houses = $houses->fetchObject;
		$aaData['vatclasseid']=$houses->vatclasseid;
		$aaData['mgtfee']=$houses->mgtfee;		
		
	}	
}

echo json_encode( $aaData );
?>