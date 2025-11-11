<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Utilitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4165";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4163";//Add
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
	$utilitys=new Utilitys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$utilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$utilitys=$utilitys->setObject($obj);
		if($utilitys->add($utilitys)){
			$error=SUCCESS;
			redirect("addutilitys_proc.php?id=".$utilitys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$utilitys=new Utilitys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$utilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$utilitys=$utilitys->setObject($obj);
		if($utilitys->edit($utilitys)){
			$error=UPDATESUCCESS;
			redirect("addutilitys_proc.php?id=".$utilitys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$utilitys=new Utilitys();
	$where=" where id=$id ";
	$fields="em_utilitys.id, em_utilitys.name, em_utilitys.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$utilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$utilitys->fetchObject;

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
	
	
$page_title="Utilitys ";
include "addutilitys.php";
?>