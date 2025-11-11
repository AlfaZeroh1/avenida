<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");

$id = $_GET['id'];
$class = $_GET['class'];


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$auth->roleid="8756";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);

$page_title="Generaljournals";
//connect to db
$db=new DB();

$obj=(object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->tb)){
  $obj->tb=$ob->tb;
}

if(!empty($ob->categoryid)){
  $obj->categoryid=$ob->categoryid;
}

if(!empty($ob->id)){
  $obj->accountid=$ob->id;
}
 
if(empty($obj->action)){
  $obj->totransactdate=date('Y-m-d');
  $obj->fromtransactdate=$_SESSION['startdate'];
  
  if(!empty($ob->fromtransactdate))
  $obj->fromtransactdate=$ob->fromtransactdate;
  
  if(!empty($ob->totransactdate))
    $obj->totransactdate=$ob->totransactdate;
    
  $obj->currencyid=5;
}

//get account type
$query="select s.* from sys_acctypes s left join fn_generaljournalaccounts gn on s.id=gn.acctypeid where gn.id='$obj->accountid' ";
$qs = mysql_fetch_object(mysql_query($query));

if($obj->fromtransactdate<$_SESSION['startdate'] and $qs->accounttype!='Cumulative'){
  $obj->fromtransactdate=$_SESSION['startdate'];
}

if(!empty($ob->accounttypeid))
  $obj->accounttypeid=$ob->accounttypeid;
else
  $obj->accounttypeid=$qs->accounttypeid;

$obj->shdocumentno=true;

if($obj->tb){
  $obj->shaccountid=1;
}



include "../../../head.php";

//processing filters

$rptwhere=" where fn_generaljournals.accountid='$obj->accountid' ";

$track=1;

// if(empty($obj->action)){
//   $obj->fromtransactdate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
//   $obj->totransactdate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
// }


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
$rptgroup=' group by accountid,jvno,documentno,transactionid ';
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
	msg="Do you want to print the statement?";
	var ans=confirm(msg);
	if(ans)
	{
	      <?php if(!empty($obj->accountid)) {  ?>
		poptastic("print.php?accountid=<?php echo $obj->accountid; ?>&accounttypeid=<?php echo $obj->accounttypeid; ?>&fromtransactdate=<?php echo $obj->fromtransactdate; ?>&totransactdate=<?php echo $obj->totransactdate; ?>&currencyid=<?php echo $obj->currencyid;; ?>&invno=<?php echo $obj->invno; ?>&pono=<?php echo $obj->pono; ?>&shippingno=<?php echo $obj->shippingno; ?>&delno=<?php echo $obj->delno; ?>",450,940);
		<?php }else{ ?>
		 poptastic("print.php?categoryid=<?php echo $obj->categoryid; ?>&accounttypeid=<?php echo $obj->accounttypeid; ?>&fromtransactdate=<?php echo $obj->fromtransactdate; ?>&totransactdate=<?php echo $obj->totransactdate;; ?>&currencyid=<?php echo $obj->currencyid; ?>&invno=<?php echo $obj->invno; ?>&pono=<?php echo $obj->pono; ?>&shippingno=<?php echo $obj->shippingno; ?>&delno=<?php echo $obj->delno; ?>",450,940);
		<?php } ?>
	}
}
 </script>
 <script>
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
 	} );
 } );
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

