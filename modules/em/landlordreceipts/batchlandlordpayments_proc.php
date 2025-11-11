<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlordpayments_class.php");
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
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) as documentno from em_landlordpayments"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->paidon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$landlordpayments=new Landlordpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shplandlordpayments=$_SESSION['shplandlordpayments'];
	$error=$landlordpayments->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shplandlordpayments)){
		$error="No items in the sale list!";
	}
	else{
		$i=0;
		$num=count($shplandlordpayments);
			while($i<$num){
				$landlordpayments=$landlordpayments->setObject($obj);
				$shop=array();
				$shop[0]=$shplandlordpayments[$i];
				if($landlordpayments->add($landlordpayments,$shop,true)){
					$error=SUCCESS;
					//redirect("addlandlordpayments_proc.php?id=".$landlordpayments->id."&error=".$error);
					
				}
				else{
					$error=FAILURE;
				}
				
				$i++;
			}
			$saved="Yes";
	}
}
	
if($obj->action=="Update"){
	$landlordpayments=new Landlordpayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$landlordpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$landlordpayments=$landlordpayments->setObject($obj);
		$shplandlordpayments=$_SESSION['shplandlordpayments'];
		if($landlordpayments->edit($landlordpayments,$shplandlordpayments)){
			$error=UPDATESUCCESS;
			redirect("addlandlordpayments_proc.php?id=".$landlordpayments->id."&error=".$error);
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
	$shplandlordpayments=$_SESSION['shplandlordpayments'];

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

	$shplandlordpayments[$it]=array('landlordid'=>"$obj->landlordid",'landlordname'=>"$obj->landlordname", 'paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'plotid'=>"$obj->plotid", 'plotname'=>"$plots->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shplandlordpayments']=$shplandlordpayments;

	$obj->paymenttermname="";
 	$obj->paymenttermid="";
 	$obj->amount="";
 	$obj->plotname="";
 	$obj->plotid="";
 	$obj->month="";
 	$obj->year="";
 	$obj->remarks="";
 	$obj->landlordid="";
 	$obj->landlordname="";
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
	$landlordpayments=new Landlordpayments();
	$where=" where id=$id ";
	$fields="em_landlordpayments.id, em_landlordpayments.documentno, em_landlordpayments.landlordid, em_landlordpayments.plotid, em_landlordpayments.paymenttermid, em_landlordpayments.paymentmodeid, em_landlordpayments.bankid, em_landlordpayments.chequeno, em_landlordpayments.amount, em_landlordpayments.paidon, em_landlordpayments.month, em_landlordpayments.year, em_landlordpayments.receivedby, em_landlordpayments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$landlordpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$landlordpayments->fetchObject;

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
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		
		$obj->year=date("Y");
		$obj->month=date("m");
	}
	else{
		$obj=$_SESSION['obj'];
	}
	if(empty($obj->action2))
		$_SESSION['shplandlordpayments']="";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	

if($obj->action=="Filter"){
	if(!empty($obj->voucherno)){
		$landlordpayments = new Landlordpayments();
		$fields="em_landlordpayments.id, em_landlordpayments.documentno, em_landlordpayments.landlordid, em_plots.name as plotid, em_landlordpayments.paymenttermid, em_landlordpayments.paymentmodeid, em_landlordpayments.bankid, em_landlordpayments.chequeno, em_landlordpayments.amount, em_landlordpayments.paidon, em_landlordpayments.month, em_landlordpayments.year, em_landlordpayments.receivedby, em_landlordpayments.remarks";
		$join=" left join em_landlords on em_landlordpayments.landlordid=em_landlords.id  left join em_plots on em_landlordpayments.plotid=em_plots.id  left join em_paymentterms on em_landlordpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_landlordpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_landlordpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->voucherno' ";
		$landlordpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$landlordpayments->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shplandlordpayments[$it]=array('landlordid'=>"$obj->landlordid",'landlordname'=>"$obj->landlordname", 'paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'plotid'=>"$obj->plotid", 'plotname'=>"$plots->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

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

		$obj->iterator=$it;
		$_SESSION['shppayables']=$shppayables;
	}
}
	
$page_title="Landlordpayments ";
include "batchlandlordpayments.php";
?>