<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
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

$payments = new Payments();
$fields="sys_transactions.name transactionid, hos_payments.amount, hos_payments.remarks,hos_payments.patientid,hos_payments.paidon, hos_payments.treatmentno ";
$join=" left join sys_transactions on hos_payments.transactionid=sys_transactions.id ";
$having="";
$groupby="";
$orderby="";
$where=" where hos_payments.documentno='$documentno' ";
$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

$payment = $payments->fetchObject;

$patient = new Patients();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$payment->patientid'";
$patient->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$patient = $patient->fetchObject;
//$patientobservations = new Patientobservations();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Patient Payment</title>
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
 
 <span style="display:block; padding:3px 10px; font-size:16px; text-align:center; font-weight:bold; color:#fff; background-color:#999">Receipt</span></div>
 <div class="hfields" align="left" style="float:left; width:100%; padding-left:5px;">
 <hr/>
 Patient: <?php echo initialCap($patient->surname); ?>&nbsp;<?php echo initialCap($patient->othernames); ?><br/>
 Date: <?php echo formatDate($payment->paidon); ?><br />
 Receipt No: <?php echo $documentno; ?><br />
 Treatment No: <?php echo $payment->treatmentno; ?><br />
 Served By: <?php echo $_SESSION['username']; ?><br /><hr/></div>
 
   </div>
   
   <table width="100%">
   	<tr>
   		<th>Description</th>
   		<th>Amount</th>
   		<th>Remarks</th>
   	</tr>
   	<?php
   	$total=0;
   	while($row=mysql_fetch_object($payments->result)){
	  $total+=$row->amount;
   	
   	?>
   	<tr>
   		<td><?php echo $row->remarks; ?></td>
   		<td align="right"><?php echo formatNumber($row->amount);?></td>
   		<td>&nbsp;</td>
   	</tr>
   	<?php
   	}
   	?>
         <tr>
	  <th><strong>Total</strong></th>
	  <th align="right" style="border-bottom: 1px solid black; border-top: 1px solid black;"><?php echo formatNumber($total);?></th>
	  <th>&nbsp;</th>
         </tr>   	
	  <tr>
           <td colspan="3" align="center" style="font: italic;"><font style="italic"><i><?php echo $arr['labtestfooter'];?></i></font></td>
         </tr>
         
        </table>
</div>
</body>
</html>
