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
require_once("../../../modules/auth/rules/Rules_class.php");

$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];

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

if(empty($obj->action)){
  $obj->currencyid=5;
}

$rptwhere='';
//$where=" where fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
if(!empty($acctype) or !empty($obj->acctype)){
  if(!empty($acctype)){
	$obj->acctype=$acctype;
	}
	$rptwhere='  fn_generaljournalaccounts.acctypeid='.$obj->acctype;
	if($obj->acctype==29){
	  $rptwhere.=" and fn_generaljournalaccounts.refid in(select id from crm_customers) ";
	}elseif($obj->acctype==30){
	  $rptwhere.=" and fn_generaljournalaccounts.refid in(select id from proc_suppliers) ";
	}
}
if(!empty($filter)){
	$obj->filter=$filter;
}
if(!empty($balance)){
	$obj->balance=$balance;
}
include "../../../head.php";

//processing filters
if(empty($obj->action)){
  //$obj->fromtransactdate=date('Y-m-d',mktime(0,0,0,date("m")-5,date("d"),date("Y")));
  $obj->fromtransactdate=$_SESSION['startdate'];
  $obj->totransactdate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}

$track=1;
if(!empty($obj->accountid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.accountid='$obj->accountid'";
	$track++;
}

if(!empty($obj->transactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate='$obj->transactdate'";
	$track++;
}
if(!empty($obj->shippingid)){
	if($track>0)
		$rptwhere.=" and";
	else
		$rptwhere.=" where";

	$rptwhere.=" motor_vehicles.shippingid='$obj->shippingid'";
	$jn=" left join motor_vehicles on motor_vehicles.id=fn_generaljournals.tid ";
	$track++;
}



//Processing Groupings
$rptgroup=' group by id';
$track=0;
//Default shows
?>
<style media="all" type="text/css">
.red {
/* background-color:#e36f6f !important; */
text-color:red;
color:red !important;
}
.bold {
/* background-color:#88b645 !important; */
color:black !important;
text-style:bold;
/* background-color:#e36f6f !important; */
}
.gray {
/* background-color:#88b645 !important; */
color:black !important;
text-style:bold;
background-color:gray !important;
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
<?php  
if(empty($obj->currencyid)){
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then ((case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)-(case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)) when lower(sys_acctypes.balance)='cr' then ((case when sum(fn_generaljournals.credit) is null then 0 else sum(fn_generaljournals.credit) end)-(case when sum(fn_generaljournals.debit) is null then 0 else sum(fn_generaljournals.debit) end)) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
}elseif($obj->currencyid==1){
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then ((case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end) - (case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end)) when lower(sys_acctypes.balance)='cr' then ((case when sum(fn_generaljournals.credit*eurorate) is null then 0 else sum(fn_generaljournals.credit*eurorate) end) - (case when sum(fn_generaljournals.debit*eurorate) is null then 0 else sum(fn_generaljournals.debit*eurorate) end)) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
}elseif($obj->currencyid==5){
$sql4 = "sum(case when lower(sys_acctypes.balance)='dr' and fn_generaljournals.transactdate<='$obj->totransactdate' then ((case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end)-(case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)) when lower(sys_acctypes.balance)='cr' and fn_generaljournals.transactdate<='$obj->totransactdate' then ((case when (fn_generaljournals.credit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.credit*fn_generaljournals.rate) end)-(case when (fn_generaljournals.debit*fn_generaljournals.rate) is null then 0 else (fn_generaljournals.debit*fn_generaljournals.rate) end)) else 0 end) ";
}

if($obj->show=="All" or $_GET['tb']==false)
	$join=" right outer join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid  ".$jn;
else 
	$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid  ".$jn;
?>
 <?php $_SESSION['aColumns']=array('fn_generaljournalaccounts.id as id', 'upper(fn_generaljournalaccounts.name) as accountid', '('.$sql4.') balance');?>
 <?php $_SESSION['sColumns']=array('id', 'accountid','balance' );?>
 <?php $_SESSION['join']=$join;?>
 <?php $_SESSION['sTable']="fn_generaljournals";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']=$rptwhere;?>
 <?php $_SESSION['sGroup']=$rptgroup;?>
 
 $(document).ready(function() {
// 	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_generaljournals",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			console.log(aaData);
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html('<a href="account.php?id='+aaData[0]+'" target="_blank">'+aaData[1]+'</a>');	
			$('td:eq(2)', nRow).html('<strong>'+(aaData[2])+'</strong>').formatCurrency().attr('align','left').addClass("bold");
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			/*
			 * Calculate the total market share for all browsers in this table (ie inc. outside
			 * the pagination)
			 */
			 //try{alert(aaData[2][2]);}catch(e){alert(e);}
			var tbalance = 0;

			for ( var i=0 ; i<aaData.length ; i++ )
			{	
				tbalance+=(aaData[i][2]*1);
			}
						
			/* Modify the footer row to match what we want */
			$('th:eq(2)', nRow).html(tbalance).formatCurrency().attr('align','left');
		}
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
<form action="generaljournalss2.php" method="post">
<table>
  <tr>
    <td>From: <input type="text" size="12" class="date_input" name="fromtransactdate" value="<?php echo $obj->fromtransactdate; ?>"/></td>
   <td>To: <input type="text" size="12" class="date_input" name="totransactdate" value="<?php echo $obj->totransactdate; ?>"/></td>&nbsp;
    <td>Currency: <select name="currencyid" class="selectbox">
				<option value="">Select...</option>  
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
			      <input type="hidden" name="acctype" value="<?php echo $obj->acctype; ?>"/>
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
			<th>Account</th>
			<th>Balance</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	<tfoot>
	    <tr>
			<th>&nbsp;</th>
			<th>Total</th>
			<th>&nbsp;</th>
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
