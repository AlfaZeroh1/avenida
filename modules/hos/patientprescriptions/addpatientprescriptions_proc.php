<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientprescriptions_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../inv/items/Items_class.php");
require_once("../../hos/patienttreatments/Patienttreatments_class.php");
require_once("../../hos/payables/Payables_class.php");
require_once("../../hos/patienttreatments/Patienttreatments_class.php");
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';

//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->patienttreatmentid)){
  $obj->patienttreatmentid=$ob->patienttreatmentid;
}
$id=$_GET['id'];
$error=$_GET['error'];

	
if($obj->action=="Save"){
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	echo $obj->totals;
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientprescriptions=new Patientprescriptions();
		$patientprescriptions=setObject($obj);
		if($patientprescriptions->add($patientprescriptions)){
			$error=SUCCESS;
			
			$patienttreatments = new Patienttreatments();
			$fields="*";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id='$obj->patienttreatmentid'";
			$patienttreatments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$pat=$patienttreatments->fetchObject;
					
			$obj->transactionid=10;		
			$obj->patientid=$pat->id;
			$obj->treatmentno=$obj->patienttreatmentid;
			$obj->consult=1;
			$obj->paid="No";
			$obj->amount=$obj->quantity*$obj->price;
			$obj->invoicedon=date("Y-m-d");
			$obj->createdby=$_SESSION['userid'];
			$obj->createdon=date("Y-m-d H:i:s");
			$obj->lasteditedby=$_SESSION['userid'];
			$obj->lasteditedon=date("Y-m-d H:i:s");
			$obj->remarks = $obj->itemname;
			$payables = new Payables();
			$payables->setObject($obj);
			$payables->add($payables);
		
			redirect("addpatientprescriptions_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientprescriptions=new Patientprescriptions();
		$patientprescriptions=setObject($obj);
		if($patientprescriptions->edit($patientprescriptions)){
			
			$obj->transactionid=10;		
			$obj->patientid=$pat->id;
			$obj->treatmentno=$obj->patienttreatmentid;
			$obj->consult=1;
			$obj->paid="No";
			$obj->amount=$obj->quantity*$obj->price;
			$obj->invoicedon=date("Y-m-d");
			$obj->createdby=$_SESSION['userid'];
			$obj->createdon=date("Y-m-d H:i:s");
			$obj->lasteditedby=$_SESSION['userid'];
			$obj->lasteditedon=date("Y-m-d H:i:s");
			$obj->remarks = $obj->itemname;
			$payables = new Payables();
			$payables->setObject($obj);
			
			$where=" hos_payables.transactionid='$obj->transactionid' and hos_payables.treatmentno='$obj->treatmentno' and hos_payables.itemid='$obj->itemid' ";
			
			$payables->add($payables,$where);
			
			$obj="";
			
			
			$error=UPDATESUCCESS;
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if(!empty($id)){

	$patientprescriptions=new Patientprescriptions();
	$where=" where hos_patientprescriptions.id=$id ";
	$fields="hos_patientprescriptions.id, hos_patientprescriptions.itemid, inv_items.name itemname, hos_patientprescriptions.patienttreatmentid, hos_patientprescriptions.quantity, hos_patientprescriptions.price, hos_patientprescriptions.Totals, hos_patientprescriptions.issued, hos_patientprescriptions.createdby, hos_patientprescriptions.createdon, hos_patientprescriptions.lasteditedby, hos_patientprescriptions.lasteditedon";
	//$fields= "id, itemid, patienttreatmentid,quantity,price, (price*quantity) as Totals, issued, createdby, createdon, lasteditedby, lasteditedon";
	$join=" left join inv_items on inv_items.id=hos_patientprescriptions.itemid ";
	$having="";
	$groupby="";
	$orderby="";
	$patientprescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientprescriptions->fetchObject;
}

// should find this class Items????
if(empty($obj->action)){

	/*$items= new Items();
	$fields="hos_items.id, hos_items.code, hos_items.name, hos_items.manufacturer, hos_items.strength, hos_items.costprice, hos_items.discount, hos_items.tradeprice, hos_items.retailprice, hos_items.applicabletax, hos_items.reorderlevel, hos_items.quantity, hos_items.status, hos_items.expirydate, hos_items.createdby, hos_items.createdon, hos_items.lasteditedby, hos_items.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);*/


	$patienttreatments= new Patienttreatments();
	$fields="hos_patienttreatments.id, hos_patienttreatments.patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.observation, hos_patienttreatments.symptoms, hos_patienttreatments.diagnosis, hos_patienttreatments.treatedon, hos_patienttreatments.patientstatusid, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->itemid)){
		$error="itemid should be provided";
	}
	else if(empty($obj->patienttreatmentid)){
		$error="patienttreatmentid should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$patientprescriptions= new Patientprescriptions();
		$patientprescriptions->id=str_replace(',','',$obj->id);
		$patientprescriptions->itemid=str_replace(',','',$obj->itemid);
		$patientprescriptions->patienttreatmentid=str_replace(',','',$obj->patienttreatmentid);
		$patientprescriptions->quantity=str_replace(',','',$obj->quantity);
		$patientprescriptions->price=str_replace(',','',$obj->price);
		$patientprescriptions->totals=str_replace(',','',$obj->totals);
		$patientprescriptions->issued=str_replace(',','',$obj->issued);
		$patientprescriptions->createdby=str_replace(',','',$obj->createdby);
		$patientprescriptions->createdon=str_replace(',','',$obj->createdon);
		$patientprescriptions->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$patientprescriptions->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $patientprescriptions;
	
}
$page_title="Patientprescriptions";
include "addpatientprescriptions.php";
?>