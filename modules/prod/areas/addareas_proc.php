<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Areas_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/blocks/Blocks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8553";//Edit
}
else{
	$auth->roleid="8551";//Add
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
	$areas=new Areas();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$areas->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$areas=$areas->setObject($obj);
		if($areas->add($areas)){
			$error=SUCCESS;
			redirect("addareas_proc.php?id=".$areas->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$areas=new Areas();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$areas->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$areas=$areas->setObject($obj);
		if($areas->edit($areas)){
			$error=UPDATESUCCESS;
			redirect("addareas_proc.php?id=".$areas->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$blocks= new Blocks();
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$areas=new Areas();
	$where=" where id=$id ";
	$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.noofplants, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$areas->fetchObject;

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
	
	
$page_title="Areas ";
include "addareas.php";
?>