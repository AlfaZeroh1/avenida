<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../fn/generaljournals/Generaljournals_class.php");

$obj = (object)$_GET;

$generaljournals = new Generaljournals();
$fields="fn_generaljournalaccounts.name, sys_currencys.name currency, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.rate, fn_generaljournals.memo, fn_generaljournals.remarks, fn_generaljournals.jvno, fn_generaljournals.transactdate";
$where=" where fn_generaljournals.jvno='$obj->jvno' ";	
$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid ";
$having="";
$groupby="";
$orderby="";
$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$generaljournals = $generaljournals->fetchObject;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

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
		jsPrintSetup.setOption('marginTop','4.8');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','4');
		jsPrintSetup.setOption('marginRight','');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<!--    <link href="../../../css/bootstrap.css" rel="stylesheet"> -->
<!-- <link href="../../../css/bootstrap.min.css" rel="stylesheet"> -->
<style type="text/css" media="all">
body{font-family:'arial';font-size:12px;}
ul{list-style:none !important;}


table{overflow-y:visible; overflow-x:hidden;}
.table td, th {
vertical-align: top;
border-right: 0px solid black;
border-bottom: 0px solid black;
padding:8px;
line-height:none !important;
}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
td{padding-left:0px !important;margin:0px !important;line-height:none !important;}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1260px !important;}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
border-bottom: 0px solid black;
}
.table > tfoot > tr > th, .table > thead > tr > th{
  border-bottom: 1px solid black;
}
</style>



</head>

<body onload="print_doc();">
<!--<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>-->
<!-- headder -->
<!-- <table class="table table-bordered"> -->
<table width="100%">
<tr>
<td colspan="8">
	    <table align="center" cellspacing="">
	    <tr>
	    <td valign="top" width="25%" align="right">
	    <img src="../../../images/printlogo.jpg"  height="130"/>
	    </td>
	    <td valign="top" align="center" width="60%">
	    <div style="float:center">
            <div style="text-align:center;text-transform:uppercase; font-size:20px;"><strong><?php echo $_SESSION['companyname']; ?></strong></div>
            <div><span><?php echo $_SESSION['companydesc']; ?></span></div>
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="valign:bottom;">
            <strong>
<span style="text-align:center;">
       <h2>  JOURNAL VOUCHER
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
		?>
		</h2>
</span>	     
            </strong>  
            </div>
            
</td>
<td valign="top" width="25%" align="center">
<br/>
<br/>
<span><?php echo $_SESSION['companActual/V.weight Ratioyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span> <br />
            <span><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span><br/>
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
	    <p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <br/>
	    <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
</td>
</tr>
</table>
<hr/>
</td>
</tr>

<tr style="padding:8px;">
  <td width="50%" colspan="7">
	  <div style="font-size:12px !important;"><strong>JV No: </strong> <?php echo $generaljournals->jvno; ?></div>
  </td>
</tr>
<tr>
  <td width="50%" colspan="7">
	  <div style="font-size:12px !important;"><strong>Date: </strong> <?php echo formatDate($generaljournals->transactdate); ?></div>
	  <hr/>
  </td>

</tr>

</table>

<table width="100%" class="table">
<thead>
   	<tr>
			      <th style="text-align:left;">Account</th>
			      <th style="text-align:left;">Memo</th>
			      <th>Currency</th>
			      <th>Rate</th>
			      <th style="text-align:right;">Debit</th>
			      <th style="text-align:right;">Credit</th>
	</tr>
</thead>
<tbody>
	<?php
	$i=0;
		$generaljournals = new Generaljournals();
		$fields="fn_generaljournalaccounts.name, sys_currencys.name currency, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.rate, fn_generaljournals.memo, fn_generaljournals.remarks";
		$where=" where fn_generaljournals.jvno='$obj->jvno' ";	
		$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid ";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		
		$debit=0;
		$credit=0;
		
		while($row=mysql_fetch_object($generaljournals->result)){
		  
		  $debit+=$row->debit;
		  $credit+=$row->credit;
		  
		  ?>
		  <tr>
			<td align="left"><?php echo $row->name; ?></td>
			<td align="left"><?php echo $row->memo; ?></td>		  
			<td align="center"><?php echo $row->currency; ?></td>	
			<td align="center"><?php echo $row->rate; ?></td>
			<td align="right"><?php echo formatNumber($row->debit); ?></td>
			<td align="right"><?php echo formatNumber($row->credit); ?></td>
		</tr>
	  <?php
	  }
	  ?>
</tbody>
	  <tfoot>
	  <tr>
			<th align="left">&nbsp;</th>
			<th align="left">&nbsp;</th>
			<th align="left">&nbsp;</th>
			<th align="left">&nbsp;</th>
			<th align="right" style="border-top:1px solid black;"><?php echo formatNumber($debit); ?></th>
			<th align="right" style="border-top:1px solid black;"><?php echo formatNumber($credit); ?></th>
		</tr>
	  </tfoot>
	  
</table>

<table class="table">
<tr>
  <td>Approved By:</td>
  <td>_______________________</td>
</tr>
<tr>
  <td>Approved By:</td>
  <td>_______________________</td>
</tr>
</table>
</body>
</html>
