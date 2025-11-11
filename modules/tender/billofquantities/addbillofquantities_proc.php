<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Billofquantities_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/tenders/Tenders_class.php");
require_once("../../tender/unitofmeasures/Unitofmeasures_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7781";//Edit
}
else{
	$auth->roleid="7779";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$billofquantities=new Billofquantities();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$billofquantities->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$billofquantities=$billofquantities->setObject($obj);
		if($billofquantities->add($billofquantities)){
			$error=SUCCESS;
			redirect("addbillofquantities_proc.php?id=".$billofquantities->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$billofquantities=new Billofquantities();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$billofquantities->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$billofquantities=$billofquantities->setObject($obj);
		if($billofquantities->edit($billofquantities)){
			$error=UPDATESUCCESS;
			redirect("addbillofquantities_proc.php?id=".$billofquantities->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tenders= new Tenders();
	$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tenders.tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, tender_tenders.employeeid, tender_tenders.statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$unitofmeasures= new Unitofmeasures();
	$fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$billofquantities=new Billofquantities();
	$where=" where id=$id ";
	$fields="tender_billofquantities.id, tender_billofquantities.tenderid, tender_billofquantities.bqitem, tender_billofquantities.quantity, tender_billofquantities.unitofmeasureid, tender_billofquantities.bqrate, tender_billofquantities.remarks, tender_billofquantities.ipaddress, tender_billofquantities.createdby, tender_billofquantities.createdon, tender_billofquantities.lasteditedby, tender_billofquantities.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$billofquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$billofquantities->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Billofquantities ";
include "addbillofquantities.php";
?>