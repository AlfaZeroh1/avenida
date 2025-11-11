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
require_once("../../../modules/auth/rules/Rules_class.php");


$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];
$class=$_GET['class'];

$ob = (object)$_GET;

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


if(empty($obj->action))
{
	$obj->fromdate=$_SESSION['startdate'];
	$obj->todate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
	$obj->currencyid=5;
} 

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

$generaljournals = new Generaljournals();
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

});
</script>
<script type="text/javascript" charset="utf-8">
 
 $(document).ready(function() {
	
				
 	$('#tbl').dataTable( {
		"scrollX": true,
	      dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],
		"aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 800,
 		"iDisplayLength":2000,
		"bJQueryUI": true,
		"bRetrieve":true,
// 		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
// 			
// 			$('td:eq(0)', nRow).html(iDisplayIndex+1);
// 			var num = aaData.length;
// 			for(var i=1; i<num; i++){
// 				if(aaData[1]!='&nbsp;' || aaData[2]!='&nbsp;' || aaData[3]!='&nbsp;'){
// 				  $('td:eq('+i+')', nRow).addClass("total");
// 				}else{
// 				  $('td:eq('+i+')', nRow).removeClass("total");
// 				}
// 			}
// 			return nRow;
// 		},
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
<table class="table">
  <tr>
    <td>From:</td>
    <td><input type="text" size="10" name="fromdate" class="date_input" value="<?php echo $obj->fromdate; ?>"/> </td>
    <td>To:</td>
    <td><input type="text" size="10" name="todate" class="date_input" value="<?php echo $obj->todate; ?>"/> </td>
    <td>Currency: </td>
    <td><select name="currencyid" class="selectbox">
				
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
			      </select></td>
    <td><input type="hidden" name="grp" value="<?php echo $obj->grp; ?>"/>
			      <input type="submit" name="action" class="btn" value="Filter"/> </td>
  </tr>
</table>
</form>

<div style="clear"></div>
<div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
<!-- 			<th>#</th> -->
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>Debit </th>
			<th>Credit </th>	
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		//get account Types
		$generaljournals = new Generaljournals();
		$fields=" fn_generaljournalaccounts.id, sys_acctypes.name acctypename, fn_generaljournalaccounts.acctypeid, (case when lower(sys_acctypes.balance)='dr' then (sum(fn_generaljournals.debit*fn_generaljournals.rate) -sum(fn_generaljournals.credit*fn_generaljournals.rate)) else 0 end) debit, (case when lower(sys_acctypes.balance)='cr' then (sum(fn_generaljournals.credit*fn_generaljournals.rate) -sum(fn_generaljournals.debit*fn_generaljournals.rate)) else 0 end)  credit, fn_generaljournalaccounts.name";
		$where=" where fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate'  ";
		$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
		$having="";
		$groupby=" group by fn_generaljournalaccounts.id ";
		$orderby=" order by sys_acctypes.id ";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$tdebit=0;
		$tcredit=0;
		while($row = mysql_fetch_object($generaljournals->result)){
		    		    
		    $tdebit+=$row->debit;
		    $tcredit+=$row->credit;
		    ?>
		    <tr>
<!-- 			    <td><?php echo $i; ?></td> -->
			    <td><?php echo $row->acctypename; ?></td>
			    <td><a href="account.php?id=<?php echo $row->id; ?>" target="_blank"><?php echo $row->name; ?></a></td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td align="right"><?php echo formatNumber($row->debit); ?></td>
			    <td align="right"><?php echo formatNumber($row->credit); ?></td>
		    </tr>
		    <?php
		    }
		    ?>
	</tbody>
	<tfoot>
	<tr>
<!-- 		<th>&nbsp;</th> -->
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
