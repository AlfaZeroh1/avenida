<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/agents/Agents_class.php");
require_once("../../pos/returninwarddetails/Returninwarddetails_class.php");
require_once("../../pos/returninwards/Returninwards_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/config/Config_class.php");
require_once("../../pos/configaccounts/Configaccounts_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");

//$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$packingno=$_GET['packingno'];
$shippedon=$_GET['shippedon'];
$customerid = $_GET['customerid'];
$id=$_GET['id'];

$customers = new Customers();
$fields="crm_customers.name, crm_customers.address, case when crm_customers.customerid is not null then customers.name else crm_customers.name end parent, case when crm_customers.customerid is not null then customers.address else crm_customers.address end parentaddress, crm_customers.code,pos_freights.name freightid, crm_agents.name agentid, crm_agents.address agentaddress, sys_currencys.name currencyid, sys_currencys.id currency";
$where=" where crm_customers.id='$customerid'";	
$join=" left join crm_agents on crm_agents.id=crm_customers.agentid left join sys_currencys on sys_currencys.id=crm_customers.currencyid left join pos_freights on pos_freights.id=crm_customers.freightid left join crm_customers customers on customers.id=crm_customers.customerid ";
$having="";
$groupby="";
$orderby="";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

$returninwards = new returninwards();
$fields="*";
$join=" ";
$where=" where pos_returninwards.documentno='$doc'";
$having="";
$groupby=" ";
$orderby="";
$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$invs = $returninwards->fetchObject;

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
body{font-family:'arial';font-size:10px;}
ul{list-style:none !important;}
.table-bordered {
border: 1px solid #ddd;
border-collapse: separate;
/*border-left: 1px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;*/
}
hr {
display: block;
-webkit-margin-before: 0.2em;
-webkit-margin-after: 0.2em;
-webkit-margin-start: auto;
-webkit-margin-end: auto;
border-style: inset;
border-width: 1px;
}
</style>



</head>

<body onload="print_doc();">
<!--<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>-->
<!-- headder -->
<table class="table table-bordered">
<table width="100%">
<tr>
<td colspan="8">
<div style="text-align:center"> 
            <div style="text-align:center;text-transform:uppercase;"><strong><?php echo $_SESSION['companyname']; ?></strong>
            <div><span><?php echo $_SESSION['companydesc']; ?></span>
            <span><?php echo $_SESSION['companActual/V.weight Ratioyaddr']; ?>,<?php echo $_SESSION['companytown']; ?></span> <br />
            <span><strong>Tel:</strong> <?php echo $_SESSION['companytel']; ?> </span>  <br/>
            <strong>Website:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyweb']; ?></span>
            <strong>Email:</strong><span style="text-transform:lowercase;"><?php echo $_SESSION['companyemail']; ?></span><br />
<p><span class="tel"><strong>PIN:</strong> <?php echo $_SESSION['companypin']; ?></span> <span class="tel"><strong>VAT:</strong> <?php echo $_SESSION['companyvat']; ?></span></p>
</td>
</tr>
<tr><td colspan="8"><hr></td></tr>
<tr>
<td colspan="7" align="center">
<strong>
<span style="text-align:center;">
       <h2>  CREDIT NOTE
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
      </span>
 </div>
</td>
</tr>
<tr><td colspan="8"><hr></td></tr>
<tr>

<td width="50%" colspan="3">
<h4>To:</h4>
		      <div style="font-size:12px !important;font-family:'arial narrow';"><strong> </strong><?php echo strtoupper($customers->name); ?><br><?php echo $customers->address; ?></div>
		     <!-- <div style="font-size:10px !important;"><strong>returninward No: </strong> <?php echo $doc; ?></div>-->
</td>
<td width="50%" colspan="4">
<h4>Sold To:</h4>
<div style="font-size:12px !important;"><strong>Client Name: </strong><?php echo strtoupper($customers->parent); ?><br/><?php echo $customers->parentaddress; ?></div><br/>
             <div style="font-size:12px !important;"><strong>Date:</strong> <?php echo formatDate($invs->soldon);?></div>
            
</td>
</tr>
<tr>

