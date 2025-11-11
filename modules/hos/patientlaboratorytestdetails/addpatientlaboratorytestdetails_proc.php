<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientlaboratorytestdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patientlaboratorytests/Patientlaboratorytests_class.php");
require_once("../../hos/laboratorytestdetails/Laboratorytestdetails_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8861";//Edit
}
else{
	$auth->roleid="8861";//Add
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
	$patientlaboratorytestdetails=new Patientlaboratorytestdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$patientlaboratorytestdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientlaboratorytestdetails=$patientlaboratorytestdetails->setObject($obj);
		if($patientlaboratorytestdetails->add($patientlaboratorytestdetails)){
			$error=SUCCESS;
			redirect("addpatientlaboratorytestdetails_proc.php?id=".$patientlaboratorytestdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$patientlaboratorytestdetails=new Patientlaboratorytestdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$patientlaboratorytestdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientlaboratorytestdetails=$patientlaboratorytestdetails->setObject($obj);
		if($patientlaboratorytestdetails->edit($patientlaboratorytestdetails)){
			$error=UPDATESUCCESS;
			redirect("addpatientlaboratorytestdetails_proc.php?id=".$patientlaboratorytestdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$patientlaboratorytests= new Patientlaboratorytests();
	$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, hos_patientlaboratorytests.patientid, hos_patientlaboratorytests.patienttreatmentid, hos_patientlaboratorytests.laboratorytestid, hos_patientlaboratorytests.charge, hos_patientlaboratorytests.results, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$laboratorytestdetails= new Laboratorytestdetails();
	$fields="hos_laboratorytestdetails.id, hos_laboratorytestdetails.laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$patientlaboratorytestdetails=new Patientlaboratorytestdetails();
	$where=" where id=$id ";
	$fields="hos_patientlaboratorytestdetails.id, hos_patientlaboratorytestdetails.patientlaboratorytestid, hos_patientlaboratorytestdetails.laboratorytestdetailid, hos_patientlaboratorytestdetails.result, hos_patientlaboratorytestdetails.remarks, hos_patientlaboratorytestdetails.ipaddress, hos_patientlaboratorytestdetails.createdby, hos_patientlaboratorytestdetails.createdon, hos_patientlaboratorytestdetails.lasteditedby, hos_patientlaboratorytestdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientlaboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientlaboratorytestdetails->fetchObject;

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
	
	
$page_title="Patientlaboratorytestdetails ";
include "addpatientlaboratorytestdetails.php";
?>