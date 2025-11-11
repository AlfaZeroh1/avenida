<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Items_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/departments/Departments_class.php");
require_once("../../inv/categorys/Categorys_class.php");
require_once("../../inv/departmentcategorys/Departmentcategorys_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../inv/unitofmeasures/Unitofmeasures_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../sys/currencys/Currencys_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="705";//Edit
}
else{
	$auth->roleid="703";//Add
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
	$items=new Items();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$items->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$items=$items->setObject($obj);
		if($items->add($items)){
			$error=SUCCESS;
			redirect("additems_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

if($obj->action=="Merge"){
  mysql_query("update proc_inwarddetails set itemid='$obj->itemid' where itemid='$obj->id'");
  mysql_query("update proc_purchaseorderdetails set itemid='$obj->itemid' where itemid='$obj->id'");
  mysql_query("update inv_purchasedetails set itemid='$obj->itemid' where itemid='$obj->id'");
  mysql_query("update proc_requisitiondetails set itemid='$obj->itemid' where itemid='$obj->id'");
  mysql_query("update inv_issuancedetails set itemid='$obj->itemid' where itemid='$obj->id'");
  
  $qna=mysql_fetch_object(mysql_query("select * from inv_items where id='$obj->itemid'"));
  $qn=mysql_fetch_object(mysql_query("select * from inv_items where id='$obj->id'"));
  
  //insert record to inv_merges
  mysql_query("insert into inv_merges(itemid, itemid2,quantity,ipaddress,createdby,createdon, lasteditedby, lasteditedon) 
  values('$obj->id','$obj->itemid','$qn->quantity','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['userid']."',Now(),'".$_SESSION['userid']."',Now())");
  
  $qna->id="";
  $qna->itemid=$obj->itemid;
  $qna->quantity=$qn->quantity;
  $stocktrack = new Stocktrack();
  $qna->recorddate=date("Y-m-d");
  $qna->transaction="MERGE";
  $stocktrack->addStock($qna);
  
  $qn->id="";
  $qn->itemid=$obj->id;
//   $qna->quantity=$qn->quantity;
  $stocktrack = new Stocktrack();
  $qn->recorddate=date("Y-m-d");
  $qn->transaction="MERGE";
  $stocktrack->reduceStock($qn);
  
  mysql_query("update inv_items set status='Not Active' where id='$obj->id'");
  $error=SUCCESS;
}
	
if($obj->action=="Update"){
	$items=new Items();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$items->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$items=$items->setObject($obj);
		if($items->edit($items)){
			$error=UPDATESUCCESS;
// 			redirect("additems_proc.php?error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorys= new Categorys();
	$fields="inv_categorys.id, inv_categorys.name, inv_categorys.remarks, inv_categorys.createdby, inv_categorys.createdon, inv_categorys.lasteditedby, inv_categorys.lasteditedon, inv_categorys.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departmentcategorys= new Departmentcategorys();
	$fields="inv_departmentcategorys.id, inv_departmentcategorys.departmentid, inv_departmentcategorys.name, inv_departmentcategorys.remarks, inv_departmentcategorys.createdby, inv_departmentcategorys.createdon, inv_departmentcategorys.lasteditedby, inv_departmentcategorys.lasteditedon, inv_departmentcategorys.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departmentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$vatclasses= new Vatclasses();
	$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$generaljournalaccounts= new Generaljournalaccounts();
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$generaljournalaccounts2= new Generaljournalaccounts();
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts2->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$unitofmeasures= new Unitofmeasures();
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$items=new Items();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$items->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->createdon="0000-00-00 00:00:00";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}

if(!empty($ob->merge)){
  $obj->merge=$ob->merge;
  $obj->action="Merge";
}
	
	
$page_title="Items ";
include "additems.php";
?>