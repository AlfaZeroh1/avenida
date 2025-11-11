<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Materialcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7793";//Edit
}
else{
	$auth->roleid="7791";//Add
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
	$materialcategorys=new Materialcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$materialcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$materialcategorys=$materialcategorys->setObject($obj);
		if($materialcategorys->add($materialcategorys)){
			$error=SUCCESS;
			redirect("addmaterialcategorys_proc.php?id=".$materialcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$materialcategorys=new Materialcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$materialcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$materialcategorys=$materialcategorys->setObject($obj);
		if($materialcategorys->edit($materialcategorys)){
			$error=UPDATESUCCESS;
			redirect("addmaterialcategorys_proc.php?id=".$materialcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$materialcategorys=new Materialcategorys();
	$where=" where id=$id ";
	$fields="con_materialcategorys.id, con_materialcategorys.name, con_materialcategorys.remarks, con_materialcategorys.ipaddress, con_materialcategorys.createdby, con_materialcategorys.createdon, con_materialcategorys.lasteditedby, con_materialcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$materialcategorys->fetchObject;

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
	
	
$page_title="Materialcategorys ";
include "addmaterialcategorys.php";
?>