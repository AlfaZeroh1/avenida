<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2166";//Edit
}
else{
	$auth->roleid="2164";//Add
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
	$itemstatuss=new Itemstatuss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$itemstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemstatuss=$itemstatuss->setObject($obj);
		if($itemstatuss->add($itemstatuss)){
			$error=SUCCESS;
			redirect("additemstatuss_proc.php?id=".$itemstatuss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$itemstatuss=new Itemstatuss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$itemstatuss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemstatuss=$itemstatuss->setObject($obj);
		if($itemstatuss->edit($itemstatuss)){
			$error=UPDATESUCCESS;
			redirect("additemstatuss_proc.php?id=".$itemstatuss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$itemstatuss=new Itemstatuss();
	$where=" where id=$id ";
	$fields="pos_itemstatuss.id, pos_itemstatuss.name, pos_itemstatuss.ipaddress, pos_itemstatuss.createdby, pos_itemstatuss.createdon, pos_itemstatuss.lasteditedby, pos_itemstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$itemstatuss->fetchObject;

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
	
	
$page_title="Itemstatuss ";
include "additemstatuss.php";
?>