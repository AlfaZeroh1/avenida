<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournalaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/currencys/Currencys_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/acctypes/Acctypes_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../crm/customers/Customers_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../fn/banks/Banks_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="757";//Edit
}
else{
	$auth->roleid="755";//Add
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
	$generaljournalaccounts=new Generaljournalaccounts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$generaljournalaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$generaljournalaccounts=$generaljournalaccounts->setObject($obj);
		if($generaljournalaccounts->add($generaljournalaccounts)){
			$error=SUCCESS;
			redirect("addgeneraljournalaccounts_proc.php?id=".$generaljournalaccounts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$generaljournalaccounts=new Generaljournalaccounts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$generaljournalaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$generaljournalaccounts=$generaljournalaccounts->setObject($obj);
		if($generaljournalaccounts->edit($generaljournalaccounts)){
			$error=UPDATESUCCESS;
			redirect("addgeneraljournalaccounts_proc.php?id=".$generaljournalaccounts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$acctypes= new Acctypes();
	$fields="sys_acctypes.id, sys_acctypes.name, sys_acctypes.balance";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$generaljournalaccounts= new Generaljournalaccounts();
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$generaljournalaccounts=new Generaljournalaccounts();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$generaljournalaccounts->fetchObject;

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
	
	
$page_title="Generaljournalaccounts ";
include "addgeneraljournalaccounts.php";
?>