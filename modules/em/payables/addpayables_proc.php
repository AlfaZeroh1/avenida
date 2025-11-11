<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$saved="No";

require_once("../../em/houses/Houses_class.php");
require_once("../../em/tenants/Tenants_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
require_once '../../em/managementfees/Managementfees_class.php';
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4255";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4253";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


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
	$payables=new Payables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shppayables=$_SESSION['shppayables'];
	$error=$payables->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppayables)){
		$error="No items in the list!";
	}
	else{
		$payables=$payables->setObject($obj);
		if($payables->add($payables,$shppayables)){
			$error=SUCCESS;
			//redirect("addpayables_proc.php?error=".$error);
			$saved="Yes";
			$_SESSION['shppayables']="";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payables=new Payables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payables=$payables->setObject($obj);
		$shppayables=$_SESSION['shppayables'];
		$payables->retrieve=$obj->retrieve;
		if($payables->edit($payables,"",$shppayables)){
			$error=UPDATESUCCESS;
			$saved="Yes";
			$_SESSION['shppayables']="";
			//redirect("addpayables_proc.php?error=".$error);
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
	elseif(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	elseif(empty($obj->amount)){
		$error="Amount must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shppayables=$_SESSION['shppayables'];

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
	
	$amount=$obj->quantity*$obj->amount;
	$obj->mgtfeeamount = $obj->mgtfee*($amount)/100;
	
	$obj->total=$amount+$obj->mgtfeeamount;
	
	$shppayables[$it]=array('vatclasseid'=>"$obj->vatclasseid", 'mgtfee'=>"$obj->mgtfee", 'mgtfeevatclasseid'=>"$obj->mgtfeevatclasseid", 'houseid'=>"$obj->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$obj->mgtfeeamount", 'vatamount'=>"$obj->vatamount", 'mgtfeevatamount'=>"$obj->mgtfeevatamount", 'paymenttermid'=>"$obj->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$obj->quantity", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppayables']=$shppayables;

	$obj->paymenttermname="";
 	$obj->paymenttermid="";
 	$obj->total=0;
	$obj->quantity="";
 	$obj->amount="";
 	$obj->remarks="";
 }
}

if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$tenants= new Tenants();
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$payables=new Payables();
	$where=" where id=$id ";
	$fields="em_payables.id, em_payables.documentno, em_payables.paymenttermid, em_payables.houseid, em_payables.tenantid, em_payables.month, em_payables.year, em_payables.invoicedon, em_payables.quantity, em_payables.amount, em_payables.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payables->fetchObject;

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
	$paymentterms = new Paymentterms();
	$fields=" * ";
	$where=" where id='$obj->paymenttermid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$paymentterms->fetchObject;

	$obj->paymenttermname=$auto->name;
}

	
if($obj->action2=="Filter"){
	if(!empty($obj->invoiceno)){
		$payables = new Payables();
		$fields="em_payables.id, em_payables.documentno,em_payables.tenantid,em_payables.total,em_payables.paymenttermid, em_paymentterms.name as paymenttermname, em_houses.id as houseid, em_payables.month, em_payables.year, em_payables.invoicedon, em_payables.quantity, em_payables.amount, em_payables.remarks";
		$join=" left join em_paymentterms on em_payables.paymenttermid=em_paymentterms.id  left join em_houses on em_payables.houseid=em_houses.id  left join em_tenants on em_payables.tenantid=em_tenants.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->invoiceno' ";
		$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payables->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
			
			$ob=$row;
			$shppayables[$it]=array('vatclasseid'=>"$row->vatclasseid", 'mgtfee'=>"$row->mgtfee", 'mgtfeevatclasseid'=>"$row->mgtfeevatclasseid", 'houseid'=>"$row->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$row->mgtfeeamount", 'vatamount'=>"$row->vatamount", 'mgtfeevatamount'=>"$row->mgtfeevatamount", 'paymenttermid'=>"$row->paymenttermid", 'paymenttermname'=>"$row->paymenttermname", 'quantity'=>"$row->quantity", 'amount'=>"$row->amount", 'remarks'=>"$row->remarks", 'total'=>"$row->total",'createdby'=>"$ob->createdby",'createdon'=>"$ob->createdon");
				
			$it++;
		}
		
		//for autocompletes
		$tenants = new Tenants();
		$fields=" * ";
		$where=" where id='$ob->tenantid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $tenants->sql;
		$auto=$tenants->fetchObject;
		$auto->tenantname=$auto->code." ".$auto->firstname." ".$auto->middlename." ".$auto->lastname;
		
		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		
		$obj->action="Update";
		
		$obj->iterator=$it;
		$_SESSION['shppayables']=$shppayables;
	}
}

if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit']) and empty($obj->retrieve)){
		$_SESSION['shpayables']="";
		$obj->action="Save";
		$obj->year=date("Y");
		$obj->month=date("m");
		$obj->quantity=1;
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from em_payables"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;

		$obj->invoicedon=date('Y-m-d');
		
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
	
$page_title="Payables ";
include "addpayables.php";
?>