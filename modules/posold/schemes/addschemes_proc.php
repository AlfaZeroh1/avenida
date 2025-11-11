<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Schemes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2214";//Edit
}
else{
	$auth->roleid="2212";//Add
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
	$schemes=new Schemes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$schemes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$schemes=$schemes->setObject($obj);
		if($schemes->add($schemes)){
			$error=SUCCESS;
			redirect("addschemes_proc.php?id=".$schemes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$schemes=new Schemes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$schemes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$schemes=$schemes->setObject($obj);
		if($schemes->edit($schemes)){
			$error=UPDATESUCCESS;
			redirect("addschemes_proc.php?id=".$schemes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$schemes=new Schemes();
	$where=" where id=$id ";
	$fields="pos_schemes.id, pos_schemes.name, pos_schemes.location, pos_schemes.description, pos_schemes.createdby, pos_schemes.createdon, pos_schemes.lasteditedby, pos_schemes.lasteditedon, pos_schemes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$schemes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$schemes->fetchObject;

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
	
	
$page_title="Schemes ";
include "addschemes.php";
?>