<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Materialsubcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/materialcategorys/Materialcategorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7797";//Edit
}
else{
	$auth->roleid="7795";//Add
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
	$materialsubcategorys=new Materialsubcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$materialsubcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$materialsubcategorys=$materialsubcategorys->setObject($obj);
		if($materialsubcategorys->add($materialsubcategorys)){
			$error=SUCCESS;
			redirect("addmaterialsubcategorys_proc.php?id=".$materialsubcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$materialsubcategorys=new Materialsubcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$materialsubcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$materialsubcategorys=$materialsubcategorys->setObject($obj);
		if($materialsubcategorys->edit($materialsubcategorys)){
			$error=UPDATESUCCESS;
			redirect("addmaterialsubcategorys_proc.php?id=".$materialsubcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$materialcategorys= new Materialcategorys();
	$fields="con_materialcategorys.id, con_materialcategorys.name, con_materialcategorys.remarks, con_materialcategorys.ipaddress, con_materialcategorys.createdby, con_materialcategorys.createdon, con_materialcategorys.lasteditedby, con_materialcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$materialsubcategorys=new Materialsubcategorys();
	$where=" where id=$id ";
	$fields="con_materialsubcategorys.id, con_materialsubcategorys.name, con_materialsubcategorys.categoryid, con_materialsubcategorys.remarks, con_materialsubcategorys.ipaddress, con_materialsubcategorys.createdby, con_materialsubcategorys.createdon, con_materialsubcategorys.lasteditedby, con_materialsubcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialsubcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$materialsubcategorys->fetchObject;

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
	
	
$page_title="Materialsubcategorys ";
include "addmaterialsubcategorys.php";
?>