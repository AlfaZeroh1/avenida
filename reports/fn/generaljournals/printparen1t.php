<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");

$obj->accountid = $_GET['accountid'];
$obj->currencyid = $_GET['currencyid'];
if(empty($obj->currencyid)){
$obj->currencyid='NULL';
}
$obj->totransactdate = $_GET['totransactdate'];
$obj->fromtransactdate = $_GET['fromtransactdate'];
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
<?php 
$generaljournalaccounts = new Generaljournalaccounts();
$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.name, sys_currencys.name currencyid, sys_acctypes.name as acctype, sys_acctypes.id as acctypeid , fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
$join=" left join sys_acctypes on fn_generaljournalaccounts.acctypeid=sys_acctypes.id left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid ";
$having="";
$groupby="";
$orderby="";
$where = " where fn_generaljournalaccounts.id='$obj->accountid' ";
$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$generaljournalaccounts=$generaljournalaccounts->fetchObject;

$type=$generaljournalaccounts->acctypeid;

if($generaljournalaccounts->acctypeid==29)
{
$customers = new Customers();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where = " where crm_customers.name='$generaljournalaccounts->name' ";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers=$customers->fetchObject;
}
elseif($generaljournalaccounts->acctypeid==30)
{
$suppliers = new Suppliers();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where = " where proc_suppliers.name='$generaljournalaccounts->name' ";
$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$suppliers=$suppliers->fetchObject;
}

?>
           <h1>
           <div align="right" style="margin-right:200px;" ><?php if($generaljournalaccounts->acctypeid==30) echo "Supplier"; else echo "Customer"; ?> Statement</div>
           </h1>
           </span>
            </div>
</td>
</tr>
</thead>
</table>
<table width="100%">
<thead>
<tr > 
<td width="50%">
<div id="company" style="text-align:left">  
        
            <p><strong><h2>FROM:</h2>
            <h3><?php echo $_SESSION['companyname']; ?></h3>
            <?php echo $_SESSION['companyaddr']; ?>,<br/>
            <?php echo $_SESSION['companytown']; ?><br />
            Tel: <?php echo $_SESSION['companytel']; ?>
            </strong>
            </p>
</div>
</td>
<td width="50%">
<table width="100%">
<thead>
<tr > 
<td width="50%">
<div id="company" style="text-align:left">  
 <?php
 if($generaljournalaccounts->acctypeid==29)
{?>
<p><strong><h2>TO:</h2>
            <h3><?php echo $generaljournalaccounts->name; ?></h3>
            <?php echo $customers->address; ?>,<br/>
            Tel: <?php echo $customers->tel; ?><br/>
            fax:<?php echo $customers->fax; ?><br />
            Email:<?php echo $customers->email; ?><br />
            <?php echo initialCap($generaljournalaccounts->name); ?> 
            </strong>
            
            </p>
<?php 
}
elseif($generaljournalaccounts->acctypeid==30)
{
?>
<h2><?php echo $generaljournalaccounts->name; ?></h2>
            <span class="addr"><?php echo $suppliers->physicaladdress; ?></span><br />
            <span class="tel"><?php echo $suppliers->tel; ?></span><br/>
            <span style="text-transform:lowercase;"><strong>fax:</strong><?php echo $suppliers->fax; ?></span><br />
            <span style="text-transform:lowercase;"><strong>Email:</strong><?php echo $suppliers->email; ?></span><br />
           <h2>
           <?php echo initialCap($generaljournalaccounts->name); ?> Statement  
     </h2>
<?php }      
?>         
</div>
</td>
</tr>
</thead>
</table>
</td>
</tr>
</thead>
</table>
<table width="100%">
<thead>
<tr > 
<td width="100%">
<div id="company" style="text-align:left">  
            <h3>
           <div align="right" style="margin-right:200px;" ><?php echo "Credit Limit:".$customers->creditlimit."  "."</br>"."Credit Days:".$customers->creditdays; ?></div>
           </h3>
</div>
</td>
</tr>
</thead>
</table>
<table width="100%">
<thead>
<tr>
<div class="fnt">
				  <!--th width="" ><span style="text-decoration:underline;">#</span></th-->
			      <th width="" align="center"><span style="text-decoration:underline;">Date</span></th>
			      <th width="" align="center"><span style="text-decoration:underline;">Transaction</span></th>
			      <th width="" align="center"><span style="text-decoration:underline;"></span></th>
			      <th width="" align="center"><span style="text-decoration:underline;">Debit</span></th>
			      <th width="" align="center"><span style="text-decoration:underline;">Credit</span></th>
			      <th width="" align="center"><span style="text-decoration:underline;">Balance</span></th>
