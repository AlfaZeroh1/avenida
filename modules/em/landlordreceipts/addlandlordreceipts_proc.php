<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlordreceipts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/landlords/Landlords_class.php");
require_once("../../em/plots/Plots_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once '../../fn/inctransactions/Inctransactions_class.php';
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4343";//Edit
}
else{
	$auth->roleid="4341";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);

$saved="";

//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
	
if(empty($obj->action)){
	

}
	
if($obj->action=="Save"){
	$landlordreceipts=new Landlordreceipts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shplandlordreceipts=$_SESSION['shplandlordreceipts'];
	$error=$landlordreceipts->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shplandlordreceipts)){
		$error="No items in the sale list!";
	}
	else{
		$landlordreceipts=$landlordreceipts->setObject($obj);
		$landlordreceipts->landlordname=$obj->landlordname;
		if($landlordreceipts->add($landlordreceipts,$shplandlordreceipts)){
			$error=SUCCESS;
			//redirect("addlandlordpayments_proc.php?id=".$landlordreceipts->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$landlordreceipts=new Landlordreceipts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$landlordreceipts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlordreceipts=$landlordreceipts->setObject($obj);
		$shplandlordreceipts=$_SESSION['shplandlordreceipts'];
		$landlordreceipts->landlordname=$obj->landlordname;
		if($landlordreceipts->edit($landlordreceipts,"",$shplandlordreceipts)){
			$error=UPDATESUCCESS;
			$saved="Yes";
			//redirect("addlandlordpayments_proc.php?id=".$landlordreceipts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->paymenttermid)){
		$error="Payment Term must be provided";
	}
	elseif(empty($obj->amount)){
		$error="Amount must be provided";
	}
	elseif(empty($obj->plotid)){
		$error="Plot must be provided";
	}
	elseif(empty($obj->month)){
		$error="Month must be provided";
	}
	elseif(empty($obj->year)){
		$error="Year must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shplandlordreceipts=$_SESSION['shplandlordreceipts'];

	$paymentterms = new Paymentterms();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->paymenttermid'";
	$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentterms=$paymentterms->fetchObject;
	$plots = new Plots();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->plotid'";
	$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$plots=$plots->fetchObject;

	;
	$shplandlordreceipts[$it]=array('paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'plotid'=>"$obj->plotid", 'plotname'=>"$plots->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shplandlordreceipts']=$shplandlordreceipts;

	$obj->paymenttermname="";
 	$obj->paymenttermid="";
 	$obj->amount="";
 	$obj->plotname="";
 	$obj->plotid="";
 	$obj->month="";
 	$obj->year="";
 	$obj->remarks="";
 }
}

if(empty($obj->action)){

	$landlords= new Landlords();
	$fields="em_landlords.id, em_landlords.llcode, em_landlords.firstname, em_landlords.middlename, em_landlords.lastname, em_landlords.tel, em_landlords.email, em_landlords.registeredon, em_landlords.fax, em_landlords.mobile, em_landlords.idno, em_landlords.passportno, em_landlords.postaladdress, em_landlords.address, em_landlords.deductcommission, em_landlords.status";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$plots= new Plots();
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.depositmgtfee, em_plots.vatable, em_plots.status, em_plots.penaltydate, em_plots.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$landlordreceipts=new Landlordreceipts();
	$where=" where id=$id ";
	$fields="em_landlordpayments.id, em_landlordpayments.documentno, em_landlordpayments.landlordid, em_landlordpayments.plotid, em_landlordpayments.paymenttermid, em_landlordpayments.paymentmodeid, em_landlordpayments.bankid, em_landlordpayments.chequeno, em_landlordpayments.amount, em_landlordpayments.paidon, em_landlordpayments.month, em_landlordpayments.year, em_landlordpayments.receivedby, em_landlordpayments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlordreceipts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$landlordreceipts->fetchObject;

	//for autocompletes
	$landlords = new Landlords();
	$fields=" * ";
	$where=" where id='$obj->landlordid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$landlords->fetchObject;

	$obj->landlordname=$auto->name;
}


if($obj->action2=="Filter"){
	if(!empty($obj->voucherno)){
		$landlordreceipts = new Landlordreceipts();
		$fields="em_landlordreceipts.id, em_landlordreceipts.documentno, em_landlords.id as landlordid, em_plots.id as plotid, em_plots.name plotname, em_paymentterms.id as paymenttermid, em_paymentterms.name paymenttermname, sys_paymentmodes.id as paymentmodeid, fn_banks.id as bankid, em_landlordreceipts.chequeno, em_landlordreceipts.amount, em_landlordreceipts.paidon, em_landlordreceipts.month, em_landlordreceipts.year, em_landlordreceipts.receivedby, em_landlordreceipts.remarks";
		$join=" left join em_landlords on em_landlordreceipts.landlordid=em_landlords.id  left join em_plots on em_landlordreceipts.plotid=em_plots.id  left join em_paymentterms on em_landlordreceipts.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_landlordreceipts.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_landlordreceipts.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->voucherno' ";
		$landlordreceipts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$landlordreceipts->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shplandlordreceipts[$it]=array('paymenttermid'=>"$row->paymenttermid", 'paymenttermname'=>"$row->paymenttermname", 'amount'=>"$row->amount", 'plotid'=>"$row->plotid", 'plotname'=>"$row->plotname", 'month'=>"$row->month", 'year'=>"$row->year", 'remarks'=>"$row->remarks", 'total'=>"$row->total");

			$it++;
		}

		//for autocompletes
		$landlords = new Landlords();
		$fields=" * ";
		$where=" where id='$ob->landlordid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$landlords->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$auto=$landlords->fetchObject;
		$auto->landlordname=$auto->firstname." ".$auto->middlename." ".$auto->lastname;

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);

		$obj->action="Update";
		
		$obj->iterator=$it;
		$_SESSION['shplandlordreceipts']=$shplandlordreceipts;
	}
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit']) and empty($obj->retrieve)){
		$obj->action="Save";
		
		$obj->year=date("Y");
		$obj->month=date("m");
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) as documentno from em_landlordreceipts"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;

		$obj->paidon=date('Y-m-d');
	}
	else{
		$ob = str_replace("'","\"",$_GET['obj']);
		$ob = unserialize($ob);
		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj->action="Update";
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}	
$page_title="Landlordreceipts ";
include "addlandlordreceipts.php";
?>