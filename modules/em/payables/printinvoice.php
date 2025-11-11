<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../em/tenants/Tenants_class.php';
require_once 'Payables_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';

$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$invoicedon=$_GET['invoicedon'];

$tenants = new Tenants();
$fields = "*";
$where=" where id='$tenant' ";
$join="";
$having="";
$groupby="";
$orderby="";
$tenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$tenants=$tenants->fetchObject;
	
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
body{margin:0px;padding:0px;}
table{width:100%;overflow-y:visible; overflow-x:hidden;border:1px solid #ccc;margin:0px;padding:0px;}
td{border:1px dotted #ccc;}
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
<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>

<table>
<tr>
<td colspan="8">
<div style="text-align:center"> 
            <div style="text-align:center;text-transform:uppercase;"><strong><?php echo $_SESSION['companyname']; ?></strong>
            <div class="fntt"><span class="desc"><?php echo $_SESSION['companydesc']; ?></span><br/>
            <span class="addr"><?php echo $_SESSION['companyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
            <span class="tel"><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span><br />
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>

<span class="name"><strong>Tenant: <?php echo $tenants->code; ?></span></strong>
<span class="name"><?php echo $tenants->firstname; ?>&nbsp;<?php echo $tenants->middlename; ?>&nbsp;<?php echo $tenants->lastname; ?></span><br />
            <span class="addr"><?php echo $tenants->address; ?></span> <br />
<div class="i-details">
            <h2>
           INVOICE
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
			?>
            </h2>
            </strong>   
            </span>
            </div>
</td>
</tr>
<tr>
<td colspan="4">
            <div style="font-size:12px !important;"><strong>Invoice Date</strong> <?php echo": ".$invoicedon;?></div>
            <div style="font-size:12px !important;"><strong>Invoice No: </strong> <?php echo $doc; ?></div>
            <div style="font-size:12px !important;"><strong>Served By: </strong><?php echo $_SESSION['username']; ?></div>
</td>
<!--td width="50%">
           <div id="customer-info">
            <span class="to"><strong>Plot:</strong><?php //echo initialCap($row->plotid); ?></span><br />
            <span class="to"><strong>Hse No:</strong> <?php //echo initialCap($row->houseid); ?></span>
           </div>
</td-->
</tr>
<tr>
				  <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">Plot</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">Hse No.</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">Desc</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">Month</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">Amount</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">VAT</span></th>
			      <th width="100" align="left"><span style="text-decoration:underline;font-size:14px !important;">Total</span></th>
</tr> 
          <tbody>   
            
    <?
    $payables = new Payables();
    $fields="em_payables.id, em_payables.documentno, em_paymentterms.name as paymenttermid, em_payables.vatamount, em_payables.total, em_plots.name as plotid, em_houses.hseno as houseid, em_payables.month, em_payables.year, em_payables.invoicedon, em_payables.quantity, em_payables.amount, em_payables.remarks";
	$join=" left join em_paymentterms on em_payables.paymenttermid=em_paymentterms.id  left join em_houses on em_payables.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid  left join em_tenants on em_payables.tenantid=em_tenants.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where em_payables.documentno='$doc' ";
	$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$res=$payables->result;
	$total=0;
	while($row=mysql_fetch_object($res)){
			$total+=$row->total;
     ?>
    <tr class="<?php echo $some_class; ?>">
      <td id="tddes" height="24" align="left" class="lines"><strong><?php echo initialCap($row->plotid); ?></strong></td>
      <td id="tddes" height="24" align="left" class="lines"><strong><?php echo initialCap($row->houseid); ?></strong></td>
      <td class="lines" align="left"><?php echo $row->paymenttermid; ?></td>
      <td class="lines" align="left"><strong><?php echo $row->month; ?>&nbsp;<?php echo $row->year; ?></strong></td>
      <td class="noprint lines" align="right"><strong><?php echo formatNumber($row->amount); ?></strong></td>
      <td align="right" id="tdquantity" class="lines"><strong><?php echo formatNumber($row->vatamount); ?></strong></td>
      <td align="right" id="tddisc" class="lines"><?php echo formatNumber($row->total); ?></td>
      </tr>
      <?
           $i++;
	  $j--;       
	  
	  }
      
	  ?>
  </tbody>
<tr>
          <tfoot class="hr">
            <?php
			if($obj->type==4)
				$col=4;
			else
				$col=3;
			?>
           
            </tfoot>
            <tr>
                <td colspan="3" align="right"><strong>Total</strong></td>
              	<td colspan="1"  align="right"><strong><?php echo formatNumber($total); ?></strong> </td>
            </tr>
             <tr><td height="50" colspan="11" align="left">
             <div id="t-foot">
             <div class="remarks">
               <strong>Remarks</strong> </div>
               <?php 
               $generaljournals = new Generaljournals();
               $fields="sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit) amount";
               $join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join em_tenants on em_tenants.id=fn_generaljournalaccounts.refid";
               $where=" where fn_generaljournalaccounts.acctypeid='32' and fn_generaljournalaccounts.refid='$tenant'";
               $groupby="";
               $having="";
               $orderby="";
               $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
               $generaljournals=$generaljournals->fetchObject;
               ?>
               Total Balance: <?php echo formatNumber($generaljournals->amount); ?>
            
             </div>
</tr>

</table>




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
