<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Countrys_class.php");
require_once("../../crm/continents/Continents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9001";//Edit
}
else{
	$auth->roleid="9001";//Add
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
	$countrys=new Countrys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$countrys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$countrys=$countrys->setObject($obj);
		if($countrys->add($countrys)){
			$error=SUCCESS;
			redirect("addcountrys_proc.php?id=".$countrys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$countrys=new Countrys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$countrys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$countrys=$countrys->setObject($obj);
		if($countrys->edit($countrys)){
			$error=UPDATESUCCESS;
			redirect("addcountrys_proc.php?id=".$countrys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$countrys=new Countrys();
	$where=" where id=$id ";
	$fields="crm_countrys.id, crm_countrys.name, crm_countrys.continentid, crm_countrys.remarks, crm_countrys.ipaddress, crm_countrys.createdby, crm_countrys.createdon, crm_countrys.lasteditedby, crm_countrys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$countrys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$countrys->fetchObject;

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
	
	
$page_title="Countrys ";
include "addcountrys.php";
?>