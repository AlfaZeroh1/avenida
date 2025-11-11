<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tschedulesexpenses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2226";//Edit
}
else{
	$auth->roleid="2224";//Add
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
	$tschedulesexpenses=new Tschedulesexpenses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tschedulesexpenses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tschedulesexpenses=$tschedulesexpenses->setObject($obj);
		if($tschedulesexpenses->add($tschedulesexpenses)){
			$error=SUCCESS;
			redirect("addtschedulesexpenses_proc.php?id=".$tschedulesexpenses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tschedulesexpenses=new Tschedulesexpenses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tschedulesexpenses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tschedulesexpenses=$tschedulesexpenses->setObject($obj);
		if($tschedulesexpenses->edit($tschedulesexpenses)){
			$error=UPDATESUCCESS;
			redirect("addtschedulesexpenses_proc.php?id=".$tschedulesexpenses->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$tschedulesexpenses=new Tschedulesexpenses();
	$where=" where id=$id ";
	$fields="pos_tschedulesexpenses.id, pos_tschedulesexpenses.tscheduleid, pos_tschedulesexpenses.expenseid, pos_tschedulesexpenses.paidthru, pos_tschedulesexpenses.bankid, pos_tschedulesexpenses.chequeno, pos_tschedulesexpenses.amount, pos_tschedulesexpenses.remarks, pos_tschedulesexpenses.ipaddress, pos_tschedulesexpenses.createdby, pos_tschedulesexpenses.createdon, pos_tschedulesexpenses.lasteditedby, pos_tschedulesexpenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tschedulesexpenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tschedulesexpenses->fetchObject;

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
	
	
$page_title="Tschedulesexpenses ";
include "addtschedulesexpenses.php";
?>