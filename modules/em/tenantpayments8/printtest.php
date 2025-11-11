<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../em/tenants/Tenants_class.php';
require_once 'Tenantpayments_class.php';

$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$paidon=$_GET['paidon'];
$copy=$_GET['copy'];

$tenants = new Tenants();
$fields = "*";
$where=" where id='$tenant' ";
$join="";
$having="";
$groupby="";
$orderby="";
$tenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$tenants=$tenants->fetchObject;

$tenantpayments = new Tenantpayments();
$fields="concat(em_plots.code,' ',em_plots.name) plotid, em_houses.hseno as houseid,em_tenantpayments.paidby, em_tenantpayments.paidon, sys_paymentmodes.name paymentmodeid,fn_banks.name bankid,em_tenantpayments.chequeno ";
$join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_houses on em_tenantpayments.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
$having="";
$groupby="";
$orderby="";
$where=" where em_tenantpayments.documentno='$doc' ";	
$tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$tn=$tenantpayments->fetchObject;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

    <title></title>
	
	<style type="text/css" media="all">
	h1 {
display: block;
font-size: 1.5em;
/*-webkit-margin-before: 0.67em;
-webkit-margin-after: 0.67em;
-webkit-margin-start: 0px;
-webkit-margin-end: 0px;*/
font-weight: bold;
}
h2{display: block;
font-size: 1em;
/*-webkit-margin-before: 0.83em;
-webkit-margin-after: 0.83em;
-webkit-margin-start: 0px;
-webkit-margin-end: 0px;*/
font-weight: bold;
}
	body{font-family:'tahoma';font-size:10px;margin:0px;padding:0px;}
	td{margin:0px;padding:0px !important;}
	tr{border:0px;margin:0px;padding:0px !important;}
	table {border:0px solid #ccc;width:100%;height:auto;}
	hr{
	/*border-color:green;*/
	display: block;
/*-webkit-margin-before: 0.5em;
-webkit-margin-after: 0.5em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;
border-style: inset;*/
border-width: 1px;
	}
	.board{
	  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  -ms-border-radius: 5px;
  -o-border-radius: 5px;
  border-radius: 5px;
  border: 1px solid #000;
  
}
	
	</style>
	
	<script type="text/javascript">
   function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
		//alert(printers[i]+"="+'<?php echo $_SESSION["smallprinter"];?>');
			if(printers[i].indexOf('<?php echo $_SESSION["smallprinter"];?>')>-1)
			{	//alert(i+": "+printers[i]);
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
		jsPrintSetup.setOption('marginLeft','0');
		jsPrintSetup.setOption('marginRight','0');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
 
  </head>
<!-- NAVBAR
================================================== -->
  <body onload="print_doc();">
<table border="1">
<tr>
<td colspan="6" style="text-align:center;">
<table align="center" width="100%">
<tr>
<td colspan="1" rowspan="2">
<img src="../../../images/logo.png" alt="master ways" height="107" width="128" /><br />
<strong>Receipt No: <?php echo $doc; ?> - <?php
            if($_GET['copy']==1){
				?>
				- Copy
				<?php 
			}
			else{
?> - Original<?php } ?></strong>
</td>
<td valign="top" colspan="2" width="60%" style="text-align:center;">
<p><h1><?php echo $_SESSION['companyname']; ?></h1><br/>
<h2><?php echo $_SESSION['companydesc']; ?></h2><br/>
<hr>
</p>
</td>
<td  colspan="1"  rowspan="2" style="text-align:right;" valign="top">
<p><?php echo $_SESSION['building']; ?><br/>
<?php echo $_SESSION['street']; ?><br/>
<?php echo $_SESSION['companyaddr']; ?><br/>
<?php echo $_SESSION['companytown']; ?><br/>
Tel:<?php echo $_SESSION['companytel']; ?><br/>
Fax:<?php echo $_SESSION['companyfax']; ?><br/>
Email: <?php echo $_SESSION['companymail']; ?><br/>
Website: <?php echo $_SESSION['companywebsite']; ?><br/>
</p>
</td>
</tr>
<tr>

<td align="left" style="border:1px solid #000;">
<p>CODE NO: <?php echo $tenants->code; ?> </p>
</td>
<td style="border:1px solid #000;">
<p>VAT No: <?php echo $_SESSION['companyvat']; ?> <br/>
PIN No:<?php echo $_SESSION['companypin']; ?></p>
</td>


</tr>

</table>
</td>

</tr>
<tr>
<td colspan="6">
<table>
<thead>
<th>Date of Payment: </th>
<th>Received With Thanks From: </th>
<th>Unit Name:&nbsp;</th>
<th>Client Name:</th>
</thead>
<tbody>
<tr style="align:center">
<td><?php echo formatDate($paidon);?></td>
<td><?php echo $tenants->code; ?>&nbsp;<?php echo $tenants->firstname; ?>&nbsp;<?php echo $tenants->middlename; ?>&nbsp;<?php echo $tenants->lastname; ?></td>
<td><?php echo $tn->houseid; ?>&nbsp;<?php echo $tn->plotid; ?></td>
<td>d</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td colspan="4">
The Amount of Kshs: <?php echo formatNumber($total); ?>
</td>
<td colspan="2">
In Words:
</td>
</tr>
<tr>
<td colspan="3">
<table style="border:0px;margin:0px;padding:0px;">
<thead>
<th>Payment Description</th>
<th>Paid</th>
</thead>
<tbody>
<?
    $tenantpayments = new Tenantpayments();
    $fields="em_tenantpayments.id,  em_plots.name plotid, em_houses.hseno as houseid, em_tenantpayments.documentno, em_paymentterms.name as paymenttermid, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_tenantpayments.chequeno, em_tenantpayments.amount, em_tenantpayments.paidon, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.paidby, em_tenantpayments.remarks";
	$join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_houses on em_tenantpayments.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where em_tenantpayments.documentno='$doc' ";
	$tenantpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$res=$tenantpayments->result;
	$total=0;
	while($row=mysql_fetch_object($res)){
			$total+=$row->amount;
     ?>
    <tr>
      <td style="font-family:'tahoma';font-size:11px;" class="stitle lines"><?php echo $row->paymenttermid; ?>&nbsp;<?php if(!empty($row->remarks)){echo"[$row->remarks]";}?></td>
      <td style="font-family:'tahoma';font-size:11px;" align="right"><?php echo formatNumber($row->amount); ?></td>	  
      </tr>
      <?
           $i++;
	  $j--;       
	  
	}
	  ?>
</tbody>
</table>
</td>
<td colspan="3" style="padding-left:20px;">
            <p style="font-size:10px;">
			Payment Mode: <?php echo $tn->paymentmodeid; ?> <br />
            Cheque No:  <?php echo $tn->chequeno; ?> <br />
            Bank: <?php echo $tn->bankid; ?><br/>
			Balance: 0.00<br/>
            Served By: <?php echo $_SESSION['username']; ?> <br/> 
			For: <?php echo $_SESSION['companyname']; ?>. </p>
</td>
</tr>
<tr style="border:1px;">
<td colspan="2">
<p> EQUITY BANK &nbsp; KIMATHI A/c. &nbsp; NO 0260201209076</p>
<p>KENYA COMMERCIAL BANK &nbsp; TOM MBOYA &nbsp; A/c.NO. 1107979404</p>
<p>ACCOUNT NAME &nbsp;&nbsp; MASTERWAYS PROPERTIES LIMITED</p>
</td>
<td  colspan="4">
<p style="font-style:italic;"><?php echo $_SESSION['receiptnotes']; ?></p>
</td>
</tr>
<tr><td colspan="6" style="text-align:center;"><p style="font-style:italic;color:green;"><?php echo $_SESSION['receiptfootnote']; ?></p></td></tr>
</tbody>
</table>
  </body>
</html>