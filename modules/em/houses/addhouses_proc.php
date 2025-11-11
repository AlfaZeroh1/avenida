<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houses_class.php");
require_once("../../auth/rules/Rules_class.php");

$tenantid = $_GET['tenantid'];

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/hsedescriptions/Hsedescriptions_class.php");
require_once("../../em/housestatuss/Housestatuss_class.php");
require_once("../../em/rentalstatuss/Rentalstatuss_class.php");
require_once("../../em/plots/Plots_class.php");
require_once("../../em/tenantdeposits/Tenantdeposits_class.php");
require_once("../../em/tenantrefunds/Tenantrefunds_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4109";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4107";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../em/houseutilitys/Houseutilitys_class.php");
require_once("../../em/plotutilitys/Plotutilitys_class.php");
require_once("../../em/utilitys/Utilitys_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");

//Process delete of houseutilitys
if(!empty($_GET['houseutilitys'])){
	$houseutilitys = new Houseutilitys();
	$houseutilitys->id=$_GET['houseutilitys'];
	$houseutilitys->delete($houseutilitys);
}
require_once("../../em/houseutilityexemptions/Houseutilityexemptions_class.php");
require_once("../../em/utilitys/Utilitys_class.php");

//Process delete of houseutilityexemptions
if(!empty($_GET['houseutilityexemptions'])){
	$houseutilityexemptions = new Houseutilityexemptions();
	$houseutilityexemptions->id=$_GET['houseutilityexemptions'];
	$houseutilityexemptions->delete($houseutilityexemptions);
}
require_once("../../em/houserentings/Houserentings_class.php");
require_once("../../em/tenants/Tenants_class.php");
require_once("../../em/rentaltypes/Rentaltypes_class.php");
require_once("../../em/payables/Payables_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../fn/liabilitys/Liabilitys_class.php");
require_once("../../fn/exptransactions/Exptransactions_class.php");

//Process delete of houserentings
if(!empty($_GET['houserentings'])){
	$houserentings = new Houserentings();
	$houserentings->id=$_GET['houserentings'];
	$houserentings->delete($houserentings);
}
require_once("../../em/houserents/Houserents_class.php");

//Process delete of houserents
if(!empty($_GET['houserents'])){
	$houserents = new Houserents();
	$houserents->id=$_GET['houserents'];
	$houserents->delete($houserents);
}
require_once("../../em/tenantpayments/Tenantpayments_class.php");
require_once("../../em/tenants/Tenants_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");

//Process delete of tenantpayments
if(!empty($_GET['tenantpayments'])){
	$tenantpayments = new Tenantpayments();
	$tenantpayments->id=$_GET['tenantpayments'];
	$tenantpayments->delete($tenantpayments);
}
require_once("../../em/housebreakages/Housebreakages_class.php");
require_once("../../em/tenants/Tenants_class.php");

//Process delete of housebreakages
if(!empty($_GET['housebreakages'])){
	$housebreakages = new Housebreakages();
	$housebreakages->id=$_GET['housebreakages'];
	$housebreakages->delete($housebreakages);
}


require_once("../../em/houseinspections/Houseinspections_class.php");
require_once("../../em/houses/Houses_class.php");
require_once("../../hrm/employees/Employees_class.php");

//Process delete of houseinspections
if(!empty($_GET['houseinspections'])){
	$houseinspections = new Houseinspections();
	$houseinspections->id=$_GET['houseinspections'];
	$houseinspections->delete($houseinspections);
}

require_once("../../em/housespecialdeposits/Housespecialdeposits_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");

//Process delete of housespecialdeposits
if(!empty($_GET['housespecialdeposits'])){
	$housespecialdeposits = new Housespecialdeposits();
	$housespecialdeposits->id=$_GET['housespecialdeposits'];
	$housespecialdeposits->delete($housespecialdeposits);
}
require_once("../../em/housespecialdepositexemptions/Housespecialdepositexemptions_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");

