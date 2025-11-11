<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Etransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8233";//Edit
}
else{
	$auth->roleid="8231";//Add
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
	$etransactions=new Etransactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$etransactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$etransactions=$etransactions->setObject($obj);
		if($etransactions->add($etransactions)){
			$error=SUCCESS;
			redirect("addetransactions_proc.php?id=".$etransactions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$etransactions=new Etransactions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$etransactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$etransactions=$etransactions->setObject($obj);
		if($etransactions->edit($etransactions)){
			$error=UPDATESUCCESS;
			redirect("addetransactions_proc.php?id=".$etransactions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$etransactions=new Etransactions();
	$where=" where id=$id ";
	$fields="fn_etransactions.Txnid, fn_etransactions.id, fn_etransactions.orig, fn_etransactions.dest, fn_etransactions.tstamp, fn_etransactions.details, fn_etransactions.username, fn_etransactions.pass, fn_etransactions.mpesa_code, fn_etransactions.mpesa_acc, fn_etransactions.mpesa_msisdn, fn_etransactions.mpesa_trx_date, fn_etransactions.mpesa_trx_time, fn_etransactions.mpesa_amt, fn_etransactions.mpesa_sender, fn_etransactions.updatecode, fn_etransactions.UpdateDateTime, fn_etransactions.dac_charge, fn_etransactions.council_amt, fn_etransactions.slot_id, fn_etransactions.Vehicle_Reg";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$etransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$etransactions->fetchObject;

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
	
	
$page_title="Etransactions ";
include "addetransactions.php";
?>