<td>
<input type='hidden' name="accountid" value="<?php echo $obj->accountid; ?>"/>
<input type='hidden' name="categoryid" value="<?php echo $obj->categoryid; ?>"/>
<input type='hidden' name="accounttypeid" value="<?php echo $obj->accounttypeid; ?>"/>
<input type='hidden' name="class" value="<?php echo $obj->class; ?>"/>
From: </td>
<td><input type="text" readonly size="12" class="date_input" name="fromtransactdate" value="<?php echo $obj->fromtransactdate; ?>"/></td>
<td>To: </td>
<td><input type="text" readonly size="12" class="date_input" name="totransactdate" value="<?php echo $obj->totransactdate; ?>"/></td>
<td>Currency:</td> 
<td><select name="currencyid" class="selectbox">
				<option value="">Select...</option>  
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby=" order by id desc ";
				$where=" where id in(5,1) ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select></td>
			      <td>Show: </td>
			      <td><input type='checkbox' name='invno'  value='1' <?php if(isset($_POST['invno'])){echo"checked";}?>/></td>
			      <td>Invoice NO.</td>
			      <td><input type='checkbox' name='shippingno'  value='1' <?php if(isset($_POST['shippingno'])){echo"checked";}?>/></td>
			      <td>Shipping No.</td>
			      <td><input type='checkbox' name='delno'  value='1' <?php if(isset($_POST['delno'])){echo"checked";}?>/>Del no</td>
			      <td><input type='checkbox' name='pono'  value='1' <?php if(isset($_POST['pono'])){echo"checked";}?>/>PO No.
			      <input type="hidden" name="acctype" value="<?php echo $obj->acctype; ?>"/>
			      <input type="hidden" name="grp" value="<?php echo $obj->grp; ?>"/>
			      <input type="hidden" name="tb" value="<?php echo $obj->tb; ?>"/>
			      <input type="hidden" name="categoryid" value="<?php echo $obj->categoryid; ?>"/>
			      <input type="hidden" name="accounttypeid" value="<?php echo $obj->accounttypeid; ?>"/>
			      <input type="hidden" name="acctypeid" value="<?php echo $obj->acctypeid; ?>"/></td>
<td><input type="submit" name="action" value="Filter"/></td>
<td><a href="#" class="btn btn-warning" onclick="Clickheretoprint();">Print</a>&nbsp;</td>
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
$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.name, sys_currencys.name currencyid, sys_acctypes.name as acctype, sys_acctypes.id as acctypeid , fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
$join=" left join sys_acctypes on fn_generaljournalaccounts.acctypeid=sys_acctypes.id left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid ";
$having="";
$groupby="";
$orderby="";
if(!empty($obj->categoryid))
  $where = " where fn_generaljournalaccounts.id='$obj->categoryid' ";
else
  $where = " where fn_generaljournalaccounts.id='$obj->accountid' ";
$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$generaljournalaccounts=$generaljournalaccounts->fetchObject;

