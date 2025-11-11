<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Pricingcreatedelete_class.php");
require_once("../../auth/rules/Rules_class.php");

$obj=(object)$_POST;
$ob=(object)$_GET;

if(empty($ob->interface)){
  if(empty($_SESSION['userid'])){;
	  redirect("../../auth/users/login.php");
  }
}

if($obj->interface==2){
  echo "Processing....please wait";
}
	
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8293";//Edit
}
else{
	$auth->roleid="8291";//Add
}
$auth->levelid=$_SESSION['level'];
if(empty($ob->interface)){
  auth($auth);
}

if($ob->interface==2)
  $obj=$ob;


//connect to db
$db=new DB();


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
	
	$pricingcreatedelete=new Pricingcreatedelete();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$obj->status="Active";
	
	$obj->fieldname=strtolower(str_replace(" ","_",$obj->fieldname));
	
	$error=$pricingcreatedelete->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$pricingcreatedelete=$pricingcreatedelete->setObject($obj);
		if($pricingcreatedelete->add($pricingcreatedelete)){
			$error=SUCCESS;
			if($obj->interface==2)
			  echo "SUCCESS";
			else
			  redirect("addpricingcreatedelete_proc.php?id=".$pricingcreatedelete->id."&error=".$error);
		}
		else{
		      echo "FAILURE";
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$pricingcreatedelete=new Pricingcreatedelete();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$pricingcreatedelete->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$pricingcreatedelete=$pricingcreatedelete->setObject($obj);
		if($pricingcreatedelete->edit($pricingcreatedelete)){
			$error=UPDATESUCCESS;
			redirect("addpricingcreatedelete_proc.php?id=".$pricingcreatedelete->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action=="Retrieve"){

    $query="select group_concat(column_name separator ';') column_name from information_schema.columns where table_name='prices_pricings' and table_schema='$db->database' and column_name not in('id','ipaddress','createdby','createdon','lasteditedby','lasteditedon')";
    $res=mysql_query($query);
    $row=mysql_fetch_object($res);
    
    $pricingcreatedelete=new Pricingcreatedelete();
    $where=" where status='Active' ";
    $fields="group_concat(prices_pricingcreatedelete.fieldname separator ';') fieldname";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    $pricingcreatedelete = $pricingcreatedelete->fetchObject;
    echo $row->column_name.";".$pricingcreatedelete->fieldname;
    
}
if(empty($obj->action)){
}

if(!empty($id)){
	$pricingcreatedelete=new Pricingcreatedelete();
	$where=" where id=$id ";
	$fields="prices_pricingcreatedelete.id, prices_pricingcreatedelete.fieldname, prices_pricingcreatedelete.fieldsize, prices_pricingcreatedelete.category, prices_pricingcreatedelete.status, prices_pricingcreatedelete.ipaddress, prices_pricingcreatedelete.createdby, prices_pricingcreatedelete.createdon, prices_pricingcreatedelete.lasteditedby, prices_pricingcreatedelete.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$pricingcreatedelete->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$pricingcreatedelete->fetchObject;

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
	
	
$page_title="Pricingcreatedelete ";
if($obj->interface!=2)
  include "addpricingcreatedelete.php";
?>