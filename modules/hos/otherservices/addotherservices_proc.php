<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Otherservices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/departments/Departments_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1325";//Edit
}
else{
	$auth->roleid="1323";//Add
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
	$otherservices=new Otherservices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$otherservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$otherservices=$otherservices->setObject($obj);
		if($otherservices->add($otherservices)){
			$error=SUCCESS;
			redirect("addotherservices_proc.php?id=".$otherservices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$otherservices=new Otherservices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$otherservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$otherservices=$otherservices->setObject($obj);
		if($otherservices->edit($otherservices)){
			$error=UPDATESUCCESS;
			redirect("addotherservices_proc.php?id=".$otherservices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$otherservices=new Otherservices();
	$where=" where id=$id ";
	$fields="hos_otherservices.id, hos_otherservices.name, hos_otherservices.departmentid, hos_otherservices.charge,hos_otherservices.nssfcharge,  hos_otherservices.createdby, hos_otherservices.createdon, hos_otherservices.lasteditedby, hos_otherservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$otherservices->fetchObject;

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
	
	
$page_title="Otherservices ";
include "addotherservices.php";
?>