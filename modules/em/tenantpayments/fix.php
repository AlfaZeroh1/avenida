<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantpayments_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once '../../fn/inctransactions/Inctransactions_class.php';
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");


//retrieve all payments done that are in houses that commission is deducted directly
$tenantpayments = new Tenantpayments();
$fields=" em_houses.hseno houseid, em_tenantpayments.id, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.documentno, em_tenantpayments.paidon, em_tenantpayments.amount, em_plots.commission, em_plots.id plotid, em_plots.commissiontype";
$join=" left join em_houses on em_houses.id=em_tenantpayments.houseid left join em_plots on em_plots.id=em_houses.plotid ";
$where=" where em_plots.deductcommission='Yes' ";
$tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($row=mysql_fetch_object($tenantpayments->result)){
	
	$inctransaction = new Inctransactions();
	$inc->incomeid=1;
	if($row->commissiontype==1)
		$inc->amount=$row->amount*$row->commission/100;
	else
		$inc->amount=$row->commission;
	
	$inc->ref=$row->id;
	$inc->paymentmodeid=5;
	$inc->bankid=$row->plotid;
	$inc->documentno=$row->documentno;
	$inc->incomedate=$row->paidon;
	$inc->remarks="Management Fee";
	$inc->remarks="Mgt Fee on $row->houseid for ".getMonth($row->month)." $row->year";
	$inc->createdby=1;
	$inc->createdon=date("Y-m-d H:i:s");
	$inc->lasteditedby=1;
	$inc->lasteditedon=date("Y-m-d H:i:s");
	
	if($inc->amount>0)
		$inctransaction->add($inc);
	
}


?>