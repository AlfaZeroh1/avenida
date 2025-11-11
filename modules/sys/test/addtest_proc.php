<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Test_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/modules/Modules_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4723";//Edit
}
else{
	$auth->roleid="4721";//Add
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
	$test=new Test();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$test->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$test=$test->setObject($obj);
		if($test->add($test)){
			$error=SUCCESS;
			redirect("addtest_proc.php?id=".$test->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$test=new Test();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$test->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$test=$test->setObject($obj);
		if($test->edit($test)){
			$error=UPDATESUCCESS;
			redirect("addtest_proc.php?id=".$test->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$modules= new Modules();
	$fields="sys_modules.id, sys_modules.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$test=new Test();
	$where=" where id=$id ";
	$fields="sys_test.id, sys_test.name, sys_test.moduleid, sys_test.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$test->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$test->fetchObject;

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
	
	
$page_title="Test ";
include "addtest.php";
?>