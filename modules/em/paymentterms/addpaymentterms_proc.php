<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentterms_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4307";//Edit
}
else{
	$auth->roleid="4305";//Add
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
	$paymentterms=new Paymentterms();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$paymentterms->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentterms=$paymentterms->setObject($obj);
		if($paymentterms->add($paymentterms)){
			if($obj->type=="Special Deposit"){
			  $liabilitys = new Liabilitys();
			  $liabilitys->name=$obj->name;
			  $liabilitys->paymenttermid=$paymentterms->id;
			  $liabilitys->remarks=$obj->remarks;
			  $liabilitys = $liabilitys->setObject($liabilitys);
			  $liabilitys->add($liabilitys);
			}
			$error=SUCCESS;
			redirect("addpaymentterms_proc.php?id=".$paymentterms->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paymentterms=new Paymentterms();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paymentterms->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentterms=$paymentterms->setObject($obj);
		if($paymentterms->edit($paymentterms)){
			$error=UPDATESUCCESS;
			redirect("addpaymentterms_proc.php?id=".$paymentterms->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$generaljournalaccounts= new Generaljournalaccounts();
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$paymentterms=new Paymentterms();
	$where=" where em_paymentterms.id=$id ";
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.generaljournalaccountid, concat(fn_generaljournalaccounts.code,' ',fn_generaljournalaccounts.name) generaljournalaccountname, em_paymentterms.chargemgtfee, em_paymentterms.remarks, em_paymentterms.ipaddress, em_paymentterms.createdby, em_paymentterms.createdon, em_paymentterms.lasteditedby, em_paymentterms.lasteditedon";
	$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=em_paymentterms.generaljournalaccountid";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paymentterms->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->payabletolandlord="No";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Paymentterms ";
include "addpaymentterms.php";
?>