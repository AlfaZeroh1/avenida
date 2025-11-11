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
	$auth->roleid="8299";//Edit
}
else{
	$auth->roleid="8299";//Add
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
	$fields="prk_etransactions.Txnid, prk_etransactions.id, prk_etransactions.orig, prk_etransactions.dest, prk_etransactions.tstamp, prk_etransactions.details, prk_etransactions.username, prk_etransactions.pass, prk_etransactions.mpesa_code, prk_etransactions.mpesa_acc, prk_etransactions.mpesa_msisdn, prk_etransactions.mpesa_trx_date, prk_etransactions.mpesa_trx_time, prk_etransactions.mpesa_amt, prk_etransactions.mpesa_sender, prk_etransactions.updatecode, prk_etransactions.UpdateDateTime, prk_etransactions.dac_charge, prk_etransactions.council_amt, prk_etransactions.slot_id, prk_etransactions.Vehicle_Reg, prk_etransactions.Payment_mode";
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