<td width="50%" colspan="7">
	<div style="font-size:12px !important;"><strong>Credit Note No: </strong><?php echo $invs->creditnotenos; ?></div>
	
	<div style="font-size:12px !important;"><strong>Magana Flowers FLO ID:</strong><?php echo "3797"; ?></div>
</td>

</tr>
<tr>

<td width="50%" colspan="4">
	<div style="font-size:12px !important;">Currency: <?php echo initialCap($customers->currencyid); ?></div>
<!-- 	<div style="font-size:12px !important;">No Of Boxes:<?php echo $inv->boxes; ?></div> -->
</td>
<td width="50%" colspan="3">
	  <div style="font-size:12px !important;">&nbsp;</div>
	<div style="font-size:12px !important;">&nbsp;</div>
            
</td>
</tr>


<!-- headerend -->

<!-- bodyyy -->
  
  <?php
  $tts=0;
  $returninwards = new returninwards();
  $fields=" pos_returninwarddetails.itemid, pos_returninwarddetails.sizeid, sum(pos_returninwarddetails.quantity) quantity, pos_returninwarddetails.price,sum(pos_returninwarddetails.total) total ";
  $join=" left join pos_returninwarddetails on pos_returninwarddetails.returninwardid=pos_returninwards.id ";
  $where=" where pos_returninwards.documentno='$doc' ";
  $having="";
  $groupby=" group by itemid, sizeid ";
  $orderby="";
  $returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  if($returninwards->affectedRows>0){
    ?>
    <table width="100%">   
    <tr>
      <th>VARIETY</th>
      <th>SIZE</th>
      <th>QTY</th>
      <th>RATE</th>
      <th>AMT</th>
    </tr>
    
   <tr><td colspan="5"><hr></td></tr>
    <?
  while($row=mysql_fetch_object($returninwards->result)){
  $tts+=$row->total;
  
  $items = new Items();
  $fields=" * ";
  $join="";
  $groupby="";
  $having="";
  $where=" where id='$row->itemid'";
  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $items=$items->fetchObject;
  
  $sizes = new Sizes();
  $fields=" * ";
  $join="";
  $groupby="";
  $having="";
  $where=" where id='$row->sizeid'";
  $sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $sizes=$sizes->fetchObject;
   ?>
   <tr>
    <td><?php echo $items->name; ?></td>
    <td><?php echo $sizes->name; ?></td>
    <td><?php echo $row->quantity; ?></td>
    <td align="right"><?php echo $row->price; ?></td>
    <td align="right"><?php echo formatNumberD($row->total,3); ?></td>
   </tr>
   <?php
  }
  ?>
  
  <tr>
    <td colspan="4">Total</td>
    <td align="right"><?php echo formatNumberD($tts,3); ?></td>
  </tr>
   <tr><td colspan="5"><hr></td></tr>
  </table>
  
<!-- bodyend -->
<?php
}
$config = new Config();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" ";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
while($configs=mysql_fetch_object($config->result)){
  if($configs->name=="TERMSANDCONDITIONS")
    $termsandconditions=$configs->value;
  if($configs->name=="DECLARATION"){
    $declaration=$configs->value;
  }
  if($configs->name=="PAYMENTTERMS"){
    $paymentterms=$configs->value;
  }
}

$configaccounts = new Configaccounts();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where currencyid='$customers->currency' ";
$configaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$configaccounts = $configaccounts->fetchObject;
?>
<!-- foooter -->
<table class="table table-codensed">
<tr>
<div style="font-size:10px !important;"><strong>Payment Details:</strong> All Payments are to be borne by: <?php echo strtoupper($customers->name); ?></div>
<div style="font-size:10px !important;"><strong>Payment Terms:<?php echo $paymentterms; ?>&nbsp;<?php echo $configaccounts->name; ?>&nbsp;<?php echo $configaccounts->accno; ?></div>
</tr>
<tr>

<div style="font-size:10px !important;text-align:center;"><?php echo $declaration; ?></div>
<div style="font-size:10px !important;">Signed:....................................</div>
<div style="font-size:10px !important;">Dated:.....................................</div>

</tr>
<tr>
<div style="font-size:10px !important;text-align:center;">
           <ul>
           <h6>TERMS AND CONDITIONS</h6>
           <li><?php echo $termsandconditions; ?></li>
           </ul>
           
</div>
         </tr>



</table>
<!-- footerend -->
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
