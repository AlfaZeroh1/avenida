<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentvouchers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8149";//Edit
}
else{
	$auth->roleid="8147";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../fn/paymentvoucherdetails/Paymentvoucherdetails_class.php");
require_once("../../fn/cashrequisitions/Cashrequisitions_class.php");
require_once("../../fn/paymentrequisitions/Paymentrequisitions_class.php");

//Process delete of paymentvoucherdetails
if(!empty($_GET['paymentvoucherdetails'])){
	$paymentvoucherdetails = new Paymentvoucherdetails();
	$paymentvoucherdetails->id=$_GET['paymentvoucherdetails'];
	$paymentvoucherdetails->delete($paymentvoucherdetails);
}


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
	$paymentvouchers=new Paymentvouchers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shppaymentvouchers=$_SESSION['shppaymentvouchers'];
	$error=$paymentvouchers->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppaymentvouchers)){
		$error="No items in the sale list!";
	}
	else{
		$paymentvouchers=$paymentvouchers->setObject($obj);
		if($paymentvouchers->add($paymentvouchers,$shppaymentvouchers)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paymentvouchers=new Paymentvouchers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paymentvouchers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentvouchers=$paymentvouchers->setObject($obj);
		$shppaymentvouchers=$_SESSION['shppaymentvouchers'];
		if($paymentvouchers->edit($paymentvouchers,$shppaymentvouchers)){
			$error=UPDATESUCCESS;
			redirect("addpaymentvouchers_proc.php?id=".$paymentvouchers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of paymentvoucherdetails
if($obj->action=="Add Paymentvoucherdetail"){
	$paymentvoucherdetails = new Paymentvoucherdetails();

	$ob->paymentvoucherid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->cashrequisitionid=$obj->paymentvoucherdetailscashrequisitionid;
	$ob->paymentrequisitionid=$obj->paymentvoucherdetailspaymentrequisitionid;
	$ob->documentno=$obj->paymentvoucherdetailsdocumentno;
	$ob->amount=$obj->paymentvoucherdetailsamount;
	$ob->remarks=$obj->paymentvoucherdetailsremarks;

	$error=$paymentvoucherdetails->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentvoucherdetails->setObject($ob);

		if($paymentvoucherdetails->add($paymentvoucherdetails)){
			$obj->paymentvoucherdetailscashrequisitionid="";
			$obj->paymentvoucherdetailspaymentrequisitionid="";
			$obj->paymentvoucherdetailsdocumentno="";
			$obj->paymentvoucherdetailsamount="";
			$obj->paymentvoucherdetailsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addpaymentvouchers_proc.php?id=".$obj->id."&error=".$error);
}

if($obj->action2=="Add"){

	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppaymentvouchers=$_SESSION['shppaymentvouchers'];

	$cashrequisitions = new Cashrequisitions();
	$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, fn_cashrequisitions.projectid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))employeeid, fn_cashrequisitions.description, fn_cashrequisitions.amount, fn_cashrequisitions.status, fn_cashrequisitions.remarks, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
	$join=" left join hrm_employees on hrm_employees.id=fn_cashrequisitions.employeeid ";
	$groupby="";
	$having="";
	$where=" where fn_cashrequisitions.id='$obj->cashrequisitionid'";
	$cashrequisitions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$cashrequisitions=$cashrequisitions->fetchObject;
	
	$paymentrequisitions = new Paymentrequisitions();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->paymentrequisitionid'";
	$paymentrequisitions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentrequisitions=$paymentrequisitions->fetchObject;

	;
	$shppaymentvouchers[$it]=array('cashrequisitionid'=>"$obj->cashrequisitionid", 'cashrequisitionname'=>"$cashrequisitions->documentno - $cashrequisitions->employeeid", 'paymentrequisitionid'=>"$obj->paymentrequisitionid", 'paymentrequisitionname'=>"$paymentrequisitions->name", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppaymentvouchers']=$shppaymentvouchers;

	$obj->cashrequisitionid="";
 	$obj->paymentrequisitionid="";
 	$obj->amount="";
 	$obj->remarks="";
 }

if(empty($obj->action)){

	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
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

}

if(!empty($id)){
	$paymentvouchers=new Paymentvouchers();
	$where=" where id=$id ";
	$fields="fn_paymentvouchers.id, fn_paymentvouchers.documentno, fn_paymentvouchers.voucherno, fn_paymentvouchers.voucherdate, fn_paymentvouchers.payee, fn_paymentvouchers.paymentmodeid, fn_paymentvouchers.bankid, fn_paymentvouchers.chequeno, fn_paymentvouchers.chequedate, fn_paymentvouchers.remarks, fn_paymentvouchers.status, fn_paymentvouchers.ipaddress, fn_paymentvouchers.createdby, fn_paymentvouchers.createdon, fn_paymentvouchers.lasteditedby, fn_paymentvouchers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentvouchers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paymentvouchers->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		
		$doc = mysql_fetch_object(mysql_query("select max(documentno) documentno from fn_paymentvouchers"));
		$obj->documentno=$doc->documentno+1;
		
		$obj->voucherdate=date("Y-m-d");
		
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Paymentvouchers ";
include "addpaymentvouchers.php";
?>