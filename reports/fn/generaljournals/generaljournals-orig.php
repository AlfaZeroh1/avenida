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

if(!empty($class))
  $obj->class=$class;
  
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
<script type="text/javascript">
function Clickheretoprint(id,dat,dat2)
{ 
	var msg;alert(id);
	msg="Do you want to print the statement?";
	var ans=confirm(msg);
	if(ans)
	{
		poptastic("printparent.php?accountid="+id+"&fromtransactdate="+dat+"&totransactdate="+dat2+"&currencyid=<?php echo $obj->currencyid; ?>",450,940);
	}
}
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
<input type="submit" name="action" value="Filter"/>
</td>
</tr>
</table>
</div>
</div>
<div style="clear"></div>
<div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account </th>
			<?php if(empty($_GET['grp'])){
			if(!$_GET['tb']){ ?>
			<th>Currency</th>
			<?php }}if($obj->balance){?>
			<th>Balance </th>
			<?php }else{?>
			<th>Account Type</th>	
<!-- 			<th>Orig Debit </th> -->
<!-- 			<th>Orig Credit </th> -->
			<th>Debit </th>
			<th>Credit</th>			
			<?php }?>
			<td>&nbsp;</td>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$generaljournals=new Generaljournals ();
		if($obj->currencyid==5){
		$fields="fn_generaljournalaccounts.id as id, sys_currencys.name currencyid, fn_accounttypes.name accounttypename, fn_accounttypes.id accounttypeid, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.name as accountid,fn_generaljournalaccounts.categoryid, sum(fn_generaljournals.debit*rate) debit, sum(fn_generaljournals.credit*rate) credit, sum(fn_generaljournals.debitorig*rate) debitorig, sum(fn_generaljournals.creditorig*rate) creditorig";
		}elseif($obj->currencyid==1){
		$fields="fn_generaljournalaccounts.id as id, sys_currencys.name currencyid, fn_accounttypes.name accounttypename, fn_accounttypes.id accounttypeid, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.name as accountid,fn_generaljournalaccounts.categoryid, sum(fn_generaljournals.debit*eurorate) debit, sum(fn_generaljournals.credit*eurorate) credit, sum(fn_generaljournals.debitorig*eurorate) debitorig, sum(fn_generaljournals.creditorig*eurorate) creditorig";
		}else{
		$fields="fn_generaljournalaccounts.id as id, sys_currencys.name currencyid, fn_accounttypes.name accounttypename, fn_accounttypes.id accounttypeid, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.name as accountid,fn_generaljournalaccounts.categoryid, sum(fn_generaljournals.debit) debit, sum(fn_generaljournals.credit) credit, sum(fn_generaljournals.debitorig) debitorig, sum(fn_generaljournals.creditorig) creditorig";
		}
		
		if($obj->show=="All" or $_GET['tb']== false)
			$join=" right outer join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id ".$jn;
		else 
			$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id ".$jn;
		
		$join.=" left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join fn_accounttypes on fn_accounttypes.id=sys_acctypes.accounttypeid left join sys_currencys on sys_currencys.id=fn_generaljournalaccounts.currencyid left join fn_subaccountypes on fn_subaccountypes.id=sys_acctypes.subaccountypeid ";
			
		$orderby="";	
		$having="";
		$where=" where case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00' ";
		
		//$where=" where  fn_generaljournals.transactdate>='2015-07-01'  ";
		if($_SESSION['SEPARATE_FINANCES']=="true")
		  $where= " where fn_generaljournals.class='$obj->class' ";
		  
		if(!empty($_GET['accounttypeid'])){
			if(empty($where))
			  $where.=" where ";
			else
			  $where.=" and ";
			  
			$where.=" sys_acctypes.accounttypeid='".$_GET['accounttypeid']."'";
			$orderby=" order by fn_accounttypes.name ";
		}
		
		if(!empty($_GET['categoryid'])){
			if(empty($where))
			  $where.=" where ";
			else
			  $where.=" and ";
			  
			$where.=" fn_generaljournalaccounts.categoryid='".$_GET['categoryid']."' ";
			$orderby=" order by fn_generaljournalaccounts.name ";
		}
		  
		if(!empty($_GET['acctypeid']) and !empty($_GET['grp'])){
			if(empty($where))
			  $where.=" where ";
			else
			  $where.=" and ";
			  
			$where.=" fn_generaljournalaccounts.acctypeid='".$_GET['acctypeid']."' ";
			
// 			if(empty($where))
// 			  $where.=" where ";
// 			else
// 			  $where.=" and ";
// 			  
// 			$where.=" (fn_generaljournalaccounts.categoryid='' or fn_generaljournalaccounts.categoryid is null) ";
                        $groupby=" group by fn_generaljournalaccounts.id ";
			$orderby=" order by trim(sys_acctypes.name) ";
		}
		
		if(!empty($_GET['acctypeid'])){
			if(empty($where))
			  $where.=" where ";
			else
			  $where.=" and ";
			  
			$where.=" fn_generaljournalaccounts.acctypeid='".$_GET['acctypeid']."' ";
			
			if(empty($where))
			  $where.=" where ";
			else
			  $where.=" and ";
			  
			$where.=" (fn_generaljournalaccounts.categoryid='' or fn_generaljournalaccounts.categoryid is null) ";
			$orderby=" order by trim(sys_acctypes.name) ";
		}
		
		if(!empty($_GET['grp'])){
			if(!empty($_GET['accounttypeid'])){
			  $groupby= " group by fn_generaljournalaccounts.acctypeid ";
			  $orderby=" order by sys_acctypes.name ";
			}elseif(!empty($_GET['acctypeid'])){
			 $groupby=" group by fn_generaljournalaccounts.id ";			  
			}
			else{
			$groupby= " group by sys_acctypes.accounttypeid ";
			}
			
		}
		else if($_GET['tb']){
// 		  if(empty($where))
// 			  $where.=" where ";
// 			else
// 			  $where.=" and ";
// 			  
// 			$where.=" fn_generaljournalaccounts.acctypeid not in(29,30)";
// 			
			$groupby= " group by fn_generaljournalaccounts.id ";
		}
		else
			$groupby= " group by fn_generaljournalaccounts.id ";
	
		
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $generaljournals->sql.'herere';
		$res=$generaljournals->result;
		$tdebit=0;
		$tcredit=0;
		$tdebitorig=0;
		$tcreditorig=0;
		while($row=mysql_fetch_object($res)){//if($row->accounttypeid==2 or $row->accounttypeid==3) echo $generaljournals->sql;echo '<br/>';echo '<br/>';
		$i++;
		//check what kind of a balance an account should have for trial balance
		$acctypes = new Acctypes();
		$fields="*";
		$where=" where id='$row->acctypeid' ";
		$join="";
		$having="";
		$orderby=" order by name ";
		$groupby ="";
		$acctypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$acctypes=$acctypes->fetchObject;
		
		//check what kind of a balance an account should have for trial balance
		$accountname = new Generaljournalaccounts();
		$fields="*";
		$where=" where id='$row->categoryid' ";
		$join="";
		$having="";
		$orderby=" order by name ";
		$groupby ="";
		$accountname->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$accountname=$accountname->fetchObject;
		
		if(!empty($_GET['acctypeid'])){
		if($obj->currencyid==5){
		  $query="select sum(debit*rate) debit, sum(debitorig*rate) debitorig from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') and case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00 ";
		  }elseif($obj->currencyid==1){
		   $query="select sum(debit*eurorate) debit, sum(debitorig*eurorate) debitorig from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') and case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00 ";
		  }else{
		   $query="select sum(debit) debit, sum(debitorig) debitorig from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') and case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00 ";
		  }
		  $db=mysql_fetch_object(mysql_query($query));
		  
		  $row->debit=$row->debit+$db->debit;
		  $row->debitorig=$row->debitorig+$db->debitorig;
		  
		  if($obj->currencyid==5)
		  {
		  $query="select sum(credit*rate) credit, sum(creditorig*rate) creditorig from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') and where case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00 ";
		  }elseif($obj->currencyid==1){
		   $query="select sum(credit*eurorate) credit, sum(creditorig*eurorate) creditorig from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') and where case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00 ";
		  }else{
		   $query="select sum(credit) credit, sum(creditorig) creditorig from fn_generaljournals where accountid in(select id from fn_generaljournalaccounts where categoryid='$row->id') and where case when sys_acctypes.accounttypeid not in(3,4,5) then fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' else fn_generaljournals.transactdate<='$obj->todate' end and fn_generaljournals.transactdate!='0000-00-00 ";
		  }
		  $db=mysql_fetch_object(mysql_query($query));
		  
		  $row->credit=$row->credit+$db->credit;
		  $row->creditorig=$row->creditorig+$db->creditorig;
		}
		
		if($_GET['tb']){
			
			if (strtolower($acctypes->balance)=='dr'){
				$debit=$row->debit-$row->credit;
				$debitorig=$row->debitorig-$row->creditorig;
				$credit=0;
				$creditorig=0;
			}
			else{
				$credit=$row->credit-$row->debit;
				$creditorig=$row->creditorig-$row->debitorig;
				$debit=0;
				$debitorig=0;
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
		
		if(empty($acctypes->name) and empty($accountname->name) and empty($row->accounttypename))
		{
		//do nothing
		}
		else{
		$tdebit+=$debit;
		$tcredit+=$credit;
		$tdebitorig+=$debitorig;
		$tcreditorig+=$creditorig;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if(!empty($_GET['grp'])){	
			if(!empty($_GET['accounttypeid'])){
			?>
			<td><a href="generaljournals.php?acctypeid=<?php echo $row->acctypeid; ?>&grp=1&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($acctypes->name); ?></a></td>
			<?php }elseif(!empty($_GET['acctypeid'])){?>
			<td><a href="generaljournals.php?acctypeid=<?php echo $row->acctypeid; ?>&categoryid=<?php echo $row->categoryid; ?>&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($accountname->name); ?></a></td>
			<?php }else{?>
			<td><a href="generaljournals.php?accounttypeid=<?php echo $row->accounttypeid; ?>&grp=1&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->accounttypename); ?></a></td>
			<?php }
			
			 }else{
			//check if its a category account
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where categoryid='$row->id' ";
			$join="";
			$having="";
			$orderby="";
			$groupby ="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			if($generaljournalaccounts->affectedRows>0){
			  ?>
			  <td><a href="generaljournals.php?categoryid=<?php echo $row->id; ?>&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->accountid); ?></a><a href="account.php?id=<?php echo $row->id; ?>" target="_blank"><i class="fa fa-edit"></i></a></td>
			  <?
			}else{
			?>
			<td><a href="account.php?id=<?php echo $row->id; ?>&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->accountid); ?></a></td>
			<?php }
			if(!$_GET['tb']){
			?>		
			<td><?php echo $row->currencyid; ?></td>
			<?php
			}
			}
			
			if(empty($_GET['grp'])){?>
			
			<?php }
			
			if($obj->balance){?>
			<td align="right"><?php echo formatNumber($balance); ?></td>
			<?php }else{?>
			<td><?php echo $acctypes->name; ?></td>
<!-- 			<td align="right"><?php echo formatNumber($debitorig); ?></td> -->
<!-- 			<td align="right"><?php echo formatNumber($creditorig); ?></td> -->
			<td align="right"><?php echo formatNumber($debit); ?></td>
			<td align="right"><?php echo formatNumber($credit); ?></td>
<!-- 			<td align="right"><?php echo formatNumber($row->balance); ?></td>		 -->
			<?php }?>	
			<?php
                       //check if its a category account 
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where categoryid='$row->categoryid' ";
			$join="";
			$having="";
			$orderby="";
			$groupby ="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby); //echo $generaljournalaccounts->sql;
			if($generaljournalaccounts->affectedRows>0){
			  ?>
			  <td><a href="#" onclick="Clickheretoprint('<?php echo $row->categoryid;?>','<?php echo $obj->fromdate;?>','<?php echo $obj->todate; ?>');">Print</a>&nbsp;</td>
			  <?php }else{ ?>
			   <td>&nbsp;</td>
			  <?php } ?>
		</tr>
		<?php } ?>
	<?php 
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<?php
		if(!$_GET['tb']){
		?>
		<th>&nbsp;</th>
		<?php }if($obj->balance){?>
		<th></th>
		<?php }else{?>
		<th></th>
<!-- 		<th align="right">&nbsp;</th> -->
<!-- 		<th align="right">&nbsp;</th> -->
		<th align="right"><?php echo formatNumber($tdebit); ?></th>
		<th align="right"><?php echo formatNumber($tcredit); ?></th>
		
		<?php }?>	
		<td>&nbsp;</td>
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
