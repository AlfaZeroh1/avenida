<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Stocktakes_class.php");
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
	$stocktakes=new Stocktakes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$stocktakes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktakes=$stocktakes->setObject($obj);
		if($stocktakes->add($stocktakes)){
			$error=SUCCESS;
			redirect("addstocktakes_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$stocktakes=new Stocktakes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$stocktakes->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktakes=$stocktakes->setObject($obj);
		if($stocktakes->edit($stocktakes)){
			$error=UPDATESUCCESS;
			redirect("addstocktakes_proc.php?error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$stocktakes=new Stocktakes();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$stocktakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$stocktakes->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->openedon=date("Y-m-d");
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_stocktakes"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
		$obj->status="Active";
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
$where=" where name='inv_stocktakes' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addstocktakes.php";
?>