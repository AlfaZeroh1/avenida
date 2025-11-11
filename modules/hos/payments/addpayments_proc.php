<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payments_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../hos/payables/Payables_class.php';
require_once("../../hos/insurances/Insurances_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patients/Patients_class.php");
require_once("../../sys/transactions/Transactions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1305";//Edit
}
else{
	$auth->roleid="1303";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);

$saved="";

//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->status)){
  $obj->status=$ob->status;
}

if(!empty($ob->retrieve))
  $obj->retrieve=$ob->retrieve;

if(!empty($ob->action3)){
  $obj=$ob;
  
  
  $payables = new Payables();
  $fields="*";
  $where=" where id='$ob->tid'";
  $having="";
  $groupby="";
  $orderby="";
  $payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $payables=$payables->fetchObject;
  
  $payments = new Payments();
  $fields=" sum(amount) amount ";
  $join="";
  $where=" where payableid='$payables->id' ";
  $having="";
  $groupby="";
  $orderby="";
  $payments->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $payments->sql;
  $payments=$payments->fetchObject;
  
  $obj->transactionid=$payables->transactionid;
  $obj->payableid=$payables->id;
  $obj->amount=$payables->amount-$payments->amount;
  $obj->remarks=$payables->remarks;
}

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
	
if(empty($obj->action)){
	$defs=@mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from hos_payments"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->paidon=date("Y-m-d");

}
	

