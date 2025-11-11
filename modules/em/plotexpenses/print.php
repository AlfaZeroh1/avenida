<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once 'Plotexpenses_class.php';
require_once '../plots/Plots_class.php';

$plotid = $_GET['plotid'];
$doc=$_GET['doc'];
$paidon=$_GET['paidon'];

$plots = new Plots();
$fields="*";
$where=" where id='$plotid' ";
$having="";
$orderby="";
$groupby="";
$join="";
$plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$plots = $plots->fetchObject;
	
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
		jsPrintSetup.setSilentPrint(true);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{//alert(i+": "+printers[i]);
			if(printers[i].indexOf('<?php echo BPRINTER; ?>')>-1)
			{	
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies',<?php echo INVOICECOPIES; ?>);
		
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		// Do Print
		jsPrintSetup.printWindow(window);
		window.close();
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
 
<style media="all" type="text/css">
table{width:100%;border:1px solid #ccc;font-family:tahoma;font-size:11px;}
td{border:1px dotted #ccc;}
table{overflow-y:visible; overflow-x:hidden;}
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
.noprint{ display:none;}
</style>
<style media="screen">
#testTable2 { height:1160px !important;}
</style>
</head>

<body onload="print_doc();">
<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>

<table width="100%">
<tr>
<td colspan="7">
<p><div><strong>Payment Date: <?php echo": ".$paidon;?></strong></div></p>
<p><div><strong>Voucher No: <?php echo $doc; ?></strong></div></p>
<div align="center">
          
            <div id="company">            
            <h2><?php echo $_SESSION['companyname']; ?></h2>
            <span class="desc"><?php echo $_SESSION['companydesc']; ?></span><br />
            <span class="addr"><?php echo $_SESSION['companyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
            <span class="tel">Tel: <?php echo $_SESSION['companytel']; ?></span><br />
            <span style="text-transform:lowercase;"><strong>Website: </strong><?php echo $_SESSION['companyweb']; ?></span><br />
            <span style="text-transform:lowercase;"><strong>Email: </strong><?php echo $_SESSION['companyemail']; ?></span><br />
            <strong>
           
            Voucher 
            <?php
            if($_GET['copy']==1){
				?>
				- Copy
				<?php 
			}else{
?>
		- Original
<?php 
}
			?>   
            </strong>   
            </div>
            </div>
</td>
</tr> 

<tr>
<td>
            <div id="customer-info" style="text-transform:uppercase;">
            <span class="to"><strong>Expense To:<?php echo $landlords->code; ?></span>
            <span class="name"><?php echo $plots->name; ?></strong></span>
            </div>
</td>
</tr>

<tr>
			      <th width="50%" class="stitle" align="left"><span style="text-decoration:underline;">Desc</span></th>
			      <th width="25%" align="left"><span style="text-decoration:underline;">Month</span></th>
			      <th width="25%" align="left"><span style="text-decoration:underline;">Amount</span></th>
</tr>
<tr>
<td colspan="7">
           <tbody>
    <?
    $plotexpenses = new Plotexpenses();
    $fields="em_plotexpenses.id, em_plots.name as plotid, fn_expenses.name as expenseid, em_plotexpenses.quantity, em_plotexpenses.amount, em_plotexpenses.total, em_plotexpenses.expensedate, em_plotexpenses.documentno, em_plotexpenses.month, em_plotexpenses.year, em_plotexpenses.remarks";
	$join=" left join em_plots on em_plotexpenses.plotid=em_plots.id  left join fn_expenses on em_plotexpenses.expenseid=fn_expenses.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where em_plotexpenses.documentno='$doc' ";
	$plotexpenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$res=$plotexpenses->result;
	$total=0;
	while($row=mysql_fetch_object($res)){
			$total+=$row->total;
     ?>
    <tr class="<?php echo $some_class; ?>">
      <td class="stitle lines"><?php echo $row->expenseid; ?></td>
      <td class="stitle lines"><div align="left"><strong><?php echo getMonth($row->month); ?>&nbsp;<?php echo $row->year; ?></strong></div></td>
      <td class=" lines"><div align="right"><strong><?php echo formatNumber($row->total); ?></strong></div></td>
      </tr>
      <?
           $i++;
	  $j--;       
	  
	  }
      
	  ?>
  </tbody>
</td>
</tr>
<tr>
<td colspan="2"  align="right"><strong>Total:</strong></td>
<td align="right"><strong><?php echo formatNumber($total); ?></strong></td>
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