</div>
</tr>
</thead>
          <tbody>
          <?php
	        $credit=0;
		$debit=0;
		$bal=0;
	
		$generaljournals=new Generaljournals ();
		$fields="fn_generaljournals.id, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate,case when $obj->currencyid=1 then sum(fn_generaljournals.debit*fn_generaljournals.eurorate) when $obj->currencyid=5 then sum(fn_generaljournals.debit*fn_generaljournals.rate) else sum(fn_generaljournals.debit) end  debit, case when $obj->currencyid=1 then sum(fn_generaljournals.credit*fn_generaljournals.eurorate) when $obj->currencyid=5 then sum(fn_generaljournals.credit*fn_generaljournals.rate) else sum(fn_generaljournals.credit) end credit";
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid ";
		$having="";
		$where= " where fn_generaljournals.transactdate < '$obj->fromtransactdate' and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals->sql;
		$row=$generaljournals->fetchObject;
		
		$acctypes = new Acctypes();
		$fields="*";
		$where=" where id='$generaljournalaccounts->acctypeid' ";
		$join="";
		$having="";
		$orderby="";
		$groupby ="";
		$acctypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$acctypes=$acctypes->fetchObject;
		
		$credit+=$row->credit;
		$debit+=$row->debit;		
		
		if (strtolower($acctypes->balance)=='dr'){
			$bal+=$row->debit-$row->credit;
		}
		else{
			$bal+=$row->credit-$row->debit;
		}
		
		?>
		<tr>
			<td><?php echo formatDate($obj->fromtransactdate); ?></td>
			<td colspan="2"><?php echo $row->remarks; ?></td>
			<td align="right"><?php if(!empty($row->debit)){echo formatNumber($row->debit);} ?></td>
			<td align="right"><?php if(!empty($row->credit)){echo formatNumber($row->credit);} ?></td>
			<td align="right" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
		</tr>
          <?
		
		$i=0;
		$generaljournals=new Generaljournals ();
		$fields="fn_generaljournals.id, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, case when $obj->currencyid=1 then (fn_generaljournals.debit*fn_generaljournals.eurorate) when $obj->currencyid=5 then (fn_generaljournals.debit*fn_generaljournals.rate) else fn_generaljournals.debit end  debit, case when $obj->currencyid=1 then (fn_generaljournals.credit*fn_generaljournals.eurorate) when $obj->currencyid=5 then (fn_generaljournals.credit*fn_generaljournals.rate) else (fn_generaljournals.credit) end credit";
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid ";
		$having="";
		$where= " where fn_generaljournals.transactdate >= '$obj->fromtransactdate' and fn_generaljournals.transactdate <= '$obj->totransactdate' and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby=" order by transactdate ";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$generaljournals->result;	

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
		<tr>
			<td><?php echo formatDate($row->transactdate); ?></td>
			<td colspan="2"><?php echo $row->remarks; ?></td>
			<td align="right"><?php if(!empty($row->debit)){echo formatNumber($row->debit);} ?></td>
			<td align="right"><?php if(!empty($row->credit)){echo formatNumber($row->credit);} ?></td>
			<td align="right" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
		</tr>
		<?php 
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
	
	<!--<tr style="font-weight: bold;">
	      <td><?php echo formatDate(date("Y-m-d")); ?></td>
	      <td>Balance B/D</td>
	      <td align="right"><?php if($credit>$debit){echo formatNumber($diff);}?> </td>
	      <td align="right"><?php if($debit>$credit){echo formatNumber($diff);}?> </td>
	      <td align="right" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
		
	</tr>-->
   </tbody>
   <tfoot>
	<tr>
	    <td>&nbsp;</td>
	    <td style="font-weight: bold; " colspan="2">Total</td>
	    <td align="right" style="font-weight: bold; "><?php echo formatNumber($total); ?></td>
	    <td align="right" style="font-weight: bold; "><?php echo formatNumber($total); ?></td>
	    <td align="right" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
	    
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td style="font-weight: bold; ">&nbsp;</td>
	    <td align="right" style="font-weight: bold; ">&nbsp;</td>
	    <td align="right" style="font-weight: bold; ">&nbsp;</td>
	    <td align="right" style="font-weight: bold; ">&nbsp;</td>
	    <td align="right" style="font-weight: bold; ">&nbsp;</td>
	</tr>
	<?php if($type==29){?>
	<tr>
	    <td align="center" style="font-weight: bold; ">CURRENT</td>
	    <td align="center" style="font-weight: bold; ">1-30 DAYS PAST DUE</td>
	    <td align="center" style="font-weight: bold; ">31-60 DAYS PAST DUE</td>
	    <td align="center" style="font-weight: bold; ">60-90 DAYS PAST DUE</td>
	    <td align="center" style="font-weight: bold; ">OVER 90 DAYS PAST DUE</td>
	    <td align="center" style="font-weight: bold; ">Amount Due</td>
	</tr>
	<?php } ?>
	 <?php
	        $generaljournals11=new Generaljournals ();
		$fields="case when $obj->currencyid=1 then (sum(fn_generaljournals.debit*fn_generaljournals.eurorate)-sum(fn_generaljournals.credit*fn_generaljournals.eurorate)) when $obj->currencyid=5 then (sum(fn_generaljournals.debit*fn_generaljournals.rate)-sum(fn_generaljournals.credit*fn_generaljournals.rate)) else (sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit)) end  bal";
		$join="";
		$having="";
		$where= " where fn_generaljournals.transactdate <= '$obj->totransactdate' and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)<0 and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals11->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals11->sql;echo "</br>";echo "</br>";
		$generaljournals11=$generaljournals11->fetchObject;
		
		$generaljournals1=new Generaljournals ();
		$fields="case when $obj->currencyid=1 then (sum(fn_generaljournals.debit*fn_generaljournals.eurorate)-sum(fn_generaljournals.credit*fn_generaljournals.eurorate)) when $obj->currencyid=5 then (sum(fn_generaljournals.debit*fn_generaljournals.rate)-sum(fn_generaljournals.credit*fn_generaljournals.rate)) else (sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit)) end  bal";
		$join="";
		$having="";
		$where= " where fn_generaljournals.transactdate <= '$obj->totransactdate' and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)>0 and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)<=30 and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals1->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals1->sql;echo "</br>";echo "</br>";
		$generaljournals1=$generaljournals1->fetchObject;
		
		$generaljournals2=new Generaljournals ();
		$fields="case when $obj->currencyid=1 then (sum(fn_generaljournals.debit*fn_generaljournals.eurorate)-sum(fn_generaljournals.credit*fn_generaljournals.eurorate)) when $obj->currencyid=5 then (sum(fn_generaljournals.debit*fn_generaljournals.rate)-sum(fn_generaljournals.credit*fn_generaljournals.rate)) else (sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit)) end  bal";
		$join="";
		$having="";
		$where= " where fn_generaljournals.transactdate <= '$obj->totransactdate' and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)>30 and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)<=60 and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals2->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals2->sql;echo "</br>";echo "</br>";
		$generaljournals2=$generaljournals2->fetchObject;
		
		$generaljournals3=new Generaljournals ();
		$fields="case when $obj->currencyid=1 then (sum(fn_generaljournals.debit*fn_generaljournals.eurorate)-sum(fn_generaljournals.credit*fn_generaljournals.eurorate)) when $obj->currencyid=5 then (sum(fn_generaljournals.debit*fn_generaljournals.rate)-sum(fn_generaljournals.credit*fn_generaljournals.rate)) else (sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit)) end  bal";
		$join="";
		$having="";
		$where= " where fn_generaljournals.transactdate <= '$obj->totransactdate' and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)>60 and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)<=90  and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals3->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals3->sql;echo "</br>";echo "</br>";
		$generaljournals3=$generaljournals3->fetchObject;
		
		$generaljournals4=new Generaljournals ();
		$fields="case when $obj->currencyid=1 then (sum(fn_generaljournals.debit*fn_generaljournals.eurorate)-sum(fn_generaljournals.credit*fn_generaljournals.eurorate)) when $obj->currencyid=5 then (sum(fn_generaljournals.debit*fn_generaljournals.rate)-sum(fn_generaljournals.credit*fn_generaljournals.rate)) else (sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit)) end  bal";
		$join="";
		$having="";
		$where= " where fn_generaljournals.transactdate <= '$obj->totransactdate' and (DATEDIFF('$obj->totransactdate',transactdate)+$customers->creditdays)>90  and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals4->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals4->sql;echo "</br>";echo "</br>";
		$generaljournals4=$generaljournals4->fetchObject;
		
		?>
	<?php if($type==29){?>
	<tr>
	    <td align="center" style="font-weight: bold; "><?php echo formatNumber($generaljournals11->bal); ?></td>
	    <td align="center" style="font-weight: bold; "><?php echo formatNumber($generaljournals1->bal); ?></td>
	    <td align="center" style="font-weight: bold; "><?php echo formatNumber($generaljournals2->bal); ?></td>
	    <td align="center" style="font-weight: bold; "><?php echo formatNumber($generaljournals3->bal); ?></td>
	    <td align="center" style="font-weight: bold; "><?php echo formatNumber($generaljournals4->bal); ?></td>
	    <td align="center" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
	</tr>
	<?php } ?>
  </tfoot>
</table>
 

<script type="text/javascript" language="javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.tablePagination.0.2.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery_003.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.easing.min.js"></script>
</body>
</html>
