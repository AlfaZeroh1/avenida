<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inspectionitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/categorys/Categorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8479";//Edit
}
else{
	$auth->roleid="8479";//Add
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
	$inspectionitems=new Inspectionitems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$inspectionitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inspectionitems=$inspectionitems->setObject($obj);
		if($inspectionitems->add($inspectionitems)){
			$error=SUCCESS;
			//redirect("addinspectionitems_proc.php?id=".$inspectionitems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$inspectionitems=new Inspectionitems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$inspectionitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inspectionitems=$inspectionitems->setObject($obj);
		if($inspectionitems->edit($inspectionitems)){
			$error=UPDATESUCCESS;
			redirect("addinspectionitems_proc.php?id=".$inspectionitems->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$categorys= new Categorys();
	$fields="assets_categorys.id, assets_categorys.name, assets_categorys.timemethod, assets_categorys.noofdepr, assets_categorys.endingdate, assets_categorys.periodlength, assets_categorys.computationmethod, assets_categorys.degressivefactor, assets_categorys.firstentry, assets_categorys.ipaddress, assets_categorys.createdby, assets_categorys.createdon, assets_categorys.lasteditedby, assets_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$inspectionitems=new Inspectionitems();
	$where=" where id=$id ";
	$fields="assets_inspectionitems.id, assets_inspectionitems.name, assets_inspectionitems.categoryid, assets_inspectionitems.remarks, assets_inspectionitems.ipaddress, assets_inspectionitems.createdby, assets_inspectionitems.createdon, assets_inspectionitems.lasteditedby, assets_inspectionitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$inspectionitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$inspectionitems->fetchObject;

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
	
	
$page_title="Inspectionitems ";
include "addinspectionitems.php";
?>