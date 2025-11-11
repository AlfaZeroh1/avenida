<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../hos/patients/Patients_class.php';
require_once '../../fn/customerpayments/Customerpayments_class.php';
// require_once '../../em/plots/Plots_class.php';



$patientid = $_GET['patientid'];
$doc=$_GET['doc'];
$paidon=$_GET['paidon'];
$copy=$_GET['copy'];

if(!empty($patientid)){
  $patients = new Patients();
  $fields = "*";
  $where=" where id='$patientid' ";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $patients->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo mysql_error();
  $tenants=$patients->fetchObject;
}

$customerpayments = new Customerpayments();
$fields=" * ";
$join="  ";
$where=" where fn_customerpayments.documentno='$doc' ";
$having="";
$orderby="";
$groupby="";
$customerpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$cust = $customerpayments->fetchObject;

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
body{width:100%;font-family:'tahoma'  !important; font-size:12px !important;}
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
<!--div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div-->

<table width="100%">
<tr>
<td colspan="10">
            <p style="font-family:'tahoma';" align="center">Receipt 
            <?php
            if($_GET['copy']==1){
				?>
				- Copy
				<?php 
			}
			else{
?> - Original<?php } ?></p>
            
			<span style="font-family:'tahoma';">
			<img src='t.jpg' alt="logo" height="200" width="50" /> 
            <div style="text-align:center;text-transform:uppercase;">
            
            
<span style="font-family:'tahoma';" class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span style="font-family:'tahoma';" class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span><br /><br/>
     <span style="font-family:'tahoma';">
<span class="name"><p><strong>Recieved From:</strong><?php echo $tenants->name; ?></p></span><br />
			<?php if(!empty($tenants->address)){?>
            <span class="addr"><?php echo $tenants->address; ?></span> <br />
			<?php }?>
            <div style="text-align:center;font-family:'tahoma';"><p><strong>Printed On:</strong> <?php echo date("d/m/y"); ?></p>			
            <p><strong>Receipt No:</strong><?php echo $doc; ?></p> </div> 
             
			
			<div class="header">

 
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
		<th>Amount</th>

	</tr>
   <?php
	  $customerpayments = new Customerpayments();
	  $fields=" * ";
	  $join="  ";
	  $where=" where fn_customerpayments.documentno='$doc' ";
	  $having="";
	  $orderby="";
	  $groupby="";
	  $customerpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);// echo  $generaljournals->sql;
	  
	  $total=0;
	  $i=0;
	  while($row=mysql_fetch_object($customerpayments->result)){$i++;
	  $total+=$row->amount;
	  ?>
    <tr style=" vertical-align:text-top;border:1px solid #ccc; ">
		  <td><?php echo ($i); ?></td>
		  <td>Payment<?php echo $row->remarks; ?></td>
		  <td align="right"><?php echo formatNumber($row->amount);?></td>
	  </tr>
      <?
           $i++;
	  $j--;       
	  } 

	  ?>
       <tr>
       <td colspan="6" align="right">
       <strong style="font-family:'tahoma';">TOTAL</strong>:<strong><strong style="font-family:'tahoma';"> <?php echo formatNumber($total); ?></strong>
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
<style="font-family:'tahoma';">For <?php echo $_SESSION['companyname']; ?><br />
<br />
&nbsp;
<style="font-family:'tahoma';">SIGN:
</td>


</tr>
<tr>
<td colspan="10" align="center">
<p style="font-family:'tahoma';">Payment Date: <?php echo formatDate($cust->paidon);?></p>
<p style="font-family:'tahoma';">Paid By: <?php echo initialCap($tn->paidby); ?></p>
<p style="font-family:'tahoma';">Served By: <?php echo $_SESSION['username']; ?></p>
<p style="font-family:'tahoma';">Note: Refunds of any kind shall attract levy</p>
</td>
</tr>


</table>



</div>      
<script type="text/javascript" language="javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.tablePagination.0.2.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery_003.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.easing.min.js"></script>
<script type="text/javascript" language="javascript">
$('tbody tr', $('#menuTable2')).addClass('hideTr'); //hiding rows for test
            var options = {
              currPage : 1, 
              ignoreRows : $('', $('#menuTable2')),
              optionsForRows : [2,3,4,5],
              firstArrow : (new Image()).src="../../media/inv-images/firstBlue.gif",
              prevArrow : (new Image()).src="../../media/inv-images/prevBlue.gif",
              lastArrow : (new Image()).src="../../media/inv-images/lastBlue.gif",
              nextArrow : (new Image()).src="../../media/inv-images/nextBlue.gif"
            }
            $('#menuTable2').tablePagination(options);
			$('a.review').toggle(function(){
				$('tbody tr', $('#menuTable2')).show();
				$('div#tablePagination').hide();
				subTotal();
				},function(){
				$('tbody tr', $('#menuTable2')).addClass('hideTr');
				$('div#tablePagination').show();
				 $('#menuTable2').tablePagination(options);
				 subTotal();
				}
			
			);

</script>
<script type="text/javascript" language="javascript">
function subTotal()
{	
	var subTot = 0;
			var subrow =$('#menuTable2 tr[style*=table-row]');
			subrow.children('td.t2').each(function() {
					subTot += parseFloat($(this).html().replace("$","")); 
				});
			$('#subTot').html(subTot);
}
$(document).ready(function(){
	subTotal(); 
	var fTot = 0;
			var nrow =$('#menuTable2 tr');
			nrow.children('td.t2').each(function() {
					fTot += parseFloat($(this).html().replace("$","")); 
				});
			$('#fTot').html(fTot);
	$('span#tablePagination_paginater img').click(function(){
		subTotal();
	});
	$('#tablePagination_currPage').change(function(){
		subTotal();
	});
	
});		
</script>
</body>
</html>
