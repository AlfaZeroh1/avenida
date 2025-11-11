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
	body{font-family:'tahoma';font-size:11px;}
	
	table {border:1px solid;width:100%;}
	hr{
	border-color:green;
	display: block;
-webkit-margin-before: 0.5em;
-webkit-margin-after: 0.5em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;
border-style: inset;
border-width: 2px;
	}
	
	
	</style>
  </head>
<!-- NAVBAR
================================================== -->
  <body onload="print_doc();">
<table style="height:100px !important;">
<tbody>
<tr>
<td colspan="2"><p>img</p>
Reciept No:</td>
<td>
<table style="border:0px;align:center;height:100px;">
<tr>
<td colspan="2" style="text-align:center;">
<p>MASTERWAYS PROPERTIES LTD<br/>
<hr>
Property Consultants,Registered Estate & Managing Agents
</p>
</td>
</tr>
<tr>

<td style="width:25%;border:1px solid #000;">
<p>CODE NO:  </p>
</td>
<td style="width:25%;border:1px solid #000;">
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
Email: masterways@masterways.co.ke<br/>
</p>
</td>
</tr>
<tr>
<td colspan="5">
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
<td colspan="3">
<div class="board">
<p>test</p>
</div>
<td colspan="2" style="border:1px solid #ccc;">
            <p><?php echo $tenants->address; ?> <br />
			<strong>Payment Mode: </strong><?php echo $tn->plotid; ?> <br />
            <strong>Cheque No:  </strong><?php echo $tn->houseid; ?> <br />
            <strong>Bank: <?php echo $tn->bankid; ?></strong><br/>
            <strong>Served By: <?php echo $tn->chequeno; ?></strong> <br/> 
			<strong>For:Masterways  Properties Ltd. </strong></p>
</td>
</tr>
<tr>

<td colspan="3">
<div class="board">
<p> EQUITY BANK &nbsp; KIMATHI A/c. &nbsp; NO 0260201209076</p>
<p>KENYA COMMERCIAL BANK &nbsp; TOM MBOYA &nbsp; A/c.NO. 1107979404</p>
<p>ACCOUNT NAME &nbsp;&nbsp; MASTERWAYS PROPERTIES LIMITED</p>
</div>
</td>
<td colspan="2">
<div class="board">
<p>Please quote your CODE NUMBER when making payments or present your latest Reciept for quicker service</p>
</div>
</td>
</tr>
</tbody>
</table>
  </body>
</html>