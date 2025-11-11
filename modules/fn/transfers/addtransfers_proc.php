<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Transfers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/currencys/Currencys_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10340";//Edit
}
else{
	$auth->roleid="10340";//Add
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
	$transfers=new Transfers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$transfers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transfers=$transfers->setObject($obj);
		$transfers->tocurrencyid=$obj->tocurrencyid;
		$transfers->torate=$obj->torate;
		$transfers->toeurate=$obj->toeurate;
		$transfers->jvno=$obj->jvno;
		if($transfers->add($transfers)){
			$error=SUCCESS;
			redirect("addtransfers_proc.php");
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$transfers=new Transfers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$transfers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transfers=$transfers->setObject($obj);
		$transfers->tocurrencyid=$obj->tocurrencyid;
		$transfers->torate=$obj->torate;
		$transfers->toeurate=$obj->toeurate;
		$transfers->jvno=$obj->jvno;
		if($transfers->edit($transfers)){
			$error=UPDATESUCCESS;
			redirect("addtransfers_proc.php?retrieve=1");
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$currencys= new Currencys();
	$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$transfers=new Transfers();
	$where=" where documentno=$id ";
	$fields="fn_transfers.id, fn_transfers.bankid,fn_transfers.documentno, fn_transfers.amount,fn_transfers.amount1, fn_transfers.currencyid, fn_transfers.rate, fn_transfers.eurorate, fn_transfers.exchangerate, fn_transfers.tobankid, fn_transfers.tocurrencyid, fn_transfers.toeurate, fn_transfers.torate, fn_transfers.diffksh, fn_transfers.diffeuro, fn_transfers.paymentmodeid, fn_transfers.transactno, fn_transfers.chequeno, fn_transfers.transactdate, fn_transfers.remarks, fn_transfers.createdby, fn_transfers.createdon, fn_transfers.lasteditedon, fn_transfers.lasteditedby, fn_transfers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$transfers->fetchObject;
	$obj->documentno=$obj->documentno;

	//for autocompletes
}

if($obj->action=="Filter"){
	$transfers=new Transfers();
	$where=" where documentno='$obj->invoiceno' ";
	$fields="fn_transfers.id, fn_transfers.bankid,fn_transfers.documentno, fn_transfers.amount,fn_transfers.amount1, fn_transfers.currencyid, fn_transfers.rate, fn_transfers.eurorate, fn_transfers.exchangerate, fn_transfers.tobankid, fn_transfers.tocurrencyid, fn_transfers.toeurate, fn_transfers.torate, fn_transfers.diffksh, fn_transfers.diffeuro, fn_transfers.paymentmodeid, fn_transfers.transactno, fn_transfers.chequeno, fn_transfers.transactdate, fn_transfers.remarks, fn_transfers.createdby, fn_transfers.createdon, fn_transfers.lasteditedon, fn_transfers.lasteditedby, fn_transfers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$transfers->fetchObject;
	
	$gn = new Generaljournals();
	$obj->jvno=$gn->getJvNos($obj->documentno,26);
	
	$obj->retrieve=1;
	$obj->action="Update";

	//for autocompletes
}

if(empty($id) and empty($obj->action) and empty($obj->retrieve)){
	if(empty($_GET['edit'])){
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_transfers"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
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
$where=" where name='fn_transfers' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addtransfers.php";
?>