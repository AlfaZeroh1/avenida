<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fetilizers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9094";//Edit
}
else{
	$auth->roleid="9094";//Add
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
	$fetilizers=new Fetilizers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fetilizers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fetilizers=$fetilizers->setObject($obj);
		if($fetilizers->add($fetilizers)){
			$error=SUCCESS;
			redirect("addfetilizers_proc.php?id=".$fetilizers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fetilizers=new Fetilizers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fetilizers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fetilizers=$fetilizers->setObject($obj);
		if($fetilizers->edit($fetilizers)){
			$error=UPDATESUCCESS;
			redirect("addfetilizers_proc.php?id=".$fetilizers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fetilizers=new Fetilizers();
	$where=" where id=$id ";
	$fields="prod_fetilizers.id, prod_fetilizers.name, prod_fetilizers.remarks, prod_fetilizers.status, prod_fetilizers.ipaddress, prod_fetilizers.createdby, prod_fetilizers.createdon, prod_fetilizers.lasteditedby, prod_fetilizers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fetilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fetilizers->fetchObject;

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
	
	
$page_title="Fetilizers ";
include "addfetilizers.php";
?>