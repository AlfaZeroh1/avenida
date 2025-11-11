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
$class=$_GET['class'];

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



if(empty($obj->action)){
  $obj->currencyid=5;
}

if(!empty($class))
  $obj->class=$class;
  
if(!empty($ob->tb))
  $obj->tb=$ob->tb;
  
if(!empty($ob->grp))
  $obj->grp=$ob->grp;
  
if(!empty($ob->accounttypeid))
  $obj->accounttypeid=$ob->accounttypeid;
  
if(!empty($ob->categoryid))
  $obj->categoryid=$ob->categoryid;
  
if(!empty($ob->acctypeid))
  $obj->acctypeid=$ob->acctypeid;
  
//$rptwhere=" where fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
if(!empty($acctype) or !empty($obj->acctype)){
  if(!empty($acctype)){
	$obj->acctype=$acctype;
	}
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
if(empty($obj->action)){
  $obj->todate=date('Y-m-d');
  $obj->fromdate=$_SESSION['startdate'];
}

if($obj->fromdate<$_SESSION['startdate']){
  $obj->fromdate=$_SESSION['startdate'];
}


// if(!empty($obj->fromtransactdate)){
// 	if($track>0)
// 		$rptwhere.="and";
// 	else
// 		$rptwhere.="where";
// 
// 		$rptwhere.=" fn_generaljournals.transactdate>='$obj->fromtransactdate'";
// 	$track++;
// }

if(!empty($obj->totransactdate)){
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
<?php if($obj->filter){?>
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;"></a></div>
<?php }?>
<form  action="generaljournals.php" class="forms" method="post" name="generaljournals">
<table>
From: <input type="text" size="12" class="date_input" name="fromdate" value="<?php echo $obj->fromdate; ?>"/></td>
<td>To: <input type="text" size="12" class="date_input" name="todate" value="<?php echo $obj->todate; ?>"/>&nbsp;
 Currency: <select name="currencyid" class="selectbox">
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
			      </select>&nbsp;<input type="hidden" name="acctype" value="<?php echo $obj->acctype; ?>"/>
			      <input type="hidden" name="grp" value="<?php echo $obj->grp; ?>"/>
			      <input type="hidden" name="tb" value="<?php echo $obj->tb; ?>"/>
			      <input type="hidden" name="categoryid" value="<?php echo $obj->categoryid; ?>"/>
			      <input type="hidden" name="accounttypeid" value="<?php echo $obj->accounttypeid; ?>"/>
			      <input type="hidden" name="acctypeid" value="<?php echo $obj->acctypeid; ?>"/>
<input type="submit" name="action" value="Filter"/>
</td>
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
			<th>Account </th>
			<th>Debit </th>
			<th>Credit </th>	
		</tr>
	</thead>
	<tbody>
	<?php
	
		$where="";
		if($obj->accounttypeid==1 and $obj->accounttypeid==2){
		  $where=" where transactdate>='$obj->fromdate' and transactdate<='$obj->todate' ";
		}else{
		  $where=" where transactdate<='$obj->todate' ";
		}
	
		$query = "select * from fn_generaljournalaccounts where categoryid='$obj->categoryid'";
		$res = mysql_query($query);
		$i=0;
		
		$tdebit=0;
		$tcredit=0;
		$tdebitorig=0;
		$tcreditorig=0;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		  $query = "select fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sum(debit*(case when '$obj->currencyid=5' then fn_generaljournals.rate when '$obj->currencyid=1' then fn_generaljournals.eurorate else 1 end)) debit, sum(credit*(case when '$obj->currencyid=5' then fn_generaljournals.rate when '$obj->currencyid=1' then fn_generaljournals.eurorate else 1 end)) credit from fn_generaljournalaccounts left join fn_generaljournals on fn_generaljournalaccounts.id=fn_generaljournals.accountid $where and fn_generaljournalaccounts.id='$row->id' group by fn_generaljournalaccounts.id";		
		  $db=mysql_fetch_object(mysql_query($query));
		  
		  $row->debit=$row->debit+$db->debit;
		  $row->credit=$row->credit+$db->credit;

		  $query="select sum(debit*(case when '$obj->currencyid=5' then fn_generaljournals.rate when '$obj->currencyid=1' then fn_generaljournals.eurorate else 1 end)) debit, sum(debitorig) debitorig from fn_generaljournals $where and accountid in(select id from fn_generaljournalaccounts where categoryid in($row->id)) ";
		  $db=mysql_fetch_object(mysql_query($query));
		  
		  $row->debit=$row->debit+$db->debit;
		  $row->debitorig=$row->debitorig+$db->debitorig;
		  
		  $query="select sum(credit*(case when '$obj->currencyid=5' then fn_generaljournals.rate when '$obj->currencyid=1' then fn_generaljournals.eurorate else 1 end)) credit, sum(creditorig) creditorig from fn_generaljournals $where and accountid in(select id from fn_generaljournalaccounts where categoryid in($row->id)) ";
		  $db=mysql_fetch_object(mysql_query($query));
		  
		  $row->credit=$row->credit+$db->credit;
		  $row->creditorig=$row->creditorig+$db->creditorig;
		
		if($obj->tb){
			
			if (strtolower($acctypes->balance)=='dr'){
				
				$debit=$row->debit-$row->credit;
				$debitorig=$row->debitorig-$row->creditorig;
				$credit=0;
				$creditorig=0;
				
				if($debit<0){
				  $credit=$debit*-1;
				  $debit=0;
				}
			}
			else{
				$credit=$row->credit-$row->debit;
				$creditorig=$row->creditorig-$row->debitorig;
				$debit=0;
				$debitorig=0;
				
				if($credit<0){
				  $debit=$credit*-1;
				  $credit=0;
				}
			}
		}
		elseif($obj->balance){
			
			if (strtolower($acctypes->balance)=='dr'){
				$balance=$row->debit-$row->credit;
				$balanceorig=$row->debitorig-$row->creditorig;
			}
			else{
				$balance=$row->credit-$row->debit;
				$balanceorig=$row->creditorig-$row->debitorig;
			}
		}
		else{
			$debit=$row->debit;
			$credit=$row->credit;
			$debitorig=$row->debitorig;
			$creditorig=$row->creditorig;
		}
		$tdebit+=$debit;
		$tcredit+=$credit;
		$tdebitorig+=$debitorig;
		$tcreditorig+=$creditorig;
		
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php
			$query="select * from fn_generaljournalaccounts where categoryid='$row->id'";
			mysql_query($query);
			if(mysql_affected_rows()>0){
			?>
			<td><a href="generaljournalscategory.php?categoryid=<?php echo $row->id; ?>&accounttypeid=<?php echo $obj->accounttypeid; ?>&grp=1&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->name); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="account.php?id=<?php echo $row->id; ?>&accounttypeid=<?php echo $obj->accounttypeid; ?>&class=<?php echo $obj->class; ?>" target="_blank"><img src="p.jpeg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="account.php?categoryid=<?php echo $row->id; ?>&accounttypeid=<?php echo $obj->accounttypeid; ?>&class=<?php echo $obj->class; ?>" target="_blank"><img src="pk1.jpeg"></a>
			</td>
			<?php
			}else{
			?>
			<td><a href="account.php?id=<?php echo $row->id; ?>&accounttypeid=<?php echo $obj->accounttypeid; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->name); ?></a></td>
			<?php
			}
			?>
			<td align="right"><?php echo formatNumber($debit); ?></td>
			<td align="right"><?php echo formatNumber($credit); ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th align="right"><?php echo formatNumber($tdebit); ?></th>
		<th align="right"><?php echo formatNumber($tcredit); ?></th>	
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
