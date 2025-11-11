<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../payables/Payables_class.php';
require_once("../../em/tenantpayments/Tenantpayments_class.php");
require_once '../../fn/generaljournals/Generaljournals_class.php';

//connect to db
$db=new DB();

$tenantid = $_GET['tenantid'];
$houseid = $_GET['houseid'];
$month=date("m");
$year=date("Y");
 
$total=0;
$in="";
//retrieve recent invoices
$payables = new Payables();
$fields=" distinct em_paymentterms.name, em_payables.paymenttermid, sum(em_payables.amount) amount";
$join=" left join em_paymentterms on em_paymentterms.id=em_payables.paymenttermid ";
$where=" where em_payables.houseid='$houseid' and em_payables.tenantid='$tenantid' ";
$having=" ";
$groupby=" group by name";
$orderby="";
$payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($row=mysql_fetch_object($payables->result)){

      $in.=$row->paymenttermid.",";

      $tenantpayments = new Tenantpayments();
      $fields="sum(amount) amount";
      $join="";
      $where=" where paymenttermid='$row->paymenttermid' and houseid='$houseid' and tenantid='$tenantid' ";
      $having="";
      $groupby="";
      $orderby="";
      $tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      $tenantpayments = $tenantpayments->fetchObject;
      $row->amount-=$tenantpayments->amount;      
      $total+=$row->amount;
      if($row->amount==0)
	continue;
      ?>
      <tr>
	      <td align="right"><?php echo initialCap($row->name); ?>:</td>
	      <td align="right"><?php echo formatNumber($row->amount); ?></td>
      </tr>
<?php 
}

$in = substr($in,0,-1);
$tenantpayments = new Tenantpayments();
$fields=" distinct em_paymentterms.name, em_tenantpayments.paymenttermid, (sum(em_tenantpayments.amount)*-1) amount";
$join=" left join em_paymentterms on em_paymentterms.id=em_tenantpayments.paymenttermid ";
$where=" where em_tenantpayments.houseid='$houseid' and em_tenantpayments.tenantid='$tenantid' and em_tenantpayments.paymenttermid not in($in) ";
$having=" ";
$groupby=" group by name";
$orderby="";
$tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($row=mysql_fetch_object($tenantpayments->result)){
  $total+=$row->amount;
      ?>
      <tr>
	      <td align="right"><?php echo initialCap($row->name); ?>:</td>
	      <td align="right"><?php echo formatNumber($row->amount); ?></td>
      </tr>
      <?php
}


?>

<tr>
	<td align="right">Balance b/d</td>
	<td align="right"><?php echo formatNumber($total);  ?></td>
</tr>