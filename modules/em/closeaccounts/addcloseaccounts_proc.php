<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Closeaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8469";//Edit
}
else{
	$auth->roleid="8467";//Add
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
	$closeaccounts=new Closeaccounts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$closeaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$closeaccounts=$closeaccounts->setObject($obj);
		if($closeaccounts->add($closeaccounts)){
			$error=SUCCESS;
			redirect("addcloseaccounts_proc.php?id=".$closeaccounts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$closeaccounts=new Closeaccounts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$closeaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$closeaccounts=$closeaccounts->setObject($obj);
		if($closeaccounts->edit($closeaccounts)){
			$error=UPDATESUCCESS;
			redirect("addcloseaccounts_proc.php?id=".$closeaccounts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$closeaccounts=new Closeaccounts();
	$where=" where id=$id ";
	$fields="em_closeaccounts.id, em_closeaccounts.plotid, em_closeaccounts.sttmtdate, em_closeaccounts.month, em_closeaccounts.year, em_closeaccounts.status, em_closeaccounts.ipaddress, em_closeaccounts.createdby, em_closeaccounts.createdon, em_closeaccounts.lasteditedby, em_closeaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$closeaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$closeaccounts->fetchObject;

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
	
	
$page_title="Closeaccounts ";
include "addcloseaccounts.php";
?>