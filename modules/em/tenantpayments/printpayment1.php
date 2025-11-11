<?php
session_start();
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
$fields="em_plots.name plotid, em_houses.hseno as houseid,em_tenantpayments.paidby, em_tenantpayments.paidon, sys_paymentmodes.name paymentmodeid,fn_banks.name bankid,em_tenantpayments.chequeno ";
$join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_houses on em_tenantpayments.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
$having="";
$groupby="";
$orderby="";
$where=" where em_tenantpayments.documentno='$doc' ";	
$tenantpayments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$tn=$tenantpayments->fetchObject;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../fs-css/printable.css" media="all" type="text/css" rel="stylesheet" />
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
			if(printers[i].indexOf('<?php echo BPRINTER; ?>')>-1)
			{	
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
		jsPrintSetup.setOption('marginTop', 15);
		jsPrintSetup.setOption('marginBottom', 15);
		jsPrintSetup.setOption('marginLeft', 20);
		jsPrintSetup.setOption('marginRight', 5);
		// Do Print
		jsPrintSetup.printWindow(window);
		//window.close();
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
#testTable2 { height:1260px !important;}
</style>
</head>

<body onload="print_doc();">
<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>
<div id="testTable2">
          <table>
            <thead>
            <tr>
<td colspan="10">
            <p style="font-family:'tahoma';font-size:14px;" align="center">Receipt 
            <?php
            if($_GET['copy']==1){
				?>
				- Copy
				<?php 
			}
			else{
?> - Original<?php } ?></p>
            <div style="text-align:center;font-size:12px;font-family:'tahoma';font-size:12px;"><p>Payment Date: <?php echo formatDate($paidon);?></p>			
            <p>Receipt No:<?php echo $doc; ?></p> </div> 
            <div style="text-align:center;text-transform:uppercase;"><strong><?php echo $_SESSION['companyname']; ?></strong>
            <div class="fntt"><span class="desc"><?php echo $_SESSION['companydesc']; ?></span><br/>
            <span class="addr"><?php echo $_SESSION['companyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span><br />
       <span style="font-family:'tahoma';font-size:10px;">
            <strong>Tel:</strong><span class="tel"><?php echo $_SESSION['companytel']; ?></span><br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span><br />
            <strong>Email:</strong><span style="font-family:'tahoma';font-size:10px;text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span></span><br />
<span style="font-family:'tahoma';font-size:10px;" class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span style="font-family:'tahoma';font-size:10px;" class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span><br /><br/>

<span class="name"><strong>Tenant: </strong><?php echo $tenants->code; ?></span>
<span class="name"><?php echo $tenants->firstname; ?>&nbsp;<?php echo $tenants->middlename; ?>&nbsp;<?php echo $tenants->lastname; ?></span><br />
			<?php if(!empty($tenants->address)){?>
            <span class="addr"><?php echo $tenants->address; ?></span> <br />
			<?php }?>
			<span class="addr"><strong>Property: </strong><?php echo $tn->plotid; ?></span> <br />
            <span class="addr"><strong>House No: </strong><?php echo $tn->houseid; ?></span> <br />
			<br />
            <span class="name"><strong>Payment Mode:</strong> <?php echo $tn->paymentmodeid; ?></span><br/>
            <?php if(!empty($tn->bankid)){?>
            <span class="name"><strong>Bank: <?php echo $tn->bankid; ?></strong></span><br/>
            <span class="addr"><strong>Cheque No: <?php echo $tn->chequeno; ?></strong></span>  </div> </div>
            <?php }?>   
			<br />
			<div class="header">

 
</div>
</td>
</tr> 
            <tr>
<td colspan="10">
<table width="100%">
<thead>
  	<tr>
			      <th  width="100%">Description</th>
                  <!--th style="text-align:left;border-bottom:1px dotted #000;" width="100%">Plot</th>
                  <th style="text-align:left;border-bottom:1px dotted #000;" width="100%">Hse No.</th-->
			      <th width="100%">Month</th>
			      <th width="100%">Amount</th>

	</tr>
	</thead>
             
                         </table>
                         </tr>
                         </table>
</div>
<script type="text/javascript" language="javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.tablePagination.0.2.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery_003.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.easing.min.js"></script>
<script type="text/javascript" language="javascript">
$('#take tr', $('#menuTable2')).addClass('hideTr'); //hiding rows for test
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
				$('#take tr', $('#menuTable2')).show();
				$('div#tablePagination').hide();
				subTotal();
				},function(){
				$('#take tr', $('#menuTable2')).addClass('hideTr');
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
