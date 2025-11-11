<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");

$id = $_GET['id'];
$class = $_GET['class'];


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Generaljournals";
//connect to db
$db=new DB();

$obj=(object)$_POST;

$obj->shdocumentno=true;

if(!empty($id)){
	$obj->accountid=$id;
	$obj->class=$class;
}

include "../../../head.php";

//processing filters

$rptwhere=" where fn_generaljournals.accountid='$obj->accountid' ";

$track=1;

if(empty($obj->action)){
  $obj->fromtransactdate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
  $obj->totransactdate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}


if(!empty($obj->fromtransactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate>='$obj->fromtransactdate'";
	$track++;
}

if(!empty($obj->totransactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate<='$obj->totransactdate'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#accountname").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=generaljournalaccounts&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#accountid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript">
function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print invoice?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("print.php?accountid=<?php echo $obj->accountid; ?>&month=<?php echo $obj->month; ?>&year=<?php echo $obj->year; ?>",450,940);
	}
}
 </script>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<form  action="account.php" method="post" name="generaljournals">
<table>
<tr>
<td><a href="#" onclick="Clickheretoprint();">Print</a>&nbsp;</td>
<td>
<input type='hidden' name="accountid" value="<?php echo $obj->accountid; ?>"/>
<input type='hidden' name="class" value="<?php echo $obj->class; ?>"/>
From: <input type="text" size="12" class="date_input" name="fromtransactdate" value="<?php echo $obj->fromtransactdate; ?>"/></td>
<td>To: <input type="text" size="12" class="date_input" name="totransactdate" value="<?php echo $obj->totransactdate; ?>"/>&nbsp;
<input type="submit" name="action" class='btn' value="Filter"/>
</td>
</tr>
</table>
<div id="boxB" class="sh" style="left: 10px; top: 63px; display: none; z-index: 500;">
<div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
<a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>

<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Account</td>
				<td><input type='text' size='20' name='accountname' id='accountname' value='<?php echo $obj->accountname; ?>'>
					</td>
			</tr>
			<tr>
				<td>Date</td>
				<td><input type='text' id='transactdate' size='10' name='transactdate' class="date_input" value='<?php echo $obj->transactdate;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<?php 
$generaljournalaccounts = new Generaljournalaccounts();
$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.name, sys_acctypes.name as acctype, sys_acctypes.id as acctypeid , fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
$join=" left join sys_acctypes on fn_generaljournalaccounts.acctypeid=sys_acctypes.id ";
$having="";
$groupby="";
$orderby="";
$where = " where fn_generaljournalaccounts.id='$obj->accountid' ";
$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$generaljournalaccounts=$generaljournalaccounts->fetchObject;

$obj->shtransactionid=1;
$obj->shremarks=1;
$obj->shmemo=1;
$obj->shtransactdate=1;
$obj->shdebit=1;
$obj->shcredit=1;
$obj->shjvno=1;
?>
<table style="clear:both;"  class="tgrid display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
		<?php 
		$cols=0;
		if($obj->shaccountid==1 ){ 
			$cols++;
		} 
		if($obj->shdaccountid==1 ){
			$cols++; 
		} 
		if($obj->shtid==1 ){ 
			$cols++;
		}
		if($obj->shdocumentno==1 ){ 
			$cols++;
		}
		if($obj->shmode==1 ){ 
			$cols++;
		}
		if($obj->shtransactionid==1   or empty($obj->action)){
			$cols++;
		}
		if($obj->shremarks==1   or empty($obj->action)){
			$cols++;
		}
		if($obj->shmemo==1 or empty($obj->action)){
			$cols++;
		}
		if($obj->shtransactdate==1  or empty($obj->action)){
			$cols++;
		}
		if($obj->shdebit==1  or empty($obj->action)){
			$cols++;
		}
		if($obj->shcredit==1  or empty($obj->action)){
			$cols++;
		}
		if($obj->shjvno==1 ){
			$cols++;
		}
		if($obj->shchequeno==1 ){
			$cols++;
		}
		if($obj->shdid==1 ){
			$cols++;
		}
		if($obj->shreconstatus==1 ){
			$cols++;
		}
		if($obj->shrecondate==1 ){
			$cols++;
		} ?>
		<tr>
			<th style="align:center;" colspan="<?php echo $cols; ?>"><span style="font-weight: bold;"><?php echo $generaljournalaccounts->name; ?></span></th>
		</tr>
		<tr>
			<th>#</th>
			<?php if($obj->shaccountid==1 ){ ?>
				<th>Account </th>
			<?php } ?>
			<?php if($obj->shdaccountid==1 ){ ?>
				<th>Debit  Account </th>
			<?php } ?>
			<?php if($obj->shtid==1 ){ ?>
				<th>Item Name </th>
			<?php } ?>
			<?php if($obj->shdocumentno){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shjvno==1 ){ ?>
				<th>JV No. </th>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<th>Mode </th>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<th>Transaction </th>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action)){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<th>Transaction Date </th>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<th>Debit </th>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<th>Credit </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>Cheque No. </th>
			<?php } ?>
			<?php if($obj->shdid==1 ){ ?>
				<th>* </th>
			<?php } ?>
			<?php if($obj->shreconstatus==1 ){ ?>
				<th>Reconciliation Status </th>
			<?php } ?>
			<?php if($obj->shrecondate==1 ){ ?>
				<th>Reconciliation Date </th>
			<?php } ?>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	  $credit=0;
		$debit=0;
		$bal=0;
	
		$generaljournals=new Generaljournals ();
		$fields="fn_generaljournals.id, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit) debit, sum(fn_generaljournals.credit) credit, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid  ";
		$having="";
		$where= " where fn_generaljournals.transactdate < '$obj->fromtransactdate' and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= " $rptgroup";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
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
			<td><?php echo $i; ?></td>
			<?php if($obj->shaccountid==1){ ?>
				<td><?php echo $row->accountid; ?></td>
			<?php } ?>
			<?php if($obj->shdaccountid==1 ){ ?>
				<td><?php echo $row->daccountid; ?></td>
			<?php } ?>
			<?php if($obj->shtid==1 ){ ?>
				<td><?php echo $row->tid; ?></td>
			<?php } ?>
			<?php if($obj->shdocumentno ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shjvno==1 ){ ?>
				<td><?php echo $row->jvno; ?></td>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<td><?php echo $row->mode; ?></td>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<td>Balance C/D</td>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action) ){ ?>
				<td><?php echo $row->memo; ?></td>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<td><?php echo formatDate($row->transactdate); ?></td>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if(!empty($row->debit)){echo formatNumber($row->debit);} ?></td>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if(!empty($row->credit)){echo formatNumber($row->credit);} ?></td>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<td><?php echo $row->chequeno; ?></td>
			<?php } ?>
			<?php if($obj->shdid==1 ){ ?>
				<td><?php echo $row->did; ?></td>
			<?php } ?>
			<?php if($obj->shreconstatus==1 ){ ?>
				<td><?php echo $row->reconstatus; ?></td>
			<?php } ?>
			<?php if($obj->shrecondate==1 ){ ?>
				<td><?php echo formatDate($row->recondate); ?></td>
			<?php } ?>
			<td align="right" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
		</tr>
		<?
		
		$i=0;
		$generaljournals=new Generaljournals ();
		$fields="fn_generaljournals.id, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid  ";
		$having="";
		$where= " $rptwhere ";
		$groupby= " $rptgroup ";
		$orderby=" order by fn_generaljournals.transactdate ";
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
			<td><?php echo $i; ?></td>
			<?php if($obj->shaccountid==1){ ?>
				<td><?php echo $row->accountid; ?></td>
			<?php } ?>
			<?php if($obj->shdaccountid==1 ){ ?>
				<td><?php echo $row->daccountid; ?></td>
			<?php } ?>
			<?php if($obj->shtid==1 ){ ?>
				<td><?php echo $row->tid; ?></td>
			<?php } ?>
			<?php if($obj->shdocumentno ){ ?>
				<td><?php echo $row->documentno; ?></td>
			<?php } ?>
			<?php if($obj->shjvno==1 ){ ?>
				<td><?php echo $row->jvno; ?></td>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<td><?php echo $row->mode; ?></td>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<td><?php echo $row->transactionid; ?></td>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<td><?php echo $row->remarks; ?></td>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action) ){ ?>
				<td><?php echo $row->memo; ?></td>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<td><?php echo formatDate($row->transactdate); ?></td>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if(!empty($row->debit)){echo formatNumber($row->debit);} ?></td>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if(!empty($row->credit)){echo formatNumber($row->credit);} ?></td>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<td><?php echo $row->chequeno; ?></td>
			<?php } ?>
			<?php if($obj->shdid==1 ){ ?>
				<td><?php echo $row->did; ?></td>
			<?php } ?>
			<?php if($obj->shreconstatus==1 ){ ?>
				<td><?php echo $row->reconstatus; ?></td>
			<?php } ?>
			<?php if($obj->shrecondate==1 ){ ?>
				<td><?php echo formatDate($row->recondate); ?></td>
			<?php } ?>
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
	
	<tr style="font-weight: bold;">
			<td><?php echo $i; ?></td>
			<?php if($obj->shaccountid==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdaccountid==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shtid==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdocumentno ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shjvno==1 ){ ?>
				<td>&nbsp; </td>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<td>&nbsp; </td>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<td>&nbsp; </td>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<td>Balance B/D </td>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action)){ ?>
				<td>&nbsp; </td>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<td><?php echo formatDate(date("Y-m-d"));?></td>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<td><?php if($credit>$debit){echo formatNumber($diff);}?> </td>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<td><?php if($debit>$credit){echo formatNumber($diff);}?> </td>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<td>&nbsp; </td>
			<?php } ?>
			<?php if($obj->shdid==1 ){ ?>
				<td>&nbsp; </td>
			<?php } ?>
			<?php if($obj->shreconstatus==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shrecondate==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<td></td>
		</tr>
		
	</tbody>
	<tfoot>
	<tr>
			<th>#</th>
			<?php if($obj->shaccountid==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdaccountid==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtid==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shjvno==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shmemo==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<th><?php echo formatNumber($total);?> </th>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<th><?php echo formatNumber($total);?> </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shreconstatus==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shrecondate==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
