<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Configaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/currencys/Currencys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9302";//Edit
}
else{
	$auth->roleid="9302";//Add
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
	$configaccounts=new Configaccounts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$configaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$configaccounts=$configaccounts->setObject($obj);
		if($configaccounts->add($configaccounts)){
			$error=SUCCESS;
			redirect("addconfigaccounts_proc.php?id=".$configaccounts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$configaccounts=new Configaccounts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$configaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$configaccounts=$configaccounts->setObject($obj);
		if($configaccounts->edit($configaccounts)){
			$error=UPDATESUCCESS;
			redirect("addconfigaccounts_proc.php?id=".$configaccounts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$currencys= new Currencys();
	$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$configaccounts=new Configaccounts();
	$where=" where id=$id ";
	$fields="pos_configaccounts.id, pos_configaccounts.name, pos_configaccounts.accno, pos_configaccounts.currencyid, pos_configaccounts.remarks, pos_configaccounts.ipaddress, pos_configaccounts.createdby, pos_configaccounts.createdon, pos_configaccounts.lasteditedby, pos_configaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$configaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$configaccounts->fetchObject;

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
	
	
$page_title="Configaccounts ";
include "addconfigaccounts.php";
?>