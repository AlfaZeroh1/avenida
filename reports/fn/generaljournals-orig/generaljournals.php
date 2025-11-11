<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/generaljournals/Generaljournals_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/sys/acctypes/Acctypes_class.php");

$acctype=$_GET['acctype'];
$filter=$_GET['filter'];
$balance = $_GET['balance'];
$class=$_GET['class'];

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Generaljournals";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="760";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);


if(!empty($class))
  $obj->class=$class;
  
$rptwhere='';
if(!empty($acctype)){
	$obj->acctype=$acctype;
	$rptwhere=' where fn_generaljournalaccounts.acctypeid='.$obj->acctype;
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

if(!empty($obj->transactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate>='$obj->fromtransactdate'";
	$track++;
}

if(!empty($obj->transactdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" fn_generaljournals.transactdate<='$obj->totransactdate'";
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
				<input type="text" name="class" value="<?php echo $obj->class; ?>"/>
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
<table style="clear:both;"  class="tgrid display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account </th>
			<?php if($obj->balance){?>
			<th>Balance </th>
			<?php }else{?>
			<th>Account Type</th>
			<th>Debit </th>
			<th>Credit </th>	
			<?php }?>		
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$generaljournals=new Generaljournals ();
		$fields="fn_generaljournalaccounts.id as id, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.name as accountid, sum(fn_generaljournals.debit) debit, sum(fn_generaljournals.credit) credit";
		if($obj->show=="All" or $_GET['tb']== false)
			$join=" right outer join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id ".$jn;
		else 
			$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id ".$jn;
			
			
		$having="";
		$where= " where 1=1 ";
		if(!empty($_GET['acctypeid']))
			$where.=" and fn_generaljournalaccounts.acctypeid='".$_GET['acctypeid']."'";
		
		if(!empty($_GET['grp']))
			$groupby= " group by fn_generaljournalaccounts.acctypeid ";
		else
			$groupby= " group by fn_generaljournalaccounts.id ";
	
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$generaljournals->result;
		$tdebit=0;
		$tcredit=0;
		while($row=mysql_fetch_object($res)){
		$i++;
		//check what kind of a balance an account should have for trial balance
		$acctypes = new Acctypes();
		$fields="*";
		$where=" where id='$row->acctypeid' ";
		$join="";
		$having="";
		$orderby="";
		$groupby ="";
		$acctypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$acctypes=$acctypes->fetchObject;
		if($_GET['tb']){
			
			if (strtolower($acctypes->balance)=='dr'){
				$debit=$row->debit-$row->credit;
				$credit=0;
			}
			else{
				$credit=$row->credit-$row->debit;
				$debit=0;
			}
		}
		elseif($obj->balance){
			
			if (strtolower($acctypes->balance)=='dr'){
				$balance=$row->debit-$row->credit;
			}
			else{
				$balance=$row->credit-$row->debit;
			}
		}
		else{
			$debit=$row->debit;
			$credit=$row->credit;
		}
		$tdebit+=$debit;
		$tcredit+=$credit;
		
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if(!empty($_GET['grp'])){?>
			<td><a href="generaljournals.php?acctypeid=<?php echo $row->acctypeid; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($acctypes->name); ?></a></td>
			<?php }else{?>
			<td><a href="account.php?id=<?php echo $row->id; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->accountid); ?></a></td>
			<?php }?>
			<?php if($obj->balance){?>
			<td align="right"><?php echo formatNumber($balance); ?></td>
			<?php }else{?>
			<td><?php echo $acctypes->name; ?></td>
			<td align="right"><?php echo formatNumber($debit); ?></td>
			<td align="right"><?php echo formatNumber($credit); ?></td>		
			<?php }?>	
		</tr>
	<?php 
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th></th>
		<th></th>
		<?php if($obj->balance){?>
		<th></th>
		<?php }else{?>
		<th></th>
		<th align="right"><?php echo formatNumber($tdebit); ?></th>
		<th align="right"><?php echo formatNumber($tcredit); ?></th>	
		<?php }?>	
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
