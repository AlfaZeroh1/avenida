<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Banks_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="741";//Edit
}
else{
	$auth->roleid="739";//Add
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
	$banks=new Banks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$banks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$banks=$banks->setObject($obj);
		if($banks->add($banks)){

			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name." Bank ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$banks->id;
			$obj->acctypeid=8;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);

			$error=SUCCESS;
			redirect("addbanks_proc.php?id=".$banks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$banks=new Banks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$banks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$banks=$banks->setObject($obj);
		if($banks->edit($banks)){

			//updating corresponding general journal account
			$name=$obj->name;
			$obj->name=$name." Bank ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$banks->id;
			$obj->acctypeid=8;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$banks->id' and acctypeid='8' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);

			$error=UPDATESUCCESS;
			redirect("addbanks_proc.php?id=".$banks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$banks=new Banks();
	$where=" where id=$id ";
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$banks->fetchObject;

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
	
	
$page_title="Banks ";
include "addbanks.php";
?>