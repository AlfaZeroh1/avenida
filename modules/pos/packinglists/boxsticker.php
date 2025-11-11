<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once("../../crm/customers/Customers_class.php");
require_once("../../crm/agents/Agents_class.php");
require_once("../../pos/packinglistdetails/Packinglistdetails_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../pos/config/Config_class.php");
require_once("../../pos/configaccounts/Configaccounts_class.php");
require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../hrm/employees/Employees_class.php");

//$tenant = $_GET['tenant'];
$doc=$_GET['doc'];
$packingno=$_GET['packingno'];
$boxno=$_GET['boxno'];
$packinglistdon=$_GET['packinglistdon'];
$shippedon=$_GET['shippedon'];
$customerid = $_GET['customerid'];
$id=$_GET['id'];

$ob = (object)$_GET;

// $packinglists = new Packinglists();
// $fields="pos_packinglists.id, pos_packinglists.boxno, pos_packinglists.packedon, pos_packinglists.customerid, count(pos_packinglists.boxno) boxes, count(pos_packinglistdetails.id) bunches, pos_packinglists.customerid, crm_customerconsignees.name customerconsigneeid, sum(pos_packinglistdetails.quantity) quantity";
// $join=" left join pos_packinglistdetails on pos_packinglistdetails.packinglistid=pos_packinglists.id left join crm_customers on crm_customers.id=pos_packinglists.customerid left join crm_customerconsignees on crm_customerconsignees.customerid=crm_customers.id ";
// $where=" where pos_packinglists.documentno='$packingno' and pos_packinglists.boxno='$boxno'";
// $having="";
// $groupby=" group by boxno ";
// $orderby="";
// $packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// $row = $packinglists->fetchObject;



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
		jsPrintSetup.setOption('numCopies',1);
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginTop','2');
		jsPrintSetup.setOption('marginBottom','0');
		jsPrintSetup.setOption('marginLeft','<?php echo $marg['left']; ?>');
		jsPrintSetup.setOption('marginRight','<?php echo $marg['right']; ?>');
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
body{font-family:'arial';font-size:15px;}
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
<table style="border-color:#f00;" border='1' width="100%">
<?php
$packinglists = new Packinglists();
$fields="pos_packinglists.*, count(pos_packinglistdetails.id) bunches, sum(pos_packinglistdetails.quantity) quantity";
$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
$where=" where pos_packinglists.documentno='$packingno' and pos_packinglists.boxno in($boxno)";
$having="";
$groupby=" group by boxno ";
$orderby="";
$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
while($row=mysql_fetch_object($packinglists->result)){

      $customers = new Customers();
      $fields="crm_customers.name, crm_customers.address, crm_customers.code, crm_agents.name agentid, crm_agents.address agentaddress, sys_currencys.name currencyid, sys_currencys.id currency";
      $where=" where crm_customers.id='$row->customerid'";	
      $join=" left join crm_agents on crm_agents.id=crm_customers.agentid left join sys_currencys on sys_currencys.id=crm_customers.currencyid ";
      $having="";
      $groupby="";
      $orderby="";
      $customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $customers = $customers->fetchObject;

      $packinglistsdetails = new Packinglistdetails();
      $fields="group_concat(distinct pos_items.name) itemid, group_concat(distinct pos_colours.name) colourid, group_concat(distinct pos_sizes.name) sizeid";
      $where=" where packinglistid='$row->id'";
      $join=" left join pos_items on pos_items.id=pos_packinglistdetails.itemid left join pos_colours on pos_colours.id=pos_items.colourid left join pos_sizes on pos_sizes.id=pos_packinglistdetails.sizeid ";
      $having="";
      $groupby=" ";
      $orderby="";
      $packinglistsdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $packinglistsdetails = $packinglistsdetails->fetchObject;
      
      $employees = new Employees();
      $fields=" hrm_employees.pfnum ";
      $join=" left join auth_users on auth_users.employeeid=hrm_employees.id ";
      $where=" where auth_users.id='$row->createdby'";
      $having="";
      $groupby="  ";
      $orderby="";
      $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $employees = $employees->fetchObject;
 ?>
 <tr>
 <?
      $i=0;
      while($i<2){
      ?>

<td width="50%" height="200px">
      <table class="table table-bordered table-codensed " width="100%" style="padding:0px !important;margin:0px !important;">
      <tr>
      <td>
	<table class="table table-bordered" width="100%">
	<?php if(!empty($ob->new)){ ?>
	<tr style="line-height:15px;text-align:top;">
	<?php }else{ ?>
	<tr>
	<?php } ?>
	<td width="70%">
	<h3>EXPORTER</h3>
	<p style="font-weight:bold;font-size:14px;"><?php echo  strtoupper($_SESSION['companyname']);?></p>
	</td>
      <!-- <td>
	<h3>FLO ID</h3>
	<p style="font-weight:bold;">3797</p>
	</td>-->
	<td>
	<h3>Country</h3>
	<p style="font-weight:bold;">KENYA</p>
	</td>
	</tr>
	<?php if(!empty($ob->new)){ ?>
	<tr style="line-height:18px;text-align:top;">
	<?php }else{ ?>
	<tr>
	<?php } ?>
	<td>
	<h3>IMPORTER</h3>
	<p style="font-weight:bold;"  ><u><?php echo $customers->name; ?></p></u>
	</td>
	<?php if(!empty($ob->new)){ ?>
	<td>Destination<br/>
	<div style="border:1px gray solid;width:200px;height:20px;"></div>
	</td>
	<?php } ?>
	<td>&nbsp;</td>
	</tr>
	</table>
      </td>
      </tr>
      <tr>
      <td>
      <table class="table table-condensed" width="100%">
	<?php if(!empty($ob->new)){ ?>
	<tr style="line-height:5px;text-align:top;">
	<?php }else{ ?>
	<tr>
	<?php } ?>
	<td>
	<h3>Variety</h3>
	<?php $items = explode(",",$packinglistsdetails->itemid);
	      if(count($items)>1){
		$items="mixed box";
	      }else{
		$items=$packinglistsdetails->itemid;
	      }
	      ?>
	<p style="font-size:14px;"><?php echo strtoupper($items); ?></p>
	</td>
	<td>
	<h3>Colour</h3>
	<?php $colours = explode(",",$packinglistsdetails->colourid);
	      if(count($colours)>1){
		$colours="Mixed Box";
	      }else{
		$colours=$packinglistsdetails->colourid;
	      }?>
	<p style="font-size:14px;"><?php echo strtoupper($colours); ?></p>
	</td>
	<td>
	<h3>Length</h3>
	<p style="font-size:14px;"><?php echo strtoupper($packinglistsdetails->sizeid); ?></p>
	</td>
	</tr>	
	<?php if(!empty($ob->new)){ ?>
	<tr style="line-height:12px;text-align:top;">
	<?php }else{ ?>
	<tr>
	<?php } ?>
	<?php if(!empty($ob->new)){ ?>
	<td>
	Purchase Order<br/>
	<div style="border:1px gray solid;width:200px;height:20px;"></div>
	</td>
	<?php } ?>
	<td>
	<h3>Packer</h3>
	<p style="font-weight:bold;"><?php echo $employees->pfnum; ?></p>
	</td>
	<td>
	<h3>Weight</h3>
	<p style="font-weight:bold;align:top;">&nbsp;<?php echo ($row->actualweight); ?></p>
	</td>
	</tr>
        <?php if(!empty($ob->new)){ ?>
	<tr style="line-height:12px;text-align:top;">
	<?php }else{ ?>
	<tr>
	<?php } ?>
	<?php if(!empty($ob->new)){ ?>
	<td>
	Harvest Date<br/>
	<div style="border:1px gray solid;width:200px;height:20px;"></div>
	</td>
	<?php } ?>
	</tr>
	<?php if(!empty($ob->new)){ ?>
	<tr style="line-height:12px;text-align:top;">
	<?php }else{ ?>
	<tr>
	<?php } ?>
	<?php if(!empty($ob->new)){ ?>
	<td>
	Part No<br/>
	<div style="border:1px gray solid;width:200px;height:20px;"></div>
	</td>
	<?php } ?>
	<td>
	<h4>TOTAL STEMS</h4>
	<p style="font-weight:bold;"><?php echo $row->quantity; ?></p>
	</td>
	<td>
	<h4>TOTAL BUNCHES</h4>
	<p style="font-weight:bold;"><?php echo $row->bunches; ?></p>
	</td>
	<td>
	<p style="font-weight:bold;">&nbsp;</p>
	</td>
	</tr>
	</table>
      </td>
      </tr>
      <tr>
      <td>
      <table class="table table-condensed" width="100%">
      <tr>
       <td width="70%">CARGO AGENT: <?php echo $customers->agentid; ?></td>
      <td width="30%">BOX No: <?php echo $row->boxno; ?></td>
        <td width="0%"></td>
   
       
      </tr>
      </table>
      </td>
      </tr>
      </table>
      </td>
<?php
$i++;
  }
  ?>
  </tr>
  <?
}
?>
</table>
<!-- bodyend -->

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
