<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../hos/payables/Payables_class.php';
require_once("../../hos/patientlaboratorytests/Patientlaboratorytests_class.php");
require_once("../../hos/patienttreatments/Patienttreatments_class.php");
require_once("../../hos/patientotherservices/Patientotherservices_class.php");
require_once("../../hos/patientprescriptions/Patientprescriptions_class.php");
require_once("../../hos/patientvitalsigns/Patientvitalsigns_class.php");
require_once '../../sys/config/Config_class.php';
require_once '../../hos/payments/Payments_class.php';
require_once '../../hos/patients/Patients_class.php';

$obj = (object)$_GET;

$config = new Config();
$fields="*";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$arr = array();
while($rw=mysql_fetch_object($config->result)){
	$arr[$rw->name]=$rw->value;
}

$documentno=$_GET['documentno'];
$treatmentno=$_GET['treatmentno'];



$payables = new Payables();
$fields="sys_transactions.name transactionid, hos_payables.amount,hos_payables.paid,hos_payables.documentno, hos_payables.remarks,hos_payables.patientid, hos_payables.treatmentno ";
$join=" left join sys_transactions on hos_payables.transactionid=sys_transactions.id ";
$having="";
$groupby="";
$orderby="";					
$where=" where hos_payables.treatmentno='$treatmentno' and hos_payables.paid in ('No','') ";
$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $payables->sql;



$payables = $payables->fetchObject;

$patient = new Patients();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$payables->patientid'";
$patient->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $patient->sql;
$patient = $patient->fetchObject;
//$patientobservations = new Patientobservations();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient Invoice</title>
<script type="text/javascript">
  function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
			if(printers[i].indexOf('<?php echo $arr['smallprinter'];?>')>-1)
			{	
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies',1);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginLeft','1');
		jsPrintSetup.setOption('marginRight','1');
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<style media="print" type="text/css">
.noprint{ display:none;}
</style>

</head>
<body onload="print_doc();">
<div align="center" id="print_content" style="width:98%; margin:0px auto;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="font-weight:bold;page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">

 <span style="display:block; padding:0px 0px 2px;"><?php echo $arr['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companyaddr'];?>,<br/><?php echo $arr['companytown']; ?></span>
<span style="display:block; padding:0px 0px 1px;"><?php echo $arr['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px;">Tel: <?php echo $arr['companytel'];?></span> </div>
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">Invoice</span></div>
 <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 <hr/>
 Patient: <?php echo initialCap($patient->surname); ?>&nbsp;<?php echo initialCap($patient->othernames); ?><br/>
 Invoice No: <?php  echo $payables->patientid; ?><br />
 Treatment No: <?php echo $treatmentno; ?><br />
 Served By: <?php echo $_SESSION['username']; ?><br /><hr/></div>
 
   </div>
   
   <table width="100%">
   <tr>
   <th>#</th>
   <th>Transaction</th>
   <th>Remarks</th>
   <th>Date</th>
   <th>Amount</th>
   </tr>
   <tbody>
			<?php 
			
			$i=0;
			$balance=0;
			$payables = new Payables();
			  $fields="sys_transactions.name transactionid, hos_payables.amount, hos_payables.remarks,hos_payables.invoicedon,hos_payables.patientid, hos_payables.treatmentno ";
			  $join=" left join sys_transactions on hos_payables.transactionid=sys_transactions.id ";
			  $having="";
			  $groupby="";
			  $orderby="";					
			  $where=" where hos_payables.treatmentno='$treatmentno'and hos_payables.paid in ('No','') ";
			  $payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);/*echo $payables->sql;*/
			  $res=$payables->result;
			
			  while($row=mysql_fetch_object($res)){$i++;
			  $balance+=$row->amount;
				  ?>
				  <tr <?php if($row->paid=="No" or empty($row->paid)){?>bgcolor=""<?php }else{?>bgcolor="green"<?php }?>>
					  <td style="border-bottom:1px solid white; " ><?php echo $i; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->transactionid; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->remarks; ?></td>
					  <td style="border-bottom:1px solid white; ">&nbsp;<?php echo $row->invoicedon; ?></td>
					  <td style="border-bottom:1px solid white; " align="right">&nbsp;<?php echo formatNumber($row->amount); ?></td>
					  
				  </tr>
				  <?php 
				  }
			?>
			</tbody>
			<tfoot>
			<tr>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white; ">Balance:</th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
			      <th style="border-bottom:1px solid white;text-decoration:underline; " align="right" bgcolor=""><?php echo formatNumber($balance); ?></th>
			      <th style="border-bottom:1px solid white; ">&nbsp;</th>
		      </tr>
		      </tfoot>
   
   </table>
  
</div>
</body>
</html>
