<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Varietys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/types/Types_class.php");
require_once("../../prod/colours/Colours_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8617";//Edit
}
else{
	$auth->roleid="8615";//Add
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
	$varietys=new Varietys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$varietys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$varietys=$varietys->setObject($obj);
		if($varietys->add($varietys)){
			$error=SUCCESS;
			redirect("addvarietys_proc.php?id=".$varietys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$varietys=new Varietys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$varietys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$varietys=$varietys->setObject($obj);
		if($varietys->edit($varietys)){
			$error=UPDATESUCCESS;
			redirect("addvarietys_proc.php?id=".$varietys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$types= new Types();
	$fields="prod_types.id, prod_types.name, prod_types.remarks, prod_types.ipaddress, prod_types.createdby, prod_types.createdon, prod_types.lasteditedby, prod_types.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$types->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$colours= new Colours();
	$fields="prod_colours.id, prod_colours.name, prod_colours.remarks, prod_colours.ipaddress, prod_colours.createdby, prod_colours.createdon, prod_colours.lasteditedby, prod_colours.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$colours->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$varietys=new Varietys();
	$where=" where id=$id ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems, prod_varietys.remarks, prod_varietys.type, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$varietys->fetchObject;

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
	
	
$page_title="Varietys ";
include "addvarietys.php";
?>