<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Incomes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="765";//Edit
}
else{
	$auth->roleid="763";//Add
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
	$incomes=new Incomes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$incomes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$incomes=$incomes->setObject($obj);
		if($incomes->add($incomes)){
		
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name." Income ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$incomes->id;
			$obj->acctypeid=1;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);

			$obj->name=$name." Prepaid Income ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$incomes->id;
			$obj->acctypeid=2;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);

			$obj->name=$name." Accrued Income ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$incomes->id;
			$obj->acctypeid=3;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$error=SUCCESS;
			redirect("addincomes_proc.php?id=".$incomes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$incomes=new Incomes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$incomes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$incomes=$incomes->setObject($obj);
		if($incomes->edit($incomes)){
			$error=UPDATESUCCESS;
			redirect("addincomes_proc.php?id=".$incomes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$incomes=new Incomes();
	$where=" where id=$id ";
	$fields="fn_incomes.id, fn_incomes.name, fn_incomes.code, fn_incomes.remarks, fn_incomes.ipaddress, fn_incomes.createdby, fn_incomes.createdon, fn_incomes.lasteditedby, fn_incomes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$incomes->fetchObject;

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
	
	
$page_title="Incomes ";
include "addincomes.php";
?>