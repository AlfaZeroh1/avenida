<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once("../../fn/banks/Banks_class.php");


require_once("../../hos/patients/Patients_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/transactions/Transactions_class.php");


//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7488";//Edit
}
else{
	$auth->roleid="7486";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);

$saved="";
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
	$customerpayments=new Customerpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customerpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerpayments=$customerpayments->setObject($obj);//print_r($shpgeneraljournals);
		if($customerpayments->add($customerpayments)){
			//$error=SUCCESS;
			//$saved="Yes";
			//unset($_SESSION['shpgeneraljournal']);
		//redirect("addcustomerpayments_proc.php?id=".$customerpayments->id."&error=".$error);		
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customerpayments=new Customerpayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$customerpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerpayments=$customerpayments->setObject($obj);
		if($customerpayments->edit($customerpayments)){
			$error=UPDATESUCCESS;
			$saved="Yes";
			unset($_SESSION['shpgeneraljournal']);
		redirect("addcustomerpayments_proc.php?id=".$customerpayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
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

}

if(!empty($id)){
	$customerpayments=new Customerpayments();
	$where=" where id=$id ";
	$fields="fn_customerpayments.id, fn_customerpayments.patientid, fn_customerpayments.documentno, fn_customerpayments.paidon, fn_customerpayments.amount, fn_customerpayments.paymentmodeid, fn_customerpayments.bankid, fn_customerpayments.chequeno, fn_customerpayments.ipaddress, fn_customerpayments.createdby, fn_customerpayments.createdon, fn_customerpayments.lasteditedby, fn_customerpayments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customerpayments->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		
		$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from fn_customerpayments"));
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
	
	
$page_title="Customerpayments";
include "addcustomerpayments.php";
?>