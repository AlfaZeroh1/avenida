<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../em/tenants/Tenants_class.php';
require_once 'Payables_class.php';

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
$tenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $tenants->sql;
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
 
<style media="print" type="text/css">
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
<div id="testTable2">
          <table>
            <thead>
            <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="16">
            <div align="center">
            <p class="fnt">Payment Date:<?php echo": ".$paidon;?></p>
            <p class="fnt">Receipt No:<?php echo $doc; ?></p> </div> 
            <div style="text-align:center;text-transform:uppercase;"><h2><?php echo $_SESSION['companyname']; ?></h2>
            <div class="fntt"><span class="desc"><?php echo $_SESSION['companydesc']; ?></span><br/>
            <span class="addr"><?php echo $_SESSION['companyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
            <span class="tel"><strong>Tel: <?php echo $_SESSION['companytel']; ?> </strong></span>  <br/>
            <span style="text-transform:lowercase;"><strong>Website:</strong><?php echo $_SESSION['companyweb']; ?></span><br />
            <span style="text-transform:lowercase;"><strong>Email:</strong><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
            <strong>
           <h2>
            Invoice 
            <?php
            if($_GET['retrieved']==1){
				?>
				- Copy
				<?php 
			}
			?>   
            </h2>
            </strong>   
            </div>
            </div>
           </td>
           <!--td>&nbsp;</td-->
           </tr>
           <tr>
           <td colspan="3">
            <div class="i-details">
            <div><strong>Invoice Date</strong> <?php echo": ".$invoicedon;?></div>
            <div><strong>Invoice No: </strong> <?php echo $doc; ?></div>
            <div><strong>Served By: </strong><?php echo $_SESSION['username']; ?></div>
            </div>
			
            <div id="customer-info">
            <span class="to"><strong>Invoice To:</strong><?php echo $tenants->code; ?></span>
            </div>
            <div class="c-title">
            <span class="name"><?php echo $tenants->firstname; ?>&nbsp;<?php echo $tenants->middlename; ?>&nbsp;<?php echo $tenants->lastname; ?></span>
            </div>
            </td>
            </td></tr>
              <tr style="border-bottom:1px color:#ccc;">
                  <th width="170" >Plot</th>
			      <th width="170" >Hse No</th>
			      <th width="43" class="stitle">Desc</th>
			      <th width="76" align="center">Month</th>
			      <th width="81" align="center">Amount</th>
			      <th width="35" align="center">VAT</th>
			      <th width="41" align="left">Total</th>
      		</tr>
            
            </thead>
            <tbody>
    <?
    $payables = new Payables();
    $fields="em_payables.id, em_payables.documentno, em_paymentterms.name as paymenttermid, em_payables.vatamount, em_plots.name as plotid, em_houses.hseno as houseid, em_payables.month, em_payables.year, em_payables.invoicedon, em_payables.quantity, em_payables.amount, em_payables.remarks";
	$join=" left join em_paymentterms on em_payables.paymenttermid=em_paymentterms.id  left join em_houses on em_payables.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid  left join em_tenants on em_payables.tenantid=em_tenants.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where em_payables.documentno='$doc' ";
	$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$res=$payables->result;
	while($row=mysql_fetch_object($res)){
			
     ?>
    <tr class="<?php echo $some_class; ?>">
      <td class="td1st lines">&nbsp;<?php echo $i+1; ?>&nbsp;</td>
      <td id="tddes" height="24" align="left" class="lines"><strong><?php echo initialCap($row->plotid); ?></strong></td>
      <td id="tset1"><span class="stitle lines"><strong><?php echo initialCap($row->houseid); ?></strong></span></td>
      <td class="stitle lines"><?php echo $row->paymenttermid; ?></td>
      <td class="stitle lines"><div align="right"><strong><?php echo $row->month; ?>&nbsp;<?php echo $row->year; ?></strong></div></td>
      <td class="noprint lines"><div align="right"><strong><?php echo formatNumber($row->amount); ?></strong></div></td>
      <td align="center" id="tdquantity" class="lines"><div align="right"><strong><?php echo formatNumber($row->vatamount); ?></strong></div></td>
      <td align="center" id="tddisc" class="lines"><div align="right"><?php echo formatNumber($row->total); ?></div></td>
      </tr>
      <?
           $i++;
	  $j--;       
	  
	  }
      
	  ?>
  </tbody>
            <tfoot>
            <?php
			if($obj->type==4)
				$col=4;
			else
				$col=3;
			?>
             <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="<?php echo $col; ?>"><strong>SubTotal</strong></td>
              <td colspan="1" id=""><strong><?php echo formatNumber($sub); ?></strong> </td>
         </tr>
            </tfoot>
            <tr>
                <td colspan="7" align="right"><strong>Total</strong></td>
              <td colspan="1" id=""><strong><?php echo formatNumber($totaltaxablesales); ?></strong> </td>
            </tr>
             <tr><td align="left" colspan="11">
             <div id="t-foot">
             <div class="remarks">
               <strong>Remarks</strong> </div>
               <div class="tr-totals">
             <div class="p-total"><strong>
               <label>Total Taxable Sales:</label>&nbsp;<?php echo formatNumber($totaltaxablesales); ?>
             </strong></div>
             <div class="tax-total"><strong>
               <label>Tax :</label> <?php echo formatNumber($totaltax); ?>
             </strong> </div>
              <div class="net-total"><strong>
               <label>Total Sales :</label> <?php echo formatNumber($totaltaxablesales+$totaltax); ?>
             </strong> </div>
             </div>
             <div class="tr-details">
             <div class="bal-due"><strong>
               <label>Balance Due :</label>
             </strong><?php echo formatNumber(0);?></div>
             <div class="cr-limit"><strong>
               <label>Credit Limit :</label>
             </strong> <?php echo formatNumber($cust->creditlimit); ?></div>
             </div>
             </div>
             </td></tr>
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
