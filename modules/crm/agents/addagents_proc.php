<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/statuss/Statuss_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4774";//Edit
}
else{
	$auth->roleid="4774";//Add
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
	
	
if($obj->action=="Save"){
	$agents=new Agents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$agents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agents=$agents->setObject($obj);
		if($agents->add($agents)){
			$error=SUCCESS;
			redirect("addagents_proc.php?id=".$agents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$agents=new Agents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$agents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agents=$agents->setObject($obj);
		if($agents->edit($agents)){
			$error=UPDATESUCCESS;
			redirect("addagents_proc.php?id=".$agents->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$statuss= new Statuss();
	$fields="crm_statuss.id, crm_statuss.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$agents=new Agents();
	$where=" where id=$id ";
	$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_agents.statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$agents->fetchObject;

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
	
	
$page_title="Agents ";
include "addagents.php";
?>