<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Vacanthousereports_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4808";//Edit
}
else{
	$auth->roleid="4806";//Add
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
	
	
if($obj->action=="Save"){
	$vacanthousereports=new Vacanthousereports();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$vacanthousereports->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vacanthousereports=$vacanthousereports->setObject($obj);
		if($vacanthousereports->add($vacanthousereports)){
			$error=SUCCESS;
			redirect("addvacanthousereports_proc.php?id=".$vacanthousereports->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$vacanthousereports=new Vacanthousereports();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$vacanthousereports->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vacanthousereports=$vacanthousereports->setObject($obj);
		if($vacanthousereports->edit($vacanthousereports)){
			$error=UPDATESUCCESS;
			redirect("addvacanthousereports_proc.php?id=".$vacanthousereports->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$vacanthousereports=new Vacanthousereports();
	$where=" where id=$id ";
	$fields="em_vacanthousereports.id, em_vacanthousereports.houseid, em_vacanthousereports.vacatedon, em_vacanthousereports.remarks, em_vacanthousereports.status, em_vacanthousereports.createdby, em_vacanthousereports.createdon, em_vacanthousereports.lasteditedby, em_vacanthousereports.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vacanthousereports->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$vacanthousereports->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->status="pending";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Vacanthousereports ";
include "addvacanthousereports.php";
?>