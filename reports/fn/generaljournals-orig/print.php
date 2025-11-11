<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");
require_once("../../../modules/em/tenants/Tenants_class.php");
require_once("../../../modules/em/landlords/Landlords_class.php");

$obj=(object)$_GET;

$generaljournalaccounts = new Generaljournalaccounts();
$fields = "*";
$where=" where id='$obj->accountid' ";
$join="";
$having="";
$groupby="";
$orderby="";
$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$generaljournalaccounts=$generaljournalaccounts->fetchObject;
	
if($generaljournalaccounts->acctypeid==29){
	$tenants = new Tenants();
}
elseif($generaljournalaccounts->acctypeid==30){
	$tenants = new Landlords();
}
$fields = "*";
$where=" where id='$generaljournalaccounts->refid' ";
$join="";
$having="";
$groupby="";
$orderby="";
$tenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$tenants=$tenants->fetchObject;

$acctypes = new Acctypes();
$fields = "*";
$where=" where id='$generaljournalaccounts->acctypeid' ";
$join="";
$having="";
$groupby="";
$orderby="";
$acctypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$acctypes=$acctypes->fetchObject;

$track=0;
if(!empty($obj->accountid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

	$rptwhere.=" fn_generaljournals.accountid='$obj->accountid'";
	$track++;
}

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
table{width:100%;border:1px solid #ccc;font-family:tahoma;font-size:12px;}
td{border:1px dotted #ccc;}
.fnt{font-family:tahoma;font-size:9px;}
.fntt{font-family: tahoma ;font-size:12px;}
/*table{overflow-y:visible; overflow-x:hidden;font-family:tahoma;}
tbody{overflow-y:visible; overflow-x:visible; height:auto;}
div{overflow-y:visible; overflow-x:visible; height:auto;}
hideTr{ display:table-row;}
table tr.hideTr[style] {
   display: table-row !important;
}*/
div#tablePagination, div.print{display:none;}
div#tablePagination[style]{display:none !important; }
tr.brk{
page-break-after: always;
}
.noprint{ display:none;}
</style>
<style media="screen">
/*#testTable2 { height:1160px !important;}*/
</style>
</head>

<body onload="print_doc();">
<div class="print"><a href="javascript:print();">Print</a>&nbsp;<a class="review" href="javascript:viewAll();">View All</a></div>

     
<table width="100%">
<thead>
<tr>
<td colspan="7">
<div id="company" style="text-align:center">            
            <h2><?php echo $_SESSION['companyname']; ?></h2>
            <span class="desc"><?php echo $_SESSION['companydesc']; ?></span><br />
            <span class="addr"><?php echo $_SESSION['companyaddr']; ?>,<br/><?php echo $_SESSION['companytown']; ?></span><br />
            <span class="tel">Tel: <?php echo $_SESSION['companytel']; ?></span>  <br />
            <span style="text-transform:lowercase;"><strong>Website:</strong><?php echo $_SESSION['companyweb']; ?></span><br />
            <span style="text-transform:lowercase;"><strong>Email:</strong><?php echo $_SESSION['companyemail']; ?></span><br />
            <strong>
           <h2>
           <?php echo initialCap($acctypes->name); ?> Statement
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
<div class="fnt">
				  <!--th width="" ><span style="text-decoration:underline;">#</span></th-->
			      <th width="" align="left"><span style="text-decoration:underline;">Transaction</span></th>
			      <th width="" align="left"><span style="text-decoration:underline;">Remarks</span></th>
			      <th width="" align="left"><span style="text-decoration:underline;">Transaction Date</span></th>
			      <th width="" align="left"><span style="text-decoration:underline;">Debit</span></th>
			      <th width="" align="left"><span style="text-decoration:underline;">Credit</span></th>
			      <th width="" align="left"><span style="text-decoration:underline;">Balance</span></th>
</div>
</tr>
</thead>
          <tbody>
    <?
    $i=0;
	$generaljournals=new Generaljournals ();
	$fields="fn_generaljournals.id, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
	$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid  ";
	$having="";
	$where= " $rptwhere";
	$groupby= " $rptgroup";
	$orderby="";
	$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$generaljournals->result;
	$credit=0;
	$debit=0;
	$bal=0;
	
	$acctypes = new Acctypes();
	$fields="*";
	$where=" where id='$generaljournalaccounts->acctypeid' ";
	$join="";
	$having="";
	$orderby="";
	$groupby ="";
	$acctypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$acctypes=$acctypes->fetchObject;
	
	while($row=mysql_fetch_object($res)){
	$i++;
	$credit+=$row->credit;
	$debit+=$row->debit;		
	
	if (strtolower($acctypes->balance)=='dr'){
		$bal+=$row->debit-$row->credit;
	}
	else{
		$bal+=$row->credit-$row->debit;
	}
	
     ?>
    <tr class="<?php echo $some_class; ?>">
      <!--td class="" align="left"><?php //echo $i+1; ?></td-->
      <td id="tddes" height="24" align="left" class="lines"><?php echo $row->transactionid; ?></td>
      <td id="tset1"><span class="stitle lines"><?php echo $row->remarks; ?></span></td>
      <td class="stitle lines"><?php echo formatDate($row->transactdate); ?></td>
      <td class="stitle lines"><div align="left"><?php echo formatNumber($row->debit); ?></div></td>
      <td class="noprint lines"><div align="left"><?php echo formatNumber($row->credit); ?></div></td>
      <td align="center" id="tdquantity" class="lines"><div align="left"><strong><?php echo formatNumber($bal); ?></strong></div></td>
      </tr>
      <?
           $i++;
	  $j--;       
	  
	  }
	  $diff=$debit-$credit;
	  if($diff<0){
	  	$diff=$diff*-1;
	  	$total=$credit;
	  }
	  else{
	  	$total=$debit;
	  }
	  ?>
  </tbody>

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
