<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Stocktakedetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/items/Items_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11152";//Edit
}
else{
	$auth->roleid="11152";//Add
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
	$stocktakedetails=new Stocktakedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$stocktakedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktakedetails=$stocktakedetails->setObject($obj);
		if($stocktakedetails->add($stocktakedetails)){
			$error=SUCCESS;
			redirect("addstocktakedetails_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$stocktakedetails=new Stocktakedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$stocktakedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktakedetails=$stocktakedetails->setObject($obj);
		if($stocktakedetails->edit($stocktakedetails)){
			$error=UPDATESUCCESS;
			redirect("addstocktakedetails_proc.php?error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$stocktakedetails=new Stocktakedetails();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$stocktakedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$stocktakedetails->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->takenon=date("Y-m-d");
		
		$query="select * from inv_stocktakes where status='Active'";
		$ob = mysql_fetch_object(mysql_query($query));
		
		$obj->documentno=$ob->documentno;
		$obj->stocktakeid=$ob->id;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='inv_stocktakedetails' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addstocktakedetails.php";
?>