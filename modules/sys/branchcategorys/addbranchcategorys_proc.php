<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Branchcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/branches/Branches_class.php");
require_once("../../inv/categorys/Categorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11931";//Edit
}
else{
	$auth->roleid="11931";//Add
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
	$branchcategorys=new Branchcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$branchcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branchcategorys=$branchcategorys->setObject($obj);
		if($branchcategorys->add($branchcategorys)){
			$error=SUCCESS;
			redirect("addbranchcategorys_proc.php?id=".$branchcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$branchcategorys=new Branchcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$branchcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branchcategorys=$branchcategorys->setObject($obj);
		if($branchcategorys->edit($branchcategorys)){
			$error=UPDATESUCCESS;
			redirect("addbranchcategorys_proc.php?id=".$branchcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorys= new Categorys();
	$fields="inv_categorys.id, inv_categorys.name, inv_categorys.remarks, inv_categorys.createdby, inv_categorys.createdon, inv_categorys.lasteditedby, inv_categorys.lasteditedon, inv_categorys.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$branchcategorys=new Branchcategorys();
	$where=" where id=$id ";
	$fields="sys_branchcategorys.id, sys_branchcategorys.brancheid, sys_branchcategorys.categoryid, sys_branchcategorys.remarks, sys_branchcategorys.ipaddress, sys_branchcategorys.createdby, sys_branchcategorys.createdon, sys_branchcategorys.lasteditedby, sys_branchcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branchcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$branchcategorys->fetchObject;

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
$where=" where name='sys_branchcategorys' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addbranchcategorys.php";
?>