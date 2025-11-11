<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Supplierpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../sys/currencys/Currencys_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
// require_once("../../fn/customerpayments/setInvoices.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4735";//Edit
}
else{
	$auth->roleid="4733";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;echo $obj->invoiceno;
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
	$supplierpayments=new Supplierpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpsupplierpayments=$_SESSION['shpsupplierpayments'];
	$error=$supplierpayments->validates($obj,$shpsupplierpayments);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$supplierpayments=$supplierpayments->setObject($obj);
		$supplierpayments->undistributed=$obj->undistributed;
		if($supplierpayments->add($supplierpayments)){
			$error=SUCCESS;
			unset($_SESSION['shpgeneraljournal']);
			$saved="Yes";
// 			redirect("addsupplierpayments_proc.php?id=".$supplierpayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$supplierpayments=new Supplierpayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$supplierpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$supplierpayments=$supplierpayments->setObject($obj);
		$shpsupplierpayments=$_SESSION['shpsupplierpayments'];
		if($supplierpayments->edit($supplierpayments,$shpsupplierpayments)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpgeneraljournal']);
			$saved="Yes";
			redirect("addsupplierpayments_proc.php?id=".$supplierpayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpsupplierpayments=$_SESSION['shpsupplierpayments'];

	//$shpsupplierpayments[$it]=arra);

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpsupplierpayments']=$shpsupplierpayments;

}

if(empty($obj->action)){

	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$supplierpayments=new Supplierpayments();
	$where=" where id=$id ";
	$fields="fn_supplierpayments.id, fn_supplierpayments.supplierid, fn_supplierpayments.documentno, fn_supplierpayments.paidon, fn_supplierpayments.amount, fn_supplierpayments.paymentmodeid, fn_supplierpayments.bankid, fn_supplierpayments.chequeno, fn_supplierpayments.ipaddress, fn_supplierpayments.createdby, fn_supplierpayments.createdon, fn_supplierpayments.lasteditedby, fn_supplierpayments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$supplierpayments->fetchObject;

	//for autocompletes
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
}

if($obj->action=="Filter"){
  $supplierpayments=new Supplierpayments();
  $where=" where documentno='$obj->invoiceno' ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $obj=$supplierpayments->fetchObject;
  
  $query="select sum(amount) amount from fn_supplierpaidinvoices where supplierpaymentid='$obj->id' and invoiceno!=''";
  $dis=mysql_fetch_object(mysql_query($query));
  
  $obj->distributed=$dis->amount;

  $query="select sum(amount) amount from fn_supplierpaidinvoices where supplierpaymentid='$obj->id' and invoiceno=''";
  $dis=mysql_fetch_object(mysql_query($query));
  
  $obj->undistributed=$dis->amount;
  
	//for autocompletes
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
	$obj->retrieve=1;
}

if(empty($id) and empty($obj->action) and empty($obj->retrieve)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->unpaid=1;
		$obj->paidon=date("Y-m-d");
		$obj->currencyid=5;
		
		$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from fn_supplierpayments"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;

		$obj->amount=0;
		$_SESSION['shpgeneraljournal']=array();
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Supplierpayments ";
include "addsupplierpayments.php";
?>