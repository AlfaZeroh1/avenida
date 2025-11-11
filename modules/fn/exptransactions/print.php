<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../ToWords.php");
require_once '../../proc/suppliers/Suppliers_class.php';
require_once 'Exptransactions_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../fn/expenses/Expenses_class.php';
require_once '../../fn/liabilitys/Liabilitys_class.php';


$supplier = $_GET['supplier'];
$documentno=$_GET['documentno'];
//  $voucher=$_GET['voucher'];

$suppliers = new Suppliers();
$fields = "*";
$where=" where id='$supplier' ";
$join="";
$having="";
$groupby="";
$orderby="";
$suppliers->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$suppliers=$suppliers->fetchObject;

$exptransactions = new Exptransactions();
$fields="fn_exptransactions.*, fn_banks.name bank, sys_currencys.name currency";
$join=" left join fn_banks on fn_banks.id=fn_exptransactions.bankid left join sys_currencys on sys_currencys.id=fn_exptransactions.currencyid  ";
$having="";
$groupby="";
$orderby="";
$where=" where fn_exptransactions.documentno='$documentno' ";
$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);// echo $exptransactions->sql;
$exptransactions=$exptransactions->fetchObject;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<link href="../../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>

<?php echo $row->remarks; ?>
<script type="text/javascript" language="javascript">

 
	




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
		jsPrintSetup.setOption('marginTop','-2');
		jsPrintSetup.setOption('marginBottom','0');
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
  
  print_doc();
 </script>
 
<style media="all" type="text/css">
body{margin:0px;padding:0px;}
table{width:100%;overflow-y:visible; overflow-x:hidden;border:0px solid #ccc;margin:0px;padding:0px;font-family:'tahoma' !important;}

table{overflow-y:visible; overflow-x:hidden;}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}
.fnt{font-family:tahoma;font-size:9px;}
.fntt{font-family: tahoma ;font-size:12px;}
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 {width:100%; height:1160px !important;}
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
 <tr>
 </br>
<td colspan="1" align="left"> 
<span style=" padding:3px 10px; font-size:12px; text-left:center; ">

</br> 
Voucher No:
<?php echo $documentno?>
</br>
Bank:</strong> <?php echo $exptransactions->bank; ?>&nbsp;&nbsp;&nbsp;Cheque No:</strong> <?php echo $exptransactions->chequeno; ?>
</br>Booked On:
<?php echo $exptransactions->expensedate?></span>
</td>

</br></br></br>
<td align="right">

<!--  <?php $to = new toWords($exptransactions->total); echo initialCap($to->words); ?> -->

<tr>
<td colspan="10">
 <table width="100%" class="table-stripped table-bordered table"  style="line-height:14px;font-size:10px;  margin: 0px auto;  padding: 0; border-spacing: none;" cellspacing="0" cellpadding="0">
<!-- 	<span style=" padding:3px 5px; font-size:1px; text-left:center; "> -->
<!--             <td align="left" >#</td> -->
		<td align="left" >Item Name</td>
		<td align="left">Memo</td>
		<td align="left">Qty</td>
		<td align="left">@ </td>
		<td align="left">Date </td>
		<td align='left'>Total</td>
<!-- 		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th> -->
</tr>
<tr><td style="border:0px dotted #ccc;" colspan="5"><hr /></td></tr>
		          <tbody>   
       	<?php
		
		$i=0;
		$exptransactions = new Exptransactions();
		$fields="fn_exptransactions.id, fn_expenses.name as expenseid,fn_liabilitys.name as liabilityid,  proc_suppliers.name as supplierid, sys_purchasemodes.name as purchasemodeid, fn_exptransactions.quantity, fn_exptransactions.tax, fn_exptransactions.discount, fn_exptransactions.amount, fn_exptransactions.total, fn_exptransactions.expensedate, fn_exptransactions.paid, fn_exptransactions.remarks, fn_exptransactions.memo, fn_exptransactions.documentno, fn_exptransactions.ipaddress, fn_exptransactions.createdby, fn_exptransactions.createdon, fn_exptransactions.lasteditedby, fn_exptransactions.lasteditedon";
		$join=" left join fn_expenses on fn_exptransactions.expenseid=fn_expenses.id  left join fn_liabilitys on fn_exptransactions.liabilityid=fn_liabilitys.id  left join proc_suppliers on fn_exptransactions.supplierid=proc_suppliers.id  left join sys_purchasemodes on fn_exptransactions.purchasemodeid=sys_purchasemodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_exptransactions.documentno='$documentno' ";
		$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo mysql_error();
		$res=$exptransactions->result;
			$total=0;
	while($row=mysql_fetch_object($res)){
			$total+=$row->total;
			$tot=$total;
			$i++;
	?>     
<!-- 	<tr style="font-size:7px !important;"> -->
<!--                         <td><?php echo $i; ?></td> -->
			<td ><?php if(!empty($row->expenseid)) echo $row->expenseid;else echo $row->liabilityid; ?></td>
			
			<td><?php echo $row->memo; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><? echo date("d-m-Y"); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
		</tr>	
      <?
           $i++;
	  $j--;       
	  
	  }
      
	  ?>
	  
	  
  </tbody>
<tr><td style="border:0px dotted #ccc;" colspan="12"><hr /></td></tr>







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

<tr><td colspan="7" align="right">Total Kshs: <?php echo formatNumber($total); ?></td></tr>
<tr>

<td>
&nbsp;
</br>
</br>

<style="font-family:'tahoma';"> Approved By: :&nbsp;_______________________
</br>
</br>

<style="font-family:'tahoma';">Authorized By:&nbsp;_______________________
</br>
</br>

<style="font-family:'tahoma';">  Received By: :&nbsp;_______________________
</td>
</tr>
<td colspan="10" align="center">
<p style="font-family:'tahoma';">Served By: <?php echo $_SESSION['username']; ?></p>
</td>
</tr>

</body>
</html>
