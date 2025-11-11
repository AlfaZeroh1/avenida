<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Expensecategorys_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/expensetypes/Expensetypes_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2150";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="2148";//Add
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
	$expensecategorys=new Expensecategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$expensecategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$expensecategorys=$expensecategorys->setObject($obj);
		if($expensecategorys->add($expensecategorys)){
			$error=SUCCESS;
			redirect("addexpensecategorys_proc.php?id=".$expensecategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$expensecategorys=new Expensecategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$expensecategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$expensecategorys=$expensecategorys->setObject($obj);
		if($expensecategorys->edit($expensecategorys)){
			$error=UPDATESUCCESS;
			redirect("addexpensecategorys_proc.php?id=".$expensecategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$expensecategorys=new Expensecategorys();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$expensecategorys->fetchObject;

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
	
	
$page_title="Expensecategorys ";
include "addexpensecategorys.php";
?>