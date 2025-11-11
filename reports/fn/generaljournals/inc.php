<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/fn/accounttypes/Accounttypes_class.php");
require_once("../../../modules/fn/subaccountypes/Subaccountypes_class.php");

$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];
$class=$_GET['class'];

$ob = (object)$_GET;

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Generaljournals";
//connect to db
$db=new DB();

$obj=(object)$_POST;

if(!empty($ob->grp)){
  $obj->grp=$ob->grp;
}

if(!empty($class))
  $obj->class=$class;
  
$rptwhere=" where fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
if(!empty($acctype)){
	$obj->acctype=$acctype;
	$rptwhere=' and fn_generaljournalaccounts.acctypeid='.$obj->acctype;
}
if(!empty($filter)){
	$obj->filter=$filter;
}
if(!empty($balance)){
	$obj->balance=$balance;
}
include "../../../head.php";

//processing filters


$track=1;

if(empty($obj->action)){
  $obj->todate=date("Y-m-d");
  $obj->currencyid=5;
}

if(!empty($obj->fromdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate>='$obj->fromdate'";
	$track++;
}

if(!empty($obj->todate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate<='$obj->todate'";
	$track++;
}
//Processing Groupings
$rptgroup=' group by id';
$track=0;
//Default shows
?>
<style media="all" type="text/css">
.total{
  font-weight: bold;
}
</style>
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

  $("#shippingname").autocomplete({
	source:"../../../modules/server/server/search.php?main=motor&module=shippings&field=concat(concat(concat(concat(name,' ',vessel),' ',voyageno),' ETD:',etd),' ETA:',eta)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#shippingid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 
 $(document).ready(function() {
	
				
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 800,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				if(aaData[1]!='&nbsp;' || aaData[2]!='&nbsp;' || aaData[3]!='&nbsp;'){
				  $('td:eq('+i+')', nRow).addClass("total");
				}else{
				  $('td:eq('+i+')', nRow).removeClass("total");
				}
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
<form action="tb.php" method="post">
<table>
  <tr>
    <td>From: <input type="text" size="10" name="fromdate" class="date_input" value="<?php echo $obj->fromdate; ?>"/> </td>
    <td>To: <input type="text" size="10" name="todate" class="date_input" value="<?php echo $obj->todate; ?>"/> </td>
    <td>Currency: <select name="currencyid" class="selectbox">
				
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby=" order by id desc ";
				$where=" where id in(1,5) ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select>&nbsp;
			      <input type="hidden" name="grp" value="<?php echo $obj->grp; ?>"/>
			      <input type="submit" name="action" class="btn" value="Filter"/> </td>
  </tr>
</table>
</form>

<div style="clear"></div>
<div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Account</th>
			<th>Debit </th>
			<th>Credit </th>	
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		//get account Types
		$accounttypes = new Accounttypes();
		$fields="*";
		$where="";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$accounttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$tdraccounttypes=0;
		$tcraccounttypes=0;
		while($accounttypess = mysql_fetch_object($accounttypes->result)){
		
		    ?>
		    <tr>
			    <td><?php echo $i; ?></td>
			    <td><?php echo $accounttypess->name; ?></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td align="right">&nbsp;</td>
			    <td align="right">&nbsp;</td>
		    </tr>
		    <?php
		    //get sub account types
		    $subaccountypes = new Subaccountypes();
		    $fields="*";
		    $where=" where fn_subaccountypes.accounttypeid='$accounttypess->id'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    $tdrsubaccountypes=0;
		    $tcrsubaccountypes=0;
		    while($subaccountypess = mysql_fetch_object($subaccountypes->result)){
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td>&nbsp;</td>
				<td><?php echo $subaccountypess->name; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>
			</tr>
			    <?php
			    //get account types
			    $acctypes = new Acctypes();
			    $fields="*";
			    $where=" where sys_acctypes.subaccountypeid='$subaccountypess->id'";
			    $join="";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    
			    while($acctypess = mysql_fetch_object($acctypes->result)){
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><?php echo $acctypess->name; ?></td>
					<td>&nbsp;</td>
					<td align="right">&nbsp;</td>
					<td align="right">&nbsp;</td>
				</tr>
				<?php
				$generaljournalaccounts=new Generaljournalaccounts ();
				$fields=" fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance ";
				$where=" where fn_generaljournalaccounts.acctypeid='$acctypess->id' ";
				if($obj->grp){
				  if(empty($where))
				    $where.=" where ";
				  else
				    $where.=" and ";
				  $where.=" (fn_generaljournalaccounts.categoryid is null or fn_generaljournalaccounts.categoryid=0) ";
				}
				
				$groupby="  ";
				$having="";
				$orderby=" order by sys_acctypes.name, fn_generaljournalaccounts.name ";
				$join=" left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
				$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				$res=$generaljournalaccounts->result;
				$tdebit=0;
				$tcredit=0;
				
				$tdracctypes=0;
				$tcracctypes=0;
				while($row=mysql_fetch_object($res)){
				$i++;
				
				if($obj->currencyid==5)	
				  $query="select sum(debit*rate) debit from fn_generaljournals where accountid in($row->id) $rptwhere";
				else
				  $query="select sum(debit*eurorate) debit from fn_generaljournals where accountid in($row->id) $rptwhere";
				$db=mysql_fetch_object(mysql_query($query));
				  
				if($obj->grp){
				  if($obj->currencyid==5)
				    $query="select sum(debit*rate) debit from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') $rptwhere";
				  else
				    $query="select sum(debit*eurorate) debit from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') $rptwhere";
				  $dbs=mysql_fetch_object(mysql_query($query));
				}
				  
				  $row->debit=$dbs->debit+$db->debit;
				
				if($obj->currencyid==5)
				  $query="select sum(credit*rate) credit from fn_generaljournals where accountid in($row->id)";
				else
				  $query="select sum(credit*eurorate) credit from fn_generaljournals where accountid in($row->id)";
				$db=mysql_fetch_object(mysql_query($query));
				if($obj->grp){
				  if($obj->currencyid==5)
				    $query="select sum(credit*rate) credit from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') $rptwhere";
				  else
				    $query="select sum(credit*eurorate) credit from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') $rptwhere";
				  $dbs=mysql_fetch_object(mysql_query($query));
				}
				  
				  $row->credit=$dbs->credit+$db->credit;

					
				  if (strtolower($row->balance)=='dr'){
					  $debit=$row->debit-$row->credit;
					  $credit=0;
				  }
				  else{
					  $credit=$row->credit-$row->debit;
					  $debit=0;
				  }
				
				$tdebit+=$debit;
				$tcredit+=$credit;
				
				$tdracctypes+=$debit;
				$tcracctypes+=$credit;
				
				if($debit<>0 or $credit<>0){
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><a href="account.php?id=<?php echo $row->id; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->name); ?></a></td>					
					<td align="right"><?php echo formatNumber($debit); ?></td>
					<td align="right"><?php echo formatNumber($credit); ?></td>
				</tr>
			<?php 
			}
			}
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Total <?php echo $acctypess->name; ?></td>
				<td>&nbsp;</td>
				<td align="right" style="text-decoration: overline;"><?php echo formatNumber($tdracctypes); ?></td>
				<td align="right" style="text-decoration: overline;"><?php echo formatNumber($tcracctypes); ?></td>
			</tr>
		    <?
		    $tdrsubaccountypes+=$tdracctypes;
		    $tcrsubaccountypes+=$tcracctypes;
		    }
		    
		    ?>
		    <tr>
				<td><?php echo $i; ?></td>
				<td>&nbsp;</td>
				<td>Total <?php echo $subaccountypess->name; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" style="text-decoration: overline;"><?php echo formatNumber($tdrsubaccountypes); ?></td>
				<td align="right" style="text-decoration: overline;"><?php echo formatNumber($tcrsubaccountypes); ?></td>
			</tr>
		    <?
		    $tdraccounttypes+=$tdrsubaccountypes;
		    $tcraccounttypes+=$tcrsubaccountypes;
	      }
	      ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td>Total <?php echo $accounttypess->name; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right" style="text-decoration: overline underline;"><?php echo formatNumber($tdraccounttypes); ?></td>
			<td align="right" style="text-decoration: overline underline;"><?php echo formatNumber($tcraccounttypes); ?></td>
		</tr>
		    <?
	  }
	?>
	</tbody>
	<tfoot>
	<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th align="right" style="text-decoration: overline underline;"><?php echo formatNumber($tdebit); ?></th>
		<th align="right" style="text-decoration: overline underline;"><?php echo formatNumber($tcredit); ?></th>	
	</tr>
	</tfoot>

</table>
</div>
<!--/div>
</div-->

<!--</div>
</div>
</div>
</div>
</div>-->
