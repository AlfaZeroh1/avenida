<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktakes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Stocktakes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11153";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$stocktakes=new Stocktakes();
if(!empty($delid)){
	$stocktakes->id=$delid;
	$stocktakes->delete($stocktakes);
	redirect("stocktakes.php");
}
//Authorization.
$auth->roleid="11152";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;
if(empty($obj->action)){
  $obj->fromdate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
  $obj->todate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addstocktakes_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>

<form action="" method="post">
  <table>
    <tr>
      <td>From Date:<input type="text" size="12" class="date_input" readonly name="fromdate" id="fromdate" value="<?php echo $obj->fromdate; ?>"/></td>
      <td>To Date:<input type="text" size="12" class="date_input" readonly name="todate" id="todate" value="<?php echo $obj->todate; ?>"/></td>
      <td><input type="submit" name="action" class="btn btn-primary" value="Filter"/>
    </tr>
  </table>
</form>

<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item Name </th>
			<th>New Value </th>
			<th>Old Value </th>
			<th>Variance </th>
<?php
//Authorization.
$auth->roleid="11154";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11155";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="inv_stocktakes.id, inv_items.name itemid, inv_categorys.id category, inv_categorys.name categoryid, inv_stocktakes.takenon, sum(inv_stocktakes.quantity*inv_stocktakes.costprice) newvalue, sum(fn_generaljournals.debit-fn_generaljournals.credit) oldvalue, inv_stocktakes.total, inv_stocktakes.createdby, inv_stocktakes.createdon, inv_stocktakes.lasteditedon, inv_stocktakes.lasteditedby, inv_stocktakes.ipaddress";
		$join=" left join inv_items on inv_items.id=inv_stocktakes.itemid left join inv_categorys on inv_categorys.id=inv_items.categoryid left join fn_generaljournalaccounts on fn_generaljournalaccounts.refid=inv_categorys.id and fn_generaljournalaccounts.acctypeid=34 left join fn_generaljournals on fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
		$having="";
		$groupby=" group by inv_categorys.id ";
		$orderby="";
		$where=" where inv_stocktakes.takenon>='$obj->fromdate' and inv_stocktakes.takenon<='$obj->todate' ";
		$stocktakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$stocktakes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="stocktakes.php?categoryid=<?php echo $row->category; ?>" target="_blank"><?php echo $row->categoryid; ?></a></td>
			<td><?php echo formatNumber($row->newvalue); ?></td>
			<td><?php echo formatNumber($row->oldvalue); ?></td>
			<td><?php echo formatNumber($row->newvalue-$row->oldvalue); ?></td>
<?php
//Authorization.
$auth->roleid="11154";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addstocktakes_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11155";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='stocktakes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
