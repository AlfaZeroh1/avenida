<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Orderpayments_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once '../../fn/banks/Banks_class.php';

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11903";//Edit
}
else{
	$auth->roleid="11903";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;//print_r($ob);

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}

if(!empty($ob->billno))
  $obj->billno=$ob->billno;

if(!empty($ob->orderid)){
  $obj->orderid=$ob->orderid;
  $obj->orderno=$ob->orderno;
  
  //get order total
  $query="select sum(pos_orderdetails.quantity*pos_orderdetails.price) amount from pos_orderdetails where orderid='$ob->orderid'";
  $rw = mysql_fetch_object(mysql_query($query));
  
  $query="select case when sum(pos_orderpayments.amount) is null then 0 else sum(pos_orderpayments.amount) end paid from pos_orderpayments where orderid='$ob->orderid' ";
  $w=mysql_fetch_object(mysql_query($query));
    
  $obj->amount=$rw->amount-$w->paid;
  
}

if(empty($obj->action)){
  $obj->paidon=date('Y-m-d');
}
	
	
if($obj->action=="Save"){
	$orderpayments=new Orderpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$orderpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$orderpayments=$orderpayments->setObject($obj);
		if($orderpayments->add($orderpayments)){
			$error=SUCCESS;
			
			$saved="Yes";
			
			
// 			redirect("addorderpayments_proc.php?id=".$orderpayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$orderpayments=new Orderpayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$orderpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$orderpayments=$orderpayments->setObject($obj);
		if($orderpayments->edit($orderpayments)){
			$error=UPDATESUCCESS;
			redirect("addorderpayments_proc.php?id=".$orderpayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$orderpayments=new Orderpayments();
	$where=" where id=$id ";
	$fields="pos_orderpayments.id, pos_orderpayments.orderid, pos_orderpayments.paidon, pos_orderpayments.amount, pos_orderpayments.amountgiven, pos_orderpayments.remarks, pos_orderpayments.ipaddress, pos_orderpayments.createdby, pos_orderpayments.createdon, pos_orderpayments.lasteditedby, pos_orderpayments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$orderpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$orderpayments->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from pos_orderpayments"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}

if(empty($obj->paymentmodeid)){
  $obj->paymentmodeid=1;
}
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='pos_orderpayments' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addorderpayments.php";
?>