<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");

$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Generaljournals";
//connect to db   
$db=new DB();

$obj=(object)$_POST;
$rptwhere='';
if(!empty($acctype)){
	$obj->acctype=$acctype;
	$rptwhere='  fn_generaljournalaccounts.acctypeid='.$obj->acctype;
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

$first=date('Y-m-d',mktime(0,0,0,date("m"),date("d")-30,date("Y")));
$second=date('Y-m-d',mktime(0,0,0,date("m"),date("d")-60,date("Y")));

$sql1 = "select case when lower(sys_acctypes.balance)='dr' then sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit) when lower(sys_acctypes.balance)='cr' then sum(fn_generaljournals.credit)-sum(fn_generaljournals.debit) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate<='$first' "; 
$sql2 = "select case when lower(sys_acctypes.balance)='dr' then sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit) when lower(sys_acctypes.balance)='cr' then sum(fn_generaljournals.credit)-sum(fn_generaljournals.debit) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$first' and fn_generaljournals.transactdate<='$second' ";
$sql3 = "select case when lower(sys_acctypes.balance)='dr' then sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit) when lower(sys_acctypes.balance)='cr' then sum(fn_generaljournals.credit)-sum(fn_generaljournals.debit) end from fn_generaljournals  where fn_generaljournalaccounts.id=fn_generaljournals.accountid and fn_generaljournals.transactdate>'$second' ";
$sql4 = "select case when lower(sys_acctypes.balance)='dr' then sum(fn_generaljournals.debit)-sum(fn_generaljournals.credit) when lower(sys_acctypes.balance)='cr' then sum(fn_generaljournals.credit)-sum(fn_generaljournals.debit) end from fn_generaljournals where fn_generaljournalaccounts.id=fn_generaljournals.accountid ";


if($obj->show=="All" or $_GET['tb']==false)
	$join=" right outer join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ".$jn;
else 
	$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid".$jn;
?>
 <?php $_SESSION['aColumns']=array('fn_generaljournalaccounts.id as id', 'fn_generaljournalaccounts.name as accountid', '('.$sql1.') first', '('.$sql2.') second','('.$sql3.') third','('.$sql4.') balance');?>
 <?php $_SESSION['sColumns']=array('id', 'accountid', 'first', 'second','third','balance');?>
 <?php $_SESSION['join']=$join;?>
 <?php $_SESSION['sTable']="fn_generaljournals";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']=$rptwhere;?>
 <?php $_SESSION['sGroup']=$rptgroup;?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_generaljournals",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			$('td:eq(1)', nRow).html('<a href="account.php?id='+aaData[0]+'" target="_blank">'+aaData[1]+'</a>');
			
			if((aaData[2]*1)<0)
			{
				aaData[3]=(aaData[3]*1)+(aaData[2]*1);
				aaData[2]=0;
			}
			if((aaData[3]*1)<0)
			{
				aaData[4]=(aaData[4]*1)+(aaData[3]*1);
				aaData[3]=0;
			}
			if(aaData[4]=='' || aaData[4]=='-0')
				aaData[4]=0;
			if(aaData[3]=='' || aaData[3]=='-0')
				aaData[3]=0;
			if(aaData[2]=='' || aaData[2]=='-0')
				aaData[2]=0;
			
			$('td:eq(2)', nRow).html(aaData[2]).formatCurrency().attr('align','right');
			$('td:eq(3)', nRow).html(aaData[3]).formatCurrency().attr('align','right');
			$('td:eq(4)', nRow).html(aaData[4]).formatCurrency().attr('align','right');
			$('td:eq(5)', nRow).html('<strong>'+(aaData[5])+'</strong>').formatCurrency().attr('align','right');
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			/*
			 * Calculate the total market share for all browsers in this table (ie inc. outside
			 * the pagination)
			 */
			 //try{alert(aaData[2][2]);}catch(e){alert(e);}
			var tfirst = 0;
			var tsecond = 0;
			var tthird = 0;

			for ( var i=0 ; i<aaData.length ; i++ )
			{				
				tfirst+=(aaData[i][4]*1);
				tsecond+=(aaData[i][3]*1);
				tthird+=(aaData[i][2]*1);
			}
						
			/* Modify the footer row to match what we want */
			$('th:eq(2)', nRow).html(tthird).formatCurrency().attr('align','right');
			$('th:eq(3)', nRow).html(tsecond).formatCurrency().attr('align','right');
			$('th:eq(4)', nRow).html(tfirst).formatCurrency().attr('align','right');
			$('th:eq(5)', nRow).html(tfirst+tsecond+tthird).formatCurrency().attr('align','right');
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
<?php if($obj->filter){?>
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;">Open Popup To Filter</a></div>
<?php }?>
<!--<div id="boxB" class="sh" style="left: 10px; top: 63px; display: none; z-index: 500;">
<div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
<a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>-->
<button id="create-user">Filter</button>
<div id="toPopup" > 
    	
        <div class="close"></div>
       	<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span>
        
<div id="dialog-modal" title="Filter" style="font:tahoma;font-size:10px;">
        


<form  action="generaljournals.php" class="forms" method="post" name="generaljournals">
<table border="0" width="100%">
	<tr>
		<td rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td><input type="hidden" name="acctype" value="<?php echo $obj->acctype; ?>"/>
				<input type="hidden" name="filter" value="<?php echo $obj->filter; ?>"/>
				<input type="hidden" name="balance" value="<?php echo $obj->balance; ?>"/>Account</td>
				<td><input type='text' size='20' name='accountname' id='accountname' value='<?php echo $obj->accountname; ?>'>
					<input type="hidden" name='accountid' id='accountid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Shipping Line</td>
				<td><input type='text' size='12' name='shippingname' id='shippingname' value='<?php echo $obj->shippingname; ?>'>
					<input type="hidden" name='shippingid' id='shippingid' value='<?php echo $obj->field; ?>'></td>
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
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shaccountid' value='1' <?php if(isset($_POST['shaccountid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Account</td>
				<td><input type='checkbox' name='shtransactdate' value='1' <?php if(isset($_POST['shtransactdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Date</td>
			<tr>
				<td><input type='checkbox' name='shdebit' value='1' <?php if(isset($_POST['shdebit'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Balance</td>
				<td><input type='checkbox' name='shcredit' value='1' <?php if(isset($_POST['shcredit'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input class="btn"  type="submit" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
<div style="clear"></div>
<div>

<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th width='45%'>Account </th>
			<th>60 Days and Above</th>
			<th>30 - 60 Days</th>
			<th>30 Days</th>
			<th>Balance </th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	<tfoot>
	<tr>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp; </th>
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
