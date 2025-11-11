<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Laboratorytestdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/laboratorytests/Laboratorytests_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8857";//Edit
}
else{
	$auth->roleid="8857";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->laboratorytestid))
  $obj->laboratorytestid=$ob->laboratorytestid;

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
	$laboratorytestdetails=new Laboratorytestdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$laboratorytestdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$laboratorytestdetails=$laboratorytestdetails->setObject($obj);
		if($laboratorytestdetails->add($laboratorytestdetails)){
			$error=SUCCESS;
			redirect("addlaboratorytestdetails_proc.php?id=".$laboratorytestdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$laboratorytestdetails=new Laboratorytestdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$laboratorytestdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$laboratorytestdetails=$laboratorytestdetails->setObject($obj);
		if($laboratorytestdetails->edit($laboratorytestdetails)){
			$error=UPDATESUCCESS;
			redirect("addlaboratorytestdetails_proc.php?id=".$laboratorytestdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$laboratorytests= new Laboratorytests();
	$fields="hos_laboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.charge, hos_laboratorytests.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$laboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$laboratorytestdetails=new Laboratorytestdetails();
	$where=" where id=$id ";
	$fields="hos_laboratorytestdetails.id, hos_laboratorytestdetails.laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$laboratorytestdetails->fetchObject;

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
	
	
$page_title="Laboratorytestdetails ";
include "addlaboratorytestdetails.php";
?>