//Process delete of housespecialdepositexemptions
if(!empty($_GET['housespecialdepositexemptions'])){
	$housespecialdepositexemptions = new Housespecialdepositexemptions();
	$housespecialdepositexemptions->id=$_GET['housespecialdepositexemptions'];
	$housespecialdepositexemptions->delete($housespecialdepositexemptions);
}
require_once("../../em/housetenants/Housetenants_class.php");
//for merged foreign keys
require_once("../../em/tenants/Tenants_class.php");


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
	
	
if($obj->action=="Save"){
	$houses=new Houses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$houses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houses=$houses->setObject($obj);
		if($houses->add($houses)){
			$error=SUCCESS;
			redirect("addhouses_proc.php?id=".$houses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$houses=new Houses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$houses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houses=$houses->setObject($obj);
		if($houses->edit($houses)){
			$error=UPDATESUCCESS;
			redirect("addhouses_proc.php?id=".$houses->id."&error=".$error."#tabs-1");
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of houseutilitys
if($obj->action=="Add Houseutility"){
	$houseutilitys = new Houseutilitys();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->utilityid=$obj->houseutilitysutilityid;
	$ob->amount=$obj->houseutilitysamount;
	$ob->showinst=$obj->houseutilitysshowinst;
	$ob->remarks=$obj->houseutilitysremarks;
	$ob->paymenttermid=$obj->houseutilityspaymenttermid;
	$ob->mgtfeevatable=$obj->houseutilitysmgtfeevatable;
	$ob->vatclasseid=$obj->houseutilitysvatclasseid;
	$ob->vatable=$obj->houseutilitysvatable;
	$ob->mgtfeeperc=$obj->houseutilitysmgtfeeperc;
	$ob->mgtfee=$obj->houseutilitysmgtfee;
	$ob->mgtfeevatclasseid=$obj->houseutilitysmgtfeevatclasseid;

	$error=$houseutilitys->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houseutilitys->setObject($ob);
		
		if($houseutilitys->add($houseutilitys)){
			$obj->houseutilitysutilityid="";
			$obj->houseutilitysamount="";
			$obj->houseutilitysshowinst="";
			$obj->houseutilitysremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-3");
}


//Process adding of houseutilityexemptions
if($obj->action=="Add Houseutilityexemption"){
	$houseutilityexemptions = new Houseutilityexemptions();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->utilityid=$obj->houseutilityexemptionsutilityid;
	$ob->remarks=$obj->houseutilityexemptionsremarks;

	$error=$houseutilityexemptions->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houseutilityexemptions->setObject($ob);

		if($houseutilityexemptions->add($houseutilityexemptions)){
			$obj->houseutilityexemptionsutilityid="";
			$obj->houseutilityexemptionsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-4");
}


//Process adding of houserentings
if($obj->action=="Add Houserenting"){
	$houserentings = new Houserentings();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->tenantid=$obj->houserentingstenantid;
	$ob->increaseevery=$obj->houserentingsincreaseevery;
	$ob->increaseby=$obj->houserentingsincreaseby;
	$ob->increasetype=$obj->houserentingsincreasetype;
	$ob->leaseends=$obj->houserentingsleaseends;
	$ob->renewevery=$obj->houserentingsrenewevery;
	$ob->leasestarts=$obj->houserentingsleasestarts;
	$ob->vacatedon=$obj->houserentingsvacatedon;
	$ob->occupiedon=$obj->occupiedon;
	$ob->rentaltypeid=$obj->houserentingsrentaltypeid;
	$ob->rentduedate=$obj->houserentingsrentduedate;

	$error=$houserentings->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houserentings->setObject($ob);

		if($houserentings->add($houserentings)){
			$obj->houserentingstenantid="";
			$obj->houserentingsincreaseevery="";
			$obj->houserentingsincreaseby="";
			$obj->houserentingsincreasetype="";
			$obj->houserentingsleaseends="";
			$obj->houserentingsrenewevery="";
			$obj->houserentingsleasestarts="";
			$obj->houserentingsvacatedon="";
			$obj->occupiedon="";
			$obj->houserentingsrentaltypeid="";
			$obj->houserentingsrentduedate="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-5");
}


//Process adding of houserents
if($obj->action=="Update Houserent"){
	$houserents = new Houserents();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->previous=$obj->houserentsprevious;
	$ob->enddate=$obj->houserentsenddate;
	$ob->current=$obj->houserentscurrent;

	$error=$houserents->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houserents->setObject($ob);

		if($houserents->add($houserents)){
			
			//update rent in houses table
			$houses = new Houses();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='$ob->houseid'";
			$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$houses=$houses->fetchObject;
			
			$house = new Houses();
			if(empty($houses->hsedescriptionid))
				$houses->hsedescriptionid=1;
			$houses->amount=$houserents->current;
			//$house->setObject($houses);			
			$house->edit($houses);
			
			$obj->houserentsprevious="";
			$obj->houserentsenddate="";
			$obj->houserentscurrent="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-6");
}


//Process adding of paidrents
if($obj->action=="Add Paidrent"){
	$paidrents = new Paidrents();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->tenantid=$obj->paidrentstenantid;
	$ob->month=$obj->paidrentsmonth;
	$ob->year=$obj->paidrentsyear;
	$ob->amount=$obj->paidrentsamount;
	$ob->remarks=$obj->paidrentsremarks;

	$error=$paidrents->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paidrents->setObject($ob);

		if($paidrents->add($paidrents)){
			$obj->paidrentstenantid="";
			$obj->paidrentsmonth="";
			$obj->paidrentsyear="";
			$obj->paidrentsamount="";
			$obj->paidrentsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-7");
}


//Process adding of housebreakages
if($obj->action=="Add Housebreakage"){
	$housebreakages = new Housebreakages();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->tenantid=$obj->housebreakagestenantid;
	$ob->breakage=$obj->housebreakagesbreakage;
	$ob->fixed=$obj->housebreakagesfixed;
	$ob->cost=$obj->housebreakagescost;
	$ob->paidbytenant=$obj->housebreakagespaidbytenant;
	$ob->remarks=$obj->housebreakagesremarks;

	$error=$housebreakages->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housebreakages->setObject($ob);

		if($housebreakages->add($housebreakages)){
			$obj->housebreakagestenantid="";
			$obj->housebreakagesbreakage="";
			$obj->housebreakagesfixed="";
			$obj->housebreakagescost="";
			$obj->housebreakagespaidbytenant="";
			$obj->housebreakagesremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-8");
}

//Process adding of housespecialdeposits
if($obj->action=="Add Housespecialdeposit"){
	$housespecialdeposits = new Housespecialdeposits();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->paymenttermid=$obj->housespecialdepositspaymenttermid;
	$ob->amount=$obj->housespecialdepositsamount;
	$ob->remarks=$obj->housespecialdepositsremarks;

	$error=$housespecialdeposits->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housespecialdeposits->setObject($ob);

		if($housespecialdeposits->add($housespecialdeposits)){
			$obj->housespecialdepositspaymenttermid="";
			$obj->housespecialdepositsamount="";
			$obj->housespecialdepositsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-9");
}


//Process adding of housespecialdepositexemptions
if($obj->action=="Add Housespecialdepositexemption"){
	$housespecialdepositexemptions = new Housespecialdepositexemptions();

	$ob->houseid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");

	$ob->paymenttermid=$obj->housespecialdepositexemptionspaymenttermid;
	$ob->remarks=$obj->housespecialdepositexemptionsremarks;

	$error=$housespecialdepositexemptions->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housespecialdepositexemptions->setObject($ob);

		if($housespecialdepositexemptions->add($housespecialdepositexemptions)){
			$obj->housespecialdepositexemptionspaymenttermid="";
			$obj->housespecialdepositexemptionsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addhouses_proc.php?id=".$obj->id."&error=".$error."#tabs-10");
}

//Process adding of housetenants
if($obj->actionhousetenant=="Add Housetenant"){
	$housetenants = new Housetenants();

	$hsetenant->createdby=$_SESSION['userid'];
	$hsetenant->createdon=date("Y-m-d H:i:s");
	$hsetenant->lasteditedby=$_SESSION['userid'];
	$hsetenant->lasteditedon=date("Y-m-d H:i:s");
	
	$hsetenant->houseid=$obj->id;
	$hsetenant->tenantid=$obj->tenantid;
	$hsetenant->payable=$obj->payable;
	$hsetenant->rentaltypeid=$obj->rentaltypeid;
	$hsetenant->occupiedon=$obj->occupiedon;
	$hsetenant->leasestarts=$obj->leasestarts;
	$hsetenant->renewevery=$obj->renewevery;
	$hsetenant->leaseends=$obj->leaseends;
	$hsetenant->increasetype=$obj->increasetype;
	$hsetenant->increaseby=$obj->increaseby;
	$hsetenant->increaseevery=$obj->increaseevery;
	$hsetenant->rentduedate=$obj->rentduedate;
	$hsetenant->lastmonthinvoiced=$obj->lastmonthinvoiced;
	$hsetenant->lastyearinvoiced=$obj->lastyearinvoiced;

	$error=$housetenants->validate($hsetenant);
	if(!empty($error)){
		$error=$error;
	}
	else{
	
		$hsetenant->month = date("m", strtotime($obj->occupiedon));
		$hsetenant->year = date("Y", strtotime($obj->occupiedon));
			
		$housetenants=$housetenants->setObject($hsetenant);
		
		if($housetenants = $housetenants->add($housetenants)){
		
			$houses = new Houses();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='$obj->id'";
			$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$houses=$houses->fetchObject;
	
			
			$obj->month = date("m", strtotime($obj->occupiedon));
			$obj->year = date("Y", strtotime($obj->occupiedon));
			$obj->houseid=$obj->id;
			$obj->id='';
			
			$payables = new Payables();
			
			$paymentterms = new Paymentterms();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='1'";
			$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$paymentterms=$paymentterms->fetchObject;
			$shppayables[0]=array('vatclasseid'=>"$houses->vatclasseid", 'mgtfee'=>"$houses->mgtfee", 'mgtfeevatclasseid'=>"$obj->mgtfeevatclasseid", 'houseid'=>"$obj->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$obj->mgtfeeamount", 'vatamount'=>"$obj->vatamount", 'mgtfeevatamount'=>"$obj->mgtfeevatamount", 'paymenttermid'=>"1", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'amount'=>"$houses->amount", 'remarks'=>"Rent for ", 'total'=>"$houses->amount");
			
			$paymentterms = new Paymentterms();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='2'";
			$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$paymentterms=$paymentterms->fetchObject;
			if($houses->deposit>0){
				$amount=$houses->amount*$houses->deposit;
				$shppayables[1]=array('vatclasseid'=>"$houses->vatclasseid", 'mgtfee'=>"$houses->mgtfee", 'mgtfeevatclasseid'=>"$obj->mgtfeevatclasseid", 'houseid'=>"$obj->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$obj->mgtfeeamount", 'vatamount'=>"$obj->vatamount", 'mgtfeevatamount'=>"$obj->mgtfeevatamount", 'paymenttermid'=>"2", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'amount'=>"$amount", 'remarks'=>"Rent", 'total'=>"$amount");
			}
			
			$k=2;
			$houseutilitys = new Houseutilitys();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where houseid='$obj->houseid' ";
			$houseutilitys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($houseutilitys->result)){
			  $shppayables[$k]=array('vatclasseid'=>"$houses->vatclasseid", 'mgtfee'=>"$houses->mgtfee", 'mgtfeevatclasseid'=>"$obj->mgtfeevatclasseid", 'houseid'=>"$obj->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$obj->mgtfeeamount", 'vatamount'=>"$obj->vatamount", 'mgtfeevatamount'=>"$obj->mgtfeevatamount", 'paymenttermid'=>"$rw->id", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'amount'=>"$rw->amount", 'remarks'=>"Rent", 'total'=>"$amount");
			  $k++;
			}
			
			$plotutilitys = new Plotutilitys();
			$fields=" em_plotutilitys.* ";
			$join=" left join em_houses on em_houses.plotid=em_plotutilitys.plotid ";
			$groupby="";
			$having="";
			$where=" where em_houses.id='$obj->houseid' and em_plotutilitys.paymenttermid not in(select paymenttermid from em_houseutilitys where houseid='$obj->houseid' union select utilityid from em_houseutilityexemptions where houseid='$obj->houseid') ";
			$plotutilitys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($plotutilitys->result)){
			  $shppayables[$k]=array('vatclasseid'=>"$houses->vatclasseid", 'mgtfee'=>"$houses->mgtfee", 'mgtfeevatclasseid'=>"$obj->mgtfeevatclasseid", 'houseid'=>"$obj->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$obj->mgtfeeamount", 'vatamount'=>"$obj->vatamount", 'mgtfeevatamount'=>"$obj->mgtfeevatamount", 'paymenttermid'=>"$rw->id", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'amount'=>"$rw->amount", 'remarks'=>"Rent", 'total'=>"$amount");
			  $k++;
			}
			
			$obj->invoicedon=date("Y-m-d");
			
			$payables->add($obj,$shppayables);				
			
			
			$houserentings = new Houserentings();
			$houserentings->setHouseid($hsetenant->houseid);
			$houserentings->setIncreaseby($hsetenant->increaseby);
			$houserentings->setIncreaseevery($hsetenant->increaseevery);
			$houserentings->setIncreasetype($hsetenant->increasetype);
			$houserentings->setLeaseends($hsetenant->leaseends);
			$houserentings->setLeasestarts($hsetenant->leasestarts);
			$houserentings->setOccupiedon($hsetenant->occupiedon);
			$houserentings->setRenewevery($hsetenant->renewevery);
			$houserentings->setRentaltypeid($hsetenant->rentaltypeid);
			$houserentings->setRentduedate($hsetenant->rentduedate);
			$houserentings->setTenantid($hsetenant->tenantid);
			
			//make entry to house rentings
			$houserentings->add($houserentings);
			
			//update house rental status
			$house = new Houses();
			
			$houses = new Houses();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='$hsetenant->houseid'";
			$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$houses=$houses->fetchObject;
			
			$house->setObject($houses);
			$houses->rentalstatusid=1;
			$house->edit($houses);
			
			$error=SUCCESS;
			redirect("addhouses_proc.php?id=".$houses->id."&error=".$error."#tabs-2");
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process house Vacating
if($obj->actionhousetenant=="Vacate"){
	//delete record from house tenants
	$housetenants = new Housetenants();
	$where=" where houseid='$obj->houseid'";
	if(empty($obj->vacatedon)){
	  $error="Must give Date Vacated";
	}
	elseif(empty($obj->rentaltypeid)){
	  $error="Must give rental type";
	}
	else{
	  if($housetenants->delete($obj,$where)){
		  
		  $error="Vacated";
		  //update house rental status
		  $house = new Houses();
		  $houses = new Houses();
		  $fields=" * ";
		  $join="";
		  $groupby="";
		  $having="";
		  $where=" where id='$obj->houseid'";
		  $houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $houses=$houses->fetchObject;
			  
		  $house->setObject($houses);
		  $houses->rentalstatusid=2;
		  $house->edit($houses);
		  
		  $houserentings = new Houserentings();
		  $fields="*";
		  $join=" ";
		  $having="";
		  $groupby="";
		  $orderby=" order by id desc";
		  $where=" where houseid='$obj->houseid' and tenantid='$obj->tenantid'";
		  $houserentings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $houserentings = $houserentings->fetchObject;
		  
		  
		  $houserentings->vacatedon=$obj->vacatedon;
		  $houserentings->rentaltypeid=$obj->rentaltypeid;
		  $houserentings->status=2;
		  
		  $hr = new Houserentings();
		  $hr->setObject($houserentings);
		  if($hr->edit($hr)){
		    //Dr Landlord/Deposit Refund Account
		    //Credit Tenant Account
		    $tenantdeposits = new Tenantdeposits();
		    $fields="em_paymentterms.name paymenttermid, em_paymentterms.id pay, em_tenantdeposits.tenantid, em_tenantdeposits.amount, em_tenantdeposits.paidon, em_tenantdeposits.remarks, em_tenantdeposits.status ";
		    $join=" left join em_paymentterms on em_paymentterms.id=em_tenantdeposits.paymenttermid ";
		    $having="";
		    $groupby="";
		    $orderby=" order by paymenttermid ";
		    $where=" where houseid='$obj->houseid' and tenantid='$obj->tenantid' and houserentingid='$houserentings->id' ";
		    $tenantdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    
		    $it=0;
		    $ex=0;
		    while($row=mysql_fetch_object($tenantdeposits->result)){
		    
		      $tenantrefunds = new Tenantrefunds();
		      $fields="max(documentno) documentno";
		      $join=" ";
		      $having="";
		      $groupby="";
		      $orderby=" ";
		      $where=" ";
		      $tenantrefunds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		      $tn = $tenantrefunds->fetchObject;
		      
		      if(is_null($tn->documentno))
			$tn->documentno=0;
		      
		      $obj->documentno=$tn->documentno+1;
		      
		      //Add record to tenant refund table
		      $tenantrefunds = new Tenantrefunds();
		      $obj->refundedon=$obj->vacatedon;
		      $obj->month=getMonth(date("m",date($obj->vacatedon)));
		      $obj->year=getYear(date("Y",date($obj->vacatedon)));
		      $obj->paymenttermid=$row->pay;
		      $obj->id='';
		      $tenantrefunds = $tenantrefunds->setObject($obj);
		      $tenantrefunds->add($tenantrefunds);
		      
		      $paymentterms = new Paymentterms();
		      $fields="*";
		      $where=" where id='$obj->paymenttermid' ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $paymentterms=$paymentterms->fetchObject;
		      
		      //get Account to Debit
		      if($row->status==1){
			$plots = new Plots();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where id='$houses->plotid'";
			$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$plots=$plots->fetchObject;
			
			$obj->month=date("m",strtotime($obj->vacatedon));
			$obj->year=date("Y",strtotime($obj->vacatedon));
			
			$shpexptransactions[$ex]=array('expenseid'=>"3", 'expensename'=>"Tenant Refunds", 'paymentid'=>"", 'paymentname'=>"",'plotid'=>"$houses->plotid",'plotname'=>"$obj->lplotname", 'tenantid'=>"$row->tenantid",'tenantname'=>"$obj->tenantname",'paymenttermid'=>"1" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$row->amount", 'memo'=>"$row->memo (Tenant Refunds)", 'total'=>"$row->amount",'month'=>"$obj->month",'year'=>"$obj->year");
				
			$ex++;
			
			//get Landlord Account
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$plots->landlordid' and acctypeid='33'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;
			
		      }
		      else{
			//get Deposit Liability Account
			
			$liabilitys = new Liabilitys();
			$fields=" * ";
			$join="";
			$groupby="";
			$having="";
			$where=" where paymenttermid='$row->pay'";
			$liabilitys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$liabilitys=$liabilitys->fetchObject;
			
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$liabilitys->id' and acctypeid='15'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;
		      }
		      
		      $obj->transactdate=$obj->vacatedon;
		      
		      $transaction = new Transactions();
		      $fields="*";
		      $where=" where lower(replace(name,' ',''))='tenantrefunds'";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $transaction=$transaction->fetchObject;
		      
		      //debit
		      $generaljournal = new Generaljournals();
		      $ob->tid=$tenantpayments->id;
		      $ob->documentno="$obj->documentno";
		      $ob->remarks="Tenant Refund ".$plots->name." # ".$houses->hseno;
		      $ob->memo=$tenantpayments->remarks;
		      $ob->accountid=$generaljournalaccounts->id;
		      $ob->transactionid=$tenantrefunds->id;
		      //$ob->mode=$obj->paymentmodeid;
		      $ob->class="B";
		      $ob->debit=$row->amount;
		      $ob->credit=0;
		      $generaljournal->setObject($ob);
		      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");

		      $it++;
		  
		      //get Tenant Account
		      
		      $generaljournalaccounts2 = new Generaljournalaccounts();
		      $fields="*";
		      $where=" where refid='$obj->tenantid' and acctypeid='32'";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		      
		      //credit
		      $generaljournal = new Generaljournals();
		      $ob->tid=$tenantpayments->id;
		      $ob->documentno="$obj->documentno";
		      $ob->remarks="Tenant Refund ".$plots->name." # ".$houses->hseno;
		      $ob->memo=$tenantpayments->remarks;
		      $ob->accountid=$generaljournalaccounts2->id;
		      $ob->transactionid=$tenantrefunds->id;
		      //$ob->mode=$obj->paymentmodeid;
		      $ob->class="B";
		      $ob->credit=$row->amount;
		      $ob->debit=0;
		      $generaljournal->setObject($ob);
		      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");

		      $it++;
		      
		    }
		    
		    $exptransactions = new Exptransactions();
		    $exptransactions->expensedate=$obj->vacatedon;
		    $exptransactions->documentno=$obj->documentno;
		    
		    $exptransactions->add($exptransactions,$shpexptransactions,true);
		    
		    $gn = new Generaljournals();
		    $gn->add($obj, $shpgeneraljournals);
		  }
		}
		
		
	}	
	redirect("addhouses_proc.php?id=".$obj->houseid."&error=".$error."#tabs-2");
}

//Process updating of housetenants
if($obj->actionhousetenant=="Update Housetenant"){
	$housetenants = new Housetenants();

	$housetenants->houseid=$obj->id;
	$housetenants->createdby=$_SESSION['userid'];
	$housetenants->createdon=date("Y-m-d H:i:s");
	$housetenants->lasteditedby=$_SESSION['userid'];
	$housetenants->lasteditedon=date("Y-m-d H:i:s");

	$error=$housetenants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housetenants=$housetenants->setObject($obj);
		if($housetenants->edit($housetenants)){
			$error=SUCCESS;
			redirect("addhouses_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
if(empty($obj->action)){

	$hsedescriptions= new Hsedescriptions();
	$fields="em_hsedescriptions.id, em_hsedescriptions.name, em_hsedescriptions.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$hsedescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$housestatuss= new Housestatuss();
	$fields="em_housestatuss.id, em_housestatuss.name, em_housestatuss.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$rentalstatuss= new Rentalstatuss();
	$fields="em_rentalstatuss.id, em_rentalstatuss.name, em_rentalstatuss.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentalstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$plots= new Plots();
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.vatable, em_plots.status, em_plots.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$houses=new Houses();
	$where=" where id=$id ";
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$houses->fetchObject;

	//for merged tables
	$housetenants = new Housetenants();
	$fields=" * ";
	$where=" where houseid=$id";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housetenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	if(mysql_affected_rows()>0){
		$obj->actionhousetenant="Update Housetenant";
	}
	else{
		$obj->actionhousetenant="Add Housetenant";
	}
	$merge=$housetenants->fetchObject;

	$obj = (object) array_merge((array) $obj, (array) $merge);
	$obj->houseid=$id;
	$obj->id=$id;
	//for autocompletes
	$plots = new Plots();
	$fields=" * ";
	$where=" where id='$obj->plotid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$plots->fetchObject;

	$obj->plotname=$auto->name;
	$tenants = new Tenants();
	$fields=" concat(concat(firstname,' ',middlename),' ',lastname) tenant, em_tenants.* ";
	$where=" where id='$obj->tenantid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$tenants->fetchObject;

	$obj->tenantname=$auto->tenant;
}

if(!empty($tenantid)){
	$tenants = new Tenants();
	$fields=" concat(concat(firstname,' ',middlename),' ',lastname) tenant, em_tenants.* ";
	$where=" where id='$tenantid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$tenants->fetchObject;
	
	$obj->tenantname=$auto->tenant;
	$obj->tenantid=$auto->id;
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		
		$houses = new Houses();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$houses->fetchObject;
		if(empty($ob->code))
			$ob->code=1;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->hsecode="HSE".$ob->code;
		
		$obj->rentalstatusid=2;
		
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->vatable="No";
	
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->houserentsprevious=$obj->amount;
	$obj->action="Update";
}
$obj->houserentsenddate=date("Y-m-d");
	
$page_title="Units";
include "addhouses.php";
?>