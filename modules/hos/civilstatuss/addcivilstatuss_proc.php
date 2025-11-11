<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Civilstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4487";//Edit
}
else{
	$auth->roleid="4487";//Add
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
	$civilstatuss=new Civilstatuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$civilstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$civilstatuss=$civilstatuss->setObject($obj);
		if($civilstatuss->add($civilstatuss)){
			$error=SUCCESS;
			redirect("addcivilstatuss_proc.php?id=".$civilstatuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$civilstatuss=new Civilstatuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$civilstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$civilstatuss=$civilstatuss->setObject($obj);
		if($civilstatuss->edit($civilstatuss)){
			$error=UPDATESUCCESS;
			redirect("addcivilstatuss_proc.php?id=".$civilstatuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$civilstatuss=new Civilstatuss();
	$where=" where id=$id ";
	$fields="hos_civilstatuss.id, hos_civilstatuss.name, hos_civilstatuss.remarks, hos_civilstatuss.createdby, hos_civilstatuss.createdon, hos_civilstatuss.lasteditedby, hos_civilstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$civilstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$civilstatuss->fetchObject;

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
	
	
$page_title="Civilstatuss ";
include "addcivilstatuss.php";
?>