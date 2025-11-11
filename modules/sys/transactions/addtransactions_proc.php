<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="162";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="160";//Add
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
	$transactions=new Transactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$transactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transactions=$transactions->setObject($obj);
		if($transactions->add($transactions)){
			$error=SUCCESS;
			redirect("addtransactions_proc.php?id=".$transactions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$transactions=new Transactions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$transactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transactions=$transactions->setObject($obj);
		if($transactions->edit($transactions)){
			$error=UPDATESUCCESS;
			redirect("addtransactions_proc.php?id=".$transactions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$transactions=new Transactions();
	$where=" where id=$id ";
	$fields="sys_transactions.id, sys_transactions.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$transactions->fetchObject;

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
	
	
$page_title="Transactions ";
include "addtransactions.php";
?>