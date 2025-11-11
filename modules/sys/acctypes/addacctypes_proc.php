<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Acctypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/accounttypes/Accounttypes_class.php");
require_once("../../fn/subaccountypes/Subaccountypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="110";//Edit
}
else{
	$auth->roleid="108";//Add
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
	$acctypes=new Acctypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$acctypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$acctypes=$acctypes->setObject($obj);
		if($acctypes->add($acctypes)){
			$error=SUCCESS;
			redirect("addacctypes_proc.php?id=".$acctypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$acctypes=new Acctypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$acctypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$acctypes=$acctypes->setObject($obj);
		if($acctypes->edit($acctypes)){
			$error=UPDATESUCCESS;
			redirect("addacctypes_proc.php?id=".$acctypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$accounttypes= new Accounttypes();
	$fields="fn_accounttypes.id, fn_accounttypes.code, fn_accounttypes.name, fn_accounttypes.remarks, fn_accounttypes.balance, fn_accounttypes.accounttype, fn_accounttypes.direct";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$accounttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$subaccountypes= new Subaccountypes();
	$fields="fn_subaccountypes.id, fn_subaccountypes.name, fn_subaccountypes.accounttypeid, fn_subaccountypes.priority, fn_subaccountypes.remarks, fn_subaccountypes.ipaddress, fn_subaccountypes.createdby, fn_subaccountypes.createdon, fn_subaccountypes.lasteditedby, fn_subaccountypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$acctypes=new Acctypes();
	$where=" where id=$id ";
	$fields="sys_acctypes.id, sys_acctypes.code, sys_acctypes.name, sys_acctypes.accounttypeid, sys_acctypes.subaccountypeid, sys_acctypes.balance, sys_acctypes.accounttype, sys_acctypes.direct";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$acctypes->fetchObject;

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
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='sys_acctypes' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addacctypes.php";
?>