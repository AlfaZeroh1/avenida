<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/rules/Rules_class.php");

$saved="";

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../sys/transactions/TransactionsDBO.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../fn/exptransactions/Exptransactions_class.php");
require_once("../../fn/incomes/Incomes_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../proc/config/Config_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../proc/inwards/Inwards_class.php");
require_once("../../proc/inwarddetails/Inwarddetails_class.php");
require_once("../../inv/issuance/Issuance_class.php");
require_once("../../inv/issuancedetails/Issuancedetails_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");
require_once("../../inv/purchases/Purchases_class.php");
require_once("../../hrm/departments/Departments_class.php");
require_once("../../inv/purchasedetails/Purchasedetails_class.php");
require_once("../../fn/supplierpayments/Supplierpayments_class.php");


$exptransactions = new Exptransactions();
$fields=" distinct documentno ";
$where="  ";
$join=" ";
$having="";
$groupby="";
$orderby=" order by documentno desc ";
$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $exptransactions->sql;
$num = $exptransactions->affectedRows;

$i=0;
$k=0;
//$progressBar = new \ProgressBar\Manager(0, $num);
while($rows=mysql_fetch_object($exptransactions->result)){
  
    $k++;
    $i++;
    $exptransactions1 = new Exptransactions();
    $fields="fn_exptransactions.*,assets_assets.name as assetname,fn_liabilitys.name as liabilityname,fn_expenses.name as expensename ";
    $join=" left join assets_assets on assets_assets.id=fn_exptransactions.assetid left join fn_liabilitys on fn_liabilitys.id=fn_exptransactions.liabilityid left join fn_expenses on fn_expenses.id=fn_exptransactions.expenseid  ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where fn_exptransactions.documentno='$rows->documentno' ";
    $exptransactions1->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $exptransactions1->sql;
    $res=$exptransactions1->result;
    $it=0;
    $shpexptransactions=array();
    while($row=mysql_fetch_object($res)){
		  
	    $ob=$row;//print_r($row);
	    $shpexptransactions[$it]=array('assetid'=>"$ob->assetid",'assetname'=>"$ob->assetname",'liabilityid'=>"$ob->liabilityid",'liabilityname'=>"$ob->liabilityname",'expenseid'=>"$ob->expenseid", 'expensename'=>"$ob->expensename", 'quantity'=>"$ob->quantity", 'tax'=>"$ob->tax", 'discount'=>"$ob->discount", 'amount'=>"$ob->amount", 'memo'=>"$ob->memo", 'total'=>"$ob->total",'month'=>"$ob->month",'year'=>"$ob->year");

	    $it++;
	    $obj = $ob;
    }

// 		$_SESSION['shpexptransactions']=$shpexptransactions;
    
    //for autocompletes
  
    $obj = (object) array_merge((array) $obj, (array) $ob);
    
    $obj->action="Update";
    $obj->retrieve=1;
    $obj->iterator=$it;
    $obj->id="";
   $_SESSION['shpexptransactions']=$shpexptransactions;
// print_r($shpexptransactions);

    $ss = new Exptransactions();
    $ss->setObject($obj);
    if($ss->edit($ss,$shpexptransactions)){
    $error=SUCCESS;
    $saved="Yes";
    
    unset($_SESSION['customername']);
    unset($_SESSION['tel']);
    unset($_SESSION['remarks']);
    unset($_SESSION['address']);

    echo "SUCCESSFULLY Updated #".$rows->documentno."\n";

}
}
?>