$obj->shtransactionid=1;
$obj->shremarks=1;
$obj->shmemo=1;
$obj->shtransactdate=1;
$obj->shdebit=1;
$obj->shcredit=1;
$obj->shdocumentno=1;
$obj->shjvno=1;
$obj->shchequeno=1;
?>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
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
		if($obj->invno==1){ 
			$cols++;
		} 
		if($obj->shippingno==1){ 
			$cols++;
		} 
		if($obj->delno==1){ 
			$cols++;
		} 
		if($obj->pono==1){ 
			$cols++;
		} 
		if($obj->shjvno==1 ){ 
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
			$cols++;
			$cols++;
			$cols++;
		}
		if($obj->shdebit==1  or empty($obj->action)){
			$cols++;
		}
		if($obj->shcredit==1  or empty($obj->action)){
			$cols++;
		}
		if($obj->shchequeno==1 or empty($obj->action)){
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
			<th style="align:center;background-color: #dff0d8;border-color: #d6e9c6;color: #3c763d;text-align:center;" colspan="<?php echo $cols; ?>"><span style="font-weight: bold;"><?php echo strtoupper($generaljournalaccounts->name); ?></span></th>
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
			<?php if($obj->shdocumentno==1){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->invno==1){ ?>
				<th>Invoice No.</th>
			<?php } ?>
			<?php if($obj->shippingno==1){ ?>
				<th>Shipping No.</th>
			<?php } ?>
			<?php if($obj->delno==1){ ?>
				<th>Del No.</th>
			<?php } ?>
			<?php if($obj->pono==1){ ?>
				<th>PO No.</th>
			<?php } ?>
			<?php if($obj->shjvno==1){ ?>
				<th>Jv No. </th>
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
				<th>Currency </th>
				<th>Rate</th>
				<th>Eurorate</th>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<th>Debit </th>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<th>Credit </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 or empty($obj->action)){ ?>
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
		if($obj->accounttypeid==3 or $obj->accounttypeid==4 or $obj->accounttypeid==4){
		$generaljournals=new Generaljournals ();		
		if($obj->currencyid==5)
		{
		  $fields="fn_generaljournals.id,fn_generaljournals.jvno,fn_generaljournals.documentno, fn_generaljournals.daccountid, fn_generaljournals.rate, fn_generaljournals.eurorate, fn_generaljournals.tid, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.transactionid transaction,  fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit*fn_generaljournals.rate) debit, sum(fn_generaljournals.credit*fn_generaljournals.rate) credit, fn_generaljournals.debiteuro, fn_generaljournals.crediteuro, fn_generaljournals.debitorig, fn_generaljournals.creditorig, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		}
		elseif($obj->currencyid==1)
		{
		   $fields="fn_generaljournals.id,fn_generaljournals.jvno,fn_generaljournals.documentno, fn_generaljournals.daccountid, fn_generaljournals.rate, fn_generaljournals.eurorate, fn_generaljournals.tid, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.transactionid transaction,  fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit*fn_generaljournals.eurorate) debit, sum(fn_generaljournals.credit*fn_generaljournals.eurorate) credit, fn_generaljournals.debiteuro, fn_generaljournals.crediteuro, fn_generaljournals.debitorig, fn_generaljournals.creditorig, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		 } 
		 else
		{
		   $fields="fn_generaljournals.id,fn_generaljournals.jvno,fn_generaljournals.documentno, fn_generaljournals.daccountid, fn_generaljournals.rate, fn_generaljournals.eurorate, fn_generaljournals.tid, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.transactionid transaction,  fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit) debit, sum(fn_generaljournals.credit) credit, fn_generaljournals.debiteuro, fn_generaljournals.crediteuro, fn_generaljournals.debitorig, fn_generaljournals.creditorig, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		 } 
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
		$having="";
		
		if($obj->accounttypeid==1 and $obj->accounttypeid==2){
		  $where=" where transactdate>='$obj->fromtransactdate' and transactdate<='$obj->totransactdate' ";
		}else{
		  $where=" where transactdate<'$obj->fromtransactdate' ";
		}
		
		if(!empty($obj->categoryid))
		  $where.=" and (fn_generaljournals.accountid='$obj->categoryid' or fn_generaljournals.accountid in(select id from fn_generaljournalaccounts where categoryid='$obj->categoryid'))";
		else
		  $where.=" and (fn_generaljournals.accountid='$obj->accountid') ";
		
// 		$where= " where case when fn_generaljournals.transactdate >='$obj->fromtransactdate' and fn_generaljournals.transactdate<='$obj->totransactdate' and fn_generaljournals.transactdate!='0000-00-00' and fn_generaljournals.accountid='$obj->accountid' ";
		$groupby= "";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals->sql;
		$row=$generaljournals->fetchObject;
		}
		$acctypes = new Acctypes();
		$fields="*";
		$wheres=" where id='$generaljournalaccounts->acctypeid' ";
		$join="";
		$having="";
		$orderby="";
		$groupby ="";
		$acctypes->retrieve($fields, $join, $wheres, $having, $groupby, $orderby);
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
			<?php if($obj->shdaccountid==1){ ?>
				<td><?php echo $row->daccountid; ?></td>
			<?php } ?>
			<?php if($obj->shtid==1){ ?>
				<td><?php echo $row->tid; ?></td>
			<?php } ?>
			<?php if($obj->shdocumentno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->invno==1){ ?>
				<td><?php echo $data->invoiceno; ?></td>
			<?php } ?>
			<?php if($obj->shippingno==1){ ?>
				<td><?php echo $data->documentno; ?></td>
			<?php } ?>
			<?php if($obj->delno==1){ ?>
				<td><?php echo $data->packingno; ?></td>
			<?php } ?>
			<?php if($obj->pono==1){ ?>
				<td><?php echo $data->remarks; ?></td>
			<?php } ?>
			<?php if($obj->shjvno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<td><?php echo $row->mode; ?></td>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<td>Balance C/D</td>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action) ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<td><?php echo formatDate($row->fromtransactdate); ?></td>
				<td><?php echo $row->currencyid; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<td align="right">&nbsp;</td>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<td align="right">&nbsp;</td>
			<?php } ?>
			<?php if($obj->shchequeno==1 or empty($obj->action)){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdid==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shreconstatus==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shrecondate==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<td align="right" style="font-weight: bold; "><?php echo formatNumber($bal); ?></td>
		</tr>
		<?
		
		$i=0;
		$generaljournals=new Generaljournals();
		if($obj->currencyid==5)
		{
		$fields="fn_generaljournals.id,fn_generaljournals.jvno,fn_generaljournals.documentno, fn_generaljournals.accountid, fn_generaljournals.tid,fn_generaljournals.rate,fn_generaljournals.eurorate, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.transactionid transaction,  fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit*fn_generaljournals.rate) as debit, sum(fn_generaljournals.credit*fn_generaljournals.rate) as credit, fn_generaljournals.debiteuro, fn_generaljournals.crediteuro, fn_generaljournals.debitorig, fn_generaljournals.creditorig, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		}
		elseif($obj->currencyid==1)
		{
		$fields="fn_generaljournals.id,fn_generaljournals.jvno,fn_generaljournals.documentno, fn_generaljournals.accountid, fn_generaljournals.tid, fn_generaljournals.rate,fn_generaljournals.eurorate, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.transactionid transaction,  fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit*fn_generaljournals.eurorate) as debit, sum(fn_generaljournals.credit*fn_generaljournals.eurorate) as credit, fn_generaljournals.debiteuro, fn_generaljournals.crediteuro, fn_generaljournals.debitorig, fn_generaljournals.creditorig, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		}
		else
		{
		$fields="fn_generaljournals.id,fn_generaljournals.jvno,fn_generaljournals.documentno, fn_generaljournals.accountid, fn_generaljournals.tid, fn_generaljournals.rate,fn_generaljournals.eurorate, fn_generaljournals.documentno, sys_currencys.name currencyid, fn_generaljournals.mode, sys_transactions.name as transactionid, fn_generaljournals.transactionid transaction,  fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, sum(fn_generaljournals.debit) as debit, sum(fn_generaljournals.credit) as credit, fn_generaljournals.debiteuro, fn_generaljournals.crediteuro, fn_generaljournals.debitorig, fn_generaljournals.creditorig, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		}
		$join=" left join sys_transactions on sys_transactions.id=fn_generaljournals.transactionid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid ";
		$having="";
// 		$where= " where fn_generaljournals.transactdate >= '$obj->fromtransactdate' and fn_generaljournals.transactdate <= '$obj->totransactdate' and fn_generaljournals.accountid='$obj->accountid' and fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
		if($obj->accounttypeid==1 and $obj->accounttypeid==2){
		  $where=" where transactdate>='$obj->fromtransactdate' and transactdate<='$obj->totransactdate' ";
		}else{
		  $where=" where transactdate>='$obj->fromtransactdate' and transactdate<='$obj->totransactdate' ";
		}
		
		if(!empty($obj->categoryid))
		  $where.=" and (fn_generaljournals.accountid='$obj->categoryid' or fn_generaljournals.accountid in(select id from fn_generaljournalaccounts where categoryid='$obj->categoryid'))";
		else
		  $where.=" and (fn_generaljournals.accountid='$obj->accountid') ";
		  
		$groupby= " $rptgroup ";
		$orderby=" order by transactdate ";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $generaljournals->sql;
		$res=$generaljournals->result;	
		
		
		while($row=mysql_fetch_object($res)){
		$query="select * from pos_invoices where documentno='$row->documentno'";
		$data=mysql_fetch_object(mysql_query($query));
		$i++;
		$credit+=$row->credit;
		$debit+=$row->debit;		
		
		if (strtolower($acctypes->balance)=='dr'){
			$bal+=$row->debit-$row->credit;
		}
		else{
			$bal+=$row->credit-$row->debit;
		}
		
		$accs=mysql_fetch_object(mysql_query("select * from fn_generaljournalaccounts where id='$row->accountid'"));
		
		$row->accountid=$accs->name;
		
		$href="";
		if($row->transaction==32)
		  $href="../../../modules/inv/issuance/addissuance_proc.php?retrieve=1&documentno=".$row->documentno;
		else if($row->transaction==10)
		  $href="../../../modules/fn/exptransactions/addexptransactions_proc.php?retrieve=1&documentno=".$row->documentno;
		else if($row->transaction==20)
		  $href="../../../modules/pos/invoices/addinvoices_proc.php?retrieve=1&documentno=".$row->documentno;
		else if($row->transaction==24)
		  $href="../../../modules/pos/returninwards/addreturninwards_proc.php?retrieve=1&types=credit&documentno=".$row->documentno;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shaccountid==1){ ?>
				<td><a href="account.php?id=<?php echo $accs->id; ?>" target="_blank"><?php echo $row->accountid; ?></a></td>
			<?php } ?>
			<?php if($obj->shdaccountid==1){ ?>
				<td><?php echo $row->daccountid; ?></td>
			<?php } ?>
			<?php if($obj->shtid==1){ ?>
				<td><?php echo $row->tid; ?></td>
			<?php } ?>
			<?php if($obj->shdocumentno=1){ ?>
				<?php if(!empty($href)){?>
				<td><a target='_blank' href="<?php echo $href; ?>"><?php echo $row->documentno; ?></a></td>
				<?php }else{ ?>
				<td><?php echo $row->documentno; ?></td>
				<?php } ?>
			<?php } ?>
			<?php if($obj->invno==1){ ?>
				<td><?php echo $data->invoiceno; ?></td>
			<?php } ?>
			<?php if($obj->shippingno==1){ ?>
				<td><?php echo $data->documentno; ?></td>
			<?php } ?>
			<?php if($obj->delno==1){ ?>
				<td><?php echo $data->packingno; ?></td>
			<?php } ?>
			<?php if($obj->pono==1){ ?>
				<td><?php echo $data->remarks; ?></td>
			<?php } ?>
			<?php if($obj->shjvno=1){ ?>
				<td><a target="_blank" href="../../../modules/fn/generaljournals/addgeneraljournals_proc.php?retrieve=1&documentno=<?php echo $row->jvno; ?>"><?php echo $row->jvno; ?></a></td>
			<?php } ?>
			<?php if($obj->shmode==1){ ?>
				<td><?php echo $row->mode; ?></td>
			<?php } ?>
			<?php if($obj->shtransactionid==1   or empty($obj->action)){ ?>
				<td><?php echo $row->transactionid; ?></td>
			<?php } ?>
			<?php if($obj->shremarks==1   or empty($obj->action)){ ?>
				<td><?php echo $row->remarks; ?></td>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action)){ ?>
				<td><?php echo $row->memo; ?></td>
			<?php } ?>
			<?php if($obj->shtransactdate==1  or empty($obj->action)){ ?>
				<td><?php echo formatDate($row->transactdate); ?></td>
				<td><?php echo $row->currencyid; ?></td>
				<td><?php echo $row->rate; ?></td>
				<td><?php echo $row->eurorate; ?></td>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if(!empty($row->debit)){echo formatNumber($row->debit);} ?></td>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if(!empty($row->credit)){echo formatNumber($row->credit);} ?></td>
			<?php } ?>
			<?php if($obj->shchequeno==1 or empty($obj->action)){ ?>
				<td><?php echo $row->chequeno; ?></td>
			<?php } ?>
			<?php if($obj->shdid==1){ ?>
				<td><?php echo $row->did; ?></td>
			<?php } ?>
			<?php if($obj->shreconstatus==1){ ?>
				<td><?php echo $row->reconstatus; ?></td>
			<?php } ?>
			<?php if($obj->shrecondate==1){ ?>
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
			<td><?php echo $i+1; ?></td>
			<?php if($obj->shaccountid==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdaccountid==1 ){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shtid==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdocumentno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->invno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shippingno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->delno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->pono==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shjvno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shmode==1){ ?>
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
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if($credit>$debit){echo formatNumber($diff);}?> </td>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<td align="right"><?php if($debit>$credit){echo formatNumber($diff);}?> </td>
			<?php } ?>
			<?php if($obj->shchequeno==1 or empty($obj->action)){ ?>
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
			<?php if($obj->invno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shippingno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->delno==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->pono==1){ ?>
				<td>&nbsp;</td>
			<?php } ?>
			<?php if($obj->shjvno==1 ){ ?>
				<th>&nbsp;</th>
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
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdebit==1  or empty($obj->action)){ ?>
				<th><?php echo formatNumber($total);?> </th>
			<?php } ?>
			<?php if($obj->shcredit==1  or empty($obj->action)){ ?>
				<th><?php echo formatNumber($total);?> </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 or empty($obj->action)){ ?>
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
