<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Systemblocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/irrigationsystems/Irrigationsystems_class.php");
require_once("../../prod/blocks/Blocks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9237";//Edit
}
else{
	$auth->roleid="9237";//Add
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
	$systemblocks=new Systemblocks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$systemblocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$systemblocks=$systemblocks->setObject($obj);
		if($systemblocks->add($systemblocks)){
			$error=SUCCESS;
			redirect("addsystemblocks_proc.php?id=".$systemblocks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$systemblocks=new Systemblocks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$systemblocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$systemblocks=$systemblocks->setObject($obj);
		if($systemblocks->edit($systemblocks)){
			$error=UPDATESUCCESS;
			redirect("addsystemblocks_proc.php?id=".$systemblocks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$irrigationsystems= new Irrigationsystems();
	$fields="prod_irrigationsystems.id, prod_irrigationsystems.name, prod_irrigationsystems.remarks, prod_irrigationsystems.ipaddress, prod_irrigationsystems.createdby, prod_irrigationsystems.createdon, prod_irrigationsystems.lasteditedby, prod_irrigationsystems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$irrigationsystems->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$blocks= new Blocks();
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$systemblocks=new Systemblocks();
	$where=" where id=$id ";
	$fields="prod_systemblocks.id, prod_systemblocks.systemid, prod_systemblocks.blockid, prod_systemblocks.remarks, prod_systemblocks.ipaddress, prod_systemblocks.createdby, prod_systemblocks.createdon, prod_systemblocks.lasteditedby, prod_systemblocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$systemblocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$systemblocks->fetchObject;

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
	
	
$page_title="Systemblocks ";
include "addsystemblocks.php";
?>