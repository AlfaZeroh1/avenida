<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inctransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/incomes/Incomes_class.php");
require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../crm/customers/Customers_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once '../../sys/paymentmodes/Paymentmodes_class.php';
require_once '../../fn/banks/Banks_class.php';
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../con/projects/Projects_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="753";//Edit
}
else{
	$auth->roleid="751";//Add
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
	$inctransactions=new Inctransactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpinctransactions=$_SESSION['shpinctransactions'];
	$error=$inctransactions->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpinctransactions)){
		$error="No items in the sale list!";
	}
	else{
		$inctransactions=$inctransactions->setObject($obj);
		if($inctransactions->add($inctransactions,$shpinctransactions)){
			$error=SUCCESS;
			$saved="Yes";
			$_SESSION['shpinctransactions']="";
			//redirect("addinctransactions_proc.php?id=".$inctransactions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$inctransactions=new Inctransactions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shpinctransactions=$_SESSION['shpinctransactions'];
	$error=$inctransactions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inctransactions=$inctransactions->setObject($obj);
		if($inctransactions->edit($inctransactions,'',$shpinctransactions)){
			$error=SUCCESS;
			$saved="Yes";
			
			$_SESSION['shpinctransactions']="";
			//redirect("addinctransactions_proc.php?id=".$inctransactions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->incomeid) and empty($obj->paymentid)){
		$error="Income/Payment must be provided";
	}
	elseif(!empty($obj->incomeid) and !empty($obj->paymentid)){
		$error="Either Income or Payment must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpinctransactions=$_SESSION['shpinctransactions'];

	$incomes = new Incomes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->incomeid'";
	$incomes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$incomes=$incomes->fetchObject;

	;
	$shpinctransactions[$it]=array('incomeid'=>"$obj->incomeid", 'incomename'=>"$incomes->name",'paymentid'=>"$obj->paymentid",'paymentname'=>"$payments->name",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$obj->quantity", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo", 'total'=>"$obj->total",'month'=>"$obj->month",'year'=>"$obj->year");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpinctransactions']=$shpinctransactions;

	$obj->incomename="";
 	$obj->incomeid="";
 	$obj->paymentname="";
 	$obj->paymentid="";
 	$obj->quantity="";
 	$obj->tax="";
 	$obj->discount="";
 	$obj->paymenttermid='';
 	$obj->amount="";
 	$obj->memo="";
 }
}
if($obj->action2=="Filter"){
	if(!empty($obj->invoiceno)){
		$inctransactions = new Inctransactions();
		$fields="fn_inctransactions.id, fn_incomes.name as incomename, fn_incomes.id incomeid, em_plots.name as plotname, em_plots.id plotid, em_paymentterms.name as paymenttermname, em_paymentterms.id paymenttermid, crm_customers.name as customername, crm_customers.id customerid, fn_inctransactions.quantity, fn_inctransactions.tax, fn_inctransactions.discount, fn_inctransactions.amount, fn_inctransactions.total, fn_inctransactions.incomedate, fn_inctransactions.month, fn_inctransactions.year, fn_inctransactions.paid, fn_inctransactions.remarks, fn_inctransactions.memo, fn_inctransactions.documentno, sys_paymentmodes.id as paymentmodeid, fn_banks.name as bankid, fn_imprestaccounts.name as imprestaccountid, fn_inctransactions.chequeno, fn_inctransactions.ipaddress, fn_inctransactions.createdby, fn_inctransactions.createdon, fn_inctransactions.lasteditedby, fn_inctransactions.lasteditedon";
		$join=" left join fn_incomes on fn_inctransactions.incomeid=fn_incomes.id  left join em_plots on fn_inctransactions.plotid=em_plots.id  left join em_paymentterms on fn_inctransactions.paymenttermid=em_paymentterms.id  left join crm_customers on fn_inctransactions.customerid=crm_customers.id left join sys_paymentmodes on fn_inctransactions.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_inctransactions.bankid=fn_banks.id  left join fn_imprestaccounts on fn_inctransactions.imprestaccountid=fn_imprestaccounts.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->invoiceno' ";
		$inctransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inctransactions->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shpinctransactions[$it]=array('incomeid'=>"$row->incomeid", 'incomename'=>"$row->incomename",'plotid'=>"$row->plotid",'plotname'=>"$row->plotname",'paymenttermid'=>"$row->paymenttermid" ,'paymenttermname'=>"$row->paymenttermname", 'quantity'=>"$row->quantity", 'tax'=>"$row->tax", 'discount'=>"$row->discount", 'amount'=>"$row->amount", 'memo'=>"$row->memo", 'total'=>"$row->total",'month'=>"$row->month",'year'=>"$row->year");

			$it++;
		}

		$obj = (object) array_merge((array) $obj, (array) $ob);
		
		$obj->action="Update";

		$obj->iterator=$it;
		$_SESSION['shpinctransactions']=$shpinctransactions;
	}
}

if(empty($obj->action)){

	$incomes= new Incomes();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	$customers= new Customers();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$ob->customerid'";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$customers = $customers->fetchObject;
	
	$obj->customerid=$customers->id;
	$obj->customername=$customers->name;
	
	$projects= new Projects();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id = '$ob->projectid'";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$projects = $projects->fetchObject;
	$obj->projectid=$projects->id;
	$obj->projectname=$projects->name;

}

if(!empty($id)){
	$inctransactions=new Inctransactions();
	$where=" where id=$id ";
	$fields="fn_inctransactions.id, fn_inctransactions.incomeid, fn_inctransactions.projectid, fn_inctransactions.customerid, fn_inctransactions.purchasemodeid, fn_inctransactions.quantity, fn_inctransactions.tax, fn_inctransactions.discount, fn_inctransactions.amount, fn_inctransactions.total, fn_inctransactions.incomedate, fn_inctransactions.paid, fn_inctransactions.remarks, fn_inctransactions.memo, fn_inctransactions.documentno, fn_inctransactions.ipaddress, fn_inctransactions.createdby, fn_inctransactions.createdon, fn_inctransactions.lasteditedby, fn_inctransactions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$inctransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $inctransactions->sql;
	$obj=$inctransactions->fetchObject;

	//for autocompletes
	$customers = new Customers();
	$fields=" * ";
	$where=" where id='$obj->customerid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$customers->fetchObject;

	$obj->customername=$auto->name;
	
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit']) and empty($obj->retrieve)){
		$obj->action="Save";
		$obj->month=date("m");
		$obj->year=date("Y");
		$obj->incomedate=date("Y-m-d");
		
		$rw = mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from fn_inctransactions"));
		if(empty($rw->documentno))
		  $rw->documentno=1;
		$obj->documentno=$rw->documentno;
	}
	else{
		$ob = str_replace("'","\"",$_GET['obj']);
		$ob = str_replace("\\","",$ob);
		$ob = unserialize($ob);
		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj->action="Update";
	}
	if(empty($obj->action2))
		$_SESSION['shpinctransactions']="";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Inctransactions ";
include "addinctransactions.php";
?>