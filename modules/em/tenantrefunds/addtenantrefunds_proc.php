<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantrefunds_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/tenants/Tenants_class.php");
require_once("../../em/houses/Houses_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4335";//Edit
}
else{
	$auth->roleid="4333";//Add
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
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) as documentno from em_tenantrefunds"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->refundedon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$tenantrefunds=new Tenantrefunds();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shptenantrefunds=$_SESSION['shptenantrefunds'];
	$error=$tenantrefunds->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shptenantrefunds)){
		$error="No items in the sale list!";
	}
	else{
		$tenantrefunds=$tenantrefunds->setObject($obj);
		if($tenantrefunds->add($tenantrefunds,$shptenantrefunds)){
			$error=SUCCESS;
			redirect("addtenantrefunds_proc.php?id=".$tenantrefunds->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tenantrefunds=new Tenantrefunds();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tenantrefunds->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenantrefunds=$tenantrefunds->setObject($obj);
		$shptenantrefunds=$_SESSION['shptenantrefunds'];
		if($tenantrefunds->edit($tenantrefunds,$shptenantrefunds)){
			$error=UPDATESUCCESS;
			redirect("addtenantrefunds_proc.php?id=".$tenantrefunds->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->paymenttermid)){
		$error="Paymnet Term must be provided";
	}
	elseif(empty($obj->amount)){
		$error="Amount must be provided";
	}
	elseif(empty($obj->houseid)){
		$error="House must be provided";
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
	$shptenantrefunds=$_SESSION['shptenantrefunds'];

	$paymentterms = new Paymentterms();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->paymenttermid'";
	$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$paymentterms=$paymentterms->fetchObject;
	$houses = new Houses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->houseid'";
	$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$houses=$houses->fetchObject;

	;
	$shptenantrefunds[$it]=array('paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'houseid'=>"$obj->houseid", 'housename'=>"$houses->name", 'month'=>"$obj->month", 'year'=>"$obj->year", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shptenantrefunds']=$shptenantrefunds;

	$obj->paymenttermname="";
 	$obj->paymenttermid="";
 	$obj->amount="";
 	$obj->housename="";
 	$obj->houseid="";
 	$obj->month="";
 	$obj->year="";
 	$obj->remarks="";
 }
}

if(empty($obj->action)){

	$tenants= new Tenants();
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.penalty, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.remarks";
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
	$tenantrefunds=new Tenantrefunds();
	$where=" where id=$id ";
	$fields="em_tenantrefunds.id, em_tenantrefunds.documentno, em_tenantrefunds.tenantid, em_tenantrefunds.houseid, em_tenantrefunds.paymenttermid, em_tenantrefunds.amount, em_tenantrefunds.refundedon, em_tenantrefunds.paymentmodeid, em_tenantrefunds.bankid, em_tenantrefunds.chequeno, em_tenantrefunds.month, em_tenantrefunds.year, em_tenantrefunds.receivedby, em_tenantrefunds.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenantrefunds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tenantrefunds->fetchObject;

	//for autocompletes
	$tenants = new Tenants();
	$fields=" * ";
	$where=" where id='$obj->tenantid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$tenants->fetchObject;

	$obj->tenantname=$auto->name;
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
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Tenantrefunds ";
include "addtenantrefunds.php";
?>