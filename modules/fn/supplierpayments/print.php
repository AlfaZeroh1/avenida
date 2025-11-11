<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../proc/suppliers/Suppliers_class.php';
require_once '../../fn/supplierpayments/Supplierpayments_class.php';
// require_once '../../em/plots/Plots_class.php';



$supplierid = $_GET['supplierid'];
$doc=$_GET['doc'];
$paidon=$_GET['paidon'];
$copy=$_GET['copy'];

if(!empty($supplierid)){
  $suppliers = new Suppliers();
  $fields = "*";
  $where=" where id='$supplierid' ";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $suppliers->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo mysql_error();
  $tenants=$suppliers->fetchObject;
}

$supplierpayments = new Supplierpayments();
$fields=" fn_supplierpayments.*, fn_banks.name bank, sys_currencys.name currency ";
$join=" left join fn_banks on fn_banks.id=fn_supplierpayments.bankid left join sys_currencys on sys_currencys.id=fn_supplierpayments.currencyid ";
$where=" where fn_supplierpayments.documentno='$doc' ";
$having="";
$orderby="";
$groupby="";
$supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$cust = $supplierpayments->fetchObject;

// $generaljournals = new Generaljournals();
// $fields=" fn_generaljournals.remarks, fn_generaljournals.documentno, fn_generaljournals.memo, fn_generaljournals.debit, fn_generaljournals.credit, sys_transactions.name transactionid ";
// $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid ";
// $where=" where fn_generaljournals.documentno='$doc' ";	
// $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// $tn=$generaljournals->fetchObject;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" /-->
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
		jsPrintSetup.setOption('marginLeft','0');
		jsPrintSetup.setOption('marginRight','0');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<link href="../../../css/bootstrap.css" rel="stylesheet">

<style media="print" type="text/css">
body{width:100%;font-family:'tahoma'  !important; font-size:8px !important;}
table{ border:1px solid #ccc;overflow-y:visible; overflow-x:hidden;}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;border:1px solid #ccc; 
}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1260px !important;}
</style>
</head>

<body onload="print_doc();">
<body onload="print_doc();" style="align:center;">
<div align="center" id="print_content" style="width:80%; border:1px gray solid; align:center; margin-left:10%;">
   <div>
   <div class="hfields" align="left">
 <div align="center" style="page-break-inside:avoid; page-break-after:avoid; page-break-before:avoid; display:block;">

 <span style="display:block; padding:3px 10px; font-size:14px; text-align:center; font-weight:bold;"><?php echo $_SESSION['companyname']; ?> </span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companytitle']; ?></span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companyaddr'];?>,<br/>
<span style="display:block; padding:0px 0px 1px; font-size:11px;"><?php echo $_SESSION['companydesc'];?></span>
<span style="display:block; padding:0px 0px 1px; font-size:11px;">Tel: <?php echo $_SESSION['companytel'];?></span> 
<span style="font-family:'tahoma';" class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> 
<span style="font-family:'tahoma';" class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span>
</div>
     <span style="font-family:'tahoma';">
<table width="100%">
<tr>
<td colspan="10">
            <p><strong>PV No:</strong><?php echo $doc; ?></p>
            <p><strong>Bank:</strong> <?php echo $cust->bank; ?> <strong>Cheque No:</strong> <?php echo $cust->chequeno; ?></p>
                  

<span class="name"><p><strong>Paid To:</strong><?php echo $tenants->name; ?></p></span><br />
			<?php if(!empty($tenants->address)){?>
            <span class="addr"><?php echo $tenants->address; ?></span> <br />
			<?php }?>
            <p><strong>Payment Date:</strong> <?php echo formatDate($cust->paidon);?></p>		
             </div> 
</td>
</tr> 
<tr>
<td colspan="10">
<table width="100%" class="table">
  	<tr>
	<span style="font-family:'tahoma';">
		<th align="left" >#</th>
		<th>Description</th>
		<th>Amount (<?php echo $cust->currency; ?>)</th>

	</tr>
   <?php
	  $supplierpayments = new Supplierpayments();
	  $fields=" * ";
	  $join="  ";
	  $where=" where fn_supplierpayments.documentno='$doc' ";
	  $having="";
	  $orderby="";
	  $groupby="";
	  $supplierpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);// echo  $generaljournals->sql;
	  
	  $total=0;
	  $i=0;
	  while($row=mysql_fetch_object($supplierpayments->result)){$i++;
	  $total+=$row->amount;
	  
	  //get invoices paid
	  $query="select * from fn_supplierpaidinvoices where supplierpaymentid='$row->id'";
	  $rs=mysql_query($query);
	  while($rw=mysql_fetch_object($rs)){
	  if(empty($rw->invoiceno))
	    $rw->invoiceno="Undistributed";
	  ?>
    <tr style=" vertical-align:text-top;border:1px solid #ccc; ">
		  <td><?php echo ($i); ?></td>
		  <td>INV: <?php echo $rw->invoiceno; ?></td>
		  <td align="right"><?php echo formatNumber($rw->amount);?></td>
	  </tr>
      <?
           $i++;
          }
	  $j--;       
	  } 

	  ?>
       <tr>
       <td colspan="6" align="right">
       <strong style="font-family:'tahoma';">TOTAL</strong>:<strong><strong style="font-family:'tahoma';"> <?php echo $cust->currency; ?>&nbsp;<?php echo formatNumber($total); ?></strong>
       </td>
       </tr>          
 </table>
</td>
</tr>
<tr><td colspan="10">
</td></tr>
<tr>
<td colspan="10">
<span style="font-family:'tahoma';">
<?php echo $cust->remarks; ?><br />
<br />
&nbsp;
<style="font-family:'tahoma';">Approved By:&nbsp;_______________________
<br />
<br />
&nbsp;
<style="font-family:'tahoma';">Authorized By:&nbsp;_______________________
<br />
<br />
&nbsp;
<style="font-family:'tahoma';">Received By:&nbsp;_______________________
</td>
</tr>
<tr>
<td colspan="10" align="center">
<p style="font-family:'tahoma';">Served By: <?php echo $_SESSION['username']; ?></p>
</td>
</tr>


</table>



</div>
</body>
</html>
