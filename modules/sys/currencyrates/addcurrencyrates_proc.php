<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Currencyrates_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/currencys/Currencys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8839";//Edit
}
else{
	$auth->roleid="8837";//Add
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
	$currencyrates=new Currencyrates();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$currencyrates->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$currencyrates=$currencyrates->setObject($obj);
		if($currencyrates->add($currencyrates)){
			$error=SUCCESS;
			redirect("addcurrencyrates_proc.php?id=".$currencyrates->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$currencyrates=new Currencyrates();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$currencyrates->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$currencyrates=$currencyrates->setObject($obj);
		if($currencyrates->edit($currencyrates)){
			$error=UPDATESUCCESS;
			redirect("addcurrencyrates_proc.php?id=".$currencyrates->id."&error=".$error);
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
	$currencyrates=new Currencyrates();
	$where=" where id=$id ";
	$fields="sys_currencyrates.id, sys_currencyrates.currencyid, sys_currencyrates.fromcurrencydate, sys_currencyrates.tocurrencydate, sys_currencyrates.rate, sys_currencyrates.eurorate, sys_currencyrates.remarks, sys_currencyrates.ipaddress, sys_currencyrates.createdby, sys_currencyrates.createdon, sys_currencyrates.lasteditedby, sys_currencyrates.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencyrates->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$currencyrates->fetchObject;

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
	
	
$page_title="Currencyrates ";
include "addcurrencyrates.php";
?>