if($obj->action=="Save"){
	$payments=new Payments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$shppayments=$_SESSION['shppayments'];
	$error=$payments->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shppayments)){
		$error="No items in the sale list!";
	}
	else{
		$payments=$payments->setObject($obj);
		$payments->status=$obj->status;
		if($payments->add($payments,$shppayments)){
			$error=SUCCESS;
			
			unset($_SESSION['shppayments']);
			//redirect("addpayments_proc.php?id=".$payments->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payments=new Payments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payments=$payments->setObject($obj);
		$shppayments=$_SESSION['shppayments'];
		if($payments->edit($payments,$shppayments)){
			$error=UPDATESUCCESS;
			//redirect("addpayments_proc.php?id=".$payments->id."&error=".$error);
			$saved="Yes";
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

if($obj->action2=="Filter"){
	if(!empty($obj->receiptno)){  
		$payments = new Payments();
		$fields="hos_payments.id, hos_payments.documentno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientname, hos_patients.id patientid, sys_transactions.name as transactionname, sys_transactions.id transactionid, hos_payments.payee, hos_payments.amount, hos_payments.remarks, hos_payments.paidon, hos_payments.consult, hos_payments.createdby, hos_payments.createdon, hos_payments.lasteditedby, hos_payments.lasteditedon";
		$join=" left join hos_patients on hos_payments.patientid=hos_patients.id  left join sys_transactions on hos_payments.transactionid=sys_transactions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_payments.documentno='$obj->receiptno' ";
		$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$payments->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			$ob=$row;
			$shppayments[$it]=array('transactionid'=>"$ob->transactionid", 'transactionname'=>"$ob->transactionname", 'amount'=>"$ob->amount", 'remarks'=>"$ob->remarks", 'total'=>"$ob->total",'tid'=>"$ob->tid",'payableid'=>"$ob->payableid");

			$it++;
		}

		$_SESSION['shppayments']=$shppayments;
		
		

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj = (object) array_merge((array) $obj, (array) $auto);
		
		$obj->action="Update";

		$obj->iterator=$it;
		$_SESSION['shppayments']=$shppayments;
	}
}

if($obj->action2=="Add"){

	if(empty($obj->transactionid)){
		$error="Bill Term must be provided";
	}
	elseif(empty($obj->amount)){
		$error="Amount must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator)){
		$it=0;
		$_SESSION['shppayments']="";
	}
	else
		$it=$obj->iterator;
	$shppayments=$_SESSION['shppayments'];

	$transactions = new Transactions();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->transactionid'";
	$transactions->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$transactions=$transactions->fetchObject;

	;
	$shppayments[$it]=array('transactionid'=>"$obj->transactionid", 'transactionname'=>"$transactions->name", 'amount'=>"$obj->amount", 'remarks'=>"$obj->remarks", 'total'=>"$obj->total",'tid'=>"$obj->tid",'payableid'=>"$obj->payableid",'departmentid'=>"$obj->departmentid");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shppayments']=$shppayments;
 	
 	$obj->action3="Retrieve";

	$obj->transactionname="";
 	$obj->transactionid="";
 	$obj->amount="";
 	$obj->remarks="";
 	$obj->tid="";
 }
}

if($obj->action3=="Retrieve"){
	if(empty($obj->treatmentid)){
		$error="Must provide Treatment";
	}
	else{
		if(empty($obj->iterator)){			
		  $_SESSION['shppayments']="";
		}
		$patients = new Patients();
		$fields="hos_patients.*";
		if($obj->consult>0){
		$query="select * from hos_patientappointments where id='$obj->treatmentid'";
		$rs = mysql_query($query);
		if(mysql_affected_rows()>0){
		  $join=" left join hos_patientappointments on hos_patientappointments.patientid=hos_patients.id ";
		  $where=" where hos_patientappointments.id='$obj->treatmentid'";
		}
		else{
		  $join=" left join hos_patientappointments on hos_patientappointments.patientid=hos_patients.id ";
		  $where=" where hos_patientappointments.id='$obj->treatmentid' ";
		}
		}
		else{
		  $join=" left join hos_payables on hos_payables.patientid=hos_patients.id ";
		  $where=" where hos_payables.treatmentno='$obj->treatmentid' and hos_payables.consult=0 ";
		}
// 		if(!empty($where))
// 		  $where.=" and ";
// 		else
// 		  $where.=" where ";
// 		  
// 		$where.=" hos_patients.id='$obj->patientid' ";
		$having="";
		$groupby="";
		$orderby="";
		$patients->retrieve($fields, $join, $where, $having, $groupby, $orderby); //echo $patients->sql;
		$patients=$patients->fetchObject;
		if(!empty($patients->id)){
		 $obj->patientid=$patients->id;
		 $obj->patientname=$patients->surname." ".$patients->othernames;
		 $obj->patientno=$patients->patientno;
		 $obj->address = $patients->address;
		}
		else{
		    $patients = new Patients();
		    $fields=" * ";
		    $join="";
		    $where=" where hos_patients.id='$obj->patientid' ";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $patients->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $patients=$patients->fetchObject;
		    
		    $obj->patientid=$patients->id;
		    $obj->patientname=$patients->surname." ".$patients->othernames;
		    $obj->patientno=$patients->patientno;
		    $obj->address = $patients->address;
		    
		}
		$obj->treatmentno=$obj->treatmentid;
		
		
		$generaljournals = new Generaljournals();
		$fields=" fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.remarks, fn_generaljournals.documentno, fn_generaljournals.transactdate, sys_transactions.name transactionid";
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join hos_patients on hos_patients.id=fn_generaljournalaccounts.refid ";
		$where=" where hos_patients.id='$patients->id' ";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		
	}
}


if(empty($obj->action)){

	$patients= new Patients();
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$transactions= new Transactions();
	$fields="sys_transactions.id, sys_transactions.name, sys_transactions.moduleid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$payments=new Payments();
	$where=" where id=$id ";
	$fields="hos_payments.id, hos_payments.documentno, hos_payments.patientid, hos_payments.transactionid, hos_payments.payee, hos_payments.amount, hos_payments.remarks, hos_payments.paidon, hos_payments.consult, hos_payments.createdby, hos_payments.createdon, hos_payments.lasteditedby, hos_payments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payments->fetchObject;

	//for autocompletes
	$patients = new Patients();
	$fields=" * ";
	$where=" where id='$obj->patientid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$patients->fetchObject;

	$obj->patientname=$auto->name;
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
	
	
$page_title="Payments ";
include "addpayments.php";
?>