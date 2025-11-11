<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantpayments_class.php");
require_once("../../auth/rules/Rules_class.php");

$saved="";

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/tenants/Tenants_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
require_once("../../em/houses/Houses_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once '../../fn/inctransactions/Inctransactions_class.php';
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/transactions/TransactionsDBO.php");
require_once '../../em/landlordpayables/Landlordpayables_class.php';
require_once '../../em/housetenants/Housetenants_class.php';
require_once("../../fn/imprests/Imprests_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once '../../em/plots/Plots_class.php';
require_once '../../em/closeaccounts/Closeaccounts_class.php';

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4259";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4257";//Add
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
$retrieve = $_GET['retrieve'];

if(!empty($retrieve))
	$obj->retrieve=$retrieve;

$error=$_GET['error'];
	
if(empty($obj->action)){
	

}
	
if($obj->action=="Save"){
	$tenantpayments=new Tenantpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shptenantpayments=$_SESSION['shptenantpayments'];
	$error=$tenantpayments->validates($obj);
	
	$closeaccounts = new Closeaccounts();
	$fields="*";
	$where=" where plotid=(select plotid from em_houses where id='$obj->houseid') and month='$obj->month' and year='$obj->year' and status=5";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$closeaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
	if(!empty($error)){
		$error=$error;
	}	
	elseif($closeaccounts->affectedRows>0){
		$error="Statement is closed already!";
	}
	elseif(empty($shptenantpayments)){
		$error="No items in the sale list!";
	}
	else{
		$tenantpayments=$tenantpayments->setObject($obj);
		$tenantpayments->tenantname=$obj->tenantname;
		if($obj->documentno=$tenantpayments->add($tenantpayments,$shptenantpayments)){
			$error=SUCCESS;
			$saved="Yes";
			$_SESSION['shptenantpayments']="";
			//redirect("addtenantpayments_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tenantpayments=new Tenantpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$shptenantpayments=$_SESSION['shptenantpayments'];
	$error=$tenantpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenantpayments=$tenantpayments->setObject($obj);		
		$tenantpayments->tenantname=$obj->tenantname;
		$tenantpayments->retrieve=$obj->retrieve;
		if($tenantpayments->edit($tenantpayments,"",$shptenantpayments)){
			$error=UPDATESUCCESS;
			$_SESSION['shptenantpayments']="";
			$saved="Yes";
			//redirect("addtenantpayments_proc.php?error=".$error);
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
	$shptenantpayments=$_SESSION['shptenantpayments'];

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
	
	$obj->total+=$obj->amount;
	$shptenantpayments[$it]=array('paymenttermid'=>"$obj->paymenttermid",'houseid'=>"$obj->houseid", 'housename'=>"$houses->name", 'paymenttermname'=>"$paymentterms->name", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks", 'month'=>"$obj->month", 'year'=>"$obj->year", 'total'=>"$obj->total",'createdby'=>"$obj->createdby",'createdon'=>"$obj->createdon");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shptenantpayments']=$shptenantpayments;

	$obj->paymenttermname="";
 	$obj->paymenttermid="";
 	$obj->total=0;
	$obj->amount="";
 	$obj->remarks="";
 	$obj->month="";
 	$obj->year="";
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


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tenantpayments=new Tenantpayments();
	$where=" where id=$id ";
	$fields="em_tenantpayments.id, em_tenantpayments.tenantid, em_tenantpayments.documentno, em_tenantpayments.paymenttermid, em_tenantpayments.paymentmodeid, em_tenantpayments.bankid, em_tenantpayments.chequeno, em_tenantpayments.amount, em_tenantpayments.paidon, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.paidby, em_tenantpayments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenantpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tenantpayments->fetchObject;

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
	if(!empty($obj->receiptno)){
		$tenantpayments = new Tenantpayments();
		$fields="em_tenantpayments.id, em_tenantpayments.tenantid, em_tenantpayments.houseid, em_tenantpayments.documentno, em_paymentterms.id as paymenttermid, em_paymentterms.name paymenttermname, sys_paymentmodes.id as paymentmodeid, fn_banks.id as bankid, em_tenantpayments.chequeno, em_tenantpayments.amount, em_tenantpayments.paidon, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.paidby, em_tenantpayments.remarks, em_tenantpayments.createdby, em_tenantpayments.createdon";
		$join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_tenantpayments.documentno='$obj->receiptno' ";
		$tenantpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$tenantpayments->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shptenantpayments[$it]=array('paymenttermid'=>"$ob->paymenttermid",'houseid'=>"$ob->houseid", 'housename'=>"$ob->name", 'paymenttermname'=>"$ob->paymenttermname", 'amount'=>"$ob->amount", 'remarks'=>"$ob->remarks", 'month'=>"$ob->month", 'year'=>"$ob->year", 'total'=>"$ob->total",'createdby'=>"$ob->createdby",'createdon'=>"$ob->createdon");

			$it++;
		}

		$_SESSION['shptenantpayments']=$shptenantpayments;
		
		//for autocompletes
		$tenants = new Tenants();
		$fields=" em_tenants.*, em_houses.hseno, em_plots.name plotname ";
		$where=" where em_tenants. id='$ob->tenantid'";
		$join=" left join em_housetenants on em_tenants.id=em_housetenants.tenantid left join em_houses on em_houses.id=em_housetenants.houseid  left join em_plots on em_houses.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$auto=$tenants->fetchObject;
		$auto->tenantname=$auto->firstname." ".$auto->middlename." ".$auto->lastname;
		
		$houses = new Houses();
		$fields="em_plots.name plotname, em_houses.plotid, em_houses.hseno";
		$where=" where em_houses.id='$ob->houseid'";
		$join=" left join em_plots on em_houses.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$houses=$houses->fetchObject;
		
		

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		$obj = (object) array_merge((array) $obj, (array) $houses);
		
		$obj->action="Update";

		$obj->iterator=$it;
		$_SESSION['shptenantpayments']=$shptenantpayments;
	}
}

if($obj->action=="Reverse"){
  $tenantpayments = new Tenantpayments();
  $fields=" em_tenantpayments.tenantid, em_tenantpayments.houseid, em_paymentterms.id as paymenttermid, em_paymentterms.name paymenttermname, sys_paymentmodes.id as paymentmodeid, fn_banks.id as bankid, em_tenantpayments.chequeno, em_tenantpayments.amount, em_tenantpayments.paidon, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.paidby, em_tenantpayments.remarks, em_tenantpayments.createdon, em_tenantpayments.createdby";
  $join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where em_tenantpayments.documentno='$obj->documentno' ";
  $tenantpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $tenantpayments->sql;
  $res=$tenantpayments->result;
  $it=0;
  while($row=mysql_fetch_object($res)){
	  $ob=$row;
		  //echo $ob->paymenttermname." = ".$ob->amount."<br/>";
	  $ob->amount*=-1;
	  $ob->total*=-1;
	  $shptenantpayments[$it]=array('paymenttermid'=>"$ob->paymenttermid",'houseid'=>"$ob->houseid", 'housename'=>"$ob->name", 'paymenttermname'=>"$ob->paymenttermname", 'amount'=>"$ob->amount", 'remarks'=>"$ob->remarks", 'month'=>"$ob->month", 'year'=>"$ob->year", 'total'=>"$ob->total",'remarks'=>"Reversal",'createdon'=>"$ob->createdon",'createdby'=>"$ob->createdby");

	  $it++;
  }
  
  $_SESSION['shptenantpayments']=$shptenantpayments;
  
  //for autocompletes
  $tenants = new Tenants();
  $fields=" em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.code, em_houses.hseno, em_houses.id houseid, em_plots.name plotname, em_plots.id plotid ";
  $where=" where em_tenants. id='$ob->tenantid'";
  $join=" left join em_housetenants on em_tenants.id=em_housetenants.tenantid left join em_houses on em_houses.id=em_housetenants.houseid  left join em_plots on em_houses.plotid=em_plots.id ";
  $having="";
  $groupby="";
  $orderby="";
  $tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
  $auto=$tenants->fetchObject;
  $auto->tenantname=$auto->firstname." ".$auto->middlename." ".$auto->lastname;

  $obj = (object) array_merge((array) $obj, (array) $ob);
  $obj = (object) array_merge((array) $obj, (array) $auto);
  
  $obj->id="";
  $obj->remarks="Reversal";
  $tenantpayments=$tenantpayments->setObject($obj);
  $tenantpayments->tenantname=$obj->tenantname;
  $tenantpayments->retrieve=1;
  if($tenantpayments->add($tenantpayments,$shptenantpayments)){
	  $error=SUCCESS;
	  $saved="Yes";
	  $_SESSION['shptenantpayments']="";
	  //redirect("addtenantpayments_proc.php?error=".$error);
  }
  else{
	  $error=FAILURE;
  }
}

if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit']) and empty($obj->retrieve)){
		$obj->action="Save";
		$obj->year=date("Y");
		$obj->month=date("m");
		
		$obj->paidon=date('Y-m-d');

		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) as documentno from em_tenantpayments"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
	}
	else{
		$ob = str_replace("'","\"",$_GET['obj']);
		$ob = str_replace("\\","",$ob);
		$ob = unserialize($ob);
		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj->action="Update";
	}
	if(empty($obj->action2))
		$_SESSION['shptenantpayments']="";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}

$page_title="Tenantpayments ";
include "addtenantpayments.php";
?>