<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Salepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../motor/customers/Customers_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2202";//Edit
}
else{
	$auth->roleid="2200";//Add
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
	$salepayments=new Salepayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$salepayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$salepayments=$salepayments->setObject($obj);
		if($salepayments->add($salepayments)){

			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->customerid' and acctypeid='29'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->bankid' and acctypeid='8'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

			//Get transaction Identity
			$transaction = new Transactions();
			$fields="*";
			$where=" where lower(replace(name,' ',''))='salepayments'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$transaction=$transaction->fetchObject;

			$ob->transactdate=$obj->paidon;

			//make debit entry
			$generaljournal = new Generaljournals();
			$ob->tid=$salepayments->id;
			$ob->documentno="$obj->documnetno";
			$ob->remarks="Payment ($obj->chequeno)";
			$ob->memo=$salepayments->remarks;
			$ob->accountid=$generaljournalaccounts->id;
			$ob->daccountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="credit";
			$ob->debit=;
			$ob->credit=$obj->amount;
			$generaljournal->setObject($ob);
			$generaljournal->add($generaljournal);

			//make credit entry
			$generaljournal2 = new Generaljournals();
			$ob->tid=$salepayments->id;
			$ob->documentno=$obj->documnetno;
			$ob->remarks="Payment from $obj->customerid";
			$ob->memo=$salepayments->remarks;
			$ob->daccountid=$generaljournalaccounts->id;
			$ob->accountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="credit";
			$ob->debit=$obj->amount;
			$ob->credit=;
			$ob->did=$generaljournal->id;
			$generaljournal2->setObject($ob);
			$generaljournal2->add($generaljournal2);

			$generaljournal->did=$generaljournal2->id;
			$generaljournal->edit($generaljournal);

			$error=SUCCESS;
			redirect("addsalepayments_proc.php?id=".$salepayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$salepayments=new Salepayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$salepayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$salepayments=$salepayments->setObject($obj);
		if($salepayments->edit($salepayments)){

			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->customerid' and acctypeid='29'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->bankid' and acctypeid='8'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
			$error=UPDATESUCCESS;
			redirect("addsalepayments_proc.php?id=".$salepayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$customers= new Customers();
	$fields="motor_customers.id, motor_customers.name, motor_customers.address, motor_customers.mobile, motor_customers.reference, motor_customers.remarks, motor_customers.status";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$salepayments=new Salepayments();
	$where=" where id=$id ";
	$fields="pos_salepayments.id, pos_salepayments.documentno, pos_salepayments.invoiceno, pos_salepayments.customerid, pos_salepayments.amount, pos_salepayments.paymentmodeid, pos_salepayments.bankid, pos_salepayments.chequeno, pos_salepayments.paidon, pos_salepayments.offsetid, pos_salepayments.createdby, pos_salepayments.createdon, pos_salepayments.lasteditedby, pos_salepayments.lasteditedon, pos_salepayments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$salepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$salepayments->fetchObject;

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
	
	
$page_title="Salepayments ";
include "addsalepayments.php";
?>