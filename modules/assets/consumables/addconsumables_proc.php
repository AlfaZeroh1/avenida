<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Consumables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/categorys/Categorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9403";//Edit
}
else{
	$auth->roleid="9403";//Add
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
	$consumables=new Consumables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$consumables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$consumables=$consumables->setObject($obj);
		if($consumables->add($consumables)){
			$error=SUCCESS;
			redirect("addconsumables_proc.php?id=".$consumables->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$consumables=new Consumables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$consumables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$consumables=$consumables->setObject($obj);
		if($consumables->edit($consumables)){
			$error=UPDATESUCCESS;
			redirect("addconsumables_proc.php?id=".$consumables->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$categorys= new Categorys();
	$fields="assets_categorys.id, assets_categorys.name, assets_categorys.timemethod, assets_categorys.noofdepr, assets_categorys.endingdate, assets_categorys.periodlength, assets_categorys.computationmethod, assets_categorys.degressivefactor, assets_categorys.firstentry, assets_categorys.assignmentid, assets_categorys.ipaddress, assets_categorys.createdby, assets_categorys.createdon, assets_categorys.lasteditedby, assets_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$consumables=new Consumables();
	$where=" where id=$id ";
	$fields="assets_consumables.id, assets_consumables.name, assets_consumables.categoryid, assets_consumables.remarks, assets_consumables.ipaddress, assets_consumables.createdby, assets_consumables.createdon, assets_consumables.lasteditedby, assets_consumables.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$consumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$consumables->fetchObject;

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
	
	
$page_title="Consumables ";
include "addconsumables.php";
?>