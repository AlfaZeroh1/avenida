<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Imprestaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8129";//Edit
}
else{
	$auth->roleid="8127";//Add
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
	$imprestaccounts=new Imprestaccounts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$imprestaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$imprestaccounts=$imprestaccounts->setObject($obj);
		if($imprestaccounts->add($imprestaccounts)){

			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name." Cash ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$imprestaccounts->id;
			$obj->acctypeid=24;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);

			$error=SUCCESS;
			redirect("addimprestaccounts_proc.php?id=".$imprestaccounts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$imprestaccounts=new Imprestaccounts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$imprestaccounts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$imprestaccounts=$imprestaccounts->setObject($obj);
		if($imprestaccounts->edit($imprestaccounts)){

			//updating corresponding general journal account
			$name=$obj->name;
			$obj->name=$name." Cash ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$imprestaccounts->id;
			$obj->acctypeid=24;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$imprestaccounts->id' and acctypeid='24' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);

			$error=UPDATESUCCESS;
			redirect("addimprestaccounts_proc.php?id=".$imprestaccounts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();

}

if(!empty($id)){
	$imprestaccounts=new Imprestaccounts();
	$where=" where id=$id ";
	$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, fn_imprestaccounts.employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$imprestaccounts->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
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
	
	
$page_title="Imprestaccounts ";
include "addimprestaccounts.php";
?>