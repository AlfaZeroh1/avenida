<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

    <title></title>
	
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
	body{font-family:'tahoma';font-size:10px;}
	tr{border:1px;}
	table {border:1px solid;width:100%;qtext-align:center;heght:auto;}
	hr{
	border-color:green;
	display: block;
-webkit-margin-before: 0.5em;
-webkit-margin-after: 0.5em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;/
border-style: inset;
border-width: 2px;
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
  </head>
<!-- NAVBAR
================================================== -->
  <body onload="print_doc();">
<table>
<thead>
<tr>
<td colspan="1">
<img src="../../../images/logo.png" alt="master ways" height="107" width="128" /><br />
<strong>Receipt No:</strong>
</td>
<td colspan="2">
<table style="border:0px;align:center;width:100%;">
<tr>
<td colspan="2" style="text-align:center;">
<p><h1>MASTERWAYS PROPERTIES LTD</h1><br/>
<hr>
<h2>Property Consultants,Registered Estate & Managing Agents</h2>
</p>
</td>
</tr>
<tr>

<td style="width:50%;border:1px solid #000;">
<p>CODE NO:  </p>
</td>
<td style="width:50%;border:1px solid #000;">
<p>VAT No: 0105274D <br/>
PIN No:P051113340H</p>
</td>
</tr>

</table>
</td>
<td colspan="1" style="text-align:right;">
<p>Old Mutual Building, 2nd Floor,<br/>
Kimathi Street<br/>
PO Box 38715-00600<br/>
Nairobi-Kenya <br/>
Tel:310459,310482,310483<br/>
Tel/Fax:310502<br/>
Email: info@masterways.co.ke<br/>
Website: www.masterways.co.ke<br/>
</p>
</td>
</tr>
</thead>
<tr>
<td colspan="6">
<table>
<thead>
<th>Date of Payment</th>
<th>Received With Thanks From:</th>
<th>Unit Name:</th>
<th>Client Name:</th>
</thead>
<tbody>
<tr style="align:center">
<td>a</td>
<td>b</td>
<td>c</td>
<td>d</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>
The Amount of Kshs:
</td>
<td>
In Words:
</td>
</tr>
<tr>
<td colspan="3" class="board">
<table style="border:0px;">
<thead>
<th>Payment Description</th>
<th>Paid</th>
</thead>
<tbody>
<td>a</td>
<td>b</td>
</tbody>
</table>
</td>
<td colspan="3" style="padding-left:20px;">
            <p style="font-size:11px;">
			Payment Mode: <?php echo $tn->plotid; ?> <br />
            Cheque No:  <?php echo $tn->houseid; ?> <br />
            Bank: <?php echo $tn->bankid; ?><br/>
			Balance: <?php echo $tn->bankid; ?><br/>
            Served By: <?php echo $tn->chequeno; ?> <br/> 
			For:Masterways  Properties Ltd. </p>
</td>
</tr>
<tr style="border:1px;">
<td colspan="3" class="board">
<p> EQUITY BANK &nbsp; KIMATHI A/c. &nbsp; NO 0260201209076</p>
<p>KENYA COMMERCIAL BANK &nbsp; TOM MBOYA &nbsp; A/c.NO. 1107979404</p>
<p>ACCOUNT NAME &nbsp;&nbsp; MASTERWAYS PROPERTIES LIMITED</p>
</td>
<td  colspan="3" class="board">
<p style="font-style:italic;">Please quote your CODE NUMBER when making payments or present your latest Reciept for quicker service</p>
</td>
</tr>
<tr><td colspan="6" style="text-align:center;"><p style="font-style:italic;color:green;">Service You deserve people you can trust</p></td></tr>
</tbody>
</table>
  </body>
</html>